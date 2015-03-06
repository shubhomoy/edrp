<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="/edrp/style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			if($user_type!='t')
				header('Location: ../error.php');
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>My Routine</h3>
				<hr />
				<?php
				//$sql="update teacher_detail set load_hr=900";
				//@mysql_query($sql);
				?>
				<?php $sql="select load_hr from teacher_detail where teacher_id='$user_id'";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				?>
				Load Remaining : <?php echo($sql['load_hr'].' mins');?>
				<table align="center" width="100%" cellspacing="0" cellpadding="3">
				<tr><th align="left">Day</th><th align="left">Time</th><th align="left">Class</th><th align="left">Subject</th></tr>
				
				<?php
				for($day=1;$day<=5;$day++){
					$load=0;
					?>
					<tr bgcolor="#B4D6E6"><td colspan="4"><?php 
						echo(showDay($day));
						?></tr>
					<?php
					$sql="select * from routine where teacher_id='$user_id' and day='$day'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)!=0){
						while($row=@mysql_fetch_array($sql)){
							?>
							<tr bgcolor="#EDEFBB"><td width="20%"></td><td width="20%"><?php 
								$class_id=$row['class_id'];
								$period=$row['period'];
								$sql2="select from_time,to_time from periods where class_id='$class_id' and period_no='$period'";
								$sql2=@mysql_query($sql2);
								$sql2=@mysql_fetch_array($sql2);
								
								$from=$sql2['from_time'];
								$to=$sql2['to_time'];
								$load+=$to-$from;
								$from=convertTime($from);
								$to=convertTime($to);
								
								echo($from['hr'].':'.$from['min'].' - '.$to['hr'].':'.$to['min']);
								?></td>
							<td width="30%"><?php echo(getClassDetail($row['class_id'], 'standard').'-'.getClassDetail($row['class_id'], 'batch'));?></td><td><?php echo($row['subject_name']);?></td></tr>
							<?php
						}
					}else{
						?>
						<tr bgcolor="#EDEFBB"><td colspan="4" align="center">No Routine</td></tr>
						<?php
					}
					?>
					<tr bgcolor="#EDEFBB"><td colspan="4" align="center">Load Consumed : <?php echo($load.' mins');?></td></tr>
					<tr><td colspan="4"><br /><br /></td></tr>
					<?php
				}
			
				?>
			</table>
				
				
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