<?php

require DIR_SYSTEM . 'library/smsassistent/sms_assistent.lib.php';

use SmsAssistentBy\Lib as ass_lib;

class SMSAssistent {

    private $db;
    private $client;
    private $config;
    private $logger;

    function __construct($extConfig, $db) {
        $this->config = $extConfig;
        $this->db = $db;

        $api_username = $this->config->get('smsassistent_ms_api_username');
        $api_token = $this->config->get('smsassistent_ms_api_token');
        $api_password = $this->config->get('smsassistent_ms_api_password');

        $this->client = new ass_lib\sms_assistent($api_username, $api_password, $api_token);

        $default_sender_name_sms = $this->config->get('smsassistent_ms_sender_name_sms');
        $default_sender_name_viber = $this->config->get('smsassistent_ms_sender_name_viber');
        $this->client->setSenderSMS($default_sender_name_sms)->setSenderViber($default_sender_name_viber);

        $base_url = $this->config->get('smsassistent_ms_base_url');
        if ($base_url != '') {
            $this->client->setUrl($base_url);
        }

        $this->logger = new \Log('smsassistent.log');
        $this->logger->write("SMSAssistent client created");
    }

    private function nacoPrepareMessage($template, $order_info, $order_product_query, $currency) {

        $products_ids = '';
        $products_names = '';
        $products_names_prices = '';
        foreach ($order_product_query->rows as $product) {
            $products_ids .= $product['product_id'] . ',';
            $products_names .= $product['name'] . ' ' . $product['model'] . ',';
            $products_names_prices .= $product['name'] . ' ' . $product['model'] . '(' . $currency->format($product['total'], $order_info['currency_code'], $order_info['currency_value']) . ')' . ',';
        }
        $products_ids = substr($products_ids, 0, -1);
        $products_names = substr($products_names, 0, -1);
        $products_names_prices = substr($products_names_prices, 0, -1);

        $findReplace = array(
            '{store_name}' => $order_info['store_name'],
            '{store_url}' => $order_info['store_url'],
            '{order_id}' => $order_info['order_id'],
            '{date_added}' => $order_info['date_added'],
            '{payment_method}' => $order_info['payment_method'],
            '{payment_code}' => $order_info['payment_code'],
            '{email}' => $order_info['email'],
            '{telephone}' => $order_info['telephone'],
            '{firstname}' => $order_info['firstname'],
            '{lastname}' => $order_info['lastname'],
            '{comment}' => $order_info['comment'],
            '{history_comment}' => $order_info['history_comment'],
            '{total}' => $currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']),
            '{products_ids}' => $products_ids,
            '{products_names}' => $products_names,
            '{products_names_prices}' => $products_names_prices
        );

        return str_replace(array_keys($findReplace), array_values($findReplace), $template);
    }

    private function narcPrepareMessage($template, $customer) {

        $findReplace = array(
            '{firstname}' => $customer['firstname'],
            '{lastname}' => $customer['lastname'],
            '{email}' => $customer['email'],
            '{telephone}' => $customer['telephone'],
            '{fax}' => $customer['fax'],
            '{store_name}' => $this->config->get('config_name'),
            '{store_address}' => $this->config->get('config_address'),
            '{store_email}' => $this->config->get('config_email'),
            '{store_phone}' => $this->config->get('config_telephone')
        );

        return str_replace(array_keys($findReplace), array_values($findReplace), $template);
    }

    private function sendMessageSMS($phones, $messageText) {
        if (count($phones) > 0) {

            $result = $this->client->sendSms($phones, $messageText);
            $this->writeErrorSendLogSMS($result);
            if($result['result'][0]['sms_code'] > 0)
                return true;
            else return false;

        }
    }

    private function sendMessageViber($phones, $messageText, $promo, $elseSMS) {
        if (count($phones) > 0) {
            $result = $this->client->sendViber($phones, $messageText, 48, false , $promo, $elseSMS);
            $this->writeErrorSendLogViber($result);

            if($result['result'][0]['message_code'] > 0)
                return true;
            else return false;
        }
    }

    private function getPromo($mod, $rec, $id){
        if($this->config->get("smsassistent_{$mod}_{$rec}_promo_{$id}") == 0)
            return array();
        $image = $this->config->get("smsassistent_{$mod}_{$rec}_viber_image_{$id}");
        $button = $this->config->get("smsassistent_{$mod}_{$rec}_viber_button_text_{$id}");
        $url = $this->config->get("smsassistent_{$mod}_{$rec}_viber_button_url_{$id}");
        if($image != '' && $button != '' && $url != '')
            return array(
                'viber_image' => $image,
                'viber_button' => $button,
                'viber_url' => $url
            );
        else return array();
    }

    private function getElseSMS($mod, $rec, $id){
        $active = $this->config->get("smsassistent_{$mod}_{$rec}_else_sms_{$id}");
        if($active == 0)
            return array();
        $sender = $this->config->get("smsassistent_{$mod}_{$rec}_sender_else_sms_{$id}");
        if($sender == '')
            $sender = $this->config->get("smsassistent_ms_sender_name_sms");
        $text = $this->config->get("smsassistent_{$mod}_{$rec}_text_else_sms_{$id}");
        return array(
            'sms_sender' => $sender,
            'sms_text' => $text
        );
    }

