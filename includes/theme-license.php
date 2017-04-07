<?php
/**
 * Theme Updater.
 *
 * Originally from Easy Digital Downloads, but customized for Utility Pro.
 *
 * @package Utility_Pro
 */

// Includes the files needed for the theme updater.
use BrightNucleus\Config\ConfigFactory;

if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include dirname( __FILE__ ) . '/../includes-vendors/edd-software-licensing/theme-license-admin.php';
}

$config_file = UTILITY_PRO_CONFIG_DIR . 'defaults.php';
$updater = ConfigFactory::createSubConfig( $config_file, 'CDils\UtilityPro\Updater' )->getArrayCopy();

// Loads the updater classes.
$GLOBALS['updater'] = new EDD_Theme_Updater_Admin( // WPCS: prefix ok.
	$updater[0], $updater[1]
);

add_action( 'admin_menu', 'utility_pro_move_license_page_menu_item', 12 );
/**
 * Move the license page menu item from under the Appearance menu to
 * under the Genesis menu.
 *
 * @since 1.0.0
 *
 * @author Gary Jones
 */
function utility_pro_move_license_page_menu_item() {
	global $updater;
	$page = remove_submenu_page( 'themes.php', 'utility-pro-license' );
	if ( is_array( $page ) ) {
		add_submenu_page( 'genesis', $page[3], $page[0], $page[1], $page[2], [ $updater, 'license_page' ] );
	}
}
