<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="/edrp/style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../../config.php';
			require_once '../../function.php';
			require_once '../function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			$check=checkAdminFeature($user_id);

		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Examination - View</h3>
				<hr />
				<?php
				getMenu($user_id);

				if(isset($_GET['id']) && isset($_GET['q']) && $_GET['q']=='hy'){
					$student_id=$_GET['id'];
					$sql="select * from marks where student_id='$student_id'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<tr><td colspan="2"><b>Half Yearly Marksheet</b></td></tr>
						<tr><td width="25%">Subject</td><td>Marks</td></tr>
						<?php
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							?>
							<tr><td><?php echo(showSubject($subject_id));?></td><td><?php echo($row['half']);?></td></tr>
							<?php
						}
						?>
						</table>
						<?php
					}else{
						echo('Marks Not Updated');
					}
				}else if(isset($_GET['id']) && isset($_GET['q']) && $_GET['q']=='ann'){
					$student_id=$_GET['id'];
					$sql="select * from marks where student_id='$student_id'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<tr><td colspan="2"><b>Annual Marksheet</b></td></tr>
						<tr><td width="25%">Subject</td><td>Marks</td></tr>
						<?php
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							?>
							<tr><td><?php echo(showSubject($subject_id));?></td><td><?php echo($row['annual']);?></td></tr>
							<?php
						}
						?>
						</table>
						<?php
					}else{
						echo('Marks Not Updated');
					}
				}else if(isset($_POST['search']) || ((isset($_GET['reg_no']) && $user_type=='t'))){
					$reg_no=0;
					if(isset($_POST['reg_no']))
						$reg_no=$_POST['reg_no'];
					else if(isset($_GET['reg_no']))
						$reg_no=$_GET['reg_no'];
					$sql="select * from student_detail where reg_no='$reg_no'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<?php
						$row=@mysql_fetch_array($sql)
						?>
						<tr><td width="25%">Name</td><td><?php echo($row['name']);?></td></tr>
						<tr><td>Registration Number</td><td><?php echo($row['reg_no']);?></td></tr>
						<tr><td>Roll Number</td><td><?php echo($row['roll_no']);?></td></tr>
						<tr><td>Standard-Section</td><td><?php echo(getClassDetail($row['class_id'],'standard').' - '.getClassDetail($row['class_id'],'batch'));?></td></tr>
						<tr><td></td><td><a href="?id=<?=$row['student_id'];?>&q=hy">View Half Yearly Marksheet</a></td></tr>
						<tr><td></td><td><a href="?id=<?=$row['student_id'];?>&q=ann">View Annual Marksheet</a></td></tr>
						</table>
						<?php
					}else{
						echo('No Student Found');
					}
				}else{
					?>
					<table align="center" width="100%">
					<form action="index.php" method="post">
					<tr><td width="25%">Registration Number</td><td><input type="text" name="reg_no" /></td></tr>
					<tr><td></td><td><input type="submit" name="search" value="Search" class="std_btn"></td></tr>
					</form>
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

		
		<script type="text/javascript" src="/edrp/ajax/ajax.js"></script>
		<script type="text/javascript" src="/edrp/js/jquery.js"></script>
		<script type="text/javascript" src="../js.js"></script>
	</body>
</html>