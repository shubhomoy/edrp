<!DOCTYPE html>
<head>
	<meta http-equiv="x-ua-compatible" content="IE=9" >
	<link rel="stylesheet" href="../../style.css" />
	<title>EdRP</title>
	<style>
		.timetable_container {
			position: absolute;
			left: 30px;
			right: 30px;
			top: 100px;
			padding-left: 10px;
			padding-right: 10px;
			padding-top: 40px;
			height: auto;
			min-width: 800px;
			color: rgb(0,0,0);
			font-size: 15px;
			background: rgba(255,255,255,1);
		}
		.timetable_container select {
			font-size: 13px;
		}
		

	</style>
	<?php
	session_start();
	require_once '../../config.php';
	require_once '../../function.php';

	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	
	$check = checkAdminFeature($user_id);
	if ($check['routine'] != 1) {
		header('Location: ../../index.php');
	}
	$class_id=0;
	if(isset($_GET['class_id'])){
		$class_id=$_GET['class_id'];
	}else if(isset($_POST['class_id'])){
		$class_id=$_POST['class_id'];
	}
	$sql="select class_id from periods where class_id='$class_id'";
	$no_of_periods=@mysql_num_rows(@mysql_query($sql));
	?>
</head>
<body>
EdRP <font size="4">- <?php echo(get_ins_name()); ?></font>
<div class="timetable_container">

<div style="position: absolute;top: 0px;left: 0px;right: 0px; background: rgb(200,200,255);font-size: 20px;">
<center>
Routine Creator
</center>
</div>
<center>
<font size="3">Set Routine for <?php echo(getClassDetail($class_id, 'standard').' - '.getClassDetail($class_id, 'batch')); ?></font>
</center>
<hr />
<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	
<table align="center" width="100%" border="0" cellspacing="1">
	<tr><td width="10%"></td>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			?>
			<th align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">Period <?php echo($i);?><br />
				<?php
				$sql="select from_time,to_time from periods where class_id='$class_id' and period_no='$i'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				$from=$sql['from_time'];
				$to=$sql['to_time'];
				$time=convertTime($from);
				echo($time['hr'].':'.$time['min']);
				$time=convertTime($to);
				echo(' - '.$time['hr'].':'.$time['min']);
				?>
			</th>
			<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Monday</th>
		<?php
		$id=0;
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">
				<?php
				$sql="select subject_id, subject_name from routine where day=1 and period='$i' and class_id='$class_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				echo($sql['subject_name'].'<br/>');
				$subject_id=$sql['subject_id'];
				?>
				<a href="#" onclick="showRoutineTeacher('<?php echo($class_id);?>','<?php echo($sql['subject_id']);?>','<?php echo($i);?>','<?php echo($no_of_periods);?>');" ><font color="#3C0FA6"><span class="<?php echo('span'.$subject_id);?>">
				<?php if(isset($_POST['slot'.$id])) echo(getUserName($_POST['slot'.$id])); else echo('Assign Teacher');?>
				</span></font></a></td>
				<input type="hidden"  id="<?php echo('slot'.$id);?>" name="<?php echo('slot'.$id);?>" class="<?php echo('slot'.$subject_id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
				<input type="hidden" name="<?php echo('subject'.$id);?>" value="<?php echo($subject_id);?>" />
				<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Tuesday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">
				<?php
				$sql="select subject_id, subject_name from routine where day=2 and period='$i' and class_id='$class_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				echo($sql['subject_name'].'<br/>');
				$subject_id=$sql['subject_id'];
				?>
				<a href="#" onclick="showRoutineTeacher('<?php echo($class_id);?>','<?php echo($sql['subject_id']);?>','<?php echo($i);?>','<?php echo($no_of_periods);?>');" ><font color="#3C0FA6"><span class="<?php echo('span'.$subject_id);?>">
				<?php if(isset($_POST['slot'.$id])) echo(getUserName($_POST['slot'.$id])); else echo('Assign Teacher');?>
				</span></font></a></td>
				<input type="hidden"  id="<?php echo('slot'.$id);?>" name="<?php echo('slot'.$id);?>" class="<?php echo('slot'.$subject_id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
				<input type="hidden" name="<?php echo('subject'.$id);?>" value="<?php echo($subject_id);?>" />
				<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Wednesday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">
				<?php
				$sql="select subject_id, subject_name from routine where day=3 and period='$i' and class_id='$class_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				echo($sql['subject_name'].'<br/>');
				$subject_id=$sql['subject_id'];
				?>
				<a href="#" onclick="showRoutineTeacher('<?php echo($class_id);?>','<?php echo($sql['subject_id']);?>','<?php echo($i);?>','<?php echo($no_of_periods);?>');" ><font color="#3C0FA6"><span class="<?php echo('span'.$subject_id);?>">
				<?php if(isset($_POST['slot'.$id])) echo(getUserName($_POST['slot'.$id])); else echo('Assign Teacher');?>
				</span></font></a></td>
				<input type="hidden"  id="<?php echo('slot'.$id);?>" name="<?php echo('slot'.$id);?>" class="<?php echo('slot'.$subject_id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
				<input type="hidden" name="<?php echo('subject'.$id);?>" value="<?php echo($subject_id);?>" />
				<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Thursday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">
				<?php
				$sql="select subject_id, subject_name from routine where day=4 and period='$i' and class_id='$class_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				echo($sql['subject_name'].'<br/>');
				$subject_id=$sql['subject_id'];
				?>
				<a href="#" onclick="showRoutineTeacher('<?php echo($class_id);?>','<?php echo($sql['subject_id']);?>','<?php echo($i);?>','<?php echo($no_of_periods);?>');" ><font color="#3C0FA6"><span class="<?php echo('span'.$subject_id);?>">
				<?php if(isset($_POST['slot'.$id])) echo(getUserName($_POST['slot'.$id])); else echo('Assign Teacher');?>
				</span></font></a></td>
				<input type="hidden"  id="<?php echo('slot'.$id);?>" name="<?php echo('slot'.$id);?>" class="<?php echo('slot'.$subject_id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
				<input type="hidden" name="<?php echo('subject'.$id);?>" value="<?php echo($subject_id);?>" />
				<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Friday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>">
				<?php
				$sql="select subject_id, subject_name from routine where day=5 and period='$i' and class_id='$class_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				echo($sql['subject_name'].'<br/>');
				$subject_id=$sql['subject_id'];
				?>
				<a href="#" onclick="showRoutineTeacher('<?php echo($class_id);?>','<?php echo($sql['subject_id']);?>','<?php echo($i);?>','<?php echo($no_of_periods);?>');" ><font color="#3C0FA6"><span class="<?php echo('span'.$subject_id);?>">
				<?php if(isset($_POST['slot'.$id])) echo(getUserName($_POST['slot'.$id])); else echo('Assign Teacher');?>
				</span></font></a></td>
				<input type="hidden"  id="<?php echo('slot'.$id);?>" name="<?php echo('slot'.$id);?>" class="<?php echo('slot'.$subject_id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
				<input type="hidden" name="<?php echo('subject'.$id);?>" value="<?php echo($subject_id);?>" />
				<?php
		}
		?>
	</tr>
