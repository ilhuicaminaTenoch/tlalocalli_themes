<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($daiquiri_columns).' post_format_'.esc_attr($daiquiri_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$daiquiri_image_hover = daiquiri_get_theme_option('image_hover');
	// Featured image
	daiquiri_show_post_featured(array(
		'thumb_size' => daiquiri_get_thumb_size(strpos(daiquiri_get_theme_option('body_style'), 'full')!==false || $daiquiri_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $daiquiri_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $daiquiri_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>