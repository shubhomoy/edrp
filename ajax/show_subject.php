<?php
require_once '../config.php';
require_once '../function.php';
$class_id=$_POST['class_id'];
$spanID=$_POST['spanID'];
$standard=getClassDetail($class_id, 'standard');
$no_of_periods=$_POST['no_of_periods'];
$sql="select subject_id,subject_name from subjects where standard='$standard'";
$sql=@mysql_query($sql);
$res=@mysql_num_rows($sql);
?>
<table align="center" width="100%">
<?php
if($res==0){
	echo('<tr><td align="center">No Subjects have been Added to Standard '.$standard.'</td></tr>');
}else{
	?>
	<tr><td align="center">Subjects Available for Standard <?php echo(getClassDetail($class_id, 'standard'));?></td></tr>
	<tr><td><hr/></td></tr>
	<?php
	while($row=@mysql_fetch_array($sql)){
		$subject=$row['subject_name'];
		?>
		<tr><td><a href="#" onclick="document.getElementById('<?php echo('span'.$spanID);?>').innerHTML='<?php echo($subject);?>';document.getElementById('<?php echo('slot'.$spanID);?>').value='<?php echo($row['subject_id']);?>'; checkRoutineSubjectAllSet('<?php echo($no_of_periods);?>');"><?php echo($row['subject_name']);?><br /></a></td></tr>
		<?php
	}
	?>
	<tr><td><hr/></td></tr>
	<tr><td><a href="#" onclick="disableBtn(); document.getElementById('<?php echo('span'.$spanID);?>').innerHTML='Add Subject';document.getElementById('<?php echo('slot'.$spanID);?>').value=0; ">Unassign<br /></a><td><tr>
	<?php	
}
?>

</table>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="ajax.js"></script>