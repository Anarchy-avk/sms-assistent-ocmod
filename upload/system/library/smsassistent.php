<?php

require DIR_SYSTEM . 'library/smsassistent/vendor/autoload.php';

use GuzzleHttp\Client as GuzzleHttpClient;
use ByZer0\SmsAssistantBy\Client;
use ByZer0\SmsAssistantBy\Http\GuzzleClient;
use ByZer0\SmsAssistantBy\Exceptions;

class SMSAssistent {

    private $db;
    private $client;
    private $config;
    private $logger;

    function __construct($extConfig, $db) {
        $this->config = $extConfig;
        $this->db = $db;

        if (file_exists(__DIR__ . '/smsassistent/cacert.pem')) {
            $client = new GuzzleHttpClient(['verify' => __DIR__ . '/smsassistent/cacert.pem']);
        } else {
            $client = null;
        }

        $this->client = new Client(new GuzzleClient($client));
        $this->client->setUsername($this->config->get('smsassistent_ms_api_username'));

        $api_token = $this->config->get('smsassistent_ms_api_token');
        $api_password = $this->config->get('smsassistent_ms_api_password');
        $sender_name = $this->config->get('smsassistent_ms_sender_name');

        if ($api_token != '') {
            $this->client->setToken($api_token);
        } else if ($api_password !== '') {
            $this->client->setPassword($api_password);
        }

        if ($sender_name != '') {
            $this->client->setSender($this->config->get('smsassistent_ms_sender_name'));
        }

        $base_url = $this->config->get('smsassistent_ms_base_url');
        if ($base_url != '') {
            $this->client->setBaseUrl($base_url);
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

    private function sendMessage($phones, $messageText) {
        if (count($phones) > 0) {
            try {
                if (count($phones) === 1) {
                    $this->client->sendMessage($phones[0], $messageText);
                } else {
                    $default = [
                        'text' => $messageText
                    ];

                    $messages = [];
                    foreach ($phones as $phone) {
                        $messages[] = [
                            'phone' => $phone
                        ];
                    }
                    $this->client->sendMessages($messages, $default);
                }
            } catch (Exceptions\LowBalanceException $e) {
                $this->logger->write("Catch exception: LowBalanceException (Code: -1)\n" . $e->getTraceAsString());
            } catch (Exceptions\AuthentificationException $e) {
                $this->logger->write("Catch exception: AuthentificationException (Codes: -2, -6, -7)\n" . $e->getTraceAsString());
            } catch (Exceptions\MessageTextException $e) {
                $this->logger->write("Catch exception: MessageTextException (Code: -3)\n" . $e->getTraceAsString());
            } catch (Exceptions\PhoneNumberException $e) {
                $this->logger->write("Catch exception: PhoneNumberException (Code: -4)\n" . $e->getTraceAsString());
            } catch (Exceptions\SenderNameException $e) {
                $this->logger->write("Catch exception: SenderNameException (Code: -5)\n" . $e->getTraceAsString());
            } catch (Exceptions\ServerException $e) {
                $this->logger->write("Catch exception: ServerException (Code: -10, -12, -13)\n" . $e->getTraceAsString());
            } catch (Exceptions\MessageIdException $e) {
                $this->logger->write("Catch exception: MessageIdException (Code: -11)\n" . $e->getTraceAsString());
            } catch (Exceptions\SendTimeException $e) {
                $this->logger->write("Catch exception: SendTimeException (Code: -14, -15)\n" . $e->getTraceAsString());
            } catch (Exception $e) {
                $this->logger->write("Unknown exception: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            }
        }
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

    public function nacoCustomerNotification($order_info, $order_status_id, $order_product_query, $currency) {

        if ($this->checkSendedLog('order', $order_info['order_id'], $order_status_id, 'customer')) {
            return;
        }

        $phones[] = $order_info['telephone'];
        $messageText = $this->nacoPrepareMessage($this->config->get("smsassistent_naco_customer_text_$order_status_id"), $order_info, $order_product_query, $currency);

        $this->sendMessage($phones, $messageText);

        $this->addSendedLog('order', $order_info['order_id'], $order_status_id, 'customer');
    }

    public function nacoAdminNotification($order_info, $order_status_id, $order_product_query, $currency) {

        if ($this->checkSendedLog('order', $order_info['order_id'], $order_status_id, 'admin')) {
            return;
        }

        $phones = explode(';', $this->config->get("smsassistent_naco_admin_phones_$order_status_id"));
        $messageText = $this->nacoPrepareMessage($this->config->get("smsassistent_naco_admin_text_$order_status_id"), $order_info, $order_product_query, $currency);

        if (count($phones) > 0) {
            $this->sendMessage($phones, $messageText);

            $this->addSendedLog('order', $order_info['order_id'], $order_status_id, 'admin');
        }
    }

    public function narcCustomerNotification($customer) {

        if ($this->checkSendedLog('customer', $customer['customer_id'], null, 'customer')) {
            return;
        }

        $phones[] = $customer['telephone'];
        $messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_customer_text'), $customer);

        $this->sendMessage($phones, $messageText);

        $this->addSendedLog('customer', $customer['customer_id'], null, 'customer');
    }

    public function narcAdminNotification($customer) {

        if ($this->checkSendedLog('customer', $customer['customer_id'], null, 'admin')) {
            return;
        }

        $phones = explode(';', $this->config->get('smsassistent_narc_admin_phones'));
        $messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_admin_text'), $customer);

        if (count($phones) > 0) {
            $this->sendMessage($phones, $messageText);

            $this->addSendedLog('customer', $customer['customer_id'], null, 'admin');
        }
    }
}