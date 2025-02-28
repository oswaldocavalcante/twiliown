<?php

class TWN_API 
{
    private $user_phone;
    private $whatsapp_sender;
    private $product_name;
    private $product_slug;

    private $twilio_sid;
    private $twilio_token;
    private $twilio_url;
    private $twilio_template_sid;

    public function __construct()
    {
        $settings                   = get_option('cwginstocksettings');
        $this->whatsapp_sender      = $settings['twn_twilio_phone'];
        $this->twilio_sid           = $settings['twn_twilio_ssid'];
        $this->twilio_token         = $settings['twn_twilio_token'];
        $this->twilio_template_sid  = $settings['twn_template_sid'];
        $this->twilio_url           = "https://api.twilio.com/2010-04-01/Accounts/{$this->twilio_sid}/Messages.json";        
    }

    public function send($id)
    {
        $this->user_phone = $this->get_whatsapp_number($id);
        if (!$this->user_phone)
        {
            $this->handle_notification_status($id, false, 'WhatsApp number invalid.');
        }

        if (get_post_meta($id, 'cwginstock_variation_id', true))
        {
            $product_id = get_post_meta($id, 'cwginstock_variation_id', true);
        }
        else
        {
            $product_id = get_post_meta($id, 'cwginstock_product_id', true);
        }

        $product            = wc_get_product($product_id);
        $this->product_name = $product->get_name();
        $this->product_slug = $this->get_product_slug($product);

        $headers = array
        (
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . base64_encode("{$this->twilio_sid}:{$this->twilio_token}"),
        );

        $data = array
        (
            'To'                => 'whatsapp:' . $this->user_phone,
            'From'              => 'whatsapp:' . $this->whatsapp_sender,
            'ContentSid'        => $this->twilio_template_sid,
            'ContentVariables'  => sprintf('{"1":"%s","2":"%s"}', $this->product_name, $this->product_slug),
        );

        $response = wp_remote_post
        (
            $this->twilio_url,
            array
            (
                'headers'       => $headers,
                'body'          => http_build_query($data)
            )
        );

        if (is_wp_error($response)) 
        {
            $this->handle_notification_status($id, false, 'WhatsApp: '. $this->user_phone . ' - ' . $response->get_error_message());
        } 
        else 
        {
            $this->handle_notification_status($id, true, 'WhatsApp: ' . $this->user_phone . ' - Notification successfully sent.');
        }
    }

    private function handle_notification_status($id, $success, $message)
    {
        $api = new CWG_Instock_API();

        if ($success)
        {
            $api->mail_sent_status($id); // update mail sent status
            $logger = new CWG_Instock_Logger('info', "Automatic Instock Mail Triggered for ID #$id : " . $message);
        }
        else
        {
            $api->mail_not_sent_status($id);
            $logger = new CWG_Instock_Logger('error', "Failed to send Automatic Instock Mail for ID #$id : " . $message);
        }

        $logger->record_log();
    }

    private function get_whatsapp_number($id)
    {
        $phone_number = get_post_meta($id, 'cwginstock_subscriber_phone', true);
        if(!$phone_number) return false;

        $formatted = wc_format_phone_number($phone_number);
        if (strpos($formatted, '+55') === 0) // Removes the additional 9, if exists (position after +55 e DDD)
        {
            $number_part = substr($formatted, 3); // Catches DDD and the phone number (after +55)
            if (strlen($number_part) === 11) // If it has 11 digits, with the initial 9, removes it
            {
                $ddd    = substr($number_part, 0, 2);
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

        $site_url       = get_site_url();
        $relative_path  = str_replace([$site_url, '/' . $product_base . '/'], '', $product_permalink); // Remove o domínio e o slug base da URL
        $product_slug   = ltrim($relative_path, '/'); // Remove a barra inicial se existir e os parâmetros de query

        return $product_slug;
    }
}