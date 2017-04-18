<?php

require 'smsassistent/vendor/autoload.php';

use ByZer0\SmsAssistantBy\Client;
use ByZer0\SmsAssistantBy\Http\GuzzleClient;
use ByZer0\SmsAssistantBy\Exceptions;

class SMSAssistent{

	private $client;
	private $config;

	function __construct($extConfig) {
		$this->config = $extConfig;

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

		$messageText = str_replace(array_keys($findReplace), array_values($findReplace), $template);

		return $messageText;

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

		$messageText = str_replace(array_keys($findReplace), array_values($findReplace), $template);

		return $messageText;

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

	public function nacoCustomerNotification($order_info, $order_product_query, $currency) {

		$phone = $order_info['telephone'];
		$messageText = $this->nacoPrepareMessage($this->config->get('smsassistent_naco_customer_text'), $order_info, $order_product_query, $currency);

		$this->sendMessage($phone, $messageText);

	}

	public function nacoAdminNotification($order_info, $order_product_query, $currency) {

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
		}
	}

	public function narcCustomerNotification($customer) {
		$phone = $customer['telephone'];
		$messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_customer_text'), $customer);

		$this->sendMessage($phone, $messageText);
	}

	public function narcAdminNotification($customer) {

		$phones = explode(';', $this->config->get('smsassistent_narc_admin_phones'));

		if (count($phones) > 0) {
			$messageText = $this->narcPrepareMessage($this->config->get('smsassistent_narc_admin_text'), $customer);

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
		}
	}
}