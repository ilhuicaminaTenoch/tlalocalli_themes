<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.10
 */

$daiquiri_footer_id = str_replace('footer-custom-', '', daiquiri_get_theme_option("footer_style"));
if ((int) $daiquiri_footer_id == 0) {
	$daiquiri_footer_id = daiquiri_get_post_id(array(
												'name' => $daiquiri_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUTS_PT') ? TRX_ADDONS_CPT_LAYOUTS_PT : 'cpt_layouts'
												)
											);
} else {
	$daiquiri_footer_id = apply_filters('daiquiri_filter_get_translated_layout', $daiquiri_footer_id);
}
$daiquiri_footer_meta = get_post_meta($daiquiri_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($daiquiri_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($daiquiri_footer_id))); 
						if (!empty($daiquiri_footer_meta['margin']) != '') 
							echo ' '.esc_attr(daiquiri_add_inline_css_class('margin-top: '.daiquiri_prepare_css_value($daiquiri_footer_meta['margin']).';'));
						if (!daiquiri_is_inherit(daiquiri_get_theme_option('footer_scheme')))
							echo ' scheme_' . esc_attr(daiquiri_get_theme_option('footer_scheme'));
						?>">
	<?php
    // Custom footer's layout
    do_action('daiquiri_action_show_layout', $daiquiri_footer_id);
	?>
</footer><!-- /.footer_wrap -->
