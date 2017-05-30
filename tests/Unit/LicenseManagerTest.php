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
use CDils\UtilityPro\LicenseManager;
use Mockery;

/**
 * Class LicenseManagerTest.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class LicenseManagerTest extends TestCase {

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
				'remote_api_url' => 'https://store.carriedils.com', // Site where EDD is hosted.
				'item_name'      => 'Utility Pro',                  // Name of theme.
				'theme_slug'     => 'utility-pro',                  // Theme slug.
				'version'        => '1.0.0',                        // The current version of this theme.
				'author'         => 'Carrie Dils',                  // The author of this theme.
			],
			[
				'theme-license'  => 'Utility Pro License',
				'enter-key'      => 'Enter your theme license key.',
				'license-key'    => 'License Key',
				'license-action' => 'License Action',
			],
		] );
	}

	/**
	 * Test that LicenseManager is initialised.
	 */
	public function test_licensemanager_is_initialised() {
		$updater = Mockery::mock( 'EDD_Theme_Updater_Admin' );

		( new LicenseManager( $this->config ) )->register();

		static::assertTrue( has_action( 'admin_menu', 'CDils\UtilityPro\LicenseManager->move_license_page_menu_item()' ),
		'move_license_page_menu_item() not added' );
	}

	/**
	 * Test that license page menu item is moved when menu item already exists.
	 */
	public function test_move_license_page_menu_item_when_item_exists() {
		$page = [
			'menu title',
			'capability',
			'menu slug',
			'page title',
		];

		Functions\when( 'remove_submenu_page' )->justReturn( $page );
		Functions\expect( 'add_submenu_page' )
			->once()
			->with( 'genesis', $page[3], $page[0], $page[1], $page[2], [ null, 'license_page' ] );

		( new LicenseManager( $this->config ) )->move_license_page_menu_item();
	}

	/**
	 * Test that license page menu item is moved when menu item does not exist.
	 */
	public function test_move_license_page_menu_item_does_not_exist() {
		Functions\when( 'remove_submenu_page' )->justReturn( false );
		Functions\expect( 'add_submenu_page' )->never();

		( new LicenseManager( $this->config ) )->move_license_page_menu_item();
	}
}
