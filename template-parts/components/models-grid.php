<?php

$paged = max(1, get_query_var('paged'), get_query_var('page'));

$args = [
    'post_type' => 'models',
    'posts_per_page' => get_option('posts_per_page', 20),
    'paged' => $paged,
];

$query = new WP_Query($args);
?>

	<div class="models_grid">
		<?php while ($query->have_posts()) {
		    $query->the_post(); ?>
			<?php get_template_part('template-parts/components/model-card'); ?>
		<?php } ?>
	</div>

	<div class="models_pagination">
		<?php
        echo paginate_links([
            'total' => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => '«',
            'next_text' => '»',
        ]);
?>
	</div>

<?php wp_reset_postdata(); ?>