<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="/edrp/style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../function.php';
			require_once '../config.php';
			$id=0;
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			$check=checkAdminFeature($user_id);
			if($check['assign-unassign-teacher-subject']!=1){
				header('Location:index.php');
			}
			
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<?php
			if(isset($_GET['id']))
			$id=$_GET['id'];
			else if(isset($_POST['id']))
			$id=$_POST['id'];
			else{
				header('Location: index.php');
			}
			?>
			<div class="container_body_main"><?php
				if(isset($_POST['id']) && isset($_POST['submit'])){
				$standard=$_POST['standardSelector'];
				$subject=$_POST['subjectSelector'];
				$subject_name=showSubject($subject);
				$teacher_name=getUserName($id);
				$sql="insert into teacher_class_subject set teacher_id='$id',name='$teacher_name',subject_id='$subject',subject_name='$subject_name', standard='$standard'";
				@mysql_query($sql);
				
			}?>
				<h3><?php echo(getUserName($id));?> - Assign Standard/Subject</h3>
				<hr />
				<table align="center" width="100%">
					<form action="assign.php" method="post">
				<tr><td width="20%">Standard/Class</td><td><select name="standardSelector" id="standardSelector" onchange="getSubject('<?php echo($id);?>')">
					<option value="0">Choose</option>
					<?php
					$sql="select distinct standard from class_detail";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							?>
							<option value="<?php echo($row['standard']);?>"><?php echo($row['standard']);?></option>
							<?php
						}
					}else{
						echo('<option>No Class Created</option>');
					}
					?>
				</select></td></tr>
				<tr><td id="subject">Subject</td><td><select name="subjectSelector" id="subjectSelector"></select></td></tr>
				<tr><td></td><td><input type="submit" disabled="disabled" name="submit" value="Assign" id="assignBtn" class="std_btn" /></td></tr>
				<input type="hidden" name="id" value="<?php echo($id);?>" />
				</form>
				</table>
				
				<br />
				<table align="center" width="100%">
				<tr><td colspan="3">Already Assigned</td></tr>
				<tr><td width="25%">Standard/Class</td><td>Subject</td><td width="25%"></td></tr>
				<?php
				$sql="select subject_name,standard,subject_id from teacher_class_subject where teacher_id='$id' order by standard asc";
				$sql=@mysql_query($sql);
				$standard=0;
				if(@mysql_num_rows($sql)){
					while($row=@mysql_fetch_array($sql)){
						if($standard!=$row['standard']){
							?>
							<tr><td colspan="3"><?php echo($row['standard']);?></td></tr>
							<?php
							$standard=$row['standard'];
						}
						$subject_id=$row['subject_id'];
						?>
						<tr><td></td><td><?php echo($row['subject_name']);?></td><td><span id="<?php echo('unassignSpan'.$subject_id);?>"><a href="#" onclick="unassignSubject('<?php echo($subject_id);?>','<?php echo($id);?>');">Unassign</a></span></td></tr>
						<?php
					}
				}else{
					?>
					<tr><td colspan="2">Not Assigned to any Standard and Subject</td></tr>
					<?php
				}
				?>
				</table>
				
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<div id="hover" style="position: absolute;display:none; max-width:200px;height: auto; background:rgba(0,0,0,0.6); color: #ffffff; padding: 5px; font-size: 13px;"></div>
		<script type="text/javascript" src="../edrp/ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>