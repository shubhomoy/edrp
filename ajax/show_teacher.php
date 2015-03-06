<?php
require_once '../config.php';
require_once '../function.php';
$class_id=$_POST['class_id'];
$subject_id=$_POST['subject_id'];
$standard=getClassDetail($class_id,'standard');
$period=$_POST['period'];
$periods=$_POST['periods'];
$no_of_periods=$_POST['no_of_periods'];
$prevTeacher=$_POST['prevTeacher'];

$period_duration=getPeriodDuration($class_id, $period);
$period_duration=$period_duration*$periods;

$sql="select teacher_id,name from teacher_class_subject where standard='$standard' and subject_id='$subject_id'";
$sql=@mysql_query($sql);
$res=@mysql_num_rows($sql);
if($res==0){
	echo('No Teacher Available for this Subject');
}else{
	?>
	<center><?php echo(showSubject($subject_id));?> teachers Available for Standard <?php echo($standard);?></center>
	<hr />
	<table align="center" width="100%">
	<tr><td>Teacher Name</td><td align="center">Load Remaining</td></tr>
	<?php
	while($row=@mysql_fetch_array($sql)){
		$teacher_id=$row['teacher_id'];
		$sql2="select load_hr from teacher_detail where teacher_id='$teacher_id'";
		$sql2=@mysql_fetch_array(@mysql_query($sql2));
		$load_hr=$sql2['load_hr'];
		if($period_duration<=$load_hr){
			?>
			<tr><td><a href="#" onclick="decreaseLoadHr('<?php echo($teacher_id);?>','<?php echo($period_duration);?>','<?php echo($subject_id);?>','<?php echo($no_of_periods);?>');"><?php echo($row['name']);?></a></td><td align="center"><?php echo($load_hr);?></td></tr>
			<?php
		}
	}
	?>
	<tr><td colspan="2"><hr /></td></tr>
	<tr><td colspan="2"><a href="#" onclick="unassignRoutineTeacher('<?php echo($prevTeacher);?>','<?php echo($period_duration);?>','<?php echo($subject_id);?>')">Unassign</a></td></tr>
	</table>
	<?php
}
?>