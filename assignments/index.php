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
			
			
			
			
			if(isset($_GET['view']) && isset($_GET['id']) && !empty($_GET['id'])){
				header('Location: download.php?id='.$_GET['id']);
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Assignments</h3>
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
				if($user_type!='s'){
					?>
					<table align="center" width="100%">
					<tr><td width="20%">Sort By</td><td>
					<select id="sort" onclick="updateSortViewDisplay()">
						<option value="0">Common to All</option>
						<?php
						$sql="select distinct standard from class_detail order by standard asc";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							while($row=@mysql_fetch_array($sql)){
								?>
								<option value="<?php echo($row['standard']);?>"><?php echo($row['standard']);?></option>
								<?php
							}	
						}
						?>
					</select>
					</td></tr>
					<tr style="display: none;" id="sectionSelect"><td>Section</td><td><select id="sectionSelector"></select></td></tr>
					<tr><td></td><td><input type="button" id="viewAssignmentBtn" value="View Assignments" class="std_btn" onclick="displayAssignment()" /></td></tr>
					<tr><td colspan="2"><span id="displayAssignment" style="display: none;"></span></td></tr>
					</table>
					<?php
				}else if($user_type=='s'){
					$class_id=$_SESSION['class_id'];
					$standard=getClassDetail($class_id,'standard');
					$sql="select * from assignment where standard='$standard' or class_id='$class_id' order by assignment_id desc";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							?>
							<div class="mail_entry">
							<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr><td style="font-size: 17px;"><strong><a href="index.php?view&id=<?=$row['assignment_id'];?>"><?php echo($row['title']);?></a></strong></td><td width="25%"><a href="index.php?view&id=<?=$row['assignment_id'];?>">Download</a></td></tr>
							<tr><td colspan="2" style="font-size: 13px;">File : <?php echo($row['file_name']);?></td></tr>
							<tr><td colspan="2" style="font-size: 13px;">By : <?php echo(getUserName($row['from_id']));?></td></tr>
							<tr><td colspan="2" style="font-size: 13px;">Uploaded on : <?php echo($row['assignment_date']);?></td></tr>
							</table>
							</div>
							<?php
						}
					}else{
						echo('No Assignments');
					}
					
				}?>
				
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