<?php

get_header();

$age = get_field('model_age');
$height = get_field('model_height');
$weight = get_field('model_weight');
$bust = get_field('model_bust_size');
$hair = get_field('model_hair_color');
$description = get_field('model_about');
$price1 = get_field('model_price_1');
$price2 = get_field('model_price_2');
$priceNight = get_field('model_price_night');
$gallery = get_field('model_photos');
$siteCurrency = get_field('site_currency', 'option') ?? '₽';

?>

<main class="base model_single_page">
	<div class="container">
		<div class="model_header_wrap">

			<div class="model_gallery col">
				<?php if ($gallery && is_array($gallery) && count($gallery) > 0): ?>
					<?php
					$gallery = array_values($gallery);
					$gallery = array_slice($gallery, 0, 12);
					$count = count($gallery);
					?>

					<?php if ($count > 1): ?>
						<div class="model_gallery_slider swiper" data-model-gallery="1">
							<div class="swiper-wrapper">
								<?php foreach ($gallery as $img_id): ?>
									<div class="swiper-slide">
										<div class="model_gallery_item">
											<?php echo wp_get_attachment_image($img_id, 'large'); ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>

							<div class="swiper-button-prev" aria-label="<?php echo esc_attr__('Предыдущее фото', 'pt-claude'); ?>"></div>
							<div class="swiper-button-next" aria-label="<?php echo esc_attr__('Следующее фото', 'pt-claude'); ?>"></div>
							<div class="swiper-pagination"></div>
						</div>

					<?php else: ?>
						<div class="model_gallery_item">
							<?php echo wp_get_attachment_image($gallery[0], 'large'); ?>
						</div>
					<?php endif; ?>

				<?php else: ?>
					<div class="model_gallery_item">
						<img src="https://via.placeholder.com/500x650" alt="No photo">
					</div>
				<?php endif; ?>
			</div>

			<div class="col">
				<div class="model_main_info">
					<h1 class="model_name_single"><?php the_title(); ?></h1>

					<ul class="model_params_single">
						<?php if ($age): ?>
							<li><strong><?php esc_html_e('Возраст:', 'pt-claude'); ?></strong> <?php echo $age; ?></li><?php endif; ?>
						<?php if ($height): ?>
							<li><strong><?php esc_html_e('Рост:', 'pt-claude'); ?></strong> <?php echo $height; ?></li><?php endif; ?>
						<?php if ($weight): ?>
							<li><strong><?php esc_html_e('Вес:', 'pt-claude'); ?></strong> <?php echo $weight; ?></li><?php endif; ?>
						<?php if ($bust): ?>
							<li><strong><?php esc_html_e('Грудь:', 'pt-claude'); ?></strong> <?php echo $bust; ?></li><?php endif; ?>
						<?php if ($hair): ?>
							<li><strong><?php esc_html_e('Волосы:', 'pt-claude'); ?></strong> <?php echo $hair; ?></li><?php endif; ?>
					</ul>

					<?php if ($price1 || $price2 || $priceNight): ?>
						<div class="model_price_box">
							<?php if ($price1): ?>
								<div class="price-row">
								<span class="price"><?php echo $price1;
									echo $siteCurrency ?></span>
									<span class="per"><?php esc_html_e('1 час', 'pt-claude'); ?></span>
								</div>
							<?php endif; ?>
							<?php if ($price2): ?>
								<div class="price-row">
								<span class="price"><?php echo $price2;
									echo $siteCurrency ?></span>
									<span class="per"><?php esc_html_e('2 часа', 'pt-claude'); ?></span>
								</div>
							<?php endif; ?>
							<?php if ($priceNight): ?>
								<div class="price-row">
								<span class="price"><?php echo $priceNight;
									echo $siteCurrency ?></span>
									<span class="per"><?php esc_html_e('Ночь', 'pt-claude'); ?></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ($description): ?>
						<div class="model_content">
							<?php echo $description; ?>
						</div>
					<?php endif; ?>

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

				<div class="model_main_taxonomies">
					<?php
					$tax_groups = [
						'area'     => __('Район', 'pt-claude'),
						'metro'    => __('Метро', 'pt-claude'),
						'services' => __('Услуги', 'pt-claude'),
						'options'  => __('Параметры модели', 'pt-claude'),
					];

					foreach ($tax_groups as $tax => $title):
						$terms = get_the_terms(get_the_ID(), $tax);
						if (!$terms || is_wp_error($terms)) continue;
						?>

						<div class="taxonomy_block">
							<div class="taxonomy_block_head">
								<?php echo esc_html($title); ?>
							</div>

							<ul class="taxonomy_list">
								<?php foreach ($terms as $term): ?>
									<li class="taxonomy_item">
										&#10003;
										<a href="<?php echo esc_url(get_term_link($term)); ?>">
											<?php echo esc_html($term->name); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<div class="related_models">
			<h2><?php esc_html_e('Похожие модели', 'pt-claude'); ?></h2>
			<?php get_template_part('template-parts/components/related-models'); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
