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
			if($check['hire']!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<?php
				if(!isset($_POST['review']) && !isset($_POST['addTeacher'])){
					?>
				<h3>Recruit</h3>
				<hr />
			
				<table align="center" width="100%">
					<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
					<tr><td colspan="2"><font style="font-size:13px;">Fields marked with (*) are mandatory</font></td></tr>
					<tr><td width="25%"><strong>Name *</strong></td><td><input type="text" size="60" name="name" id="name"  /></td></tr>
					<tr><td width="25%"><strong>Address *</strong></td><td><input type="text" size="60"  name="address" id="address" /></td></tr>
					<tr><td width="25%"><strong>Contact *</strong></td><td>+91<input type="text" name="contact_no" size="30" maxlength="10" id="contact_no" onkeyup="check_contact_no()" /></td></tr>
					<tr><td><strong>Designation (Optional)</strong></td><td><input type="text" size="30" value="Teacher" name="designation" /></td></tr>
					<tr><td colspan="2"><strong>Assign Standard/Class</strong></td></tr>
					<tr><td></td><td>
						<?php
						$sql="select distinct standard from class_detail";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)==0){
							echo('No Standard/Class has been added.');
						}else{
							while($row=@mysql_fetch_array($sql)){
								?>
								<input type="checkbox" value="1" name="<?php echo($row['standard']);?>" /><?php echo($row['standard']);?><br />
								<?php
							}
						}
						?>
					</td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td></td><td><input type="submit"  name="review" class="std_btn" value="Add Staff" /></td></tr>
					</form>
				</table>
				<?php
				}else if(isset($_POST['review'])){
					if(trim($_POST['name'])==''){
						?><h3>Field Missing</h3>
						<hr /><?php
						echo('Some Fields are missing');
					}else
					if(trim($_POST['address'])==''){
						?><h3>Field Missing</h3>
						<hr /><?php
						echo('Some Fields are missing');
					}else
						if(trim($_POST['contact_no'])==''){
							?><h3>Field Missing</h3>
						<hr /><?php
						echo('Some Fields are missing');
					}else{
					?>
					<h3>Recruit - Review</h3>
					<hr />
					<table align="center" width="100%" border="0" cellspacing="0">
						<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
						<tr><td width="25%">Name</td><td><?php echo($_POST['name']);?></td></tr>
						<tr><td width="25%">Address</td><td><?php echo($_POST['address']);?></td></tr>
						<tr><td width="25%">Contact</td><td><?php echo($_POST['contact_no']);?></td></tr>
						<tr><td width="25%">Designation</td><td><?php echo($_POST['designation']);?></td></tr>
						<tr><td colspan="2">Standard/Class assigned</td></tr>
						<tr><td></td><td>
							<?php
							$sql="select distinct standard from class_detail";
							$sql=@mysql_query($sql);
							if(@mysql_num_rows($sql)==0)
								echo('No Standard/Class assigned');
							else{
								while($row=@mysql_fetch_array($sql)){
									$standard=$row['standard'];
									if(isset($_POST[$standard]) && $_POST[$standard]==1)
										echo($standard.'<br/>');
								}
							}
							?>
						</td></tr>
						<tr><td colspan="2">Select Subjects</td></tr>
						<?php
						$sql="select distinct standard from class_detail";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)==0)
							echo('<tr><td></td><td>No Standard/Class assigned</td></tr>');
						else{
							while($row=@mysql_fetch_array($sql)){
								$standard=$row['standard'];
								if(isset($_POST[$standard]) && $_POST[$standard]==1){
									?>
									<tr><td colspan="2"><?php echo('Standard '.$standard);?>
										<input type="hidden" name="<?php echo($standard);?>" value="1" />
									</td></tr>
										<?php
										$sql2="select subject_name,subject_id from subjects where standard='$standard'";
										$sql2=@mysql_query($sql2);
										$res=@mysql_num_rows($sql2);
										if($res==0)
											echo('<tr><td></td><td>No Subjects are added for Standard/Class'.$standard.'</td></tr>');
										else{
											while($row2=@mysql_fetch_array($sql2)){
												$subject_name=$row2['subject_name'];
												?>
												<tr><td></td><td><input type="checkbox" value="1" name="<?php echo($standard.$subject_name);?>" /><?php echo($row2['subject_name']);?></td></tr>
												<?php
											}
										}
										?>
									<?php
								}
							}
						}
						?>
						<tr><td colspan="2"><hr /></td></tr>
						<input type="hidden" name="name" value="<?php echo($_POST['name']);?>" />
						<input type="hidden" name="address" value="<?php echo($_POST['address']);?>" />
						<input type="hidden" name="contact_no" value="<?php echo($_POST['contact_no']);?>" />
						<input type="hidden" name="designation" value="<?php echo($_POST['designation']);?>" />
						<?php /*
						<tr><td></td><td><button class="std_btn" onclick="add_teacher();">Add</button></td></tr>
						 */?>
						 <tr><td></td><td><input type="submit" name="addTeacher" value="Add" class="std_btn" /></td></tr>
						 </form>
					</table>
					<div id="add_result"></div>
					<?php
					}
				}else if(isset($_POST['addTeacher'])){
					$name=$_POST['name'];
					$contact_no=$_POST['contact_no'];
					$address=$_POST['address'];
					$post=$_POST['designation'];
					$showPass=rand(8000, 9000);
					$pass=md5($showPass);
					$sql="insert into user set name='$name', password='$pass', user_type='t'";
					$sql=@mysql_query($sql);
					$sql="select user_id from user where password='$pass' and user_type='t' and name='$name' and user_added=0";
					$sql=@mysql_query($sql);
					$t_id=@mysql_fetch_array($sql);
					$t_id=$t_id['user_id'];
					$sql="insert into teacher_detail set teacher_id='$t_id',showPass='$showPass', name='$name',password='$pass',address='$address', contact_no='$contact_no',post='$post'";
					$sql=@mysql_query($sql);
					$sql="update user set user_added=1 where user_id='$t_id' and password='$pass' and user_type='t' and name='$name' and user_added=0";
					@mysql_query($sql);
					$sql="select distinct standard from class_detail";
					$sql=@mysql_query($sql);
					while($row=@mysql_fetch_array($sql)){
						$standard=$row['standard'];
						if(isset($_POST[$standard]) && $_POST[$standard]==1){
							$sql2="select subject_name,subject_id from subjects where standard='$standard'";
							$sql2=@mysql_query($sql2);
							while($row2=@mysql_fetch_array($sql2)){
								$subject_name=$row2['subject_name'];
								$subject_id=$row2['subject_id'];
								$subject_name2=$standard.$subject_name;
								if(isset($_POST[$subject_name2]) && $_POST[$subject_name2]==1){
									$sql3="insert into teacher_class_subject set teacher_id='$t_id',name='$name', standard='$standard', subject_name='$subject_name',subject_id='$subject_id'";
									@mysql_query($sql3);
								}
							}
						}
					}
					echo('New Staff Added with password '.$showPass);
				}else{
					echo('Session Expired');
				}?>


				<?php
				getGuide('../guideTips/recruit-guide.html');
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