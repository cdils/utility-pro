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

use BrightNucleus\Config\ConfigInterface;
use BrightNucleus\Config\ConfigTrait;
use BrightNucleus\Exception\RuntimeException;

/**
 * Class WidgetAreas.
 *
 * @package CDils\UtilityPro
 */
class WidgetAreas {
	use ConfigTrait;

	/**
	 * Initialise WidgetAreas object.
	 *
	 * @param ConfigInterface $config Config to parametrize the object.
	 * @throws RuntimeException       If the Config could not be parsed correctly.
	 */
	public function __construct( ConfigInterface $config ) {
		$this->processConfig( $config );
	}

	/**
	 * Register widget areas.
	 */
	public function register() {
		$widget_areas = (array) apply_filters( 'utility_pro_default_widget_areas', $this->config->getAll() );
		foreach ( $widget_areas as $widget_area ) {
			genesis_register_sidebar( $widget_area );
		}
	}
}
