<?php
require_once '../../config.php';
require_once '../../function.php';

$teacher_id=$_POST['teacher_id'];

$sql="update class_detail set class_teacher=0 where class_teacher='$teacher_id'";
@mysql_query($sql);	
?>