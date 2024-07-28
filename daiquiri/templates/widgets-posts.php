<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_post_id    = get_the_ID();
$daiquiri_post_date  = daiquiri_get_date();
$daiquiri_post_title = get_the_title();
$daiquiri_post_link  = get_permalink();
$daiquiri_post_author_id   = get_the_author_meta('ID');
$daiquiri_post_author_name = get_the_author_meta('display_name');
$daiquiri_post_author_url  = get_author_posts_url($daiquiri_post_author_id, '');

$daiquiri_args = get_query_var('daiquiri_args_widgets_posts');
$daiquiri_show_date = isset($daiquiri_args['show_date']) ? (int) $daiquiri_args['show_date'] : 1;
$daiquiri_show_image = isset($daiquiri_args['show_image']) ? (int) $daiquiri_args['show_image'] : 1;
$daiquiri_show_author = isset($daiquiri_args['show_author']) ? (int) $daiquiri_args['show_author'] : 1;
$daiquiri_show_counters = isset($daiquiri_args['show_counters']) ? (int) $daiquiri_args['show_counters'] : 1;
$daiquiri_show_categories = isset($daiquiri_args['show_categories']) ? (int) $daiquiri_args['show_categories'] : 1;

$daiquiri_output = daiquiri_storage_get('daiquiri_output_widgets_posts');

$daiquiri_post_counters_output = '';
if ( $daiquiri_show_counters ) {
	$daiquiri_post_counters_output = '<span class="post_info_item post_info_counters">'
								. daiquiri_get_post_counters('comments')
							. '</span>';
}


$daiquiri_output .= '<article class="post_item with_thumb">';

if ($daiquiri_show_image) {
	$daiquiri_post_thumb = get_the_post_thumbnail($daiquiri_post_id, daiquiri_get_thumb_size('tiny'), array(
		'alt' => the_title_attribute( array( 'echo' => false ) )
	));
	if ($daiquiri_post_thumb) $daiquiri_output .= '<div class="post_thumb">' . ($daiquiri_post_link ? '<a href="' . esc_url($daiquiri_post_link) . '">' : '') . ($daiquiri_post_thumb) . ($daiquiri_post_link ? '</a>' : '') . '</div>';
}

$daiquiri_output .= '<div class="post_content">'
			. ($daiquiri_show_categories 
					? '<div class="post_categories">'
						. daiquiri_get_post_categories()
						. $daiquiri_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($daiquiri_post_link ? '<a href="' . esc_url($daiquiri_post_link) . '">' : '') . ($daiquiri_post_title) . ($daiquiri_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('daiquiri_filter_get_post_info', 
								'<div class="post_info">'
									. ($daiquiri_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($daiquiri_post_link ? '<a href="' . esc_url($daiquiri_post_link) . '" class="post_info_date">' : '') 
											. esc_html($daiquiri_post_date) 
											. ($daiquiri_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($daiquiri_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'daiquiri') . ' ' 
											. ($daiquiri_post_link ? '<a href="' . esc_url($daiquiri_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($daiquiri_post_author_name) 
											. ($daiquiri_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$daiquiri_show_categories && $daiquiri_post_counters_output
										? $daiquiri_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
daiquiri_storage_set('daiquiri_output_widgets_posts', $daiquiri_output);
?>