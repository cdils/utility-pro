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
use BrightNucleus\Config\Exception\FailedToProcessConfigException;

/**
 * Class GenesisThemeDefaults.
 *
 * @package CDils\UtilityPro
 */
class GenesisForceThemeSettings {
	use ConfigTrait;

	/**
	 * Initialise Genesis Theme Defaults object.
	 *
	 * @param ConfigInterface $config Config to parametrize the object.
	 *
	 * @throws FailedToProcessConfigException  If the Config could not be parsed correctly.
	 */
	public function __construct( ConfigInterface $config ) {
		$this->processConfig( $config );
	}

	/**
	 * Apply filters and hooks.
	 */
	public function apply() {
		// Change the theme settings defaults.
		add_filter( 'genesis_theme_settings_defaults', [ $this, 'theme_settings_defaults' ] );

		// Force specific values to be returned.
		$this->force_values();
	}

	/**
	 * Change the theme settings defaults.
	 *
	 * @param array $defaults Existing theme settings defaults.
	 * @return array Theme settings defaults.
	 */
	public function theme_settings_defaults( $defaults ) : array {
		foreach ( $this->config->getArrayCopy() as $key => $value ) {
			$defaults[ $key ] = $value;
		}

		return $defaults;
	}

	/**
	 * Force specific values to be returned.
	 */
	public function force_values() {
		foreach ( $this->config->getArrayCopy() as $key => $value ) {
			add_filter( "genesis_pre_get_option_{$key}", function () use ( $value ) {
				return $value;
			} );
		}
	}
}
