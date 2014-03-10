<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pojo_PrettyPhoto_Setting_Page extends Pojo_Settings_Page_Base {

	public function section_lightbox( $sections = array() ) {
		$fields = array();

		$fields[] = array(
			'id' => 'lightbox_enable',
			'title' => __( 'Enable LightBox', 'pojo' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Enable', 'pojo' ),
				'disable' => __( 'Disable', 'pojo' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_theme',
			'title'    => __( 'LightBox Theme', 'pojo' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'desc' => __( '6 Themes to choose from', 'pojo' ),
			'options'  => array(
				''    => __( 'Default', 'pojo' ),
				'light_rounded' => __( 'Light Rounded', 'pojo' ),
				'dark_rounded'  => __( 'Dark Rounded', 'pojo' ),
				'dark_square'   => __( 'Dark Square', 'pojo' ),
				'light_square'  => __( 'Light Square', 'pojo' ),
				'facebook'      => __( 'Facebook', 'pojo' ),
			),
			'std'      => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_animation_speed',
			'title'    => __( 'Animation Speed', 'pojo' ),
			'type' => Pojo_Settings::FIELD_SELECT,
			'std'      => '',
			'options'  => array(
				''   => __( 'Fast', 'pojo' ),
				'normal' => __( 'Normal', 'pojo' ),
				'slow'   => __( 'Slow', 'pojo' ),
			),
		);

		$fields[] = array(
			'id'       => 'lightbox_bg_opacity',
			'title'    => __( 'Background Opacity', 'pojo' ),
			'std'      => '0.80',
			'sanitize_callback' => 'floatval',
		);

		$fields[] = array(
			'id'       => 'lightbox_show_title',
			'title'    => __( 'Show Title', 'pojo' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'show' => __( 'Show', 'pojo' ),
				'' => __( 'Hide', 'pojo' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_overlay_gallery',
			'title'    => __( 'Gallery Thumbnails', 'pojo' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Show', 'pojo' ),
				'hide' => __( 'Hide', 'pojo' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_slideshow',
			'title'    => __( 'Autoplay Gallery Speed', 'pojo' ),
			'desc' => __( 'Default: 5000, 1000 ms = 1 second', 'pojo' ),
			'std'      => '5000',
			'sanitize_callback' => array( 'Pojo_Settings_Validations', 'field_number' ),
		);

		$fields[] = array(
			'id'       => 'lightbox_social_icons',
			'title'    => __( 'Social Icons', 'pojo' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'desc'     => __( 'Show social sharing buttons on lightbox', 'pojo' ),
			'options' => array(
				'' => __( 'Show', 'pojo' ),
				'hide' => __( 'Hide', 'pojo' ),
			),
			'std' => '',
		);

		$fields[] = array(
			'id'       => 'lightbox_smartphone',
			'title'    => __( 'LightBox on Smartphone', 'pojo' ),
			'type'     => Pojo_Settings::FIELD_SELECT,
			'options' => array(
				'' => __( 'Enable', 'pojo' ),
				'disable' => __( 'Disable', 'pojo' ),
			),
			'std' => '',
		);

		$sections[] = array(
			'id' => 'section-lightbox',
			'page' => $this->_page_id,
			'title' => __( 'Lightbox:', 'pojo' ),
			'intro' => '',
			'fields' => $fields,
		);

		return $sections;
	}

	public function __construct( $priority = 10 ) {
		$this->_page_id = 'pojo-lightbox';
		$this->_page_title = __( 'Lightbox Settings', 'pojo' );
		$this->_page_menu_title = __( 'Lightbox', 'pojo' );
		$this->_page_type = 'submenu';
		$this->_page_parent = 'pojo-general';

		add_filter( 'pojo_register_settings_sections', array( &$this, 'section_lightbox' ), 100 );

		parent::__construct( $priority );
	}
	
}