<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.06
 */

$daiquiri_header_css = '';
$daiquiri_header_image = get_header_image();
$daiquiri_header_video = daiquiri_get_header_video();
if (!empty($daiquiri_header_image) && daiquiri_trx_addons_featured_image_override(is_singular() || daiquiri_storage_isset('blog_archive') || is_category())) {
	$daiquiri_header_image = daiquiri_get_current_mode_image($daiquiri_header_image);
}

$daiquiri_header_id = str_replace('header-custom-', '', daiquiri_get_theme_option("header_style"));
if ((int) $daiquiri_header_id == 0) {
	$daiquiri_header_id = daiquiri_get_post_id(array(
												'name' => $daiquiri_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$daiquiri_header_id = apply_filters('daiquiri_filter_get_translated_layout', $daiquiri_header_id);
}
$daiquiri_header_meta = get_post_meta($daiquiri_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($daiquiri_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($daiquiri_header_id)));
				echo !empty($daiquiri_header_image) || !empty($daiquiri_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($daiquiri_header_video!='') 
					echo ' with_bg_video';
				if ($daiquiri_header_image!='') 
					echo ' '.esc_attr(daiquiri_add_inline_css_class('background-image: url('.esc_url($daiquiri_header_image).');'));
				if (!empty($daiquiri_header_meta['margin']) != '') 
					echo ' '.esc_attr(daiquiri_add_inline_css_class('margin-bottom: '.esc_attr(daiquiri_prepare_css_value($daiquiri_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (daiquiri_is_on(daiquiri_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight daiquiri-full-height';
				if (!daiquiri_is_inherit(daiquiri_get_theme_option('header_scheme')))
					echo ' scheme_' . esc_attr(daiquiri_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($daiquiri_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('daiquiri_action_show_layout', $daiquiri_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>