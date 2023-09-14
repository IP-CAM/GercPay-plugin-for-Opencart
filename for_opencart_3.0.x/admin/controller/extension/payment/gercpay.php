<?php

/**
 * Class ControllerExtensionPaymentGercpay
 *
 * @property Loader $load
 * @property Document $document
 * @property Request $request
 * @property ModelSettingSetting $model_setting_setting
 * @property Session $session
 * @property Response $response
 * @property Language $language
 * @property Url $url
 * @property ModelLocalisationOrderStatus model_localisation_order_status
 * @property Config $config
 * @property ModelLocalisationCurrency model_localisation_currency
 * @property ModelLocalisationGeoZone model_localisation_geo_zone
 * @property Cart\User $user
 */
class ControllerExtensionPaymentGercpay extends Controller
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
     * ControllerExtensionPaymentGercpay constructor.
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
     * @throws Exception
     */
    public function index()
    {
        $this->load->language('extension/payment/gercpay');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        // Update settings.
        if (($this->request->server['REQUEST_METHOD'] === 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('payment_gercpay', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');

            $redirect_args = 'user_token=' . $this->session->data['user_token'] . '&type=payment';
            $this->response->redirect(
                $this->url->link('marketplace/extension', $redirect_args, true)
            );
        }

        // Show translated plugin settings page.
        $arr = array(
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
            'error_approve_url',
            'error_callback_url',
            'error_decline_url',
            'error_cancel_url'
        );

        foreach ($arr as $v) {
            $data[$v] = $this->language->get($v);
        }
        $data['button_save']    = $this->language->get('button_save');
        $data['button_cancel']  = $this->language->get('button_cancel');
        $data['text_enabled']   = $this->language->get('text_enabled');
        $data['text_disabled']  = $this->language->get('text_disabled');
        $data['text_all_zones'] = $this->language->get('text_all_zones');
        $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');

        $arr = array(
            'warning',
            'merchant',
            'secretkey',
            'type',
            'approve_url',
            'decline_url',
            'cancel_url',
            'callback_url',
        );

        foreach ($arr as $v) {
            $data['error_' . $v] = $this->error[$v] ?? '';
        }

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
                'extension/payment/gercpay',
                'user_token=' . $this->session->data['user_token'],
                true
            ),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link(
            'extension/payment/gercpay',
            'user_token=' . $this->session->data['user_token'],
            true
        );
        $data['cancel'] = $this->url->link(
            'marketplace/extension',
            'user_token=' . $this->session->data['user_token'] . '&type=payment',
            true
        );

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $arr = array(
            'payment_gercpay_merchant',
            'payment_gercpay_secretkey',
            'payment_gercpay_currency',
            'payment_gercpay_approve_url',
            'payment_gercpay_callback_url',
            'payment_gercpay_decline_url',
            'payment_gercpay_cancel_url',
            'payment_gercpay_language',
            'payment_gercpay_status',
            'payment_gercpay_sort_order',
            'payment_gercpay_order_status_id',
            'payment_gercpay_order_reverse_status_id',
        );

        foreach ($arr as $v) {
            $data[$v] = $this->request->post[$v] ?? $this->config->get($v);
            if (defined('HTTP_CATALOG') &&
                defined('HTTPS_CATALOG') &&
                ! isset($this->request->post[$v]) &&
                empty($data[$v])
            ) {
                if ($v === 'payment_gercpay_approve_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=extension/payment/gercpay/approve';
                } elseif ($v === 'payment_gercpay_decline_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=extension/payment/gercpay/decline';
                } elseif ($v === 'payment_gercpay_cancel_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=extension/payment/gercpay/cancel';
                } elseif ($v === 'payment_gercpay_callback_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                    'index.php?route=extension/payment/gercpay/callback';
                }
            }
        }
        $data['text_all_zones'] = $this->language->get('text_all_zones');

        if (isset($this->request->post['payment_gercpay_geo_zone_id'])) {
            $data['payment_gercpay_geo_zone_id'] = $this->request->post['payment_gercpay_geo_zone_id'];
        } else {
            $data['payment_gercpay_geo_zone_id'] = $this->config->get('payment_gercpay_geo_zone_id');
        }

        $this->load->model('localisation/currency');
        $data['currencies'] = array();
        $results = $this->model_localisation_currency->getCurrencies();
        foreach ($results as $result) {
            if ($result['status']) {
                $data['currencies'][] = array(
                    'title'        => $result['title'],
                    'code'         => $result['code'],
                    'symbol_left'  => $result['symbol_left'],
                    'symbol_right' => $result['symbol_right']
                );
            }
        }

        $data['allowed_payment_page_locales'] = $this->allowed_payment_page_locales;

        $this->load->model('localisation/geo_zone');
        $data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('extension/payment/gercpay', $data));
    }

    /**
     * @return bool
     */
    private function validate()
    {
        if (! $this->user->hasPermission('modify', 'extension/payment/gercpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (! $this->request->post['payment_gercpay_merchant']) {
            $this->error['merchant'] = $this->language->get('error_merchant');
        }

        if (! $this->request->post['payment_gercpay_secretkey']) {
            $this->error['secretkey'] = $this->language->get('error_secretkey');
        }

        if (! $this->request->post['payment_gercpay_approve_url']) {
            $this->error['approve_url'] = $this->language->get('error_approve_url');
        }

        if (! $this->request->post['payment_gercpay_decline_url']) {
            $this->error['decline_url'] = $this->language->get('error_decline_url');
        }

        if (! $this->request->post['payment_gercpay_cancel_url']) {
            $this->error['cancel_url'] = $this->language->get('error_cancel_url');
        }

        if (! $this->request->post['payment_gercpay_callback_url']) {
            $this->error['callback_url'] = $this->language->get('error_callback_url');
        }

        return ! $this->error;
    }
}
