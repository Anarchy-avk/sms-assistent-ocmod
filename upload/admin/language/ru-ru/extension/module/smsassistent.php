<?php
// Heading
$_['heading_title']     = 'SMS-ассистент';

$_['text_module']       = 'Расширения';
$_['text_success']      = 'Настройки успешно изменены!';
$_['text_edit']         = 'Настройки модуля';

// Main settings (ms)
$_['pane_ms'] = 'Настройки';
$_['text_ms_general'] = 'Основное';
$_['entry_ms_status'] = 'Активен';
$_['entry_ms_api_username'] = 'Имя пользователя';
$_['entry_ms_api_password'] = 'Пароль';
$_['help_ms_api_password'] = 'Пароль для доступа к АПИ. Генерируется в личном кабинете.';
$_['entry_ms_api_or'] = 'или';
$_['entry_ms_api_token'] = 'Токен';
$_['entry_ms_sender_name_sms'] = 'Отправитель SMS по-умолчанию';
$_['entry_ms_sender_name_viber'] = 'Отправитель Viber по-умолчанию';
$_['entry_ms_base_url'] = 'Адрес API сервера';
$_['help_ms_base_url'] = 'Если не указан, то используется адрес сервера по-умолчанию.';

// Notifications after change order status (naco)
$_['pane_naco'] = 'Новый статус заказа';
$_['text_naco_order_status'] = 'Отправлять уведомления при изменении статуса';
$_['text_naco_customer'] = 'Уведомление пользователю';
$_['entry_naco_customer_status'] = 'Активен';
$_['select_naco_messenger_sms'] = 'SMS';
$_['select_naco_messenger_viber'] = 'Viber';
$_['entry_naco_customer_text_disabled'] = 'Отправка уведомлений пользователю отключена';
$_['entry_naco_admin_text_disabled'] = 'Отправка уведомлений менеджеру отключена';
$_['help_naco_sender_name'] = 'Если не указан, то используется отправитель по-умолчанию на вкладке Настройка.';
$_['entry_naco_sender_sms'] = 'Отправитель SMS';
$_['entry_naco_sender_viber'] = 'Отправитель Viber';
$_['entry_naco_text_sms'] = 'Шаблон SMS сообщения';
$_['entry_naco_text_viber'] = 'Шаблон Viber сообщения';
$_['text_naco_admin'] = 'Уведомление менеджерам';
$_['entry_naco_admin_status'] = 'Активен';
$_['entry_naco_admin_phones'] = 'Номера телефонов';
$_['help_naco_admin_phones'] = 'Номера телефонов перечисляются через ;.';
$_['entry_naco_admin_text'] = 'Шаблон SMS сообщения';
$_['pane_naco_sms_text'] = 'Сообщение';
$_['pane_naco_viber_text'] = 'Сообщение';
$_['pane_naco_sms_template'] = 'Доступные тэги';
$_['pane_naco_viber_template'] = 'Доступные тэги';
$_['entry_naco_promo'] = 'Рекламное сообщение';
$_['help_naco_promo'] = 'Любое сообщение автоматически станет рекламным. Информация о тарифах находится по адресу: https://userarea.sms-assistent.by/my_tarifs.php.';
$_['entry_naco_viber_image'] = 'Ссылка на изображение';
$_['placeholder_naco_viber_image'] = 'Должна начинаться на http:// или https://';
$_['help_naco_viber_image'] = <<<TEMPLATE_TEXT
Рекомендуемый размер изображения: 400×400 px.<br />
Допустимые форматы: png, jpg, jpeg, gif.<br />
Максимальный размер файла: 12 Мб.
TEMPLATE_TEXT;
$_['entry_naco_viber_button_text'] = 'Название кнопки';
$_['help_naco_viber_button_text'] = 'Название кнопки должно быть не более 20 символов.';
$_['entry_naco_viber_button_url'] = 'Ссылка';
$_['placeholder_naco_viber_button_url'] = 'Должна начинаться на http:// или https://';
$_['help_naco_viber_button_url'] = 'Адрес сайта, который открывается по нажатию на кнопку.';
$_['pane_naco_sms_template_text'] = <<<TEMPLATE_TEXT
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
<strong>{comment}</strong> - комментарий к заказу;</br>
<strong>{history_comment}</strong> - комментарий к статусу заказа;</br>
<strong>{total}</strong> - итого по заказу;</br>
<strong>{products_ids}</strong> - идентификаторы товаров, перечисленные через запятую;</br> 
<strong>{products_names}</strong> - названия товаров, перечисленные через запятую;</br> 
<strong>{products_names_prices}</strong> - название и цена товаров, перечисленные через запятую.
TEMPLATE_TEXT;
$_['text_naco_promo'] = 'Выберите, чтобы добавить к сообщению изображение и кнопку';
$_['pane_naco_viber_promo_alert'] = <<<TEMPLATE_TEXT
<b>ОБРАТИТЕ ОСОБОЕ ВНИМАНИЕ!</b> Если введённый здесь текст не будет соответствовать вашим зарегистрированным шаблонам сервисных Viber-сообщений, то сообщение будет тарифицироваться как рекламное.
Подробную информацию о тарифах вы можете получить в личном кабинете SMS-ассистент в разделе <a class="alert-link" href="https://userarea.sms-assistent.by/my_tarifs.php">Мои тарифы</a>.
TEMPLATE_TEXT;
$_['help_naco_else_sms'] = 'Выберите эту опцию, если вы хотите, чтобы абоненту, которому не доставлено Viber-сообщение, через 1 минуту было отправлено SMS. Отправка SMS будет происходить только в том случае, если Viber-сообщение в течение 1 минуты не получило статус «Доставлено» или «Прочитано».';
$_['entry_naco_else_sms'] = 'Отправлять SMS';
$_['text_naco_else_sms'] = 'Если Viber-сообщение не доставлено абоненту, то ему необходимо отправить SMS';


