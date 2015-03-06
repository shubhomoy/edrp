<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="../style.css" />
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
		.timetable_container input[type="submit"] {
			font-size: 10px;
		}

	</style>
	<?php
	session_start();
	require_once '../config.php';
	require_once '../function.php';

	$user_id = $_SESSION['user_id'];
	$user_type = $_SESSION['user_type'];
	
	$check = checkAdminFeature($user_id);
	if ($check['routine'] != 1) {
		header('Location: ../index.php');
	}
	?>
</head>
<body>
	<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
	<div class="timetable_container">
		<?php
		if (isset($_GET['id']))
			$class_id = $_GET['id'];
		else {
			$class_id = $_POST['class_id'];
		}
		
		$sql="select class_id from routine where class_id='$class_id' LIMIT 1";
		$sql=@mysql_query($sql);
		$res=@mysql_num_rows($sql);
		if($res!=0){
			header('Location: routinemaker/assign_teacher.php?class_id='.$class_id);
		}
		?>
		<div style="position: absolute;top: 0px;left: 0px;right: 0px; background: rgb(200,200,255);font-size: 20px;">
			<center>
				Routine Creator
			</center>
		</div>
		<?php
		$sql = "select standard,batch from class_detail where class_id='$class_id'";
		$sql = @mysql_fetch_array(@mysql_query($sql));
		?>
		<center>
			<font size="3">Set Routine for <?php echo($sql['standard'] . ' - ' . $sql['batch']); ?></font>
		</center>
		<hr />
		<?php
		$sql="select class_id from routine where class_id='$class_id' limit=1";
		$sql=@mysql_num_rows(@mysql_query($sql));
		if($sql==0){
		// routine have not been set
		if(!isset($_POST['next1']) && !isset($_POST['next2']) && !isset($_POST['next3'])){
			?>
			<table align="center" style="width: auto;" cellspacing="0" cellpadding="3">
			<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
			<input type="hidden" name="class_id" value="<?php echo($class_id); ?>" />
			<tr>
			<td>Number of Periods</td><td>
			<input type="text" id="period" name="no_of_period" maxlength="2" onkeyup="check_num();" />
			</td>
			</tr>
			<tr>
			<td></td><td>
			<input type="submit" name="next1" value="Next" class="std_btn" />
			</td>
			</tr>
			</form>
			</table>
			<hr />
			<?php
		}else if(isset($_POST['next1'])){
			if(trim($_POST['no_of_period'])==''){
				?>
				Please fill up correct number of Periods
				<br />
				<a href="?id=<?=$class_id; ?>">Go Back</a>
				<?php
			}else{
				?>
				<table align="center" width="70%">
				<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<input type="hidden" name="class_id" value="<?php echo($class_id); ?>" />
				<?php
				$no_of_periods=$_POST['no_of_period'];
				for($i=1;$i<=$_POST['no_of_period'];$i++){
					?>
					<tr>
					<td colspan="3">Period <?php echo($i); ?> Duration</td>
					</tr>
					<tr>
					<td width="10%"></td><td>From</td><td>
					<select name="<?php echo('period' . $i . 'from_hr'); ?>" >
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
					<option value="5">05</option>
					<option value="6">06</option>
					<option value="7">07</option>
					<option value="8">08</option>
					<option value="9">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					</select> :
					<select name="<?php echo('period' . $i . 'from_min'); ?>">
					<?php
					for($j=0;$j<=59;$j++){
						if($j>=0 && $j<=9){
							?>
							<option value="<?php echo($j); ?>">0<?php echo($j); ?></option>
							<?php
						}else{
							?><option><?php echo($j); ?></option>
							<?php 
						}
					} ?>
					</select>
					<select name="<?php echo('period' . $i . 'from_am_pm'); ?>">
					<option value="am">AM</option><option value="pm">PM</option>
					</select></td>
					</tr>
					<tr>
					<td></td><td>To</td><td>
					<select name="<?php echo('period' . $i . 'to_hr'); ?>" >
					<option value="1">01</option>
					<option value="2">02</option>
					<option value="3">03</option>
					<option value="4">04</option>
					<option value="5">05</option>
					<option value="6">06</option>
					<option value="7">07</option>
					<option value="8">08</option>
					<option value="9">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
					</select> :
					<select name="<?php echo('period' . $i . 'to_min'); ?>">
					<?php
					for($j=0;$j<=59;$j++){
						if($j>=0 && $j<=9){
							?>
							<option value="<?php echo($j); ?>">0<?php echo($j); ?></option>
							<?php
						}else{
							?><option><?php echo($j); ?></option>
							<?php 
						}
					} ?>
					</select>
					<select name="<?php echo('period' . $i . 'to_am_pm'); ?>">
					<option value="am">AM</option><option value="pm">PM</option>
					</select></td>
					</tr>
					<tr>
					<td colspan="3">
					<hr />
					</td>
					</tr>
					<?php
				}
				?>
				<input type="hidden" name="no_of_periods" value="<?php echo($no_of_periods); ?>" />
				<tr>
				<td></td><td></td><td>
				<input type="submit" name="next2"  value="Next" class="std_btn"  />
				</td>
				</tr>
				</form>
				</table>
				<?php
			}
		}else if(isset($_POST['next2'])){
			//period check\
			$no_of_intervals=0;
			$error=0;
			$no_of_periods=$_POST['no_of_periods'];
			$class_id=$_POST['class_id'];
			for($i=1;$i<$no_of_periods;$i++){
				$to=getMinutes($_POST['period'.$i.'to_hr'], $_POST['period'.$i.'to_min'], $_POST['period'.$i.'to_am_pm']);
				$from=getMinutes($_POST['period'.$i.'from_hr'], $_POST['period'.$i.'from_min'], $_POST['period'.$i.'from_am_pm']);
				if($to<=$from){
					echo('Invalid');
					$error++;
					break;
				}
				$to=getMinutes($_POST['period'.$i.'to_hr'], $_POST['period'.$i.'to_min'], $_POST['period'.$i.'to_am_pm']);
				$from=getMinutes($_POST['period'.($i+1).'from_hr'], $_POST['period'.($i+1).'from_min'], $_POST['period'.($i+1).'from_am_pm']);
				if($from<$to){
					echo('Invalid'.' '.$i);
					$error++;
					break;
				}
			}
			if($error==0){
				?>
				<form action="<?=$_SERVER['PHP_SELF']; ?>" method="post">
				<table align="center" width="100%" border="0" cellpadding="2" cellspacing="0">
				<input type="hidden" name="class_id" value="<?php echo($class_id); ?>" />
				<input type="hidden" name="no_of_periods" value="<?php echo($no_of_periods); ?>" />
				<tr>
				<?php
				for($i=1; $i<=$no_of_periods; $i++){
					$from=convertTime(getMinutes($_POST['period'.$i.'from_hr'], $_POST['period'.$i.'from_min'], $_POST['period'.$i.'from_am_pm']));
					$to=convertTime(getMinutes($_POST['period'.$i.'to_hr'], $_POST['period'.$i.'to_min'], $_POST['period'.$i.'to_am_pm']));
					?>
					<input type="hidden" name="<?php echo('period' . $i . 'from'); ?>" value="<?php echo(getMinutes($_POST['period' . $i . 'from_hr'], $_POST['period' . $i . 'from_min'], $_POST['period' . $i . 'from_am_pm'])); ?>" />
					<input type="hidden" name="<?php echo('period' . $i . 'to'); ?>" value="<?php echo(getMinutes($_POST['period' . $i . 'to_hr'], $_POST['period' . $i . 'to_min'], $_POST['period' . $i . 'to_am_pm'])); ?>" />
					<?php
					if($i!=$no_of_periods){
						$from2=getMinutes($_POST['period'.($i+1).'from_hr'], $_POST['period'.($i+1).'from_min'], $_POST['period'.($i+1).'from_am_pm']);
						$to2=getMinutes($_POST['period'.$i.'to_hr'], $_POST['period'.$i.'to_min'], $_POST['period'.$i.'to_am_pm']);
						?>
						<td align="center" bgcolor="<?php if($i%2==0)echo('#CCDAFF');else echo('#DBCCFF')?>">Period <?php echo($i); ?><br /><?php echo($from['hr'] . ':' . $from['min'] . ' - ' . $to['hr'] . ':' . $to['min']); ?></td>
						<?php
						if(($from2-$to2)!=0){
							$no_of_intervals++;
							?>
							<td align="center" bgcolor="#66FF90">Interval <br /><?php echo(($from2 - $to2) . 'mins'); ?></td>
							<?php
						}
					}
					if($i==$no_of_periods){
						?>
						<td align="center" bgcolor="<?php if($i%2==0)echo('#CCDAFF');else echo('#DBCCFF')?>">Period <?php echo($i); ?><br /><?php echo($from['hr'] . ':' . $from['min'] . ' - ' . $to['hr'] . ':' . $to['min']); ?></td>
						<?php
					}
				}
				?></tr></table>
				<center><input type="submit" name="next3" value="Set Periods" class="std_btn" /></center>
				</form><?php
			}
		}else if(isset($_POST['next3'])){
			$class_id=$_POST['class_id'];
			$no_of_periods=$_POST['no_of_periods'];
			for($i=1;$i<=$no_of_periods;$i++){
				$from=$_POST['period'.$i.'from'];
				$to=$_POST['period'.$i.'to'];
				$sql="insert into periods set class_id='$class_id', period_no='$i', from_time='$from', to_time='$to'";
				@mysql_query($sql);
			}
			echo('Periods for '.getClassDetail($class_id, 'standard').' - '.getClassDetail($class_id, 'batch').' have been set');
			?>
			<form action="routinemaker/set_routine.php" method="post">
			<input type="hidden" name="class_id" value="<?php echo($class_id);?>" />
			<center><input type="submit" name="next4" value="Proceed to Routine Creator" class="std_btn" /></center>
			</form>
			<?php
		}else{
			
		}
		}
		?>
		<br />
		<br />
		<br />
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript">
			function check_num() {
				input = document.getElementById('period').value;
				if (!(input >= 0) && !(input <= 9))
					document.getElementById('period').value = '';
			}
		</script>
</body>
</html>
