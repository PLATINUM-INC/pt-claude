<?php

function theme_testimonial_post_type() {

  $labels = [
    'name'                  => 'Testimonials',
    'singular_name'         => 'Testimonial',
    'menu_name'             => 'Testimonials',
    'name_admin_bar'        => 'Testimonials',
    'add_new_item'          => 'Add New Testimonial',
  ];

  $args = [
    'labels'                => $labels,
    'label'                 => 'Testimonial',
    'supports'              => ['title'],
    'menu_position'         => 5,
    'public'                => true,
    'has_archive'           => false,
    'menu_icon'             => 'dashicons-format-quote',
    'capability_type'       => 'page',
    'rewrite'               => [
      'slug' => 'testimonials',
      'with_front' => false
    ]
  ];

  register_post_type('testimonial', $args);
}

add_action('init', 'theme_testimonial_post_type', 0);
