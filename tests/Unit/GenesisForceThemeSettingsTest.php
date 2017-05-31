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

use BrightNucleus\Config\ConfigFactory;
use BrightNucleus\Config\ConfigInterface;
use CDils\UtilityPro\GenesisForceThemeSettings;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class GenesisForceThemeSettingsTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class GenesisForceThemeSettingsTest extends TestCase {
	/**
	 * Test config.
	 *
	 * @var ConfigInterface
	 */
	protected $config;

	/**
	 * Prepares the test environment before each test.
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->config = ConfigFactory::createFromArray( [
			'a_key' => 'A value',
			'b_key' => 'Another value',
		] );
	}

	/**
	 * Test that force theme defaults hooks are applied.
	 */
	public function test_defaults_hooks_are_applied() {
		( new GenesisForceThemeSettings( $this->config ) )->apply();

		static::assertTrue( has_filter( 'genesis_theme_settings_defaults', 'CDils\UtilityPro\GenesisForceThemeSettings->theme_settings_defaults()' ),
		'theme_settings_defaults() not added' );
	}

	/**
	 * Test that force theme defaults hooks are applied.
	 */
	public function test_forced_value_hooks_are_applied() {
		( new GenesisForceThemeSettings( $this->config ) )->force_values();

		static::assertTrue( has_filter( 'genesis_pre_get_option_a_key', 'function ()' ), 'Closure not added' );

		static::assertTrue( has_filter( 'genesis_pre_get_option_b_key', 'function ()' ), 'Closure not added' );
	}
}
