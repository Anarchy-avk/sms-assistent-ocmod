<?php
// Heading
$_['heading_title']	= 'SMS-ассистент';

$_['text_module']	= 'Расширения';
$_['text_success']	= 'Настройки успешно изменены!';
$_['text_edit']		= 'Настройки модуля';

// Main settings
$_['pane_main_settings']	= 'Настройки';
$_['text_general']			= 'Основное';
$_['entry_status']			= 'Статус';
$_['entry_api_username']	= 'Имя пользователя';
$_['entry_api_token']		= 'Токен';
$_['entry_api_password']	= 'или Пароль';
$_['entry_sender_name']		= 'Отправитель по-умолчанию';

// Notifications after create order
$_['pane_order_create']						= 'Новый заказ';
$_['text_customer_order_create']			= 'Уведомление пользователю';
$_['entry_customer_order_create_status']	= 'Статус';
$_['entry_customer_order_create_text']		= 'Шаблон SMS сообщения';
$_['text_admin_order_create']				= 'Уведомление менеджерам';
$_['entry_admin_order_create_status']		= 'Статус';
$_['entry_admin_order_create_phones']		= 'Номера телефонов';
$_['help_admin_order_create_phones']		= 'Номера телефонов перечисляются через ;';
$_['entry_admin_order_create_text']			= 'Шаблон SMS сообщения';
$_['pane_sms_text']							= 'Сообщение';
$_['pane_sms_template']						= 'Доступные тэги';
$_['pane_sms_template_text'] = <<<TEMPLATE_TEXT
<strong>{store_name}</strong> - название магазина;</br>
<strong>{store_url}</strong> - URL магазина;</br>
<strong>{order_id}</strong> - номер заказа;</br>
<strong>{date_added}</strong> - время создания;</br> 
<strong>{payment_method}</strong> - способ оплаты;</br>
<strong>{payment_code}</strong> - код оплаты;</br>
<strong>{email}</strong> - EMail покупателя;</br>
<strong>{telephone}</strong> - телефон покупателя;</br>
<strong>{firstname}</strong> - фамилия покупателя;</br> 
<strong>{lastname}</strong> - имя покупателя;</br>
<strong>{total}</strong> - итого по заказу;</br>
<strong>{products_ids}</strong> - идентификаторы товаров, перечисленные через запятую;</br> 
<strong>{products_names}</strong> - названия товаров, перечисленные через запятую;</br> 
<strong>{products_names_prices}</strong> - название и цена товаров, перечисленные через запятую
TEMPLATE_TEXT;

// Logs
$_['pane_logs']	= 'Логи';
$_['text_logs']	= 'Журнал событий';

// Error
$_['error_permission'] = 'У Вас нет прав для изменения настроек!';