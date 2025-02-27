# Twilio WhatsApp Notifier for WooCommerce

Uma extensão para o plugin Back In Stock Notifier for WooCommerce que adiciona suporte a notificações via WhatsApp usando a API da Twilio.

## Descrição

Este plugin estende a funcionalidade do Back In Stock Notifier for WooCommerce, permitindo que os clientes recebam notificações via WhatsApp quando produtos que estavam fora de estoque voltam a estar disponíveis.

## Funcionalidades

- Integração com a API do WhatsApp da Twilio
- Configuração simplificada através do painel administrativo do WooCommerce
- Suporte a números de telefone brasileiros (formatação automática)
- Notificações automáticas quando produtos voltam ao estoque

## Requisitos

- WordPress 5.0 ou superior
- WooCommerce 3.5 ou superior
- Back In Stock Notifier for WooCommerce
- Conta Twilio com acesso à API do WhatsApp

## Instalação

1. Faça upload dos arquivos do plugin para a pasta `/wp-content/plugins/`
2. Ative o plugin através do menu 'Plugins' no WordPress
3. Configure suas credenciais da Twilio em WooCommerce > Configurações > Back In Stock Notifier > Twilio WhatsApp

## Configuração

1. Acesse WooCommerce > Configurações > Back In Stock Notifier
2. Na seção "Twilio WhatsApp", preencha:
   - Twilio Account SSID
   - Twilio Auth Token
   - WhatsApp Sender Number (número do WhatsApp remetente)

## Desenvolvimento

Para contribuir com o desenvolvimento:

```bash
# Clone o repositório
git clone https://github.com/oswaldocavalcante/twiliown

# Instale as dependências
composer install
```

## Dependências

- woocommerce/woocommerce-stubs (desenvolvimento)
- Back In Stock Notifier for WooCommerce (plugin principal)

## Licença

GPL v2 ou posterior

## Suporte

Para suporte, por favor abra uma issue no repositório do GitHub.