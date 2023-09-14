<?php
// Heading
$_['heading_title'] = 'GercPay';

// Text
$_['text_payment'] = 'Оплата';
$_['text_gercpay'] = '<a href="https://gercpay.com.ua" target="_blank" style="background: url(view/image/payment/gercpay.svg) 0 0 no-repeat !important;"><img src="view/image/payment/gercpay.png" alt="GercPay" title="GercPay"></a>';
$_['text_success'] = 'Настройки модуля обновлены!';
$_['text_pay'] = 'GercPay';
$_['text_card'] = 'Кредитная карта';

// Entry
$_['entry_merchant'] = 'Идентификатор торговца';
$_['entry_secretkey'] = 'Секретный ключ';
$_['entry_order_status'] = 'Статус заказа после успешной оплаты';
$_['entry_order_reverse_status'] = 'Статус заказа после возврата платежа';
$_['entry_currency'] = 'Валюта';
$_['entry_approve_url'] = 'URL перенаправления при успешном платеже';
$_['entry_decline_url'] = 'URL перенаправления при неудачном платеже';
$_['entry_cancel_url'] = 'URL перенаправления при отмене платежа';
$_['entry_callback_url'] = 'URL для информации об оплате';
$_['entry_language'] = 'Язык страницы оплаты';
$_['entry_status'] = 'Статус метода оплаты';
$_['entry_sort_order'] = 'Порядок сортировки';

// Help
$_['help_merchant'] = 'Выдаётся торговцу системой GercPay';
$_['help_secretkey'] = 'Выдаётся торговцу системой GercPay';
$_['help_order_status'] = 'Статус заказа по умолчанию после успешного платежа.';
$_['help_order_reverse_status'] = 'Статус заказа по умолчанию после возврата платежа.';
$_['help_currency'] = 'Валюта торговца';
$_['help_approve_url'] = 'По умолчанию: http://{YOUR_SITE}/index.php?route=payment/gercpay/approve';
$_['help_decline_url'] = 'По умолчанию: http://{YOUR_SITE}/index.php?route=payment/gercpay/decline';
$_['help_cancel_url'] = 'По умолчанию: http://{YOUR_SITE}/index.php?route=payment/gercpay/cancel';
$_['help_callback_url'] = 'По умолчанию: http://{YOUR_SITE}/index.php?route=payment/gercpay/callback';
$_['help_language'] = 'По умолчанию: RU';
$_['help_geo_zone'] = 'Географическая зона';
$_['help_status'] = 'Статус метода оплаты';
$_['help_sort_order'] = 'Позиция GercPay в списке методов оплаты';

// Error
$_['error_permission'] = 'У Вас нет прав для управления этим модулем!';
$_['error_merchant'] = 'Идентификатор торговца не верен!';
$_['error_secretkey'] = 'Секретный ключ пуст!';
?>
