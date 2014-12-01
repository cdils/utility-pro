<?php
/** skip-links.php
*	Description: Adds skiplinks after the header to content, menu's and asides.
*	Author: Rian Rietveld
*	Plugin URI: http://genesis-accessible.org/
*	License: GPLv2 or later
*/

/** Add skiplinks for screen readers and keyboard navigation
*
* @since 1.0.0
*/
add_action ( 'genesis_before_header', 'utility_skip_links', 5 );
function utility_skip_links() {

    $site_layout = genesis_site_layout();

	// set defaults
	$nav = false;
	$nav2 = false;
    $sidebar = false;
    $sidebar_alt = false;
	$search = false;
	$footer_widget = false;

   	//  navigation?
   	if ( genesis_get_option( 'menu-primary' ) == '1' ) $nav = true;
	if ( genesis_get_option( 'menu-secondary' ) == '1' ) $nav2 = true;

   	// sidebar?
    if ( $site_layout == 'sidebar-content' || $site_layout == 'content-sidebar' )  $sidebar = true;

	// search widget?
	if( is_active_widget( '', '', 'search' ) ) $search = true;

    // footer widgets?
    if ( current_theme_supports( 'genesis-footer-widgets' ) == '1' ) {
    	$footer_widgets = get_theme_support( 'genesis-footer-widgets' );
    	if ( isset( $footer_widgets[0] ) && is_numeric( $footer_widgets[0] ) )
    		$footer = true;
    }

	// add id's to the elements to jump to
	// genesis_markup() http://docs.garyjones.co.uk/genesis/2.0.0/source-function-genesis_parse_attr.html#77-100
	// https://gist.github.com/salcode/7164690

	if ( function_exists( 'genesis_markup' ) ) {

		// Add ID markup if primary nav is assigned to a menu area
		add_filter( 'genesis_attr_nav-primary', 'wpacc_genesis_attr_nav_primary' );
		function wpacc_genesis_attr_nav_primary( $attributes ) {
			if ( has_nav_menu( 'primary' ) ) {
	    		$attributes['id'] = 'wpacc-genesis-nav';

			}
			return $attributes;
		}

		// Add ID markup if secondary nav is assigned to a menu area
		add_filter( 'genesis_attr_nav-secondary', 'wpacc_genesis_attr_nav_secondary' );
		function wpacc_genesis_attr_nav_secondary( $attributes ) {
			if ( has_nav_menu( 'secondary' ) ) {
	    		$attributes['id'] = 'wpacc-genesis-secondary';

			}
			return $attributes;
		}

		// Add ID markup to content area
		add_filter( 'genesis_attr_content', 'wpacc_genesis_attr_content' );
		function wpacc_genesis_attr_content( $attributes ) {
    		$attributes['id'] = 'wpacc-genesis-content';
			return $attributes;
		}

		// Add ID markup if the primary sidebar is active
		add_filter( 'genesis_attr_sidebar-primary', 'wpacc_genesis_attr_sidebar_primary' );
		function wpacc_genesis_attr_sidebar_primary( $attributes ) {
			if ( is_active_sidebar( 'sidebar' ) ) {
	    		$attributes['id'] = 'wpacc-sidebar-primary';

			}
			return $attributes;
		}

		// Add ID markup if the secondary sidebar is active
		add_filter( 'genesis_attr_sidebar-secondary', 'wpacc_genesis_attr_sidebar_secondary' );
		function wpacc_genesis_attr_sidebar_secondary( $attributes ) {
			if ( is_active_sidebar( 'sidebar-alt' ) ) {
	    		$attributes['id'] = 'wpacc-sidebar-secondary';
			}
	    	return $attributes;
		}

		// Add ID markup if the footer widgets are active
		add_filter( 'genesis_attr_footer-widgets', 'genesis_attr_footer_widgets' );
		function genesis_attr_footer_widgets( $attributes ) {
			if ( is_active_sidebar( 'genesis-footer-widgets' ) ) {
				$attributes['id'] = 'wpacc-genesis-footer-widgets';
			}

 			return $attributes;
		}

	}


    // write HTML, skiplinks in a list with a heading

   	?> <!-- skiplinks --><?php

    echo '<h2 class="screen-reader-text">'. __( 'Skip links', 'utility-pro' ) .'</h2>' . "\n";

	echo '<ul class="wpacc-genesis-skip-link">' . "\n";

    if ($nav) echo '  <li><a href="#wpacc-genesis-nav" class="screen-reader-shortcut">'. __( 'Jump to main navigation', 'utility-pro' ) .'</a></li>' . "\n";

	if ($search) echo '  <li><a href="#searchform" class="screen-reader-shortcut">'. __( 'Jump to search', 'utility-pro' ) .'</a></li>' . "\n";

	if ($nav2) echo '  <li><a href="#wpacc-genesis-nav" class="screen-reader-shortcut">'. __( 'Jump to sub navigation', 'utility-pro' ) .'</a></li>' . "\n";

	echo '  <li><a href="#wpacc-genesis-content" class="screen-reader-shortcut">'. __( 'Jump to content', 'utility-pro' ) .'</a></li>' . "\n";

	if ($sidebar) echo '  <li><a href="#wpacc-sidebar-primary" class="screen-reader-shortcut">'. __( 'Jump to primary sidebar', 'utility-pro' ) .'</a></li>' . "\n";

	if ($footer) echo '  <li><a href="#wpacc-genesis-footer-widgets" class="screen-reader-shortcut">'. __( 'Jump to footer', 'utility-pro' ) .'</a></li>' . "\n";

	echo '</ul>' . "\n";

}

add_action( 'wp_enqueue_scripts', 'utility_skiplinks_scripts' );
function utility_skiplinks_scripts() {

	wp_enqueue_script( 'genwpacc-skiplinks-js',  get_stylesheet_directory() . '/lib/js/genwpacc-skiplinks.js' );

}

?>