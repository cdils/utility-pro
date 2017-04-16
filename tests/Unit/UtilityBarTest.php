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

use CDils\UtilityPro\UtilityBar;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class UtilityBar.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class UtilityBarTest extends TestCase {

	/**
	 * Test that utility bar hooks are applied.
	 */
	public function test_utilitybar_hooks_are_applied() {
		( new UtilityBar() )->apply();

		static::assertTrue( has_action( 'genesis_before_header', 'CDils\UtilityPro\UtilityBar->add_bar()' ),
		'add_bar() not added' );
	}
}
