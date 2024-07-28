<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.10
 */


// Socials
if ( daiquiri_is_on(daiquiri_get_theme_option('socials_in_footer')) && ($daiquiri_output = daiquiri_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php daiquiri_show_layout($daiquiri_output); ?>
		</div>
	</div>
	<?php
}
?>