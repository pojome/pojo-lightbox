<?php
/*
Plugin Name: Pojo Lightbox
Description: This plugin used to add the lightbox (overlay) effect to all images on your WordPress site with Pojo Framework.
Plugin URI: https://github.com/pojome/pojo-lightbox
Author: Pojo Team
Version: 1.0.5
Author URI: http://pojo.me/
Text Domain: pojo-lightbox
Domain Path: /languages/
License: GPLv2 or later


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'POJO_LIGHTBOX__FILE__', __FILE__ );
define( 'POJO_LIGHTBOX_BASE', plugin_basename( POJO_LIGHTBOX__FILE__ ) );
define( 'POJO_LIGHTBOX_URL', plugins_url( '/', POJO_LIGHTBOX__FILE__ ) );
define( 'POJO_LIGHTBOX_ASSETS_URL', POJO_LIGHTBOX_URL . 'assets/' );

final class Pojo_Lightbox_Main {

	private static $_instance = null;
	
	public $admin_ui;

	/**
	 * @return Pojo_Lightbox_Main
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new Pojo_Lightbox_Main();
		return self::$_instance;
	}
	
	public function enqueue_scripts() {
		if ( 'disable' === pojo_get_option( 'lightbox_enable' ) )
			return;
		
		wp_enqueue_style( 'jquery.prettyPhoto', POJO_LIGHTBOX_ASSETS_URL . 'css/prettyPhoto.css' );
		
		wp_register_script( 'jquery.prettyPhoto', POJO_LIGHTBOX_ASSETS_URL . 'js/jquery.prettyPhoto.min.js', array( 'jquery' ), '3.1.5', true );
		wp_enqueue_script( 'jquery.prettyPhoto' );
	}
	
	public function pojo_localize_scripts_array( $params = array() ) {
		$lightbox_args = array(
			'theme'           => pojo_get_option( 'lightbox_theme' ),
			'animation_speed' => pojo_get_option( 'lightbox_animation_speed' ),
			'overlay_gallery' => ( 'hide' !== pojo_get_option( 'lightbox_overlay_gallery' ) ),
			'slideshow'       => floatval( pojo_get_option( 'lightbox_slideshow' ) ),
			'opacity'         => floatval( pojo_get_option( 'lightbox_bg_opacity' ) ),
			'show_title'      => ( 'show' === pojo_get_option( 'lightbox_show_title' ) ),
			'deeplinking'     => false,
		);

		if ( 'hide' === pojo_get_option( 'lightbox_social_icons' ) )
			$lightbox_args['social_tools'] = '';

		if ( empty( $lightbox_args['theme'] ) )
			$lightbox_args['theme'] = 'pp_default';

		if ( empty( $lightbox_args['theme'] ) )
			$lightbox_args['theme'] = 'fast';

		$params['lightbox_enable']     = pojo_get_option( 'lightbox_enable' );
		$params['lightbox_smartphone'] = pojo_get_option( 'lightbox_smartphone' );
		$params['lightbox_args']       = $lightbox_args;
		
		return $params;
	}
	
	public function include_settings() {
		include( 'classes/pojo-lightbox-setting-page.php' );
		new Pojo_Lightbox_Setting_Page( 50 );
	}

	public function admin_notices() {
		echo '<div class="error"><p>' . sprintf( __( '<a href="%s" target="_blank">Pojo Framework</a> is not active. Please activate any theme by Pojo before you are using "Pojo Lightbox" plugin.', 'pojo-lightbox' ), 'http://pojo.me/' ) . '</p></div>';
	}
	
	public function bootstrap() {
		// This plugin for Pojo Themes..
		if ( ! class_exists( 'Pojo_Core' ) ) {
			add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
			return;
		}

		load_plugin_textdomain( 'pojo-lightbox', false, basename( dirname( POJO_LIGHTBOX__FILE__ ) ) . '/languages' );
		
		include( 'classes/pojo-lightbox-admin-ui.php' );
		
		$this->admin_ui = new Pojo_Lightbox_Admin_UI();

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 150 );
		add_action( 'pojo_localize_scripts_array', array( &$this, 'pojo_localize_scripts_array' ) );
		add_action( 'pojo_framework_base_settings_included', array( &$this, 'include_settings' ) );
	}

	public function __construct() {
		add_action( 'init', array( &$this, 'bootstrap' ) );
	}
	
}

Pojo_Lightbox_Main::instance();

// EOF
