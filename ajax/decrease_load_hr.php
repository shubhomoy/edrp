<?php
require_once '../config.php';
require_once '../function.php';

$teacher_id=$_POST['teacher_id'];
$period_duration=$_POST['period_duration'];

$sql="update teacher_detail set load_hr=load_hr-'$period_duration' where teacher_id='$teacher_id'";
@mysql_query($sql);

$span_id=$_POST['subject_id'];
$sql="update teacher_detail set load_hr=load_hr+'$period_duration' where teacher_id='$span_id'";
@mysql_query($sql);
echo(getUserName($teacher_id));
?>