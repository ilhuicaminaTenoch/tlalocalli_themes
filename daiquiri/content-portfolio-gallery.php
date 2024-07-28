<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_blog_style = explode('_', daiquiri_get_theme_option('blog_style'));
$daiquiri_columns = empty($daiquiri_blog_style[1]) ? 2 : max(2, $daiquiri_blog_style[1]);
$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
$daiquiri_animation = daiquiri_get_theme_option('blog_animation');
$daiquiri_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($daiquiri_columns).' post_format_'.esc_attr($daiquiri_post_format) ); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($daiquiri_image[1]) && !empty($daiquiri_image[2])) echo intval($daiquiri_image[1]) .'x' . intval($daiquiri_image[2]); ?>"
	data-src="<?php if (!empty($daiquiri_image[0])) echo esc_url($daiquiri_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$daiquiri_image_hover = 'icon';
	if (in_array($daiquiri_image_hover, array('icons', 'zoom'))) $daiquiri_image_hover = 'dots';
	$daiquiri_components = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('meta_parts'));
	$daiquiri_counters = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('counters'));
	daiquiri_show_post_featured(array(
		'hover' => $daiquiri_image_hover,
		'thumb_size' => daiquiri_get_thumb_size( strpos(daiquiri_get_theme_option('body_style'), 'full')!==false || $daiquiri_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($daiquiri_components)
										? daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
											'components' => $daiquiri_components,
											'counters' => $daiquiri_counters,
											'seo' => false,
											'echo' => false
											), $daiquiri_blog_style[0], $daiquiri_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'daiquiri') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>