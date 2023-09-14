<?php
// Heading
$_['heading_title'] = 'GercPay';

// Text
$_['text_extension'] = 'Модулі / Розширення';
$_['text_payment'] = 'Оплата';
$_['text_gercpay'] = '<a href="https://gercpay.com.ua" target="_blank" style="background: url(view/image/payment/gercpay.svg) 0 0 no-repeat !important;"><img src="view/image/payment/gercpay.png" alt="GercPay" title="GercPay"></a>';
$_['text_success'] = 'Налаштування модуля оновлені!';
$_['text_pay'] = 'GercPay';
$_['text_card'] = 'Кредитна картка';
$_['text_all_zones'] = 'Всі зони';
$_['text_disabled'] = 'Вимкнено';
$_['text_enabled'] = 'Увімкнено';

// Entry
$_['entry_merchant'] = 'Ідентифікатор торговця';
$_['entry_secretkey'] = 'Секретний ключ';
$_['entry_order_status'] = 'Статус замовлення після оплати';
$_['entry_order_reverse_status'] = 'Статус замовлення після повернення платежу';
$_['entry_currency'] = 'Валюта';
$_['entry_approve_url'] = 'URL перенаправлення при успішному платежі';
$_['entry_decline_url'] = 'URL перенаправлення при невдалому платежі';
$_['entry_cancel_url'] = 'URL перенаправлення при скасуванні платежу';
$_['entry_callback_url'] = 'URL для інформації про оплату';
$_['entry_language'] = 'Мова сторінки оплати';
$_['entry_geo_zone'] = 'Географічна зона';
$_['entry_status'] = 'Статус методу оплати';
$_['entry_sort_order'] = 'Порядок сортування';

// Help
$_['help_merchant'] = 'Надається торговцеві системою GercPay';
$_['help_secretkey'] = 'Надається торговцеві системою GercPay';
$_['help_order_status'] = 'Статус замовлення за замовчуванням після успішного платежу.';
$_['help_order_reverse_status'] = 'Статус замовлення за замовчуванням після повернення платежу.';
$_['help_currency'] = 'Валюта торговця';
$_['help_approve_url'] = 'За замовчуванням: http://{YOUR_SITE}/index.php?route=payment/gercpay/approve';
$_['help_decline_url'] = 'За замовчуванням: http://{YOUR_SITE}/index.php?route=payment/gercpay/decline';
$_['help_cancel_url'] = 'За замовчуванням: http://{YOUR_SITE}/index.php?route=payment/gercpay/cancel';
$_['help_callback_url'] = 'За замовчуванням: http://{YOUR_SITE}/index.php?route=payment/gercpay/callback';
$_['help_language'] = 'За замовчуванням: RU';
$_['help_geo_zone'] = 'Географічна зона';
$_['help_status'] = 'Статус методу оплати';
$_['help_sort_order'] = 'Позиція GercPay в списку методів оплати';

// Error
$_['error_permission'] = 'Ви не маєте прав для управління цим модулем!';
$_['error_merchant'] = 'Ідентифікатор торговця хибний!';
$_['error_secretkey'] = 'Секретний ключ порожній!';
$_['error_approve_url'] = 'Обов\'язковий URL перенаправлення при успішному платежі!';
$_['error_decline_url'] = 'Обов\'язковий URL перенаправлення при невдалому платежі!';
$_['error_cancel_url'] = 'Обов\'язковий URL перенаправлення при скасуванні платежу!';
$_['error_callback_url'] = 'Обов\'язковий URL для інформації про оплату!';
?>