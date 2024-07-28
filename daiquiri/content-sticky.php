<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
$daiquiri_animation = daiquiri_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($daiquiri_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($daiquiri_post_format) ); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	daiquiri_show_post_featured(array(
		'thumb_size' => daiquiri_get_thumb_size($daiquiri_columns==1 ? 'big' : ($daiquiri_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($daiquiri_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(), 'sticky', $daiquiri_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>