    /**
     * @param $type         string      Type of notification
     * @param $relatedId    integer     Related identifier
     * @param $additionalRelatedId    integer|null     Related identifier
     * @param $notificate   string      Who notificate
     *
     * @return bool
     */
    private function checkSendedLog($type, $relatedId, $additionalRelatedId, $notificate) {
        $query = "SELECT `id` FROM `" . DB_PREFIX . "smsassistent_send_log` WHERE `type` = '$type' AND `related_id` = $relatedId AND `notificate` = '$notificate'";
        if ($additionalRelatedId) {
            $query .= " AND `additional_related_id` = $additionalRelatedId";
        }
        $query = $this->db->query($query);
        $this->logger->write("Check if sended message earlier (type=$type, relatedId=$relatedId, additionalRelatedId=$additionalRelatedId, notificate=$notificate) - " . $query->num_rows);
        return ($query->num_rows > 0);
    }


    /**
     * @param $type         string      Type of notification
     * @param $relatedId    integer     Related identifier
     * @param $additionalRelatedId    integer|null     Related identifier
     * @param $notificate   string      Who notificate
     */
    private function addSendedLog($type, $relatedId, $additionalRelatedId, $notificate) {
        $this->db->query("INSERT INTO `" . DB_PREFIX . "smsassistent_send_log` (`type`, `related_id`, `additional_related_id`, `notificate`, `created_at`) VALUES ('$type', $relatedId, " . ($additionalRelatedId ? $additionalRelatedId : 'NULL') . ", '$notificate', NOW())");
    }

    private function writeErrorSendLogSMS($res){
        if($res['error'] > 0){
            foreach ($res['error_messages'] as $err)
                $this->logger->write("Error: $err");
        }
        else{
            if($res['result'][0]['sms_error'] == 0)
                $this->logger->write("Message sent. Method: ".$res['type'] );
            else
                $this->logger->write("Error: ".$res['result'][0]['sms_error_msg']);
        }
    }

    private function writeErrorSendLogViber($res){
        if($res['error'] > 0){
            foreach ($res['error_messages'] as $err)
                $this->logger->write("Error: $err");
        }
        else{
            if($res['result'][0]['message_error'] == 0)
                $this->logger->write("Message sent. Method: ".$res['type'] );
            else
                $this->logger->write("Error: ".$res['result'][0]['message_error_msg']);
        }
    }

    private function writeOrderLog($order, $newStatus){

        $this->logger->write("Order info: order=".$order['order_id'].", new status=".$newStatus);
    }

    private function writeMessageLog($mod, $rec, $messenger, $sender, $phones, $message){

        if($mod == "naco")
            $this->logger->write("--- ".$messenger." notification of order status change ---");
        elseif ($mod == "narc")
            $this->logger->write("--- ".$messenger." notification of adding a new user ---");
        if(is_array($phones))
            $phones = implode(", ", $phones);
        $this->logger->write("Sender: ".$sender.", recipient: ".$rec."(".$phones.")");
        $this->logger->write("Message: ".$message);

    }

    private function writeNewUserLog($user){

        $this->logger->write("New user #".$user['customer_id'].": name: ".$user['firstname']." ".$user['lastname']."; phone: ".$user['telephone']);
    }

    public function nacoCustomerNotification($order_info, $order_status_id, $order_product_query, $currency) {

        if ($this->checkSendedLog('order', $order_info['order_id'], $order_status_id, 'customer')) {
            return;
        }

        $phone[] = $order_info['telephone'];
        $messenger = $this->config->get("smsassistent_naco_customer_status_$order_status_id");
        $messageText = $this->nacoPrepareMessage($this->config->get("smsassistent_naco_customer_text_".$messenger."_".$order_status_id), $order_info, $order_product_query, $currency);

        $sender = $this->config->get("smsassistent_naco_customer_sender_".$messenger."_".$order_status_id);

        if($messenger == "sms"){
            if($sender != '')
                $this->client->setSenderSMS($sender);
            $this->writeMessageLog("naco", "customer", $messenger, $this->client->getSenderSMS(), $phone, $messageText);
            $this->writeOrderLog($order_info, $order_status_id);
            $this->sendMessageSMS($phone, $messageText);
        }
        if($messenger == "viber") {
            if($sender != '')
                $this->client->setSenderViber($sender);
            $promo = $this->getPromo("naco", "customer", $order_status_id);
            $elseSMS = $this->getElseSMS("naco", "customer", $order_status_id);
            if(count($elseSMS) > 0 && $elseSMS['sms_text'] != '')
                $elseSMS['sms_text'] = $this->nacoPrepareMessage($elseSMS['sms_text'], $order_info, $order_product_query, $currency);
            $this->writeMessageLog("naco", "customer", $messenger, $this->client->getSenderViber(), $phone, $messageText);
            $this->writeOrderLog($order_info, $order_status_id);
            $this->sendMessageViber($phone, $messageText, $promo, $elseSMS);
        }

        $this->addSendedLog('order', $order_info['order_id'], $order_status_id, 'customer');
    }

