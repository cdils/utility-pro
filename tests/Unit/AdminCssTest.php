<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro\Tests\Unit
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro\Tests\Unit;

use Brain\Monkey\Functions;
use CDils\UtilityPro\AdminCss;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class AdminCssTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class AdminCssTest extends TestCase {

	/**
	 * Test that hooks are applied.
	 */
	public function test_hooks_are_applied() {
		( new AdminCss() )->apply();

		static::assertTrue( has_action( 'admin_print_styles', 'CDils\UtilityPro\AdminCss->add_theme_settings_css()' ),
		'add_theme_settings_css() not added' );
	}

	/**
	 * Test that wp_add_inline_style is not called when not on the Genesis theme settings page.
	 */
	public function test_css_is_not_added_when_not_on_genesis_theme_settings_page() {
		$genesis_mock_screen = new \stdClass();
		$genesis_mock_screen->id = 'not_toplevel_page_genesis';
		Functions\when( 'get_current_screen' )->justReturn( $genesis_mock_screen );

		Functions\expect( 'wp_add_inline_style' )->never();

		( new AdminCss() )->add_theme_settings_css();
	}

	/**
	 * Test that wp_add_inline_style is not called when not on the Genesis theme settings page.
	 */
	public function test_css_is_added_when_on_genesis_theme_settings_page() {
		$genesis_mock_screen = new \stdClass();
		$genesis_mock_screen->id = 'toplevel_page_genesis';
		Functions\when( 'get_current_screen' )->justReturn( $genesis_mock_screen );

		Functions\expect( 'wp_add_inline_style' )->once();

		( new AdminCss() )->add_theme_settings_css();
	}
}
