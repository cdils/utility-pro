<?php
/**
 * Utility.
 *
 * @package      Utility
 * @link         http://www.carriedils.com/themes/utility
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2013, Carrie Dils
 * @license      GPL-2.0+
 */

// Use copy of Genesis Framework language files for upgrade stability
define( 'GENESIS_LANGUAGES_DIR', get_stylesheet_directory() . '/languages/genesis' );

// Must be added before Genesis Framework /lib/init.php is included
add_action( 'after_setup_theme', 'utility_genesis_child_setup' );
function utility_genesis_child_setup() {
    load_child_theme_textdomain( 'utility', get_stylesheet_directory() . '/languages' );
}

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

define( 'CHILD_THEME_NAME', 'Utility' );
define( 'CHILD_THEME_URL', 'http://www.carriedils.com/' );
define( 'CHILD_THEME_VERSION', '1.1.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for three footer widget areas
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add support for custom background
add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'utility-purple' =>	__( 'Purple', 'utility' ),
	'utility-green'  =>	__( 'Green', 'utility' ),
	'utility-orange' =>	__( 'Orange', 'utility' ),
	'utility-red'    =>	__( 'Red', 'utility' ),
));

//* Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'site-tagline',
	'home-gallery',
	'nav',
	'subnav',
	'site-inner',
	'footer-widgets',
	'footer'
) );


//* Add custom image sizes
add_image_size( 'feature-large', 960, 330, true );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Unregister layouts that use secondary sidebar
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

//* Register the default widget areas
utility_register_widget_areas();

/**
 * Register the widget areas enabled by default in Utility.
 *
 * Applies the `utility_default_widget_areas` filter.
 *
 * @since 1.0.0
 */
function utility_register_widget_areas() {

	$widget_areas = array(
		'utility-bar-left' => array(
			'id'          => 'utility-bar-left',
			'name'        => __( 'Utility Bar Left', 'utility' ),
			'description' => __( 'This is the left side of the utility bar across the top of page.', 'utility' ),
		),
		'utility-bar-right' => array(
			'id'          => 'utility-bar-right',
			'name'        => __( 'Utility Bar Right', 'utility' ),
			'description' => __( 'This is the right side of the utility bar across the top of page.', 'utility' ),
		),
		'home-welcome' => array(
			'id'          => 'utility-home-welcome',
			'name'        => __( 'Home Welcome', 'utility' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility' ),
		),
		'home-gallery-1' => array(
			'id'          => 'utility-home-gallery-1',
			'name'        => __( 'Home Gallery 1', 'utility' ),
			'description' => __( 'This is the 1st gallery section in the middle of the home page.', 'utility' ),
		),
		'home-gallery-2' => array(
			'id'          => 'utility-home-gallery-2',
			'name'        => __( 'Home Gallery 2', 'utility' ),
			'description' => __( 'This is the 2nd gallery section in the middle of the home page.', 'utility' ),
		),
		'home-gallery-3' => array(
			'id'          => 'utility-home-gallery-3',
			'name'        => __( 'Home Gallery 3', 'utility' ),
			'description' => __( 'This is the 3rd gallery section in the middle of the home page.', 'utility' ),
		),
		'home-gallery-4' => array(
			'id'          => 'utility-home-gallery-4',
			'name'        => __( 'Home Gallery 4', 'utility' ),
			'description' => __( 'This is the 4th gallery section in the middle of the home page.', 'utility' ),
		),
		'call-to-action' => array(
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Call to Action', 'utility' ),
			'description' => __( 'This is the CTA section at the bottom of the home page.', 'utility' ),
		),
		'copyright' => array(
			'id'          => 'utility-copyright',
			'name'        => __( 'Copyright', 'utility' ),
			'description' => __( 'This is the copyright section at the bottom of the page.', 'utility' ),
		),
	);

	$widget_areas = apply_filters( 'utility_default_widget_areas', $widget_areas );

	foreach( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}


add_action( 'wp_enqueue_scripts', 'utility_enqueue_styles' );
/**
 * Enqueue the Google Web Font and Font Awesome style sheets.
 *
 * @since 1.1.0
 */
function utility_enqueue_styles() {
	wp_enqueue_style( 'utility-google-fonts', '//fonts.googleapis.com/css?family=Arvo:400,700|PT+Sans:400,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'utility-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array(), '4.1.0' );
}


add_action( 'wp_enqueue_scripts', 'utility_enqueue_scripts' );
/**
 * Load Backstretch script and prepare images for loading.
 *
 */
function utility_enqueue_scripts() {

	//* Load scripts only if custom background is being used
	if ( ! get_background_image() ) {
		return;
	}

	wp_enqueue_script( 'utility-backstretch', get_stylesheet_directory_uri() . "/lib/js/backstretch.js", array( 'jquery' ), '2.0.1' );
	wp_enqueue_script( 'utility-backstretch-args', get_stylesheet_directory_uri()."/lib/js/backstretch.args.js" , array( 'utility-backstretch' ), CHILD_THEME_VERSION );

	wp_localize_script( 'utility-backstretch-args', 'utilityL10n', array( 'src' => get_background_image() ) );

}

add_action( 'genesis_before_header', 'utility_bar' );
/**
 * Add utility bar above header.
 *
 * @since 1.0.0
 */
function utility_bar() {

		echo '<div class="utility-bar"><div class="wrap">';

		genesis_widget_area( 'utility-bar-left', array(
			'before' => '<div class="utility-bar-left">',
			'after' => '</div>',
		) );

		genesis_widget_area( 'utility-bar-right', array(
			'before' => '<div class="utility-bar-right">',
			'after' => '</div>',
		) );

		echo '</div></div>';

}

add_action( 'genesis_before_entry_content', 'utility_featured_image' );
/**
 * Add featured image above single posts.
 *
 * @since  1.0.0
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 */
function utility_featured_image() {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() )
		return;

	echo '<div class="featured-image">';
		echo get_the_post_thumbnail( $thumbnail->ID, 'feature-large' );
	echo '</div>';
}

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'utility_custom_footer' );
/**
 * Callback to replace genesis_do_footer.
 *
 * @since 1.0.0
 */
function utility_custom_footer() {
	genesis_widget_area( 'utility-copyright' );
}