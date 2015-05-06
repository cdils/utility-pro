<?php
/**
 * Theme Updater.
 *
 * Originally from Easy Digital Downloads, but customized for Utility Pro.
 *
 * @package Utility_Pro
 */

// Includes the files needed for the theme updater.
if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/vendors/edd-software-licensing/theme-license-admin.php' );
}

// Loads the updater classes.
$GLOBALS['updater'] = new EDD_Theme_Updater_Admin(
	$config = array(
		'remote_api_url' => 'https://store.carriedils.com', // Site where EDD is hosted.
		'item_name'      => 'Utility Pro',                  // Name of theme.
		'theme_slug'     => 'utility-pro',                  // Theme slug.
		'version'        => '1.0.0',                        // The current version of this theme.
		'author'         => 'Carrie Dils',                  // The author of this theme.
	),
	$strings = array(
		'theme-license'             => __( 'Utility Pro License', 'utility-pro' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'utility-pro' ),
		'license-key'               => __( 'License Key', 'utility-pro' ),
		'license-action'            => __( 'License Action', 'utility-pro' ),
		'deactivate-license'        => __( 'Deactivate License', 'utility-pro' ),
		'activate-license'          => __( 'Activate License', 'utility-pro' ),
		'status-unknown'            => __( 'License status is unknown.', 'utility-pro' ),
		'renew'                     => __( 'Renew?', 'utility-pro' ),
		'unlimited'                 => __( 'unlimited', 'utility-pro' ),
		'license-key-is-active'     => __( 'License key is active.', 'utility-pro' ),
		'expires%s'                 => __( 'Expires %s.', 'utility-pro' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'utility-pro' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'utility-pro' ),
		'license-key-expired'       => __( 'License key has expired.', 'utility-pro' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'utility-pro' ),
		'license-is-inactive'       => __( 'License is inactive.', 'utility-pro' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'utility-pro' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'utility-pro' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'utility-pro' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'utility-pro' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'utility-pro' )
	)
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
	add_submenu_page( 'genesis', $page[3], $page[0], $page[1], $page[2], array( $updater, 'license_page' ) );
}
