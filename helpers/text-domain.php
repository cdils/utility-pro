<?php

/**
 * This file loads the child theme text domain.
 *
 * @author Carrie Dils
 * @package Utility Pro
 * @subpackage Customizations
 */

add_action( 'after_setup_theme', 'utility_pro_i18n' );
/**
 * Load the child theme textdomain for internationalization.
 *
 * Must be loaded before Genesis Framework /lib/init.php is included.
 * Translations can be filed in the /languages/ directory.
 *
 * @since 1.0.0
 */
function utility_pro_i18n() {
    load_child_theme_textdomain( 'utility-pro', get_stylesheet_directory() . '/languages' );
}
