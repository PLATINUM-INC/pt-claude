<?php

add_action('rest_api_init', function () {
    register_rest_route('site/v1', '/contacts', [
        'methods' => 'GET',
        'callback' => 'proxy_contacts_api',
        'permission_callback' => '__return_true',
    ]);
});

function proxy_contacts_api()
{
    $referer = wp_get_referer();
    if ($referer && strpos($referer, home_url()) === false) {
        return new WP_Error('forbidden', 'Invalid request', ['status' => 403]);
    }

    $domain = wp_parse_url(home_url(), PHP_URL_HOST);
    $response = wp_remote_get('https://oparamese.com/api/get-contacts?domain='.urlencode($domain), [
        'timeout' => 10,
        'sslverify' => true,
    ]);

    if (is_wp_error($response)) {
        return new WP_Error('api_error', 'Service unavailable', ['status' => 503]);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    return rest_ensure_response($data);
}
