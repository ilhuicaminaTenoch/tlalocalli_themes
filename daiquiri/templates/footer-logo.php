<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.10
 */

// Logo
if (daiquiri_is_on(daiquiri_get_theme_option('logo_in_footer'))) {
	$daiquiri_logo_image = '';
	if (daiquiri_is_on(daiquiri_get_theme_option('logo_retina_enabled')) && daiquiri_get_retina_multiplier() > 1)
		$daiquiri_logo_image = daiquiri_get_theme_option( 'logo_footer_retina' );
	if (empty($daiquiri_logo_image)) 
		$daiquiri_logo_image = daiquiri_get_theme_option( 'logo_footer' );
	$daiquiri_logo_text   = get_bloginfo( 'name' );
	if (!empty($daiquiri_logo_image) || !empty($daiquiri_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($daiquiri_logo_image)) {
					$daiquiri_attr = daiquiri_getimagesize($daiquiri_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($daiquiri_logo_image).'" class="logo_footer_image" alt="'.esc_attr(basename($daiquiri_logo_image)).'"'.(!empty($daiquiri_attr[3]) ? ' ' . wp_kses_data($daiquiri_attr[3]) : '').'></a>' ;
				} else if (!empty($daiquiri_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($daiquiri_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>