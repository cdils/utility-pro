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

/**
 * Class UtilityBar.
 *
 * @package CDils\UtilityPro
 */
class UtilityBar {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		add_action( 'genesis_before_header', [ $this, 'add_bar' ] );
	}

	/**
	 * Add Utility Bar above header.
	 *
	 * @since 1.0.0
	 */
	public function add_bar() {
		\genesis_widget_area( 'utility-bar', [
			'before' => '<div class="utility-bar"><div class="wrap">',
			'after'  => '</div></div>',
		] );
	}
}
