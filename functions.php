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

use BrightNucleus\Config\ConfigFactory;

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove.
\load_child_theme_textdomain( 'utility-pro', \get_stylesheet_directory() . '/languages' );

// Autoload dependencies.
if ( \file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

\define( 'UTILITY_PRO_CONFIG_DIR', __DIR__ . '/config/' );

add_action( 'genesis_setup', __NAMESPACE__ . '\\setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function setup() {
	$child_theme = wp_get_theme();

	\define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );  // WPCS: prefix ok.
	\define( 'CHILD_THEME_URL', $child_theme->get( 'ThemeURI' ) );  // WPCS: prefix ok.
	\define( 'CHILD_THEME_VERSION', $child_theme->get( 'Version' ) );  // WPCS: prefix ok.

	$config_file = \UTILITY_PRO_CONFIG_DIR . 'defaults.php';
	$config = ConfigFactory::createSubConfig( $config_file, 'CDils\UtilityPro' );

	// Register theme support items, defined in config/defaults.php.
	$theme_support = new ThemeSupport( $config->getSubConfig( 'ThemeSupport' ) );
	$theme_support->register();

	// Force specific theme settings.
	$forced_theme_settings = new GenesisForceThemeSettings( $config->getSubConfig( 'GenesisForceThemeSettings' ) );
	$forced_theme_settings->apply();

	// Add custom image sizes.
	\add_image_size( 'feature-grid', 500, 250, true );
	\add_image_size( 'feature-large', 1000, 500, true );

	// Remove header right widget area.
	\unregister_sidebar( 'header-right' );

	// Unregister secondary sidebar.
	\unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar.
	\genesis_unregister_layout( 'content-sidebar-sidebar' );
	\genesis_unregister_layout( 'sidebar-content-sidebar' );
	\genesis_unregister_layout( 'sidebar-sidebar-content' );

	add_filter( 'theme_page_templates',  __NAMESPACE__ . '\\remove_genesis_page_templates' );

	// Register the default widget areas.
	$widget_areas = new WidgetAreas( $config->getSubConfig( 'WidgetAreas' ) );
	$widget_areas->register();
	add_filter( 'widget_text', 'do_shortcode' );

	// Enqueue Google Fonts.
	include get_stylesheet_directory() . '/lib/google-fonts.php';

	// Load files in admin.
	if ( is_admin() ) {
		// Configure and register TGMPA functionality for suggested plugins.
		$tgmpa = new Tgmpa( $config->getSubConfig( 'Tgmpa' ) );
		$tgmpa->register();

		// Add theme license (don't remove, unless you don't want theme support).
		$license = new LicenseManager( $config->getSubConfig( 'Updater' ) );
		$license->register();

		// Add admin CSS.
		$admin_css = new AdminCss();
		$admin_css->apply();

		// Add Gutenberg-specific styles to visual editor.
		add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\block_editor_styles' );

	} else {

		// Add Utility Bar above header.
		$utility_bar = new UtilityBar();
		$utility_bar->apply();

		// Add accessibility enhancements.
		$accessibility = new Accessibility();
		$accessibility->apply();

		// Add customizations for single posts.
		$single_post = new SinglePost();
		$single_post->apply();

		// Footer nav.
		$footer_nav = new FooterNav();
		$footer_nav->apply();

		// Reposition primary navigation menu.
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		add_action( 'genesis_header', 'genesis_do_nav', 12 );

		// Change the footer text.
		add_filter( 'genesis_footer_creds_text',  __NAMESPACE__ . '\\footer_creds' );

		// Change default Gravatar size.
		add_filter( 'genesis_author_box_gravatar_size', function() {
			return 96;
		} );

		// Enqueue theme scripts.
		add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );

		// Enqueue theme stylesheet after plugins have loaded so that theme styles always "trump" plugin styles.
		remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
		add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 999 );

	}// End if().
}

/**
 * Customize footer credits.
 *
 * @since  1.0.0
 *
 * @param string $creds Existing credentials.
 *
 * @return string Footer credentials.
 */
function footer_creds( $creds ) {
	$creds = sprintf(
		/* translators: %s: URL for Utility Pro. */
		__( 'Powered by WordPress and the <a href="%s" rel="nofollow">Utility Pro</a> theme for Genesis Framework.', 'utility-pro' ),
		esc_url( 'https://store.carriedils.com/downloads/utility-pro/?utm_source=Utility%20Pro%20Footer%20Credits&utm_medium=Distributed%20Theme&utm_campaign=Utility%20Pro%20Theme' )
		);

	return $creds;
}

/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates Existing recognised page templates.
 * @return array Amended recognised page templates.
 */
function remove_genesis_page_templates( array $page_templates ) : array {
	unset( $page_templates['page_blog.php'] );

	return $page_templates;
}

/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function enqueue_assets() {
	// Load unminified JS if WP_DEBUG is enabled in wp-config.php
	$suffix = \defined( 'WP_DEBUG' ) && WP_DEBUG ? '.js' : '.min.js';

	// Replace style.css with style-rtl.css for RTL languages.
	\wp_style_add_data( 'utility-pro', 'rtl', 'replace' );

	// Keyboard navigation (dropdown menus) script.
	\wp_enqueue_script(
		'utility-pro-keyboard-dropdown',
		\get_stylesheet_directory_uri() . '/js/keyboard-dropdown' . $suffix,
		[ 'jquery' ],
		\CHILD_THEME_VERSION,
		true
	);

	// Load mobile responsive menu.
	\wp_enqueue_script(
		'utility-pro-responsive-menu',
		\get_stylesheet_directory_uri() . '/js/responsive-menu' . $suffix,
		[ 'jquery' ],
		'1.0.0', true
	);

	$localize_primary = [
		'buttonText'     => __( 'Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Primary Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	$localize_footer = [
		'buttonText'     => __( 'Footer Menu', 'utility-pro' ),
		'buttonLabel'    => __( 'Footer Navigation Menu', 'utility-pro' ),
		'subButtonText'  => __( 'Sub Menu', 'utility-pro' ),
		'subButtonLabel' => __( 'Sub Menu', 'utility-pro' ),
	];

	// Localize the responsive menu script (for translation).
	\wp_localize_script( 'utility-pro-responsive-menu', 'utilityProMenuPrimaryL10n', $localize_primary );
	\wp_localize_script( 'utility-pro-responsive-menu', 'utilityProMenuFooterL10n', $localize_footer );

	\wp_enqueue_script(
		'utility-pro-responsive-menu-args',
		\get_stylesheet_directory_uri() . '/js/responsive-menu-args' . $suffix,
		[ 'utility-pro-responsive-menu' ],
		\CHILD_THEME_VERSION,
		true
	);
}

/**
 * Enqueue block editor styles.
 *
 * @since 3.0.0
 */
function block_editor_styles() {
    wp_enqueue_style(
    	'utility-pro-block-editor-styles',
    	get_theme_file_uri( '/gutenberg.min.css' ),
    	false, '1.0.0', 'all'
    );
}
