<?php

class Twilion
{
    public function __construct()
    {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies()
    {
        require_once TWN_ABSPATH . 'admin/class-twn-admin.php';
        require_once TWN_ABSPATH . 'public/class-twn-public.php';
    }

    private function define_admin_hooks()
    {
        $plugin_admin = new TWN_Admin();

        add_action('admin_init',                    array($plugin_admin, 'add_settings'));
        add_action('cwginstock_manual_email_sent',  array($plugin_admin, 'back_in_stock_whatsapp'), 10, 2);
    }

    private function define_public_hooks()
    {
        $plugin_public = new TWN_Public();

        add_action('cwg_instock_after_email_field', array($plugin_public, 'hide_email_field'));
    }
}