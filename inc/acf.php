<?php

// ACF Settings

/*
==================
 ACF options page
==================
*/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug' => 'site-settings',
        'capability' => 'edit_posts',
        'redirect' => false,
    ]);

    // Allow client to add GTM, Analytics and other scripts to the head, body etc.
    acf_add_options_sub_page([
        'page_title' => 'Scripts',
        'menu_title' => 'Scripts',
        'parent_slug' => 'site-settings',
    ]);

    // Allow client to change 404 copy
    acf_add_options_sub_page([
        'page_title' => '404 - Error page',
        'menu_title' => '404 - Error page',
        'parent_slug' => 'site-settings',
    ]);

}
