<?php
require_once '../../config.php';
$standard=$_POST['standard'];
$section=$_POST['section'];
$seat=$_POST['seat'];
$from_hr=$_POST['from_hr'];
$from_min=$_POST['from_min'];
$from_am_pm=$_POST['from_am_pm'];


$to_hr=$_POST['to_hr'];
$to_min=$_POST['to_min'];
$to_am_pm=$_POST['to_am_pm'];


if(trim($section)==''){
	echo('Enter Section');
	return false;
}

if($seat==''){
	echo('Enter Total Seating Capacity');
	return false;
}


$from=0;
$to=0;

if($from_am_pm=='PM'){
	$from_hr+=12;
}
if($to_am_pm=='PM'){
	$to_hr+=12;
}
$from=($from_hr*60)+$from_min;
$to=($to_hr*60)+$to_min;

$total_class_duration=$to-$from;
if($total_class_duration<=0){
	echo('Invalid Class Duration');
	return false;	
}


$diff_hr=floor($total_class_duration/60);
$diff_min=$total_class_duration%60;



$section=strtoupper($section);
?>
<table align="center" width="100%">
	<form action="../academic/ajax/add_class.php" method="post">
	<input type="hidden" name="standard_add" value="<?php echo($standard);?>" />
	<input type="hidden" name="section_add" value="<?php echo($section);?>" />
	<input type="hidden" name="seat_capacity_add" value="<?php echo($seat);?>" />
	<input type="hidden" name="class_duration_add" value="<?php echo($total_class_duration);?>" />
	<input type="hidden" name="from_add" value="<?php echo($from);?>" />
	<input type="hidden" name="to_add" value="<?php echo($to);?>" />
	<tr><td colspan="2" align="left"><strong>New Class Review</strong></td></tr>
	<tr><td colspan="2"><hr /></td></tr>
	<tr><td width="25%"><strong>Class</strong></td><td><?php echo($standard.' - '.$section);?></td></tr>
	<tr><td width="25%"><strong>Seating Capacity</strong></td><td><?php echo($seat);?></td></tr>
	<tr><td width="25%"><strong>School Duration</strong></td><td><?php echo($diff_hr.' hrs '.$diff_min.' mins<br/>');?></td></tr>
	<tr><td colspan="2"><hr /></td></tr>
	<tr><td></td><td><input type="submit" name="addClass" class="std_btn" value="Add Class" /></td></tr>
	</form>
</table>