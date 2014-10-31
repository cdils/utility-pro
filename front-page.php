<?php
/**
 * Utility Pro.
 *
 * @package      Utility Pro
 * @link         http://www.carriedils.com/utility
 * @author       Carrie Dils <carrie@carriedils.com>
 * @copyright    Copyright (c) 2013, Carrie Dils
 * @license      GPL-2.0+
 */

add_action( 'genesis_after_header', 'utility_pro_homepage_widgets' );
/**
 * Output home page widget areas.
 *
 * @since 1.0.0
 */
function utility_pro_homepage_widgets() {

		genesis_widget_area( 'utility-home-welcome', array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		) );

		printf( '<div %s>', genesis_attr( 'home-gallery' ) );
		genesis_structural_wrap( 'home-gallery' );

			genesis_widget_area( 'utility-home-gallery-1', array(
				'before'=> '<div class="home-gallery-1 widget-area">',
				'after'	=> '</div>',
			) );

			genesis_widget_area( 'utility-home-gallery-2', array(
				'before'=> '<div class="home-gallery-2 widget-area">',
				'after'	=> '</div>',
			) );

			genesis_widget_area( 'utility-home-gallery-3', array(
				'before'=> '<div class="home-gallery-3 widget-area">',
				'after'	=> '</div>',
			) );

			genesis_widget_area( 'utility-home-gallery-4', array(
				'before'=> '<div class="home-gallery-4 widget-area">',
				'after'	=> '</div>',
			) );

		genesis_structural_wrap( 'home-gallery', 'close' );
		echo '</div>'; //* end .home-gallery

		genesis_widget_area( 'utility-call-to-action', array(
			'before' => '<div class="call-to-action-bar"><div class="wrap">',
			'after' => '</div></div>',
		) );

}

genesis();