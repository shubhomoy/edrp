<?php
$class_id=$_POST['class_id'];
$no_of_periods=$_POST['no_of_periods'];
echo('d');
$flag=1;
for($i=1;$i=($no_of_periods*5);$i++){
	if(!isset($_POST['slot'.$i]) || $_POST['slot'.$i]==0){
		$flag=0;
		break;
	}
}
if($flag==1)
	echo('All Subjects Set');
else {
	echo('Some Fields are empty');
}

?>