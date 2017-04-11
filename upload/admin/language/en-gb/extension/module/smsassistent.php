<?php
// Heading
$_['heading_title']    = 'SMS-Assistent';

$_['text_module']      = 'Modules';
$_['text_success']     = 'Success: You have modified SMS-Assistent module!';
$_['text_edit']        = 'Edit SMS-Assistent Module';

// Entry
$_['text_general']			= 'Main';
$_['entry_status']     		= 'Status';
$_['entry_api_username']	= 'API username';
$_['entry_api_token']		= 'Token';
$_['entry_api_password']	= 'or Password';
$_['entry_sender_name']		= 'Sender by default';
$_['text_customer_order_create']			= 'Send notification to customer, after order create';
$_['entry_customer_order_create_status']	= 'Status';
$_['entry_customer_order_create_text']		= 'Template of SMS notification';
$_['text_admin_order_create']				= 'Send notification to administrators, after order create by customer';
$_['entry_admin_order_create_status']	= 'Status';
$_['entry_admin_order_create_phones']	= 'Phone numbers';
$_['help_admin_order_create_phones']	= 'Phone numbers are listed through ;';
$_['entry_admin_order_create_text']		= 'Template of SMS notification';
$_['text_logs']						= 'Error and notification log';
$_['pane_main_settings']			= 'Main';
$_['pane_notification_settings']	= 'Notifications';
$_['pane_logs']						= 'Logs';
$_['pane_sms_text']		= 'SMS message';
$_['pane_sms_template']	= 'Tags';
$_['pane_sms_template_text'] = '
<strong>{store_name}</strong> - Name of the shop;</br>
<strong>{store_url}</strong> - URL of the shop;</br>
<strong>{order_id}</strong> - Number of order;</br>
<strong>{date_added}</strong> - Create time;</br> 
<strong>{payment_method}</strong> - Payment method;</br>
<strong>{payment_code}</strong> - Payment code;</br>
<strong>{email}</strong> - Customer EMail;</br>
<strong>{telephone}</strong> - Customer phone;</br>
<strong>{firstname}</strong> - Customer lastname;</br> 
<strong>{lastname}</strong> - Customer firstname;</br>
<strong>{total}</strong> - Order total;</br>
<strong>{products_ids}</strong> - Product IDs separated by commas;</br> 
<strong>{products_names}</strong> - Product names separated by commas;</br> 
<strong>{products_names_prices}</strong> - Product names and prices separated by commas
';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify with module!';