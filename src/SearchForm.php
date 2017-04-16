<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

/**
 * Search form class.
 *
 * @package CDils\UtilityPro
 * @author Gary Jones
 */
class SearchForm {
	/**
	 * Unique ID for this search field.
	 *
	 * @var string
	 */
	protected $unique_id;

	/**
	 * Holds internationalized strings.
	 *
	 * @var array
	 */
	protected $strings;

	/**
	 * Merge strings and assign to property.
	 *
	 * @since 1.0.0
	 *
	 * @param array $strings Optional. Array of strings. Default is an empty array.
	 */
	public function __construct( array $strings = null ) {
		$default_strings = [
			/** This filter is documented in genesis/lib/structure/search.php */
			'label'        => apply_filters( 'genesis_search_form_label', __( 'Search site', 'utility-pro' ) ), // WPCS: prefix ok.
			// Placeholder should be empty: http://www.nngroup.com/articles/form-design-placeholders/.
			/** This filter is documented in genesis/lib/structure/search.php */
			'placeholder'  => apply_filters( 'genesis_search_text', '' ), // WPCS: prefix ok.
			/** This filter is documented in genesis/lib/structure/search.php */
			'button'       => apply_filters( 'genesis_search_button_text', __( 'Search', 'utility-pro' ) ), // WPCS: prefix ok.
			/**
			 * Filter the ARIA label for the search form button.
			 *
			 * @since 1.0.0
			 *
			 * @param string $button_label Default label is "Search".
			 */
			'button_label' => apply_filters( 'genesis_search_button_label', __( 'Search', 'utility-pro' ) ), // WPCS: prefix ok.
		];

		$this->strings = \wp_parse_args( $strings ?? [], $default_strings );
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
	protected function strings( string $key = 'all' ) {
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
	public function get_form() : string {
		return \sprintf(
			'<form method="get" action="%s" role="search" class="search-form">%s</form>',
			\esc_url( home_url( '/' ) ),
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
	protected function get_label() : string {
		return \sprintf(
			'<label for="%s" class="screen-reader-text">%s</label>',
			\esc_attr( $this->get_id() ),
			\esc_attr( $this->strings( 'label' ) )
		);
	}

	/**
	 * Get input markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Input field markup.
	 */
	protected function get_input() : string {
		$value = \get_search_query() ? apply_filters( 'the_search_query', \get_search_query() ) : ''; // WPCS: prefix ok.

		return \sprintf(
			'<input type="search" name="s" id="%s" value="%s" placeholder="%s" autocomplete="off" />',
			\esc_attr( $this->get_id() ),
			\esc_attr( $value ),
			\esc_attr( $this->strings( 'placeholder' ) )
		);
	}

	/**
	 * Get button markup.
	 *
	 * @since 1.0.0
	 *
	 * @return string Button markup.
	 */
	protected function get_button() : string {
		return \sprintf(
			'<button type="submit" aria-label="%s"><span class="search-button-text">%s</span></button>',
			\esc_attr( $this->strings( 'button_label' ) ),
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
	protected function get_id() : string {
		if ( null === $this->unique_id ) {
			$this->unique_id = 'searchform-' . \uniqid( '', true );
		}

		return $this->unique_id;
	}
}
