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
use CDils\UtilityPro\Footer;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class Footer.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class FooterTest extends TestCase {
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
			'creds' => 'Some footer credentials.',
		] );
	}

	/**
	 * Test that utlity bar hooks are applied.
	 */
	public function test_footer_hooks_are_applied() {
		( new Footer( $this->config ) )->apply();

		static::assertTrue( has_filter( 'genesis_footer_creds_text', 'CDils\UtilityPro\Footer->creds_text()' ),
		'creds_text() not added' );
	}

	/**
	 * Test methods returns creds text from config.
	 */
	public function test_gets_creds_text_from_config() {
		static::assertSame( 'Some footer credentials.', ( new Footer( $this->config ) )->creds_text() );
	}
}
