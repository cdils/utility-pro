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
require( get_stylesheet_directory() . '/helpers/text-domain.php' );
require( get_stylesheet_directory() . '/helpers/google-fonts.php' );

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

	// Add support for additional color style options
	add_theme_support( 'genesis-style-selector', array(
		'utility-pro-purple' =>	__( 'Purple', 'utility-pro' ),
		'utility-pro-green'  =>	__( 'Green', 'utility-pro' ),
		'utility-pro-red'    =>	__( 'Red', 'utility-pro' ),
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
		'subnav',
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

	// Reposition the secondary navigation menu
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );
	add_action( 'genesis_before_footer', 'genesis_do_subnav', 15 );

	// Add Utility Bar above header
	add_action( 'genesis_before_header', 'utility_pro_bar' );

	// Add featured image above posts
	add_action( 'genesis_before_entry_content', 'utility_pro_featured_image' );

	// Load skip links (accessibility)
	include_once( get_stylesheet_directory() . '/includes/vendors/genesis-accessible/skip-links.php' );

	// Load form enhancements (accessibility)
	include_once( get_stylesheet_directory() . '/includes/vendors/genesis-accessible/forms.php' );

	// Load files in admin
	if ( is_admin() ) {
		// Plugins
		include_once( get_stylesheet_directory() . '/includes/vendors/tgm-plugin-activation/suggested-plugins.php' );
		// Theme Settings
		include_once( get_stylesheet_directory() . '/helpers/theme-settings/theme-license.php' );
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
		'utility-bar'    => array(
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'utility-pro' ),
			'description' => __( 'This is the the utility bar across the top of page.', 'utility-pro' ),
		),
		'home-welcome'   => array(
			'id'          => 'utility-home-welcome',
			'name'        => __( 'Home Welcome', 'utility-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
		),
		'home-gallery-1' => array(
			'id'          => 'utility-home-gallery-1',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 1 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 1 ),
		),
		'home-gallery-2' => array(
			'id'          => 'utility-home-gallery-2',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 2 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 2 ),
		),
		'home-gallery-3' => array(
			'id'          => 'utility-home-gallery-3',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 3 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 3 ),
		),
		'home-gallery-4' => array(
			'id'          => 'utility-home-gallery-4',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 4 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 4 ),
		),
		'call-to-action' => array(
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Call to Action', 'utility-pro' ),
			'description' => __( 'This is the CTA section at the bottom of the home page.', 'utility-pro' ),
		),
	);

	$widget_areas = apply_filters( 'utility_pro_default_widget_areas', $widget_areas );

	foreach( $widget_areas as $widget_area ) {
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
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/helpers/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Load script for keyboard navigation on dropdown menus (accessibility)
	wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/includes/vendors/genesis-accessible/genwpacc-dropdown.js', array( 'jquery' ), false, true );

    // Replace style.css with style-rtl.css for RTL languages
    wp_style_add_data( 'utility-pro', 'rtl', 'replace' );


wp_reset_query();

	// Load remaining scripts only if custom background is being used and we're on the home page
	if ( ! get_background_image() ||  ! is_front_page() ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . '/helpers/js/backstretch.js', array( 'jquery' ), '2.0.1', true );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . '/helpers/js/backstretch.args.js', array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION, true );

	wp_localize_script( 'utility-pro-backstretch-args', 'utilityL10n', array( 'src' => get_background_image() ) );
}

/**
 * Add utility bar above header.
 *
 * @since 1.0.0
 */
function utility_pro_bar() {

	genesis_widget_area( 'utility-bar', array(
		'before' => '<div class="utility-bar"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

/**
 * Add featured image above single posts.
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 *
 * @since  1.0.0
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

add_filter( 'wp_nav_menu_args', 'utility_pro_secondary_menu_args' );
/**
 * Reduce the secondary navigation menu to one level depth.
 *
 * @param  array $args
 * @return array
 * @since  1.0.0
 */
function utility_pro_secondary_menu_args( $args ) {

	if( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds' );
/**
 * Change the footer text.
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 *
 * @since  1.0.0
 */
function utility_pro_footer_creds( $creds ) {

	return '[footer_copyright first="2015"] &middot; <a href="https://store.carriedils.com/utility-pro">Utility Pro</a> &middot; Powered by the <a href="http://www.carriedils.com/go/genesis">Genesis Framework</a> and <a href="http://wordpress.org">WordPress</a>.';
}

/**
 * Customize the Gravatar size in the author box
 *
 * @since 1.0.0
 */
add_filter( 'genesis_author_box_gravatar_size', 'utility_pro_author_box_gravatar' );
function utility_pro_author_box_gravatar( $size ) {
	return '96';
}

/**
 * Add body class to URL string.
 *
 * Display availabile theme color options via the URL.
 *
 * @todo  remove this from final version - demo only
 */
add_filter( 'body_class', 'string_body_class' );
function string_body_class( $classes ) {

	if ( isset( $_GET['color'] ) ) :
		$classes[] = 'utility-pro-' . sanitize_html_class( $_GET['color'] );
	endif;

	return $classes;
}

/**
 * Generate sitemap.
 *
 * This sitemap is used in conjunction with grunt-exec and grunt-unccss.
 *
 * @todo remove this from final version - dev only
 */
add_action( 'template_redirect', 'show_sitemap' );
function show_sitemap() {
	if ( isset( $_GET['show_sitemap'] ) ) {

		$the_query = new WP_Query( array( 'post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish' ) );
		$urls = array();

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$urls[] = get_permalink();
		}
		die( json_encode($urls) );
	}
}
