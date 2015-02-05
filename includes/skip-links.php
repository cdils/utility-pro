<?php
 /**
  * This file adds skip link markup and navigation.
  *
  * @package      Utility_Pro
  * @author       Rian Rietveld
  * @author       Carrie Dils
  * @author       Amanda Rush
  * @license      GPL-2.0+
  * @link         http://genesis-accessible.org/
  *
  */

add_action ( 'genesis_before_header', 'utility_pro_skip_links', 5 );
/**
 * Add skiplinks for screen readers and keyboard navigation
 *
 * @since  1.0.0
 */
function utility_pro_skip_links() {

	// Call function to add IDs to the markup
	utility_skiplinks_markup();

	// write HTML, skiplinks in a list with a heading
	echo '<h2 class="screen-reader-text">'. __( 'Skip links', 'utility-pro' ) .'</h2>' . "\n";

	echo '<ul class="wpacc-genesis-skip-link">' . "\n";

	if ( has_nav_menu( 'primary' ) ) {
		echo '  <li><a href="#genwpacc-genesis-nav-primary" class="screen-reader-shortcut">'. __( 'Skip to primary navigation', 'utility-pro' ) .'</a></li>' . "\n";
	}

	echo '  <li><a href="#genwpacc-genesis-content" class="screen-reader-shortcut">'. __( 'Skip to content', 'utility-pro' ) .'</a></li>' . "\n";

	if ( ( 'sidebar-content' === genesis_site_layout() ) || ( 'content-sidebar' === genesis_site_layout() ) ) {
		echo '  <li><a href="#genwpacc-sidebar-primary" class="screen-reader-shortcut">'. __( 'Skip to primary sidebar', 'utility-pro' ) .'</a></li>' . "\n";
	}

	if ( 1 == current_theme_supports( 'genesis-footer-widgets' ) ) {
		$footer_widgets = get_theme_support( 'genesis-footer-widgets' );
	}

	if ( isset( $footer_widgets[0] ) && is_numeric( $footer_widgets[0] ) ) {
		echo '  <li><a href="#genwpacc-genesis-footer-widgets" class="screen-reader-shortcut">'. __( 'Skip to footer widgets', 'utility-pro' ) .'</a></li>' . "\n";
	}

	if ( has_nav_menu( 'footer' ) ) {
		echo '  <li><a href="#genwpacc-genesis-nav-footer" class="screen-reader-shortcut">'. __( 'Skip to footer navigation', 'utility-pro' ) .'</a></li>' . "\n";
	}

	echo '</ul>' . "\n";
}

/**
 * Add ID markup to the elements to jump to
 *
 * @link https://gist.github.com/salcode/7164690
 * @link genesis_markup() http://docs.garyjones.co.uk/genesis/2.0.0/source-function-genesis_parse_attr.html#77-100
 * @return array
 * @since 1.0.0
 */
function utility_skiplinks_markup() {

	add_filter( 'genesis_attr_nav-primary', 'utility_pro_genesis_attr_nav_primary' );
	add_filter( 'genesis_attr_content', 'utility_pro_genesis_attr_content' );
	add_filter( 'genesis_attr_sidebar-primary', 'utility_pro_genesis_attr_sidebar_primary' );
	add_filter( 'genesis_attr_footer-widgets', 'genesis_attr_footer_widgets' );
	add_filter( 'genesis_attr_nav-footer', 'utility_pro_genesis_attr_nav_footer' );
}

// Add ID markup if primary nav is assigned to a menu area
// We use have_nav_menu()
function utility_pro_genesis_attr_nav_primary( $attributes ) {
	$attributes['id'] = 'genwpacc-genesis-nav-primary';
	return $attributes;
}

// Add ID markup to content area
function utility_pro_genesis_attr_content( $attributes ) {
	$attributes['id'] = 'genwpacc-genesis-content';
	return $attributes;
}

// Add ID markup if the primary sidebar is active
function utility_pro_genesis_attr_sidebar_primary( $attributes ) {
	$attributes['id'] = 'genwpacc-sidebar-primary';
	return $attributes;
}

// Add ID markup if the footer widgets are active
function genesis_attr_footer_widgets( $attributes ) {
	$attributes['id'] = 'genwpacc-genesis-footer-widgets';
	return $attributes;
}

// Add ID markup if footer nav is assigned to a menu area
function utility_pro_genesis_attr_nav_footer( $attributes ) {
	$attributes['id'] = 'genwpacc-genesis-nav-footer';
	return $attributes;
}
