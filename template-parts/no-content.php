<section class="no-content">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'starter_theme' ); ?></h1>
	</header>
	<div class="page-content">

		<?php if ( is_search() ) : ?>
			<p><?php esc_html_e( 'We couldn\'t find anything to match your search terms.', 'starter_theme' ); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'It seems like your are searching for something that doesn\'t exists.', 'starter_theme' ); ?></p>
		<?php endif; ?>

	</div>
</section>