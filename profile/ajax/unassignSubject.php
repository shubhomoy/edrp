<?php
require_once '../../config.php';

$subject_id=$_POST['subject_id'];
$teacher_id=$_POST['teacher_id'];

$sql="select class_id from routine where subject_id='$subject_id' and teacher_id='$teacher_id' limit 1";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql))
	echo(0);
else{
	$sql="delete from teacher_class_subject where teacher_id='$teacher_id' and subject_id='$subject_id'";
	@mysql_query($sql);
	echo(1);
}
?>