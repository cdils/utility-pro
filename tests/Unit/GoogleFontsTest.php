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
use CDils\UtilityPro\GoogleFont;
use CDils\UtilityPro\GoogleFonts;
use CDils\UtilityPro\Tests\TestCase;
use Mockery;

/**
 * Class GoogleFonts.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class GoogleFontsTest extends TestCase {

	/**
	 * Fake font 1.
	 *
	 * @var GoogleFont
	 */
	protected $fake_font;

	/**
	 * Fake font 3.
	 *
	 * @var GoogleFont
	 */
	protected $fake_font2;

	/**
	 * Fake font 3.
	 *
	 * @var GoogleFont
	 */
	protected $fake_font3;

	/**
	 * Prepares the test environment before each test.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function setUp() {
		parent::setUp();

		$this->fake_font = Mockery::mock( GoogleFont::class );
		$this->fake_font->shouldReceive( 'is_on' )->andReturn( true );
		$this->fake_font->shouldReceive( 'font_family' )->andReturn( 'font:300' );

		$this->fake_font2 = Mockery::mock( GoogleFont::class );
		$this->fake_font2->shouldReceive( 'is_on' )->andReturn( false );

		$this->fake_font3 = Mockery::mock( GoogleFont::class );
		$this->fake_font3->shouldReceive( 'is_on' )->andReturn( true );
		$this->fake_font3->shouldReceive( 'font_family' )->andReturn( 'Spaced font:400,700' );
	}

	/**
	 * Test that fonts can be added to registry, without duplication,
	 * and only for fonts not disabled by translators.
	 */
	public function test_add_to_registry() {
		$google_fonts = new GoogleFonts();
		static::assertCount( 0, $google_fonts->get_fonts() );

		$google_fonts->add( 'fake-font', $this->fake_font );
		static::assertCount( 1, $google_fonts->get_fonts() );

		// Attempt to add the same one again - it should not change the count.
		$google_fonts->add( 'fake-font', $this->fake_font );
		static::assertCount( 1, $google_fonts->get_fonts() );

		// Attempt to add the disabled font - it should not change the count.
		$google_fonts->add( 'fake-font2', $this->fake_font2 );
		static::assertCount( 1, $google_fonts->get_fonts() );
	}

	/**
	 * Test that no styles are enqueued when registry is empty.
	 */
	public function test_no_styles_are_enqueued_when_registry_is_empty() {
		Functions::expect( 'wp_enqueue_style' )->never();

		( new GoogleFonts() )->enqueue();
	}

	/**
	 * Test that styles are enqueued when registry is not empty.
	 */
	public function test_styles_are_enqueued_when_registry_is_not_empty() {
		Functions::expect( 'wp_enqueue_style' )->once();
		Functions::when( 'add_query_arg' )->justReturn( '' );

		$google_fonts = new GoogleFonts();
		$google_fonts->add( 'fake-font', $this->fake_font );
		$google_fonts->enqueue();
	}

	/**
	 * Test constructed fonts URL is correct.
	 */
	public function test_fonts_url() {
		$query_args = [
			'family' => 'font%3A300%7CSpaced%20font%3A400%2C700',
			'subset' => 'latin%2Clatin-ext',
		];

		$expected_fonts_url = 'https://fonts.googleapis.com/css?family=font:300|Spaced+font:400,700&subset=latin,latin-ext';

		Functions::expect( 'add_query_arg' )
			->with( $query_args, 'https://fonts.googleapis.com/css' )
			->once()
			->andReturn( $expected_fonts_url );

		Functions::expect( 'wp_enqueue_style' )
			->with( 'utility-pro-fonts', $expected_fonts_url, [], null )
			->once();

		$google_fonts = new GoogleFonts();
		$google_fonts->add( 'fake-font', $this->fake_font );
		$google_fonts->add( 'fake-font2', $this->fake_font2 );
		$google_fonts->add( 'fake-font3', $this->fake_font3 );
		$google_fonts->enqueue();
	}
}
