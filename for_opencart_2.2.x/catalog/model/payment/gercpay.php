<?php

/**
 * Class ModelPaymentGercpay
 *
 * @property Loader $load
 * @property Language $language
 * @property Config $config
 */
class ModelPaymentGercpay extends Model
{
    /**
     * @param $address
     * @param $total
     * @return array
     */
    public function getMethod($address, $total)
    {
        $this->load->language('payment/gercpay');

        $method_data = array(
            'code' => 'gercpay',
            'title' => $this->language->get('text_title'),
            'sort_order' => $this->config->get('gercpay_sort_order'),
            'terms' => ''
        );

        return $method_data;
    }
}
