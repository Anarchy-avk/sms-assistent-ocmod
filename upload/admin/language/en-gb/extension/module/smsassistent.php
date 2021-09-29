<?php
// Heading
$_['heading_title']	= 'SMS-Assistent';

$_['text_module']	= 'Modules';
$_['text_success']	= 'Success: You have modified SMS-Assistent module!';
$_['text_edit']		= 'Edit SMS-Assistent Module';

// Main settings (ms)
$_['pane_ms']				      = 'Settings';
$_['text_ms_general']		      = 'Main';
$_['entry_ms_status']             = 'Active';
$_['entry_ms_api_username'] 	  = 'API username';
$_['entry_ms_api_password'] 	  = 'Password';
$_['help_ms_api_password']	      = 'Password for API. Generated in your personal account.';
$_['entry_ms_api_or']	          = 'or';
$_['entry_ms_api_token']	      = 'Token';
$_['entry_ms_sender_name_sms']	  = 'Default SMS sender';
$_['entry_ms_sender_name_viber']  = 'Default Viber sender';
$_['entry_ms_base_url']	          = 'Server API address';
$_['help_ms_base_url']            = 'If omitted, the default server address is used.';

// Notifications after create order (naco)
$_['pane_naco']					    	= 'New order status';
$_['text_naco_order_status']	    	= 'Send notification when status changed';
$_['text_naco_customer']		    	= 'Send notification to customer';
$_['entry_naco_customer_status']    	= 'Active';
$_['select_naco_messenger_sms']         = 'SMS';
$_['select_naco_messenger_viber']       = 'Viber';
$_['entry_naco_customer_text_disabled'] = 'Sending notifications to the user is disabled';
$_['entry_naco_admin_text_disabled']    = 'Sending notifications to the manager is disabled';
$_['help_naco_sender_name']             = 'If not specified, the default sender is used on the Settings tab.';
$_['entry_naco_sender_sms']             = 'SMS sender';
$_['entry_naco_sender_viber']           = 'Viber Sender';
$_['entry_naco_text_sms']             	= 'Template of SMS notification';
$_['entry_naco_text_viber']             = 'Template of Viber notification';
$_['text_naco_admin']			    	= 'Send notification to managers';
$_['entry_naco_admin_status']	    	= 'Active';
$_['entry_naco_admin_phones']	    	= 'Phone numbers';
$_['help_naco_admin_phones']	    	= 'Phone numbers are listed through ;.';
$_['entry_naco_admin_text']		    	= 'Template of SMS notification';
$_['pane_naco_sms_text']		    	= 'Message';
$_['pane_naco_viber_text']		    	= 'Message';
$_['pane_naco_sms_template']	    	= 'Tags';
$_['pane_naco_viber_template']	    	= 'Tags';
$_['entry_naco_promo']	              	= 'Advertising message';
$_['help_naco_promo']	              	= 'Any message will automatically become advertising. Tariff information is available at: https://userarea.sms-assistent.by/my_tarifs.php.';
$_['entry_naco_viber_image']	    	= 'Image link';
$_['placeholder_naco_viber_image']	   	= 'Should begin with either http:// or https://';
$_['help_naco_viber_image']	         	= <<<TEMPLATE_TEXT
Recommended image size: 400×400 px.<br />
Acceptable formats: png, jpg, jpeg, gif.<br />
Maximum file size: 12 Mb.
TEMPLATE_TEXT;
$_['entry_naco_viber_button_text']	    = 'Button name';
$_['help_naco_viber_button_text']	    = 'Button name must be no more than 20 characters';
$_['entry_naco_viber_button_url']	    = 'Link';
$_['placeholder_naco_viber_button_url'] = 'Should begin with either http:// or https://';
$_['help_naco_viber_button_url']	    = 'The address of the site that opens by clicking on the button.';
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
$_['text_naco_promo']                   = 'Select to add an image and a button to the message';
$_['pane_naco_viber_promo_alert']   	= <<<TEMPLATE_TEXT
<b>Attention!</b> If the entered text does not correspond to your registered Viber’s service messages templates, then the message will be charged as a promotional one.
More info about tariffs you can get in SMS assistant’s personal account in the <a class="alert-link" href="https://userarea.sms-assistent.by/my_tarifs.php">My tariffs</a> section.
TEMPLATE_TEXT;
$_['help_naco_else_sms']                = 'Choose this option if you want the recipient, to whom the Viber message has not been delivered, to get an SMS. The SMS will be sent only in case when Viber message did not get either “Delivered” or “Read” during one minute.';
$_['entry_naco_else_sms']               = 'Send SMS';
$_['text_naco_else_sms']                = 'If the Viber message is not delivered to the subscriber, then he needs to send an SMS';

