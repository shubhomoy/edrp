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
			
			function authenticateFile($standard,$class_id){
				if(trim($_POST['title'])==''){
					return 6;
				}
				if($_FILES["file"]["error"]>0){
						return 2;
					}else{
						$user_id=$_SESSION['user_id'];
						$title=$_POST['title'];
						$extension=array("gif","png","jpeg","jpg","pdf","doc","docx","ppt","pptx");
						$fileExt=explode('.', $_FILES['file']['name']);
						$fileExt=end($fileExt);
						if(in_array($fileExt, $extension) && (
							$_FILES['file']['type']=='image/jpeg' || 
							$_FILES['file']['type']=='image/jpg' || 
							$_FILES['file']['type']=='image/png' || 
							$_FILES['file']['type']=='image/gif' || 
							$_FILES['file']['type']=='application/pdf' || 
							$_FILES['file']['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
							$_FILES['file']['type']=='application/vnd.openxmlformats-officedocument.presentationml.presentation')){
								
							if($_FILES['file']['size']<=5000000 ){
								$sql='';
								if($standard!=0){
									if($class_id!=0){
										if(!is_dir('../upload/class_id-'.$class_id)){
											mkdir('../upload/class_id-'.$class_id);
										}
										if(!file_exists('../upload/class_id-'.$class_id.'/'.$_FILES['file']['name'])){
											move_uploaded_file($_FILES['file']['tmp_name'], '../upload/class_id-'.$class_id.'/'.$_FILES['file']['name']);
											$file_name=$_FILES['file']['name'];
											$sql="insert into assignment set from_id='$user_id', title='$title', assignment_date=NOW(), standard='$standard', class_id='$class_id', file_name='$file_name'";
											
										}else {
											return 5;
										}
									}else{
										if(!is_dir('../upload/'.$standard)){
											mkdir('../upload/'.$standard);
										}
										if(!file_exists('../upload/'.$standard.'/'.$_FILES['file']['name'])){
											move_uploaded_file($_FILES['file']['tmp_name'], '../upload/'.$standard.'/'.$_FILES['file']['name']);
											$file_name=$_FILES['file']['name'];
											$sql="insert into assignment set from_id='$user_id', title='$title', assignment_date=NOW(), standard='$standard', class_id=0, file_name='$file_name'";
										}
										else{
											return 5;
										}
									}
								}else{
									if(!is_dir('../upload/all')){
										mkdir('../upload/all');
									}
									if(!file_exists('../upload/all/'.$_FILES['file']['name'])){
										move_uploaded_file($_FILES['file']['tmp_name'], '../upload/all/'.$_FILES['file']['name']);
										$file_name=$_FILES['file']['name'];
										$sql="insert into assignment set from_id='$user_id', title='$title', assignment_date=NOW(), standard=0, class_id=0, file_name='$file_name'";
									}else{
										return 5;
									}
								}
								@mysql_query($sql);
								return 1;
							}else{
								return 3;
							}
						}else{
							return 4;
						}				
						//
					}
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Assignments - Create</h3>
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
				<table align="center" width="100%">
				<form enctype="multipart/form-data" method="post" >
					<tr><td>Title</td><td><input type="text" name="title" id="title" autocomplete="off" size="60" /></td></tr>
				<tr><td width="25%">Standard</td><td><select id="standardSelect" name="standardSelect"; 
					onclick="sectionSelector();">
					<option value="0">All</option>
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
				</select></td></tr>
				<tr id="section" style="display: none;"><td>Section/Batch</td><td>
					<select id="sectionSelect" name="sectionSelect">
						
					</select>
				</td></tr>
				<tr><td>Upload File</td><td><input type="file" name="file" id="file" /></td></tr>
				<tr><td></td><td><span id="reviewDisplay"></span></td></tr>
				<tr><td></td><td><input type="button" id="upload" name="upload" value="Review" class="std_btn" onclick="reviewAssignment()" /></td></tr>
				</form>
				</table>
				
				<br />
				<br />
				<center><i>
				<?php
				if(isset($_POST['upload'])){
					$validFile=0;
					$standard=$_POST['standardSelect'];
					$class_id=0;
					if(isset($_POST['sectionSelect']))
					$class_id=$_POST['sectionSelect'];
					$validFile=authenticateFile($standard,$class_id);
					
					if($validFile==1){
						if($standard!=0){
							if($class_id!=0){
								echo('<font color="green">Assignment for '.getClassDetail($class_id, 'standard').'-'.getClassDetail($class_id, 'batch').' has been Uploaded</font>');
							}else{
								echo('<font color="green">Assignment for '.$standard.' has been Uploaded</font>');
							}
						}else{
						echo('<font color="green">Assignment for All has been Uploaded</font>');
						}
					}else if($validFile==2){
						echo('<font color="red">Please Upload a File</font>');
					}else if($validFile==3){
						echo('<font color="red">File is too Large. Maximum file size should be 4mb</font>');
					}else if($validFile==4){
						echo('<font color="red">Invalid File Type</font>');
					}else if($validFile==5){
						echo('<font color="red">File Already Exists</font>');
					}else if($validFile==6){
						echo('<font color="red">Please specify a Title</font>');
					}
				}
				?>
				</i></center>
				
				
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="js.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
	</body>
</html>