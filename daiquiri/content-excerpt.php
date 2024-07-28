<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
$daiquiri_animation = daiquiri_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($daiquiri_post_format) ); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$cats = get_post_type()=='post' ? get_the_category_list(', ') : apply_filters('daiquiri_filter_get_post_categories', '');

	// Featured image
	daiquiri_show_post_featured(array(
		'thumb_size' => daiquiri_get_thumb_size( strpos(daiquiri_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ),
		'post_info' => (!empty($cats) ? '<span class="post_categories_style">'. ($cats). '</span>' : '')
	));

	do_action('daiquiri_action_before_post_meta');
	// Post meta
	$daiquiri_components = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('meta_parts'));
	$daiquiri_counters = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('counters'));

	if (!empty($daiquiri_components))
		daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
				'components' => $daiquiri_components,
				'counters' => $daiquiri_counters,
				'seo' => false
			), 'excerpt', 1)
	);

	// Title and post meta
	if (get_the_title() != '') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('daiquiri_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (daiquiri_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'daiquiri' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'daiquiri' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$daiquiri_show_learn_more = !in_array($daiquiri_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php
			// More button
			if ( $daiquiri_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'daiquiri'); ?></a></p><?php
			}

		}
	?></div><!-- .entry-content -->
</article>