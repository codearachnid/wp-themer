<?php
/*
Plugin Name: WordPress Themer
Plugin URI: 
Description: Override theme, styles and templates without risk of loosing your changes with 3rd party updates
Version: 1.0
Author: Timothy Wood @codearachnid
Author URI: http://www.codearachnid.com
License: GPLv2
*/

/*
Copyright 2012 Imagine Simplicity and the Collaborators

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Don't load directly
if ( !defined( 'ABSPATH' ) )
	die( '-1' );


// add_action('init', 'tribe_disable_default_meta');

// function tribe_disable_default_meta() {
// 	remove_post_type_support( 'tribe_events', 'author' );
// 	remove_post_type_support( 'tribe_events', 'custom-fields' );
// 	remove_post_type_support( 'tribe_events', 'excerpt' );
// }


class WP_Themer {

	protected static $instance;

	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	/**
	 * run hooks on WP init
	 *
	 * @since 1.0
	 * @author codearachnid
	 * @return void
	 */
	function init() {
		load_plugin_textdomain( 'wp-themer', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}

	/**
	 * add menu items
	 *
	 * @since 1.0
	 * @author codearachnid
	 * @return void
	 */
	function add_menu() {
		add_theme_page( __( 'Theme Override', 'wp-themer' ), __( 'WP Themer', 'wp-themer' ), 'switch_themes', 'wp-themer', array( $this, 'theme_page' ));
	}

	function theme_page(){
		echo 'theme_page';
	}

	/**
	 * static singleton method
	 */
	static function instance() {
		if ( !isset( self::$instance ) ) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}


}

function wp_themer_init() {
	add_filter( 'wp_themer_init', array( 'WP_Themer', 'init_addon' ) );
	if ( class_exists( 'WP_Themer' ) ) {
		WP_Themer::instance();
	} else {
		add_action( 'admin_notices', 'The WordPress Themer is not able to be loaded.' );
	}
}
add_action( 'plugins_loaded', 'wp_themer_init' );