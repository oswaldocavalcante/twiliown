# Twilio WhatsApp Notifier for WooCommerce

An extension for the Back In Stock Notifier for WooCommerce plugin that adds WhatsApp notification support using the Twilio API.

## Description

This plugin extends the functionality of Back In Stock Notifier for WooCommerce, allowing customers to receive WhatsApp notifications when out-of-stock products become available again.

## Features

- Integration with Twilio WhatsApp API
- Simple configuration through WooCommerce admin panel
- Support for Brazilian phone numbers (automatic formatting)
- Automatic notifications when products are back in stock

## Requirements

- WordPress 5.0 or higher
- WooCommerce 3.5 or higher
- Back In Stock Notifier for WooCommerce
- Twilio account with WhatsApp API access

## Installation

1. Upload the plugin files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure your Twilio credentials in WooCommerce > Settings > Back In Stock Notifier > Twilio WhatsApp

## Configuration

1. Go to WooCommerce > Settings > Back In Stock Notifier
2. In the "Twilio WhatsApp" section, fill in:
   - Twilio Account SSID
   - Twilio Auth Token
   - WhatsApp Sender Number (sender WhatsApp number)

## Development

To contribute to development:

```bash
# Clone the repository
git clone https://github.com/oswaldocavalcante/twiliown

# Install dependencies
composer install
```

## Dependencies

- woocommerce/woocommerce-stubs (development)
- Back In Stock Notifier for WooCommerce (main plugin)

## License

GPL v2 or later

## Support

For support, please open an issue on the GitHub repository.