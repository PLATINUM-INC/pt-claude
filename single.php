<?php
/**
 * Single Post Template
 */

get_header();

$post_id = get_the_ID();
$categories = get_the_category();
$tags = get_the_tags();
$placeholder_url = get_template_directory_uri() . '/assets/icons/placeholder.jpeg';
?>

<main class="base single_post_page" id="main">
	<div class="container">

		<article class="post_article">
			<header class="post_header">
				<h1 class="post_title"><?php the_title(); ?></h1>

				<div class="post_meta">
					<time class="post_date" datetime="<?php echo get_the_date('c'); ?>">
						<?php echo get_the_date(); ?>
					</time>

					<span class="post_reading_time">
						<?php echo sprintf(__('%d мин чтения', 'pt-claude'), get_reading_time()); ?>
					</span>

					<?php if ($categories && !is_wp_error($categories)): ?>
						<span class="post_categories">
							<?php foreach ($categories as $index => $cat): ?>
								<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>">
									<?php echo esc_html($cat->name); ?>
								</a><?php echo ($index < count($categories) - 1) ? ', ' : ''; ?>
							<?php endforeach; ?>
						</span>
					<?php endif; ?>
				</div>
			</header>

			<div class="post_thumbnail">
				<?php if (has_post_thumbnail()): ?>
					<?php the_post_thumbnail('large'); ?>
				<?php else: ?>
					<img src="<?php echo esc_url($placeholder_url); ?>" alt="<?php the_title_attribute(); ?>">
				<?php endif; ?>
			</div>

			<div class="post_content">
				<?php the_content(); ?>
			</div>

			<?php if ($tags && !is_wp_error($tags)): ?>
				<footer class="post_footer">
					<div class="post_tags">
						<span class="post_tags_label"><?php esc_html_e('Теги:', 'pt-claude'); ?></span>
						<?php foreach ($tags as $tag): ?>
							<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="post_tag">
								<?php echo esc_html($tag->name); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</footer>
			<?php endif; ?>
		</article>

		<?php
		$related_posts = get_related_posts($post_id, 3);
		if (!empty($related_posts)):
		?>
			<div class="related_posts">
				<h2><?php esc_html_e('Похожие статьи', 'pt-claude'); ?></h2>

				<div class="related_posts_grid">
					<?php foreach ($related_posts as $related): ?>
						<article class="related_post_card">
							<a href="<?php echo get_permalink($related->ID); ?>" class="related_post_image">
								<?php if (has_post_thumbnail($related->ID)): ?>
									<?php echo get_the_post_thumbnail($related->ID, 'medium'); ?>
								<?php else: ?>
									<img src="<?php echo esc_url($placeholder_url); ?>" alt="<?php echo esc_attr($related->post_title); ?>">
								<?php endif; ?>
							</a>

							<div class="related_post_content">
								<h3 class="related_post_title">
									<a href="<?php echo get_permalink($related->ID); ?>">
										<?php echo esc_html($related->post_title); ?>
									</a>
								</h3>

								<time class="related_post_date" datetime="<?php echo get_the_date('c', $related->ID); ?>">
									<?php echo get_the_date('', $related->ID); ?>
								</time>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
