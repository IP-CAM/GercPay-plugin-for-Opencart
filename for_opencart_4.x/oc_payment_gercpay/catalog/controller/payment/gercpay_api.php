<?php

namespace Opencart\Catalog\Controller\Extension\OcPaymentGercpay\Payment;

/**
 * Class GercpayApi
 */
class GercpayApi
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

    const URL = "https://api.gercpay.com.ua/api/";

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
