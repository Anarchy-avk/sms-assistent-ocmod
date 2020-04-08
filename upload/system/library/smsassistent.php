<?php

require DIR_SYSTEM . 'library/smsassistent/vendor/autoload.php';

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

        $this->client = new Client(new GuzzleClient());
        $this->client->setUsername($this->config->get('smsassistent_ms_api_username'));

        $api_token = $this->config->get('smsassistent_ms_api_token');
        $api_password = $this->config->get('smsassistent_ms_api_password');
        $sender_name = $this->config->get('smsassistent_ms_sender_name');

        if ($api_token !== '')
        {
            $this->client->setToken($api_token);
        } else if ($api_password !== '')
        {
            $this->client->setPassword($api_password);
        }

        if ($sender_name !== '')
        {
            $this->client->setSender($this->config->get('smsassistent_ms_sender_name'));
        }

        $this->logger = new \Log('smsassistent.log');
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
            '{store_name}'				=> $order_info['store_name'],
            '{store_url}'				=> $order_info['store_url'],
            '{order_id}'				=> $order_info['order_id'],
            '{date_added}'				=> $order_info['date_added'],
            '{payment_method}'			=> $order_info['payment_method'],
            '{payment_code}'			=> $order_info['payment_code'],
            '{email}'					=> $order_info['email'],
            '{telephone}'				=> $order_info['telephone'],
            '{firstname}'				=> $order_info['firstname'],
            '{lastname}'				=> $order_info['lastname'],
            '{total}'					=> $currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']),
            '{products_ids}'			=> $products_ids,
            '{products_names}'			=> $products_names,
            '{products_names_prices}'	=> $products_names_prices
        );

        return str_replace(array_keys($findReplace), array_values($findReplace), $template);
    }

    private function narcPrepareMessage($template, $customer) {

        $findReplace = array(
            '{firstname}'	=> $customer['firstname'],
            '{lastname}'	=> $customer['lastname'],
            '{email}'		=> $customer['email'],
            '{telephone}'	=> $customer['telephone'],
            '{fax}'			=> $customer['fax'],
            '{company}'		=> $customer['company'],
            '{address_1}'	=> $customer['address_1'],
            '{address_2}'	=> $customer['address_2'],
            '{city}'		=> $customer['city'],
            '{postcode}'	=> $customer['postcode'],
            '{store_name}'	=> $this->config->get('config_name'),
            '{store_address}'	=> $this->config->get('config_address'),
            '{store_email}'		=> $this->config->get('config_email'),
            '{store_phone}'		=> $this->config->get('config_telephone')
        );

        return str_replace(array_keys($findReplace), array_values($findReplace), $template);
    }

    private function sendMessage($phone, $messageText) {
        try {
            $this->client->sendMessage($phone, $messageText);
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
        }
    }

    private function sendMessages ($messages, $default) {
        try {
            $this->client->sendMessages($messages, $default);
        } catch (Exceptions\LowBalanceException $e) {
            $this->logger->write("Catch exception: LowBalanceException (Code: -1)\n" . $e->getTraceAsString());
        } catch (Exceptions\AuthentificationException $e) {
            $this->logger->write("Catch exception: AuthentificationException (Code: -2, -6, -7)\n" . $e->getTraceAsString());
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
        }
    }

    /**
     * @param $type         string      Type of notification
     * @param $relatedId    integer     Related identifier
     * @param $notificate   string      Who notificate
     *
     * @return bool
     */
    private function checkSendedLog($type, $relatedId, $notificate) {
        $query = $this->db->query("SELECT `id` FROM `" . DB_PREFIX . "smsassistent_send_log` WHERE `type` = '$type' AND `related_id` = $relatedId AND `notificate` = '$notificate'");

        return ($query->num_rows > 0);
    }

    /**
     * @param $type         string      Type of notification
     * @param $relatedId    integer     Related identifier
     * @param $notificate   string      Who notificate
     */
    private function addSendedLog($type, $relatedId, $notificate) {
        $query = $this->db->query("INSERT INTO `" . DB_PREFIX . "smsassistent_send_log` (`type`, `related_id`, `notificate`, `created_at`) VALUES ('$type', $relatedId, '$notificate', NOW())");
    }

    public function nacoCustomerNotification($order_info, $order_product_query, $currency) {

        if ($this->checkSendedLog('new_order', $order_info['order_id'], 'customer')) {
            return;
        }

        $phone = $order_info['telephone'];
        $messageText = $this->nacoPrepareMessage($this->config->get('smsassistent_naco_customer_text'), $order_info, $order_product_query, $currency);

        $this->sendMessage($phone, $messageText);

        $this->addSendedLog('new_order', $order_info['order_id'], 'customer');
    }

    public function nacoAdminNotification($order_info, $order_product_query, $currency) {

        if ($this->checkSendedLog('new_order', $order_info['order_id'], 'admin')) {
            return;
        }

        $phones = explode(';', $this->config->get('smsassistent_naco_admin_phones'));

        if (count($phones) > 0) {
            $messageText = $this->nacoPrepareMessage($this->config->get('smsassistent_naco_admin_text'), $order_info, $order_product_query, $currency);

            if (count($phones) === 1) {
                $this->sendMessage($phones[0], $messageText);
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
                $this->sendMessages($messages, $default);
            }
            $this->addSendedLog('new_order', $order_info['order_id'], 'admin');
        }
    }

    public function narcCustomerNotification($customerId, $customerData) {

        if ($this->checkSendedLog('new_customer', $customerId, 'customer')) {
            return;
        }

        $phone = $customerData['telephone'];
        $messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_customer_text'), $customerData);

        $this->sendMessage($phone, $messageText);

        $this->addSendedLog('new_customer', $customerId, 'customer');
    }

    public function narcAdminNotification($customerId, $customerData) {

        if ($this->checkSendedLog('new_customer', $customerId, 'admin')) {
            return;
        }

        $phones = explode(';', $this->config->get('smsassistent_narc_admin_phones'));

        if (count($phones) > 0) {
            $messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_admin_text'), $customerData);

            if (count($phones) === 1) {
                $this->sendMessage($phones[0], $messageText);
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
                $this->sendMessages($messages, $default);
            }
            $this->addSendedLog('new_customer', $customerId, 'admin');
        }
    }
}