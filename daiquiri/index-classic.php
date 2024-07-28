<?php
/**
 * The template for homepage posts with "Classic" style
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

daiquiri_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	daiquiri_show_layout(get_query_var('blog_archive_start'));

	$daiquiri_classes = 'posts_container '
						. (substr(daiquiri_get_theme_option('blog_style'), 0, 7) == 'classic' ? 'columns_wrap columns_padding_bottom' : 'masonry_wrap');
	$daiquiri_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$daiquiri_sticky_out = daiquiri_get_theme_option('sticky_style')=='columns' 
							&& is_array($daiquiri_stickies) && count($daiquiri_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($daiquiri_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	if (!$daiquiri_sticky_out) {
		if (daiquiri_get_theme_option('first_post_large') && !is_paged() && !in_array(daiquiri_get_theme_option('body_style'), array('fullwide', 'fullscreen'))) {
			the_post();
			get_template_part( 'content', 'excerpt' );
		}
		
		?><div class="<?php echo esc_attr($daiquiri_classes); ?>"><?php
	}
	while ( have_posts() ) { the_post(); 
		if ($daiquiri_sticky_out && !is_sticky()) {
			$daiquiri_sticky_out = false;
			?></div><div class="<?php echo esc_attr($daiquiri_classes); ?>"><?php
		}
		get_template_part( 'content', $daiquiri_sticky_out && is_sticky() ? 'sticky' : 'classic' );
	}
	
	?></div><?php

	daiquiri_show_pagination();

	daiquiri_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>