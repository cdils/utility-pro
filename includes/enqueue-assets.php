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

add_action( 'wp_enqueue_scripts', 'utility_pro_enqueue_assets' );
/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function utility_pro_enqueue_assets() {

	// Replace style.css with style-rtl.css for RTL languages.
	wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Keyboard navigation (dropdown menus) script.
	wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );

	// Load mobile responsive menu.
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.min.js', array( 'jquery' ), '1.0.0', true );

	$localize_primary = array(
		'buttonText'     => __( 'Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Primary Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	);

	$localize_footer = array(
		'buttonText'     => __( 'Footer Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	);

	// Localize the responsive menu script (for translation).
	wp_localize_script( 'utility-pro-responsive-menu', 'utilityMenuPrimaryL10n', $localize_primary );
	wp_localize_script( 'utility-pro-responsive-menu', 'utilityMenuFooterL10n', $localize_footer );

	wp_enqueue_script( 'utility-pro', get_stylesheet_directory_uri() . '/js/responsive-menu.args.js', array( 'utility-pro-responsive-menu' ), CHILD_THEME_VERSION, true );

	// Load Backstretch scripts only if custom background is being used
	// and we're on the home page or a page using the landing page template.
	if ( ! get_background_image() || ( ! ( is_front_page() || is_page_template( 'page_landing.php' ) ) ) ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.min.js', array( 'jquery' ), '2.0.1', true );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . '/js/backstretch.args.js', array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION, true );
	wp_localize_script( 'utility-pro', 'utilityBackstretchL10n', array( 'src' => get_background_image() ) );

}
