<?php
/**
 * Template Name: Archive
 *
 * This file modifies the default archive template for Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

__NAMESPACE__ . move_title_description();
/**
 * Reposition archive title & description.
 *
 * Moving the title and description outside of the content <div> allows for
 * cleaner/simpler styling of articles within that <div>.
 *
 * @since 3.0.0
 */
function move_title_description() {

	// If this template is served, is_archive() is true.
	$function_name = "genesis_do_archive_title_description";

	// Check to see if a more specific conditional is true and update $function_name.
	if ( is_category() ) {
		$function_name = "genesis_do_taxonomy_title_description";
	}

	if ( is_author() ) {
		$function_name = "genesis_do_author_title_description";
	}

	if ( is_post_type_archive() ) {
		$function_name = "genesis_do_cpt_title_description";
	}

	if ( is_date() ) {
		$function_name = "genesis_do_date_title_description";
	}

	remove_action( 'genesis_before_loop', $function_name, 15 );
	add_action( 'genesis_before_content_sidebar_wrap', $function_name, 15 );
}


// Reposition featured image.
add_action( 'genesis_entry_header', 'genesis_do_post_image', 4 );
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Reposition post info.
add_action( 'genesis_entry_header', 'genesis_post_info', 8 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove unwanted elements.
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );


\genesis();
