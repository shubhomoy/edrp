<?php
require_once '../config.php';
$sub_name=preg_replace('/\s+/','-',htmlentities($_POST['sub_name']));
$standard=$_POST['standard'];
$sql="insert into subjects set subject_name='$sub_name',standard='$standard'";
@mysql_query($sql);
?>