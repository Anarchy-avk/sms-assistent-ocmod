<?php

class ControllerExtensionModuleSMSAssistent extends Controller {
    private $error = array();

    public function install() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "smsassistent_send_log`");
        $this->db->query("
            CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "smsassistent_send_log` (
                `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                `type` ENUM('order','customer') NOT NULL DEFAULT 'order',
                `related_id` INT(11) NOT NULL,
                `additional_related_id` INT(11),
                `notificate` ENUM('admin','customer') NOT NULL DEFAULT 'admin',
                `created_at` DATETIME NOT NULL,
                PRIMARY KEY (`id`),
                KEY `related_id` (`related_id`)
            )
        ");

        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('module_smsassistent', ['module_smsassistent_status' => 1]);
    }

    public function uninstall() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->deleteSetting('smsassistent');
        $this->model_setting_setting->deleteSetting('module_smsassistent');

        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "smsassistent_send_log`");
    }

    private function loadData(&$data, $data_name) {
        if (isset($this->request->post[$data_name])) {
            $data[$data_name] = $this->request->post[$data_name];
        } else {
            $data[$data_name] = $this->config->get($data_name);
        }
    }

    private function addCheckboxStatuses($post) {
        $this->load->model('localisation/order_status');
        $order_statuses = $this->model_localisation_order_status->getOrderStatuses();
        foreach ($order_statuses as $order_status) {
            $i = $order_status['order_status_id'];
            $post = $this->addCheckboxStatus($post, 'naco', 'customer', 'promo', $i);
            $post = $this->addCheckboxStatus($post, 'naco', 'customer', 'else_sms', $i);
            $post = $this->addCheckboxStatus($post, 'naco', 'admin', 'promo', $i);
            $post = $this->addCheckboxStatus($post, 'naco', 'admin', 'else_sms', $i);
        }
        $post = $this->addCheckboxStatus($post, 'narc', 'customer', 'promo', 0);
        $post = $this->addCheckboxStatus($post, 'narc', 'customer', 'else_sms', 0);
        $post = $this->addCheckboxStatus($post, 'narc', 'admin', 'promo', 0);
        $post = $this->addCheckboxStatus($post, 'narc', 'admin', 'else_sms', 0);
        return $post;
    }

    private function addCheckboxStatus($data, $mod, $rec, $check, $id) {
        $field = implode('_', array('smsassistent', $mod, $rec, $check, $id));
        if(!isset($data[$field]))
            $data[$field] = 0;
        return $data;
    }


    public function index() {
        $this->load->language('extension/module/smsassistent');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $data = $this->addCheckboxStatuses($this->request->post);
            $this->model_setting_setting->editSetting('smsassistent', $data);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL'));
        }

        // Notifications after change order status (naco)
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/module/smsassistent', 'user_token=' . $this->session->data['user_token'], 'SSL')
        );

        $data['action'] = $this->url->link('extension/module/smsassistent', 'user_token=' . $this->session->data['user_token'], 'SSL');

        $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', 'SSL');

        $this->loadData($data, 'smsassistent_ms_status');
        $this->loadData($data, 'smsassistent_ms_api_username');
        $this->loadData($data, 'smsassistent_ms_api_token');
        $this->loadData($data, 'smsassistent_ms_api_password');
        $this->loadData($data, 'smsassistent_ms_sender_name_sms');
        $this->loadData($data, 'smsassistent_ms_sender_name_viber');
        $this->loadData($data, 'smsassistent_ms_base_url');

        foreach ($this->model_localisation_order_status->getOrderStatuses() as $order_status) {
            $data = $this->loadDataForm($data, 'naco', 'customer', $order_status['order_status_id']);
            $data = $this->loadDataForm($data, 'naco', 'admin', $order_status['order_status_id']);
            $this->loadData($data, 'smsassistent_naco_admin_phones_sms_' . $order_status['order_status_id']);
        }

        $data = $this->loadDataForm($data, 'narc', 'customer', '0');
        $data = $this->loadDataForm($data, 'narc', 'admin', '0');

        $data['smsassistent_log'] = '';

        $file = DIR_LOGS . 'smsassistent.log';
        if (file_exists($file)) {
            $data['smsassistent_log'] .= file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/smsassistent', $data));
    }

    private function loadDataForm($data, $mod, $rec, $id){
        $name = 'smsassistent_' . $mod . '_' . $rec . '_';
        $field = array('status_', 'phones_sms_', 'sender_sms_', 'text_sms_', 'sender_viber_', 'phones_viber_', 'text_viber_', 'promo_', 'viber_image_', 'viber_button_text_', 'viber_button_url_', 'else_sms_', 'sender_else_sms_', 'text_else_sms_');
        foreach ($field as $f)
            $this->loadData($data, $name . $f . $id);
        return $data;
    }

    protected function validate() {
        if (!$this->user->hasPermission('modify', 'extension/module/smsassistent')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}