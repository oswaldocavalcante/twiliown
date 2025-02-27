<?php

require_once TWN_ABSPATH . 'admin/class-twn-settings.php';

class TWN_Admin
{
    public function add_settings()
    {
        $settings = new TWN_Settings();

        add_settings_section('cwg_section_twilio_whatsapp', __('Twilio WhatsApp',       'back-in-stock-notifier-for-woocommerce'),    array($settings, 'section_description'),    'cwginstocknotifier_settings');
        add_settings_field('cwg_twilio_ssid',               __('Twilio Account SSID',   'back-in-stock-notifier-for-woocommerce'),    array($settings, 'cwg_twilio_ssid'),        'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_twilio_token',              __('Twilio Auth Token',     'back-in-stock-notifier-for-woocommerce'),    array($settings, 'cwg_twilio_token'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_twilio_phone',              __('WhatsApp Sender Number','back-in-stock-notifier-for-woocommerce'),    array($settings, 'cwg_twilio_phone'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
        add_settings_field('cwg_template_sid',              __('Twilio Template SID',   'back-in-stock-notifier-for-woocommerce'),    array($settings, 'cwg_template_sid'),       'cwginstocknotifier_settings', 'cwg_section_twilio_whatsapp');
    }

    public function back_in_stock_whatsapp($id, $time)
    {
        $user_phone     = get_post_meta($id, 'cwginstock_subscriber_phone', true);
        $user_phone     = $this->parse_brazilian_phone($user_phone);
        if(!$user_phone) return;

        if(get_post_meta($id, 'cwginstock_variation_id', true)) 
        {
            $product_id = get_post_meta($id, 'cwginstock_variation_id', true);
        } 
        else {
            $product_id = get_post_meta($id, 'cwginstock_product_id', true);
        }

        $product        = wc_get_product($product_id);
        $product_name   = $product->get_name();
        $product_slug   = $this->get_product_slug($product);

        $settings       = get_option('cwginstocksettings');
        $twilio_sid     = $settings['twn_twilio_ssid'];
        $twilio_token   = $settings['twn_twilio_token'];
        $twilio_phone   = $settings['twn_twilio_phone'];
        $template_sid   = $settings['twn_template_sid'];
        $api_url        = "https://api.twilio.com/2010-04-01/Accounts/{$twilio_sid}/Messages.json";

        $headers = array
        (
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("{$twilio_sid}:{$twilio_token}"),
        );

        $data = array
        (
            'To'                => 'whatsapp:' . $user_phone,
            'From'              => 'whatsapp:' . $twilio_phone,
            'ContentSid'        => $template_sid,
            'ContentVariables'  => sprintf('{"1":"%s","2":"%s"}', $product_name, $product_slug),
        );

        $response = wp_remote_post
        (
            $api_url,
            array
            (
                'headers'       => $headers,
                'body'          => http_build_query($data)
            )
        );

        if (is_wp_error($response)) error_log($response->get_error_message());
    }

    private function parse_brazilian_phone($phone_number)
    {
        $formatted = wc_format_phone_number($phone_number);

        // Removes the additional 9, if exists (position after +55 e DDD)
        if (strpos($formatted, '+55') === 0)
        {
            // Catches DDD and the phone number (after +55)
            $number_part = substr($formatted, 3);

            // If it has 11 digits, with the initial 9, removes it
            if (strlen($number_part) === 11)
            {
                $ddd = substr($number_part, 0, 2);
                $number = substr($number_part, 3);
                return '+55' . $ddd . $number;
            } 
            else return false;
        }

        return $formatted;
    }

    private function get_product_slug($product)
    {
        $product_permalink = $product->add_to_cart_url();

        $product_base = get_option('woocommerce_permalinks')['product_base']; // Obtém o slug base dos produtos dinamicamente
        $product_base = trim($product_base, '/'); // Remove barras do início/fim

        $site_url = get_site_url();
        $relative_path = str_replace([$site_url, '/' . $product_base . '/'], '', $product_permalink); // Remove o domínio e o slug base da URL
        $product_slug = ltrim($relative_path, '/'); // Remove a barra inicial se existir e os parâmetros de query

        return $product_slug;
    }
}