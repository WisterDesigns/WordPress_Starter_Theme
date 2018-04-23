<?php
/**
 * @package    dorzki\Core\Plugins
 * @subpackage WooCommerce
 * @version    1.0.0
 * @author     Dor Zuberi <webmaster@dorzki.co.il>
 * @link       https://www.dorzki.co.il
 */

namespace dorzki\Core\Plugins;

// Block direct access to the file via url.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class WooCommerce
 *
 * @package dorzki\Core\Plugins
 */
class WooCommerce {

	/**
	 * WooCommerce constructor.
	 */
	public function __construct() {

		add_filter( 'add_to_cart_fragments', [ $this, 'update_cart_icon' ] );
		add_filter( 'loop_shop_per_page', [ $this, 'change_products_per_page' ] );

	}


	/* ---------------------------------------- */


	/**
	 * Update cart icon dynamically on add to cart.
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	public function update_cart_icon( $fragments ) {

		ob_start();

		get_template_part( 'template-parts/cart', 'icon' );

		$fragments[ 'div.cart-icon' ] = ob_get_clean();

		return $fragments;

	}


	/**
	 * Change products per pge to 12.
	 *
	 * @param $per_page
	 *
	 * @return int
	 */
	public function change_products_per_page( $per_page ) {

		return 12;

	}


}

// Init class
new WooCommerce();