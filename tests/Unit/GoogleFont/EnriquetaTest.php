<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro\Tests\Unit\GoogleFont
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro\Tests\Unit\GoogleFont;

use Brain\Monkey\Functions;
use CDils\UtilityPro\GoogleFont\Enriqueta;
use CDils\UtilityPro\Tests\TestCase;


/**
 * Class Enriqueta.
 *
 * @package CDils\UtilityPro\Tests\Unit\GoogleFont
 */
class EnriquetaTest extends TestCase {
	/**
	 * Test font is on when flag is not translated
	 */
	public function test_is_on_when_flag_is_not_translated() {
		Functions\when( '_x' )->returnArg( 1 );

		static::assertTrue( ( new Enriqueta() )->is_on() );
	}

	/**
	 * Test font is of when flag is translated.
	 */
	public function test_is_off_when_flag_is_translated() {
		Functions\when( '_x' )->justReturn( 'off' );

		static::assertFalse( ( new Enriqueta() )->is_on() );
	}

	/**
	 * Test returned font family string.
	 */
	public function test_returned_font_family_string() {
		static::assertSame( 'Enriqueta:400,700', ( new Enriqueta() )->font_family() );
	}
}
