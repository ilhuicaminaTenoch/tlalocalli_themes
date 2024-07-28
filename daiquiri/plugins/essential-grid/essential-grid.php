<?php
/* Essential Grid support functions
------------------------------------------------------------------------------- */


// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_essential_grid_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_essential_grid_theme_setup9', 9 );
	function daiquiri_essential_grid_theme_setup9() {
		
		add_filter( 'daiquiri_filter_merge_styles',						'daiquiri_essential_grid_merge_styles' );

		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',		'daiquiri_essential_grid_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_essential_grid_tgmpa_required_plugins' ) ) {
	
	function daiquiri_essential_grid_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'essential-grid')) {
			$path = daiquiri_get_file_dir('plugins/essential-grid/essential-grid.zip');
			if (!empty($path) || daiquiri_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
						'name' 		=> daiquiri_storage_get_array('required_plugins', 'essential-grid'),
						'slug' 		=> 'essential-grid',
						'version'	=> '3.1.2.1',
						'source'	=> !empty($path) ? $path : 'upload://essential-grid.zip',
						'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'daiquiri_exists_essential_grid' ) ) {
	function daiquiri_exists_essential_grid() {
		return defined( 'EG_PLUGIN_PATH' ) || defined( 'ESG_PLUGIN_PATH' );
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_essential_grid_merge_styles' ) ) {
	
	function daiquiri_essential_grid_merge_styles($list) {
		if (daiquiri_exists_essential_grid()) {
			$list[] = 'plugins/essential-grid/_essential-grid.scss';
		}
		return $list;
	}
}
?>