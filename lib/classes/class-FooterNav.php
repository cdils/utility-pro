<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

/**
 * Class FooterNav.
 *
 * @package CDils\UtilityPro
 */
class FooterNav {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Add a navigation area above the site footer.
		add_action( 'genesis_before_footer', [ $this, 'do_footer_nav' ] );
		// Set footer menu arguments.
		add_filter( 'wp_nav_menu_args', [ $this, 'footer_menu_args' ] );
		// Add schema markup to Footer Navigation Menu.
		add_filter( 'genesis_attr_nav-footer', 'genesis_attributes_nav' );
		// Add ID to footer nav.
		add_filter( 'genesis_attr_nav-footer',  [ $this, 'add_nav_secondary_id' ] );
	}

	/**
	 * Output footer navigation menu.
	 *
	 * @since  1.0.0
	 */
	public function do_footer_nav() {
		echo \wp_kses_post(
			\genesis_get_nav_menu(
				[
					'menu_class'     => 'menu genesis-nav-menu menu-footer',
					'theme_location' => 'footer',
				]
			)
		);
	}

	/**
	 * Reduce the footer navigation menu to one level depth.
	 *
	 * @since  1.0.0
	 *
	 * @param  array $args Existing footer menu args.
	 * @return array Amended footer menu args.
	 */
	public function footer_menu_args( array $args ) : array {
		if ( 'footer' !== $args['theme_location'] ) {
			return $args;
		}

		$args['depth'] = 1;

		return $args;
	}

	/**
	 * Add ID to footer nav.
	 *
	 * In order to use skip links with the footer menu, the menu needs an
	 * ID to anchor the link to. Hat tip to Robin Cornett for the tutorial.
	 *
	 * @link http://robincornett.com/genesis-responsive-menu/
	 *
	 * @since 1.2.1
	 * @param array $attributes Optional. Extra attributes to merge with defaults.
	 * @return array Merged and filtered attributes.
	 */
	public function add_nav_secondary_id( array $attributes ) : array {
		$attributes['id'] = 'genesis-nav-footer';

		return $attributes;
	}
}
