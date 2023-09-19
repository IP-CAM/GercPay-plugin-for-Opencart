<?php
// Heading
$_['heading_title'] = 'GercPay';

// Text
$_['text_edit'] = 'Налаштування модуля';
$_['text_extension'] = 'Модулі / Розширення';
$_['text_payment'] = 'Оплата';
$_['text_gercpay'] = '<a href="https://gercpay.com.ua" target="_blank" style="background: url(/image/payment/gercpay.svg) 0 0/auto 100% no-repeat !important;"><img src="/image/payment/gercpay.png" alt="GercPay" title="GercPay"></a>';
$_['text_success'] = 'Налаштування модуля оновлені';
$_['text_pay'] = 'GercPay';
$_['text_card'] = 'Кредитна картка';
$_['text_all_zones'] = 'Всі зони';

// Entry
$_['entry_merchant'] = 'Ідентифікатор торговця';
$_['entry_secretkey'] = 'Секретний ключ';
$_['entry_order_status'] = 'Статус замовлення після успішної оплати';
$_['entry_order_reverse_status'] = 'Статус замовлення після повернення оплати';
$_['entry_currency'] = 'Валюта';
$_['entry_approve_url'] = 'URL перенаправлення після успішної оплати';
$_['entry_decline_url'] = 'URL перенаправлення після неуспішної оплати';
$_['entry_cancel_url'] = 'URL перенаправлення після скасування оплати';
$_['entry_callback_url'] = 'URL для інформації про оплату';
$_['entry_language'] = 'Мова сторінки оплати';
$_['entry_geo_zone'] = 'Географічна зона';
$_['entry_status'] = 'Стан методу оплати';
$_['entry_sort_order'] = 'Порядок сортування';

// Help
$_['help_merchant'] = 'Надається торговцеві системою GercPay';
$_['help_secretkey'] = 'Надається торговцеві системою GercPay';
$_['help_order_status'] = '';
$_['help_order_reverse_status'] = '';
$_['help_currency'] = 'Валюта торговця';
$_['help_approve_url'] = 'Якщо не вказано: https://{your_site}/index.php?route=extension/payment/gercpay/approve';
$_['help_decline_url'] = 'За замовчуванням: https://{your_site}/index.php?route=extension/payment/gercpay/decline';
$_['help_cancel_url'] = 'За замовчуванням: https://{your_site}/index.php?route=extension/payment/gercpay/cancel';
$_['help_callback_url'] = 'За замовчуванням: https://{your_site}/index.php?route=extension/payment/gercpay/callback';
$_['help_language'] = 'За замовчуванням: UK';
$_['help_geo_zone'] = 'Географічна зона';
$_['help_status'] = 'Увімкнути метод оплати';
$_['help_sort_order'] = 'Позиція GercPay в списку методів оплати';

// Error
$_['error_permission'] = 'Вам бракує прав для зміни налаштувань цього модуля';
$_['error_merchant'] = 'Ідентифікатор торговця не вірний';
$_['error_secretkey'] = 'Секретний ключ порожній';
$_['error_currency'] = 'Вкажіть валюту торговця';
$_['error_order_status'] = 'Вкажіть статус замовлення після успішної оплати';
$_['error_order_reverse_status'] = 'Вкажіть статус замовлення після повернення оплати';
$_['error_approve_url'] = 'Обов\'язковий URL перенаправлення після успішної оплати';
$_['error_decline_url'] = 'Обов\'язковий URL перенаправлення після неуспішної оплати';
$_['error_cancel_url'] = 'Обов\'язковий URL перенаправлення після скасування оплати';
$_['error_callback_url'] = 'Обов\'язковий URL для інформації про оплату';

$_['error_warning'] = 'Попередження: уважно перевірте форму на наявність помилок';
$_['default_placeholder'] = '-- Не вибрано --';
?>