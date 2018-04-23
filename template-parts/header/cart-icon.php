<?php global $woocommerce; ?>
<div class="cart-icon">
	<a href="<?php echo wc_get_cart_url(); ?>">
		<span class="dashicons dashicons-cart"></span>
		<?php if ( 0 < $woocommerce->cart->cart_contents_count ) : ?>
			<span class="badge"><?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?></span>
		<?php endif; ?>
	</a>
</div>