<?php
require_once '../config.php';
require_once '../function.php';

$day=$_POST['day'];
$to=$_POST['to'];
$from=$_POST['from'];
$span_id=$_POST['span_id'];
$hidden_id=$_POST['hidden_id'];
$period=$_POST['period'];
$class_id=$_POST['class_id'];
?>
<a href="#" onclick="document.getElementById('<?php echo($span_id);?>').innerHTML='Add';document.getElementById('<?php echo($hidden_id);?>').value=0;insertTeacher('<?php echo($class_id);?>','<?php echo($period);?>','<?php echo($day);?>','<?php echo($hidden_id);?>','<?php echo($span_id);?>','Add','0');">Unassign</a><br />
<?php
$sql="select distinct teacher_id from teacher_class_subject";
$sql=@mysql_query($sql);
while($teacher_id=@mysql_fetch_array($sql)){
	$id=$teacher_id['teacher_id'];
	$sql2="select teacher_id from routine where teacher_id='$id' and day='$day' and ( (from_time>='$from' and from_time <'$to' and to_time>='$to') or (from_time>='$from' and to_time <= '$to') or (from_time<='$from' and to_time >= '$to') or (to_time>'$from' and to_time<='$to') )";
	$sql2=@mysql_query($sql2);
	$res=@mysql_num_rows($sql2);
	if($res==0){
		?>
		<a href="#" onclick="insertTeacher('<?php echo($class_id);?>','<?php echo($period);?>','<?php echo($day);?>','<?php echo($hidden_id);?>','<?php echo($span_id);?>','<?php echo(getUserName($id));?>','<?php echo($id);?>')"><?php echo(getUserName($id));?></a><br />
		<?php
	}
}
?>
<script type="text/javascript" src="../ajax/ajax.js"></script>