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

	// Load mobile responsive menu
	wp_enqueue_script( 'utility-pro-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Localize the responsive menu script (for translation)
	//wp_localize_script( 'utility-pro-responsive-menu', 'utilityResponsiveL10n', array( 'button_label' => __( 'Menu', 'utility-pro' ) ) );

	// Load keyboard navigation script only if Genesis Accessible plugin is not active
	if ( ! utility_pro_genesis_accessible_is_active() ) {
		wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );
	}

	// Replace style.css with style-rtl.css for RTL languages
	wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Load remaining scripts only if custom background is being used
	// and we're on the home page or a page using the landing page template
	if ( ! get_background_image() && ( ! is_front_page() || ! is_page_template( 'page-template-page_landing' ) ) ) {
		return;
	}

	wp_enqueue_script( 'utility-pro-backstretch', get_stylesheet_directory_uri() . '/js/backstretch.min.js', array( 'jquery' ), '2.0.1', true );
	wp_enqueue_script( 'utility-pro-backstretch-args', get_stylesheet_directory_uri() . '/js/backstretch.args.js', array( 'utility-pro-backstretch' ), CHILD_THEME_VERSION, true );

	wp_localize_script( 'utility-pro-backstretch-args', 'utilityBackstretchL10n', array( 'src' => get_background_image() ) );
}
