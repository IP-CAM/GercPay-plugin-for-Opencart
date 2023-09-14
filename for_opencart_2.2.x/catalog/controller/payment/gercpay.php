<?php

/**
 * Class ControllerPaymentGercpay
 *
 * @property ModelCheckoutOrder $model_checkout_order
 * @property Config $config
 * @property Session $session
 * @property Loader $load
 * @property Url $url
 * @property Response $response
 * @property Language $language
 * @property Cart\Cart $cart
 * @property Cart\Customer $customer
 * @property ModelAccountActivity $model_account_activity
 */
class ControllerPaymentGercpay extends Controller
{
    const OPENCART_VERSION_2 = 200;

    /**
     * @var string[]
     */
    public $codes_currency = [
        980 => 'UAH',
    ];

    /**
     * Shows checkout page.
     *
     * @return string
     * @throws Exception
     */
    public function index()
    {
        $gercpay = new Gercpay();
        $secret_key = $this->config->get('gercpay_secretkey');
        $gercpay->setSecretKey($secret_key);

        $this->load->language('payment/gercpay');
        $this->load->model('checkout/order');
        $order = $this->model_checkout_order->getOrder($this->session->data['order_id']);

        $approve_url  = $this->config->get('gercpay_approve_url');
        $decline_url  = $this->config->get('gercpay_decline_url');
        $cancel_url   = $this->config->get('gercpay_cancel_url');
        $callback_url = $this->config->get('gercpay_callback_url');
        $language     = $this->config->get('gercpay_language');

        $currency = $this->codes_currency[$order['currency_code']] ?? $order['currency_code'];
        $amount = round(($order['total'] * $order['currency_value']), 2);

        $description = $this->language->get('text_payment_by_card') . ' ' .
            rtrim($this->config->get('config_url'), '/') . ', ' . $order['payment_firstname'] . ' ' .
            $order['payment_lastname'] . ', ' . $order['telephone'] . '.';

        $fields = array(
            'operation'    => 'Purchase',
            'merchant_id'  => $this->config->get('gercpay_merchant'),
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
            'client_last_name'  => $order['payment_lastname'] ?? '',
            'client_first_name' => $order['payment_firstname'] ?? '',
            'email'             => $order['email'] ?? '',
            'phone'             => $order['telephone'] ?? ''
        );

        $fields['signature'] = $gercpay->getRequestSignature($fields);

        $data['fields']         = $fields;
        $data['action']         = Gercpay::URL;
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['text_loading']   = 'loading';
        $data['continue']       = $this->url->link('checkout/success');

        return $this->load->view('payment/gercpay.tpl', $data);
    }

    /**
     * User confirmation of order.
     * Sets the default status for the order (by store config).
     */
    public function confirm()
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
     * @throws Exception
     */
    public function callback()
    {
        $raw_data = json_decode(file_get_contents("php://input"), true);
        $data = filter_var_array($raw_data, FILTER_SANITIZE_STRING);

        $gercpay = new GercPay();
        $key = $this->config->get('gercpay_secretkey');
        $gercpay->setSecretKey($key);

        $payment_info = $gercpay->isPaymentValid($data);

        if ($payment_info === true) {
            // Transaction approved.
            $order_id = $data['orderReference'];
            $this->load->model('checkout/order');

            if ($data['type'] === GercPay::RESPONSE_TYPE_PAYMENT) {
                $this->model_checkout_order->addOrderHistory(
                    $order_id,
                    $this->config->get('gercpay_order_status_id'),
                    'GercPay',
                    true
                );
            } elseif ($data['type'] === GercPay::RESPONSE_TYPE_REVERSE) {
                $this->model_checkout_order->addOrderHistory(
                    $order_id,
                    $this->config->get('gercpay_order_reverse_status_id'),
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

/**
 * Class Gercpay
 */
class Gercpay
{
    const ORDER_NEW                   = 'New';
    const ORDER_DECLINED              = 'Declined';
    const ORDER_REFUND_IN_PROCESSING  = 'RefundInProcessing';
    const ORDER_REFUNDED              = 'Refunded';
    const ORDER_EXPIRED               = 'Expired';
    const ORDER_PENDING               = 'Pending';
    const ORDER_APPROVED              = 'Approved';
    const ORDER_WAITING_AUTH_COMPLETE = 'WaitingAuthComplete';
    const ORDER_IN_PROCESSING         = 'InProcessing';
    const ORDER_SEPARATOR             = '#';
    const RESPONSE_TYPE_PAYMENT       = 'payment';
    const RESPONSE_TYPE_REVERSE       = 'reverse';

    const SIGNATURE_SEPARATOR = ';';

    const URL = "https://api.gercpay.com.ua/";

    /**
     * @var string
     */
    protected $secret_key = '';

    /**
     * @var string[]
     */
    protected $keys_for_response = array(
        'merchantAccount',
        'orderReference',
        'amount',
        'currency'
    );

    /**
     * @var string[]
     */
    protected $keys_for_request = array(
        'merchant_id',
        'order_id',
        'amount',
        'currency_iso',
        'description'
    );

    /**
     * @param $option
     * @param $keys
     *
     * @return string
     */
    public function getSignature($option, $keys)
    {
        $hash = array();
        foreach ($keys as $data_key) {
            if (!isset($option[$data_key])) {
                $option[$data_key] = '';
            }
            if (is_array($option[$data_key])) {
                foreach ($option[$data_key] as $v) {
                    $hash[] = $v;
                }
            } else {
                $hash [] = $option[$data_key];
            }
        }

        $hash = implode(self::SIGNATURE_SEPARATOR, $hash);

        return hash_hmac('md5', $hash, $this->getSecretKey());
    }

    /**
     * @param $options
     *
     * @return string
     */
    public function getRequestSignature($options)
    {
        return $this->getSignature($options, $this->keys_for_request);
    }

    /**
     * @param $options
     *
     * @return string
     */
    public function getResponseSignature($options)
    {
        return $this->getSignature($options, $this->keys_for_response);
    }

    /**
     * @param $response
     *
     * @return bool|string
     */
    public function isPaymentValid($response)
    {
        $sign = $this->getResponseSignature($response);
        if ($sign !== $response['merchantSignature']) {
            return $sign;
        }

        if ($response['transactionStatus'] === self::ORDER_APPROVED) {
            return true;
        }

        return false;
    }

    /**
     * @param $key
     */
    public function setSecretKey($key)
    {
        $this->secret_key = $key;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secret_key;
    }
}
