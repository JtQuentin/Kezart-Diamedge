<?php

$plugins = array(
    array(
        'name'               => 'Advanced Custom Fields Pro',
        'slug'               => 'acf',
        'source'             => get_theme_file_uri().'/assets/plugins/advanced-custom-fields-pro.zip',
        'required'           => true,
        'force_activation'   => true,
    ),
    array(
        'name'               => 'Gravity Forms',
        'slug'               => 'gf',
        'source'             => get_theme_file_uri().'/assets/plugins/gravityforms_2.1.3.9.zip',
        'required'           => true,
        'force_activation'   => true,
    )
);

$config = array(
    'id'           => 'zekario-tgmpa',
    'default_path' => get_theme_file_uri().'/assets/plugins/',
    'menu'         => 'zekario-install-required-plugins',
    'has_notices'  => true,
    'dismissable'  => false,
    'dismiss_msg'  => 'I really, really need you to install these plugins, okay?',
    'is_automatic' => true,
    'message'      => '<!--Hey there.-->',
    'strings'      => array()
);

tgmpa( $plugins );