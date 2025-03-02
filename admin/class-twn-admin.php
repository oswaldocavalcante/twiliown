<?php

use Automattic\WooCommerce\Utilities\FeaturesUtil;

require_once TWN_ABSPATH . 'admin/class-twn-settings.php';
require_once TWN_ABSPATH . 'admin/class-twn-api.php';

class TWN_Admin
{
    private $api;
    private $settings;

    public function __construct()
    {
        $this->api      = new TWN_API();
        $this->settings = new TWN_Settings();
    }

    /**
     * Declare compatibility with WooCommerce features
     * 
     * @return void
     */
    public function declare_wc_compatibility()
    {
        if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil'))
        {
            FeaturesUtil::declare_compatibility('custom_order_tables', TWN_ABSPATH, true);
        }
    }

    public function add_settings()
    {
        add_settings_section('cwg_section_twilio_whatsapp', __('Twilio WhatsApp',       'twiliown'),    array($this->settings, 'section_description'),    'cwginstocknotifier_settings');
        
        add_settings_field('cwg_twilio_ssid',               __('Twilio Account SSID',   'twiliown'),    array($this->settings, 'cwg_twilio_ssid'),        'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_twilio_token',              __('Twilio Auth Token',     'twiliown'),    array($this->settings, 'cwg_twilio_token'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_twilio_phone',              __('WhatsApp Sender Number','twiliown'),    array($this->settings, 'cwg_twilio_phone'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_template_sid',              __('Twilio Template SID',   'twiliown'),    array($this->settings, 'cwg_template_sid'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
    }

    public function notify_batch($ids)
    {
        if (is_array($ids) && ! empty($ids))
        {
            foreach ($ids as $each_id)
            {
                if (!get_post_meta($each_id, 'cwginstock_bypass_pid', true))
                {
                    $pid = get_post_meta($each_id, 'cwginstock_pid', true);
                }
                else {
                    $pid = get_post_meta($each_id, 'cwginstock_bypass_pid', true);
                }

                $product = wc_get_product($pid);
                if ($product && $product->is_in_stock())
                {
                    if ('cwg_subscribed' == get_post_status($each_id))
                    {
                        $this->api->send($each_id);
                    }
                } 
                else 
                {
                    $logger = new CWG_Instock_Logger('error', 'Seems this product has been out of stock, so no point in sending mail to the respective subscriber');
                    $logger->record_log();
                }
            }
        }
    }

    public function notify($id, $time = null)
    {
        $this->api->send($id);
    }
}