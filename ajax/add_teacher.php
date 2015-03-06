<?php
require_once '../config.php';
$name=$_POST['name'];
$contact_no=$_POST['contact_no'];
$address=$_POST['address'];
$post=$_POST['designation'];
$showPass=rand(8000, 9000);
$pass=md5($showPass);
$sql="insert into user set name='$name', password='$pass', user_type='t'";
$sql=@mysql_query($sql);
$sql="select user_id from user where password='$pass' and user_type='t' and name='$name' and user_added=0";
$sql=@mysql_query($sql);
$user_id=@mysql_fetch_array($sql);
$user_id=$user_id['user_id'];
$sql="insert into teacher_detail set teacher_id='$user_id',showPass='$showPass', name='$name',password='$pass',address='$address', contact_no='$contact_no',post='$post'";
$sql=@mysql_query($sql);
echo('New Staff Added<br/>Please note down the initial password : '.$showPass);
?>