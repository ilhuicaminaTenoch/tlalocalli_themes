<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

daiquiri_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	daiquiri_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$daiquiri_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$daiquiri_sticky_out = daiquiri_get_theme_option('sticky_style')=='columns' 
							&& is_array($daiquiri_stickies) && count($daiquiri_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($daiquiri_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($daiquiri_sticky_out && !is_sticky()) {
			$daiquiri_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $daiquiri_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($daiquiri_sticky_out) {
		$daiquiri_sticky_out = false;
		?></div><?php
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