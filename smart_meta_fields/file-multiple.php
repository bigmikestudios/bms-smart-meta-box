<?php 
global $post;
$my_post = get_post($value);
$my_title = ($my_post->ID == $post->ID) ? "" : $my_post->post_title;
$my_thumbnail = wp_get_attachment_image($my_post->ID, 'thumbnail')
?>
<input type="hidden" name="<?php echo $id?>[]" id="<?php echo $id?>" value="<?php echo $value?>" class="<?php echo $id?>" />
<div id="smb-file-label-<?php echo $id?>">
	<div><?php echo $my_thumbnail?></div>
	<div><?php echo $my_title?></div>
</div>
<input type="button" name="<?php echo $id?>-media-button[]" id="<?php echo $id?>-media-button" value="media picker" class="media-button"  rel="<?php echo $id?>" 		
	onClick="javascript: 	smb_file_field = '#<?php echo $id?>';
    						smb_file_label = '#smb-file-label-<?php echo $id?>';
							tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&show_media_picker_link=true');
                            return false;"/>

<input type="button" name="<?php echo $id?>-clear-media-button[]" id="<?php echo $id?>-clear-media-button"  value="clear" rel="<?php echo $id?>-clear" 
	onClick="javascript: 	jQuery('#smb-file-label-<?php echo $id?>').html('');
    						jQuery('#<?php echo $id?>').val('');
    						return false" />
                            
                            asdfdsaf
