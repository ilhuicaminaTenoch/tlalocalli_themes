<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_blog_style = explode('_', daiquiri_get_theme_option('blog_style'));
$daiquiri_columns = empty($daiquiri_blog_style[1]) ? 2 : max(2, $daiquiri_blog_style[1]);
$daiquiri_expanded = !daiquiri_sidebar_present() && daiquiri_is_on(daiquiri_get_theme_option('expand_content'));
$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
$daiquiri_animation = daiquiri_get_theme_option('blog_animation');
$daiquiri_components = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('meta_parts'));
$daiquiri_counters = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('counters'));

?><div class="<?php echo esc_attr($daiquiri_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($daiquiri_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($daiquiri_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($daiquiri_columns)
					. ' post_layout_'.esc_attr($daiquiri_blog_style[0]) 
					. ' post_layout_'.esc_attr($daiquiri_blog_style[0]).'_'.esc_attr($daiquiri_columns)
					); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	daiquiri_show_post_featured( array( 'thumb_size' => daiquiri_get_thumb_size($daiquiri_blog_style[0] == 'classic'
													? (strpos(daiquiri_get_theme_option('body_style'), 'full')!==false 
															? ( $daiquiri_columns > 2 ? 'big' : 'huge' )
															: (	$daiquiri_columns > 2
																? ($daiquiri_expanded ? 'med' : 'small')
																: ($daiquiri_expanded ? 'big' : 'med')
																)
														)
													: (strpos(daiquiri_get_theme_option('body_style'), 'full')!==false 
															? ( $daiquiri_columns > 2 ? 'masonry-big' : 'full' )
															: (	$daiquiri_columns <= 2 && $daiquiri_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($daiquiri_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php 
			do_action('daiquiri_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('daiquiri_action_before_post_meta'); 

			// Post meta
			if (!empty($daiquiri_components))
				daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
					'components' => $daiquiri_components,
					'counters' => $daiquiri_counters,
					'seo' => false
					), $daiquiri_blog_style[0], $daiquiri_columns)
				);

			do_action('daiquiri_action_after_post_meta'); 
			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$daiquiri_show_learn_more = false;
			if (has_excerpt()) {
				the_excerpt();
			} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
				the_content( '' );
			} else if (in_array($daiquiri_post_format, array('link', 'aside', 'status'))) {
				the_content();
			} else if ($daiquiri_post_format == 'quote') {
				if (($quote = daiquiri_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
					daiquiri_show_layout(wpautop($quote));
				else
					the_excerpt();
			} else if (substr(get_the_content(), 0, 1)!='[') {
				the_excerpt();
			}
			?>
		</div>
		<?php
		// Post meta
		if (in_array($daiquiri_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($daiquiri_components))
				daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
					'components' => $daiquiri_components,
					'counters' => $daiquiri_counters
					), $daiquiri_blog_style[0], $daiquiri_columns)
				);
		}
		// More button
		if ( $daiquiri_show_learn_more ) {
			?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'daiquiri'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->

</article></div>