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

				if(isset($_POST['updateHalfBtn'])){
					$student_id=$_POST['student_id'];
					$standard=$_POST['standard'];
					$sql="select * from marking_scheme where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							$mark=$_POST[$subject_id];
							$sql2="select half from marks where student_id='$student_id' and subject_id='$subject_id'";
							$sql2=@mysql_query($sql2);
							if(@mysql_num_rows($sql2)){
								$sql2="update marks set half='$mark' where student_id='$student_id' and subject_id='$subject_id'";
								$sql2=@mysql_query($sql2);
							}else{
								$sql2="insert into marks set half='$mark',student_id='$student_id',subject_id='$subject_id'";
								$sql2=@mysql_query($sql2);
							}
						}
					}else{
						echo('Something Went Wrong');
					}
				}else if(isset($_POST['updateAnnualBtn'])){
					$student_id=$_POST['student_id'];
					$standard=$_POST['standard'];
					$sql="select * from marking_scheme where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							$mark=$_POST[$subject_id];
							$sql2="select annual from marks where student_id='$student_id' and subject_id='$subject_id'";
							$sql2=@mysql_query($sql2);
							if(@mysql_num_rows($sql2)){
								$sql2="update marks set annual='$mark' where student_id='$student_id' and subject_id='$subject_id'";
								$sql2=@mysql_query($sql2);
							}else{
								$sql2="insert into marks set annual='$mark',student_id='$student_id',subject_id='$subject_id'";
								$sql2=@mysql_query($sql2);
							}
						}
					}else{
						echo('Something Went Wrong');
					}
				}else if(isset($_GET['id']) && isset($_GET['q']) && $_GET['q']=='hy'){
					// half yearly marksheet
					$student_id=$_GET['id'];
					$standard=get_user_name($student_id,'s','standard');
					$sql="select * from marking_scheme where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<form action="insert.php" method="post">
						<tr><td colspan="2"><b>Half Yearly Marksheet</b></td></tr>
						<tr><td width="25%">Subject</td><td>Marks</td></tr>
						<?php
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							$sql2="select half from marks where student_id='$student_id' and subject_id='$subject_id'";
							$sql2=@mysql_query($sql2);
							if(@mysql_num_rows($sql2)){
								$maxMark=$row['half'];
								$sql2=@mysql_fetch_array($sql2);
								?>
								<tr><td><?php echo(showSubject($subject_id));?></td><td><input onkeyup="checkMaxMark('<?php echo($maxMark);?>','<?php echo($subject_id);?>')" type="text" id="<?php echo($row['subject_id']);?>" name="<?php echo($row['subject_id']);?>" maxlength="3" size="10" value="<?php echo($sql2['half']);?>" />/<?php echo($row['half']); ?></td></tr>
								<?php
							}else{

								?>
								<tr><td><?php echo(showSubject($subject_id));?></td><td><input onkeyup="checkMaxMark('<?php echo($maxMark);?>')"> type="text" id="<?php echo($row['subject_id']);?>" name="<?php echo($row['subject_id']);?>" maxlength="3" size="10" />/<?php echo($row['half']); ?></td></tr>
								<?php
							}
						}
						?>
						<input type="hidden" name="student_id" value="<?php echo($student_id);?>">
						<input type="hidden" name="standard" value="<?php echo($standard);?>">
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><input type="submit" name="updateHalfBtn" value="Update" class="std_btn"></td></tr>
						</form>
						</table>
						<?php
					}else{
						echo('Marksheet Format is not Set');
					}
				}else if(isset($_GET['id']) && isset($_GET['q']) && $_GET['q']=='ann'){
					// half yearly marksheet
					$student_id=$_GET['id'];
					$standard=get_user_name($student_id,'s','standard');
					$sql="select * from marking_scheme where standard='$standard'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<form action="insert.php" method="post">
						<tr><td colspan="2"><b>Annual Marksheet</b></td></tr>
						<tr><td width="25%">Subject</td><td>Marks</td></tr>
						<?php
						while($row=@mysql_fetch_array($sql)){
							$subject_id=$row['subject_id'];
							$sql2="select annual from marks where student_id='$student_id' and subject_id='$subject_id'";
							$sql2=@mysql_query($sql2);
							if(@mysql_num_rows($sql2)){
								$sql2=@mysql_fetch_array($sql2);
								?>
								<tr><td><?php echo(showSubject($subject_id));?></td><td><input type="text" name="<?php echo($row['subject_id']);?>" maxlength="3" size="10" value="<?php echo($sql2['annual']);?>" />/<?php echo($row['half']); ?></td></tr>
								<?php
							}else{
								?>
								<tr><td><?php echo(showSubject($subject_id));?></td><td><input type="text" name="<?php echo($row['subject_id']);?>" maxlength="3" size="10" />/<?php echo($row['annual']); ?></td></tr>
								<?php
							}
						}
						?>
						<input type="hidden" name="student_id" value="<?php echo($student_id);?>">
						<input type="hidden" name="standard" value="<?php echo($standard);?>">
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><input type="submit" name="updateAnnualBtn" value="Update" class="std_btn"></td></tr>
						</form>
						</table>
						<?php
					}else{
						echo('Marksheet Format is not Set');
					}
				}else if(isset($_POST['reg_no']) && trim($_POST['reg_no'])!=''){
					$reg_no=$_POST['reg_no'];
					$sql="select * from student_detail where reg_no='$reg_no'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						$sql=@mysql_fetch_array($sql);
						?>
						<table align="center" width="100%">
						<tr><td width="25%">Name</td><td><?php echo($sql['name']);?></td></tr>
						<tr><td>Registration Number</td><td><?php echo($sql['reg_no']);?></td></tr>
						<tr><td>Roll Number</td><td><?php echo($sql['roll_no']);?></td></tr>
						<tr><td>Standard-Section</td><td><?php echo(getClassDetail($sql['class_id'],'standard').' - '.getClassDetail($sql['class_id'],'batch'));?></td></tr>
						<tr><td></td><td><a href="?id=<?=$sql['student_id'];?>&q=hy">Update Half Yearly Marksheet</a> | <a href="?id=<?=$sql['student_id'];?>&q=ann">Update Annual Marksheet</a></td></tr>
						</table>
						<?php
					}else{
						echo('No Student Found');
					}
				}else if(isset($_POST['standardSelector']) && isset($_POST['sectionSelector'])){
					$class_id=$_POST['sectionSelector'];
					$sql="select * from student_detail where class_id='$class_id' order by batch asc";
					$sql=@mysql_query($sql);

					if(@mysql_num_rows($sql)){
						?>
						<table align="center" width="100%">
						<tr><td>Roll Number</td><td>Name</td><td>Class-Section</td></tr>
						<?php
						while($row=@mysql_fetch_array($sql)){
							?>
							<tr><td></td><td><?php echo($row['name']);?></td></tr>
							<?php
						}
						?>
						</table>
						<?php
					}else{
						echo('No Students Found');
					}
				}
				?>
				


				
				<?php
				getGuide('../../guideTips/updateMarks-guide.html');
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
		<script type="text/javascript" src="../js.js"></script>
	</body>
</html>