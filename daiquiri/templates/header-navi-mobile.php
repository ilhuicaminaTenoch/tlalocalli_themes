<?php
/**
 * The template to show mobile menu
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */
?>
<div class="menu_mobile_overlay"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr(daiquiri_get_theme_option('menu_mobile_fullscreen') > 0 ? 'fullscreen' : 'narrow'); ?> scheme_dark">
	<div class="menu_mobile_inner">
		<a class="menu_mobile_close icon-cancel"></a><?php

		echo '<h5 class="title-menu-mobile">'.esc_html__('Menu','daiquiri').'</h5>';

		// Mobile menu
		$daiquiri_menu_mobile = daiquiri_get_nav_menu('menu_mobile');
		if (empty($daiquiri_menu_mobile)) {
			$daiquiri_menu_mobile = apply_filters('daiquiri_filter_get_mobile_menu', '');
			if (empty($daiquiri_menu_mobile)) $daiquiri_menu_mobile = daiquiri_get_nav_menu('menu_main');
			if (empty($daiquiri_menu_mobile)) $daiquiri_menu_mobile = daiquiri_get_nav_menu();
		}
		if (!empty($daiquiri_menu_mobile)) {
			if (!empty($daiquiri_menu_mobile))
				$daiquiri_menu_mobile = str_replace(
					array('menu_main', 'id="menu-', 'sc_layouts_menu_nav', 'sc_layouts_hide_on_mobile', 'hide_on_mobile'),
					array('menu_mobile', 'id="menu_mobile-', '', '', ''),
					$daiquiri_menu_mobile
					);
			if (strpos($daiquiri_menu_mobile, '<nav ')===false)
				$daiquiri_menu_mobile = sprintf('<nav class="menu_mobile_nav_area">%s</nav>', $daiquiri_menu_mobile);
			daiquiri_show_layout(apply_filters('daiquiri_filter_menu_mobile_layout', $daiquiri_menu_mobile));
		}

		if(false) {
			// Search field
			do_action('daiquiri_action_search', 'normal', 'search_mobile', false);
			// Social icons
			daiquiri_show_layout(daiquiri_get_socials_links(), '<div class="socials_mobile">', '</div>');
		}
		?>
	</div>
</div>
