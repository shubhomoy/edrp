<!DOCTYPE html>
<html>

<!-- This page is for viewing your own profile -->
	<head>
		<link rel="stylesheet" href="/edrp/style.css" />
		<title>EdRP - Profile</title>
		<?php
			session_start();
			require_once '../function.php';
			require_once '../config.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];

			$check=checkAdminFeature($user_id);
			
		?>
	</head>

	<?php
	if(isset($_SESSION['notifyChanges']) && $_SESSION['notifyChanges']!=-1){
		?>
		<body onload="checkForChanges();">
		<?php
	}else{
		?>
		<body>
		<?php
	}
	?>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font>
		<div class="sub-header"><a href="#">About Us</a> | <a href="#">Contact</a> | <a href="#">Members</a></div>
		</div>
		<div id="container">
			<div class="container_body_main">
				<?php
				
				$sql='';
				if(isset($_GET['id'])){
					$id=$_GET['id'];
					$sql='';
					if(getUserType($id)=='t'){
						$sql="select * from teacher_detail where teacher_id='$id'";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							$sql=@mysql_fetch_array($sql);
							?>
							<h3><?php echo(getUserName($sql['teacher_id']));?></h3>
							<hr />
							<div class="menu_bar"><a href="/edrp/mail/compose.php?id=<?=$id;?>">Message</a></div>
							<table align="center" width="100%">
							<tr><td width="25%">Teacher ID</td><td><?php echo($sql['teacher_id']);?></td></tr>
							<tr><td>Name</td><td><?php echo($sql['name']);?></td></tr>
							<tr><td>Address</td><td><?php echo($sql['address']);?></td></tr>
							<tr><td>Contact No.</td><td><?php echo($sql['contact_no']);?></td></tr>

							<?php
							if($user_type!='s'){
								?>
								<tr><td>Load Left</td><td><?php echo($sql['load_hr']);?></td></tr>
							<?php
							}?>
							<tr><td colspan="2"><hr /></td></tr>
							<tr><td colspan="2"><strong>Assigned</strong></td></tr>
							<tr><td>Class Teacher</td><td><span id="classTeacher"><?php
							$sql="select standard,batch from class_detail where class_teacher='$id'";
							$sql=@mysql_query($sql);
							if(@mysql_num_rows($sql)){
								$sql=@mysql_fetch_array($sql);
								echo($sql['standard'].' - '.$sql['batch']); 
								if($check['assign-unassign-class-teacher']==1){
									?>
									<font style="font-size: 13px;"><a href="#" onclick="unassignClassTeacher('<?php echo($id);?>');">(Unassign)</a></font><?php
								}
							}else if($check['assign-unassign-class-teacher']==1){
								?>
								<a href="#" onclick="$('#assignClassTeacherDisplay').fadeIn();">Assign</a>
								<?php
							}else{
								echo('Not Assigned');
							}
							?></span></td></tr>
							<?php 
							if($check['assign-unassign-teacher-subject']==1){
								?>
								<tr><td colspan="2"><a href="assign.php?id=<?=$id;?>">Assign/Unassign Standard-Subject</a></td></tr>
								<?php
							}?>
							<tr><td>Standard</td><td>Subject</td></tr>
							<?php
							$sql="select * from teacher_class_subject where teacher_id='$id' order by standard asc";
							$sql=@mysql_query($sql);
							$standard=0;
							while($row=@mysql_fetch_array($sql)){
								if($standard!=$row['standard']){
									?>
									<tr><td colspan="2"><?php echo($row['standard']);?></td></tr>
									<?php
									$standard=$row['standard'];
								}
								?>
								<tr><td></td><td><?php echo($row['subject_name']);?></td></tr>
								<?php
							}
							?>
							</table>
							<div id="assignClassTeacherDisplay" onclick="$(this).fadeOut();" class="review-screen">
							<p align="center">Assign Class Teacher</p>
							<hr />
							<?php
								if($check['assign-unassign-class-teacher']){
									$sql="select class_id,standard,batch from class_detail where class_teacher=0 order by standard asc";
									$sql=@mysql_query($sql);
									if(@mysql_num_rows($sql)){
										?><table align="center" width="100%" border="0" cellspacing="1" cellpadding="5">
										<tr bgcolor="#0055CC"><td align="center">Standard</td><td align="center">Batch</td><td></td></tr>
										<?php
										while($row=@mysql_fetch_array($sql)){
											$class_id=$row['class_id'];
											?>
											<tr bgcolor="#0099CC"><td align="center" width="10%"><?php echo($row['standard']);?></td>
											<td align="center" width="10%"><?php echo($row['batch']);?></td>
											<td align="center"><a href="#" onclick="assignClassTeacher('<?php echo($id);?>','<?php echo($class_id);?>');">Assign</a></td>
											</tr>
											<?php
										}
										?></table><?php
									}else{
										echo('All Classes have been assigned with their respective Class Teacher');
									}
								}else{
									echo('You are not eligible to Assign Class Teacher');
								}?>
							</div>
							<?php
						}else{
							echo('No results Found');
						}
					}
				}else if(!isset($_GET['edit'])){
				// view your own profile
				?>
				<h3>My Profile</h3>
				<hr />
				<table align="center" width="100%" cellspacing="0" cellpadding="5">
				<tr><td width="25%"><strong>Name</strong></td><td><?php echo(getUserName($user_id));?></td></tr>
				<?php if($user_type!='s'){

					// Displays the Designation if NOT a student
					
					?>
					<tr><td width="25%"><strong>Post</strong></td><td><?php if($user_type=='a')
					echo(get_user_name($user_id, 'a', 'post'));
					else if($user_type=='t')
					echo(get_user_name($user_id, 't', 'post'));
					?></td></tr>
					<?php
				}?>
				<tr><td><strong>Address</strong></td><td><?php if($user_type=='a')
					echo(get_user_name($user_id, 'a', 'address'));
					else if($user_type=='t')
					echo(get_user_name($user_id, 't', 'address'));
					else if($user_type=='s')
					echo(get_user_name($user_id, 's', 'address'));
				?>
				</td></tr>
				<tr><td><strong>Contact</strong></td><td><?php if($user_type=='a')
					echo(get_user_name($user_id, 'a', 'contact'));
					else if($user_type=='t')
					echo(get_user_name($user_id, 't', 'contact'));
					else if($user_type=='s')
					echo(get_user_name($user_id, 's', 'contact'));
				?></td></tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr><td></td><td><a href="?edit">Edit Profile</a></td></tr>
				</table>
				<?php
			}else if(isset($_GET['edit'])){
				// edit your own profile
				?>
				<h3>My Profile - Edit</h3>
				<hr />
				<table align="center" width="100%" cellspacing="0" cellpadding="5">
				<tr><td width="25%"><strong>Address</strong></td><td>
				<input type="text" id="addr" size="60" value="<?php if($user_type=='a')
					echo(get_user_name($user_id, 'a', 'address'));
					else if($user_type=='t')
					echo(get_user_name($user_id, 't', 'address'));
					else if($user_type=='s')
					echo(get_user_name($user_id, 's', 'address'));
				?>" autocomplete="off" /></td></tr>
				<tr><td width="25%"><strong>Contact</strong></td><td>
				<input type="text" name="contact" maxlength="10" id="contact_no" onkeyup="check_contact_no()" value="<?php if($user_type=='a')
					echo(get_user_name($user_id, 'a', 'contact'));
					else if($user_type=='t')
					echo(get_user_name($user_id, 't', 'contact'));
					else if($user_type=='s')
					echo(get_user_name($user_id, 's', 'contact'));
				?>" autocomplete="off" /></td></tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr><td></td><td><input type="button" id="reviewBtn" value="Review" class="std_btn" onclick="showReview()" /></td></tr>
				</table>
				<?php
			}
			?>
			<div class="review-screen"></div>
			<div class="notify-change">
				<?php
				if(isset($_SESSION['notifyChanges']) && $_SESSION['notifyChanges']!=-1){
					$text=$_SESSION['notifyChanges'];
					$_SESSION['notifyChanges']=-1;
					echo($text);
				}
				?>
			</div>
				

			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="/edrp/ajax/ajax.js"></script>
		<script type="text/javascript" src="/edrp/js/jquery.js"></script>
		<script type="text/javascript" src="/edrp/js/js.js"></script>
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>