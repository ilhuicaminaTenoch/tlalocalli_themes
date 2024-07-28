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
$daiquiri_columns = empty($daiquiri_blog_style[1]) ? 1 : max(1, $daiquiri_blog_style[1]);
$daiquiri_expanded = !daiquiri_sidebar_present() && daiquiri_is_on(daiquiri_get_theme_option('expand_content'));
$daiquiri_post_format = get_post_format();
$daiquiri_post_format = empty($daiquiri_post_format) ? 'standard' : str_replace('post-format-', '', $daiquiri_post_format);
$daiquiri_animation = daiquiri_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($daiquiri_columns).' post_format_'.esc_attr($daiquiri_post_format) ); ?>
	<?php echo (!daiquiri_is_off($daiquiri_animation) ? ' data-animation="'.esc_attr(daiquiri_get_animation_classes($daiquiri_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($daiquiri_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.the_title_attribute( array( 'echo' => false ) ).'" icon="'.esc_attr(daiquiri_get_post_icon()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	daiquiri_show_post_featured( array(
											'class' => $daiquiri_columns == 1 ? 'daiquiri-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => daiquiri_get_thumb_size(
																	strpos(daiquiri_get_theme_option('body_style'), 'full')!==false
																		? ( $daiquiri_columns > 1 ? 'huge' : 'original' )
																		: (	$daiquiri_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('daiquiri_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('daiquiri_action_before_post_meta'); 

			// Post meta
			$daiquiri_components = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('meta_parts'));
			$daiquiri_counters = daiquiri_array_get_keys_by_value(daiquiri_get_theme_option('counters'));
			$daiquiri_post_meta = empty($daiquiri_components) 
										? '' 
										: daiquiri_show_post_meta(apply_filters('daiquiri_filter_post_meta_args', array(
												'components' => $daiquiri_components,
												'counters' => $daiquiri_counters,
												'seo' => false,
												'echo' => false
												), $daiquiri_blog_style[0], $daiquiri_columns)
											);
			daiquiri_show_layout($daiquiri_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$daiquiri_show_learn_more = !in_array($daiquiri_post_format, array('link', 'aside', 'status', 'quote'));
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
				daiquiri_show_layout($daiquiri_post_meta);
			}
			// More button
			if ( $daiquiri_show_learn_more ) {
				?><p><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'daiquiri'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>