<?php

get_header();

$desc = term_description();
?>

<main class="base" id="main">
	<div class="container">

		<h1>
			<?php single_term_title(); ?>
		</h1>

		<?php
        get_template_part('template-parts/components/models-grid');
?>

		<?php if ($desc && ! is_paged()) { ?>
			<div class="term_description">
				<?php echo wp_kses_post($desc); ?>
			</div>
		<?php } ?>
	</div>
</main>

<?php get_footer(); ?>
