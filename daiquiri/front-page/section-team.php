<div class="front_page_section front_page_section_team<?php
			$daiquiri_scheme = daiquiri_get_theme_option('front_page_team_scheme');
			if (!daiquiri_is_inherit($daiquiri_scheme)) echo ' scheme_'.esc_attr($daiquiri_scheme);
			echo ' front_page_section_paddings_'.esc_attr(daiquiri_get_theme_option('front_page_team_paddings'));
		?>"<?php
		$daiquiri_css = '';
		$daiquiri_bg_image = daiquiri_get_theme_option('front_page_team_bg_image');
		if (!empty($daiquiri_bg_image)) 
			$daiquiri_css .= 'background-image: url('.esc_url(daiquiri_get_attachment_url($daiquiri_bg_image)).');';
		if (!empty($daiquiri_css))
			echo ' style="' . esc_attr($daiquiri_css) . '"';
?>><?php
	// Add anchor
	$daiquiri_anchor_icon = daiquiri_get_theme_option('front_page_team_anchor_icon');	
	$daiquiri_anchor_text = daiquiri_get_theme_option('front_page_team_anchor_text');	
	if ((!empty($daiquiri_anchor_icon) || !empty($daiquiri_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_team"'
										. (!empty($daiquiri_anchor_icon) ? ' icon="'.esc_attr($daiquiri_anchor_icon).'"' : '')
										. (!empty($daiquiri_anchor_text) ? ' title="'.esc_attr($daiquiri_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_team_inner<?php
			if (daiquiri_get_theme_option('front_page_team_fullheight'))
				echo ' daiquiri-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$daiquiri_css = '';
			$daiquiri_bg_mask = daiquiri_get_theme_option('front_page_team_bg_mask');
			$daiquiri_bg_color = daiquiri_get_theme_option('front_page_team_bg_color');
			if (!empty($daiquiri_bg_color) && $daiquiri_bg_mask > 0)
				$daiquiri_css .= 'background-color: '.esc_attr($daiquiri_bg_mask==1
																	? $daiquiri_bg_color
																	: daiquiri_hex2rgba($daiquiri_bg_color, $daiquiri_bg_mask)
																).';';
			if (!empty($daiquiri_css))
				echo ' style="' . esc_attr($daiquiri_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_team_content_wrap content_wrap">
			<?php
			// Caption
			$daiquiri_caption = daiquiri_get_theme_option('front_page_team_caption');
			if (!empty($daiquiri_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_team_caption front_page_block_<?php echo !empty($daiquiri_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses($daiquiri_caption, 'daiquiri_kses_content'); ?></h2><?php
			}
		
			// Description (text)
			$daiquiri_description = daiquiri_get_theme_option('front_page_team_description');
			if (!empty($daiquiri_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_team_description front_page_block_<?php echo !empty($daiquiri_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses(wpautop($daiquiri_description), 'daiquiri_kses_content'); ?></div><?php
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_team_output"><?php 
				if (is_active_sidebar('front_page_team_widgets')) {
					dynamic_sidebar( 'front_page_team_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!daiquiri_exists_trx_addons())
						daiquiri_customizer_need_trx_addons_message();
					else
						daiquiri_customizer_need_widgets_message('front_page_team_caption', 'ThemeREX Addons - Team');
				}
			?></div>
		</div>
	</div>
</div>