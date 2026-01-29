<?php
// SET DARK MODE IF SAVED IN COOKIE
$mode = null;

if (! empty($_COOKIE['mode'])) {
    $mode = $_COOKIE['mode'];
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> data-mode="light">

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width initial-scale=1">
	<?php
    wp_head();
the_field('header_scripts', 'option');
?>
</head>

<body <?php body_class(); ?>>
	<?php
the_field('body_scripts_top', 'option');
function_exists('wp_body_open') ? wp_body_open() : do_action('wp_body_open');
?>

	<div class="wrapper">

		<?php
    get_template_part('template-parts/header/header');
get_template_part('template-parts/breadcrumbs');
