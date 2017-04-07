<?php
/**
 * This file contains a Google Font class
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro\GoogleFont;

use CDils\UtilityPro\GoogleFont;

/**
 * Class OpenSans.
 *
 * @package CDils\UtilityPro
 */
class OpenSans implements GoogleFont {
	/**
	 * Allow translators to disable this font.
	 *
	 * @return bool
	 */
	public function is_on() : bool {
		/*
		 * Translators: If there are characters in your language that are not
		 * supported by this font, translate this to 'off'. Do not translate
		 * into your own language.
		 */
		return 'on' === _x( 'on', 'Open Sans font: on or off', 'utility-pro' );
	}

	/**
	 * Get font family string.
	 *
	 * @return string
	 */
	public function font_family() : string {
		return 'Open Sans:400,700';
	}
}
