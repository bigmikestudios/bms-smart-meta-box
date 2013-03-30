<?php

/**
 * @package BMS_Smart_Meta_Box
 * @author Mike Lathrop
 * @version 0.0.3
 */
/*
Plugin Name: BMS Smart Meta Box
Plugin URI: http://bigmikestudios.com
Description: Implements the Smart Meta Box class for other plugins
Version: 0.0.1
Author URI: http://bigmikestudios.com

THIS PLUGIN IS ONLY HERE TO MAKE THE CLASS FILE THAT INSTALLS WITH IT AVAILABLE TO OTHER PLUGINS.
*/

add_action('wp_ajax_my_action', 'my_action_callback');

// used by the "attached-images" field
function my_action_callback() {
	global $wpdb; // this is how you get access to the database

	$post_id = intval( $_POST['post_id'] );

	$args = array (
		'numberposts' => '9999',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => $post_id,
		);

	$my_attachments = get_posts($args);
	
	// now, construct an object to return to js. I need an array of objects with urls for thumbnails.
	
	$return = array();
	
	foreach ($my_attachments as $att) {
		$img = wp_get_attachment_image_src($att->ID, 'thumbnail');
		$img_src = $img[0];
		$img_w = $img[1];
		$img_h = $img[2];
		
		$return [] = array(
			'src' => $img[0],
			'img_w' => $img[1],
			'img_h' => $img[2],
			'title' => $att->post_title
		);
	}
	
	echo json_encode($return);

	die(); // this is required to return a proper result
}

add_action('admin_head', 'my_action_javascript');

function my_action_javascript() {
	global $post;
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

	function bmssm_update_attached_images() {
		var data = {
			action: 'my_action',
			post_id: <?php echo $post->ID; ?>
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
			var my_imgs = jQuery.parseJSON(response);
			var my_html = "<div style='margin: 0 -20px;'>";
			for ( var i = 0; i < my_imgs.length; i++) {
				my_html += "<div style='float:left; width: 150px; height: 175px; padding: 4px; border: 1px solid gray; margin: 20px;'>";
				my_html += "<div><img src='"+my_imgs[i].src+"' width='"+my_imgs[i].w+"' height='"+my_imgs[i].h+"' /></div>";
				my_html += "<div>"+my_imgs[i].title+"</div>";
				my_html += "</div>";		
			}
			my_html += "</div>";
			jQuery('#bmssm-attached-images').html(my_html);
		});
	}
	
	bmssm_update_attached_images();
		
	jQuery('#bmssm-attached-images-update').click( bmssm_update_attached_images );
	jQuery('body').on("click", '.media-modal-close', bmssm_update_attached_images );
	jQuery('body').on("click", '.media-modal-backdrop', bmssm_update_attached_images );
});
</script>
<?php
}

//gets the key value by key name, with or without the prefix.
function bmssm_get($key, $post_id=false) {
	$prefix = "_smartmeta_"; // same as defined in SmartMetaBox class
	// prepend prefix if it's not detected
	if ( substr($key, 0, strlen($prefix)) != $prefix ) $key = $prefix.$key;
	if (!$post_id) {
	  GLOBAL $post;
	  $post_id = $post->ID;
	}
	global $wpdb;
	$sql = "SELECT m.meta_value FROM wp_postmeta m where m.meta_key = '$key' and m.post_id = '$post_id' order by m.meta_id";
	$results = $wpdb->get_results( $sql );
	$return = array();
	foreach( $results as $result )
	{
	  $return[] = $result->meta_value;
	  // Use value here
	}
	// if there's no result, return an empty string.
	if (count($return) == 0) {
		return '';
	}
	// if there's only one result, return that value.
	if (count($return) == 1) {
		$return =  $return[0];
	}
	
	return $return;
}
   
?>