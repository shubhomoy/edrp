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
				<h3>Examination - Setup</h3>
				<hr />
				<?php
				getMenu($user_id);
				if(isset($_POST['marksSetBtn'])){
					$standard=$_POST['standard'];
					$sql="select * from subjects where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							if(isset($_POST['half_'.$subject_id]))
								$half=$_POST['half_'.$subject_id];
							if(isset($_POST['annual_'.$subject_id]))
								$annual=$_POST['annual_'.$subject_id];
							//echo($half.' '.$annual.' '.$subject_id.'<br />');
							$sql2="select subject_id from marking_scheme where subject_id='$subject_id' and standard='$standard'";
							$sql2=@mysql_query($sql2);
							if(@mysql_num_rows($sql2)){
								// already exists
								$sql2="update marking_scheme set half='$half', annual='$annual' where subject_id='$subject_id' and standard='$standard'";
								$sql2=@mysql_query($sql2);
							}else{
								// new entry
								$sql2="insert into marking_scheme set standard='$standard', subject_id='$subject_id', half='$half', annual='$annual'";
								@mysql_query($sql2);
							}
							echo('Marking Scheme has been Set');
						}
					}else{
						echo('There are no Subjects in Stadnard '.$standard);
					}

				}else if(isset($_POST['selectStandardBtn'])){
					$standard=$_POST['standard'];
					?>
					<table align="center" width="100%" border="0">
					<form action="index.php" method="post">
					<tr><td></td><td><b>Half Yearly</b></td><td><b>Annual</b></td></tr>
					<?php
					$sql="select subject_id,subject_name from subjects where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							?>
							<tr><td width="30%" style="padding-left:20px;"><?php echo($row['subject_name']);?></td>
							<td width="20%"><input type="text" maxlength="3" size="10" name="<?php echo('half_'.$row['subject_id']);?>" /></td>
							<td><input type="text" maxlength="3" size="10" name="<?php echo('annual_'.$row['subject_id']);?>" /></td>
							</tr>
							<?php
						}?>
						<tr><td colspan="3"><hr /></td></tr>
						<tr><td colspan="3" align="center"><input type="submit" value="Proceed" class="std_btn" name="marksSetBtn" /></td></tr>
						<input type="hidden" name="standard" value="<?php echo($standard);?>">
						</form>
						<?php
					}else{
						echo('<tr><td colspan="3">There are no Subjects in stnadard '.$standard.'</td></tr>');
					}
					?>
					</table>
					<?php

				}else if(!isset($_POST['selectStandardBtn'])){
					?>
				
					<table align="center" width="100%">
					<form action="index.php" method="post">
					<tr><td width="25%">Select Standard</td><td>
					<?php
					$sql="select distinct standard from class_detail order by standard asc";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<select name="standard">
						<?php
						while($row=@mysql_fetch_array($sql)){
							?>
							<option value="<?php echo($row['standard']);?>">
							<?php
							echo($row['standard']);
							?>
							</option>
							<?php
						}
						?></select>
						</td></tr>
						<tr><td></td><td><input type="submit" value="Proceed" name="selectStandardBtn" class="std_btn" /></td></tr>
					<?php
					}else{
						echo('There is no class in your Institute. Create one first');
					}
					?>
					</form>
					</table>
					<?php
				}
				?>

				<?php
				getGuide('../../guideTips/examinationSetup-guide.html');
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
		<script type="text/javascript" src="/edrp/ajax/ajax.js"></script>
		<script type="text/javascript" src="/edrp/js/jquery.js"></script>
	</body>
</html>