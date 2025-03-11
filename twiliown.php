<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://oswaldocavalcante.com
 * @since             1.0.0
 * @package           TwilioWhatsApp
 *
 * @wordpress-plugin
 * Plugin Name:       Add-on: Twilio WhatsApp - Back In Stock Notifier for WooCommerce
 * Plugin URI:        https://github.com/oswaldocavalcante/
 * Description:       Adds Twilio WhatsApp notifications for the plugin 'Back In Stock Notifier for WooCommerce'.
 * Version:           1.1.0
 * Author:            Oswaldo Cavalcante
 * Author URI:        https://oswaldocavalcante.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       twiliown
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce, back-in-stock-notifier-for-woocommerce
 * Tested up to: 6.6.2
 * Requires PHP: 7.2
 * WC requires at least: 4.0
 * WC tested up to: 9.3.3
 * 
 */

// If this file is called directly, abort.
if (! defined('WPINC')) die;

define('TWN_VERSION', '1.1.0');
if (!defined('TWN_PLUGIN_FILE')) define('TWN_PLUGIN_FILE', __FILE__);
define('TWN_ABSPATH', dirname(TWN_PLUGIN_FILE) . '/');
define('TWN_URL', plugins_url('/', __FILE__));

require plugin_dir_path(__FILE__) . 'includes/class-twiliown.php';
function run_twiliown()
{
    $plugin = new Twiliown();
}

run_twiliown();