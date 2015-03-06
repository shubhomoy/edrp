<?php
require_once '../../config.php';

session_start();

$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];

$addr=$_POST['addr'];
$contact_no=$_POST['contact_no'];
$sql='';
if($user_type=='a'){
	$sql="update admin_detail set address='$addr', contact_no='$contact_no' where admin_id='$user_id'";
}else if($user_type=='t'){
	$sql="update teacher_detail set address='$addr', contact_no='$contact_no' where teacher_id='$user_id'";
}else if($user_type=='s'){
	$sql="update student_detail set address='$addr', contact_no='$contact_no' where student_id='$user_id'";
}
$sql=@mysql_query($sql);

if($sql>0){
	$_SESSION['notifyChanges']='Your profile has been updated';
	echo ('1');
}
?>