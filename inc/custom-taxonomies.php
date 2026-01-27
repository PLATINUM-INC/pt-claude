<?php

/*
=========================
    Custom Taxonomies
=========================
*/


/**
 * Override ACF taxonomy labels with translatable strings
 */
function pt_bunny_taxonomy_labels( $args, $taxonomy ) {
	$labels = [
		'area' => [
			'name'          => __( 'Районы', 'pt-claude' ),
			'singular_name' => __( 'Район', 'pt-claude' ),
		],
		'metro' => [
			'name'          => __( 'Метро', 'pt-claude' ),
			'singular_name' => __( 'Метро', 'pt-claude' ),
		],
		'services' => [
			'name'          => __( 'Услуги', 'pt-claude' ),
			'singular_name' => __( 'Услуга', 'pt-claude' ),
		],
		'options' => [
			'name'          => __( 'Параметры', 'pt-claude' ),
			'singular_name' => __( 'Параметр', 'pt-claude' ),
		],
	];

	if ( isset( $labels[ $taxonomy ] ) ) {
		$args['labels'] = array_merge( (array) $args['labels'], $labels[ $taxonomy ] );
	}

	return $args;
}
add_filter( 'register_taxonomy_args', 'pt_bunny_taxonomy_labels', 10, 2 );