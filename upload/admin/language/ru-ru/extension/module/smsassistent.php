<?php
// Heading
$_['heading_title']	= 'SMS-ассистент';

$_['text_module']	= 'Расширения';
$_['text_success']	= 'Настройки успешно изменены!';
$_['text_edit']		= 'Настройки модуля';

// Main settings (ms)
$_['pane_ms']				= 'Настройки';
$_['text_ms_general']		= 'Основное';
$_['entry_ms_status']		= 'Активен';
$_['entry_ms_api_username']	= 'Имя пользователя';
$_['entry_ms_api_token']	= 'Токен';
$_['entry_ms_api_password']	= 'или Пароль';
$_['entry_ms_sender_name']	= 'Отправитель по-умолчанию';

// Notifications after change order status (naco)
$_['pane_naco']						= 'Новый статус заказа';
$_['text_naco_order_status']		= 'Отправлять уведомления при изменении статуса';
$_['text_naco_customer']			= 'Уведомление пользователю';
$_['entry_naco_customer_status']	= 'Активен';
$_['entry_naco_customer_text']		= 'Шаблон SMS сообщения';
$_['text_naco_admin']				= 'Уведомление менеджерам';
$_['entry_naco_admin_status']		= 'Активен';
$_['entry_naco_admin_phones']		= 'Номера телефонов';
$_['help_naco_admin_phones']		= 'Номера телефонов перечисляются через ;';
$_['entry_naco_admin_text']			= 'Шаблон SMS сообщения';
$_['pane_naco_sms_text']			= 'Сообщение';
$_['pane_naco_sms_template']		= 'Доступные тэги';
$_['pane_naco_sms_template_text'] 	= <<<TEMPLATE_TEXT
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

// Notifications after register customer (narc)
$_['pane_narc']						= 'Новый пользователь';
$_['text_narc_customer']			= 'Уведомление пользователю';
$_['entry_narc_customer_status']	= 'Активен';
$_['entry_narc_customer_text']		= 'Шаблон SMS сообщения';
$_['text_narc_admin']				= 'Уведомление менеджерам';
$_['entry_narc_admin_status']		= 'Активен';
$_['entry_narc_admin_phones']		= 'Номера телефонов';
$_['help_narc_admin_phones']		= 'Номера телефонов перечисляются через ;';
$_['entry_narc_admin_text']			= 'Шаблон SMS сообщения';
$_['pane_narc_sms_text']			= 'Сообщение';
$_['pane_narc_sms_template']		= 'Доступные тэги';
$_['pane_narc_sms_template_text'] 	= <<<TEMPLATE_TEXT
<strong>{firstname}</strong> - Имя;</br>
<strong>{lastname}</strong> - Фамилия;</br>
<strong>{email}</strong> - Email;</br>
<strong>{telephone}</strong> - Телефон;</br> 
<strong>{fax}</strong> - Факс;</br>
<strong>{company}</strong> - Место работы;</br>
<strong>{address_1}</strong> - Адрес;</br>
<strong>{address_2}</strong> - Адрес дополнительно;</br>
<strong>{city}</strong> - Город;</br> 
<strong>{postcode}</strong> - Почтовый индекс;
<strong>{store_name}</strong> - Название магазина;
<strong>{store_address}</strong> - Адрес магазина;
<strong>{store_email}</strong> - Email магазина;
<strong>{store_phone}</strong> - Телефон магазина;
TEMPLATE_TEXT;

// Logs (logs)
$_['pane_logs']	= 'Логи';
$_['text_logs']	= 'Журнал событий';

// Error
$_['error_permission'] = 'У Вас нет прав для изменения настроек!';