<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

// Page (category, tag, archive, author) title

if ( daiquiri_need_page_title() ) {
	daiquiri_sc_layouts_showed('title', true);
	daiquiri_sc_layouts_showed('postmeta', false);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( false && is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
									'components' => daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('meta_parts')),
									'counters' => daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('counters')),
									'seo' => daiquiri_is_on(daiquiri_get_theme_option('seo_snippets'))
									), 'header', 1)
								);
							?></div><?php
						}
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$daiquiri_blog_title = daiquiri_get_blog_title();
							$daiquiri_blog_title_text = $daiquiri_blog_title_class = $daiquiri_blog_title_link = $daiquiri_blog_title_link_text = '';
							if (is_array($daiquiri_blog_title)) {
								$daiquiri_blog_title_text = $daiquiri_blog_title['text'];
								$daiquiri_blog_title_class = !empty($daiquiri_blog_title['class']) ? ' '.$daiquiri_blog_title['class'] : '';
								$daiquiri_blog_title_link = !empty($daiquiri_blog_title['link']) ? $daiquiri_blog_title['link'] : '';
								$daiquiri_blog_title_link_text = !empty($daiquiri_blog_title['link_text']) ? $daiquiri_blog_title['link_text'] : '';
							} else
								$daiquiri_blog_title_text = $daiquiri_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($daiquiri_blog_title_class); ?>"><?php
								$daiquiri_top_icon = daiquiri_get_category_icon();
								if (!empty($daiquiri_top_icon)) {
									$daiquiri_attr = daiquiri_getimagesize($daiquiri_top_icon);
									?><img src="<?php echo esc_url($daiquiri_top_icon); ?>" alt="<?php echo esc_attr(basename($daiquiri_top_icon)); ?>" <?php if (!empty($daiquiri_attr[3])) daiquiri_show_layout($daiquiri_attr[3]);?>><?php
								}
								echo wp_kses($daiquiri_blog_title_text, 'daiquiri_kses_content');
							?></h1>
							<?php
							if (!empty($daiquiri_blog_title_link) && !empty($daiquiri_blog_title_link_text)) {
								?><a href="<?php echo esc_url($daiquiri_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($daiquiri_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'daiquiri_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>