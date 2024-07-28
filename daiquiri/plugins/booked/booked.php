<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_booked_theme_setup9', 9 );
	function daiquiri_booked_theme_setup9() {
		add_filter( 'daiquiri_filter_merge_styles', 						'daiquiri_booked_merge_styles' );
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',		'daiquiri_booked_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_booked_tgmpa_required_plugins' ) ) {
	
	function daiquiri_booked_tgmpa_required_plugins($list=array()) {
		if (false && daiquiri_storage_isset('required_plugins', 'booked')) {
			$path = daiquiri_get_file_dir('plugins/booked/booked.zip');
			if (!empty($path) || daiquiri_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> daiquiri_storage_get_array('required_plugins', 'booked'),
					'slug' 		=> 'booked',
					'version'	=> '2.4',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'daiquiri_exists_booked' ) ) {
	function daiquiri_exists_booked() {
		return class_exists('booked_plugin');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_booked_merge_styles' ) ) {
	
	function daiquiri_booked_merge_styles($list) {
		if (daiquiri_exists_booked()) {
			$list[] = 'plugins/booked/_booked.scss';
		}
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (daiquiri_exists_booked()) { require_once DAIQUIRI_THEME_DIR . 'plugins/booked/booked-styles.php'; }
?>