<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<meta name="theme-color" content="#3498db">
	<?php wp_head(); ?>

	<?php do_action( 'before_head_close' ); ?>

</head>
<body <?php body_class(); ?>>

<?php do_action( 'after_body_open' ); ?>

<!-- HEADER -->
<header id="masthead" class="site-header">

	<!-- Mobile Strip -->
	<?php get_template_part( 'template-parts/header/menu' ); ?>
	<!-- /Mobile Strip -->

</header>
<!-- /HEADER -->