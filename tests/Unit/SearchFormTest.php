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
use Brain\Monkey\Filters;
use CDils\UtilityPro\SearchForm;
use CDils\UtilityPro\Tests\TestCase;

/**
 * Class SearchForm.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class SearchFormTest extends TestCase {
	/**
	 * Test search form is initialised with filters applied to default strings.
	 */
	public function test_searchform_is_initialised_with_default_strings() {
		Functions\when( '__' )->returnArg( 1 );

		Filters\expectApplied( 'genesis_search_form_label' )
			->once()
			->with( 'Search site' )
			->andReturnFirstArg();

		Filters\expectApplied( 'genesis_search_text' )
			->once()
			->with( '' )
			->andReturnFirstArg();

		Filters\expectApplied( 'genesis_search_button_text' )
			->once()
			->with( 'Search' )
			->andReturnFirstArg();

		Filters\expectApplied( 'genesis_search_button_label' )
			->once()
			->with( 'Search' )
			->andReturnFirstArg();

		$default_strings = [
			'label'        => 'Search site',
			'placeholder'  => '',
			'button'       => 'Search',
			'button_label' => 'Search',
		];

		Functions\expect( 'wp_parse_args' )
			->with( [], $default_strings )
			->once();

		new SearchForm();
	}

	/**
	 * Test search form is initialised with filters applied to default strings.
	 */
	public function test_searchform_is_initialised_with_custom_strings() {
		Functions\when( '__' )->returnArg( 1 );

		$default_strings = [
			'label'        => 'Search site',
			'placeholder'  => '',
			'button'       => 'Search',
			'button_label' => 'Search',
		];

		$custom_strings = [
			'label'        => 'foo',
			'placeholder'  => 'bar',
			'button'       => 'baz',
			'button_label' => 'boom',
		];

		Functions\expect( 'wp_parse_args' )
			->with( $custom_strings, $default_strings )
			->once();

		new SearchForm( $custom_strings );
	}

	/**
	 * Test get search form.
	 */
	public function test_get_search_form() {
		Functions\when( '__' )->returnArg( 1 );
		Functions\when( 'wp_parse_args' )->returnArg( 1 );
		Functions\when( 'esc_url' )->returnArg( 1 );
		Functions\when( 'esc_attr' )->returnArg( 1 );
		Functions\when( 'home_url' )->justReturn( 'https://example.com' );
		Functions\when( 'get_search_query' )->justReturn( 'test' );

		static::assertContains( 'role="search"', ( new SearchForm() )->get_form() );
	}
}
