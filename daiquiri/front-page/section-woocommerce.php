<div class="front_page_section front_page_section_woocommerce<?php
			$daiquiri_scheme = daiquiri_get_theme_option('front_page_woocommerce_scheme');
			if (!daiquiri_is_inherit($daiquiri_scheme)) echo ' scheme_'.esc_attr($daiquiri_scheme);
			echo ' front_page_section_paddings_'.esc_attr(daiquiri_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$daiquiri_css = '';
		$daiquiri_bg_image = daiquiri_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($daiquiri_bg_image)) 
			$daiquiri_css .= 'background-image: url('.esc_url(daiquiri_get_attachment_url($daiquiri_bg_image)).');';
		if (!empty($daiquiri_css))
			echo ' style="' . esc_attr($daiquiri_css) . '"';
?>><?php
	// Add anchor
	$daiquiri_anchor_icon = daiquiri_get_theme_option('front_page_woocommerce_anchor_icon');	
	$daiquiri_anchor_text = daiquiri_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($daiquiri_anchor_icon) || !empty($daiquiri_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($daiquiri_anchor_icon) ? ' icon="'.esc_attr($daiquiri_anchor_icon).'"' : '')
										. (!empty($daiquiri_anchor_text) ? ' title="'.esc_attr($daiquiri_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (daiquiri_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' daiquiri-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$daiquiri_css = '';
			$daiquiri_bg_mask = daiquiri_get_theme_option('front_page_woocommerce_bg_mask');
			$daiquiri_bg_color = daiquiri_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($daiquiri_bg_color) && $daiquiri_bg_mask > 0)
				$daiquiri_css .= 'background-color: '.esc_attr($daiquiri_bg_mask==1
																	? $daiquiri_bg_color
																	: daiquiri_hex2rgba($daiquiri_bg_color, $daiquiri_bg_mask)
																).';';
			if (!empty($daiquiri_css))
				echo ' style="' . esc_attr($daiquiri_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$daiquiri_caption = daiquiri_get_theme_option('front_page_woocommerce_caption');
			$daiquiri_description = daiquiri_get_theme_option('front_page_woocommerce_description');
			if (!empty($daiquiri_caption) || !empty($daiquiri_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($daiquiri_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($daiquiri_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses($daiquiri_caption, 'daiquiri_kses_content');
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($daiquiri_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($daiquiri_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses(wpautop($daiquiri_description), 'daiquiri_kses_content');
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$daiquiri_woocommerce_sc = daiquiri_get_theme_option('front_page_woocommerce_products');
				if ($daiquiri_woocommerce_sc == 'products') {
					$daiquiri_woocommerce_sc_ids = daiquiri_get_theme_option('front_page_woocommerce_products_per_page');
					$daiquiri_woocommerce_sc_per_page = count(explode(',', $daiquiri_woocommerce_sc_ids));
				} else {
					$daiquiri_woocommerce_sc_per_page = max(1, (int) daiquiri_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$daiquiri_woocommerce_sc_columns = max(1, min($daiquiri_woocommerce_sc_per_page, (int) daiquiri_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$daiquiri_woocommerce_sc}"
									. ($daiquiri_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($daiquiri_woocommerce_sc_ids).'"' 
											: '')
									. ($daiquiri_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(daiquiri_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($daiquiri_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(daiquiri_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(daiquiri_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($daiquiri_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($daiquiri_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>