<!DOCTYPE html>
	<head>
		<meta http-equiv="x-ua-compatible" content="IE=9" >
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			
			$check=checkAdminFeature($user_id);
			if($check['student']!=1)
				header('Location:../index.php');
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Student</h3>
				<hr />
				<div class="menu_bar">
					<a href="index.php">Student List</a>
					<?php
					if($check['student']==1){
						?><a href="register.php">Registration</a><?php
					}
					?>
				</div>
				
				<table align="center" width="100%">
					<form action="register.php" method="post">
					<tr><td width="25%">Name</td><td><input type="text" name="name" size="50" id="name" /></td></tr>
					<tr><td>Registration No.</td><td><input type="text" name="reg_no" id="reg_no" value="<?php echo(getRegistrationNumber());?>" /></td></tr>
					<tr><td>Standard</td><td><select id="standard" name="standard">
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
							<option value="0">There are no Standard Created</option>
							<?php
						}
						?>
					</select></td></tr>
					<tr><td>Address</td><td><input type="text" id="addr" name="addr" size="60" /></td></tr>
					<tr><td>Contact No.</td><td><input type="text" name="contact_no" maxlength="10" size="20" id="contact_no" onkeyup="check_contact_no()" /></td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td colspan="2"><span id="review"></span></td></tr>
					<tr><td></td><td><input type="button" name="submit" id="reviewBtn" class="std_btn" value="Review" onclick="review()" /></td></tr>
					</form>
				</table>
				<span id="review2">
				<?php
				if(isset($_POST['submit'])){
					$name=$_POST['name'];
					$reg_no=$_POST['reg_no'];
					$addr=$_POST['addr'];
					$contact=$_POST['contact_no'];
					$standard=$_POST['standard'];
					
					if(trim($name)!='' && trim($reg_no)!='' && trim($addr)!='' && trim($contact)!='' && $standard!=0){
						$sql="select student_id from student_detail where reg_no='$reg_no'";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							echo('Registration Number Already Exists');
						}else{
							$pass=md5($reg_no);
							$sql="insert into user set name='$name',password='$pass',user_type='s'";
							@mysql_query($sql);
							$sql="select user_id from user where name='$name' and password='$pass' and user_type='s' and user_added=0";
							$sql=@mysql_fetch_array(@mysql_query($sql));
							$student_id=$sql['user_id'];
							$sql="insert into student_detail set student_id='$student_id', name='$name', reg_no='$reg_no', address='$addr', contact_no='$contact',standard='$standard', password='$reg_no'";
							@mysql_query($sql);
							$sql="update user set user_added=1 where name='$name' and password='$pass' and user_type='s' and user_added=0";
							@mysql_query($sql);
							echo('New Student has been Registered Successfully');
						}
					}else{
						echo('Some Fields are Empty');
					}
					
				}
				?>
				</span>
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