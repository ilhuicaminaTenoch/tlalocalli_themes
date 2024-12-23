<?php
/* Cookie Information support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'daiquiri_wp_gdpr_compliance_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'daiquiri_wp_gdpr_compliance_theme_setup9', 9 );
	function daiquiri_wp_gdpr_compliance_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'daiquiri_filter_tgmpa_required_plugins', 'daiquiri_wp_gdpr_compliance_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'daiquiri_wp_gdpr_compliance_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('daiquiri_filter_tgmpa_required_plugins',	'daiquiri_wp_gdpr_compliance_tgmpa_required_plugins');
	function daiquiri_wp_gdpr_compliance_tgmpa_required_plugins( $list = array() ) {
		if ( false && daiquiri_storage_isset( 'required_plugins', 'wp-gdpr-compliance' ) && daiquiri_storage_get_array( 'required_plugins', 'wp-gdpr-compliance', 'install' ) !== false ) {
			$list[] = array(
				'name'     => daiquiri_storage_get_array( 'required_plugins', 'wp-gdpr-compliance' ),
				'slug'     => 'wp-gdpr-compliance',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'daiquiri_exists_wp_gdpr_compliance' ) ) {
	function daiquiri_exists_wp_gdpr_compliance() {
		return defined( 'WP_GDPR_C_ROOT_FILE' ) || defined( 'WPGDPRC_ROOT_FILE' );
	}
}
