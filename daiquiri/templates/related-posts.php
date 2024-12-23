<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_link = get_permalink();
$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
?><div id="post-<?php the_ID(); ?>" 
	<?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($daiquiri_post_format) ); ?>><?php
	daiquiri_show_post_featured(array(
		'thumb_size' => apply_filters('daiquiri_filter_related_thumb_size', daiquiri_get_thumb_size( (int) daiquiri_get_theme_option('related_posts') == 1 ? 'huge' : 'big' )),
		'show_no_image' => daiquiri_get_theme_setting('allow_no_image'),
		'singular' => false,
		'post_info' => '<div class="post_header entry-header">'
							. '<div class="post_categories">'.wp_kses(daiquiri_get_post_categories(''), 'daiquiri_kses_content').'</div>'
							. '<h6 class="post_title entry-title"><a href="'.esc_url($daiquiri_link).'">'.esc_html(get_the_title()).'</a></h6>'
							. (in_array(get_post_type(), array('post', 'attachment'))
									? '<span class="post_date"><a href="'.esc_url($daiquiri_link).'">'.wp_kses_data(daiquiri_get_date()).'</a></span>'
									: '')
						. '</div>'
		)
	);
?></div>