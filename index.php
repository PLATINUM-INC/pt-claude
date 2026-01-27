<?php get_header(); ?>

	<main class="base" id="main">
		<div class="section_in">
			<h1>
				<?php the_title() ?>
			</h1>
			<?php
			get_template_part('template-parts/components/models-grid');
			?>
			<?php the_content(); ?>
		</div>
	</main>


<?php get_footer(); ?>