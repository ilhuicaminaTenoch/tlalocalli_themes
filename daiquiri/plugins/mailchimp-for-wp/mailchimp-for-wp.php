<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('daiquiri_mailchimp_theme_setup9')) {
	add_action( 'after_setup_theme', 'daiquiri_mailchimp_theme_setup9', 9 );
	function daiquiri_mailchimp_theme_setup9() {

		add_filter( 'daiquiri_filter_merge_styles',						'daiquiri_mailchimp_merge_styles');
		
		if (is_admin()) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins',		'daiquiri_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'daiquiri_mailchimp_tgmpa_required_plugins' ) ) {
	
	function daiquiri_mailchimp_tgmpa_required_plugins($list=array()) {
		if (daiquiri_storage_isset('required_plugins', 'mailchimp-for-wp')) {
			$list[] = array(
				'name' 		=> daiquiri_storage_get_array('required_plugins', 'mailchimp-for-wp'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'daiquiri_exists_mailchimp' ) ) {
	function daiquiri_exists_mailchimp() {
		return function_exists('__mc4wp_load_plugin') || defined('MC4WP_VERSION');
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------
	
// Merge custom styles
if ( !function_exists( 'daiquiri_mailchimp_merge_styles' ) ) {
	
	function daiquiri_mailchimp_merge_styles($list) {
		if (daiquiri_exists_mailchimp()) {
			$list[] = 'plugins/mailchimp-for-wp/_mailchimp-for-wp.scss';
		}
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (daiquiri_exists_mailchimp()) { require_once DAIQUIRI_THEME_DIR . 'plugins/mailchimp-for-wp/mailchimp-for-wp-styles.php'; }
?>