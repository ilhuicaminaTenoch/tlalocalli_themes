<?php
/**
 * The style "chess" of the Services item
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.6.13
 */

$args = get_query_var('trx_addons_args_sc_services');

if (empty($args['id'])) $args['id'] = 'sc_services_'.str_replace('.', '', mt_rand());

$link = get_permalink();
$meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);

if (!empty($args['slider'])) {
	?><div class="slider-slide swiper-slide"><?php
} else if ((int) $args['columns'] > 1) {
	?><div class="<?php echo esc_attr(trx_addons_get_column_class(1, $args['columns'])); ?> "><?php
}
?>
<div class="sc_services_item<?php
	echo !isset($args['hide_excerpt']) || (int) $args['hide_excerpt']==0 ? ' with_content' : ' without_content';
	echo (isset($args['style']) && (int) $args['style'] === 1) ? ' with_style' : ' without_style';
?>"<?php
	if (!empty($args['popup'])) {
		?> data-post_id="<?php echo esc_attr(get_the_ID()); ?>"<?php
		?> data-post_type="<?php echo esc_attr(TRX_ADDONS_CPT_SERVICES_PT); ?>"<?php
	}
?>><?php
	trx_addons_get_template_part('templates/tpl.featured.php',
									'trx_addons_args_featured',
									apply_filters('trx_addons_filter_args_featured', array(
												'class' => 'sc_services_item_header',
												'show_no_image' => true,
												'thumb_bg' => true,
												'thumb_size' => apply_filters('trx_addons_filter_thumb_size', trx_addons_get_thumb_size('masonry-big'), 'services-chess')
												),
												'services-chess'
												)
								);
if ((int) $args['columns'] > 1) {
    ?><div class="sc_services_item_content_wrap"><?php
}
	?>
	<div class="sc_services_item_content">
        <div class="sc_services_item_subtitle"><?php trx_addons_show_layout(trx_addons_get_post_terms(', ', get_the_ID(), TRX_ADDONS_CPT_SERVICES_TAXONOMY));?></div>
        <?php
        $show_more = true;
		$title_tag = 'h6';
		if ((int) $args['columns'] == 1) $title_tag = 'h4';
		?>
		<<?php echo esc_attr($title_tag); ?> class="sc_services_item_title<?php if (!empty($meta['price'])) echo ' with_price'; ?>"><a href="<?php echo esc_url($link); ?>"><?php
			the_title();
			// Price
			if (!empty($meta['price'])) {
				?><div class="sc_services_item_price"><?php echo esc_html($meta['price']); ?></div><?php
			}
		?></a></<?php echo esc_attr($title_tag); ?>>
		<?php if (!isset($args['hide_excerpt']) || (int) $args['hide_excerpt']==0) { ?>
			<div class="sc_services_item_text"><?php the_excerpt(); ?></div>
            <?php
            // More button
            if ( $show_more ) {
            ?><div class="sc_services_item_button sc_item_button"><a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr(apply_filters('trx_addons_filter_sc_item_link_classes', 'sc_button color_style_default sc_button_default sc_button_size_normal', 'sc_services', $args)); ?>"><?php esc_html_e('view details', 'daiquiri'); ?></a></div><?php
            }
            ?>
		<?php } ?>
	</div>




<?php
if (!empty($meta['icon'])) {
    $svg = $img = '';
    if (trx_addons_is_url($meta['icon'])) {
        $img = $meta['icon'];
        $meta['icon'] = basename($meta['icon']);
    }
    ?>
<span class="sc_services_item_icon <?php echo esc_attr($meta['icon']); ?>"></span><?php
}

if ((int) $args['columns'] > 1) {
    ?></div><?php
}
?>

</div>
<?php
if (!empty($args['slider']) || (int) $args['columns'] > 1) {
	?></div><?php
}
?>