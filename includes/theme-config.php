<?php
/**
 * Utility Pro.
 *
 * @package      Utility_Pro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'theme_page_templates', 'utility_pro_remove_genesis_page_templates' );
/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates
 * @return array
 */
function utility_pro_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
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
function utility_pro_get_search_form() {
	$search = new Utility_Pro_Search_Form;
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
 * @see  the_posts_pagination()
 * @return string Markup for pagination links.
 */
function utility_pro_post_pagination() {
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

/**
 * Check whether Genesis Accessible plugin is active.
 *
 * If the Genesis Accessible plugin is in use, disable certain accessibility
 * features in Utility Pro and default to plugin settings to avoid unneccessary
 * scripts from loading.
 *
 * @since  1.0.0
 *
 * @return boolean
 */
function utility_pro_genesis_accessible_is_active() {
   return function_exists( 'genwpacc_genesis_init' );
}
