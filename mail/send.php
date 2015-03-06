<?php
require_once '../config.php';
session_start();
$user_id=$_SESSION['user_id'];
$to_id=$_POST['to_id'];
$subject=$_POST['subject'];
$msg_body=nl2br($_POST['msg_body']);

if(trim($subject)=='')
$subject="No Subject";

if(trim($msg_body)==''){
	$_SESSION['notifyChange']=1;
	header('Location:compose.php');
	die();
}
$sql="select user_id,name from user where user_id='$to_id'";
$sql=@mysql_query($sql);
if(!@mysql_num_rows($sql)){
	$_SESSION['notifyChange']=0;
	header('Location:compose.php');
}else{
	date_default_timezone_set('Asia/Calcutta');
	$date=date('Y-m-d h:i:s',time());
	$sql="insert into mail set to_id='$to_id', from_id='$user_id',subject='$subject',msg_body='$msg_body',msg_date='$date'";
	$sql=@mysql_query($sql);
	if($sql>0){
		$_SESSION['notifyChange']='Message Sent';
		header('Location:index.php');
	}
}
?>