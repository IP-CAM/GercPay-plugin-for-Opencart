<?php

/**
 * Class ControllerPaymentGercpay
 *
 * @property Loader $load
 * @property Document $document
 * @property Request $request
 * @property ModelSettingSetting $model_setting_setting
 * @property Session $session
 * @property Response $response
 * @property Language $language
 * @property Config $config
 * @property Url $url
 * @property ModelLocalisationOrderStatus $model_localisation_order_status
 * @property ModelLocalisationCurrency $model_localisation_currency
 * @property User $user
 * @property Error $error
 */
class ControllerPaymentGercpay extends Controller
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
     * ControllerPaymentGercpay constructor.
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
        $this->load->language('payment/gercpay');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('setting/setting');

        // Update settings.
        if ($this->request->server['REQUEST_METHOD'] === 'POST' && $this->validate()) {
            $this->model_setting_setting->editSetting('gercpay', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect(
                $this->url->link(
                    'extension/payment',
                    'token=' . $this->session->data['token'],
                    'SSL'
                )
            );
        }

        // Show translated plugin settings page.
        $arr = array(
            'heading_title',
            'text_payment',
            'text_success',
            'text_pay',
            'text_card',
            'text_disabled',
            'text_enabled',
            'entry_merchant',
            'entry_secretkey',
            'entry_order_status',
            'entry_order_reverse_status',
            'entry_currency',
            'entry_approve_url',
            'entry_decline_url',
            'entry_cancel_url',
            'entry_callback_url',
            'entry_language',
            'entry_status',
            'entry_sort_order',
            'error_permission',
            'error_merchant',
            'error_secretkey',
            'help_status',
            'help_merchant',
            'help_secretkey',
            'help_order_status',
            'help_order_reverse_status',
            'help_approve_url',
            'help_decline_url',
            'help_cancel_url',
            'help_callback_url',
            'help_sort_order',
            'help_language',
        );

        foreach ($arr as $v) {
            $data[$v] = $this->language->get($v);
        }
        $data['button_save']   = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['text_enabled']  = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

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
                'common/home',
                'token=' . $this->session->data['token'],
                'SSL'
            ),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_payment'),
            'href' => $this->url->link(
                'extension/payment',
                'token=' . $this->session->data['token'],
                'SSL'
            ),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link(
                'payment/gercpay',
                'token=' . $this->session->data['token'],
                'SSL'
            ),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link(
            'payment/gercpay',
            'token=' . $this->session->data['token'],
            'SSL'
        );
        $data['cancel'] = $this->url->link(
            'extension/payment',
            'token=' . $this->session->data['token'],
            'SSL'
        );

        $this->load->model('localisation/order_status');

        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $arr = array(
            'gercpay_merchant',
            'gercpay_secretkey',
            'gercpay_currency',
            'gercpay_approve_url',
            'gercpay_callback_url',
            'gercpay_decline_url',
            'gercpay_cancel_url',
            'gercpay_language',
            'gercpay_status',
            'gercpay_sort_order',
            'gercpay_order_status_id',
            'gercpay_order_reverse_status_id',
        );

        foreach ($arr as $v) {
            $data[$v] = $this->request->post[$v] ?? $this->config->get($v);
            if (defined('HTTP_CATALOG') &&
                defined('HTTPS_CATALOG') &&
                ! isset($this->request->post[$v]) &&
                empty($data[$v])
            ) {
                if ($v === 'gercpay_approve_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=payment/gercpay/approve';
                } elseif ($v === 'gercpay_decline_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=payment/gercpay/decline';
                } elseif ($v === 'gercpay_cancel_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=payment/gercpay/cancel';
                } elseif ($v === 'gercpay_callback_url') {
                    $data[$v] = (isset($_SERVER['HTTPS']) ? HTTPS_CATALOG : HTTP_CATALOG) .
                        'index.php?route=payment/gercpay/callback';
                } elseif ($v === 'gercpay_sort_order') {
                    $data[$v] = '1';
                }
            }
        }

        $this->load->model('localisation/currency');
        $data['currencies'] = array();
        $currencies = $this->model_localisation_currency->getCurrencies();
        foreach ($currencies as $currency) {
            if ($currency['status']) {
                $data['currencies'][] = array(
                    'title'        => $currency['title'],
                    'code'         => $currency['code'],
                    'symbol_left'  => $currency['symbol_left'],
                    'symbol_right' => $currency['symbol_right']
                );
            }
        }

        $data['allowed_payment_page_locales'] = $this->allowed_payment_page_locales;

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('payment/gercpay.tpl', $data));
    }

    /**
     * @return bool
     */
    private function validate()
    {
        if (!$this->user->hasPermission('modify', 'payment/gercpay')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->request->post['gercpay_merchant']) {
            $this->error['merchant'] = $this->language->get('error_merchant');
        }

        if (!$this->request->post['gercpay_secretkey']) {
            $this->error['secretkey'] = $this->language->get('error_secretkey');
        }

        if (! $this->request->post['gercpay_approve_url']) {
            $this->error['approve_url'] = $this->language->get('error_approve_url');
        }

        if (! $this->request->post['gercpay_decline_url']) {
            $this->error['decline_url'] = $this->language->get('error_decline_url');
        }

        if (! $this->request->post['gercpay_cancel_url']) {
            $this->error['cancel_url'] = $this->language->get('error_cancel_url');
        }

        if (! $this->request->post['gercpay_callback_url']) {
            $this->error['callback_url'] = $this->language->get('error_callback_url');
        }

        return ! $this->error;
    }
}
