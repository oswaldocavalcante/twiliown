<?php return array(
    'root' => array(
        'name' => 'oswaldocavalcante/twiliown',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => null,
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v1.12.0',
            'version' => '1.12.0.0',
            'reference' => 'd20a64ed3c94748397ff5973488761b22f6d3f19',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
        'oswaldocavalcante/twiliown' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => null,
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'roundcube/plugin-installer' => array(
            'dev_requirement' => true,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'shama/baton' => array(
            'dev_requirement' => true,
            'replaced' => array(
                0 => '*',
            ),
        ),
        'woocommerce/woocommerce' => array(
            'pretty_version' => '3.5.10',
            'version' => '3.5.10.0',
            'reference' => '2ff9d442abfcabed6d865c1b9ce2fa59b66aa613',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../wp-content/plugins/woocommerce',
            'aliases' => array(),
            'dev_requirement' => true,
        ),
    ),
);
