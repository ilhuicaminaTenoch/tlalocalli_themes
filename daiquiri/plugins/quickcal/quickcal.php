<?php
/* QuickCal support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_quickcal_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_quickcal_theme_setup9', 9 );
	function daiquiri_quickcal_theme_setup9() {
		add_filter( 'daiquiri_filter_merge_styles', 						'daiquiri_quickcal_merge_styles' );
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',		'daiquiri_quickcal_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_quickcal_tgmpa_required_plugins' ) ) {
	
	function daiquiri_quickcal_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'quickcal')) {
			$path = daiquiri_get_file_dir('plugins/quickcal/quickcal.zip');
			if (!empty($path) || daiquiri_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> daiquiri_storage_get_array('required_plugins', 'quickcal'),
					'slug' 		=> 'quickcal',
					'version'   => '1.0.12',
					'source' 	=> !empty($path) ? $path : 'upload://quickcal.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'daiquiri_exists_quickcal' ) ) {
	function daiquiri_exists_quickcal() {
		return class_exists('quickcal_plugin');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_quickcal_merge_styles' ) ) {
	
	function daiquiri_quickcal_merge_styles($list) {
		if (daiquiri_exists_quickcal()) {
			$list[] = 'plugins/quickcal/_quickcal.scss';
		}
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (daiquiri_exists_quickcal()) { require_once DAIQUIRI_THEME_DIR . 'plugins/quickcal/quickcal-styles.php'; }
?>