<?php
$daiquiri_args = array_merge(array(
								'style' => 'normal',
								'class' => '',
								'ajax' => false
								), (array) get_query_var('daiquiri_search_args'));
?><div class="search_wrap search_style_<?php
								echo esc_attr($daiquiri_args['style']) 
									. (!empty($daiquiri_args['class']) ? ' '.esc_attr($daiquiri_args['class']) : '');
?>">
	<div class="search_form_wrap">
		<form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
			<input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'daiquiri'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
			<button type="submit" class="search_submit icon-search"></button>
		</form>
	</div>
</div>