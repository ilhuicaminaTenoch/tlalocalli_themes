<?php
/* Elementor Builder support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_elm_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_elm_theme_setup9', 9 );
	function daiquiri_elm_theme_setup9() {
		
		add_filter( 'daiquiri_filter_merge_styles',					'daiquiri_elm_merge_styles' );

		if (daiquiri_exists_elementor()) {
	
			// Add/Remove params in the standard elements
			//-----------------------------------------------------
			add_action( 'elementor/element/before_section_end',		'daiquiri_elm_add_color_scheme_control', 10, 3 );
			add_action( 'elementor/element/print_template',			'daiquiri_elm_add_color_scheme_to_template', 10, 2 );
			add_action( 'elementor/frontend/element/before_render', 'daiquiri_elm_add_color_scheme_class' );
		}
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',	'daiquiri_elm_tgmpa_required_plugins' );
		}
	}
}

// Add control to select color scheme in the sections and columns
if (!function_exists('daiquiri_elm_add_color_scheme_control')) {
	
	function daiquiri_elm_add_color_scheme_control($element, $section_id, $args) {
		$elm_list = apply_filters('daiquiri_filter_add_scheme_in_elements', array('section', 'column'));
		if ( is_object($element) && in_array($element->get_name(), $elm_list) && 'section_advanced' === $section_id ) {
			$element->add_control('scheme', array(
					'type' => \Elementor\Controls_Manager::SELECT,
					'label' => esc_html__("Color scheme", 'daiquiri'),
					'label_block' => true,
					'options' => daiquiri_get_list_schemes(true),
					'default' => 'inherit',
					) );
		}
	}
}

// Add class with selected color scheme to the sections and columns in Backend
if (!function_exists('daiquiri_elm_add_color_scheme_to_template')) {
	
	function daiquiri_elm_add_color_scheme_to_template($template, $element) {
		if ( is_object($element) ) {
			if ( $element->get_name() == 'section' )
				$template = str_replace('elementor-row', 'elementor-row scheme_{{ settings.scheme }}', $template);
			else if ( $element->get_name() == 'column' )
				$template = str_replace('elementor-column-wrap', 'elementor-column-wrap scheme_{{ settings.scheme }}', $template);
		}
		return $template;
	}
}

// Add class with selected color scheme to the sections and columns in Frontend
if (!function_exists('daiquiri_elm_add_color_scheme_class')) {
	
	function daiquiri_elm_add_color_scheme_class($element) {
		$elm_list = apply_filters('daiquiri_filter_add_scheme_in_elements', array('section', 'column'));
		if ( is_object($element) && in_array($element->get_name(), $elm_list) ) {
			$scheme = $element->get_settings('scheme');
			if (!empty($scheme) && !daiquiri_is_inherit($scheme)) {
				$element->add_render_attribute( '_wrapper', array(
					'class' => 'scheme_'.esc_attr($scheme),
					) );
			}
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_elm_tgmpa_required_plugins' ) ) {
	
	function daiquiri_elm_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'elementor')) {
			$list[] = array(
				'name' 		=> daiquiri_storage_get_array('required_plugins', 'elementor'),
				'slug' 		=> 'elementor',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if WPBakery Page Builder installed and activated
if ( !function_exists( 'daiquiri_exists_elementor' ) ) {
	function daiquiri_exists_elementor() {
		return class_exists('Elementor\Plugin');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_elm_merge_styles' ) ) {
	
	function daiquiri_elm_merge_styles($list) {
		if (daiquiri_exists_elementor()) {
			$list[] = 'plugins/elementor/_elementor.scss';
		}
		return $list;
	}
}



// Shortcodes support
//------------------------------------------------------------------------


// Add plugin-specific colors and fonts to the custom CSS
if (daiquiri_exists_elementor()) { require_once DAIQUIRI_THEME_DIR . 'plugins/elementor/elementor-styles.php'; }
?>