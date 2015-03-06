<?php
require_once ('../config.php');
$username=$_GET['u'];
$password=md5($_GET['p']);
$sql="select * from user where user_id='$username' and password='$password'";
$sql=@mysql_query($sql);
$res=@mysql_num_rows($sql);

if($res==0)
	echo(0);
else{
	session_start();
	$sql=@mysql_fetch_array($sql);
	$_SESSION['user_id']=$username;
	$_SESSION['user_type']=$sql['user_type'];
	
	if($sql['user_type']=='x')	//school's network admin
		echo(1);
	else if($sql['user_type']=='a'){	//school's admin
		echo(2);
	}
	else if($sql['user_type']=='t')	//school's teacher
		echo(3);
	else if($sql['user_type']=='s'){
		$sql="select class_id from student_detail where student_id='$username'";
		$sql=@mysql_fetch_array(@mysql_query($sql));
		$_SESSION['class_id']=$sql['class_id'];
		echo(4);	
	}
}
?>