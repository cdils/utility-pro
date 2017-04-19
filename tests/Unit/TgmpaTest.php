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
use BrightNucleus\Config\ConfigInterface;
use CDils\UtilityPro\Tests\TestCase;
use CDils\UtilityPro\Tgmpa;

/**
 * Class TgmpaTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class TgmpaTest extends TestCase {

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
			'plugins' => [
				[
					'name'     => 'Better Font Awesome', // The plugin name.
					'slug'     => 'better-font-awesome', // The plugin slug (typically the folder name).
					'required' => false, // If false, the plugin is only 'recommended' instead of required.
				],
				[
					'name'     => 'WP Accessibility', // The plugin name.
					'slug'     => 'wp-accessibility', // The plugin slug (typically the folder name).
					'required' => false, // If false, the plugin is only 'recommended' instead of required.
				],
			],
			'config'  => [
				'domain'           => 'utility-pro',              // Text domain - likely want to be the same as your theme.
				'default_path'     => '',                         // Default absolute path to pre-packaged plugins.
				'parent_slug'      => 'themes.php',               // Default parent menu slug.
				'menu'             => 'install-required-plugins', // Menu slug.
			],
		] );
	}

	/**
	 * Test that TGMPA is hooked in to `tgmpa_register`.
	 */
	public function test_tgmpa_is_hooked_in() {
		( new Tgmpa( $this->config ) )->register();

		static::assertTrue( has_action( 'tgmpa_register', 'CDils\UtilityPro\Tgmpa->tgmpa()' ),
		'tgmpa() not added' );
	}

	/**
	 * Test that TGMPA function `tgmpa()` is called.
	 */
	public function test_tgmpa_is_initialised() {
		Functions::expect( 'tgmpa' )
			->once()
			->with( $this->config->getKey( 'plugins' ), $this->config->getKey( 'config' ) );

		( new Tgmpa( $this->config ) )->tgmpa();
	}
}
