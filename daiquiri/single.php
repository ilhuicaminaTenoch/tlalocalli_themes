<?php
/**
 * The template to display single post
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

get_header();

while ( have_posts() ) { the_post();

	get_template_part( 'content', get_post_format() );
if(false) {
    // Previous/next post navigation.
    ?>
    <div class="nav-links-single"><?php
    the_post_navigation(array(
        'next_text' => '<span class="nav-arrow"></span>'
            . '<span class="screen-reader-text">' . esc_html__('Next post:', 'daiquiri') . '</span> '
            . '<h6 class="post-title">%title</h6>'
            . '<span class="post_date">%date</span>',
        'prev_text' => '<span class="nav-arrow"></span>'
            . '<span class="screen-reader-text">' . esc_html__('Previous post:', 'daiquiri') . '</span> '
            . '<h6 class="post-title">%title</h6>'
            . '<span class="post_date">%date</span>'
    ));
    ?></div><?php
}
	// Related posts
	if ((int) daiquiri_get_theme_option('show_related_posts') && ($daiquiri_related_posts = (int) daiquiri_get_theme_option('related_posts')) > 0) {
		daiquiri_show_related_posts(array('orderby' => 'rand',
										'posts_per_page' => max(1, min(9, $daiquiri_related_posts)),
										'columns' => max(1, min(4, daiquiri_get_theme_option('related_columns')))
										),
									daiquiri_get_theme_option('related_style')
									);
	}

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>