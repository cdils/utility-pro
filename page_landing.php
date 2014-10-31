<?php
/**
 * This file adds the Landing template to the Utility Theme.
 *
 * @author Carrie Dils
 * @package Utility Pro
 * @subpackage Customizations
 */

/*
Template Name: Landing
*/

// Add custom body class to the head
add_filter( 'body_class', 'utility_add_body_class' );
function utility_add_body_class( $classes ) {

   $classes[] = 'utility-landing';
   return $classes;

}

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

//* Remove Utility Bar
remove_action( 'genesis_before_header', 'utility_bar' );

//* Remove site header elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

//* Remove navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_header', 'genesis_do_subnav' );

//* Remove breadcrumbs
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Remove site footer widgets
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

//* Remove site footer elements
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//* Remove Custom Utility Copyright
remove_action( 'genesis_footer', 'utility_custom_footer' );

//* Run the Genesis loop
genesis();
