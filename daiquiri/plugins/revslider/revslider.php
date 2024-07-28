<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_revslider_theme_setup9', 9 );
	function daiquiri_revslider_theme_setup9() {

		add_filter( 'daiquiri_filter_merge_styles',				'daiquiri_revslider_merge_styles' );
		
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins','daiquiri_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_revslider_tgmpa_required_plugins' ) ) {
	
	function daiquiri_revslider_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'revslider')) {
			$path = daiquiri_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || daiquiri_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> daiquiri_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'version'	=> '6.7.7',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'daiquiri_exists_revslider' ) ) {
	function daiquiri_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_revslider_merge_styles' ) ) {
	
	function daiquiri_revslider_merge_styles($list) {
		if (daiquiri_exists_revslider()) {
			$list[] = 'plugins/revslider/_revslider.scss';
		}
		return $list;
	}
}
?>