// Notifications after register customer (narc)
$_['pane_narc']					    	= 'New user';
$_['text_narc_customer']			    = 'Send notification to user';
$_['select_narc_messenger_sms']         = 'SMS';
$_['select_narc_messenger_viber']       = 'Viber';
$_['entry_narc_customer_text_disabled'] = 'Sending notifications to the user is disabled';
$_['entry_narc_admin_text_disabled']    = 'Sending notifications to the manager is disabled';
$_['entry_narc_customer_status']    	= 'Active';
$_['help_narc_sender_name']             = 'If not specified, the default sender is used on the Settings tab.';
$_['entry_narc_sender_sms']             = 'SMS sender';
$_['entry_narc_sender_viber']           = 'Viber sender';
$_['entry_narc_text_sms']             	= 'Template of SMS notification';
$_['entry_narc_text_viber']             = 'Template of Viber notification';
$_['text_narc_admin']			    	= 'Notice to managers';
$_['entry_narc_admin_status']	    	= 'Active';
$_['entry_narc_admin_phones']	    	= 'Phone numbers';
$_['help_narc_admin_phones']	    	= 'Phone numbers are listed through ;.';
$_['entry_narc_admin_text']		    	= 'Template of SMS notification';
$_['pane_narc_sms_text']		    	= 'Message';
$_['pane_narc_viber_text']		    	= 'Message';
$_['pane_narc_sms_template']	    	= 'Tags';
$_['pane_narc_viber_template']	    	= 'Tags';
$_['entry_narc_promo']	              	= 'Advertising message';
$_['help_narc_promo']	              	= 'Any message will automatically become advertising. Tariff information is available at: https://userarea.sms-assistent.by/my_tarifs.php.';
$_['entry_narc_viber_image']	    	= 'Image link';
$_['placeholder_narc_viber_image']	   	= 'Should begin with either http:// or https://';
$_['help_narc_viber_image']	         	= <<<TEMPLATE_TEXT
Recommended image size: 400×400 px.<br />
Acceptable formats: png, jpg, jpeg, gif.<br />
Maximum file size: 12 Mb.
TEMPLATE_TEXT;
$_['entry_narc_viber_button_text']	    = 'Button name';
$_['help_narc_viber_button_text']	    = 'Button name must be no more than 20 characters.';
$_['entry_narc_viber_button_url']	    = 'Link';
$_['placeholder_narc_viber_button_url'] = 'Should begin with either http:// or https://';
$_['help_narc_viber_button_url']	    = 'The address of the site that opens by clicking on the button.';
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
$_['text_narc_promo']                   = 'Select to add an image and a button to the message';
$_['pane_narc_viber_promo_alert']   	= <<<TEMPLATE_TEXT
<b>Attention!</b> If the entered text does not correspond to your registered Viber’s service messages templates, then the message will be charged as a promotional one.
More info about tariffs you can get in SMS assistant’s personal account in the <a class="alert-link" href="https://userarea.sms-assistent.by/my_tarifs.php">My tariffs</a> section.
TEMPLATE_TEXT;
$_['help_narc_else_sms']                = 'Choose this option if you want the recipient, to whom the Viber message has not been delivered, to get an SMS. The SMS will be sent only in case when Viber message did not get either “Delivered” or “Read” during one minute.';
$_['entry_narc_else_sms']               = 'Send SMS';
$_['text_narc_else_sms']                = 'If the Viber message is not delivered to the subscriber, then he needs to send an SMS';

// Logs (logs)
$_['pane_logs']	= 'Logs';
$_['text_logs']	= 'Error and notification log';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify with module!';