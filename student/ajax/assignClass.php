<?php
require_once '../../config.php';
$student_id=$_POST['student_id'];
$class_id=$_POST['class_id'];
$sql="select class_id from student_detail where student_id='$student_id'";
$sql=@mysql_fetch_array(@mysql_query($sql));
if($sql['class_id']==0){
	$sql="update student_detail set class_id='$class_id' where student_id='$student_id'";
	$sql=@mysql_query($sql);
	$sql="update class_detail set seat_capacity=seat_capacity-1 where class_id='$class_id'";
	$sql=@mysql_query($sql);
	if($sql>0)
		echo('1');
	else {
		echo('Something went Wrong');
	}
}else{
	echo('Already assigned to a Class');
}
?>