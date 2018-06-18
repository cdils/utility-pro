<?php
/**
 * Template Name: Landing
 *
 * This file adds a front page template to Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

add_action( 'genesis_meta', __NAMESPACE__ . '\\homepage_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 *
 * @since 1.0.0
 */
function homepage_setup() {
	$home_sidebars = [
		'home_welcome'   => \is_active_sidebar( 'utility-home-welcome' ),
		'home_gallery_1' => \is_active_sidebar( 'utility-home-gallery-1' ),
		'call_to_action' => \is_active_sidebar( 'utility-call-to-action' ),
	];

	// Return early if no sidebars are active.
	if ( ! \in_array( true, $home_sidebars, true ) ) {
		return;
	}

	// Get static home page number.
	$page = \get_query_var( 'page' ) ? (int) \get_query_var( 'page' ) : 1;

	// Only show home page widgets on page 1.
	if ( 1 === $page ) {

		// Add home welcome area if "Home Welcome" widget area is active.
		if ( $home_sidebars['home_welcome'] ) {
			add_action( 'genesis_after_header', __NAMESPACE__ . '\\add_home_welcome' );
		}

		// Add home gallery area if "Home Gallery 1" widget area is active.
		if ( $home_sidebars['home_gallery_1'] ) {
			add_action( 'genesis_after_header', __NAMESPACE__ . '\\add_home_gallery' );
		}

		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['call_to_action'] ) {
			add_action( 'genesis_after_header', __NAMESPACE__ . '\\add_call_to_action' );
		}
	}

	// Filter site title markup to include an h1.
	add_filter( 'genesis_site_title_wrap', __NAMESPACE__ . '\\return_h1' );

	// Remove standard loop that would show Page content.
	remove_action( 'genesis_loop', 'genesis_do_loop' );
}

/**
 * Use h1 for site title on a static front page.
 *
 * Hat tip to Bill Erickson for the suggestion.
 *
 * @see http://www.billerickson.net/genesis-h1-front-page/
 *
 * @since 1.2.0
 */
function return_h1() {
	return 'h1';
}

/**
 * Display content for the "Home Welcome" section.
 *
 * @since 1.0.0
 */
function add_home_welcome() {
	\genesis_widget_area( 'utility-home-welcome',
		[
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		]
	);
}

/**
 * Display content for the "Home Gallery" section.
 *
 * @since 1.0.0
 */
function add_home_gallery() {
	\printf( '<div %s>', \genesis_attr( 'home-gallery' ) );
	\genesis_structural_wrap( 'home-gallery' );

	foreach ( \range( 1, 4 ) as $widget_area_id ) {
		\genesis_widget_area(
			'utility-home-gallery-' . $widget_area_id,
			[
				'before' => '<div class="home-gallery-' . $widget_area_id . ' widget-area">',
				'after'  => '</div>',
			]
		);
	}

	\genesis_structural_wrap( 'home-gallery', 'close' );
	echo '</div>';
}

/**
 * Display content for the "Call to action" section.
 *
 * @since 1.0.0
 */
function add_call_to_action() {
	\genesis_widget_area(
		'utility-call-to-action',
		[
			'before' => '<div class="call-to-action-bar"><div class="wrap">',
			'after'  => '</div></div>',
		]
	);
}

\genesis();