// Notifications after register customer (narc)
$_['pane_narc']                         = 'Новый пользователь';
$_['text_narc_customer']                = 'Уведомление пользователю';
$_['select_narc_messenger_sms']         = 'SMS';
$_['select_narc_messenger_viber']       = 'Viber';
$_['entry_narc_customer_text_disabled'] = 'Отправка уведомлений пользователю отключена';
$_['entry_narc_admin_text_disabled']    = 'Отправка уведомлений менеджеру отключена';
$_['entry_narc_customer_status']        = 'Активен';
$_['help_narc_sender_name']             = 'Если не указан, то используется отправитель по-умолчанию на вкладке Настройка.';
$_['entry_narc_sender_sms'] = 'Отправитель SMS';
$_['entry_narc_sender_viber'] = 'Отправитель Viber';
$_['entry_narc_text_sms'] = 'Шаблон SMS сообщения';
$_['entry_narc_text_viber'] = 'Шаблон Viber сообщения';
$_['text_narc_admin'] = 'Уведомление менеджерам';
$_['entry_narc_admin_status'] = 'Активен';
$_['entry_narc_admin_phones'] = 'Номера телефонов';
$_['help_narc_admin_phones'] = 'Номера телефонов перечисляются через ;.';
$_['entry_narc_admin_text'] = 'Шаблон SMS сообщения';
$_['pane_narc_sms_text'] = 'Сообщение';
$_['pane_narc_viber_text'] = 'Сообщение';
$_['pane_narc_sms_template'] = 'Доступные тэги';
$_['pane_narc_viber_template'] = 'Доступные тэги';
$_['entry_narc_promo'] = 'Рекламное сообщение';
$_['help_narc_promo'] = 'Любое сообщение автоматически станет рекламным. Информация о тарифах находится по адресу: https://userarea.sms-assistent.by/my_tarifs.php.';
$_['entry_narc_viber_image'] = 'Ссылка на изображение';
$_['placeholder_narc_viber_image'] = 'Должна начинаться на http:// или https://';
$_['help_narc_viber_image'] = <<<TEMPLATE_TEXT
Рекомендуемый размер изображения: 400×400 px.<br />
Допустимые форматы: png, jpg, jpeg, gif.<br />
Максимальный размер файла: 12 Мб.
TEMPLATE_TEXT;
$_['entry_narc_viber_button_text'] = 'Название кнопки';
$_['help_narc_viber_button_text'] = 'Название кнопки должно быть не более 20 символов.';
$_['entry_narc_viber_button_url'] = 'Ссылка';
$_['placeholder_narc_viber_button_url'] = 'Должна начинаться на http:// или https://';
$_['help_narc_viber_button_url'] = 'Адрес сайта, который открывается по нажатию на кнопку.';
$_['pane_narc_sms_template_text'] = <<<TEMPLATE_TEXT
<strong>{firstname}</strong> - Имя;</br>
<strong>{lastname}</strong> - Фамилия;</br>
<strong>{email}</strong> - Email;</br>
<strong>{telephone}</strong> - Телефон;</br> 
<strong>{fax}</strong> - Факс;</br>
<strong>{store_name}</strong> - Название магазина;</br>
<strong>{store_address}</strong> - Адрес магазина;</br>
<strong>{store_email}</strong> - Email магазина;</br>
<strong>{store_phone}</strong> - Телефон магазина.
TEMPLATE_TEXT;
$_['text_narc_promo'] = 'Выберите, чтобы добавить к сообщению изображение и кнопку';
$_['pane_narc_viber_promo_alert'] = <<<TEMPLATE_TEXT
<b>ОБРАТИТЕ ОСОБОЕ ВНИМАНИЕ!</b> Если введённый здесь текст не будет соответствовать вашим зарегистрированным шаблонам сервисных Viber-сообщений, то сообщение будет тарифицироваться как рекламное.
Подробную информацию о тарифах вы можете получить в личном кабинете SMS-ассистент в разделе <a class="alert-link" href="https://userarea.sms-assistent.by/my_tarifs.php">Мои тарифы</a>.
TEMPLATE_TEXT;
$_['help_narc_else_sms'] = 'Выберите эту опцию, если вы хотите, чтобы абоненту, которому не доставлено Viber-сообщение, через 1 минуту было отправлено SMS. Отправка SMS будет происходить только в том случае, если Viber-сообщение в течение 1 минуты не получило статус «Доставлено» или «Прочитано».';
$_['entry_narc_else_sms'] = 'Отправлять SMS';
$_['text_narc_else_sms'] = 'Если Viber-сообщение не доставлено абоненту, то ему необходимо отправить SMS';

// Logs (logs)
$_['pane_logs'] = 'Логи';
$_['text_logs'] = 'Журнал событий';

// Error
$_['error_permission'] = 'У Вас нет прав для изменения настроек!';