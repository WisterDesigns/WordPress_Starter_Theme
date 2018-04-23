<div class="header-strip">
	<div class="container">

		<!-- Branding -->
		<div class="logo">
			<?php if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				printf( '<a href="%s">%s</a>', get_bloginfo( 'url' ), get_bloginfo( 'name' ) );
			} ?>
		</div>
		<!-- /Branding -->

		<!-- Menu -->
		<nav class="main-navigation" role="navigation">
			<?php wp_nav_menu( [
				'theme_location' => 'main-menu',
				'container'      => false,
			] ); ?>
		</nav>
		<!-- Menu -->

		<div class="mobile-actions">

			<?php if ( class_exists( 'WooCommerce' ) ) : ?>

				<!-- Cart Icon -->
				<?php get_template_part( 'template-parts/header/cart-icon' ); ?>
				<!-- /Cart Icon -->

			<?php endif; ?>

			<!-- Menu Toggle -->
			<div class="menu-toggle">
				<button class="toggler">
					<span class="sr-only"><?php esc_html_e( 'Toggle Menu', 'starter_theme' ); ?></span>
					<span class="bar"></span>
					<span class="bar"></span>
					<span class="bar"></span>
				</button>
			</div>
			<!-- /Menu Toggle -->

		</div>
	</div>
</div>