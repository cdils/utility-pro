<?php
/**
 * Theme configuration
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Gary Jones
 * @copyright    Copyright (c) 2017, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

// Configure theme support items here.
$utility_pro_theme_support = [
	// Add HTML5 markup structure.
	'html5' => [ 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ],

	// Add viewport meta tag for mobile browsers.
	'genesis-responsive-viewport' => null,

	// Add support for custom background.
	'custom-background' => [
		'wp-head-callback' => '__return_false',
	],

	// Add support for accessibility features.
	'genesis-accessibility' => [ '404-page', 'headings', 'skip-links' ],

	// Add support for three footer widget areas.
	'genesis-footer-widgets' => 3,

	// Add support for additional color style options.
	'genesis-style-selector' => [
		'utility-pro-indigo' => __( 'Indigo', 'utility-pro' ),
		'utility-pro-jam'  => __( 'Jazzberry Jam', 'utility-pro' ),
		'utility-pro-greener'    => __( 'Greener Grass', 'utility-pro' ),
	],

	// Add support for structural wraps (all default Genesis wraps unless noted).
	'genesis-structural-wraps' => [
		'footer',
		'footer-widgets',
		'footernav',    // Custom.
		'header',
		'home-gallery', // Custom.
		'menu-footer',  // Custom.
		'nav',
		'site-inner',
		'site-tagline',
	],

	// Add support for two navigation areas (theme doesn't use secondary navigation).
	'genesis-menus' => [
		'primary' => __( 'Primary Navigation Menu', 'utility-pro' ),
		'footer'  => __( 'Footer Navigation Menu', 'utility-pro' ),
	],

	// Add support for wide images (Gutenberg).
	'align-wide' => true,

	// Disable custom colors in block color pallettes (Gutenberg).
	'disable-custom-colors' => true
];

$utility_pro_genesis_force_theme_settings = [
	'posts_nav' => 'numeric',
];

// Configure recommended / required plugins and TGMPA configuration here.
$utility_pro_tgmpa = [
	'plugins' => [
		[
			'name'     => 'Better Font Awesome', // The plugin name.
			'slug'     => 'better-font-awesome', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
		],
		[
			'name'     => 'Genesis E-News Extended', // The plugin name.
			'slug'     => 'genesis-enews-extended', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
		],
		[
			'name'     => 'WP Accessibility', // The plugin name.
			'slug'     => 'wp-accessibility', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
		],
	],
	'config'  => [
		'domain'           => 'utility-pro',              // Text domain - likely want to be the same as your theme.
		'default_path'     => '',                         // Default absolute path to pre-packaged plugins.
		'parent_slug'      => 'themes.php',               // Default parent menu slug.
		'menu'             => 'install-required-plugins', // Menu slug.
		'has_notices'      => true,                       // Show admin notices or not.
		'dismissable'      => true,                       // If false, a user cannot dismiss the nag message.
		'dismiss_msg'      => '',                         // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'     => false,                      // Automatically activate plugins after installation or not.
		'message'          => '',                         // Message to output right before the plugins table.
		'strings'          => [
			'page_title'                      => __( 'Install Required Plugins', 'utility-pro' ),
			'menu_title'                      => __( 'Install Plugins', 'utility-pro' ),
			/* translators: %s: plugin name */
			'installing'                      => __( 'Installing Plugin: %s', 'utility-pro' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'utility-pro' ),
			/* translators: %s: plugin name(s) */
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'utility-pro' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'utility-pro' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'utility-pro' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'utility-pro' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'utility-pro' ),
			/* translators: %s: dashboard link */
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'utility-pro' ),
			'nag_type'                        => 'updated', // Determines admin notice type - can only be 'updated' or 'error'.
		],
	],
];

// Configure widget areas here.
$utility_pro_widget_areas = [
	[
		'id'          => 'utility-bar',
		'name'        => __( 'Utility Bar', 'utility-pro' ),
		'description' => __( 'This is the utility bar across the top of page.', 'utility-pro' ),
	],
	[
		'id'          => 'utility-home-welcome',
		'name'        => __( 'Home Welcome', 'utility-pro' ),
		'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
	],
	[
		'id'          => 'utility-home-gallery-1',
		/* translators: %d: Number of widget area. */
		'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 1 ),
		/* translators: %d: Number of widget area. */
		'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 1 ),
	],
	[
		'id'          => 'utility-home-gallery-2',
		/* translators: %d: Number of widget area. */
		'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 2 ),
		/* translators: %d: Number of widget area. */
		'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 2 ),
	],
	[
		'id'          => 'utility-home-gallery-3',
		/* translators: %d: Number of widget area. */
		'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 3 ),
		/* translators: %d: Number of widget area. */
		'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 3 ),
	],
	[
		'id'          => 'utility-home-gallery-4',
		/* translators: %d: Number of widget area. */
		'name'        => sprintf( _x( 'Home Gallery %d', 'Group of Home Gallery widget areas', 'utility-pro' ), 4 ),
		/* translators: %d: Number of widget area. */
		'description' => sprintf( _x( 'Home Gallery %d widget area on home page.', 'Description of widget area', 'utility-pro' ), 4 ),
	],
	[
		'id'          => 'utility-call-to-action',
		'name'        => __( 'Call to Action', 'utility-pro' ),
		'description' => __( 'This is the Call to Action section on the home page.', 'utility-pro' ),
	],
];

// Configure updater / license here.
$utility_pro_updater = [
	[
		'remote_api_url' => 'https://store.carriedils.com', // Site where EDD is hosted.
		'item_name'      => 'Utility Pro',                  // Name of theme.
		'theme_slug'     => 'utility-pro',                  // Theme slug.
		'version'        => '1.0.0',                        // The current version of this theme.
		'author'         => 'Carrie Dils',                  // The author of this theme.
	],
	[
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
		/* translators: %s: expiry date */
		'expires%s'                 => __( 'Expires %s.', 'utility-pro' ),
		/* translators: 1: site count, 2: license limit */
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'utility-pro' ),
		/* translators: %s: expiry date */
		'license-key-expired-%s'    => __( 'License key expired %s.', 'utility-pro' ),
		'license-key-expired'       => __( 'License key has expired.', 'utility-pro' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'utility-pro' ),
		'license-is-inactive'       => __( 'License is inactive.', 'utility-pro' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'utility-pro' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'utility-pro' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'utility-pro' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'utility-pro' ),
		/* translators: 1: theme name, 2: new version number, 3: thickbox link, 4: theme name, 5: update URL, 6: onclick attribute */
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'utility-pro' ),
	],
];

return [
	'CDils' => [
		'UtilityPro' => [
			'ThemeSupport'              => $utility_pro_theme_support,
			'GenesisForceThemeSettings' => $utility_pro_genesis_force_theme_settings,
			'Tgmpa'                     => $utility_pro_tgmpa,
			'WidgetAreas'               => $utility_pro_widget_areas,
			'Updater'                   => $utility_pro_updater,
		],
	],
];
