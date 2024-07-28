<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage DAIQUIRI
 * @since DAIQUIRI 1.0.14
 */
$daiquiri_header_video = daiquiri_get_header_video();
$daiquiri_embed_video = '';
if (!empty($daiquiri_header_video) && !daiquiri_is_from_uploads($daiquiri_header_video)) {
	if (daiquiri_is_youtube_url($daiquiri_header_video) && preg_match('/[=\/]([^=\/]*)$/', $daiquiri_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$daiquiri_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($daiquiri_header_video) . '[/embed]' ));
			$daiquiri_embed_video = daiquiri_make_video_autoplay($daiquiri_embed_video);
		} else {
			$daiquiri_header_video = str_replace('/watch?v=', '/embed/', $daiquiri_header_video);
			$daiquiri_header_video = daiquiri_add_to_url($daiquiri_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$daiquiri_embed_video = '<iframe src="' . esc_url($daiquiri_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php daiquiri_show_layout($daiquiri_embed_video); ?></div><?php
	}
}
?>