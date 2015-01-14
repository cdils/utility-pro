<?php
/**
 * Template Name: Landing
 *
 * This file adds a Landing page template to Utility Pro.
 *
 * @package Utility_Pro
 * @author Carrie Dils
 * @license GPL-2.0+
 *
 */

// Add custom body class to the head
add_filter( 'body_class', 'utility_add_body_class' );
function utility_add_body_class( $classes ) {

   $classes[] = 'utility-landing';
   return $classes;

}

// Full width layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove default Genesis elements
remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Remove elements specific to Utility Pro
remove_action( 'genesis_before_header', 'utility_pro_add_bar' );
remove_action( 'genesis_before_footer', 'utility_pro_do_footer_nav' );

//* Run the Genesis loop
genesis();
