<?php if ( !is_front_page() && !is_home() ) : ?>
	<div class="breadcrumbs-wrapper">
		<div class="container">
			<?php
			if ( function_exists('rank_math_the_breadcrumbs') ) {
				rank_math_the_breadcrumbs();
			}
			?>
		</div>
	</div>
<?php endif; ?>
