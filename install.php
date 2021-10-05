<?php

$replacement = array();
$replacement['smsassistent_ms_sender_name'] = 'smsassistent_ms_sender_name_sms';
$replacement['smsassistent_narc_admin_phones'] = 'smsassistent_narc_admin_phones_sms_0';
$replacement['smsassistent_narc_admin_status'] = 'smsassistent_narc_admin_status_0';
$replacement['smsassistent_narc_customer_status'] = 'smsassistent_narc_customer_status_0';
$replacement['smsassistent_narc_admin_text'] = 'smsassistent_narc_admin_text_sms_0';
$replacement['smsassistent_narc_customer_text'] = 'smsassistent_narc_customer_text_sms_0';

$this->db->query("UPDATE " . DB_PREFIX . "setting SET `key` = REPLACE (`key`, 'smsassistent_naco_customer_text_', 'smsassistent_naco_customer_text_sms_') WHERE `key` LIKE 'smsassistent_naco_customer_text_%'");
$this->db->query("UPDATE " . DB_PREFIX . "setting SET `key` = REPLACE (`key`, 'smsassistent_naco_admin_text_', 'smsassistent_naco_admin_text_sms_') WHERE `key` LIKE 'smsassistent_naco_admin_text_%'");
$this->db->query("UPDATE " . DB_PREFIX . "setting SET `key` = REPLACE (`key`, 'smsassistent_naco_admin_phones_', 'smsassistent_naco_admin_phones_sms_') WHERE `key` LIKE 'smsassistent_naco_admin_phones_%'");
foreach ($replacement as $key => $value) {
    $this->db->query("UPDATE " . DB_PREFIX . "setting SET `key` = '$value' WHERE `key` = '$key'");
}

$q = "UPDATE " . DB_PREFIX . "setting SET `value` = REPLACE (`value`, ";
$this->db->query($q . "'0', 'disabled') WHERE `key` LIKE 'smsassistent_naco_customer_status_%'");
$this->db->query($q . "'1', 'sms') WHERE `key` LIKE 'smsassistent_naco_customer_status_%'");
$this->db->query($q . "'0', 'disabled') WHERE `key` LIKE 'smsassistent_naco_admin_status_%'");
$this->db->query($q . "'1', 'sms') WHERE `key` LIKE 'smsassistent_naco_admin_status_%'");

$this->db->query($q . "'0', 'disabled') WHERE `key` = 'smsassistent_narc_customer_status_0'");
$this->db->query($q . "'1', 'sms') WHERE `key` = 'smsassistent_narc_customer_status_0'");
$this->db->query($q . "'0', 'disabled') WHERE `key` = 'smsassistent_narc_admin_status_0'");
$this->db->query($q . "'1', 'sms') WHERE `key` = 'smsassistent_narc_admin_status_0'");
