<?php

namespace Opencart\Catalog\Controller\Extension\OcPaymentGercpay\Payment;

/**
 * Class Gercpay
 */
class Gercpay extends \Opencart\System\Engine\Controller
{
    const OPENCART_VERSION_2 = 200;

    /**
     * @var string[]
     */
    public $codes_currency = array(
        980 => 'UAH',
    );

    /**
     * Shows checkout page.
     *
     * @return string
     * @throws \Exception
     */
    public function index() : string
    {
        $this->language->load('extension/oc_payment_gercpay/payment/gercpay');
        $this->load->model('checkout/order');

        $fields = $this->generateFields();

        $data['action'] = GercpayApi::URL;
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['fields'] = $fields;
        $data['text_loading'] = 'loading';
        $data['order_id'] = $this->session->data['order_id'];
        $data['language'] = $this->config->get('config_language');

        return $this->load->view('extension/oc_payment_gercpay/payment/gercpay', $data);
    }

    /**
     * Generate payment form fields.
     *
     * @return array
     * @throws \Exception
     */
    public function generateFields()
    {
        $gercpay = new GercpayApi();
        $secret_key = $this->config->get('payment_gercpay_secretkey');
        $gercpay->setSecretKey($secret_key);

        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $approve_url  = $this->config->get('payment_gercpay_approve_url');
        $decline_url  = $this->config->get('payment_gercpay_decline_url');
        $cancel_url   = $this->config->get('payment_gercpay_cancel_url');
        $callback_url = $this->config->get('payment_gercpay_callback_url');
        $language     = $this->config->get('payment_gercpay_language');

        $currency = $this->codes_currency[$order['currency_code']] ?? $order['currency_code'];
        $amount = round(($order['total'] * $order['currency_value']), 2);

        $firstName = trim($order['firstname']) ?? trim($order['payment_firstname']) ?? trim($order['shipping_firstname']) ?? '';
        $lastName  = trim($order['lastname']) ?? trim($order['payment_lastname']) ?? trim($order['shipping_lastname']) ?? '';
        $email = $order['email'] ?? '';
        $phone = $order['telephone'] ?? '';

        $description = $this->language->get('text_payment_by_card') . ' ' . rtrim($this->config->get('config_url'), '/');
        if (!empty($firstName) || !empty($lastName)) {
            $description .= ", $firstName $lastName";
        }
        if (!empty($phone)) {
            $description .= ", $phone";
        }

        $fields = array(
            'operation'    => 'Purchase',
            'merchant_id'  => $this->config->get('payment_gercpay_merchant'),
            'amount'       => $amount,
            'order_id'     => $order['order_id'],
            'currency_iso' => $currency,
            'description'  => $description,
            'add_params'   => [],
            'approve_url'  => $approve_url,
            'decline_url'  => $decline_url,
            'cancel_url'   => $cancel_url,
            'callback_url' => $callback_url,
            'language'     => $language,
            // Statistics.
            'client_last_name'  => $lastName,
            'client_first_name' => $firstName,
            'email'             => $email,
            'phone'             => $phone
        );

        $this->load->model('account/order');

        $fields['signature'] = $gercpay->getRequestSignature($fields);

        return $fields;
    }

    /**
     * User confirmation of order.
     * Sets the default status for the order (by store config).
     */
    public function confirm(): void
    {
        if ($this->session->data['payment_method']['code'] === 'gercpay') {
            $this->load->model('checkout/order');

            $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
            if (! $order_info) {
                return;
            }

            $order_id = $this->session->data['order_id'];

            if ((int)$order_info['order_status_id'] === 0) {
                $this->model_checkout_order->addOrderHistory(
                    $order_id,
                    $this->config->get('config_order_status_id'),
                    'GercPay'
                );
            }
        }
    }

    /**
     * Shows approve payment page ('Thank you page').
     * The method clears the shopping cart!
     */
    public function approve()
    {
        $this->response->redirect($this->url->link('checkout/success', '', 'SSL'));
    }

    /**
     * Shows decline payment page.
     */
    public function decline()
    {
        $this->response->redirect($this->url->link('checkout/failure', '', 'SSL'));
    }

    /**
     * On cancel payment - return to checkout page.
     */
    public function cancel()
    {
        $this->response->redirect($this->url->link('checkout/checkout', '', 'SSL'));
    }

    /**
     * Processes the server response with payment results.
     *
     * @throws \Exception
     */
    public function callback()
    {
        $raw_data = json_decode(file_get_contents("php://input"), true);
        $data = array_map('htmlspecialchars', $raw_data);

        $gercpay = new GercpayApi();
        $key = $this->config->get('payment_gercpay_secretkey');
        $gercpay->setSecretKey($key);

        $payment_info = $gercpay->isPaymentValid($data);

        if ($payment_info === true) {
            // Transaction approved.
            $order_id = $data['orderReference'];
            $this->load->model('checkout/order');
                        
            if ($data['type'] === GercpayApi::RESPONSE_TYPE_PAYMENT) {
                $this->model_checkout_order->addHistory(
                    $order_id,
                    (int) $this->config->get('payment_gercpay_order_status'),
                    'GercPay',
                    true
                );
            } elseif ($data['type'] === GercpayApi::RESPONSE_TYPE_REVERSE) {
                $this->model_checkout_order->addHistory(
                    $order_id,
                    (int) $this->config->get('payment_gercpay_order_reverse_status'),
                    'GercPay',
                    true
                );
            }
        } else {
            // Transaction declined or canceled.
            echo $payment_info;
        }
        exit();
    }

    /**
     * Returns OpenCart version.
     *
     * @return float
     */
    protected function getOpencartVersion()
    {
        $oc_version = explode('.', VERSION);

        return (float)(
            $oc_version[0] . $oc_version[1] . $oc_version[2] . '.' . ($oc_version[3] ?? 0)
        );
    }
}
