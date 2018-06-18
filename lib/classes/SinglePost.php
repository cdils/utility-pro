<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

/**
 * Class SinglePost.
 *
 * @package CDils\UtilityPro
 */
class SinglePost {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Add featured image above posts.
		add_action( 'genesis_entry_header', [ $this, 'featured_image' ], 1 );

		// Reposition post info.
		add_action( 'genesis_entry_header', 'genesis_post_info', 8 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	}

	/**
	 * Add featured image above single posts.
	 *
	 * Outputs image as part of the post content, so it's included in the RSS feed.
	 * H/t to Robin Cornett for the suggestion of making image available to RSS.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Post content.
	 *
	 * @return string Return early if not a single post or there is no thumbnail.
	 *                     Image and content markup otherwise.
	 */
	public function featured_image() {
		if ( ! \is_singular( 'post' ) || ! \has_post_thumbnail() ) {
			return;
		}

		$image  = '<div class="featured-image">';
		$image .= \get_the_post_thumbnail( \get_the_ID(), 'feature-large' );
		$image .= '</div>';

		echo $image;
	}
}
