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
			
			if($user_type!='t'){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>My Assignments</h3>
				<hr />
				<?php
				$sql="select assignments from admin_features where admin_id='$user_id'";
				$sql=@mysql_query($sql);
				$sql=@mysql_fetch_array($sql);
				?>
				<div class="menu_bar"><a href="index.php">View</a>
					<?php
					if($sql['assignments']==1){
						?>
						<a href="create.php">Create</a>
						<?php
					}
					if($user_type=='t'){
						?>
						<a href="myassignment.php">My Assignments</a>
						<?php
					}
				?>
				</div>
				<?php
				$sql="select * from assignment where from_id='$user_id'";
				$sql=@mysql_query($sql);
				while($row=@mysql_fetch_array($sql)){
					$ass_id=$row['assignment_id'];
					?>
					<div class="mail_entry">
					<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr><td style="font-size: 17px;"><strong><a href="index.php?view&id=<?=$row['assignment_id'];?>"><?php echo($row['title']);?></a></strong></td><td width="25%"><a href="index.php?view&id=<?=$row['assignment_id'];?>">Download</a> | <a href="#" onclick="deleteAssignment('<?php echo($ass_id);?>');"><span class="hover">Delete</span></a></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">File : <?php echo($row['file_name']);?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">By : <?php echo(getUserName($row['from_id']));?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">Uploaded on : <?php echo($row['assignment_date']);?></td></tr>
					</table>
					</div>
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
		<div id="mousehoverdiv" style="position: absolute; padding: 10px; display: none; color: white; font-size: 13px; max-width: 100px; height: auto; background: rgba(0,0,0,0.5);"></div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>