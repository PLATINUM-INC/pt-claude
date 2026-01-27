<?php

function theme_member_post_type() {

  $labels = [
    'name'                  => 'Members',
    'singular_name'         => 'Member',
    'menu_name'             => 'Members',
    'name_admin_bar'        => 'Members',
    'add_new_item'          => 'Add New Member',
  ];

  $args = [
    'labels'                => $labels,
    'label'                 => 'Member',
    'supports'              => ['title'],
    'menu_position'         => 5,
    'public'                => true,
    'has_archive'           => false,
    'menu_icon'             => 'dashicons-businessman',
    'capability_type'       => 'page',
    'rewrite'               => [
      'slug' => 'members',
      'with_front' => false
    ]
  ];

  register_post_type('member', $args);
}

add_action('init', 'theme_member_post_type', 0);
