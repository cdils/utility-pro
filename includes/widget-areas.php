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

/**
 * Register the widget areas enabled by default in Utility.
 *
 * @since  1.0.0
 */
function utility_pro_register_widget_areas() {

	$widget_areas = [
		[
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'utility-pro' ),
			'description' => __( 'This is the utility bar across the top of page.', 'utility-pro' ),
		],
		[
			'id'          => 'utility-home-welcome',
			'name'        => __( 'Home Welcome', 'utility-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
		],
		[
			'id'          => 'utility-home-gallery-1',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 1 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 1 ),
		],
		[
			'id'          => 'utility-home-gallery-2',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 2 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 2 ),
		],
		[
			'id'          => 'utility-home-gallery-3',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 3 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 3 ),
		],
		[
			'id'          => 'utility-home-gallery-4',
			'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 4 ),
			'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 4 ),
		],
		[
			'id'          => 'utility-call-to-action',
			'name'        => __( 'Call to Action', 'utility-pro' ),
			'description' => __( 'This is the Call to Action section on the home page.', 'utility-pro' ),
		],
	];

	$widget_areas = (array) apply_filters( 'utility_pro_default_widget_areas', $widget_areas );

	foreach ( $widget_areas as $widget_area ) {
		genesis_register_widget_area( $widget_area );
	}
}
