<?php
/*
Plugin Name: Pojo prettyPhoto
Description:
Author: Pojo Team
Version: 1.0.0
Author URI: http://pojo.me/
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

define( 'POJO_PRETTY_PHOTO__FILE__', __FILE__ );
define( 'POJO_PRETTY_PHOTO_BASE', plugin_basename( POJO_PRETTY_PHOTO__FILE__ ) );
define( 'POJO_PRETTY_PHOTO_URL', plugins_url( '/', POJO_PRETTY_PHOTO__FILE__ ) );
define( 'POJO_PRETTY_PHOTO_ASSETS_URL', POJO_PRETTY_PHOTO_URL . 'assets/' );

final class Pojo_PrettyPhoto_Main {

	private static $_instance = null;

	/**
	 * @return Pojo_PrettyPhoto_Main
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new Pojo_PrettyPhoto_Main();
		return self::$_instance;
	}
	
	public function enqueue_scripts() {
		if ( 'disable' === pojo_get_option( 'lightbox_enable' ) )
			return;
		
		wp_enqueue_style( 'jquery.prettyPhoto', POJO_PRETTY_PHOTO_ASSETS_URL . 'css/prettyPhoto.css' );
		
		wp_register_script( 'jquery.prettyPhoto', POJO_PRETTY_PHOTO_ASSETS_URL . 'js/jquery.prettyPhoto.min.js', array( 'jquery' ), '3.1.5', true );
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
		
		$params['lightbox_enable'] = pojo_get_option( 'lightbox_enable' );
		$params['lightbox_smartphone'] = pojo_get_option( 'lightbox_smartphone' );
		$params['lightbox_args'] = $lightbox_args;
		
		return $params;
	}
	
	public function include_settings() {
		include( 'classes/pojo-pretty-photo-setting-page.php' );
		new Pojo_PrettyPhoto_Setting_Page( 50 );
	}
	
	public function init() {
		// This plugin for Pojo Themes..
		if ( ! class_exists( 'Pojo_Maintenance' ) )
			return;

		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 150 );
		add_action( 'pojo_localize_scripts_array', array( &$this, 'pojo_localize_scripts_array' ) );
		add_action( 'pojo_framework_base_settings_included', array( &$this, 'include_settings' ) );
	}

	public function __construct() {
		add_action( 'init', array( &$this, 'init' ) );
	}
	
}

Pojo_PrettyPhoto_Main::instance();

// EOF