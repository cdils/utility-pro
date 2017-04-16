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
 * Class Accessibility.
 *
 * @package CDils\UtilityPro
 */
class Accessibility {

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Remove Genesis archive pagination (Genesis pagination settings still apply).
		remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

		// Add WordPress archive pagination (accessibility).
		add_action( 'genesis_after_endwhile', [ $this, 'post_pagination' ] );

		// Apply search form enhancements (accessibility).
		add_filter( 'get_search_form', [ $this, 'get_search_form' ], 25 );

		add_filter( 'genesis_skip_links_output', [ $this, 'add_nav_secondary_skip_link' ] );
	}

	/**
	 * Add skip link to footer navigation.
	 *
	 * @since 1.2.1
	 *
	 * @param array $links Default skiplinks.
	 * @return array Amended markup for Genesis skip links.
	 */
	public function add_nav_secondary_skip_link( array $links ) : array {
		$new_links = $links;
		$new_links = \array_reverse( $new_links );
		\array_splice( $new_links, 1 );

		if ( \has_nav_menu( 'footer' ) ) {
			$new_links['genesis-nav-footer'] = __( 'Skip to footer navigation', 'utility-pro' );
		}

		return \array_merge( $links, $new_links );
	}

	/**
	 * Customize the search form to improve accessibility.
	 *
	 * The instantiation can accept an array of custom strings, should you want
	 * the search form have different strings in different contexts.
	 *
	 * @since 1.0.0
	 *
	 * @return string Search form markup.
	 */
	public function get_search_form() : string {
		$search = new SearchForm();

		return $search->get_form();
	}

	/**
	 * Use WordPress archive pagination.
	 *
	 * Return a paginated navigation to next/previous set of posts, when
	 * applicable. Includes screen reader text for better accessibility.
	 *
	 * @since  1.0.0
	 *
	 * @see the_posts_pagination()
	 */
	public function post_pagination() {
		$args = [
			'mid_size' => 2,
			'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'utility-pro' ) . ' </span>',
		];

		if ( 'numeric' === \genesis_get_option( 'posts_nav' ) ) {
			\the_posts_pagination( $args );
		} else {
			\the_posts_navigation( $args );
		}
	}
}
