<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_header_css = '';
$daiquiri_header_image = get_header_image();
$daiquiri_header_video = daiquiri_get_header_video();
if (!empty($daiquiri_header_image) && daiquiri_trx_addons_featured_image_override(is_singular() || daiquiri_storage_isset('blog_archive') || is_category())) {
	$daiquiri_header_image = daiquiri_get_current_mode_image($daiquiri_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($daiquiri_header_image) || !empty($daiquiri_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($daiquiri_header_video!='') echo ' with_bg_video';
					if ($daiquiri_header_image!='') echo ' '.esc_attr(daiquiri_add_inline_css_class('background-image: url('.esc_url($daiquiri_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (daiquiri_is_on(daiquiri_get_theme_option('header_fullheight'))) echo ' header_fullheight daiquiri-full-height';
					if (!daiquiri_is_inherit(daiquiri_get_theme_option('header_scheme')))
						echo ' scheme_' . esc_attr(daiquiri_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($daiquiri_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (daiquiri_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Mobile header
	if (daiquiri_is_on(daiquiri_get_theme_option("header_mobile_enabled"))) {
		get_template_part( 'templates/header-mobile' );
	}
	
	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

	// Display featured image in the header on the single posts
	// Comment next line to prevent show featured image in the header area
	// and display it in the post's content
	

?></header>