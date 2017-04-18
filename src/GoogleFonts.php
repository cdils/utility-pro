<?php
/**
 * This file contains elements for theme internationalization.
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
 * Class GoogleFonts.
 *
 * This acts as a registry to which GoogleFont objects can be added. It then loops through to create the single URL
 * needed to pull all the enabled Google Fonts done in one request.
 *
 * @package CDils\UtilityPro
 */
class GoogleFonts {
	/**
	 * Registry items.
	 *
	 * @var array
	 */
	protected $fonts = [];

	/**
	 * Add a Google Font to the registry.
	 *
	 * @param string     $id   Registry key.
	 * @param GoogleFont $font Registry item.
	 */
	public function add( string $id, GoogleFont $font ) {
		if ( ! \in_array( $id, $this->fonts, true ) && $font->is_on() ) {
			$this->fonts[ $id ] = $font;
		}
	}

	/**
	 * Enqueue Google fonts styles.
	 */
	public function enqueue() {
		if ( empty( $this->fonts ) ) {
			return;
		}

		\wp_enqueue_style( 'utility-pro-fonts', $this->fonts_url(), [], null );
	}

	/**
	 * Get list of fonts in registry.
	 *
	 * @return array Registered fonts.
	 */
	public function get_fonts() : array {
		return $this->fonts;
	}

	/**
	 * Build the fonts URL.
	 *
	 * @return string URL for Google Font.
	 */
	protected function fonts_url() : string {
		$font_families = '';

		foreach ( $this->fonts as $font ) {
			/* @var GoogleFont $font */
			$font_families[] = $font->font_family();
		}

		$query_args = [
			'family' => \rawurlencode( \implode( '|', $font_families ) ),
			'subset' => \rawurlencode( 'latin,latin-ext' ),
		];

		return \add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}
}
