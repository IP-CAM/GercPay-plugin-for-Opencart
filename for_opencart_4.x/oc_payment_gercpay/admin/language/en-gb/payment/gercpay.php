<?php
// Heading
$_['heading_title'] = 'GercPay';

// Text
$_['text_edit'] = 'Module settings';
$_['text_payment'] = 'Payment';
$_['text_gercpay'] = '<a href="https://gercpay.com.ua" target="_blank" style="background: url(/image/payment/gercpay.svg) 0 0/auto 100% no-repeat !important;"><img src="/image/payment/gercpay.png" alt="GercPay" title="GercPay"></a>';
$_['text_success'] = 'Settings updated';
$_['text_pay'] = 'GercPay';
$_['text_card'] = 'Credit Card';
$_['text_all_zones'] = 'All Zones';

// Entry
$_['entry_merchant'] = 'Merchant Account';
$_['entry_secretkey'] = 'Secret key';
$_['entry_order_status'] = 'Order status after payment';
$_['entry_order_reverse_status'] = 'Order status after refunded payment';
$_['entry_currency'] = 'Currency';
$_['entry_approve_url'] = 'Redirect URL on successful payment';
$_['entry_decline_url'] = 'Redirect URL on failed payment';
$_['entry_cancel_url'] = 'Redirect URL on canceled payment';
$_['entry_callback_url'] = 'URL of the result information';
$_['entry_language'] = 'Payment page language';
$_['entry_geo_zone'] = 'Geo Zone';
$_['entry_status'] = 'Payment method state';
$_['entry_sort_order'] = 'Ordering';

// Help
$_['help_merchant'] = 'Given to Merchant by GercPay';
$_['help_secretkey'] = 'Given to Merchant by GercPay';
$_['help_order_status'] = '';
$_['help_order_reverse_status'] = '';
$_['help_currency'] = 'Merchant currency';
$_['help_approve_url'] = 'Default: https://{your_site}/index.php?route=extension/payment/gercpay/approve';
$_['help_decline_url'] = 'Default: https://{your_site}/index.php?route=extension/payment/gercpay/decline';
$_['help_cancel_url'] = 'Default: https://{your_site}/index.php?route=extension/payment/gercpay/cancel';
$_['help_callback_url'] = 'Default: https://{your_site}/index.php?route=extension/payment/gercpay/callback';
$_['help_language'] = 'Default: UK';
$_['help_geo_zone'] = 'Geo Zone';
$_['help_status'] = 'Enable payment method';
$_['help_sort_order'] = 'GercPay position in the list of payment methods';

// Error
$_['error_permission'] = "You haven't permission to change this module settings";
$_['error_merchant'] = 'Merchant Account is incorrect';
$_['error_secretkey'] = 'Secret key is empty';
$_['error_currency'] = 'Required merchant currency';
$_['error_order_status'] = 'Required order status after successful payment';
$_['error_order_reverse_status'] = 'Required order status after refund payment';
$_['error_approve_url'] = 'Required successful payment URL';
$_['error_decline_url'] = 'Required declined payment URL';
$_['error_cancel_url'] = 'Required canceled payment URL';
$_['error_callback_url'] = 'Required result information URL';

$_['error_warning'] = 'Warning: Please check the form carefully for errors';
$_['default_placeholder'] = '-- Not selected --';
?>