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
 * Class Archives.
 *
 * @package CDils\UtilityPro
 */
class Archives {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {

		// Only apply these changes to archives.
		if ( \is_archive() || \is_home() ) {
			echo "This is an archive";
			return;
		}

		// Remove post content.
		remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

		// Remove entry footer markup and post meta.
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
		remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
	}
}
