<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$daiquiri_content = '';
$daiquiri_blog_archive_mask = '%%CONTENT%%';
$daiquiri_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $daiquiri_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($daiquiri_content = apply_filters('the_content', get_the_content())) != '') {
		if (($daiquiri_pos = strpos($daiquiri_content, $daiquiri_blog_archive_mask)) !== false) {
			$daiquiri_content = preg_replace('/(\<p\>\s*)?'.$daiquiri_blog_archive_mask.'(\s*\<\/p\>)/i', $daiquiri_blog_archive_subst, $daiquiri_content);
		} else
			$daiquiri_content .= $daiquiri_blog_archive_subst;
		$daiquiri_content = explode($daiquiri_blog_archive_mask, $daiquiri_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) daiquiri_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$daiquiri_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$daiquiri_args = daiquiri_query_add_posts_and_cats($daiquiri_args, '', daiquiri_get_theme_option('post_type'), daiquiri_get_theme_option('parent_cat'));
$daiquiri_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($daiquiri_page_number > 1) {
	$daiquiri_args['paged'] = $daiquiri_page_number;
	$daiquiri_args['ignore_sticky_posts'] = true;
}
$daiquiri_ppp = daiquiri_get_theme_option('posts_per_page');
if ((int) $daiquiri_ppp != 0)
	$daiquiri_args['posts_per_page'] = (int) $daiquiri_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($daiquiri_args);


// Add internal query vars in the new query!
if (is_array($daiquiri_content) && count($daiquiri_content) == 2) {
	set_query_var('blog_archive_start', $daiquiri_content[0]);
	set_query_var('blog_archive_end', $daiquiri_content[1]);
}

get_template_part('index');
?>