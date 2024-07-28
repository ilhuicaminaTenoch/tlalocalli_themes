<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0
 */

						// Widgets area inside page content
						daiquiri_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					daiquiri_create_widgets_area('widgets_below_page');

					$daiquiri_body_style = daiquiri_get_theme_option('body_style');
					if ($daiquiri_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$daiquiri_footer_type = daiquiri_get_theme_option("footer_type");
			if ($daiquiri_footer_type == 'custom' && !daiquiri_is_layouts_available())
				$daiquiri_footer_type = 'default';
			get_template_part( "templates/footer-{$daiquiri_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (daiquiri_is_on(daiquiri_get_theme_option('debug_mode')) && daiquiri_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(daiquiri_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>