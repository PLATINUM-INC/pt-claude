<?php

/**
 *  Custom colors from ACF Global Options
 */

add_action('wp_head', function () {
	if (defined('ICL_SITEPRESS_VERSION')) {
		$text_color   = get_option('options_text_color') ?: '#1a1a1a';
		$bg_color     = get_option('options_bg_color') ?: '#faf9f7';
		$accent_color = get_option('options_accent_color') ?: '#d97706';
		$muted_color  = get_option('options_muted_color') ?: '#f3f1ed';
	} else {
		$text_color   = get_field('text_color', 'option') ?: '#1a1a1a';
		$bg_color     = get_field('bg_color', 'option') ?: '#faf9f7';
		$accent_color = get_field('accent_color', 'option') ?: '#d97706';
		$muted_color  = get_field('muted_color', 'option') ?: '#f3f1ed';
	}

	echo "
    <style>
        :root {
            --text-color: {$text_color};
            --bg-color: {$bg_color};
            --accent-color: {$accent_color};
            --muted-color: {$muted_color};
        }
    </style>";
});

add_action('admin_init', 'ptb_set_default_colors_on_activation');
function ptb_set_default_colors_on_activation() {

	$colors_configured = get_field('colors_configured', 'option');

	if ($colors_configured) {
		return;
	}

	$file = get_template_directory() . '/assets/colors/colors.json';

	if (!file_exists($file)) {
		return;
	}

	$json = file_get_contents($file);
	$palettes = json_decode($json, true);

	if (!$palettes || !is_array($palettes)) {
		return;
	}

	$random_palette = $palettes[array_rand($palettes)];

	update_field('text_color', $random_palette['text'], 'option');
	update_field('bg_color', $random_palette['bg'], 'option');
	update_field('accent_color', $random_palette['accent'], 'option');
	update_field('muted_color', $random_palette['muted'], 'option');

	update_field('colors_configured', true, 'option');
}