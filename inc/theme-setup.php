<?php

/*
=====================
    Theme setup
=====================
*/

function theme_setup() {

	load_theme_textdomain('pt-claude', get_template_directory() . '/languages');

	add_theme_support('title-tag');
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
	add_theme_support('woocommerce');
	add_theme_support('rank-math-breadcrumbs');

	global $content_width;
	if (!isset($content_width)) $content_width = 640;

	register_nav_menus(
		array(
			'header-menu'   => __('Header Menu', 'pt-claude'),
			'footer-menu'   => __('Footer Menu', 'pt-claude'),
			'footer-menu-1' => __('Footer Col 1', 'pt-claude'),
			'footer-menu-2' => __('Footer Col 2', 'pt-claude'),
			'footer-menu-3' => __('Footer Col 3', 'pt-claude'),
		)
	);
}

add_action('after_setup_theme', 'theme_setup', 0);

function theme_activation() {
	update_option('posts_per_page', 60);
	ptb_generate_favicon();
}

add_action('after_switch_theme', 'theme_activation');

/**
 * Get random font from assets/fonts directory
 */
function ptb_get_random_font() {
	$fonts_dir = get_template_directory() . '/assets/fonts';
	$fonts = glob($fonts_dir . '/*.{ttf,otf,TTF,OTF}', GLOB_BRACE);

	if (!empty($fonts)) {
		return $fonts[array_rand($fonts)];
	}

	// Fallback to default font
	return __DIR__ . '/fonts/Inter-Bold.ttf';
}

/**
 * Generate favicon with site initials using Imagick
 */
function ptb_generate_favicon() {
	if (get_option('site_icon')) {
		return;
	}

	if (!class_exists('Imagick')) {
		return;
	}

	$site_name = get_bloginfo('name');
	$initials = ptb_get_site_initials($site_name);

	$bg_color = get_option('options_bg_color') ?: '#d97706';
	$text_color = get_option('options_accent_color') ?: '#ffffff';

	$size = 512;
	$font = ptb_get_random_font();
	$font_size = strlen($initials) > 1 ? $size * 0.60 : $size * 0.55;

	try {
		$image = new Imagick();
		$image->newImage($size, $size, new ImagickPixel($bg_color));
		$image->setImageFormat('png');

		$draw = new ImagickDraw();
		$draw->setFillColor(new ImagickPixel($text_color));
		$draw->setTextAlignment(Imagick::ALIGN_CENTER);
		$draw->setTextAntialias(true);

		if (file_exists($font)) {
			$draw->setFont($font);
		}
		$draw->setFontSize($font_size);

		$metrics = $image->queryFontMetrics($draw, $initials);

		$x = $size / 2;
		$y = (($size - $metrics['textHeight']) / 2) + $metrics['ascender'];

		$image->annotateImage($draw, $x, $y, 0, $initials);

		$upload_dir = wp_upload_dir();
		$filename = 'favicon-' . sanitize_title($site_name) . '.png';
		$filepath = $upload_dir['path'] . '/' . $filename;

		$image->writeImage($filepath);
		$image->clear();
		$image->destroy();

		$attachment = array(
			'post_mime_type' => 'image/png',
			'post_title'     => 'Site Favicon',
			'post_content'   => '',
			'post_status'    => 'inherit',
		);

		$attach_id = wp_insert_attachment($attachment, $filepath);

		if (!is_wp_error($attach_id)) {
			$attach_data = array(
				'width'  => $size,
				'height' => $size,
				'file'   => $upload_dir['subdir'] . '/' . $filename,
			);
			wp_update_attachment_metadata($attach_id, $attach_data);
			update_option('site_icon', $attach_id);
		}

	} catch (Exception $e) {
		error_log('Favicon generation failed: ' . $e->getMessage());
	}
}

/**
 * Get initials from site name
 */
function ptb_get_site_initials($name) {
	$words = preg_split('/[\s\-_]+/', trim($name));
	$words = array_filter($words);

	if (count($words) >= 2) {
		return mb_strtoupper(
			mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1)
		);
	}

	return mb_strtoupper(mb_substr($name, 0, 2));
}
