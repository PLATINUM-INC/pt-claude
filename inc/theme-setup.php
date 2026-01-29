<?php

/*
=====================
    Theme setup
=====================
*/

function theme_setup(){

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
}

add_action('after_switch_theme', 'theme_activation');

/**
 * Generate favicon on admin_init if not configured
 */
add_action('admin_init', 'ptb_maybe_generate_favicon');
function ptb_maybe_generate_favicon() {
	$favicon_configured = get_field('favicon_configured', 'option');

	if ($favicon_configured) {
		return;
	}

	ptb_generate_favicon();
	update_field('favicon_configured', true, 'option');
}

/**
 * Get random font from assets/fonts directory
 */
function ptb_get_random_font() {
	$fonts_dir = get_template_directory() . '/assets/fonts';
	$fonts = [];

	// GLOB_BRACE not supported on all systems, use multiple globs
	foreach (['*.ttf', '*.otf', '*.TTF', '*.OTF'] as $pattern) {
		$found = glob($fonts_dir . '/' . $pattern);
		if ($found) {
			$fonts = array_merge($fonts, $found);
		}
	}

	if (!empty($fonts)) {
		return $fonts[array_rand($fonts)];
	}

	// Fallback to default font
	return __DIR__ . '/fonts/Inter-Bold.ttf';
}

/**
 * Convert hex color to RGB array
 */
function ptb_hex_to_rgb($hex) {
	$hex = ltrim($hex, '#');
	return [
		hexdec(substr($hex, 0, 2)),
		hexdec(substr($hex, 2, 2)),
		hexdec(substr($hex, 4, 2))
	];
}

/**
 * Generate favicon with site initials using GD
 */
function ptb_generate_favicon() {
	if (!function_exists('imagecreatetruecolor')) {
		return;
	}

	$site_name = get_bloginfo('name');
	$initials = ptb_get_site_initials($site_name);

	$bg_color = get_option('options_bg_color') ?: '#d97706';
	$text_color = get_option('options_accent_color') ?: '#ffffff';

	$size = 512;
	$font = ptb_get_random_font();
	$font_size = strlen($initials) > 1 ? $size * 0.35 : $size * 0.40;
	$shapes = ['circle', 'square', 'none'];
	$shape = $shapes[array_rand($shapes)];

	// Create image with transparency
	$image = imagecreatetruecolor($size, $size);
	imagesavealpha($image, true);
	imagealphablending($image, false);

	$transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $transparent);

	$bg_rgb = ptb_hex_to_rgb($bg_color);
	$text_rgb = ptb_hex_to_rgb($text_color);

	$bg = imagecolorallocate($image, $bg_rgb[0], $bg_rgb[1], $bg_rgb[2]);
	$text = imagecolorallocate($image, $text_rgb[0], $text_rgb[1], $text_rgb[2]);

	imagealphablending($image, true);

	if ($shape === 'circle') {
		imagefilledellipse($image, $size / 2, $size / 2, $size, $size, $bg);
	} elseif ($shape === 'square') {
		imagefilledrectangle($image, 0, 0, $size, $size, $bg);
	} elseif ($shape === 'none') {
		$text = $bg; // Use bg_color for text when no background
	}

	// Calculate text position
	if (file_exists($font)) {
		$bbox = imagettfbbox($font_size, 0, $font, $initials);
		$text_width = abs($bbox[4] - $bbox[0]);
		$text_height = abs($bbox[5] - $bbox[1]);
		$x = ($size - $text_width) / 2;
		$y = ($size + $text_height) / 2;
		imagettftext($image, $font_size, 0, $x, $y, $text, $font, $initials);
	} else {
		// Fallback to built-in font
		$font_id = 5;
		$text_width = imagefontwidth($font_id) * strlen($initials);
		$text_height = imagefontheight($font_id);
		$x = ($size - $text_width) / 2;
		$y = ($size - $text_height) / 2;
		imagestring($image, $font_id, $x, $y, $initials, $text);
	}

	$upload_dir = wp_upload_dir();
	$filename = 'favicon-' . sanitize_title($site_name) . '-' . time() . '.png';
	$filepath = $upload_dir['path'] . '/' . $filename;

	imagepng($image, $filepath);
	imagedestroy($image);

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
