<?php
require_once '../../config.php';

$teacher_id=$_POST['teacher_id'];
$standard=$_POST['standard'];
$sql="select subject_id from teacher_class_subject where teacher_id='$teacher_id' and standard='$standard'";
$sql=@mysql_query($sql);
$sql2="select * from subjects where standard='$standard'";
if(@mysql_num_rows($sql)){
	while($row=@mysql_fetch_array($sql)){
		$subject_id=$row['subject_id'];
		$sql2=$sql2." and subject_id!='$subject_id'";
	}
}
$sql2=@mysql_query($sql2);

if(@mysql_num_rows($sql2)){
	while($row=@mysql_fetch_array($sql2)){
		?>
		<option value="<?php echo($row['subject_id']);?>"><?php echo($row['subject_name']);?></option>
		<?php
	}
}else{
	?>
	<option><?php echo('No Subjects');?></option>
	<?php
}
?>