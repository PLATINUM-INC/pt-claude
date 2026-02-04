<?php
$age = get_field('model_age');
$height = get_field('model_height');
$weight = get_field('model_weight');
$bust = get_field('model_bust_size');

$price_1 = get_field('model_price_1');
$price_2 = get_field('model_price_2');
$price_night = get_field('model_price_night');

$siteCurrency = get_field('site_currency', 'option') ?? '₽';

$about = get_field('model_about');

$photos = get_field('model_photos');
$main_photo = '';

if ($photos && is_array($photos)) {
    $main_photo = wp_get_attachment_image_url($photos[0]);
}

$permalink = get_permalink();
?>

<div class="model_card">

	<a class="model_card_media" href="<?php echo esc_url($permalink); ?>">

		<div class="model_card_image">
			<img src="<?php echo esc_url($main_photo); ?>" alt="<?php the_title_attribute(); ?>">
		</div>

		<div class="model_overlay">
			<div class="model_cred">
				<span class="model_name"><?php the_title(); ?></span>

				<ul class="model_params">
					<?php if ($age) { ?>
						<li><?php echo esc_html(sprintf(__('%s лет', 'pt-claude'), $age)); ?></li>
					<?php } ?>

					<?php if ($height) { ?>
						<li><?php echo esc_html(sprintf(__('%s см', 'pt-claude'), $height)); ?></li>
					<?php } ?>

					<?php if ($weight) { ?>
						<li><?php echo esc_html(sprintf(__('%s кг', 'pt-claude'), $weight)); ?></li>
					<?php } ?>

					<?php if ($bust) { ?>
						<li><?php echo esc_html(sprintf(__('Грудь %s', 'pt-claude'), $bust)); ?></li>
					<?php } ?>
				</ul>
			</div>
		</div>

	</a>

	<div class="model_info">

		<?php if ($price_1 || $price_2 || $price_night) { ?>
			<div class="model_prices">

				<?php if ($price_1) { ?>
					<div class="price_row">
						<div class="price_label"><?php echo esc_html__('1 час', 'pt-claude'); ?></div>
						<div class="price_value"><?php echo esc_html($price_1.$siteCurrency); ?></div>
					</div>
				<?php } ?>

				<?php if ($price_2) { ?>
					<div class="price_row">
						<div class="price_label"><?php echo esc_html__('2 часа', 'pt-claude'); ?></div>
						<div class="price_value"><?php echo esc_html($price_2.$siteCurrency); ?></div>
					</div>
				<?php } ?>

				<?php if ($price_night) { ?>
					<div class="price_row">
						<div class="price_label"><?php echo esc_html__('Ночь', 'pt-claude'); ?></div>
						<div class="price_value"><?php echo esc_html($price_night.$siteCurrency); ?></div>
					</div>
				<?php } ?>

			</div>
		<?php } ?>

		<?php
        if ($about) {
            $about = wp_strip_all_tags(do_shortcode((string) $about));
            $about = trim(preg_replace('/\s+/u', ' ', $about));

            $max_words = 15;
            $words = preg_split('/\s+/u', $about, -1, PREG_SPLIT_NO_EMPTY);

            if ($words && count($words) > $max_words) {
                $about = implode(' ', array_slice($words, 0, $max_words)).'...';
            }

            if ($about !== '') { ?>
				<div class="model_about">
					<?php echo esc_html($about); ?>
				</div>
			<?php }
            }
?>

		<div class="model_bottom">
			<?php
    $areas = get_the_terms(get_the_ID(), 'area');
$metros = get_the_terms(get_the_ID(), 'metro');
?>

			<?php if (($metros && ! is_wp_error($metros)) || ($areas && ! is_wp_error($areas))) { ?>
				<div class="model_location">

					<?php if ($metros && ! is_wp_error($metros)) { ?>
						<?php
            $metro_term = $metros[0];
					    $metro_link = get_term_link($metro_term);
					    ?>
						<?php if (! is_wp_error($metro_link)) { ?>
							<a class="metro" href="<?php echo esc_url($metro_link); ?>">
								<?php echo get_inline_svg('metro.svg'); ?>
								<?php echo esc_html($metro_term->name); ?>
							</a>
						<?php } else { ?>
							<span class="metro">
							<?php echo get_inline_svg('metro.svg'); ?>
							<?php echo esc_html($metro_term->name); ?>
						</span>
						<?php } ?>
					<?php } ?>

					<?php if ($areas && ! is_wp_error($areas)) { ?>
						<?php
					    $area_term = $areas[0];
					    $area_link = get_term_link($area_term);
					    ?>
						<?php if (! is_wp_error($area_link)) { ?>
							<a class="area" href="<?php echo esc_url($area_link); ?>">
								<?php echo get_inline_svg('area.svg'); ?>
								<?php echo esc_html($area_term->name); ?>
							</a>
						<?php } else { ?>
							<span class="area">
							<?php echo get_inline_svg('area.svg'); ?>
							<?php echo esc_html($area_term->name); ?>
						</span>
						<?php } ?>
					<?php } ?>

				</div>
			<?php } ?>

			<?php
            $services = get_the_terms(get_the_ID(), 'services');
if ($services && ! is_wp_error($services)) {
    $services = array_slice($services, 0, 6);
    ?>
				<ul class="model_services">
					<?php foreach ($services as $service) { ?>
						<?php
            $service_link = get_term_link($service);
					    ?>
						<li>
							<?php if (! is_wp_error($service_link)) { ?>
								<a href="<?php echo esc_url($service_link); ?>">
									<?php echo esc_html($service->name); ?>
								</a>
							<?php } else { ?>
								<?php echo esc_html($service->name); ?>
							<?php } ?>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>

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

	</div>

</div>