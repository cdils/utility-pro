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
 * Integrate WooCommerce with Genesis.
 * Partially based on work by AlphaBlossom / Tony Eppright (http://www.alphablossom.com)
 */
class Genesis_WooCommerce_Compatability {

	/**
	 * Class constructor.
	 */
	public function __construct() {

		// Add WooCommerce support for Genesis Features
		add_post_type_support( 'product', array( 'genesis-layouts', 'genesis-seo', 'genesis-scripts', 'genesis-ss' ) );

		// Unhook WooCommerce Sidebar - use Genesis Sidebars instead
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

		// Unhook WooCommerce wrappers
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		// Hook new functions with Genesis wrappers
		add_action( 'woocommerce_before_main_content', array( $this, 'theme_wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content', array( $this, 'theme_wrapper_end' ), 10 );
		add_action( 'woocommerce_before_main_content', array( $this, 'shop_page_wrapper_start' ), 15 );
		add_action( 'woocommerce_after_main_content', array( $this, 'shop_page_wrapper_end' ), 5 );

		// move WooCommerce breadcrumbs in the same location as default Genesis
		add_action( 'init', array( $this,  'reposition_breadcrumbs' ) );

	}

	/**
	 * Add opening wrapper before WooCommerce loop.
	 */
	public function theme_wrapper_start() {

		do_action( 'genesis_before_content_sidebar_wrap' );
			genesis_markup(
		   		array(
			       'html5' => '<div %s>',
			       'xhtml' => '<div id="content-sidebar-wrap">',
			       'context' => 'content-sidebar-wrap',
		   		)
	   		);

		do_action( 'genesis_before_content' );
			genesis_markup(
				array(
					'html5' => '<main %s>',
					'xhtml' => '<div id="content" class="hfeed">',
					'context' => 'content',
		   		)
			);
		do_action( 'genesis_before_loop' );

	}

	/**
	 * Add closing wrapper after WooCommerce loop.
	 */
	public function theme_wrapper_end() {

		do_action( 'genesis_after_loop' );
			genesis_markup(
				array(
		    		'html5' => '</main>', //* end .content
		      		'xhtml' => '</div>', //* end #content
		  		)
	  		);
		  do_action( 'genesis_after_content' );

		  echo '</div>'; //* end .content-sidebar-wrap or #content-sidebar-wrap
		  do_action( 'genesis_after_content_sidebar_wrap' );
	}

	/**
	 * Adds Article Wrapper on Shop page
	 */
	public function shop_page_wrapper_start() {
		if ( ! is_shop() ) {
			return;
		}
		echo '<article class="entry">';

	}

	/**
	 * Closes Article Wrapper on Shop page
	 */
	public function shop_page_wrapper_end() {
		if ( ! is_shop() ) {
			return;
		}
		echo '</article>';

	}

	/**
	 * Removes WooCommerce Breadcrumbs (and allows for Genesis default breadcrumbs)
	 */
	public function reposition_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

}
new Genesis_WooCommerce_Compatability;
