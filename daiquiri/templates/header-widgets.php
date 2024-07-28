<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

// Header sidebar
$daiquiri_header_name = daiquiri_get_theme_option('header_widgets');
$daiquiri_header_present = !daiquiri_is_off($daiquiri_header_name) && is_active_sidebar($daiquiri_header_name);
if ($daiquiri_header_present) { 
	daiquiri_storage_set('current_sidebar', 'header');
	$daiquiri_header_wide = daiquiri_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($daiquiri_header_name) ) {
		dynamic_sidebar($daiquiri_header_name);
	}
	$daiquiri_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($daiquiri_widgets_output)) {
		$daiquiri_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $daiquiri_widgets_output);
		$daiquiri_need_columns = strpos($daiquiri_widgets_output, 'columns_wrap')===false;
		if ($daiquiri_need_columns) {
			$daiquiri_columns = max(0, (int) daiquiri_get_theme_option('header_columns'));
			if ($daiquiri_columns == 0) $daiquiri_columns = min(6, max(1, substr_count($daiquiri_widgets_output, '<aside ')));
			if ($daiquiri_columns > 1)
				$daiquiri_widgets_output = preg_replace("/<aside([^>]*)class=\"widget/", "<aside$1class=\"column-1_".esc_attr($daiquiri_columns).' widget', $daiquiri_widgets_output);
			else
				$daiquiri_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($daiquiri_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$daiquiri_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($daiquiri_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'daiquiri_action_before_sidebar' );
				daiquiri_show_layout($daiquiri_widgets_output);
				do_action( 'daiquiri_action_after_sidebar' );
				if ($daiquiri_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$daiquiri_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>