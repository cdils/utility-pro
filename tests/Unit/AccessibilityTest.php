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
use CDils\UtilityPro\Accessibility;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class Accessibility.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class AccessibilityTest extends TestCase {

	/**
	 * Test that footer nav hooks are applied.
	 */
	public function test_footernav_hooks_are_applied() {
		( new Accessibility() )->apply();

		static::assertFalse( has_action( 'genesis_after_endwhile', 'genesis_posts_nav' ),
		'genesis_posts_nav() not remove' );
		static::assertTrue( has_action( 'genesis_after_endwhile', 'CDils\UtilityPro\Accessibility->post_pagination()' ),
		'post_pagination() not added.' );
		static::assertTrue( has_filter( 'get_search_form', 'CDils\UtilityPro\Accessibility->get_search_form()', 25 ),
		'get_search_form() not added.' );
		static::assertTrue( has_filter( 'genesis_skip_links_output',  'CDils\UtilityPro\Accessibility->add_secondary_nav_skip_link()' ),
		'add_secondary_nav_skip_link() not added.' );
	}

	/**
	 * Test add secondary nav skip link when menu is footer.
	 */
	public function test_add_secondary_nav_skip_link_when_menu_is_footer() {
		$links = [
			'primary'        => 'a string',
			'content'        => 'b string',
			'footer-widgets' => 'c string',
		];

		$expected = [
			'primary'            => 'a string',
			'content'            => 'b string',
			'footer-widgets'     => 'c string',
			'genesis-nav-footer' => 'Skip to footer navigation',
		];

		Functions::when( '__' )->returnArg( 1 );
		Functions::when( 'has_nav_menu' )->justReturn( true );

		static::assertSame( $expected, ( new Accessibility() )->add_secondary_nav_skip_link( $links ) );
	}

	/**
	 * Test add secondary nav skip link when menu is not footer.
	 */
	public function test_add_secondary_nav_skip_link_when_menu_is_not_footer() {
		$links = [
			'primary'        => 'a string',
			'content'        => 'b string',
			'footer-widgets' => 'c string',
		];

		$expected = $links;

		Functions::when( '__' )->returnArg( 1 );
		Functions::when( 'has_nav_menu' )->justReturn( false );

		static::assertSame( $expected, ( new Accessibility() )->add_secondary_nav_skip_link( $links ) );
	}

	/**
	 * Test get search form.
	 */
	public function test_get_search_form() {
		Functions::when( '__' )->returnArg( 1 );
		Functions::when( 'wp_parse_args' )->returnArg( 1 );
		Functions::when( 'esc_url' )->returnArg( 1 );
		Functions::when( 'esc_attr' )->returnArg( 1 );
		Functions::when( 'home_url' )->justReturn( 'https://example.com' );
		Functions::when( 'get_search_query' )->justReturn( 'test' );

		static::assertContains( 'role="search"', ( new Accessibility() )->get_search_form() );
	}

	/**
	 * Test post pagination when numeric Genesis option is set.
	 */
	public function test_post_pagination_when_numeric() {
		Functions::when( 'genesis_get_option' )->justReturn( 'numeric' );
		Functions::when( '__' )->returnArg( 1 );
		Functions::expect( 'the_posts_pagination' )->once();

		( new Accessibility() )->post_pagination();
	}

	/**
	 * Test post pagination when numeric Genesis option is not set.
	 */
	public function test_post_pagination_when_not_numeric() {
		Functions::when( 'genesis_get_option' )->justReturn( 'foo' );
		Functions::when( '__' )->returnArg( 1 );
		Functions::expect( 'the_posts_navigation' )->once();

		( new Accessibility() )->post_pagination();
	}
}
