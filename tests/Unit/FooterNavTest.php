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
use CDils\UtilityPro\FooterNav;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class FooterNav.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class FooterNavTest extends TestCase {

	/**
	 * Test that footer nav hooks are applied.
	 */
	public function test_footernav_hooks_are_applied() {
		Functions\when( 'genesis_attributes_nav' );

		( new FooterNav() )->apply();

		static::assertTrue( has_action( 'genesis_before_footer', 'CDils\UtilityPro\FooterNav->do_footer_nav()' ),
		'do_footer_nav() not added' );
		static::assertTrue( has_filter( 'wp_nav_menu_args', 'CDils\UtilityPro\FooterNav->footer_menu_args()' ),
		'footer_menu_args() not added.' );
		static::assertTrue( has_filter( 'genesis_attr_nav-footer', 'genesis_attributes_nav' ),
		'genesis_attributes_nav() not added.' );
		static::assertTrue( has_filter( 'genesis_attr_nav-footer',  'CDils\UtilityPro\FooterNav->add_nav_secondary_id()' ),
		'add_nav_secondary_id() not added.' );
	}

	/**
	 * Test that menu args are amended for footer location menu.
	 */
	public function test_footer_menu_args_correct_location() {
		$args = [
			'theme_location' => 'footer',
		];

		$expected = [
			'theme_location' => 'footer',
			'depth' => 1,
		];

		static::assertSame( $expected, ( new FooterNav() )->footer_menu_args( $args ) );
	}

	/**
	 * Test that menu args are not amended for other menu locations.
	 */
	public function test_footer_menu_args_incorrect_location() {
		$args = [
			'theme_location' => 'primary',
		];

		$expected = $args;

		static::assertSame( $expected, ( new FooterNav() )->footer_menu_args( $args ) );
	}

	/**
	 * Test that secondary nav ID is added.
	 */
	public function test_add_nav_secondary_id() {
		$attributes = [];

		$expected = [
			'id' => 'genesis-nav-footer',
		];

		static::assertSame( $expected, ( new FooterNav() )->add_nav_secondary_id( $attributes ) );
	}
}
