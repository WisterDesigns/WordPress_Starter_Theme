<?php get_header(); ?>

<!-- CONTENT -->
<main id="content" class="main-content">
	<section class="error-404">
		<header class="entry-header">
			<h1 class="entry-title"><?php esc_html_e( 'Not Found', 'starter_theme' ); ?></h1>
		</header>
		<div class="entry-content">
			<p><?php esc_html_e( 'It seems like your are searching for something that doesn\'t exist.', 'starter_theme' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</section>
</main>
<!-- /CONTENT -->

<?php get_footer(); ?>
