<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

// Enable shortcodes in widgets.
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'theme_page_templates',  __NAMESPACE__ . '\\remove_genesis_page_templates' );
/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates Existing recognised page templates.
 * @return array Amended recognised page templates.
 */
function remove_genesis_page_templates( array $page_templates ) : array {
	unset( $page_templates['page_blog.php'] );

	return $page_templates;
}

add_filter( 'genesis_attr_nav-footer',  __NAMESPACE__ . '\\add_nav_secondary_id' );
/**
 * Add ID to footer nav.
 *
 * In order to use skip links with the footer menu, the menu needs an
 * ID to anchor the link to. Hat tip to Robin Cornett for the tutorial.
 *
 * @link http://robincornett.com/genesis-responsive-menu/
 *
 * @since 1.2.1
 * @param array $attributes Optional. Extra attributes to merge with defaults.
 * @return array Merged and filtered attributes.
 */
function add_nav_secondary_id( array $attributes ) : array {
	$attributes['id'] = 'genesis-nav-footer';

	return $attributes;
}

add_filter( 'genesis_skip_links_output', __NAMESPACE__ . '\\add_nav_secondary_skip_link' );
/**
 * Add skip link to footer navigation.
 *
 * @since 1.2.1
 *
 * @param array $links Default skiplinks.
 * @return array Amended markup for Genesis skip links.
 */
function add_nav_secondary_skip_link( array $links ) : array {
	$new_links = $links;
	array_splice( $new_links, 1 );

	if ( has_nav_menu( 'footer' ) ) {
		$new_links['genesis-nav-footer'] = __( 'Skip to footer navigation', 'utility_pro' );
	}

	return array_merge( $new_links, $links );
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
function get_search_form() : string {
	$search = new SearchForm;

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
function post_pagination() {
	$args = array(
		'mid_size' => 2,
		'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'utility-pro' ) . ' </span>',
	);

	if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
		the_posts_pagination( $args );
	} else {
		the_posts_navigation( $args );
	}
}
