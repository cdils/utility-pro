<?php
/**
 * GoogleFont interface
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

/**
 * Interface GoogleFont.
 *
 * All Google Font classes should implement this interface.
 *
 * @package CDils\UtilityPro
 */
interface GoogleFont {
	/**
	 * Allow translators to disable this font.
	 *
	 * @return bool
	 */
	public function is_on() : bool;

	/**
	 * Get font family string.
	 *
	 * @return string
	 */
	public function font_family() : string;
}
