<?php

require_once '../../config.php';
require_once '../../function.php';

$standard=$_POST['standard'];

$sql="select distinct class_id from class_detail where standard='$standard'";
$sql=@mysql_query($sql);
?>
<option value="0">All</option>
<?php
while($row=@mysql_fetch_array($sql)){
	?>
	<option value="<?php echo($row['class_id']);?>">
		<?php
		echo(getClassDetail($row['class_id'], 'standard').' - '.getClassDetail($row['class_id'], 'batch'));
		?>
	</option>
	<?php
}
?>
