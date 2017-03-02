<?php

require 'smsassistent/vendor/autoload.php';

use ByZer0\SmsAssistantBy\Client;
use ByZer0\SmsAssistantBy\Http\GuzzleClient;

class SMSAssistent{

	private $client;
	private $config;

	function __construct($extConfig) {
		$this->config = $extConfig;

		$this->client = new Client(new GuzzleClient());
		$this->client->setUsername($this->config->get('smsassistent_api_username'));

		$api_token = $this->config->get('smsassistent_api_token');
		$api_password = $this->config->get('smsassistent_api_password');
		$sender_name = $this->config->get('smsassistent_sender_name');

		if ($api_token !== '')
		{
			$this->client->setToken($api_token);
		} else if ($api_password !== '')
		{
			$this->client->setPassword($api_password);
		}

		if ($sender_name !== '')
		{
			$this->client->setSender($this->config->get('smsassistent_sender_name'));
		}

	}

	private function prepareMessage($template, $order_info, $order_product_query) {

		$find = array(
			'{store_name}',
			'{store_url}',
			'{order_id}',
			'{date_added}',
			'{payment_method}',
			'{payment_code}',
			'{email}',
			'{telephone}',
			'{firstname}',
			'{lastname}',
			'{total}',
			'{products_ids}',
			'{products_names}',
			'{products_names_prices}'
		);

		$products_ids = '';
		$products_names = '';
		$products_names_prices = '';
		foreach ($order_product_query->rows as $product) {
			$products_ids .= $product['product_id'] . ',';
			$products_names .= $product['name'] . ' ' . $product['model'] . ',';
			$products_names_prices .= $product['name'] . ' ' . $product['model'] . '(' . $product['total'] . ')' . ',';
		}
		$products_ids = substr($products_ids, 0, -1);
		$products_names = substr($products_names, 0, -1);
		$products_names_prices = substr($products_names_prices, 0, -1);

		$replace = array(
			'store_name'	=> $order_info['store_name'],
			'store_url'		=> $order_info['store_url'],
			'order_id'		=> $order_info['order_id'],
			'date_added'	=> $order_info['date_added'],
			'payment_method'	=> $order_info['payment_method'],
			'payment_code'		=> $order_info['payment_code'],
			'email'		=> $order_info['email'],
			'telephone'	=> $order_info['telephone'],
			'firstname'	=> $order_info['firstname'],
			'lastname'	=> $order_info['lastname'],
			'total'		=> $order_info['total'],
			'products_ids'			=> $products_ids,
			'products_names'		=> $products_names,
			'products_names_prices'	=> $products_names_prices
		);

		$messageText = str_replace($find, $replace, $template);

		return $messageText;

	}

	public function sendCustomerNotification($order_info, $order_product_query) {

		$phone = $order_info['telephone'];
		$messageText = $this->prepareMessage($this->config->get('smsassistent_customer_order_create_text'), $order_info, $order_product_query);

		$this->client->sendMessage($phone, $messageText);

	}

	public function sendAdminNotification($order_info, $order_product_query) {

		$phones = explode(';', $this->config->get('smsassistent_admin_order_create_phones'));

		if (count($phones) > 0) {

			$messageText = $this->prepareMessage($this->config->get('smsassistent_admin_order_create_text'), $order_info, $order_product_query);
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
	}

}