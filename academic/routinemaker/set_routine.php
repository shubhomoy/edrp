<!DOCTYPE html>
<head>
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

	$class_id = $_POST['class_id'];
	$sql="select class_id from periods where class_id='$class_id'";
	$no_of_periods=@mysql_num_rows(@mysql_query($sql));
	?>
</head>
<body onload="checkRoutineSubjectAllSet('<?php echo($no_of_periods);?>')">
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
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>"><a href="#" onclick="showSubject('<?php echo($class_id);?>','<?php echo($id);?>','<?php echo($no_of_periods);?>');"><font color="#3C0FA6"><span id="<?php echo('span'.$id);?>"><?php if(isset($_POST['slot'.$id])) echo(showSubject($_POST['slot'.$id])); else echo('Add Subject');?></span></font></a></td>
			<input type="hidden" name="<?php echo('slot'.$id);?>" id="<?php echo('slot'.$id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
			<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Tuesday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>"><a href="#" onclick="showSubject('<?php echo($class_id);?>','<?php echo($id);?>','<?php echo($no_of_periods);?>');"><font color="#3C0FA6"><span id="<?php echo('span'.$id);?>"><?php if(isset($_POST['slot'.$id])) echo(showSubject($_POST['slot'.$id])); else echo('Add Subject');?></span></font></a></td>
			<input type="hidden" name="<?php echo('slot'.$id);?>" id="<?php echo('slot'.$id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
			<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Wednesday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>"><a href="#" onclick="showSubject('<?php echo($class_id);?>','<?php echo($id);?>','<?php echo($no_of_periods);?>');"><font color="#3C0FA6"><span id="<?php echo('span'.$id);?>"><?php if(isset($_POST['slot'.$id])) echo(showSubject($_POST['slot'.$id])); else echo('Add Subject');?></span></font></a></td>
			<input type="hidden" name="<?php echo('slot'.$id);?>" id="<?php echo('slot'.$id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
			<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Thursday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>"><a href="#" onclick="showSubject('<?php echo($class_id);?>','<?php echo($id);?>','<?php echo($no_of_periods);?>');"><font color="#3C0FA6"><span id="<?php echo('span'.$id);?>"><?php if(isset($_POST['slot'.$id])) echo(showSubject($_POST['slot'.$id])); else echo('Add Subject');?></span></font></a></td>
			<input type="hidden" name="<?php echo('slot'.$id);?>" id="<?php echo('slot'.$id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
			<?php
		}
		?>
	</tr>
	<tr bgcolor="#90C4DE"><th style="padding-top: 10px; padding-bottom: 10px; padding-left: 20px;" align="left">Friday</th>
		<?php
		for($i=1;$i<=$no_of_periods;$i++){
			$id++;
			?>
			<td align="center" bgcolor="<?php if($i%2==0)echo('#DBCCFF');else echo('#CCD9FF');?>"><a href="#" onclick="showSubject('<?php echo($class_id);?>','<?php echo($id);?>','<?php echo($no_of_periods);?>');"><font color="#3C0FA6"><span id="<?php echo('span'.$id);?>"><?php if(isset($_POST['slot'.$id])) echo(showSubject($_POST['slot'.$id])); else echo('Add Subject');?></span></font></a></td>
			<input type="hidden" name="<?php echo('slot'.$id);?>" id="<?php echo('slot'.$id);?>" value="<?php if(isset($_POST['slot'.$id])) echo($_POST['slot'.$id]); else echo('0');?>" />
			<?php
		}
		?>
	</tr>
</table>
<br />
<br />
<br />
<center><input type="submit" name="generateDetailsBtn" value="Generate Details" class="std_btn" id="generateDetailsBtn" disabled="disabled" /><br /></center>

<input type="hidden" name="class_id" value="<?php echo($class_id);?>" />

<br />
<?php
if(isset($_POST['generateDetailsBtn']) && !isset($_POST['setRoutineBtn'])){
	?>
	<div id="details">
		<table align="center" width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr bgcolor="#EFE29B"><th>Subject</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Total</th></tr>
		<?php
		$standard=getClassDetail($class_id, 'standard');
		$sql="select subject_id from subjects where standard='$standard'";
		$sql=@mysql_query($sql);
		$j=0;
		$color=0;
		while($sub=@mysql_fetch_array($sql)){
			?>
			<tr bgcolor="<?php if($color==0){echo('#DBCCFF');$color=1;}else{$color=0; echo('#CFEFFF');}?>"><td align="center"><?php echo(showSubject($sub['subject_id']));?></td>
			<?php
			$totalDuration=0;
			$duration=0;
			$j=0;
			for($day=1;$day<=5;$day++){
				$duration=0;
				for($i=1;$i<=$no_of_periods;$i++){
					$j++;
					if($_POST['slot'.$j]==$sub['subject_id']){
						$duration+=getPeriodDuration($class_id,$i);
						$totalDuration+=getPeriodDuration($class_id,$i);
					}
				}
				?>
				<td align="center"><?php if($duration==0) echo('-'); else echo($duration.' mins');?></td>
				<?php
			}
			?>
			<td align="center"><?php if($totalDuration==0) echo('-'); else echo($totalDuration.' mins');?></td></tr>
			<?php
		}
		?>
		</table>
		<center><input type="submit"  name="setSubjectBtn" id="setSubjectBtn" disabled="disabled"  value="Fill All Slots" class="std_btn"  /></center>
	</div>
	<?php
}else if(isset($_POST['setSubjectBtn'])){
	$j=0;
	for($day=1;$day<=5;$day++){
		for($i=1;$i<=$no_of_periods;$i++){
			$j++;
			$subject_id=$_POST['slot'.$j];
			$subject_name=showSubject($subject_id);
			$sql="insert into routine set class_id='$class_id', day='$day',period='$i', subject_id='$subject_id', subject_name='$subject_name'";
			@mysql_query($sql);
		}
	}
	header('Location: assign_teacher.php?class_id='.$class_id);
}

?>
</form>
<br />
<br />
</div>
<div onclick="$('#showSubjectDiv').fadeOut();" id="showSubjectDiv" style="position: absolute; top: 180px;left: 100px; right: 100px;height: auto; background: rgba(0,0,0,0.8);display: none; padding-left: 50px; padding-right: 50px; padding-top: 20px;padding-bottom: 20px; font-size: 18px;box-shadow: 0px 0px 10px rgba(0,0,0,1);">
	
</div>

<script type="text/javascript" src="../../ajax/ajax.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>

</body>
</html>