    public function nacoAdminNotification($order_info, $order_status_id, $order_product_query, $currency) {

        if ($this->checkSendedLog('order', $order_info['order_id'], $order_status_id, 'admin')) {
            return;
        }

        $messenger = $this->config->get("smsassistent_naco_admin_status_$order_status_id");
        $phones = explode(';', $this->config->get("smsassistent_naco_admin_phones_".$messenger."_".$order_status_id));
        $messageText = $this->nacoPrepareMessage($this->config->get("smsassistent_naco_admin_text_".$messenger."_".$order_status_id), $order_info, $order_product_query, $currency);

        $sender = $this->config->get("smsassistent_naco_admin_sender_".$messenger."_".$order_status_id);

        if($messenger == "sms"){
            if($sender != '')
                $this->client->setSenderSMS($sender);
            $this->writeMessageLog("naco", "admin", $messenger, $this->client->getSenderSMS(), $phones, $messageText);
            $this->writeOrderLog($order_info, $order_status_id);
            $this->sendMessageSMS($phones, $messageText);
        }
        if($messenger == "viber") {
            if($sender != '')
                $this->client->setSenderViber($sender);
            $promo = $this->getPromo("naco", "admin", $order_status_id);
            $elseSMS = $this->getElseSMS("naco", "admin", $order_status_id);
            if(count($elseSMS) > 0 && $elseSMS['sms_text'] != '')
                $elseSMS['sms_text'] = $this->nacoPrepareMessage($elseSMS['sms_text'], $order_info, $order_product_query, $currency);
            $this->writeMessageLog("naco", "admin", $messenger, $this->client->getSenderViber(), $phones, $messageText);
            $this->writeOrderLog($order_info, $order_status_id);
            $this->sendMessageViber($phones, $messageText, $promo, $elseSMS);
        }

        $this->addSendedLog('order', $order_info['order_id'], $order_status_id, 'customer');

    }

    public function narcCustomerNotification($customer) {

        if ($this->checkSendedLog('customer', $customer['customer_id'], null, 'customer')) {
            return;
        }

        $messenger = $this->config->get("smsassistent_narc_customer_status_0");
        $phone[] = $customer['telephone'];
        $messageText = $this->narcPrepareMessage($this->config->get("smsassistent_narc_customer_text_".$messenger."_0"), $customer);

        $sender = $this->config->get("smsassistent_narc_customer_sender_".$messenger."_0");

        if($messenger == "sms"){
            if($sender != '')
                $this->client->setSenderSMS($sender);
            $this->writeMessageLog("narc", "customer", $messenger, $this->client->getSenderSMS(), $phone, $messageText);
            $this->writeNewUserLog($customer);
            $this->sendMessageSMS($phone, $messageText);
        }
        if($messenger == "viber") {
            if($sender != '')
                $this->client->setSenderViber($sender);
            $promo = $this->getPromo("narc", "customer", 0);
            $elseSMS = $this->getElseSMS("narc", "customer", 0);
            if(count($elseSMS) > 0 && $elseSMS['sms_text'] != '')
                $elseSMS['sms_text'] = $this->narcPrepareMessage($elseSMS['sms_text'], $customer);
            $this->writeMessageLog("narc", "customer", $messenger, $this->client->getSenderViber(), $phone, $messageText);
            $this->sendMessageViber($phone, $messageText, $promo, $elseSMS);

        }

        $this->addSendedLog('customer', $customer['customer_id'], null, 'customer');
    }

    public function narcAdminNotification($customer) {

        if ($this->checkSendedLog('customer', $customer['customer_id'], null, 'admin')) {
            return;
        }

        $messenger = $this->config->get("smsassistent_narc_admin_status_0");
        $phones = explode(';', $this->config->get("smsassistent_narc_admin_phones_".$messenger."_0"));
        $messageText = $this->narcPrepareMessage($this->config->get("smsassistent_narc_admin_text_".$messenger."_0"), $customer);

        $sender = $this->config->get("smsassistent_narc_admin_sender_".$messenger."_0");

        if($messenger == "sms"){
            if($sender != '')
                $this->client->setSenderSMS($sender);
            $this->writeMessageLog("narc", "admin", $messenger, $this->client->getSenderSMS(), $phones, $messageText);
            $this->writeNewUserLog($customer);
            $this->sendMessageSMS($phones, $messageText);
        }
        if($messenger == "viber") {
            if($sender != '')
                $this->client->setSenderViber($sender);
            $promo = $this->getPromo("narc", "admin", 0);
            $elseSMS = $this->getElseSMS("narc", "admin", 0);
            if(count($elseSMS) > 0 && $elseSMS['sms_text'] != '')
                $elseSMS['sms_text'] = $this->narcPrepareMessage($elseSMS['sms_text'], $customer);
            $this->writeMessageLog("narc", "admin", $messenger, $this->client->getSenderViber(), $phones, $messageText);
            $this->sendMessageViber($phones, $messageText, $promo, $elseSMS);
        }

        $this->addSendedLog('customer', $customer['customer_id'], null, 'customer');
    }
}