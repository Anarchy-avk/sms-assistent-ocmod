<?php
class ControllerExtensionModuleSMSAssistent extends Controller {
	private $error = array();

	private function loadData(&$data, $data_name) {
		if (isset($this->request->post[$data_name])) {
			$data[$data_name] = $this->request->post[$data_name];
		} else {
			$data[$data_name] = $this->config->get($data_name);
		}
	}

	public function index() {
		$this->load->language('extension/module/smsassistent');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('smsassistent', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'));
		}

		// Heading
		$data['heading_title'] = $this->language->get('heading_title');		
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		// Main settings (ms)
		$data['pane_ms'] = $this->language->get('pane_ms');
		$data['text_ms_general'] = $this->language->get('text_ms_general');
		$data['entry_ms_status'] = $this->language->get('entry_ms_status');
		$data['entry_ms_api_username'] = $this->language->get('entry_ms_api_username');
		$data['entry_ms_api_token'] = $this->language->get('entry_ms_api_token');
		$data['entry_ms_api_password'] = $this->language->get('entry_ms_api_password');
		$data['entry_ms_sender_name'] = $this->language->get('entry_ms_sender_name');

		// Notifications after create order (naco)
		$data['pane_naco'] = $this->language->get('pane_naco');
		$data['text_naco_customer'] = $this->language->get('text_naco_customer');
		$data['entry_naco_customer_status'] = $this->language->get('entry_naco_customer_status');
		$data['entry_naco_customer_text'] = $this->language->get('entry_naco_customer_text');
		$data['text_naco_admin'] = $this->language->get('text_naco_admin');
		$data['entry_naco_admin_status'] = $this->language->get('entry_naco_admin_status');
		$data['entry_naco_admin_phones'] = $this->language->get('entry_naco_admin_phones');
		$data['help_naco_admin_phones'] = $this->language->get('help_naco_admin_phones');
		$data['entry_naco_admin_text'] = $this->language->get('entry_naco_admin_text');
		$data['pane_naco_sms_text'] = $this->language->get('pane_naco_sms_text');
		$data['pane_naco_sms_template'] = $this->language->get('pane_naco_sms_template');
		$data['pane_naco_sms_template_text'] = $this->language->get('pane_naco_sms_template_text');

		// Logs (logs)
		$data['pane_logs'] = $this->language->get('pane_logs');
		$data['text_logs'] = $this->language->get('text_logs');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/smsassistent', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('extension/module/smsassistent', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL');

		$this->loadData($data, 'smsassistent_status');
		$this->loadData($data, 'smsassistent_api_username');
		$this->loadData($data, 'smsassistent_api_token');
		$this->loadData($data, 'smsassistent_api_password');
		$this->loadData($data, 'smsassistent_sender_name');
		$this->loadData($data, 'smsassistent_customer_order_create_status');
		$this->loadData($data, 'smsassistent_customer_order_create_text');
		$this->loadData($data, 'smsassistent_admin_order_create_status');
		$this->loadData($data, 'smsassistent_admin_order_create_phones');
		$this->loadData($data, 'smsassistent_admin_order_create_text');

		$data['smsassistent_log'] = '';
		$file = DIR_LOGS . 'smsassistent.log';
		if (file_exists($file)) {
			$data['smsassistent_log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/smsassistent.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/smsassistent')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}