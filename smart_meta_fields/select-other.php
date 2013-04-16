<?php $add_id = $prefix.$add_id; ?>
<input type='text' value='' id='<?php echo $id; ?>' /><br/>
<input type="button" class="add-field-<?php echo $add_id?>" data-add_id="<?php echo $add_id?>" value="Add Option" />
<script>
jQuery('.add-field-<?php echo $add_id?>').click(function(e) {
    e.preventDefault();
	var my_add_select = '#'+jQuery(this).data('add_id');
	console.log (my_add_select);
	var my_val = jQuery('#<?php echo $id; ?>').val();
	console.log (my_val);
	console.log (jQuery(my_add_select).html());
	
	jQuery(my_add_select).prepend('<option selected value='+my_val+'>'+my_val+'</option>');
	// console.log(my_add_field);
	
	
});
</script>