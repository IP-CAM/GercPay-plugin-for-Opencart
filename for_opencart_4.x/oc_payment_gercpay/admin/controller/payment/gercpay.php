<?php

namespace Opencart\Admin\Controller\Extension\OcPaymentGercpay\Payment;

/**
 * Class Gercpay
 */
class Gercpay extends \Opencart\System\Engine\Controller
{
    /**
     * @var array
     */
    private $error = array();

    /**
     * @var string[]
     */
    protected $allowed_payment_page_locales;

    /**
     * Gercpay constructor.
     *
     * @param $registry
     */
    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->allowed_payment_page_locales = array('ua', 'ru', 'en');
    }

    /**
     * Shows plugin settings page.
     *
     * @throws \Exception
     */
    public function index()
    {
        $this->load->language('extension/oc_payment_gercpay/payment/gercpay');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        $this->setTranslations($data);
        $this->setErrors($data);
        $this->setBreadcrumbs($data);

        $this->setLinks($data);
        $this->setOrderStatuses($data);
        $this->setSettings($data);
        $this->setGeoZones($data);

        $data['allowed_payment_page_locales'] = $this->allowed_payment_page_locales;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/oc_payment_gercpay/payment/gercpay', $data));
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function save(): void
    {
        $this->load->language('extension/oc_payment_gercpay/payment/gercpay');

        $json = [];

        if (!$this->user->hasPermission('modify', 'extension/oc_payment_gercpay/payment/gercpay')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if (!$json) {
            $this->load->model('setting/setting');

            // Update settings.
            if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {
                $this->updateSettings();
                $json['success'] = $this->language->get('text_success');
            } else {
                foreach ($this->error as $code => $error) {
                    $json['error'][$code] = $error;
                }
            }
        }

        if (isset($json['error']) && !isset($json['error']['warning'])) {
            $json['error']['warning'] = $this->language->get('error_warning');
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * @return bool
     */
    private function validate()
    {
        if (! $this->request->post['payment_gercpay_merchant']) {
            $this->error['payment_gercpay_merchant'] = $this->language->get('error_merchant');
        }

        if (! $this->request->post['payment_gercpay_secretkey']) {
            $this->error['payment_gercpay_secretkey'] = $this->language->get('error_secretkey');
        }

        if (! $this->request->post['payment_gercpay_order_status']) {
            $this->error['payment_gercpay_order_status'] = $this->language->get('error_order_status');
        }

        if (! $this->request->post['payment_gercpay_order_reverse_status']) {
            $this->error['payment_gercpay_order_reverse_status'] = $this->language->get('error_order_reverse_status');
        }

        return ! $this->error;
    }

    /**
     * @return void
     */
    private function updateSettings(): void
    {
        $postData = $this->request->post;
        $postData['payment_gercpay_approve_url']  = self::getBaseUrl() . '|approve';
        $postData['payment_gercpay_decline_url']  = self::getBaseUrl() . '|decline';
        $postData['payment_gercpay_cancel_url']   = self::getBaseUrl() . '|cancel';
        $postData['payment_gercpay_callback_url'] = self::getBaseUrl() . '|callback';

        $this->model_setting_setting->editSetting('payment_gercpay', $postData);
        $this->session->data['success'] = $this->language->get('text_success');

        $redirect_args = 'user_token=' . $this->session->data['user_token'] . '&type=payment';
        $this->response->redirect(
            $this->url->link('marketplace/extension', $redirect_args, true)
        );
    }

    /**
     * @return string
     */
    private static function getBaseUrl(): string
    {
        if (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])) {
            $serverUrl = 'https://' . $_SERVER['SERVER_NAME'];
        } else {
            $serverUrl = HTTP_CATALOG;
        }

        return $serverUrl . 'index.php?route=extension/oc_payment_gercpay/payment/gercpay';
    }

    /**
     * @param $data
     * @return void
     */
    private function setTranslations(&$data): void
    {
        $translations = array(
            'heading_title',
            'text_payment',
            'text_success',
            'text_pay',
            'text_card',
            'entry_merchant',
            'entry_secretkey',
            'entry_order_status',
            'entry_currency',
            'entry_approve_url',
            'entry_callback_url',
            'entry_decline_url',
            'entry_cancel_url',
            'entry_language',
            'entry_status',
            'entry_sort_order',
            'error_permission',
            'error_merchant',
            'error_secretkey',
            'error_currency',
            'error_order_status',
            'error_order_reverse_status',
            'error_approve_url',
            'error_callback_url',
            'error_decline_url',
            'error_cancel_url',
            'default_placeholder',
            'button_save',
            'button_cancel',
            'text_enabled',
            'text_disabled',
            'text_all_zones',
            'entry_geo_zone',
        );

        foreach ($translations as $translation) {
            $data[$translation] = $this->language->get($translation);
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function setErrors(&$data): void
    {
        $errors = array(
            'error_warning',
            'error_merchant',
            'error_secretkey',
            'error_currency',
            'error_order_status',
            'error_order_reverse_status',
            'error_type',
            'error_approve_url',
            'error_decline_url',
            'error_cancel_url',
            'error_callback_url',
        );

        foreach ($errors as $error) {
            $data[$error] = $this->error[$error] ?? '';
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function setBreadcrumbs(&$data): void
    {
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link(
                'common/dashboard',
                'user_token=' . $this->session->data['user_token'],
                true
            ),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link(
                'marketplace/extension',
                'user_token=' . $this->session->data['user_token'] . '&type=payment',
                true
            ),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link(
                'extension/oc_payment_gercpay/payment/gercpay',
                'user_token=' . $this->session->data['user_token'],
                true
            ),
            'separator' => ' :: '
        );
    }

    /**
     * @param $data
     * @return void
     */
    private function setLinks(&$data): void
    {
        $data['save'] = $this->url->link(
            'extension/oc_payment_gercpay/payment/gercpay|save',
            'user_token=' . $this->session->data['user_token'],
            true
        );
        $data['cancel'] = $this->url->link(
            'marketplace/extension',
            'user_token=' . $this->session->data['user_token'] . '&type=payment',
            true
        );
    }

    /**
     * @param $data
     * @return void
     * @throws \Exception
     */
    private function setOrderStatuses(&$data): void
    {
        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
    }

    /**
     * @param $data
     * @return void
     */
    private function setSettings(&$data): void
    {
        $settings = array(
            'payment_gercpay_status',
            'payment_gercpay_merchant',
            'payment_gercpay_secretkey',
            'payment_gercpay_language',
            'payment_gercpay_order_status',
            'payment_gercpay_order_reverse_status',
            'payment_gercpay_sort_order',
        );

        foreach ($settings as $setting) {
            $data[$setting] = $this->request->post[$setting] ?? $this->config->get($setting);
        }
    }

    /**
     * @param $data
     * @return void
     * @throws \Exception
     */
    private function setGeoZones(&$data): void
    {
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        if (isset($this->request->post['payment_gercpay_geo_zone_id'])) {
            $data['payment_gercpay_geo_zone_id'] = $this->request->post['payment_gercpay_geo_zone_id'];
        } else {
            $data['payment_gercpay_geo_zone_id'] = $this->config->get('payment_gercpay_geo_zone_id');
        }

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
    }
}
