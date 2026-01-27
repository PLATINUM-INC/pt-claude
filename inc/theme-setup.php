<?php

/*
=====================
    Theme setup
=====================	
*/


function theme_setup(){

	load_theme_textdomain( 'pt-claude', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'rank-math-breadcrumbs' );

	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;

  register_nav_menus(
    array(
      'header-menu' => __('Header Menu', 'pt-claude'),
      'footer-menu' => __('Footer Menu', 'pt-claude'),
      'footer-menu-1' => __('Footer Col 1', 'pt-claude'),
      'footer-menu-2' => __('Footer Col 2', 'pt-claude'),
      'footer-menu-3' => __('Footer Col 3', 'pt-claude'),
    )
  );
}

add_action( 'after_setup_theme', 'theme_setup', 0 );


function theme_activation() {
	update_option( 'posts_per_page', 60 );
}

add_action( 'after_switch_theme', 'theme_activation' );

