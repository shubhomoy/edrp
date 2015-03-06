<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../function.php';
			require_once '../config.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Application</h3>
				<hr />
				<div class="menu_bar"><a href="index.php">View</a><a href="create.php">Create</a></div>
				
					<table align="center" width="100%">
					<form action="create.php" method="post">
					<tr><td colspan="2"><font style="font-size:13px;">Fields marked with (*) are mandatory</font></td></tr>
					<tr><td width="25%"><strong>To</strong></td><td>
					<?php
					if($user_type!='a'){
						$sql="select admin_id from admin_features where approve_application_admin=1 and admin_id!='$user_id'";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							?><select id="to_id" name="to_id">
							<?php
							while($row=@mysql_fetch_array($sql)){
								echo('<option value='.$row['admin_id'].'>'.getUserName($row['admin_id']).'</option>');
							}
							?></select><?php
						}else{
							echo('There is no Higher Authority to approve your application');
						}
					}else if($user_type!='s'){
						$sql="select admin_id from admin_features where approve_application_teacher=1 and admin_id!='$user_id'";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							?><select id="to_id" name="to_id">
							<?php
							while($row=@mysql_fetch_array($sql)){
								echo('<option value='.$row['admin_id'].'>'.getUserName($row['admin_id']).'</option>');
							}
							?></select><?php
						}else{
							echo('There is no Higher Authority to approve your application');
						}
					}else{
						$sql="select admin_id from admin_features where approve_application_student=1";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							?><select id="to_id" name="to_id">
							<?php
							while($row=@mysql_fetch_array($sql)){
								echo('<option value='.$row['admin_id'].'>'.getUserName($row['admin_id']).'</option>');
							}
							?></select><?php
						}else{
							echo('There is no Higher Authority to approve your application');
						}
					}
					?>
					</select>
					</td></tr>
					<tr><td><strong>Subject *</strong></td><td><input type="text" size="50" id="subject" name="subject" /></td></tr>
					<tr><td colspan="2"><strong>Application *</strong></td></tr>
					<tr><td></td><td><textarea style="width: 100%;" rows="10" id="body" name="body"></textarea></td></tr>
					<tr><td></td><td><input type="button" id="reviewBtn" name="submit" class="std_btn" value="Review" onclick="displayReview();" /></td></tr>
					</form>
					</table>
				

				
				<div class="review-screen"></div>
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/js.js"></script>
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>