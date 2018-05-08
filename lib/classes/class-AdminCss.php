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
 * Class AdminCss.
 *
 * @package CDils\UtilityPro
 */
class AdminCss {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Add admin CSS to Genesis Theme Settings page.
		add_action( 'admin_print_styles', [ $this, 'add_theme_settings_css' ] );
	}

	/**
	 * Add admin CSS to Genesis Theme Settings page.
	 *
	 * @since 2.0.0
	 */
	public function add_theme_settings_css() {
		if ( 'toplevel_page_genesis' !== get_current_screen()->id ) {
			return;
		}

		// Hide the Entry Pagination setting.
		$style = '#genesis-theme-settings-posts tr:nth-child(4){display:none;}';

		wp_add_inline_style( 'genesis_admin_css', $style );
	}
}
