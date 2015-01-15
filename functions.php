<?php
/**
 * Utility Pro.
 *
 * @package      Utility_Pro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove
require( get_stylesheet_directory() . '/includes/text-domain.php' );

// This file loads the Google fonts used in this theme
require( get_stylesheet_directory() . '/includes/google-fonts.php' );

add_action( 'genesis_setup', 'utility_pro_setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function utility_pro_setup() {

	define( 'CHILD_THEME_NAME', 'utility-pro' );
	define( 'CHILD_THEME_URL', 'https://store.carriedils.com/utility-pro' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background
	add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

	// Add support for three footer widget areas
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add support for additional color style options
	add_theme_support(
		'genesis-style-selector',
		array(
			'utility-pro-purple' =>	__( 'Purple', 'utility-pro' ),
			'utility-pro-green'  =>	__( 'Green', 'utility-pro' ),
			'utility-pro-red'    =>	__( 'Red', 'utility-pro' ),
		)
	);

	// Add support for structural wraps (all default Genesis wraps unless noted)
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'footernav', // Custom
			'menu-footer', // Custom
			'header',
			'home-gallery', // Custom
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// Add support for two navigation areas (theme doesn't use secondary navigation)
	add_theme_support(
		'genesis-menus',
		array(
			'primary'   => __( 'Primary Navigation Menu', 'utility-pro' ),
			'footer'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		)
	);

	// Add custom image sizes
	add_image_size( 'feature-large', 960, 330, true );

	// Unregister secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register the default widget areas
	utility_pro_register_widget_areas();

	// Add Utility Bar above header
	add_action( 'genesis_before_header', 'utility_pro_add_bar' );

	// Add featured image above posts
	add_action( 'genesis_before_entry_content', 'utility_pro_featured_image' );

	// Add a navigation area above the site footer
	add_action( 'genesis_before_footer', 'utility_pro_do_footer_nav' );

	// Load accesibility components if the Genesis Accessible plugin is not active
	if ( ! function_exists( 'genwpacc_genesis_init' ) ) {

		// Load skip links (accessibility)
		include get_stylesheet_directory() . '/includes/skip-links.php';

		// Load form enhancements (accessibility)
		include get_stylesheet_directory() . '/includes/forms.php';
	}

	// Load files in admin
	if ( is_admin() ) {

		// Add suggested plugins nag
		include get_stylesheet_directory() . '/includes/suggested-plugins.php';

		// Add theme license (don't remove, unless you don't want theme support)
		include get_stylesheet_directory() . '/includes/theme-license.php';
	}
}

/**
 * Register the widget areas enabled by default in Utility.
 *
 * Applies the `utility_pro_default_widget_areas` filter.
 *
 * @since 1.0.0
 */
function utility_pro_register_widget_areas() {

	$widget_areas = array(
		array(
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'utility-pro' ),
			'description' => __( 'This is the utility bar across the top of page.', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-welcome',
			'name'        => __( 'Home Welcome', 'utility-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-gallery-1',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 1 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 1 ),
		),
		array(
			'id'          => 'utility-home-gallery-2',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 2 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 2 ),
		),
		array(
			'id'          => 'utility-home-gallery-3',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 3 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 3 ),
		),
		array(
			'id'          => 'utility-home-gallery-4',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 4 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 4 ),
		),
		array(
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Call to Action', 'utility-pro' ),
			'description' => __( 'This is the Call to Action section on the home page.', 'utility-pro' ),
		),
	);

	$widget_areas = apply_filters( 'utility_pro_default_widget_areas', $widget_areas );

	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}

add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_assets' );
/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function utility_pro_enqueue_assets() {


	// Load mobile responsive menu
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/includes/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Localize the responsive menu script (for translation)
	wp_localize_script( 'utility-pro-responsive-menu', 'responsiveL10n', array( 'button_label' => __( 'Menu', 'utility-pro' ) ) );

	// Load keyboard navigation script only if Genesis Accessible plugin is not active
	if ( ! function_exists( 'genwpacc_dropdown_scripts' ) ) {
		wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/includes/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );
	}

	// Replace style.css with style-rtl.css for RTL languages
	wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Load remaining scripts only if custom background is being used and we're on the home page
	if ( ! get_background_image() && ( ! is_front_page() || ! is_page_template( 'page-template-page_landing' ) ) ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . '/includes/js/backstretch.min.js', array( 'jquery' ), '2.0.1', true );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . '/includes/js/backstretch.args.js', array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION, true );

	wp_localize_script( 'utility-pro-backstretch-args', 'utilityL10n', array( 'src' => get_background_image() ) );
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
 * @return null Return early if not a single post there is no thumbnail.
 * @since  1.0.0
 */
function utility_pro_featured_image() {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return;
	}

	echo '<div class="featured-image">';
		echo get_the_post_thumbnail( get_the_ID(), 'feature-large' );
	echo '</div>';
}

/**
 * Outputs Footer Navigation Menu
 *
 * @return string Navigation menu markup.
 * @since  1.0.0
 */
function utility_pro_do_footer_nav() {

	genesis_nav_menu(
		array(
			'menu_class'     => 'menu genesis-nav-menu menu-footer',
			'theme_location' => 'footer',
		)
	);
}

// Add schema markup to Footer Navigation Menu
add_filter( 'genesis_attr_nav-footer', 'genesis_attributes_nav' );

add_filter( 'wp_nav_menu_args', 'utility_pro_footer_menu_args' );
/**
 * Reduce the footer navigation menu to one level depth.
 *
 * @param  array $args
 * @return array
 * @since  1.0.0
 */
function utility_pro_footer_menu_args( $args ) {

	if( 'footer' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;
}

add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds' );
/**
 * Change the footer text.
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 * @since  1.0.0
 */
function utility_pro_footer_creds( $creds ) {

	return '[footer_copyright first="2015"] &middot; <a href="https://store.carriedils.com/downloads/utility-pro/?utm_source=Utility%20Pro%20Footer%20Credits&utm_medium=Distributed%20Theme&utm_campaign=Utility%20Pro%20Theme">Utility Pro</a>.';
}

add_filter( 'genesis_author_box_gravatar_size', 'utility_pro_author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @return integer Pixel size of gravatar.
 * @since 1.0.0
 */
function utility_pro_author_box_gravatar_size( $size ) {
	return 96;
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );
