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
			$check=$check['class_administration'];
			if($check!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Class Administration - View Class</h3>
				<hr />
				<div class="menu_bar"><a href="routine.php?view">View Routine</a><a href="routine.php?set">Set Routine</a><a href="classadministration.php">Class Administration</a></div>
				<?php
				if(isset($_GET['c_id'])){
					$class_id=$_GET['c_id'];
					$sql="select * from class_detail where class_id='$class_id'";
					$sql=@mysql_query($sql);
					$res=@mysql_num_rows($sql);
					if($res==0)
						echo('No Class Found');
					else{
						$sql=@mysql_fetch_array($sql);
						$class_duration=$sql['class_duration'];
						$break_duration=$sql['break_duration'];
						$period_duration=$sql['period_duration'];
						$from_time=$sql['from_time'];
						$to_time=$sql['to_time'];
						
						$hr=0;
						$min=0;
						?>
						<table align="center" width="100%" cellpadding="1" border="0" cellspacing="0">
							<tr bgcolor="#ebf2ff"><td width="25%"><strong>Standard</strong></td><td><?php echo($sql['standard']);?></td></tr>
							<tr><td><strong>Section/Batch</strong></td><td><?php echo($sql['batch']);?></td></tr>
							<tr bgcolor="#ebf2ff"><td><strong>Total Seat Capacity</strong></td><td><?php echo($sql['seat_capacity']);?></td></tr>
							<tr><td><strong>Periods</strong></td><td><?php echo($sql['period']);?></td></tr>
							<tr bgcolor="#ebf2ff"><td><strong>Number of Intervals</strong></td><td><?php echo($sql['class_interval']);?></td></tr>
							<?php
							$hr=floor($class_duration/60);
							$min=floor($class_duration%60);
							if($min>=60){
								$hr++;
								$min-=60;
							}
							?>
							<tr><td><strong>Class Duration</strong></td><td><?php echo($hr.' hr '.$min.' mins');?></td></tr>
							<?php
							$hr=$sql['from_time'];
							$hr=floor($hr/60);
							$min=floor($sql['from_time']%60);
							?>
							<tr><td align="center">From</td><td><?php 
								if($hr<=12) echo($hr.' : '.$min.' AM'); else{$hr-=12; echo($hr.' : '.$min.' PM');}?></td></tr>
							<?php
							$hr=$sql['to_time'];
							$hr=floor($hr/60);
							$min=floor($sql['to_time']%60);
							?>
							<tr><td align="center">To</td><td><?php 
								if($hr<=12) echo($hr.' : '.$min.' AM'); else{$hr-=12; echo($hr.' : '.$min.' PM');}?></td></tr>
							<?php
							$hr=floor($period_duration/60);
							$min=floor($period_duration%60);
							if($min>=60){
								$hr++;
								$min-=60;
							}
							?>
							<tr bgcolor="#ebf2ff"><td><strong>Each Period Duration</strong></td><td><?php echo($hr.' hr '.$min.' mins');?></td></tr>
							<?php
							$hr=floor($break_duration/60);
							$min=floor($break_duration%60);
							if($min>=60){
								$hr++;
								$min-=60;
							}
							?>
							<tr><td><strong>Interval Duration</strong></td><td><?php echo($hr.' hr '.$min.' mins');?></td></tr>
							<tr><td colspan="2"><hr /></td></tr>
							<tr><td></td><td><a href="#">Modify/Edit</a></td></tr>
						</table>
						<?php
					}
				}else{
					echo('No Class Found');
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