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
			$check=$check['class_administration'];
			if($check!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Class Administration - Search Result</h3>
				<hr />
				<div class="menu_bar"><a href="routine.php?view">View Routine</a><a href="routine.php?set">Set Routine</a><a href="classadministration.php">Class Administration</a></div>
				<?php
				if(isset($_POST['searchClass'])){
					$standard=$_POST['standard'];
					$section=strtoupper($_POST['section']);
					$sql='';
					$check=1;
					if(trim($standard)=='' && trim($section)!=''){
						$sql="select class_id,standard,batch from class_detail where batch='$section'";
					}else if(trim($section)=='' && trim($standard)!=''){
						$sql="select class_id,standard,batch from class_detail where standard='$standard'";
					}else if(trim($standard)=='' && trim($section)==''){
						echo('Invalid Search Input');
						$check=0;
					}else if(trim($standard)!='' && trim($section)!=''){
						$sql="select class_id,standard,batch from class_detail where batch='$section' and standard='$standard'";
					}
					if($check){
						$sql=@mysql_query($sql);
						$res=@mysql_num_rows($sql);
						if($res==0)
							echo('No Class Found');
						else{
							?>
							<table align="center" width="100%">
							<tr><td><strong>Search Results</strong></td></tr>
							<tr><td><hr /></td></tr><?php
							while($row=@mysql_fetch_array($sql)){
								?>
								<tr><td align="left"><a href="vclass.php?c_id=<?=$row['class_id'];?>"><?php echo($row['standard'].' - '.$row['batch']);?></a></td></tr>
								<?php
							}
							?></table><?php
						}
					}
				}else{
					header('Location: classadministration.php');
				}
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