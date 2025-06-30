
<h1>Options Demo Admin Page</h1>
<form method="post" action="<?php echo admin_url('admin-post.php') ?>">
	<?php
	wp_nonce_field("optionsdemo");
	$optionsdemo_longitude = get_option('optionsdemo_longitude2');
	$optionsdemo_color = get_option('optionsdemo_color');
	?>
	<label for="optionsdemo_longitude2"><?php _e('Longitude', 'optionsdemo'); ?></label>
	<input type="text" id="optionsdemo_longitude2" name="optionsdemo_longitude2" value="<?php echo esc_attr($optionsdemo_longitude); ?>">
	<!-- color  -->
	<label for="optionsdemo_color"><?php _e('Color', 'optionsdemo'); ?></label>
	<input type="color" id="optionsdemo_color" name="optionsdemo_color" value="<?php echo esc_attr($optionsdemo_color); ?>">



	<input type="hidden" name="action" value="optionsdemo_admin_page">
	<!-- <input type="hidden" name="action" value="optionsdemo_color"> -->
	<?php
	submit_button('Save');
	?>
</form>

