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

	public function sendCustomerNotification($phone) {

		$this->client->sendMessage($phone, $this->config->get('smsassistent_customer_order_create_text'));

	}

	public function sendAdminNotification() {

		$phones = explode(';', $this->config->get('smsassistent_admin_order_create_phones'));

		if (count($phones) > 0) {
			$default = [
				'text' => $this->config->get('smsassistent_admin_order_create_text')
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