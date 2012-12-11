<?php 


if (!isset($height)) $height = "200px";
if (!isset($width)) $width = "200px";

$options_left = array();
$options_right = array();

// get_current_selection
$current_selection = bmssm_get($id, $post->ID );
if (!is_array($current_selection)) $current_selection = array($current_selection);

if (empty($current_selection)) $current_selection = array();

// get posts
$my_args = array(
		'post_type'=>$post_type,
		'numberposts'=>999,);
if (isset($args)) {
	$args = array_merge($my_args, $args);
} else {
	$args = $my_args;
}

$my_posts = get_posts($args);

// populate arrays
foreach($my_posts as $my_post) {
	if (!in_array($my_post->ID, $current_selection)) {
		$options_left[$my_post->ID] = $my_post->post_title;
	}
}
foreach($current_selection as $my_post_id) {
	if (is_numeric($my_post_id)) { // don't do anything if it's empty
		$my_post = get_post($my_post_id);
		$options_right[$my_post->ID] = $my_post->post_title;
	}
}
?>

<div class="bms-selectable">
    <table>
      <tr>
        <td><select multiple="multiple" class="bms-selectable-left" style="width: <?php echo $width?>; height: <?php echo $height?>">
            <?php foreach ($options_left as $opt_value=>$opt_name): ?>
                <option <?php echo $selected ?> value="<?php echo $opt_value?>"><?php echo $opt_name?></option>
            <?php endforeach ?>
          </select></td>
        <td><input type="button" value="&larr;" class="bms-selectable-rtl" />
          <input type="button" value="&rarr;" class="bms-selectable-ltr" /></td>
        <td><select multiple="multiple" class="bms-selectable-right" style="width: <?php echo $width?>; height: <?php echo $height?>"  name="<?php echo $id?>[]" id="<?php echo $id?>">
            <?php foreach ($options_right as $opt_value=>$opt_name): ?>
                <option <?php echo $selected ?> value="<?php echo $opt_value?>"><?php echo $opt_name?></option>
            <?php endforeach ?>
          </select></td>
        <td><input type="button" value="&uarr;" class="bms-selectable-up" />
          <br />
          <input type="button" value="&darr;" class="bms-selectable-down" /></td>
      </tr>
    </table>
  </div>

<?php 
// only include this once...
if (!isset($bms_selectable_inc)): 
	$bms_selectable_inc = 1; ?>
<script type="text/javascript">

jQuery(document).ready(function() {	
	
	jQuery("form#post").submit(function() { 
		jQuery('.bms-selectable-right option').attr("selected","selected");
	});
	jQuery(".bms-selectable").each(function() {
		buttons = jQuery(this).find("input");
		jQuery(buttons).click(function() {
			switch (jQuery(this).attr("class")) {
				case "bms-selectable-ltr":
					// What's the name of this div?
					var thisdiv = jQuery(this).parent().parent();
					// Get an array of items to move, and move them!
					var moveus = thisdiv.find(".bms-selectable-left option:selected")
					moveus.each(function() {
						jQuery(this).remove().appendTo(thisdiv.find(".bms-selectable-right"))
					});
					break;
				case "bms-selectable-rtl":
					// What's the name of this div?
					var thisdiv = jQuery(this).parent().parent()
					// Get an array of items to move, and move them!
					var moveus = thisdiv.find(".bms-selectable-right option:selected")
					moveus.each(function() {
						jQuery(this).remove().appendTo(thisdiv.find(".bms-selectable-left"))
					});
					break;
				case "bms-selectable-up":
					// What's the name of this div?
					var thisdiv = jQuery(this).parent().parent()
					// Get an array of selected items
					var selected = thisdiv.find(".bms-selectable-right option:selected")
					// get the previous item of the first in that list
					var prev = jQuery(selected[0]).prev();
					//alert(jQuery(prev).html());
					jQuery(selected).insertBefore(jQuery(prev));
					break;
				case "bms-selectable-down":
					// What's the name of this div?
					var thisdiv = jQuery(this).parent().parent()
					// Get an array of selected items
					var selected = thisdiv.find(".bms-selectable-right option:selected")
					// get the next item of the last in that list
					var next = jQuery(selected[selected.length-1]).next()
					jQuery(selected).insertAfter(jQuery(next));
					break;
			}
		});
	});
});
</script>
<?php endif; ?>

