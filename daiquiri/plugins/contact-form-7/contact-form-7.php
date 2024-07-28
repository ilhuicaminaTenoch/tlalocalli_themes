<?php
/* Contact Form 7 support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_cf7_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_cf7_theme_setup9', 9 );
	function daiquiri_cf7_theme_setup9() {
		
		add_filter( 'daiquiri_filter_merge_styles',							'daiquiri_cf7_merge_styles' );
		add_filter( 'daiquiri_filter_merge_scripts', 'daiquiri_cf7_merge_scripts' );
		add_filter('wpcf7_autop_or_not', '__return_false');
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',			'daiquiri_cf7_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_cf7_tgmpa_required_plugins' ) ) {
	
	function daiquiri_cf7_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'contact-form-7')) {
			// CF7 plugin
			$list[] = array(
					'name' 		=> daiquiri_storage_get_array('required_plugins', 'contact-form-7'),
					'slug' 		=> 'contact-form-7',
					'required' 	=> false
			);
		}
		return $list;
	}
}



// Check if cf7 installed and activated
if ( !function_exists( 'daiquiri_exists_cf7' ) ) {
	function daiquiri_exists_cf7() {
		return class_exists('WPCF7');
	}
}
	
// Merge custom styles
if ( !function_exists( 'daiquiri_cf7_merge_styles' ) ) {
	function daiquiri_cf7_merge_styles($list) {
		if (daiquiri_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/_contact-form-7.scss';
		}
		return $list;
	}
}

// Merge custom scripts
if ( !function_exists( 'daiquiri_cf7_merge_scripts' ) ) {
	function daiquiri_cf7_merge_scripts($list) {
		if (daiquiri_exists_cf7()) {
			$list[] = 'plugins/contact-form-7/contact-form-7.js';
		}
		return $list;
	}
}
?>