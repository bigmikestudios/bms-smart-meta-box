<?php $add_id = $prefix.$add_id; ?>
<input type="button" class="add-field-<?php echo $add_id?>" data-add_id="<?php echo $add_id?>" value="Add Another Field" />
<script>
jQuery('.add-field-<?php echo $add_id?>').click(function(e) {
    e.preventDefault();
    console.log("add a new " + jQuery(this).data('add_id') + " field");
	
	var my_add_field = '.'+jQuery(this).data('add_id');
	console.log(my_add_field);
	
	var last_row = jQuery('._smartmeta_gwinv_option').last().parents('tr');
	var new_row_html = "<tr>"+last_row.html()+"</tr>";
	last_row.after(new_row_html);
	
});
</script>