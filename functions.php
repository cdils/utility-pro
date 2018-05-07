<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );
namespace CDils\UtilityPro;

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove.
load_child_theme_textdomain( 'utility-pro', get_stylesheet_directory() . '/languages' );

add_action( 'genesis_setup', __NAMESPACE__ . '\\setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * theme-specific functions are defined below this setup function.
 *
 * @since 1.0.0
 */
function setup() {

	$child_theme = wp_get_theme();

	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );
	define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );

	// Add HTML5 markup structure.
	add_theme_support(
		'html5',
		[
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form'
		]
	);

	// Add viewport meta tag for mobile browsers.
	add_theme_support(
		'genesis-responsive-viewport'
	);

	// Add support for custom background.
	add_theme_support(
		'custom-background',
		[
			'wp-head-callback' => '__return_false'
		]
	);

	// Add support for accessibility features.
	add_theme_support(
		'genesis-accessibility',
		[
			'404-page',
			'headings',
			'skip-links'
		]
	);

	// Add support for three footer widget areas.
	add_theme_support(
		'genesis-footer-widgets',
		3
	);

	// Add support for additional color style options.
	add_theme_support(
		'genesis-style-selector',
		[
			'utility-pro-purple' => __( 'Purple', 'utility-pro' ),
			'utility-pro-green'  => __( 'Green', 'utility-pro' ),
			'utility-pro-jam'    => __( 'Jazzberry Jam', 'utility-pro' ),
		]
	);

	// Add support for structural wraps (all default Genesis wraps unless noted).
	add_theme_support(
		'genesis-structural-wraps',
		[
			'footer',
			'footer-widgets',
			'footernav',    // Custom.
			'header',
			'home-gallery', // Custom.
			'menu-footer',  // Custom.
			'nav',
			'site-inner',
			'site-tagline',
		]
	);

	// Add support for two navigation areas (theme doesn't use secondary navigation).
	add_theme_support(
		'genesis-menus',
		[
			'primary' => __( 'Primary Navigation Menu', 'utility-pro' ),
			'footer'  => __( 'Footer Navigation Menu', 'utility-pro' ),
		]
	);

	// Add custom image sizes.
	add_image_size( 'feature-large', 960, 330, true );

	// Unregister secondary sidebar.
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar.
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Remove unused templates.
	add_filter( 'theme_page_templates', 'utility_pro_remove_genesis_page_templates' );

	// Register the default widget areas.
	utility_pro_register_widget_areas();

	// Enable shortcodes in widgets.
	add_filter( 'widget_text', 'do_shortcode' );

	// Add featured image above posts.
	add_filter( 'the_content', 'utility_pro_featured_image' );

	// Load files in admin.
	if ( is_admin() ) {
		// Add theme license (don't remove, unless you don't want theme support).
		include get_stylesheet_directory() . '/includes/theme-license.php';
	} else {

		// This file loads the Google fonts used in this theme.
		require get_stylesheet_directory() . '/includes/google-fonts.php';

		// Add accessibility enhancements.
		$accessibility = new Accessibility();
		$accessibility->apply();

		// Footer nav.
		$footer_nav = new FooterNav();
		$footer_nav->apply();

		// Add Utility Bar above header.
		add_action( 'genesis_before_header', 'utility_pro_add_bar' );

		// Change the footer text.
		add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds' );

		// Customize the Gravatar size in the author box.
		add_filter( 'genesis_author_box_gravatar_size', function () {
			return 96;
		} );

		add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_assets' );
	}
}

/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates Existing recognised page templates.
 * @return array Amended recognised page templates.
 */
function utility_pro_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_blog.php'] );

	return $page_templates;
}

/**
 * Add Utility Bar above header.
 *
 * @since 1.0.0
 */
function utility_pro_add_bar() {
	genesis_widget_area( 'utility-bar', array(
		'before' => '<div class="utility-bar"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

/**
 * Add featured image above single posts.
 *
 * Outputs image as part of the post content, so it's included in the RSS feed.
 * H/t to Robin Cornett for the suggestion of making image available to RSS.
 *
 * @since 1.0.0
 *
 * @param string $content Post content.
 *
 * @return null|string Return early if not a single post or there is no thumbnail.
 *                     Image and content markup otherwise.
 */
function utility_pro_featured_image( $content ) {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return $content;
	}

	$image = '<div class="featured-image">';
	$image .= get_the_post_thumbnail( get_the_ID(), 'feature-large' );
	$image .= '</div>';

	return $image . $content;
}

/**
 * Change the footer text.
 *
 * @since  1.0.0
 *
 * @param string $creds Existing credentials.
 *
 * @return string Footer credentials.
 */
function utility_pro_footer_creds( $creds ) {
	return sprintf(
		/* translators: %s: URL for Utility Pro. */
		__( 'Powered by WordPress and the <a href="%s" rel="nofollow">Utility Pro</a> theme for Genesis Framework.', 'utility-pro' ),
		esc_url( 'https://store.carriedils.com/downloads/utility-pro/?utm_source=Utility%20Pro%20Footer%20Credits&utm_medium=Distributed%20Theme&utm_campaign=Utility%20Pro%20Theme' )
	);
}

/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function utility_pro_enqueue_assets() {
	// Replace style.css with style-rtl.css for RTL languages.
	wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Keyboard navigation (dropdown menus) script.
	wp_enqueue_script( 'keyboard-dropdown',  get_stylesheet_directory_uri() . '/js/keyboard-dropdown.min.js', array( 'jquery' ), false, true );

	// Load mobile responsive menu.
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.min.js', array( 'jquery' ),CHILD_THEME_VERSION, true );

	$localize_primary = [
		'buttonText'     => __( 'Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Primary Navigation Menu', 'utility-pro' ),
		'subMenuButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subMenuButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	$localize_footer = [
		'buttonText'     => __( 'Footer Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		'subMenuButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subMenuButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	// Localize the responsive menu script (for translation).
	wp_localize_script( 'utility-pro-responsive-menu', 'utilityMenuPrimaryL10n', $localize_primary );
	wp_localize_script( 'utility-pro-responsive-menu', 'utilityMenuFooterL10n', $localize_footer );

	wp_enqueue_script( 'utility-pro', get_stylesheet_directory_uri() . '/js/responsive-menu.args.min.js', array( 'utility-pro-responsive-menu' ), CHILD_THEME_VERSION, true );

	// Load Backstretch scripts only if custom background is being used
	// and we're on the home page or a page using the landing page template.
	if ( ! get_background_image() || ( ! ( is_front_page() || is_page_template( 'page_landing.php' ) ) ) ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.min.js', array( 'jquery' ), '2.0.1', true );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . '/js/backstretch.args.min.js', array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION, true );
	wp_localize_script( 'utility-pro', 'utilityBackstretchL10n', array( 'src' => get_background_image() ) );

}

// Add theme widget areas.
include get_stylesheet_directory() . '/includes/widget-areas.php';
