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

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove.
use BrightNucleus\Config\ConfigFactory;
use CDils\UtilityPro\GoogleFont\Enriqueta;
use CDils\UtilityPro\GoogleFont\OpenSans;

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
	\define( 'CHILD_THEME_NAME', 'utility-pro' ); // WPCS: prefix ok.
	\define( 'CHILD_THEME_URL', 'https://store.carriedils.com/utility-pro' );  // WPCS: prefix ok.
	\define( 'CHILD_THEME_VERSION', '1.3.1' );  // WPCS: prefix ok.

	$config_file = \UTILITY_PRO_CONFIG_DIR . 'defaults.php';
	$config = ConfigFactory::createSubConfig( $config_file, 'CDils\UtilityPro' );

	// Register theme support items, defined in config/defaults.php.
	$theme_support = new ThemeSupport( $config->getSubConfig( 'ThemeSupport' ) );
	$theme_support->register();

	// Force specific theme settings.
	$forced_theme_settings = new GenesisForceThemeSettings( $config->getSubConfig( 'GenesisForceThemeSettings' ) );
	$forced_theme_settings->apply();

	// Add custom image sizes.
	\add_image_size( 'feature-large', 960, 330, true );

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
	} else {
		// Enqueue Google Fonts.
		$google_fonts = new GoogleFonts();
		$google_fonts->add( 'enriqueta', new Enriqueta() );
		$google_fonts->add( 'opensans', new OpenSans() );
		$google_fonts->enqueue();

		// Footer nav.
		$footer_nav = new FooterNav();
		$footer_nav->apply();

		// Add Utility Bar above header.
		$utility_bar = new UtilityBar();
		$utility_bar->apply();

		// Add accessibility enhancments.
		$accessibility = new Accessibility();
		$accessibility->apply();

		// Add customizations for single posts.
		$single_post = new SinglePost();
		$single_post->apply();

		// Add customizations to footer.
		$footer = new Footer( $config->getSubConfig( 'Footer' ) );
		$footer->apply();

		add_filter( 'genesis_author_box_gravatar_size', function() {
			return 96;
		} );

		add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
	}// End if().
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
	$suffix = \defined( 'WP_DEBUG' ) && WP_DEBUG ? '.min.js' : '.js';

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

	// Load Backstretch scripts only if custom background is being used
	// and we're on the home page or a page using the landing page template.
	if ( ! \get_background_image() || ( ! ( \is_front_page() || \is_page_template( 'page_landing.php' ) ) ) ) {
		return;
	}

	\wp_enqueue_script(
		'utility-pro-backstretch',
		\get_stylesheet_directory_uri() . '/js/backstretch' . $suffix,
		[ 'jquery' ],
		'2.0.1',
		true
	);

	\wp_localize_script( 'utility-pro', 'utilityProBackstretchL10n', [
		'src' => \get_background_image(),
	] );
}
