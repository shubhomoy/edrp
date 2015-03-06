<?php

require_once '../../config.php';

$ass_id=$_POST['ass_id'];
$sql="select standard,class_id,file_name from assignment where assignment_id='$ass_id'";
$sql=@mysql_query($sql);
$sql=@mysql_fetch_array($sql);

$class_id=$sql['class_id'];
$standard=$sql['standard'];
$file_name=$sql['file_name'];

if($standard!=0){
	if($class_id!=0){
		// assigneemnt for particular class
		unlink('../../upload/class_id-'.$class_id.'/'.$file_name);
	}
	// assignment for particular standard
	unlink('../../upload/'.$standard.'/'.$file_name);
}else{
	// assignment for all
	unlink('../../upload/all/'.$file_name);
}
$sql="delete from assignment where assignment_id='$ass_id'";
@mysql_query($sql);

?>