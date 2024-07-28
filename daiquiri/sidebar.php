<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

if (daiquiri_sidebar_present()) {
	ob_start();
	$daiquiri_sidebar_name = daiquiri_get_theme_option('sidebar_widgets');
	daiquiri_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($daiquiri_sidebar_name) ) {
		dynamic_sidebar($daiquiri_sidebar_name);
	}
	$daiquiri_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($daiquiri_out)) {
		$daiquiri_sidebar_position = daiquiri_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($daiquiri_sidebar_position); ?> widget_area<?php if (!daiquiri_is_inherit(daiquiri_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(daiquiri_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'daiquiri_action_before_sidebar' );
				daiquiri_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $daiquiri_out));
				do_action( 'daiquiri_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>