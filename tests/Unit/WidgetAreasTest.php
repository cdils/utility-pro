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
use Brain\Monkey\WP\Filters;
use BrightNucleus\Config\ConfigFactory;
use BrightNucleus\Config\ConfigInterface;
use CDils\UtilityPro\Tests\TestCase;
use CDils\UtilityPro\WidgetAreas;

/**
 * Class WidgetAreasTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class WidgetAreasTest extends TestCase {

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
			[
				'id'          => 'utility-bar',
				'name'        => 'Utility Bar',
				'description' => 'This is the utility bar across the top of page.',
			],
			[
				'id'          => 'utility-home-welcome',
				'name'        => 'Home Welcome',
				'description' => 'This is the welcome section at the top of the home page.',
			],
		] );
	}

	/**
	 * Test that widget areas are registered.
	 */
	public function test_widget_areas_registration() {
		// Filter is applied.
		Filters::expectApplied( 'utility_pro_default_widget_areas' )
			->once()
			->with( $this->config->getAll() )
			->andReturnUsing( function() {
				return \func_get_arg( 0 ); // Return first arg so other expectations work.
			} );

		// Registration is done with each set of widget configs.
		Functions::expect( 'genesis_register_sidebar' )
			->once()
			->with( [
				'id'          => 'utility-bar',
				'name'        => 'Utility Bar',
				'description' => 'This is the utility bar across the top of page.',
			] );

		Functions::expect( 'genesis_register_sidebar' )
			->once()
			->with( [
				'id'          => 'utility-home-welcome',
				'name'        => 'Home Welcome',
				'description' => 'This is the welcome section at the top of the home page.',
			] );

		( new WidgetAreas( $this->config ) )->register();
	}
}
