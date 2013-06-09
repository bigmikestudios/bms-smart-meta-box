<?php
// make an array for a table:
if (!(is_numeric($columns)) or ($columns < 1)) $columns = 1;

	$items_per_row = ceil(count($options)/$columns);
	
	$table_array = array();
	for ($i=0; $i<$items_per_row; $i++) {
		$my_table_row = array();
		for($ii=0;$ii<$columns;$ii++) {
			$my_index = $i + $items_per_row * $ii;
			$my_table_row[] = (isset($options[$my_index])) ? $options[$my_index] : NULL;
		}
		$table_array[]=$my_table_row;
	}
?>
<table width="100%"><tbody>
<?php foreach($table_array as $table_row): ?>
<tr>
<?php foreach($table_row as $opt_name):?>
<?php 
$checked ="";
if (is_array($values)) {
	if (in_array($opt_name, $values)) {
		$checked ="checked";
	}
}
if ($opt_name == $value) $checked ="checked";
?>
<td style="vertical-align:top; text-align: right;">
<?php if (trim($opt_name) != ""): ?>
<input type="checkbox" name="<?php echo $id?>[]" id="<?php echo $id?>" value="<?php echo $opt_name?>" <?php echo $checked; ?> />
<?php endif; ?>
</td>
<td style="vertical-align:top"><?php echo $opt_name ?></td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</tbody></table>