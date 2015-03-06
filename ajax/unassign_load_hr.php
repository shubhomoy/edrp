<?php
require_once '../config.php';
$teacher_id=$_POST['teacher_id'];
$duration=$_POST['period_duration'];
$sql="update teacher_detail set load_hr=load_hr+'$duration' where teacher_id='$teacher_id'";
@mysql_query($sql);
?>