<?php
require_once '../config.php';
require_once '../function.php';

$standard=$_POST['standard'];
$sql="select class_id,batch,standard from class_detail where standard='$standard'";
$sql=@mysql_query($sql);
?>
<select id="pClassSelector">
	<option value="0">No</option>
	<?php
	while($row=@mysql_fetch_array($sql)){
		?>
		<option value="<?php echo($row['class_id']);?>"><?php echo($row['standard'].' - '.$row['batch']);?></option>
		<?php
	}
	?>
</select>