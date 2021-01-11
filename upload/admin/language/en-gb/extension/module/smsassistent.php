<?php
// Heading
$_['heading_title']	= 'SMS-Assistent';

$_['text_module']	= 'Modules';
$_['text_success']	= 'Success: You have modified SMS-Assistent module!';
$_['text_edit']		= 'Edit SMS-Assistent Module';

// Main settings (ms)
$_['pane_ms']				= 'Settings';
$_['text_ms_general']		= 'Main';
$_['entry_ms_status']       = 'Active';
$_['entry_ms_api_username']	= 'API username';
$_['entry_ms_api_password']	= 'Password';
$_['help_ms_api_password']	= 'Password for API. Generated in your personal account';
$_['entry_ms_api_or']	    = 'or';
$_['entry_ms_api_token']	= 'Token';
$_['entry_ms_sender_name']	= 'Sender by default';
$_['entry_ms_base_url']	    = 'Basi API URL';
$_['help_ms_base_url']      = 'If omitted, the default server address is used';

// Notifications after create order (naco)
$_['pane_naco']						= 'New order status';
$_['text_naco_order_status']		= 'Send notification when status changed';
$_['text_naco_customer']			= 'Send notification to customer';
$_['entry_naco_customer_status']	= 'Active';
$_['entry_naco_customer_text']		= 'Template of SMS notification';
$_['text_naco_admin']				= 'Send notification to managers';
$_['entry_naco_admin_status']		= 'Active';
$_['entry_naco_admin_phones']		= 'Phone numbers';
$_['help_naco_admin_phones']		= 'Phone numbers are listed through ;';
$_['entry_naco_admin_text']			= 'Template of SMS notification';
$_['pane_naco_sms_text']			= 'SMS message';
$_['pane_naco_sms_template']		= 'Tags';
$_['pane_naco_sms_template_text'] 	= <<<TEMPLATE_TEXT
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
<strong>{comment}</strong> - Order comment;</br>
<strong>{history_comment}</strong> - Order history comment;</br>
<strong>{total}</strong> - Order total;</br>
<strong>{products_ids}</strong> - Product IDs separated by commas;</br> 
<strong>{products_names}</strong> - Product names separated by commas;</br> 
<strong>{products_names_prices}</strong> - Product names and prices separated by commas.
TEMPLATE_TEXT;

// Notifications after register customer (narc)
$_['pane_narc']						= 'New customer';
$_['text_narc_customer']			= 'Send notification to customer';
$_['entry_narc_customer_status']	= 'Active';
$_['entry_narc_customer_text']		= 'Template of SMS notification';
$_['text_narc_admin']				= 'Send notification to managers';
$_['entry_narc_admin_status']		= 'Active';
$_['entry_narc_admin_phones']		= 'Phone numbers';
$_['help_narc_admin_phones']		= 'Phone numbers are listed through ;';
$_['entry_narc_admin_text']			= 'Template of SMS notification';
$_['pane_narc_sms_text']			= 'SMS message';
$_['pane_narc_sms_template']		= 'Tags';
$_['pane_narc_sms_template_text'] 	= <<<TEMPLATE_TEXT
<strong>{firstname}</strong> - Firstname;</br>
<strong>{lastname}</strong> - Lastname;</br>
<strong>{email}</strong> - Email;</br>
<strong>{telephone}</strong> - Phone;</br> 
<strong>{fax}</strong> - Fax;</br>
<strong>{store_name}</strong> - Store name;</br>
<strong>{store_address}</strong> - Store address;</br>
<strong>{store_email}</strong> - Store Email;</br>
<strong>{store_phone}</strong> - Store phone.
TEMPLATE_TEXT;

// Logs (logs)
$_['pane_logs']	= 'Logs';
$_['text_logs']	= 'Error and notification log';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify with module!';