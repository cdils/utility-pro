<?php

/**
 * Utility Pro.
 *
 * Based on code from ThemeMix Pro for Genesis (https://github.com/WPPlugins/thememix-pro-genesis/)
 * by ThemeMix (https://thememix.com)
 *
 * @package      CDils\UtilityPro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

declare( strict_types = 1 );

namespace CDils\UtilityPro;

/**
 * EDD Genesis compatibility class.
 *
 * Uses code from Genesis EDD Connect (https://wordpress.org/plugins/genesis-connect-edd/)
 * by David Decker (http://deckerweb.de/).
 */
class Genesis_EDD_Compatibility {

	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Add EDD support for 3rd-party plugins.
		add_action( 'after_setup_theme', [ $this, 'edd_add_support' ] );

		// Remove post info & meta.
		add_action( 'template_redirect', [ $this, 'remove_post_meta' ] );

		// Remove original filter that adds purchase button below download content.
		remove_filter( 'the_content', 'edd_after_download_content' );

		// Add purchase button below download content.
		add_action ( 'genesis_entry_footer', [ $this, 'add_download_button' ] );
	}

	/**
	 * Remove default post info & meta.
	 *
	 * Only applies to single downloads and download archives.
	 *
	 * @since 3.0.0
	 */
	public function remove_post_meta() {

		if ( \is_singular( 'download' ) || \is_archive( 'download' ) ) {

			remove_action( 'genesis_entry_header', 'genesis_post_info', 8 );
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
		}
	}

	/**
	 * Setup Genesis Connect for Easy Digital Downloads.
	 *
	 * Checks whether Easy Digital Downloads and Genesis Framework are active.
	 * Once past these checks, loads the necessary files, actions and filters
	 * for the plugin to do its thing.
	 *
	 * @since 3.0.0
	 */
	public function edd_add_support() {

		// Add Genesis Layout, SEO, Scripts, Archive Settings options to "Download" edit screen
		add_post_type_support( 'download', [
			'genesis-layouts',
			'genesis-seo',
			'genesis-scripts',
			'genesis-cpt-archives-settings'
		] );

		// Add plugin support for: Genesis Simple Sidebars, Genesis Simple Menus, Genesis Prose Extras
		add_post_type_support( 'download', [
			'genesis-simple-sidebars',
			'genesis-simple-menus',
			'gpex-inpost-css'
		] );

		// Add some additional toolbar items for "EDD Toolbar" plugin
		add_action( 'eddtb_custom_main_items', 'gcedd_toolbar_additions' );
	}

	/*
	 * Output purchase button below the content on download archive pages.
	 *
	 * @since 3.0.0
	 *
	 * @link https://github.com/easydigitaldownloads/library/blob/master/_downloads/display-purchase-button-on-download-archives.html
	 *
	 * @return string
	 */
	public function add_download_button() {

		global $post;

		$cart_btn = "";

		if ( \is_singular( 'download' ) || \is_archive( 'download' ) ) {
			ob_start();
			do_action( 'edd_after_download_content', $post->ID );
			$cart_btn = ob_get_clean();
		}

		echo $cart_btn;
	}
}
new Genesis_EDD_Compatibility;
