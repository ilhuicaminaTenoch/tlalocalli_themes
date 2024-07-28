<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap<?php
				if (!daiquiri_is_inherit(daiquiri_get_theme_option('copyright_scheme')))
					echo ' scheme_' . esc_attr(daiquiri_get_theme_option('copyright_scheme'));
 				?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$daiquiri_copyright = daiquiri_prepare_macros(daiquiri_get_theme_option('copyright'));
				if (!empty($daiquiri_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $daiquiri_copyright, $daiquiri_matches)) {
						$daiquiri_copyright = str_replace($daiquiri_matches[1], date_i18n(str_replace(array('{', '}'), '', $daiquiri_matches[1])), $daiquiri_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($daiquiri_copyright));
				}
			?></div>
		</div>
	</div>
</div>
