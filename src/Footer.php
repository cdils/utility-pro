<?php
/**
 * Utility Pro.
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Exception\RuntimeException;

/**
 * Class Footer.
 *
 * @package CDils\UtilityPro
 */
class Footer {

	use ConfigTrait;

	/**
	 * Initialise Footer object.
	 *
	 * @param ConfigInterface $config Config to parametrize the object.
	 * @throws RuntimeException       If the Config could not be parsed correctly.
	 */
	public function __construct( ConfigInterface $config ) {
		$this->processConfig( $config );
	}

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Change the footer text.
		add_filter( 'genesis_footer_creds_text', [ $this, 'creds_text' ] );
	}

	/**
	 * Change the footer text.
	 *
	 * @since  1.0.0
	 *
	 * @return string Footer credentials.
	 */
	public function creds_text() : string {
		return $this->config->getKey( 'creds' );
	}
}
