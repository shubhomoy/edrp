<?php
require_once '../../config.php';
require_once '../../function.php';

$teacher_id=$_POST['teacher_id'];
$class_id=$_POST['class_id'];
$sql="select class_teacher from class_detail where class_teacher='$teacher_id'";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql)){
	$sql="update class_detail set class_teacher=0 where class_teacher='$teacher_id'";
	@mysql_query($sql);
}
$sql="update class_detail set class_teacher='$teacher_id' where class_id='$class_id'";
@mysql_query($sql);	
?>
<a href="#" onclick="$('#assignClassTeacherDisplay').fadeIn();"><?php echo(getClassDetail($class_id,'standard').' - '.getClassDetail($class_id, 'batch'));?></a>
