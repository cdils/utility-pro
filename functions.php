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
require( get_stylesheet_directory() . '/inc/i18n.php' );

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
	add_theme_support( 'genesis-reutility_proonsive-viewport' );

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

	// Queue scripts used for the front end
	add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_assets' );

	// Add Utility Bar above header
	add_action( 'genesis_before_header', 'utility_pro_bar' );

	// Add featured image above posts
	add_action( 'genesis_before_entry_content', 'utility_pro_featured_image' );

	// Load skip links (accessibility)
	include_once( get_stylesheet_directory() . '/inc/skip-links.php' );

	// Load files in admin
	if ( is_admin() ) {
		// Plugins
		include_once( get_stylesheet_directory() . '/inc/plugins/plugins.php' );
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
		'utility-bar' => array(
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'utility-pro' ),
			'description' => __( 'This is the the utility bar across the top of page.', 'utility-pro' ),
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

	// Load Google fonts (see /lib/i18n.php for font family information)
    wp_enqueue_style( 'utility-pro-fonts', utility_pro_fonts_url(), array(), null );

    // Load mobile responsive menu
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/lib/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Load script to fixes issues with keyboard accessibility
	wp_enqueue_script( 'genwpacc-dropdown', get_stylesheet_directory() . '/lib/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );

    // Replace style.css with style-rtl.css for RTL languages
    wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Load remaining scripts only if custom background is being used
	if ( ! get_background_image() ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . "/lib/js/backstretch.js", array( 'jquery' ), '2.0.1' );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . "/lib/js/backstretch.args.js", array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION );

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
function utility_pro_secondary_menu_args( $args ){

	if( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds');
/**
 * Change the footer text.
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 *
 * @since  1.0.0
 */
function utility_pro_footer_creds( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://store.carriedils.com/utility-pro">Utility Pro</a> &middot; Powered by the <a href="http://www.carriedils.com/go/genesis" title="Genesis Framework">Genesis Framework</a> and <a href="http://wordpress.org">WordPress</a>.';
	return $creds;
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

	if (isset($_GET['show_sitemap'])) {

		$the_query = new WP_Query( array( 'post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish' ) );
		$urls = array();

		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$urls[] = get_permalink();
		}
		die(json_encode($urls));
	}
}
