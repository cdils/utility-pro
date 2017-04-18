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
use CDils\UtilityPro\SinglePost;
use CDils\UtilityPro\Tests\TestCase;


/**
 * Class SinglePost.
 *
 * @package CDils\UtilityPro\Tests\Unit
 */
class SinglePostTest extends TestCase {

	/**
	 * Test that single post hooks are applied.
	 */
	public function test_singlepost_hooks_are_applied() {
		( new SinglePost() )->apply();

		static::assertTrue( has_filter( 'the_content', 'CDils\UtilityPro\SinglePost->featured_image()' ),
		'featured_image() not added' );
	}

	/**
	 * Test that featured image is not added when not a single post.
	 */
	public function test_featured_image_is_not_added_when_not_a_single_post() {
		$content = 'content string';

		$expected = $content;

		// Monkey patch WP function!
		Functions::when( 'is_singular' )->justReturn( false );

		static::assertSame( $expected, ( new SinglePost() )->featured_image( $content ) );
	}

	/**
	 * Test that featured image is not added when is a single post but has no thumbnail.
	 */
	public function test_featured_image_is_not_added_when_is_a_single_post_but_has_no_thumbnail() {
		$content = 'content string';

		$expected = $content;

		// Monkey patch WP functions!
		Functions::when( 'is_singular' )->justReturn( true );
		Functions::when( 'has_post_thumbnail' )->justReturn( false );

		static::assertSame( $expected, ( new SinglePost() )->featured_image( $content ) );
	}

	/**
	 * Test that featured image is added when is a single post and has a thumbnail.
	 */
	public function test_featured_image_is_added_when_is_a_single_post_and_has_a_thumbnail() {
		$content   = 'content string';
		$thumbnail = '<img src="">';
		$image     = '<div class="featured-image">' . $thumbnail . '</div>';

		$expected = $image . $content;

		// Monkey patch WP functions!
		Functions::when( 'is_singular' )->justReturn( true );
		Functions::when( 'has_post_thumbnail' )->justReturn( true );
		Functions::when( 'get_the_ID' )->justReturn();
		Functions::when( 'get_the_post_thumbnail' )->justReturn( $thumbnail );

		static::assertSame( $expected, ( new SinglePost() )->featured_image( $content ) );
	}
}
