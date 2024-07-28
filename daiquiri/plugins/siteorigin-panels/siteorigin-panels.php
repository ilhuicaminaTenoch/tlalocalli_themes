<?php
/* SiteOrigin Panels support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_sop_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_sop_theme_setup9', 9 );
	function daiquiri_sop_theme_setup9() {

		add_filter( 'daiquiri_filter_merge_styles',						'daiquiri_sop_merge_styles' );
		
		if (daiquiri_exists_sop()) {
			add_filter( 'siteorigin_panels_general_style_fields',		'daiquiri_sop_add_row_params', 10, 3 );
			add_filter( 'siteorigin_panels_general_style_attributes',	'daiquiri_sop_row_style_attributes', 10, 2 );
		}
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',		'daiquiri_sop_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_sop_tgmpa_required_plugins' ) ) {
	
	function daiquiri_sop_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'siteorigin-panels')) {
			$list[] = array(
					'name' 		=> esc_html__('SiteOrigin Panels (free Page Builder)', 'daiquiri'),
					'slug' 		=> 'siteorigin-panels',
					'required' 	=> false
			);
			$list[] = array(
					'name' 		=> esc_html__('SiteOrigin Panels Widgets bundle', 'daiquiri'),
					'slug' 		=> 'so-widgets-bundle',
					'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if SiteOrigin Panels is installed and activated
if ( !function_exists( 'daiquiri_exists_sop' ) ) {
	function daiquiri_exists_sop() {
		return class_exists('SiteOrigin_Panels');
	}
}

// Check if SiteOrigin Widgets Bundle is installed and activated
if ( !function_exists( 'daiquiri_exists_sow' ) ) {
	function daiquiri_exists_sow() {
		return class_exists('SiteOrigin_Widgets_Bundle');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_sop_merge_styles' ) ) {
	
	function daiquiri_sop_merge_styles($list) {
		if (daiquiri_exists_sop()) {
			$list[] = 'plugins/siteorigin-panels/_siteorigin-panels.scss';
		}
		return $list;
	}
}



// Shortcodes support
//------------------------------------------------------------------------

// Add params to the standard SOP rows
if ( !function_exists( 'daiquiri_sop_add_row_params' ) ) {
	
	function daiquiri_sop_add_row_params($fields, $post_id, $args) {
		$fields['scheme'] = array(
			'name'        => esc_html__( 'Color scheme', 'daiquiri' ),
			'description' => wp_kses_data( __( 'Select color scheme to decorate this block', 'daiquiri' )),
			'group'       => 'design',
			'priority'    => 3,
			'default'     => 'inherit',
			'options'     => daiquiri_get_list_schemes(true),
			'type'        => 'select'
		);
		return $fields;
	}
}

// Add layouts specific classes to the standard SOP rows
if ( !function_exists( 'daiquiri_sop_row_style_attributes' ) ) {
	
	function daiquiri_sop_row_style_attributes($attributes, $style) {
		if ( !empty($style['scheme']) && !trx_addons_is_inherit($style['scheme']) )
			$attributes['class'][] = 'scheme_' . $style['scheme'];
		return $attributes;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (daiquiri_exists_sop()) { require_once DAIQUIRI_THEME_DIR . 'plugins/siteorigin-panels/siteorigin-panels-styles.php'; }
?>