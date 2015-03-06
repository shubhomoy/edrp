<?php
require_once '../../function.php';
$standard=$_POST['standard'];
$class_id=$_POST['class_id'];
if($standard!=0){
	if($class_id!=0){
		echo('Upload Assignment for '.getClassDetail($class_id, 'standard').'-'.getClassDetail($class_id, 'batch'));
	}else{
		echo('Upload Assignment for '.$standard);
	}
}else{
	echo('Upload Assignment for All');
}

?>