</table>
<br />
<br />

<center><input type="submit" name="generateDetailsBtn" id="generateDetailsBtn" disabled="disabled" class="std_btn" value="Generate Details" /></center>
<input type="hidden" name="class_id" value="<?php echo($class_id);?>" />

<br />

<br />
<br />
<?php
 if(isset($_POST['generateDetailsBtn'])){
	?>
	<div>
	<table align="center" width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr bgcolor="#EFE29B"><th align="left" width="20%">Subject</th><th align="center">Teacher</th><th align="center">Load hour Consumed</th><th align="center">Load hour Left</th></tr>
		<?php
		$standard=getClassDetail($class_id,'standard');
		$sql="select subject_id from subjects where standard='$standard'";
		$sql=@mysql_query($sql);
		$color=0;
		while($subject=@mysql_fetch_array($sql)){
			$subject_id=$subject['subject_id'];
			$j=0;
			$loadCurrent=0;
			$teacher_id=0;
			for($day=1;$day<=5;$day++){
				for($i=1;$i<=$no_of_periods;$i++){
					$j++;
					if($_POST['subject'.$j]==$subject_id){
						$teacher_id=$_POST['slot'.$j];
						$loadCurrent+=getPeriodDuration($class_id, $i);
					}
				}
			}
			$sql2="select load_hr from teacher_detail where teacher_id='$teacher_id'";
			$sql2=@mysql_fetch_array(@mysql_query($sql2));
			?>
			<tr bgcolor="<?php if($color==0){echo('#DBCCFF');$color=1;}else{$color=0; echo('#CFEFFF');}?>"><td><?php echo(showSubject($subject_id));?></td><td align="center"><?php if($teacher_id==0)echo('-'); else echo(getUserName($teacher_id));?></td><td align="center"><?php if($loadCurrent==0) echo('-'); else echo($loadCurrent.' mins');?></td><td align="center"><?php if($sql2['load_hr']!='') echo($sql2['load_hr'].' mins');?></td></tr>
			<?php
		}
		?>
	</table>
	<br />
	<center><input type="submit" name="assignTeacherBtn" class="std_btn" value="Confirm and Assign Teacher" /></center>
	<br /><br />
	</div>
	<?php
}else if(isset($_POST['assignTeacherBtn'])){
	$class_id=$_POST['class_id'];
	$standard=getClassDetail($class_id,'standard');
	$sql="select subject_id from subjects where standard='$standard'";
	$sql=@mysql_query($sql);
	while($subject=@mysql_fetch_array($sql)){
		$subject_id=$subject['subject_id'];
		$j=0;
		$teacher_id=0;
		for($day=1;$day<=5;$day++){
			for($i=1;$i<=$no_of_periods;$i++){
				$j++;
				if($_POST['subject'.$j]==$subject_id){
					$teacher_id=$_POST['slot'.$j];
					$sql2="update routine set teacher_id='$teacher_id' where class_id='$class_id' and day='$day' and period='$i' and subject_id='$subject_id'";
					@mysql_query($sql2);
				}
			}
		}
	}
	header('Location:../routine.php');
}
?>
</form>
</div>
<div onclick="$('#showTeacherDiv').fadeOut();" id="showTeacherDiv" style="position: absolute; top: 180px;left: 100px; right: 100px;height: auto; background: rgba(0,0,0,0.8);display: none; padding-left: 50px; padding-right: 50px; padding-top: 20px;padding-bottom: 20px; font-size: 18px;box-shadow: 0px 0px 10px rgba(0,0,0,1);">
	
</div>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>

</body>
</html>
