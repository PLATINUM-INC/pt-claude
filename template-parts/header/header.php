<?php

$logo = get_field('site-logo', 'option');
$button = get_field('cta-button', 'option');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');
$extra_taxonomies = ['area', 'metro', 'services', 'options'];

function menu_limit_words($text, $limit = 3) {
	$text = trim(wp_strip_all_tags((string) $text));
	if ($text === '') return '';

	$words = preg_split('/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
	if (!$words) return '';

	$words = array_slice($words, 0, $limit);

	// if last word consists of 1-2 letters — hide it
	while (count($words) > 1) {
		$last = end($words);
		if (mb_strlen($last) <= 2) {
			array_pop($words);
		} else {
			break;
		}
	}

	return implode(' ', $words);
}

?>

<header class="header js-header" id="header">

	<?php
	$front_id = (int) get_option('page_on_front');

	// WPML: get translated front page ID
	if ( function_exists( 'wpml_object_id_filter' ) ) {
		$front_id = (int) wpml_object_id_filter( $front_id, 'page', true );
	}

	$top_pages = get_pages([
		'post_type'        => 'page',
		'parent'           => 0,
		'sort_column'      => 'menu_order',
		'sort_order'       => 'ASC',
		'suppress_filters' => false,
	]);

	// Убираем главную (если задана как статическая), чтобы не дублировать
	if ($front_id) {
		$top_pages = array_filter($top_pages, function($p) use ($front_id) {
			return (int) $p->ID !== $front_id;
		});
	}

	$single_pages = [];          // без детей -> в dropdown "Разное"
	$parents_with_children = []; // с детьми -> отдельные dropdown

	foreach ($top_pages as $p) {
		$has_child = get_pages([
			'post_type'        => 'page',
			'parent'           => $p->ID,
			'number'           => 1,
			'suppress_filters' => false,
		]);

		if (!empty($has_child)) $parents_with_children[] = $p;
		else $single_pages[] = $p;
	}
	?>

	<button class="mobile-burger-btn js-filters-open" type="button" aria-label="<?php echo esc_attr__('Открыть меню', 'pt-claude'); ?>">
		<span class="burger-lines" aria-hidden="true"></span>
	</button>

	<?php if ( function_exists( 'icl_get_languages' ) ): ?>
		<div class="language-switcher language-switcher--mobile">
			<?php do_action( 'wpml_add_language_selector' ); ?>
		</div>
	<?php endif; ?>

	<nav id="filters" class="filters-nav desktop-only">
		<div class="container">
			<ul class="filters-nav-list">

				<!-- Главная (просто ссылка, без выпадашки) -->
				<li class="menu-item">
					<a class="dropdown-toggle" href="<?php echo esc_url(home_url('/')); ?>">
						<span><?php esc_html_e('Главная', 'pt-claude'); ?></span>
					</a>
				</li>

				<!-- Родители с детьми -->
				<?php foreach (array_slice($parents_with_children, 0, 4) as $parent): ?>
					<?php
					$children = get_pages([
						'post_type'        => 'page',
						'parent'           => $parent->ID,
						'sort_column'      => 'menu_order',
						'sort_order'       => 'ASC',
						'suppress_filters' => false,
					]);

					$title = get_field('menu_label', $parent->ID) ?: $parent->post_title;
					?>

					<li class="menu-item dropdown">
						<button class="dropdown-toggle dropdown-toggle--js" type="button">
							<span><?php echo esc_html(menu_limit_words($title, 3)); ?></span>
						</button>

						<div class="dropdown-menu">
							<ul>
								<?php foreach ($children as $child): ?>
									<li>
										<a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
											<?php echo esc_html($child->post_title); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</li>
				<?php endforeach; ?>

				<!-- Разное (dropdown из одиночных верхнеуровневых страниц) -->
				<?php if (!empty($single_pages)): ?>
					<li class="menu-item dropdown">
						<button class="dropdown-toggle dropdown-toggle--js" type="button">
							<span><?php esc_html_e('Разное', 'pt-claude'); ?></span>
						</button>

						<div class="dropdown-menu">
							<ul>
								<?php foreach ($single_pages as $p): ?>
									<?php
									$title = get_field('menu_label', $p->ID) ?: $p->post_title;
									$link  = get_permalink($p->ID);
									?>
									<li>
										<a href="<?php echo esc_url($link); ?>">
											<?php echo esc_html($title); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</li>
				<?php endif; ?>

				<!-- Таксономии -->
				<?php foreach ($extra_taxonomies as $tax): ?>
					<?php
					$tax_obj = get_taxonomy($tax);

					if (!$tax_obj) continue;

					$terms = get_terms(['taxonomy' => $tax, 'hide_empty' => false]);
					if (empty($terms)) continue;
					?>

					<li class="menu-item dropdown">
						<button class="dropdown-toggle dropdown-toggle--js" type="button">
							<span><?php echo esc_html($tax_obj->labels->name); ?></span>
						</button>

						<div class="dropdown-menu">
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
					</li>

				<?php endforeach; ?>

			</ul>

			<?php if ( function_exists( 'icl_get_languages' ) ): ?>
				<div class="language-switcher">
					<?php do_action( 'wpml_add_language_selector' ); ?>
				</div>
			<?php endif; ?>

		</div>
	</nav>

	<!-- Mobile menu -->
	<div class="mobile-filters-panel js-filters-panel">
		<div class="mobile-filters-header">
			<p><?php esc_html_e('Фильтры', 'pt-claude'); ?></p>
			<button class="js-filters-close">✕</button>
		</div>

		<ul class="mobile-filters-list">

			<!-- Главная (ссылка) -->
			<li class="m-item">
				<a class="m-toggle" href="<?php echo esc_url(home_url('/')); ?>">
					<?php esc_html_e('Главная', 'pt-claude'); ?>
				</a>
			</li>

			<!-- Родители с детьми -->
			<?php $i = 0; foreach ($parents_with_children as $parent): ?>
				<?php
				$title = get_field('menu_label', $parent->ID) ?: $parent->post_title;

				$children = get_pages([
					'post_type'        => 'page',
					'parent'           => $parent->ID,
					'sort_column'      => 'menu_order',
					'sort_order'       => 'ASC',
					'suppress_filters' => false,
				]);
				?>

				<li class="m-item">
					<button class="m-toggle" data-mobile-index="<?php echo $i; ?>">
						<?php echo esc_html($title); ?>
					</button>

					<?php if ($children): ?>
						<ul class="m-sub">
							<?php foreach ($children as $child): ?>
								<li>
									<a href="<?php echo esc_url(get_permalink($child->ID)); ?>">
										<?php echo esc_html($child->post_title); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>

				<?php $i++; endforeach; ?>

			<!-- Разное (submenu из одиночных страниц) -->
			<?php if (!empty($single_pages)): ?>
				<li class="m-item">
					<button class="m-toggle" type="button">
						<?php esc_html_e('Разное', 'pt-claude'); ?>
					</button>

					<ul class="m-sub">
						<?php foreach ($single_pages as $p): ?>
							<?php
							$title = get_field('menu_label', $p->ID) ?: $p->post_title;
							$link  = get_permalink($p->ID);
							?>
							<li>
								<a href="<?php echo esc_url($link); ?>">
									<?php echo esc_html($title); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endif; ?>

			<!-- Таксономии -->
			<?php foreach ($extra_taxonomies as $tax): ?>
				<?php
				$tax_obj = get_taxonomy($tax);
				if (!$tax_obj) continue;

				$terms = get_terms(['taxonomy' => $tax, 'hide_empty' => false]);
				if (empty($terms)) continue;
				?>

				<li class="m-item">
					<button class="m-toggle" type="button">
						<?php echo esc_html($tax_obj->labels->name); ?>
					</button>

					<ul class="m-sub">
						<?php foreach ($terms as $term): ?>
							<li>
								<a href="<?php echo esc_url(get_term_link($term)); ?>">
									<?php echo esc_html($term->name); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>

			<?php endforeach; ?>

		</ul>
	</div>

</header>
