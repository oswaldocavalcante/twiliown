<?php

class TWN_Settings
{
    public function section_description()
    {
        esc_html_e('Settings for Twilio WhatsApp integration.', 'back-in-stock-notifier-for-woocommerce');
    }

    public function cwg_twilio_ssid()
    {
        $options = get_option('cwginstocksettings');
        $option_value = isset($options['twn_twilio_ssid']) ? $options['twn_twilio_ssid'] : '';

        ?>
            <input
                type='text' style='width: 400px;'
                name='cwginstocksettings[twn_twilio_ssid]'
                value="<?php echo wp_kses_post(sanitize_text_field($option_value)); ?>"
                placeholder="<?php esc_attr_e('Twilio SSID', 'back-in-stock-notifier-for-woocommerce'); ?>"
            />
            <p><small><?php esc_html_e('Enter Twilio SSID.', 'back-in-stock-notifier-for-woocommerce'); ?></small></p>
        <?php
    }

    public function cwg_twilio_token()
    {
        $options = get_option('cwginstocksettings');
        $option_value = isset($options['twn_twilio_token']) ? $options['twn_twilio_token'] : '';

        ?>
            <input
                type='text' style='width: 400px;'
                name='cwginstocksettings[twn_twilio_token]'
                value="<?php echo wp_kses_post(sanitize_text_field($option_value)); ?>"
                placeholder="<?php esc_attr_e('Twilio Auth Token', 'back-in-stock-notifier-for-woocommerce'); ?>"
            />
            <p><small><?php esc_html_e('Enter Twilio Auth Token.', 'back-in-stock-notifier-for-woocommerce'); ?></small></p>
        <?php
    }

    public function cwg_twilio_phone()
    {
        $options = get_option('cwginstocksettings');
        $option_value = isset($options['twn_twilio_phone']) ? $options['twn_twilio_phone'] : '';
        $formatted_value = $this->parse_user_phone($option_value);

        ?>
            <input
                type='text'
                name='cwginstocksettings[twn_twilio_phone]'
                value="<?php echo wp_kses_post($formatted_value ? $formatted_value : $option_value); ?>"
                placeholder="<?php esc_attr_e('+1234567890', 'back-in-stock-notifier-for-woocommerce'); ?>"
            />
            <p><small><?php esc_html_e('Enter WhatsApp number in international format (e.g., +1234567890).', 'back-in-stock-notifier-for-woocommerce'); ?></small></p>
        <?php
    }

    public function cwg_template_sid()
    {
        $options = get_option('cwginstocksettings');
        $option_value = isset($options['twn_template_sid']) ? $options['twn_template_sid'] : '';
        $formatted_value = $this->parse_user_phone($option_value);

        ?>
            <input
                type='text' style='width: 400px;'
                name='cwginstocksettings[twn_template_sid]'
                value="<?php echo wp_kses_post($formatted_value ? $formatted_value : $option_value); ?>"
                placeholder="<?php esc_attr_e('Twilio Template SID', 'back-in-stock-notifier-for-woocommerce'); ?>"
            />
            <p><small><?php esc_html_e('Enter Twilio Template SID.', 'back-in-stock-notifier-for-woocommerce'); ?></small></p>
        <?php
    }

    /**
     * Formata um número de telefone para o padrão E.164 exigido pelo WhatsApp
     * 
     * @param string $phone_number Número de telefone a ser formatado
     * @return string|false Número formatado ou false em caso de erro
     */
    private function parse_user_phone($phone_number)
    {
        $formatted = wc_format_phone_number($phone_number);

        // Remove todos os caracteres não numéricos, exceto o +
        $cleaned = preg_replace('/[^\d+]/', '', $formatted);

        // Verifica se o número está no formato E.164 (+CCNNNNNNNNN)
        if (preg_match('/^\+\d{1,3}\d{6,14}$/', $cleaned)) return $cleaned;

        return false;
    }
}
