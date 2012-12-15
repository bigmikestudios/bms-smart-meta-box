<?php 

// add link to media browser
function smart_meta_attachment_fields_to_edit($form_fields, $post) {
	
		$my_image = wp_get_attachment_image_src($post->ID, 'thumbnail');
		$my_image_tag = "<img src=\'$my_image[0]\' /><br/>";
		$form_fields["custom_field_template"]["label"] = __('Media Picker', 'smart-meta');
		$form_fields["custom_field_template"]["input"] = "html";
		$form_fields["custom_field_template"]["html"] = '
		<a href="javascript:void(0);" onclick="parent.jQuery(parent.smb_file_field).val(\''.$post->ID.'\');
		                                       parent.jQuery(parent.smb_file_label).html(\''.$my_image_tag.$post->post_title.'\'); 
											   top.tb_remove();">'.__('<p>Use this</p>', 'smart-meta').'</a>
		
		<script type="text/javascript">
			if ((parent.jQuery(parent.smb_file_field).length) < 1) {
				jQuery("tr.compat-field-custom_field_template").hide();
			}
		</script>
		';
																								
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'smart_meta_attachment_fields_to_edit', 10, 2 );

// add scripts to head
function my_admin_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
}
// add styles
function my_admin_styles() {
	wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

?>
