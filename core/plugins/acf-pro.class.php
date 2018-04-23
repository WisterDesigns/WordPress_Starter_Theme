<?php
/**
 * @package    dorzki\Core\Plugins
 * @subpackage ACF_Pro
 * @version    1.0.0
 * @author     Dor Zuberi <webmaster@dorzki.co.il>
 * @link       https://www.dorzki.co.il
 */

namespace dorzki\Core\Plugins;

use dorzki\Core\Theme;

// Block direct access to the file via url.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class ACF_Pro
 *
 * @package dorzki\Core\Plugins
 */
class ACF_Pro {

	/**
	 * ACF_Pro constructor.
	 */
	public function __construct() {

		add_action( 'acf/init', [ $this, 'register_options_page' ] );

		// Enable Polylang to translate ACF options pages. (https://github.com/BeAPI/acf-options-for-polylang)
		add_filter( 'acf/validate_post_id', [ $this, 'set_options_id_lang' ], 10, 2 );
		add_filter( 'acf/settings/current_language', [ $this, 'set_current_site_lang' ] );
		add_filter( 'acf/load_value', [ $this, 'get_default_value' ], 10, 3 );

	}


	/* ---------------------------------------- */


	/**
	 * Register ACF Pro theme options page.
	 */
	public function register_options_page() {

		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page( [
				'page_title' => __( 'Theme Options', 'starter_theme' ),
				'menu_title' => __( 'Theme Options', 'starter_theme' ),
				'menu_slug'  => Theme::SLUG . '-theme-options',
				'parent'     => 'themes.php',
			] );

		}

	}


	/* ---------------------------------------- */


	/**
	 * Manage to change the post_id with the current lang to save option against.
	 *
	 * @param $future_post_id
	 * @param $original_post_id
	 *
	 * @return string
	 */
	public function set_options_id_lang( $future_post_id, $original_post_id ) {

		if ( !function_exists( 'pll_current_language' ) ) {
			return $future_post_id;
		}

		$options_pages = $this->get_option_page_ids();

		if ( empty( $options_pages ) || !in_array( $original_post_id, $options_pages ) ) {
			return $future_post_id;
		}

		$dl = acf_get_setting( 'default_language' );
		$cl = acf_get_setting( 'current_language' );

		if ( $cl && $cl !== $dl ) {
			$future_post_id .= '_' . $cl;
		}

		return $future_post_id;

	}


	/**
	 * Get the current Polylang's locale or the wp's one.
	 *
	 * @return bool|string
	 */
	public function set_current_site_lang() {

		return ( function_exists( 'pll_current_language' ) ) ? pll_current_language( 'locale' ) : 'en';

	}


	/**
	 * Load default value (all languages) in front if none found for an acf option.
	 *
	 * @param $value
	 * @param $post_id
	 * @param $field
	 *
	 * @return mixed|null
	 */
	public function get_default_value( $value, $post_id, $field ) {

		if ( !function_exists( 'pll_current_language' ) ) {
			return $value;
		}

		if ( is_admin() || !self::is_option_page( $post_id ) ) {
			return $value;
		}

		if ( !is_null( $value ) ) {

			if ( is_array( $value ) ) {


				$is_empty = array_filter( $value, function ( $value_c ) {
					return "" !== $value_c;
				} );

				if ( !empty( $is_empty ) ) {
					return $value;
				}

			} else {

				if ( "" !== $value ) {
					return $value;
				}

			}

		}

		remove_filter( 'acf/settings/current_language', [ $this, 'set_current_site_lang' ] );
		remove_filter( 'acf/load_value', [ $this, 'get_default_value' ] );

		$all_language_post_id = str_replace( sprintf( '_%s', pll_current_language( 'locale' ) ), '', $post_id );

		$value = acf_get_metadata( $all_language_post_id, $field[ 'name' ] );

		add_filter( 'acf/settings/current_language', [ $this, 'set_current_site_lang' ] );
		add_filter( 'acf/load_value', [ $this, 'get_default_value' ], 10, 3 );

		return $value;

	}


	/* ---------------------------------------- */


	/**
	 * Get all registered options pages as array [ post_id => page title ].
	 *
	 * @return array
	 */
	public function get_option_page_ids() {

		if ( !function_exists( 'acf_get_valid_location_rule' ) ) {
			return [];
		}

		$rule = [
			'param'    => 'options_page',
			'operator' => '==',
			'value'    => 'acf-options',
			'id'       => 'rule_0',
			'group'    => 'group_0',
		];

		$rule = acf_get_valid_location_rule( $rule );
		$options_pages = acf_get_location_rule_values( $rule );

		return empty( $options_pages ) ? [] : array_keys( $options_pages );

	}


	/**
	 * Check if the given post id is from an options page or not.
	 *
	 * @param $post_id
	 *
	 * @return bool
	 */
	public function is_option_page( $post_id ) {

		if ( false !== strpos( $post_id, 'options' ) ) {
			return true;
		}

		$options_pages = $this->get_option_page_ids();

		if ( !empty( $options_pages ) && in_array( $post_id, $options_pages ) ) {
			return true;
		}

		return false;

	}

}

// Init class
new ACF_Pro();