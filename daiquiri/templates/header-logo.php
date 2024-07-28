<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

$daiquiri_args = get_query_var('daiquiri_logo_args');

// Site logo
$daiquiri_logo_type   = isset($daiquiri_args['type']) ? $daiquiri_args['type'] : '';
$daiquiri_logo_image  = daiquiri_get_logo_image($daiquiri_logo_type);
$daiquiri_logo_text   = daiquiri_is_on(daiquiri_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$daiquiri_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($daiquiri_logo_image) || !empty($daiquiri_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($daiquiri_logo_image)) {
			if (empty($daiquiri_logo_type) && function_exists('the_custom_logo') && is_numeric( $daiquiri_logo_image ) && (int) $daiquiri_logo_image > 0) {
				the_custom_logo();
			} else {
				$daiquiri_attr = daiquiri_getimagesize($daiquiri_logo_image);
				echo '<img src="'.esc_url($daiquiri_logo_image).'" alt="'.esc_attr(basename($daiquiri_logo_image)).'"'.(!empty($daiquiri_attr[3]) ? ' '.wp_kses_data($daiquiri_attr[3]) : '').'>';
			}
		} else {
			daiquiri_show_layout(daiquiri_prepare_macros($daiquiri_logo_text), '<span class="logo_text">', '</span>');
			daiquiri_show_layout(daiquiri_prepare_macros($daiquiri_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>