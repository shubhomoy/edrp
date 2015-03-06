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
			
			if($user_type=='s'){
				header('Location: ../index.php');
			}
			$check=checkAdminFeature($user_id);
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Student</h3>
				<hr />
				<?php
				getMenu($user_id);
				?>
				
				<?php
				if(!isset($_GET['view']) && !isset($_GET['unassigned'])){
					?>
					<a href="view.php">View All</a><br />
					<?php
					if($check['student']==1){
						$sql="select student_id from student_detail where class_id=0";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							?><a href="?unassigned">Unassigned Students</a><?php
						}
					}
				}else if(isset($_GET['unassigned']) && $check['student']==1){
					$sql="select student_id,reg_no,standard,name from student_detail where class_id=0";
					$sql=@mysql_query($sql);
					?>
					<table align="center" width="100%">
					<tr><td width="10%">Student ID</td><td width="20%">Registration Number</td><td>Name</td><td width="10%">Standard</td><td width="10%"></td></tr>
					<?php
					while($row=@mysql_fetch_array($sql)){
						?>
						<tr><td><?php echo($row['student_id']);?></td>
						<td><?php echo($row['reg_no']);?></td>
						<td><?php echo($row['name']);?></td>
						<td><?php echo($row['standard']);?></td>
						<td><a href="assign.php?id=<?=$row['student_id'];?>">Assign Class</a></td>
						</tr>
						<?php
					}
					?>
					</table>
					<?php
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