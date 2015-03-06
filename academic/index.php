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
			
			$check=checkAdminFeature($user_id);
			if($check['academic']!=1 && $check['routine']!=1 && $check['class_administration']!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<div id="subjectValidResult" style="position: absolute; left: 0px; top: 110px; width: 90%; height: auto; background: rgba(0,0,0,0.7);
				padding:50px; color: white; display: none;" onclick="$('#subjectValidResult').fadeOut(); document.getElementById('add_subject_btn').disabled=false;"></div>
				<?php
				if(!isset($_GET['addsubject'])){
					?>
					<h3>Academic Administration</h3>
					<hr />
					<?php
					$check=checkAdminFeature($user_id);
					getMenu($user_id);
				}else if(isset($_GET['addsubject'])){
					?>
					<h3>Academic Administration - Add New Subject</h3>
					<hr />
					<table align="center" width="100%">
						<tr><td width="25%">Subject Name</td><td><input type="text" id="sub_name" /></td></tr>
						<tr><td>Standard</td><td><select id="standard">
							<option value="0">Subject for...</option>
							<?php
							$sql="select distinct standard from class_detail";
							$sql=@mysql_query($sql);
							$res=mysql_num_rows($sql);
							if($res!=0){
								while($row=@mysql_fetch_array($sql)){
									?>
									<option><?php echo($row['standard']);?></option>
									<?php
								}
							}
							?>
						</select></td></tr>
						<tr><td></td><td><input type="button" <?php if($res==0){echo('disabled=true');}?> class="std_btn" value="<?php if($res==0){echo('Add Class First');}else echo('Add Subject');?>" id="add_subject_btn" onclick="checkSubjectValidity();" /></td></tr>
						<tr><td colspan="2">Existing Subjects</td></tr>
						<tr><td><strong>Standard</strong></td><td><strong>Subject Name</strong></td></tr>
						<?php
						$sql="select subject_name,standard from subjects order by standard ASC";
						$sql=@mysql_query($sql);
						$res=@mysql_num_rows($sql);
						if($res==0){
							?>
							<tr><td></td><td>No Subjects Added</td></tr>
							<?php
						}else{
							$standard=0;
							while($row=@mysql_fetch_array($sql)){
								if($standard!=$row['standard']){
									$standard=$row['standard'];
									?>
									<tr bgcolor="#ebf2ff"><td colspan="2"><?php echo($row['standard']);?></td></tr>
									<?php
								}
								?>
								<tr><td></td><td><?php echo($row['subject_name']);?></td></tr>
								<?php
							}
						}
						?>
					</table>
					<?php
					getGuide('../guideTips/addSubject-guide.html');
				}
				?>
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>

		<script type="text/javascript">
			function checkField(id){
				var field=document.getElementById(id).value;
				if(field==''){
					alert('Field is Empty');
				}
			}
		</script>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
	</body>
</html>