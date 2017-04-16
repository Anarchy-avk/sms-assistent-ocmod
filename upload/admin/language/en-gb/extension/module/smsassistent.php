<?php
// Heading
$_['heading_title']	= 'SMS-Assistent';

$_['text_module']	= 'Modules';
$_['text_success']	= 'Success: You have modified SMS-Assistent module!';
$_['text_edit']		= 'Edit SMS-Assistent Module';

// Main settings
$_['pane_main_settings']	= 'Settings';
$_['text_general']			= 'Main';
$_['entry_status']     		= 'Status';
$_['entry_api_username']	= 'API username';
$_['entry_api_token']		= 'Token';
$_['entry_api_password']	= 'or Password';
$_['entry_sender_name']		= 'Sender by default';

// Notifications after create order
$_['pane_order_create']						= 'New order';
$_['text_customer_order_create']			= 'Send notification to customer';
$_['entry_customer_order_create_status']	= 'Status';
$_['entry_customer_order_create_text']		= 'Template of SMS notification';
$_['text_admin_order_create']				= 'Send notification to managers';
$_['entry_admin_order_create_status']		= 'Status';
$_['entry_admin_order_create_phones']		= 'Phone numbers';
$_['help_admin_order_create_phones']		= 'Phone numbers are listed through ;';
$_['entry_admin_order_create_text']			= 'Template of SMS notification';
$_['pane_sms_text']							= 'SMS message';
$_['pane_sms_template']						= 'Tags';
$_['pane_sms_template_text'] = <<<TEMPLATE_TEXT
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
TEMPLATE_TEXT;

// Logs
$_['pane_logs']	= 'Logs';
$_['text_logs']	= 'Error and notification log';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify with module!';