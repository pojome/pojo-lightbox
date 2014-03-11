<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_Lightbox_Setting_Page extends Pojo_Settings_Page_Base {

	public function section_lightbox( $sections = array() ) {
		$fields = array();

		$fields[] = array(
			'id' => 'lightbox_enable',
			'title' => __( 'Enable LightBox', 'pojo-lightbox' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Enable', 'pojo-lightbox' ),
				'disable' => __( 'Disable', 'pojo-lightbox' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_theme',
			'title'    => __( 'LightBox Theme', 'pojo-lightbox' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'desc' => __( '6 Themes to choose from', 'pojo-lightbox' ),
			'options'  => array(
				''    => __( 'Default', 'pojo-lightbox' ),
				'light_rounded' => __( 'Light Rounded', 'pojo-lightbox' ),
				'dark_rounded'  => __( 'Dark Rounded', 'pojo-lightbox' ),
				'dark_square'   => __( 'Dark Square', 'pojo-lightbox' ),
				'light_square'  => __( 'Light Square', 'pojo-lightbox' ),
				'facebook'      => __( 'Facebook', 'pojo-lightbox' ),
			),
			'std'      => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_animation_speed',
			'title'    => __( 'Animation Speed', 'pojo-lightbox' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'std'      => '',
			'options'  => array(
				''   => __( 'Fast', 'pojo-lightbox' ),
				'normal' => __( 'Normal', 'pojo-lightbox' ),
				'slow'   => __( 'Slow', 'pojo-lightbox' ),
			),
		);

		$fields[] = array(
			'id'       => 'lightbox_bg_opacity',
			'title'    => __( 'Background Opacity', 'pojo-lightbox' ),
			'std'      => '0.80',
			'sanitize_callback' => 'floatval',
		);

		$fields[] = array(
			'id'       => 'lightbox_show_title',
			'title'    => __( 'Show Title', 'pojo-lightbox' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'show' => __( 'Show', 'pojo-lightbox' ),
				'' => __( 'Hide', 'pojo-lightbox' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_overlay_gallery',
			'title'    => __( 'Gallery Thumbnails', 'pojo-lightbox' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Show', 'pojo-lightbox' ),
				'hide' => __( 'Hide', 'pojo-lightbox' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_slideshow',
			'title'    => __( 'Autoplay Gallery Speed', 'pojo-lightbox' ),
			'desc' => __( 'Default: 5000, 1000 ms = 1 second', 'pojo-lightbox' ),
			'std'      => '5000',
			'sanitize_callback' => array( 'Pojo_Settings_Validations', 'field_number' ),
		);

		$fields[] = array(
			'id'       => 'lightbox_social_icons',
			'title'    => __( 'Social Icons', 'pojo-lightbox' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'desc'     => __( 'Show social sharing buttons on lightbox', 'pojo-lightbox' ),
			'options' => array(
				'' => __( 'Show', 'pojo-lightbox' ),
				'hide' => __( 'Hide', 'pojo-lightbox' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_smartphone',
			'title'    => __( 'LightBox on Smartphone', 'pojo-lightbox' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Enable', 'pojo-lightbox' ),
				'disable' => __( 'Disable', 'pojo-lightbox' ),
			),
			'std' => '',
		);

		$sections[] = array(
			'id' => 'section-lightbox',
			'page' => $this->_page_id,
			'title' => __( 'Lightbox:', 'pojo-lightbox' ),
			'intro' => '',
			'fields' => $fields,
		);

		return $sections;
	}

	public function __construct( $priority = 10 ) {
		$this->_page_id = 'pojo-lightbox';
		$this->_page_title = __( 'Lightbox Settings', 'pojo-lightbox' );
		$this->_page_menu_title = __( 'Lightbox', 'pojo-lightbox' );
		$this->_page_type = 'submenu';
		$this->_page_parent = 'pojo-general';

		add_filter( 'pojo_register_settings_sections', array( &$this, 'section_lightbox' ), 100 );

		parent::__construct( $priority );
	}
	
}