<?php
/**
 * This file adds label and id to the search forms
 *
 * @package      Utility_Pro
 * @author       Rian Rietveld
 * @author       Carrie Dils
 * @license      GPL-2.0+
 * @link         http://genesis-accessible.org/
 *
 */

// Replace the search form, function adds a real label and an id for the search input field
// Based on the genesis_search_form with Genesis 2.0.2, keeps the filters

remove_filter( 'get_search_form', 'genesis_search_form', 20 );
add_filter( 'get_search_form', 'utility_pro_get_search_form_uniqueid', 20 );

/**
 * Replace the default search form with a Genesis-specific accessible form.
 *
 * Applies the `genesis_search_text`, `genesis_search_button_text`, `genesis_search_form_label` and
 * `genesis_search_form` filters.
 *
 * @since 0.2.0
 * @return string HTML markup.
 */
function utility_pro_get_search_form_uniqueid() {

	$search_text = get_search_query() ? apply_filters( 'the_search_query', get_search_query() ) : apply_filters( 'genesis_search_text', __( 'Search this website', 'utility-pro' ) );

	$button_text = apply_filters( 'genesis_search_button_text', __( 'Search', 'utility-pro' ) );

	$onfocus = esc_js( "if ('" . $search_text . "' === this.value) {this.value = '';}" );
	$onblur  = esc_js( "if ('' === this.value) {this.value = '" . $search_text . "';}" );

	// Generate ramdom id for the search field (n case there are more than one search form on the page)
	$id = uniqid( 'searchform-' );

	// Empty label, by default. Filterable.
	$label = apply_filters( 'genesis_search_form_label', $search_text );
	$label = '<label for="' . $id . '" class="screen-reader-text">' . $label . '</label>';

	$value_or_placeholder = ( get_search_query() == '' ) ? 'placeholder' : 'value';

	$form = sprintf( '<form method="get" class="search-form" action="%s" role="search">%s<input type="search" name="s" id="%s" %s="%s" /><input type="submit" value="%s" /></form>', home_url( '/' ), $label, $id, $value_or_placeholder, esc_attr( $search_text ), esc_attr( $button_text ) );

	return apply_filters( 'genesis_search_form', $form, $search_text, $button_text, $label );

}
