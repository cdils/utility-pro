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
use BrightNucleus\Config\ConfigFactory;
use CDils\UtilityPro\ThemeSupport;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class ThemeSupportTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class ThemeSupportTest extends TestCase {

	/**
	 * Test that theme supports are registered.
	 *
	 * @dataProvider dataProvider
	 *
	 * @param string $key   Theme Support key.
	 * @param mixed  $value Theme support value.
	 */
	public function test_theme_support_registration( string $key, $value ) {
		$config = ConfigFactory::createFromArray( [
			$key => $value,
		] );

		Functions\expect( 'add_theme_support' )
			->once()
			->with( $key, $value );

		( new ThemeSupport( $config ) )->register();
	}

	/**
	 * Data provider for test_theme_support_registration.
	 *
	 * @return array
	 */
	public function dataProvider() {
		return [
			[
				'html5',
				// Indexed array value.
				[ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ],
			],
			[
				'genesis-responsive-viewport',
				// Null value.
				null,
			],
			[
				'custom-background',
				// Associative array value.
				[
					'wp-head-callback' => '__return_false',
				],
			],
			[
				'genesis-footer-widgets',
				// Scalar value.
				3,
			],
		];
	}
}
