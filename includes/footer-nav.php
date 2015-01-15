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

	if ( 'footer' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;
}
