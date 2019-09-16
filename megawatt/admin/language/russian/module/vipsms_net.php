<?php

// Heading
$_['heading_title'] = 'VipSMS.net';
$_['text_module']   = 'Модули';

$_['vipsms_net_saved_success'] = 'Успешно сохранены настройки';
$_['vipsms_net_smssend_success'] = 'Сообщение успешно отправлено на шлюз';

// Error
$_['vipsms_net_error_permission'] = 'Вы не имеете полномочий для изменения настроек данного модуля!';
$_['vipsms_net_error_request'] = 'Ошибка запроса';
$_['vipsms_net_error_auth_info'] = 'Необходимо задать идентификационный данные SMS-шлюза';
$_['vipsms_net_error_login_field'] = 'Необходимо указать логин';
$_['vipsms_net_error_password_field'] = 'Необходимо указать пароль';
$_['vipsms_net_error_sign_field'] = 'Необходимо указать подпись для сообщений';
$_['vipsms_net_error_admphone_field'] = 'Укажите номер телефона администратора';
$_['vipsms_net_error_sign_to_large'] = 'Подпись слишком длинная. Максимум 11 символов.';
$_['vipsms_net_error_empty_frmsms_message'] = 'Необходимо указать текст сообщения';

// Tabs name in view
$_['vipsms_net_tab_connection'] = 'Настройки шлюза';
$_['vipsms_net_tab_signature'] = 'Подпись сообщений';
$_['vipsms_net_tab_events'] = 'Выполнять при действиях';
$_['vipsms_net_tab_about'] = 'О модуле';
$_['vipsms_net_tab_sendsms'] = 'Отправить SMS';

// Text messges
$_['vipsms_net_text_gate_settings'] = 'Настройки шлюза';
$_['vipsms_net_text_login'] = 'Логин';
$_['vipsms_net_text_password'] = 'Пароль';
$_['vipsms_net_text_sign'] = 'Подпись сообщений';
$_['vipsms_net_text_admphone'] = 'Телефон администратора';
$_['vipsms_net_text_notify_sms_to_admin'] = 'Сообщать по событиям администратора';
$_['vipsms_net_text_notify_sms_to_customer'] = 'Сообщать по событиям покупателя';
$_['vipsms_net_text_connection_established'] = 'Соеденение с SMS-шлюзом установлено';
$_['vipsms_net_text_connection_error'] = 'Нет связи с SMS-шлюзом';
$_['vipsms_net_events_admin_new_customer'] = 'Новый покупатель зарегистрирован';
$_['vipsms_net_events_admin_new_order'] = 'Осуществили новый заказ';
$_['vipsms_net_events_admin_new_email'] = 'Поступило новое письмо с контактной формы магазина';
$_['vipsms_net_text_frmsms_message'] = 'Текст сообщения';
$_['vipsms_net_text_frmsms_phone'] = 'Номер получателя';
$_['vipsms_net_text_button_send_sms'] = 'Отправить SMS';
$_['vipsms_net_events_admin_gateway_connection_error'] = 'Уведомлять на email при неудачном соединении со шлюзом';
$_['vipsms_net_events_customer_new_order_status'] = 'Изменение статуса заказа';
$_['vipsms_net_events_customer_new_order'] = 'Покупателю сообщение о новом заказе';
$_['vipsms_net_events_customer_new_register'] = 'Успешное завершение регистрации';

$_['vipsms_net_message_customer_new_order_status'] = 'Статус заказа #%s изменен на "%s"';

$_['vipsms_net_text_connection_tab_description'] =
'Укажите правильные данные для подключения к шлюзу VipSMS.net через SOAP протокол.<br/>';

$_['vipsms_net_text_about_tab_description'] =
'<b>%s &copy; %s Все права защищены</b><br/>
<br/>
Модуль предназначен для рассылки SMS уведомлений посредством шлюза VipSMS.net.
<br/><br/>
Данное произведение распространяется на основании BSD лицензии<br/><br/>
Текущая версия: %s<br/>';

# vi:ts=2:sw=2:ai:et:ft=php:enc=utf8
