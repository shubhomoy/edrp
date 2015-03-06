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
			
			if ($user_type=='s') {
				# code...
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
				
				if(isset($_POST['submit'])){
					if($user_type=='a'){
						if(isset($_POST['reg_no']) && !empty($_POST['reg_no'])){
							$reg_no=$_POST['reg_no'];
							$sql="select * from student_detail where reg_no='$reg_no'";
							$sql=@mysql_query($sql);
							$sql=@mysql_fetch_array($sql);
							header('Location:view2.php?rno='.$sql['reg_no']);
						}else if((!empty($_POST['sectionSelector']) || !empty($_POST['standardSelector'])) && empty($_POST['reg_no'])){
							$standard=$_POST['standardSelector'];
							$section=$_POST['sectionSelector'];
							if($standard!=0){
								if($section!=0){
									$sql="select reg_no,name,class_id from student_detail where class_id='$section' order by standard asc";
									$sql=@mysql_query($sql);
									if(@mysql_num_rows($sql)){
										?>
										<table align="center" width="100%">
										<tr><td width="25%">Registration Number</td><td>Name</td><td width="20%" align="center">Standard - Section</td></tr>
										<?php
										while($row=@mysql_fetch_array($sql)){
											?>
											<tr><td><a href="view2.php?rno=<?=$row['reg_no'];?>"><?php echo($row['reg_no']);?></a></td>
											<td><?php echo($row['name']);?></td><td align="center"><?php echo(getClassDetail($row['class_id'], 'standard').' - '.getClassDetail($row['class_id'], 'batch'));?></td></tr>
											<?php
										}
										?>
										</table>
										<?php
									}else{
										echo('No Students Found');
									}
								}else{
									$sql="select reg_no,name,class_id from student_detail where standard='$standard' order by standard asc";
									$sql=@mysql_query($sql);
									if(@mysql_num_rows($sql)){
										?>
										<table align="center" width="100%">
										<tr><td width="25%">Registration Number</td><td>Name</td><td width="20%" align="center">Standard - Section</td></tr>
										<?php
										while($row=@mysql_fetch_array($sql)){
											?>
											<tr><td><a href="view2.php?rno=<?=$row['reg_no'];?>"><?php echo($row['reg_no']);?></a></td>
											<td><?php echo($row['name']);?></td><td align="center"><?php echo(getClassDetail($row['class_id'], 'standard').' - '.getClassDetail($row['class_id'], 'batch'));?></td></tr>
											<?php
										}
										?>
										</table>
										<?php
									}else{
										echo('No Students Found');
									}
								}
							}
						}
					}else if($user_type=='t'){

					}
				}
				
				if($user_type=='a' && !isset($_POST['submit']) && !isset($_GET['view'])){
					?>
					<table align="center" width="100%">
					<form action="view.php" method="post">
					<tr><td width="25%">Registration Number</td><td><input type="text" name="reg_no" /></td></tr>
					<tr><td></td><td>or</td></tr>
					<tr><td>Sort by Standard</td><td><select id="standardSelector" onchange="displaySection()" name="standardSelector">
					<option value="0">Choose</option>
					<?php
					$sql="select distinct standard from class_detail order by standard asc";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							?>
							<option value="<?php echo($row['standard']);?>"><?php echo($row['standard']);?></option>
							<?php
						}
					}else{
						?>
						<option value="0">No Stanadard Created</option>
						<?php
					}
					?>
					</select></td></tr>
					<tr style="display: none" id="section"><td>Sort by Batch</td><td><select id="sectionSelector" name="sectionSelector"></select></td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="Search" class="std_btn" /></td></tr>
					</form>
					</table>
					<?php
				}else if($user_type=='t' && !isset($_POST['submit']) && !isset($_GET['view'])){
					?>
					<table align="center" width="100%">
					<tr><td width="25%">Registration Number</td><td><input type="text" name="reg_no" /></td></tr>
					<tr><td></td><td>or</td></tr>
					<tr><td></td><td><a href="?view">View All</a></td></tr>
					<tr><td></td><td><input type="submit" name="submit" value="Search" class="std_btn"></td></tr>
					</table>
					<?php
				}else if($user_type=='t' && !isset($_POST['submit']) && isset($_GET['view'])){
					$class_id=getClassOfClassTeacher($user_id);
					if($class_id!=0){
						$sql="select student_id, name,reg_no from student_detail where class_id='$class_id'";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							?>
							<table align="center" width="100%">
							<tr><td>Registration Number</td><td>Name</td></tr>
							<?php
							while ($row=@mysql_fetch_array($sql)) {
								# code...
								?>
								<tr><td width="25%"><?php echo($row['reg_no']);?></td><td>
								<a href="view2.php?rno=<?=$row['reg_no'];?>"><?php echo($row['name']);?></a>
								</td></tr>
								<?php
							}
							?>
							</table>
							<?php
						}else{
							echo('There are no students in '.getClassDetail($class_id,'standard').' - '.getClassDetail($class_id,'batch'));

						}
					}else{
						echo('You have not been assigned to any Class/Standard');
					}
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