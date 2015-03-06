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
			
			if($user_type!='a'){
				header('Location: ../error.php');
			}
			
			$check=checkAdminFeature($user_id);
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Teacher/Staff</h3>
				<hr />
				<div class="menu_bar">
					<a href="index.php">View/Edit</a>
				</div>
				<?php
				if(!isset($_GET['showall'])){
					?>
					<table align="center" width="100%">
					<tr><td colspan="2"><a href="?showall">Show All</a></td></tr>
					<tr><td colspan="2">Or</td></tr>
					<tr><td width="20%">Teacher Id</td><td><input type="text" /></td></tr>
					<tr><td></td><td><input type="button" value="Search" class="std_btn" /></td></tr>
					</table>
					<?php
				}else if(isset($_GET['showall'])){
					$page=0;
					if(isset($_GET['page']) && !empty($_GET['page'])){
						$page=$_GET['page'];
					}else{
						$page=0;
					}
					$sql="select teacher_id, name from teacher_detail limit ".$page.',20';
					$sql=@mysql_query($sql);
					echo(@mysql_num_rows());
					if(@mysql_num_rows($sql)>0){
						?>
						<table align="center" width="100%" cellspacing="0" cellpadding="3" border="0">
						<tr><td colspan="3">Displaying 20 results per page</td></tr>
						<tr bgcolor="#8169CC" style="color: white;"><td width="10%">S. No.</td><td width="15%">Teacher Id</td><td>Name</td></tr>
					
						<?php
						$i=1;
						while($row=@mysql_fetch_array($sql)){
							$id=$row['teacher_id'];
							$sql2="select teacher_id from teacher_class_subject where teacher_id='$id' ";
							$sql2=@mysql_query($sql2);
							?>
							<tr <?php if(@mysql_num_rows($sql2)==0) echo('bgcolor=#F4CCC9'); else if($i%2==0) echo('bgcolor="#B5D7E6"');?>><td><?php echo($i);?></td><td><?php echo($row['teacher_id']);?></td><td>
								<a href="../profile/index.php?id=<?=$row['teacher_id'];?>"><?php echo($row['name']);if(@mysql_num_rows($sql2)==0) echo(' (Not Assigned)');?></a>
							</td></tr>
							<?php
							$i++;
						}
						$page=$page+20;
						if(@mysql_num_rows($sql)==20){
							?>
							<tr><td></td><td><a href="?showall&page=<?=$page;?>">Next</a></td><td></td></tr>
							<?php
						}?>
						</table>
					<?php
					}else{
						echo('No Result');
					}
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