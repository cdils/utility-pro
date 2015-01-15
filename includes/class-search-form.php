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
 * Search form class.
 *
 * @package Utility_Pro
 * @author Gary Jones
 */
class Utility_Pro_Search_Form {
	protected $unique_id;
	protected $strings;

	/**
	 * Merge strings and assign to property.
	 *
	 * @since 1.0.0
	 *
	 * @param array $strings Optional. Array of strings. Default is an empty array.
	 */
	public function __construct( array $strings = array() ) {
		$default_strings = array(
			/** This filter is documented in genesis/lib/structure/search.php */
			'label'        => apply_filters( 'genesis_search_form_label', __( 'Search site', 'utility-pro' ) ),
			/** This filter is documented in genesis/lib/structure/search.php */
			'placeholder'  => apply_filters( 'genesis_search_text', __( 'Search this website', 'utility-pro' ) ),
			/** This filter is documented in genesis/lib/structure/search.php */
			'button'       => apply_filters( 'genesis_search_button_text', __( 'Search', 'utility-pro' ) ),
			/**
			 * Filter the ARIA label for the search form button.
			 *
			 * @since 1.0.0
			 *
			 * @param string $button_label Default label is "Search".
			 */
			'button_label' => apply_filters( 'genesis_search_button_label', __( 'Search', 'utility-pro' ) ),
		);

		$this->strings = wp_parse_args( $strings, $default_strings );
	}

	/**
	 * Get one or all strings.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Optional. Identifier for which string to return. Default is 'all'.
	 *
	 * @return string|array String if key is not 'all', and key exists. Array of all strings otherwise.
	 */
	protected function strings( $key = 'all' ) {
		if ( 'all' !== $key && isset( $this->strings[ $key ] ) ) {
			return $this->strings[ $key ];
		}

		return $this->strings;
	}

	/**
	 * Get form markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Form markup.
	 */
	public function get_form() {
		return sprintf(
			'<form method="get" action="%s" role="search" class="search-form">%s</form>',
			esc_url( home_url( '/' ) ),
			$this->get_label() . $this->get_input() . $this->get_button()
		);
	}

	/**
	 * Get label markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Label markup.
	 */
	protected function get_label() {
		return sprintf(
			'<label for="%s" class="screen-reader-text">%s</label>',
			esc_attr( $this->get_id() ),
			esc_attr( $this->strings( 'label' ) )
		);
	}

	/**
	 * Get input markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Input field markup.
	 */
	protected function get_input() {
		$value = get_search_query() ? apply_filters( 'the_search_query', get_search_query() ) : '';

		return sprintf(
			'<input type="search" name="s" id="%s" value="%s" placeholder="%s" autocomplete="off" />',
			esc_attr( $this->get_id() ),
			esc_attr( $value ),
			esc_attr( $this->strings( 'placeholder' ) )
		);
	}

	/**
	 * Get button markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Button markup.
	 */
	protected function get_button() {
		return sprintf(
			'<button type="submit" aria-label="%s"><span>%s</span></button>',
			esc_attr( $this->strings( 'button_label' ) ),
			$this->strings( 'button' )
		);
	}

	/**
	 * Get unique ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Unique ID.
	 */
	protected function get_id() {
		if ( ! isset( $this->unique_id ) ) {
			$this->unique_id = uniqid( 'searchform-' );
		}

		return $this->unique_id;
	}
}
