<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function enqueue_assets() {
	$suffix = \defined( 'WP_DEBUG' ) && WP_DEBUG ? '.min.js' : '.js';

	// Replace style.css with style-rtl.css for RTL languages.
	\wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Keyboard navigation (dropdown menus) script.
	\wp_enqueue_script( 'utility-pro-keyboard-dropdown',  \get_stylesheet_directory_uri() . '/js/keyboard-dropdown' . $suffix, [ 'jquery' ], CHILD_THEME_VERSION, true );

	// Load mobile responsive menu.
	\wp_enqueue_script( 'utility-pro-responsive-menu', \get_stylesheet_directory_uri() . '/js/responsive-menu' . $suffix, [ 'jquery' ], '1.0.0', true );

	$localize_primary = [
		'buttonText'     => __( 'Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Primary Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	$localize_footer = [
		'buttonText'     => __( 'Footer Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	// Localize the responsive menu script (for translation).
	\wp_localize_script( 'utility-pro-responsive-menu', 'utilityProMenuPrimaryL10n', $localize_primary );
	\wp_localize_script( 'utility-pro-responsive-menu', 'utilityProMenuFooterL10n', $localize_footer );

	\wp_enqueue_script( 'utility-pro-responsive-menu-args', \get_stylesheet_directory_uri() . '/js/responsive-menu-args' . $suffix, [ 'utility-pro-responsive-menu' ], CHILD_THEME_VERSION, true );

	// Load Backstretch scripts only if custom background is being used
	// and we're on the home page or a page using the landing page template.
	if ( ! \get_background_image() || ( ! ( \is_front_page() || \is_page_template( 'page_landing.php' ) ) ) ) {
		return;
	}

	\wp_enqueue_script( 'utility-pro-backstretch', \get_stylesheet_directory_uri() . '/js/backstretch' . $suffix, [ 'jquery' ], '2.0.1', true );
	\wp_localize_script( 'utility-pro', 'utilityProBackstretchL10n', [
		'src' => \get_background_image(),
	] );
}
