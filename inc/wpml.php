<?php
/**
 * WPML Integration
 */

/**
 * Setup WPML on init
 */
function pt_bunny_setup_wpml() {
    if ( ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
        return;
    }

    pt_bunny_setup_wpml_language_switcher();
    pt_bunny_setup_wpml_translatable_types();
}
add_action( 'init', 'pt_bunny_setup_wpml' );

/**
 * Setup WPML language switcher
 */
function pt_bunny_setup_wpml_language_switcher() {
    $option_name = 'wpml_language_switcher';
    $settings = get_option( $option_name );

    if ( ! $settings ) {
        return;
    }

    if ( isset( $settings['statics']['shortcode_actions'] ) ) {
        $slot = $settings['statics']['shortcode_actions'];

        // Already enabled - skip
        if ( is_object( $slot ) && method_exists( $slot, 'is_enabled' ) && $slot->is_enabled() ) {
            return;
        }

        $slot_data = [];
        if ( is_object( $slot ) && method_exists( $slot, 'get_model' ) ) {
            $slot_data = $slot->get_model();
        } elseif ( is_array( $slot ) ) {
            $slot_data = $slot;
        }

        $slot_data['show'] = 1;
        $slot_data['template'] = 'wpml-legacy-dropdown-click';
        $slot_data['slot_group'] = 'statics';
        $slot_data['slot_slug'] = 'shortcode_actions';
        $slot_data['display_flags'] = 1;
        $slot_data['display_names_in_native_lang'] = 1;
        $slot_data['display_names_in_current_lang'] = 0;
        $slot_data['display_link_for_current_lang'] = 1;

        if ( class_exists( 'WPML_LS_Shortcode_Actions_Slot' ) ) {
            $settings['statics']['shortcode_actions'] = new WPML_LS_Shortcode_Actions_Slot( $slot_data );
        }

        update_option( $option_name, $settings );
    }
}

/**
 * Make CPT and taxonomies translatable
 */
function pt_bunny_setup_wpml_translatable_types() {
    global $sitepress;

    if ( ! $sitepress ) {
        return;
    }

    $settings_changed = false;

    // CPT to translate
    $post_types = [ 'models' ];

    // Taxonomies to translate
    $taxonomies = [ 'options', 'services', 'metro', 'area' ];

    // Get current settings
    $custom_posts_sync = $sitepress->get_setting( 'custom_posts_sync_option', [] );
    $taxonomies_sync = $sitepress->get_setting( 'taxonomies_sync_option', [] );

    // Set CPT as translatable (1 = translate)
    foreach ( $post_types as $post_type ) {
        if ( ! isset( $custom_posts_sync[ $post_type ] ) || $custom_posts_sync[ $post_type ] != 1 ) {
            $custom_posts_sync[ $post_type ] = 1;
            $settings_changed = true;
        }
    }

    // Set taxonomies as translatable (1 = translate)
    foreach ( $taxonomies as $taxonomy ) {
        if ( ! isset( $taxonomies_sync[ $taxonomy ] ) || $taxonomies_sync[ $taxonomy ] != 1 ) {
            $taxonomies_sync[ $taxonomy ] = 1;
            $settings_changed = true;
        }
    }

    // Save settings if changed
    if ( $settings_changed ) {
        $sitepress->set_setting( 'custom_posts_sync_option', $custom_posts_sync );
        $sitepress->set_setting( 'taxonomies_sync_option', $taxonomies_sync );
        $sitepress->save_settings();
    }
}
