<?php
/**
 * This file contains elements for theme licensing.
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
 * License manager class.
 *
 * @package CDils\UtilityPro
 */
class LicenseManager {
	use ConfigTrait;

	/**
	 * Holds the admin page hook.
	 *
	 * @var string
	 */
	protected $edd_theme_updater_admin;

	/**
	 * Initialise license manager object.
	 *
	 * @param ConfigInterface $config Config to parametrize the object.
	 *
	 * @throws FailedToProcessConfigException  If the Config could not be parsed correctly.
	 */
	public function __construct( ConfigInterface $config ) {
		$this->processConfig( $config );
	}

	/**
	 * Register license page.
	 */
	public function register() {
		if ( ! \class_exists( 'EDD_Theme_Updater_Admin' ) ) {
			include __DIR__ . '../vendor-includes/edd-software-licensing/theme-license-admin.php';
		}
		$updater = $this->config->getArrayCopy();
		$this->edd_theme_updater_admin = new \EDD_Theme_Updater_Admin( $updater[0], $updater[1] );
		add_action( 'admin_menu', [ $this, 'move_license_page_menu_item' ], 12 );
	}

	/**
	 * Move the license page menu item from under the Appearance menu to
	 * under the Genesis menu.
	 *
	 * @since 1.0.0
	 *
	 * @author Gary Jones
	 */
	public function move_license_page_menu_item() {
		$page = \remove_submenu_page( 'themes.php', 'utility-pro-license' );
		if ( \is_array( $page ) ) {
			/* @var array $page */
			\add_submenu_page(
				'genesis',
				$page[3],
				$page[0],
				$page[1],
				$page[2],
				[ $this->edd_theme_updater_admin, 'license_page' ]
			);
		}
	}
}
