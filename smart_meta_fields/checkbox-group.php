<?php foreach($options as $opt_value=>$opt_name): ?>
<?php 
$checked ="";
if (is_array($values)) {
	if (in_array($opt_name, $values)) {
		$checked ="checked";
	}
}
if ($opt_name == $value) $checked ="checked";
?>
	<label>
		<input type="checkbox" name="<?php echo $id?>[]" id="<?php echo $id?>" value="<?php echo $opt_name?>" <?php echo $checked; ?> />
		<?php echo $opt_name ?><br/>
	</label>
<?php endforeach ?>