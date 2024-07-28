<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( !function_exists( 'daiquiri_elm_get_css' ) ) {
	add_filter( 'daiquiri_filter_get_css', 'daiquiri_elm_get_css', 10, 4 );
	function daiquiri_elm_get_css($css, $colors, $fonts, $scheme='') {
		if (isset($css['fonts']) && $fonts) {
			$css['fonts'] .= <<<CSS

CSS;
		}

		if (isset($css['colors']) && $colors) {
			$css['colors'] .= <<<CSS

.elementor-shape .elementor-shape-fill {
	fill: {$colors['bg_color']};
}

CSS;
		}
		
		return $css;
	}
}
?>