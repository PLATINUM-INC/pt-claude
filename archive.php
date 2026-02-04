<?php
/**
 * Archive Template (Categories, Tags, Date archives)
 */

get_header();

$archive_title = '';
$archive_description = '';
$placeholder_url = get_template_directory_uri() . '/assets/icons/placeholder.jpeg';

if (is_category()) {
	$archive_title = single_cat_title('', false);
	$archive_description = category_description();
} elseif (is_tag()) {
	$archive_title = single_tag_title('', false);
	$archive_description = tag_description();
} elseif (is_author()) {
	$archive_title = get_the_author();
	$archive_description = get_the_author_meta('description');
} elseif (is_date()) {
	if (is_year()) {
		$archive_title = get_the_date('Y');
	} elseif (is_month()) {
		$archive_title = get_the_date('F Y');
	} elseif (is_day()) {
		$archive_title = get_the_date('F j, Y');
	}
} else {
	$archive_title = __('Архив', 'pt-claude');
}
?>

<main class="base archive_page" id="main">
	<div class="container">

		<header class="archive_header">
			<h1 class="archive_title"><?php echo esc_html($archive_title); ?></h1>

			<?php if ($archive_description && !is_paged()): ?>
				<div class="archive_description">
					<?php echo wp_kses_post($archive_description); ?>
				</div>
			<?php endif; ?>
		</header>

		<?php if (have_posts()): ?>
			<div class="posts_grid">
				<?php while (have_posts()): the_post(); ?>
					<article class="post_card">
						<a href="<?php the_permalink(); ?>" class="post_card_image">
							<?php if (has_post_thumbnail()): ?>
								<?php the_post_thumbnail('medium'); ?>
							<?php else: ?>
								<img src="<?php echo esc_url($placeholder_url); ?>" alt="<?php the_title_attribute(); ?>">
							<?php endif; ?>
						</a>

						<div class="post_card_content">
							<h2 class="post_card_title">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</h2>

							<div class="post_card_meta">
								<time class="post_card_date" datetime="<?php echo get_the_date('c'); ?>">
									<?php echo get_the_date(); ?>
								</time>

								<span class="post_card_reading_time">
									<?php echo sprintf(__('%d мин', 'pt-claude'), get_reading_time()); ?>
								</span>

								<?php
								$post_categories = get_the_category();
								if ($post_categories && !is_wp_error($post_categories) && !is_category()):
								?>
									<span class="post_card_category">
										<a href="<?php echo esc_url(get_category_link($post_categories[0]->term_id)); ?>">
											<?php echo esc_html($post_categories[0]->name); ?>
										</a>
									</span>
								<?php endif; ?>
							</div>

							<?php if (has_excerpt() || get_the_content()): ?>
								<div class="post_card_excerpt">
									<?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
								</div>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="post_card_link">
								<?php esc_html_e('Читать далее', 'pt-claude'); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php
			the_posts_pagination([
				'mid_size'  => 2,
				'prev_text' => __('&laquo; Назад', 'pt-claude'),
				'next_text' => __('Вперёд &raquo;', 'pt-claude'),
			]);
			?>

		<?php else: ?>
			<div class="no_posts">
				<p><?php esc_html_e('Записей не найдено.', 'pt-claude'); ?></p>
			</div>
		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
