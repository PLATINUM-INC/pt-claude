<?php
$current_id = get_the_ID();

$args = [
    'post_type' => 'models',
    'posts_per_page' => 4,
    'post__not_in' => [$current_id],
    'orderby' => 'rand',
];

$query = new WP_Query($args);
?>

<div class="models_grid">
	<?php while ($query->have_posts()) {
	    $query->the_post(); ?>
		<?php get_template_part('template-parts/components/model-card'); ?>
	<?php } ?>
</div>

<?php wp_reset_postdata(); ?>
