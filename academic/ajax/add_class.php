<?php
require_once '../../config.php';
session_start();
$standard=$_POST['standard_add'];
$section=$_POST['section_add'];
$seat=$_POST['seat_capacity_add'];
$class_duration=floor($_POST['class_duration_add']);
$from=$_POST['from_add'];
$to=$_POST['to_add'];

$sql="select class_id from class_detail where standard='$standard' and batch='$section'";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql)!=0)
	$_SESSION['notifyChanges']='Class already exists';
else{
	$sql="insert into class_detail set standard='$standard',batch='$section',seat_capacity='$seat',class_duration='$class_duration',from_time='$from',to_time='$to'";
	@mysql_query($sql);
	$_SESSION['notifyChanges']='A new Class has been added';
}
header('Location: ../../academic/classadministration.php');

?>