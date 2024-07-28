<div class="front_page_section front_page_section_googlemap<?php
			$daiquiri_scheme = daiquiri_get_theme_option('front_page_googlemap_scheme');
			if (!daiquiri_is_inherit($daiquiri_scheme)) echo ' scheme_'.esc_attr($daiquiri_scheme);
			echo ' front_page_section_paddings_'.esc_attr(daiquiri_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$daiquiri_css = '';
		$daiquiri_bg_image = daiquiri_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($daiquiri_bg_image)) 
			$daiquiri_css .= 'background-image: url('.esc_url(daiquiri_get_attachment_url($daiquiri_bg_image)).');';
		if (!empty($daiquiri_css))
			echo ' style="' . esc_attr($daiquiri_css) . '"';
?>><?php
	// Add anchor
	$daiquiri_anchor_icon = daiquiri_get_theme_option('front_page_googlemap_anchor_icon');	
	$daiquiri_anchor_text = daiquiri_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($daiquiri_anchor_icon) || !empty($daiquiri_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($daiquiri_anchor_icon) ? ' icon="'.esc_attr($daiquiri_anchor_icon).'"' : '')
										. (!empty($daiquiri_anchor_text) ? ' title="'.esc_attr($daiquiri_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (daiquiri_get_theme_option('front_page_googlemap_fullheight'))
				echo ' daiquiri-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$daiquiri_css = '';
			$daiquiri_bg_mask = daiquiri_get_theme_option('front_page_googlemap_bg_mask');
			$daiquiri_bg_color = daiquiri_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($daiquiri_bg_color) && $daiquiri_bg_mask > 0)
				$daiquiri_css .= 'background-color: '.esc_attr($daiquiri_bg_mask==1
																	? $daiquiri_bg_color
																	: daiquiri_hex2rgba($daiquiri_bg_color, $daiquiri_bg_mask)
																).';';
			if (!empty($daiquiri_css))
				echo ' style="' . esc_attr($daiquiri_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$daiquiri_layout = daiquiri_get_theme_option('front_page_googlemap_layout');
			if ($daiquiri_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$daiquiri_caption = daiquiri_get_theme_option('front_page_googlemap_caption');
			$daiquiri_description = daiquiri_get_theme_option('front_page_googlemap_description');
			if (!empty($daiquiri_caption) || !empty($daiquiri_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($daiquiri_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($daiquiri_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($daiquiri_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses($daiquiri_caption, 'daiquiri_kses_content');
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($daiquiri_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($daiquiri_description) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses(wpautop($daiquiri_description), 'daiquiri_kses_content');
						?></div><?php
					}
				if ($daiquiri_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$daiquiri_content = daiquiri_get_theme_option('front_page_googlemap_content');
			if (!empty($daiquiri_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($daiquiri_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($daiquiri_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($daiquiri_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses($daiquiri_content, 'daiquiri_kses_content');
				?></div><?php
	
				if ($daiquiri_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($daiquiri_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!daiquiri_exists_trx_addons())
						daiquiri_customizer_need_trx_addons_message();
					else
						daiquiri_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($daiquiri_layout == 'columns' && (!empty($daiquiri_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>