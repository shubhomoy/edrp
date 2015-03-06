<?php
require_once '../config.php';
require_once '../function.php';

$t_id=$_POST['user_id'];
date_default_timezone_set("Asia/Calcutta");
$hr=date("G");
$min=date("i");
$time=($hr*60)+$min;

$day=date("N");

$sql="select * from routine where day='$day' and teacher_id='$t_id'";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql)){
	$flag=0;
	while($row=@mysql_fetch_array($sql)){
		$class_id=$row['class_id'];
		$period=$row['period'];
		$sql2="select * from periods where class_id='$class_id' and period_no='$period'";
		$sql2=@mysql_query($sql2);
		if(@mysql_num_rows($sql2)){
			$sql2=@mysql_fetch_array($sql2);
			$from_time=$sql2['from_time'];
			if($from_time>$time){
				echo('You have a Class in '.getClassDetail($class_id,'standard').' - '.getClassDetail($class_id,'batch').
					' in '.($from_time-$time).' mins');
				$flag=1;
			}
		}
	}
	if($flag==0){
		echo('No Upcoming Schedule');
	}
}else{
	echo('You are free today');
}

?>