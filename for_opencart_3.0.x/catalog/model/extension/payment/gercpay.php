<?php

/**
 * Class ModelExtensionPaymentGercpay
 *
 * @property DB $db
 * @property Config $config
 * @property Loader $load
 * @property Language $language
 */
class ModelExtensionPaymentGercpay extends Model
{
    /**
     * @param $address
     * @param $total
     * @return array
     */
    public function getMethod($address, $total)
    {
        $this->load->language('extension/payment/gercpay');
        $geo_zone_id = (int)$this->config->get('payment_gercpay_geo_zone_id');
        $query = $this->db->query(
            "SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . $geo_zone_id . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );

        $gercpay_total = $this->config->get('payment_gercpay_total');
        if ($gercpay_total > 0 && $gercpay_total > $total) {
            $status = false;
        } elseif (!$this->config->get('payment_gercpay_geo_zone_id')) {
            $status = true;
        } elseif ($query->num_rows) {
            $status = true;
        } else {
            $status = false;
        }

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code' => 'gercpay',
                'title' => $this->language->get('text_title'),
                'terms' => '',
                'sort_order' => $this->config->get('payment_gercpay_sort_order')
            );
        }

        return $method_data;
    }
}
