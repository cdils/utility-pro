<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove.
use BrightNucleus\Config\ConfigFactory;
use CDils\UtilityPro\GoogleFont\Enriqueta;
use CDils\UtilityPro\GoogleFont\OpenSans;

load_child_theme_textdomain( 'utility-pro', get_stylesheet_directory() . '/languages' );

// Autoload dependencies.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

define( 'UTILITY_PRO_CONFIG_DIR', __DIR__ . '/config/' );

add_action( 'genesis_setup', __NAMESPACE__ . '\\setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function setup() {
	define( 'CHILD_THEME_NAME', 'utility-pro' );
	define( 'CHILD_THEME_URL', 'https://store.carriedils.com/utility-pro' );
	define( 'CHILD_THEME_VERSION', '1.3.1' );

	$config_file = UTILITY_PRO_CONFIG_DIR . 'defaults.php';
	$config = ConfigFactory::createSubConfig($config_file, 'CDils\UtilityPro' );

	// Add HTML5 markup structure.
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background.
	add_theme_support( 'custom-background', array(
		'wp-head-callback' => '__return_false',
	) );

	// Add support for accessibility features.
	add_theme_support( 'genesis-accessibility', array( '404-page', 'headings', 'skip-links' ) );

	// Add support for three footer widget areas.
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add support for additional color style options.
	add_theme_support(
		'genesis-style-selector',
		array(
			'utility-pro-purple' => __( 'Purple', 'utility-pro' ),
			'utility-pro-green'  => __( 'Green', 'utility-pro' ),
			'utility-pro-red'    => __( 'Red', 'utility-pro' ),
		)
	);

	// Add support for structural wraps (all default Genesis wraps unless noted).
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'footernav',    // Custom.
			'header',
			'home-gallery', // Custom.
			'menu-footer',  // Custom.
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// Add support for two navigation areas (theme doesn't use secondary navigation).
	add_theme_support(
		'genesis-menus',
		array(
			'primary' => __( 'Primary Navigation Menu', 'utility-pro' ),
			'footer'  => __( 'Footer Navigation Menu', 'utility-pro' ),
		)
	);

	// Add custom image sizes.
	add_image_size( 'feature-large', 960, 330, true );

	// Unregister secondary sidebar.
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar.
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register the default widget areas.
	$widget_areas = new WidgetAreas( $config->getSubConfig( 'WidgetAreas' ) );
	$widget_areas->register();

	// Add Utility Bar above header.
	add_action( 'genesis_before_header', __NAMESPACE__ . '\\add_bar' );

	// Add featured image above posts.
	add_filter( 'the_content', __NAMESPACE__ . '\\featured_image' );


	// Remove Genesis archive pagination (Genesis pagination settings still apply).
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

	// Add WordPress archive pagination (accessibility).
	add_action( 'genesis_after_endwhile', __NAMESPACE__ . '\\post_pagination' );

	// Apply search form enhancements (accessibility).
	add_filter( 'get_search_form', __NAMESPACE__ . '\\get_search_form', 25 );

	// Load files in admin.
	if ( is_admin() ) {
		// Configure and register TGMPA functionality for suggested plugins.
		$tgmpa = new Tgmpa( $config->getSubConfig( 'Tgmpa' ) );
		$tgmpa->register();

		// Add theme license (don't remove, unless you don't want theme support).
		include get_stylesheet_directory() . '/includes/theme-license.php';
	} else {
		// Enqueue Google Fonts.
		$google_fonts = new GoogleFonts();
		$google_fonts->add( 'enriqueta', new Enriqueta() );
		$google_fonts->add( 'opensans', new OpenSans() );
		$google_fonts->enqueue();

		// Footer nav.
		$footer_nav = new FooterNav();
		$footer_nav->apply();
	}

}

/**
 * Add Utility Bar above header.
 *
 * @since 1.0.0
 */
function add_bar() {
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
function featured_image( $content ) {
	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return $content;
	}

	$image = '<div class="featured-image">';
	$image .= get_the_post_thumbnail( get_the_ID(), 'feature-large' );
	$image .= '</div>';

	return $image . $content;
}

add_filter( 'genesis_footer_creds_text', __NAMESPACE__ . '\\footer_creds' );
/**
 * Change the footer text.
 *
 * @since  1.0.0
 *
 * @return string Footer credentials.
 */
function footer_creds() {
	return 'Powered by WordPress and the <a href="https://store.carriedils.com/downloads/utility-pro/?utm_source=Utility%20Pro%20Footer%20Credits&utm_medium=Distributed%20Theme&utm_campaign=Utility%20Pro%20Theme" rel="nofollow">Utility Pro</a> theme for Genesis Framework.';
}

add_filter( 'genesis_author_box_gravatar_size', __NAMESPACE__ . '\\author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @since 1.0.0
 *
 * @return int Pixel size of gravatar.
 */
function author_box_gravatar_size() {
	return 96;
}

// Add scripts to enqueue.
include get_stylesheet_directory() . '/includes/enqueue-assets.php';

// Miscellaneous functions used in theme configuration.
include get_stylesheet_directory() . '/includes/theme-config.php';
