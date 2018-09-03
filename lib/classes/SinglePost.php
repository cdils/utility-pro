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
	}

	/**
	 * Add featured image above single posts.
	 *
	 * @since 1.0.0
	 *
	 * @return string Return early if not a single post or there is no thumbnail.
	 *                     Image and content markup otherwise.
	 */
	public function featured_image() {
		if ( ! \is_singular() || ! \has_post_thumbnail() ) {
			return;
		}

		$image  = '<div class="featured-image">';
		$image .= \get_the_post_thumbnail( \get_the_ID(), 'feature-large' );
		$image .= '</div>';

		echo $image;
	}
}
