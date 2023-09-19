<?php
// Heading
$_['heading_title'] = 'GercPay';

// Text
$_['text_edit'] = 'Настройки модуля';
$_['text_extension'] = 'Модули / Расширения';
$_['text_payment'] = 'Оплата';
$_['text_gercpay'] = '<a href="https://gercpay.com.ua" target="_blank" style="background: url(/image/payment/gercpay.svg) 0 0/auto 100% no-repeat !important;"><img src="/image/payment/gercpay.png" alt="GercPay" title="GercPay"></a>';
$_['text_success'] = 'Настройки модуля обновлены';
$_['text_pay'] = 'GercPay';
$_['text_card'] = 'Кредитная карта';
$_['text_all_zones'] = 'Все зоны';

// Entry
$_['entry_merchant'] = 'Идентификатор торговца';
$_['entry_secretkey'] = 'Секретный ключ';
$_['entry_order_status'] = 'Статус заказа после успешной оплаты';
$_['entry_order_reverse_status'] = 'Статус заказа после возврата оплаты';
$_['entry_currency'] = 'Валюта';
$_['entry_approve_url'] = 'URL перенаправления после успешной оплаты';
$_['entry_decline_url'] = 'URL перенаправления после неуспешной оплаты';
$_['entry_cancel_url'] = 'URL перенаправления после отмены оплаты';
$_['entry_callback_url'] = 'URL для информации об оплате';
$_['entry_language'] = 'Язык страницы оплаты';
$_['entry_geo_zone'] = 'Географическая зона';
$_['entry_status'] = 'Состояние метода оплаты';
$_['entry_sort_order'] = 'Порядок сортировки';

// Help
$_['help_merchant'] = 'Выдаётся торговцу системой GercPay';
$_['help_secretkey'] = 'Выдаётся торговцу системой GercPay';
$_['help_order_status'] = '';
$_['help_order_reverse_status'] = '';
$_['help_currency'] = 'Валюта торговца';
$_['help_approve_url'] = 'По умолчанию: https://{your_site}/index.php?route=extension/payment/gercpay/approve';
$_['help_decline_url'] = 'По умолчанию: https://{your_site}/index.php?route=extension/payment/gercpay/decline';
$_['help_cancel_url'] = 'По умолчанию: https://{your_site}/index.php?route=extension/payment/gercpay/cancel';
$_['help_callback_url'] = 'По умолчанию: https://{your_site}/index.php?route=extension/payment/gercpay/callback';
$_['help_language'] = 'По умолчанию: UK';
$_['help_geo_zone'] = 'Географическая зона';
$_['help_status'] = 'Включить метод оплаты';
$_['help_sort_order'] = 'Позиция GercPay в списке методов оплаты';

// Error
$_['error_permission'] = 'У вас недостаточно прав для изменения настроек этого модуля';
$_['error_merchant'] = 'Идентификатор торговца не верен';
$_['error_secretkey'] = 'Секретный ключ пуст';
$_['error_currency'] = 'Укажите валюту торговца';
$_['error_order_status'] = 'Укажите статус заказа после успешной оплаты';
$_['error_order_reverse_status'] = 'Укажите статус заказа после возврата оплаты';
$_['error_approve_url'] = 'Обязателен URL перенаправления после успешной оплаты';
$_['error_decline_url'] = 'Обязателен URL перенаправления после неуспешной оплаты';
$_['error_cancel_url'] = 'Обязателен URL перенаправления после отмены платежа';
$_['error_callback_url'] = 'Обязателен URL для информации об оплате';

$_['error_warning'] = 'Предупреждение: внимательно проверьте форму на наличие ошибок';
$_['default_placeholder'] = '-- Не выбрано --';
?>