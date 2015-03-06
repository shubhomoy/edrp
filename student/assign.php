<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			require_once 'function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			
			$check=checkAdminFeature($user_id);
			if($check['student']!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Student - Assign</h3>
				<hr />
				<?php
				getMenu($user_id);
				
				if(isset($_GET['id']) && !empty($_GET['id'])){
					$student_id=$_GET['id'];
					$sql="select standard from student_detail where student_id='$student_id' and class_id=0";
					$sql=@mysql_query($sql);
					$sql=@mysql_fetch_array($sql);
					$standard=$sql['standard'];
					$sql="select class_id,seat_capacity,batch from class_detail where standard='$standard' and seat_capacity>0 order by standard asc";
					$sql=@mysql_query($sql);
					?>
					<table align="center" width="100%">
					<tr><td>Standard</td><td>Batch/Section</td><td>Seat Capacity</td><td></td></tr>
					<?php
					while($row=@mysql_fetch_array($sql)){
						?>
						<tr><td width="25%"><?php echo($standard);?></td><td width="25%"><?php echo($row['batch']);?></td><td width="25%"><?php echo($row['seat_capacity']);?></td><td width="25%">
						<span id="span<?php echo($row['class_id']);?>"><a href="#" onclick="assignStudent('<?php echo($student_id);?>','<?php echo($row['class_id']);?>')">Assign</a></span></td></tr>
						<?php
					}
					?>
					</table>
					<?php
					
				}else{
					echo('Invalid Student');
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
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>