<?php get_header(); ?>

<main class="base" id="main">
	<div class="container">
		<h1>
			<?php the_title() ?>
		</h1>
		<?php
            get_template_part('template-parts/components/models-grid');
?>
		<?php if (! is_paged()) {
		    the_content();
		} ?>
	</div>
</main>


<?php get_footer(); ?>