<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.10
 */

// Footer sidebar
$daiquiri_footer_name = daiquiri_get_theme_option('footer_widgets');
$daiquiri_footer_present = !daiquiri_is_off($daiquiri_footer_name) && is_active_sidebar($daiquiri_footer_name);
if ($daiquiri_footer_present) { 
	daiquiri_storage_set('current_sidebar', 'footer');
	$daiquiri_footer_wide = daiquiri_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($daiquiri_footer_name) ) {
		dynamic_sidebar($daiquiri_footer_name);
	}
	$daiquiri_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($daiquiri_out)) {
		$daiquiri_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $daiquiri_out);
		$daiquiri_need_columns = true;
		if ($daiquiri_need_columns) {
			$daiquiri_columns = max(0, (int) daiquiri_get_theme_option('footer_columns'));
			if ($daiquiri_columns == 0) $daiquiri_columns = min(4, max(1, substr_count($daiquiri_out, '<aside ')));
			if ($daiquiri_columns > 1)
				$daiquiri_out = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($daiquiri_columns).' widget', $daiquiri_out);
			else
				$daiquiri_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($daiquiri_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$daiquiri_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($daiquiri_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'daiquiri_action_before_sidebar' );
				daiquiri_show_layout($daiquiri_out);
				do_action( 'daiquiri_action_after_sidebar' );
				if ($daiquiri_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$daiquiri_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>