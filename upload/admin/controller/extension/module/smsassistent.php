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

        $data = array();

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $data = $this->addCheckboxStatuses($this->request->post);
            $this->model_setting_setting->editSetting('smsassistent', $data);

            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', 'SSL'));
        }

        //Heading language
        $data = $this->getLanguageHeading($data);

        //Main language
        $data = $this->getLanguageMs($data);

        // Notifications after change order status (naco)
        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        //Naco language
        $data = $this->getLanguageNacoNarc($data, 'naco');

        //Narc language
        $data = $this->getLanguageNacoNarc($data, 'narc');

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
            $data['smsassistent_log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/module/smsassistent.tpl', $data));
    }

    private function getLanguageHeading($data){
        $data['heading_title']  = $this->language->get('heading_title');
        $data['text_edit']      = $this->language->get('text_edit');
        $data['text_yes']       = $this->language->get('text_yes');
        $data['text_no']        = $this->language->get('text_no');
        $data['text_enabled']   = $this->language->get('text_enabled');
        $data['text_disabled']  = $this->language->get('text_disabled');
        $data['button_save']    = $this->language->get('button_save');
        $data['button_cancel']  = $this->language->get('button_cancel');
        return $data;
    }

    private function getLanguageMs($data){
        $data['pane_ms']                    = $this->language->get('pane_ms');
        $data['text_ms_general']            = $this->language->get('text_ms_general');
        $data['entry_ms_status']            = $this->language->get('entry_ms_status');
        $data['entry_ms_api_username']      = $this->language->get('entry_ms_api_username');
        $data['entry_ms_api_password']      = $this->language->get('entry_ms_api_password');
        $data['help_ms_api_password']       = $this->language->get('help_ms_api_password');
        $data['entry_ms_api_or']            = $this->language->get('entry_ms_api_or');
        $data['entry_ms_api_token']         = $this->language->get('entry_ms_api_token');
        $data['entry_ms_sender_name_sms']   = $this->language->get('entry_ms_sender_name_sms');
        $data['entry_ms_sender_name_viber'] = $this->language->get('entry_ms_sender_name_viber');
        $data['entry_ms_base_url']          = $this->language->get('entry_ms_base_url');
        $data['help_ms_base_url']           = $this->language->get('help_ms_base_url');
        return $data;
    }

    private function getLanguageNacoNarc($data, $mod){
        $data['pane_' .$mod]                               = $this->language->get('pane_' .$mod);
        $data['text_' .$mod. '_order_status']              = $this->language->get('text_' .$mod. '_order_status');
        $data['text_' .$mod. '_customer']                  = $this->language->get('text_' .$mod. '_customer');
        $data['entry_' .$mod. '_customer_status']          = $this->language->get('entry_' .$mod. '_customer_status');
        $data['select_' .$mod. '_messenger_sms']           = $this->language->get('select_' .$mod. '_messenger_sms');
        $data['select_' .$mod. '_messenger_viber']         = $this->language->get('select_' .$mod. '_messenger_viber');
        $data['entry_' .$mod. '_customer_text_disabled']   = $this->language->get('entry_' .$mod. '_customer_text_disabled');
        $data['entry_' .$mod. '_admin_text_disabled']      = $this->language->get('entry_' .$mod. '_admin_text_disabled');
        $data['help_' .$mod. '_sender_name']               = $this->language->get('help_' .$mod. '_sender_name');
        $data['entry_' .$mod. '_sender_sms']               = $this->language->get('entry_' .$mod. '_sender_sms');
        $data['entry_' .$mod. '_sender_viber']             = $this->language->get('entry_' .$mod. '_sender_viber');
        $data['entry_' .$mod. '_text_sms']                 = $this->language->get('entry_' .$mod. '_text_sms');
        $data['entry_' .$mod. '_text_viber']               = $this->language->get('entry_' .$mod. '_text_viber');
        $data['text_' .$mod. '_admin']                     = $this->language->get('text_' .$mod. '_admin');
        $data['entry_' .$mod. '_admin_status']             = $this->language->get('entry_' .$mod. '_admin_status');
        $data['entry_' .$mod. '_admin_phones']             = $this->language->get('entry_' .$mod. '_admin_phones');
        $data['help_' .$mod. '_admin_phones']              = $this->language->get('help_' .$mod. '_admin_phones');
        $data['entry_' .$mod. '_admin_text']               = $this->language->get('entry_' .$mod. '_admin_text');
        $data['pane_' .$mod. '_sms_text']                  = $this->language->get('pane_' .$mod. '_sms_text');
        $data['pane_' .$mod. '_viber_text']                = $this->language->get('pane_' .$mod. '_viber_text');
        $data['pane_' .$mod. '_sms_template']              = $this->language->get('pane_' .$mod. '_sms_template');
        $data['pane_' .$mod. '_viber_template']            = $this->language->get('pane_' .$mod. '_viber_template');
        $data['entry_' .$mod. '_promo']                    = $this->language->get('entry_' .$mod. '_promo');
        $data['help_' .$mod. '_promo']                     = $this->language->get('help_' .$mod. '_promo');
        $data['entry_' .$mod. '_viber_image']              = $this->language->get('entry_' .$mod. '_viber_image');
        $data['placeholder_' .$mod. '_viber_image']        = $this->language->get('placeholder_' .$mod. '_viber_image');
        $data['help_' .$mod. '_viber_image']               = $this->language->get('help_' .$mod. '_viber_image');
        $data['entry_' .$mod. '_viber_button_text']        = $this->language->get('entry_' .$mod. '_viber_button_text');
        $data['help_' .$mod. '_viber_button_text']         = $this->language->get('help_' .$mod. '_viber_button_text');
        $data['entry_' .$mod. '_viber_button_url']         = $this->language->get('entry_' .$mod. '_viber_button_url');
        $data['placeholder_' .$mod. '_viber_button_url']   = $this->language->get('placeholder_' .$mod. '_viber_button_url');
        $data['help_' .$mod. '_viber_button_url']          = $this->language->get('help_' .$mod. '_viber_button_url');
        $data['pane_' .$mod. '_sms_template_text']         = $this->language->get('pane_' .$mod. '_sms_template_text');
        $data['text_' .$mod. '_promo']                     = $this->language->get('text_' .$mod. '_promo');
        $data['pane_' .$mod. '_viber_promo_alert']         = $this->language->get('pane_' .$mod. '_viber_promo_alert');
        $data['help_' .$mod. '_else_sms']                  = $this->language->get('help_' .$mod. '_else_sms');
        $data['entry_' .$mod. '_else_sms']                 = $this->language->get('entry_' .$mod. '_else_sms');
        $data['text_' .$mod. '_else_sms']                  = $this->language->get('text_' .$mod. '_else_sms');
        return $data;
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