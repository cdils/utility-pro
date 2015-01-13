<?php
/**
 * Front page for the Utility Pro theme
 *
 * @package Utility_Pro
 * @author Carrie Dils
 * @license GPL-2.0+
 *
 */

add_action( 'genesis_meta', 'utility_pro_homepage_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 *
 * @since 1.0.0
 */
function utility_pro_homepage_setup() {

	$home_sidebars = array(
		'home_welcome' 	   => is_active_sidebar( 'utility-home-welcome' ),
		'home_gallery_1'   => is_active_sidebar( 'utility-home-gallery-1' ),
		'call_to_action'   => is_active_sidebar( 'utility-call-to-action' ),
	);

	// Return early if no sidebars are active
	if ( ! in_array( true, $home_sidebars ) ) {
		return;
	}

	// Add home welcome area if "Home Welcome" widget area is active
	if ( $home_sidebars['home_welcome'] ) {
		add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
	}

	// Add home gallery area if "Home Gallery 1" widget area is active
	if ( $home_sidebars['home_gallery_1'] ) {
		add_action( 'genesis_after_header', 'utility_pro_add_home_gallery' );
	}

	// Add call to action area if "Call to Action" widget area is active
	if ( $home_sidebars['call_to_action'] ) {
		add_action( 'genesis_after_header', 'utility_pro_add_call_to_action' );
	}

	// Remove standard loop and replace with custom
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action ( 'genesis_loop', 'utility_pro_custom_loop' );

	// Remove pagination after posts
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

}

// Display latest posts instead of static page
function utility_pro_custom_loop() {

	global $query_args;
	genesis_custom_loop( wp_parse_args( $query_args, array( 'post_type' => 'post' ) ) );

}

// Display content for the "Home Welcome" section
function utility_pro_add_home_welcome() {

	genesis_widget_area( 'utility-home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);

}

// Display content for the "Home Gallery" section
function utility_pro_add_home_gallery() {

	printf( '<div %s>', genesis_attr( 'home-gallery' ) );
	genesis_structural_wrap( 'home-gallery' );

		genesis_widget_area(
			'utility-home-gallery-1',
			array(
				'before'=> '<div class="home-gallery-1 widget-area">',
				'after'	=> '</div>',
			)
		);

		genesis_widget_area(
			'utility-home-gallery-2',
			array(
				'before'=> '<div class="home-gallery-2 widget-area">',
				'after'	=> '</div>',
			)
		);

		genesis_widget_area(
			'utility-home-gallery-3',
			array(
				'before'=> '<div class="home-gallery-3 widget-area">',
				'after'	=> '</div>',
			)
		);
		genesis_widget_area(
			'utility-home-gallery-4',
			array(
				'before'=> '<div class="home-gallery-4 widget-area">',
				'after'	=> '</div>',
			)
		);

	genesis_structural_wrap( 'home-gallery', 'close' );
	echo '</div>'; // end .home-gallery

}

// Display content for the "Call to action" section
function utility_pro_add_call_to_action() {

	genesis_widget_area(
		'utility-call-to-action',
		array(
			'before' => '<div class="call-to-action-bar"><div class="wrap">',
			'after' => '</div></div>',
		)
	);

}

genesis();
