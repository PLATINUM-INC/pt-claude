<?php

/*
==============================
    Add Styles And Scripts
==============================
*/

function theme_enqueue()
{

    $DEVELOPMENT = true; // change to false if PRODUCTION

    $ABSOLUTE_DIST = get_template_directory().'/dist'; // Absolute path to the dist folder
    $DIST = get_template_directory_uri().'/dist'; // Dir to the dist theme folder
    $LIB = get_template_directory_uri().'/lib'; // Dir to the lib theme folder

    if ($DEVELOPMENT) {

        $style_version = filemtime("{$ABSOLUTE_DIST}/css/app.css");
        $custom_version = filemtime("{$ABSOLUTE_DIST}/js/app.js");
    } else {

        $style_version = '1.0.0';
        $vendor_version = '1.0.0';
        $custom_version = '1.0.0';
    }

    /* Styles */

    wp_enqueue_style('main', "{$DIST}/css/app.css", [], $style_version, 'all');

    /* JavaScript */

    // Lottie Player: https://lottiefiles.github.io/lottie-player/usage.html
    // wp_enqueue_script( 'lottie-player', "{$LIB}/lottie-player.js", array(), '1.0.0', true );

    // Our Custom JavaScript (should depend on libaries above)
    wp_enqueue_script('main', "{$DIST}/js/app.js", ['jquery'], $custom_version, true);

    /* Passing PHP variables to JavaScript */

    $site_url = get_site_url();
    if (function_exists('idn_to_utf8')) {
        $host = parse_url($site_url, PHP_URL_HOST);
        $decoded = idn_to_utf8($host);
        if ($decoded) {
            $site_url = str_replace($host, $decoded, $site_url);
        }
    }

    wp_localize_script(
        'main',
        'pt_bunny',
        [
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('secure_nonce_name'),
            'site_url' => $site_url,
            'theme_url' => get_template_directory_uri(),
            'contact_message' => sprintf(__('Привет! Я с сайта %s, хочу подобрать девушку.', 'pt-claude'), $site_url),
        ]
    );
}

add_action('wp_enqueue_scripts', 'theme_enqueue');
