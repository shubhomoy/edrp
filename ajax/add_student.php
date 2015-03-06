<?php
require_once '../config.php';
session_start();

$name=$_POST['name'];
$reg_no=$_POST['reg_no'];
$address=$_POST['address'];
$contact_no=$_POST['contact_no'];
$pass=md5('password');

$sql="select reg_no from student_detail where reg_no='$reg_no'";
$res=@mysql_num_rows(@mysql_query($sql));
if($res==0){
	$sql="insert into user set name='$name',password='$pass',user_type='s'";
	@mysql_query($sql);
	$sql="select user_id from user where name='$name' and password='$pass' and user_type='s' and user_added=0";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	$user_id=$sql['user_id'];
	$sql="insert into student_detail set student_id='$user_id', name='$name',reg_no='$reg_no',address='$address',contact_no='$contact_no',password='$pass'";
	@mysql_query($sql);
	$sql="update user set user_added=1 where name='$name' and password='$pass' and user_id='$user_id'";
	@mysql_query($sql);	
	$_SESSION['register_student']=2;
}else{
	$_SESSION['register_student']=3;
}
?>