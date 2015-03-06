<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			$check=checkAdminFeature($user_id);
			if($check['routine']!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>View Routine</h3>
				<hr />
				
				<div class="menu_bar"><a href="routine.php?view">View Routine</a><a href="routine.php?set">Set Routine</a></div>
				<?php
				$class_id=$_GET['id'];
				$sql="select from_time,to_time from periods where class_id='$class_id'";
				$sql=@mysql_query($sql);
				if(@mysql_num_rows($sql)){
				$no_of_periods=@mysql_num_rows($sql);
				$j=1;
				?>
				<table align="center" width="100%" border="0" cellspacing="0" cellpadding="6">
					<tr bgcolor="#90C4DE"><td></td><?php
					//$interval=99999999;
					while($row=@mysql_fetch_array($sql)){
						
						$from_time=convertTime($row['from_time']);
						$to_time=convertTime($row['to_time']);
					//	$interval=$row['to_time'];
						
						?>
						<th align="center">Period <?php echo($j);?><br /><?php echo($from_time['hr'].':'.$from_time['min'].' - '.$to_time['hr'].':'.$to_time['min']);?></th>
						<?php
					}?></tr>
					
					<tr bgcolor="#DBCCFF"><th width="10%" align="left" bgcolor="#90C4DE">Monday</th>
						<?php
						for($i=1;$i<=$no_of_periods;$i++){
							$sql="select teacher_id,subject_id,subject_name from routine where class_id='$class_id' and period='$i' and day=1";
							$sql=@mysql_query($sql);
							while($row=@mysql_fetch_array($sql)){
								?>
									<td align="center"><b><?php echo($row['subject_name']);?></b><br /><i><?php echo(getUserName($row['teacher_id']));?></i></td>
								<?php
							}
						}
						?>
					</tr>
					<tr bgcolor="#CCD9FF"><th align="left" bgcolor="#90C4DE">Tuesday</th>
						<?php
						for($i=1;$i<=$no_of_periods;$i++){
							$sql="select teacher_id,subject_id,subject_name from routine where class_id='$class_id' and period='$i' and day=2";
							$sql=@mysql_query($sql);
							while($row=@mysql_fetch_array($sql)){
								?>
									<td align="center"><b><?php echo($row['subject_name']);?></b><br /><i><?php echo(getUserName($row['teacher_id']));?></td>
								<?php
							}
						}
						?>
					</tr>
					<tr bgcolor="#DBCCFF"><th align="left" bgcolor="#90C4DE">Wednesday</th>
						<?php
						for($i=1;$i<=$no_of_periods;$i++){
							$sql="select teacher_id,subject_id,subject_name from routine where class_id='$class_id' and period='$i' and day=3";
							$sql=@mysql_query($sql);
							while($row=@mysql_fetch_array($sql)){
								?>
									<td align="center"><b><?php echo($row['subject_name']);?></b><br /><i><?php echo(getUserName($row['teacher_id']));?></td>
								<?php
							}
						}
						?>
					</tr>
					<tr bgcolor="#CCD9FF"><th align="left" bgcolor="#90C4DE">Thursday</th>
						<?php
						for($i=1;$i<=$no_of_periods;$i++){
							$sql="select teacher_id,subject_id,subject_name from routine where class_id='$class_id' and period='$i' and day=4";
							$sql=@mysql_query($sql);
							while($row=@mysql_fetch_array($sql)){
								?>
									<td align="center"><b><?php echo($row['subject_name']);?></b><br /><i><?php echo(getUserName($row['teacher_id']));?></i></td>
								<?php
							}
						}
						?>
					</tr>
					<tr bgcolor="#DBCCFF"><th align="left" bgcolor="#90C4DE" >Friday</th>
						<?php
						for($i=1;$i<=$no_of_periods;$i++){
							$sql="select teacher_id,subject_id,subject_name from routine where class_id='$class_id' and period='$i' and day=5";
							$sql=@mysql_query($sql);
							while($row=@mysql_fetch_array($sql)){
								?>
									<td align="center"><b><?php echo($row['subject_name']);?></b><br /><i><?php echo(getUserName($row['teacher_id']));?></i></td>
								<?php
							}
						}
						?>
					</tr>
				</table>
				<?php
				}else{
					echo('Routine not set');
				}
				?>
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
	</body>
</html>