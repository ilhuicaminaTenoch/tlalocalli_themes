<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

daiquiri_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	daiquiri_show_layout(get_query_var('blog_archive_start'));

	$daiquiri_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$daiquiri_sticky_out = daiquiri_get_theme_option('sticky_style')=='columns' 
							&& is_array($daiquiri_stickies) && count($daiquiri_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$daiquiri_cat = daiquiri_get_theme_option('parent_cat');
	$daiquiri_post_type = daiquiri_get_theme_option('post_type');
	$daiquiri_taxonomy = daiquiri_get_post_type_taxonomy($daiquiri_post_type);
	$daiquiri_show_filters = daiquiri_get_theme_option('show_filters');
	$daiquiri_tabs = array();
	if (!daiquiri_is_off($daiquiri_show_filters)) {
		$daiquiri_args = array(
			'type'			=> $daiquiri_post_type,
			'child_of'		=> $daiquiri_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'number'		=> '',
			'taxonomy'		=> $daiquiri_taxonomy,
			'pad_counts'	=> false
		);
		$daiquiri_portfolio_list = get_terms($daiquiri_args);
		if (is_array($daiquiri_portfolio_list) && count($daiquiri_portfolio_list) > 0) {
			$daiquiri_tabs[$daiquiri_cat] = esc_html__('All', 'daiquiri');
			foreach ($daiquiri_portfolio_list as $daiquiri_term) {
				if (isset($daiquiri_term->term_id)) $daiquiri_tabs[$daiquiri_term->term_id] = $daiquiri_term->name;
			}
		}
	}
	if (count($daiquiri_tabs) > 0) {
		$daiquiri_portfolio_filters_ajax = true;
		$daiquiri_portfolio_filters_active = $daiquiri_cat;
		$daiquiri_portfolio_filters_id = 'portfolio_filters';
		?>
		<div class="portfolio_filters daiquiri_tabs daiquiri_tabs_ajax">
			<ul class="portfolio_titles daiquiri_tabs_titles">
				<?php
				foreach ($daiquiri_tabs as $daiquiri_id=>$daiquiri_title) {
					?><li><a href="<?php echo esc_url(daiquiri_get_hash_link(sprintf('#%s_%s_content', $daiquiri_portfolio_filters_id, $daiquiri_id))); ?>" data-tab="<?php echo esc_attr($daiquiri_id); ?>"><?php echo esc_html($daiquiri_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$daiquiri_ppp = daiquiri_get_theme_option('posts_per_page');
			if (daiquiri_is_inherit($daiquiri_ppp)) $daiquiri_ppp = '';
			foreach ($daiquiri_tabs as $daiquiri_id=>$daiquiri_title) {
				$daiquiri_portfolio_need_content = $daiquiri_id==$daiquiri_portfolio_filters_active || !$daiquiri_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $daiquiri_portfolio_filters_id, $daiquiri_id)); ?>"
					class="portfolio_content daiquiri_tabs_content"
					data-blog-template="<?php echo esc_attr(daiquiri_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(daiquiri_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($daiquiri_ppp); ?>"
					data-post-type="<?php echo esc_attr($daiquiri_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($daiquiri_taxonomy); ?>"
					data-cat="<?php echo esc_attr($daiquiri_id); ?>"
					data-parent-cat="<?php echo esc_attr($daiquiri_cat); ?>"
					data-need-content="<?php echo (false===$daiquiri_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($daiquiri_portfolio_need_content) 
						daiquiri_show_portfolio_posts(array(
							'cat' => $daiquiri_id,
							'parent_cat' => $daiquiri_cat,
							'taxonomy' => $daiquiri_taxonomy,
							'post_type' => $daiquiri_post_type,
							'page' => 1,
							'sticky' => $daiquiri_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		daiquiri_show_portfolio_posts(array(
			'cat' => $daiquiri_cat,
			'parent_cat' => $daiquiri_cat,
			'taxonomy' => $daiquiri_taxonomy,
			'post_type' => $daiquiri_post_type,
			'page' => 1,
			'sticky' => $daiquiri_sticky_out
			)
		);
	}

	daiquiri_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>