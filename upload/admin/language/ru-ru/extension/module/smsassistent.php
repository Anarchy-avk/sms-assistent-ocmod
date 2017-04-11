<?php
// Heading
$_['heading_title']		= 'SMS-ассистент';

$_['text_module']		= 'Расширения';
$_['text_success']		= 'Настройки успешно изменены!';
$_['text_edit']			= 'Настройки модуля';

// Entry
$_['text_general']			= 'Основное';
$_['entry_status']			= 'Статус';
$_['entry_api_username']	= 'Имя пользователя';
$_['entry_api_token']		= 'Токен';
$_['entry_api_password']	= 'или Пароль';
$_['entry_sender_name']		= 'Отправитель по-умолчанию';
$_['text_customer_order_create']			= 'Уведомление пользователю, при создании заказа';
$_['entry_customer_order_create_status']	= 'Статус';
$_['entry_customer_order_create_text']		= 'Шаблон SMS сообщения';
$_['text_admin_order_create']				= 'Уведомление администраторам, при создании заказа пользователями';
$_['entry_admin_order_create_status']	= 'Статус';
$_['entry_admin_order_create_phones']	= 'Номера телефонов';
$_['help_admin_order_create_phones']	= 'Номера телефонов перечисляются через ;';
$_['entry_admin_order_create_text']		= 'Шаблон SMS сообщения';
$_['text_logs']						= 'Журнал событий';
$_['pane_main_settings']			= 'Основное';
$_['pane_notification_settings']	= 'Уведомления';
$_['pane_logs']						= 'Логи';
$_['pane_sms_text']		= 'Сообщение';
$_['pane_sms_template']	= 'Доступные тэги';
$_['pane_sms_template_text'] = '
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
';

// Error
$_['error_permission'] = 'У Вас нет прав для изменения настроек!';