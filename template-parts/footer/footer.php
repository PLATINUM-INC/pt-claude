<?php
$whatsapp = get_field('whatsapp', 'option');
$telegram = get_field('telegram', 'option');

$parents = get_pages([
	'post_type'        => 'page',
	'parent'           => 0,
	'sort_column'      => 'menu_order',
	'suppress_filters' => false,
]);

$children_links = [];
foreach ($parents as $p) {
	$children = get_pages([
		'post_type'        => 'page',
		'parent'           => $p->ID,
		'sort_column'      => 'menu_order',
		'suppress_filters' => false,
	]);
	$children_links = array_merge($children_links, $children);
}
$children_links = array_slice($children_links, 0, 10);

$taxonomies = [
	'area'      => __('Районы', 'pt-claude'),
	'metro'     => __('Метро', 'pt-claude'),
	'services'  => __('Услуги', 'pt-claude'),
	'options'   => __('Параметры', 'pt-claude'),
];

?>
<footer class="footer">
	<div class="container">
		<div class="footer_inner">

			<div class="footer_col">
				<h3><?php esc_html_e('Меню', 'pt-claude'); ?></h3>
				<ul>
					<?php foreach ($parents as $page): ?>
						<li>
							<a href="<?php echo esc_url(get_permalink($page->ID)); ?>">
								<?php echo esc_html($page->post_title); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="footer_col">
				<h3><?php esc_html_e('Категории', 'pt-claude'); ?></h3>

				<?php foreach ($taxonomies as $tax => $label): ?>
					<?php
					$terms = get_terms([
						'taxonomy'   => $tax,
						'hide_empty' => false,
						'number'     => 6,
					]);

					if (!empty($terms) && !is_wp_error($terms)): ?>
						<div class="footer_tax_block">
							<h4><?php echo esc_html($label); ?></h4>
							<ul>
								<?php foreach ($terms as $term): ?>
									<li>
										<a href="<?php echo esc_url(get_term_link($term)); ?>">
											<?php echo esc_html($term->name); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>

			</div>

			<div class="footer_col">
				<h3><?php esc_html_e('Новости', 'pt-claude'); ?></h3>
				<?php
				$footer_posts = get_posts([
					'post_type'      => 'post',
					'posts_per_page' => 5,
					'post_status'    => 'publish',
				]);

				if (!empty($footer_posts)): ?>
					<ul class="footer_posts">
						<?php foreach ($footer_posts as $fp): ?>
							<li>
								<a href="<?php echo esc_url(get_permalink($fp->ID)); ?>">
									<?php echo esc_html($fp->post_title); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="footer_col footer_contacts">
				<h3><?php esc_html_e('Контакты', 'pt-claude'); ?></h3>
				<div class="model_contacts">
					<button type="button" class="model-contact-js model_contact" id="tg" aria-label="<?php echo esc_attr__('Открыть Telegram', 'pt-claude'); ?>">
						<?php echo get_inline_svg('tg.svg'); ?>
						<span><?php echo esc_html__('Telegram', 'pt-claude'); ?></span>
					</button>

					<button type="button" class="model-contact-js model_contact" id="wa" aria-label="<?php echo esc_attr__('Открыть WhatsApp', 'pt-claude'); ?>">
						<?php echo get_inline_svg('wa.svg'); ?>
						<span><?php echo esc_html__('WhatsApp', 'pt-claude'); ?></span>
					</button>
				</div>
			</div>

			<div class="footer_brand">
				<div class="brand_title"><?php bloginfo('name'); ?></div>
				<p>© <?php echo date('Y'); ?> <?php esc_html_e('Все права защищены', 'pt-claude'); ?></p>
			</div>

		</div>
	</div>
</footer>
