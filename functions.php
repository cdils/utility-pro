<?php
/**
 * Utility Pro.
 *
 * @package      Utility Pro
 * @link         http://store.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2014, Carrie Dils
 * @license      GPL-2.0+
 */

// Load internationalization components
require( get_stylesheet_directory() . '/lib/i18n.php' );

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
	define( 'CHILD_THEME_URL', 'http://store.carriedils.com/utility-pro' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background
	add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

	// Add support for additional color style options
	add_theme_support( 'genesis-style-selector', array(
		'utility-purple' =>	__( 'Purple', 'utility-pro' ),
		'utility-green'  =>	__( 'Green', 'utility-pro' ),
		'utility-orange' =>	__( 'Orange', 'utility-pro' ),
		'utility-red'    =>	__( 'Red', 'utility-pro' ),
	));

	// Add support for structural wraps
	add_theme_support( 'genesis-structural-wraps', array(
		'footer',
		'footer-widgets',
		'header',
		'home-gallery',
		'nav',
		'site-inner',
		'site-tagline',
		'subnav'
	) );

	// Add support for three footer widget areas
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add custom image sizes
	add_image_size( 'feature-large', 960, 330, true );

	// Unregister secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );

	// Register the default widget areas
	utility_pro_register_widget_areas();

	// Queue scripts used for the front end
	add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_assets' );

	// Load skip links
	include_once( get_stylesheet_directory() . '/lib/skip-links.php' );

	// Load heading fixes for better accessibility
	include_once( get_stylesheet_directory() . '/lib/headings.php' );
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
		'utility-bar-left' => array(
			'id'          => 'utility-bar-left',
			'name'        => __( 'Utility Bar Left', 'utility-pro' ),
			'description' => __( 'This is the left side of the utility bar across the top of page.', 'utility-pro' ),
		),
		'utility-bar-right' => array(
			'id'          => 'utility-bar-right',
			'name'        => __( 'Utility Bar Right', 'utility-pro' ),
			'description' => __( 'This is the right side of the utility bar across the top of page.', 'utility-pro' ),
		),
		'home-welcome' => array(
			'id'          => 'utility-home-welcome',
			'name'        => __( 'Home Welcome', 'utility-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
		),
		'home-gallery-1' => array(
			'id'          => 'utility-home-gallery-1',
			'name'        => __( 'Home Gallery 1', 'utility-pro' ),
			'description' => __( 'This is the 1st gallery section in the middle of the home page.', 'utility-pro' ),
		),
		'home-gallery-2' => array(
			'id'          => 'utility-home-gallery-2',
			'name'        => __( 'Home Gallery 2', 'utility-pro' ),
			'description' => __( 'This is the 2nd gallery section in the middle of the home page.', 'utility-pro' ),
		),
		'home-gallery-3' => array(
			'id'          => 'utility-home-gallery-3',
			'name'        => __( 'Home Gallery 3', 'utility-pro' ),
			'description' => __( 'This is the 3rd gallery section in the middle of the home page.', 'utility-pro' ),
		),
		'home-gallery-4' => array(
			'id'          => 'utility-home-gallery-4',
			'name'        => __( 'Home Gallery 4', 'utility-pro' ),
			'description' => __( 'This is the 4th gallery section in the middle of the home page.', 'utility-pro' ),
		),
		'call-to-action' => array(
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Call to Action', 'utility-pro' ),
			'description' => __( 'This is the CTA section at the bottom of the home page.', 'utility-pro' ),
		),
		'copyright' => array(
			'id'          => 'utility-copyright',
			'name'        => __( 'Copyright', 'utility-pro' ),
			'description' => __( 'This is the copyright section at the bottom of the page.', 'utility-pro' ),
		),
	);

	$widget_areas = apply_filters( 'utility_pro_default_widget_areas', $widget_areas );

	foreach( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}

/**
 * Enqueue theme assets.
 *
 * @see utility_pro_fonts_url()
 * @since 1.0.0
 */
function utility_pro_enqueue_assets() {

	// Load Google fonts
    wp_enqueue_style( 'utility-pro-fonts', utility_pro_fonts_url(), array(), null );

    // Load Font Awesome stylsheet
	wp_enqueue_style( 'utility-font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css', array(), '4.1.0' );

    // Replace style.css with style-rtl.css for RTL languages
    wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Load remaining scripts only if custom background is being used
	if ( ! get_background_image() ) {
		return;
	}

	wp_enqueue_script( 'utility-backstretch', get_stylesheet_directory_uri() . "/lib/js/backstretch.js", array( 'jquery' ), '2.0.1' );
	wp_enqueue_script( 'utility-backstretch-args', get_stylesheet_directory_uri() . "/lib/js/backstretch.args.js", array( 'utility-backstretch' ), CHILD_THEME_VERSION );

	wp_localize_script( 'utility-backstretch-args', 'utilityL10n', array( 'src' => get_background_image() ) );

}

add_action( 'genesis_before_header', 'utility_pro_bar' );
/**
 * Add utility bar above header.
 *
 * @since 1.0.0
 */
function utility_pro_bar() {

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

add_action( 'genesis_before_entry_content', 'utility_pro_featured_image' );
/**
 * Add featured image above single posts.
 *
 * @since  1.0.0
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 */
function utility_pro_featured_image() {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return;
	}

	global $post;

	echo '<div class="featured-image">';
		echo get_the_post_thumbnail( $post->ID, 'feature-large' );
	echo '</div>';
}

remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'utility_pro_custom_footer' );
/**
 * Callback to replace genesis_do_footer.
 *
 * @since 1.0.0
 */
function utility_pro_custom_footer() {
	genesis_widget_area( 'utility-copyright' );
}

add_filter( 'comment_form_defaults', 'remove_comment_form_allowed_tags' );
/**
 * Get rid of the comment notes section after comment box.
 *
 * This is the annoying box telling users they can use HTML tags, etc. in comments.
 * Not useful for the average user IMHO. Remove this function entirely if you want
 * it back.
 *
 * @since  1.0.0
 */
function remove_comment_form_allowed_tags( $defaults ) {

	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* To-do remove this from final version - demo only
add_filter('body_class', 'string_body_class');
function string_body_class( $classes ) {
	if ( isset( $_GET['color'] ) ) :
		$classes[] = 'utility-pro-' . sanitize_html_class( $_GET['color'] );
	endif;

	return $classes;
}
