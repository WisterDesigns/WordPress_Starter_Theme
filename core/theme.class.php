<?php
/**
 * @package    dorzki\Core
 * @subpackage Theme
 * @version    1.0.0
 * @author     Dor Zuberi <webmaster@dorzki.co.il>
 * @link       https://www.dorzki.co.il
 */

namespace dorzki\Core;

// Block direct access to the file via url.
if ( !defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Class Theme
 *
 * @package dorzki\Core
 */
class Theme {

	/**
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * @var string
	 */
	const SLUG = 'starter_theme';


	/* ---------------------------------------- */


	/**
	 * Theme constructor.
	 */
	public function __construct() {

		add_action( 'after_setup_theme', [ $this, 'theme_capabilities' ] );
		add_action( 'after_setup_theme', [ $this, 'register_menus' ] );
		add_action( 'after_setup_theme', [ $this, 'register_sidebars' ] );
		add_action( 'after_setup_theme', [ $this, 'remove_capabilities' ] );

		add_action( 'init', [ $this, 'disable_emojies' ] );
		add_action( 'init', [ $this, 'disable_oembeds' ] );

		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );

		add_filter( 'upload_mimes', [ $this, 'allow_svg_upload' ] );
		add_filter( 'show_admin_bar', '__return_false' );

	}


	/* ---------------------------------------- */


	/**
	 * Register theme capabilities.
	 */
	public function theme_capabilities() {

		# i18n & l10n
		load_theme_textdomain( 'starter_theme' );

		# Title Tag
		add_theme_support( 'title-tag' );

		# Dynamic Menus
		add_theme_support( 'menus' );

		# Post Thumbnails
		add_theme_support( 'post-thumbnails' );

		# HTML5 Output
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		] );

		# Custom Logo
		add_theme_support( 'custom-logo' );

		# WooCommerce Support
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );

	}


	/**
	 * Register theme menu locations.
	 */
	public function register_menus() {

		register_nav_menu( 'main-menu', esc_html__( 'Main Menu', 'starter_theme' ) );

	}


	/**
	 * Register theme sidebars.
	 */
	public function register_sidebars() {

		register_sidebar( [
			'name'         => esc_html__( 'Main Sidebar', 'starter_theme' ),
			'id'           => 'main-sidebar',
			'before_title' => '<h3 class="widget_title">',
			'after_title'  => '</h3>',
		] );

	}


	/**
	 * Remove unused WordPress capabilities.
	 */
	public function remove_capabilities() {

		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'rest_output_link_wp_head' );

		add_filter( 'the_generator', '__return_false' );

	}


	/* ---------------------------------------- */


	/**
	 * Disable WordPress emojies.
	 */
	public function disable_emojies() {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		add_filter( 'wp_resource_hints', [ $this, 'disable_emojies_dns_prefetch' ], 10, 2 );

	}


	/**
	 * Disable emojies prefetch.
	 *
	 * @param $urls
	 * @param $relation_type
	 *
	 * @return array
	 */
	public function disable_emojies_dns_prefetch( $urls, $relation_type ) {

		if ( 'dns-prefetch' == $relation_type ) {

			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			$urls = array_diff( $urls, [ $emoji_svg_url ] );

		}

		return $urls;

	}


	/**
	 * Disable oEmbeds.
	 */
	public function disable_oembeds() {

		remove_action( 'rest_api_init', 'wp_oembed_register_route' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );

		add_filter( 'embed_oembed_discover', '__return_false' );
		add_filter( 'rewrite_rules_array', [ $this, 'disable_embeds_rewrites' ] );

		remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
		remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

	}


	/**
	 * Remove oEmbed param.
	 *
	 * @param $rules
	 *
	 * @return mixed
	 */
	public function disable_embeds_rewrites( $rules ) {

		foreach ( $rules as $rule => $rewrite ) {

			if ( false !== strpos( $rewrite, 'embed=true' ) ) {
				unset( $rules[ $rule ] );
			}

		}

		return $rules;

	}


	/* ---------------------------------------- */


	/**
	 * Register theme stylesheets.
	 */
	public function register_styles() {

		# Google Fonts
		wp_enqueue_style( 'google_fonts', '//fonts.googleapis.com/css?family=Assistant:300,400,700&amp;subset=hebrew' );

		# Theme CSS
		wp_enqueue_style( self::SLUG . '_css', get_theme_file_uri( 'assets/css/styles.min.css' ), [ 'google_fonts', 'dashicons' ], self::VERSION );

	}


	/**
	 * Register theme scripts.
	 */
	public function register_scripts() {

		# jQuery - we do this in order to make it load in footer.
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, false, true );

		# Theme JS
		wp_enqueue_script( self::SLUG . '_js', get_theme_file_uri( 'assets/js/scripts.min.js' ), [ 'jquery' ], self::VERSION, true );

	}


	/* ---------------------------------------- */


	/**
	 * Allow to upload SVG files.
	 *
	 * @param $mimes
	 *
	 * @return mixed
	 */
	public function allow_svg_upload( $mimes ) {

		$mimes[ 'svg' ] = 'image/svg+xml';

		return $mimes;

	}

}

// Init class
new Theme();