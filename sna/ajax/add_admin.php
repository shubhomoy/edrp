<?php
require_once '../../config.php';
$admin_name=mysql_real_escape_string(htmlentities($_POST['admin_name']));
$admin_contact_no=mysql_real_escape_string(htmlentities($_POST['admin_contact_no']));
$admin_addr=mysql_real_escape_string(htmlentities($_POST['admin_addr']));
$post=$_POST['adminpost'];
$routine=$_POST['routine'];
$hire=$_POST['hire'];
$approve_application=$_POST['approve_application'];
$student=$_POST['student'];

if($admin_name=='')
	echo('Please Enter Administrator\'s Name');
else if($admin_contact_no=='')
	echo('Please Enter Administrator\'s Contact Number');
else if($admin_addr=='')
	echo('Please Enter Administrator\'s Address');
else if($post=='')
	echo('Please Enter Administrator\'s Designation');
else{
	session_start();
	$pass=rand(5000,8000);
	$passShow=$pass;
	$pass=md5($pass);
	$sql="insert into user set user_type='a',password='$pass',name='$admin_name'";
	@mysql_query($sql);
	$sql="select user_id from user where password='$pass' and user_type='a' and name='$admin_name' and user_added=0";
	$user_id=@mysql_fetch_array(@mysql_query($sql));
	$user_id=$user_id['user_id'];
	$sql="insert into admin_features set admin_id='$user_id',hire='$hire',routine='$routine',approve_application='$approve_application',student='$student'";
	@mysql_query($sql);
	$sql="insert into admin_detail set admin_id='$user_id',name='$admin_name',address='$admin_addr',contact_no='$admin_contact_no',post='$post',password='$pass'";
	@mysql_query($sql);
	$sql="update user set user_added=1,name='$admin_name' where user_id='$user_id' and password='$pass' and user_type='a'";
	@mysql_query($sql);
	$message="Administrator Added Successfully.<br/><i>Please Note Down the initial password : ".$passShow."<br/><a href=\"vadmin.php?id=".$user_id."\">View Details</a>";
	echo($message);	
}
?>