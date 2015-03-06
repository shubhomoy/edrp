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
				
				<?php
				if(!isset($_GET['id'])){
					$sql="select application_id,to_id,subject,application_date,approval from application where from_id='$user_id' order by application_id desc";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						while($row=@mysql_fetch_array($sql)){
							?>
							<div class="mail_entry">
							<table align="center" width="100%" cellspacing="0">
							<tr><td><font style="font-size: 18px"><a href="?id=<?=$row['application_id'];?>"><?php echo($row['subject']);?></a></font></td><td rowspan="3" width="20%">
							<font style="font-size: 12px"><?php if($row['approval']==1)echo('Approved'); else if($row['approval']==2) echo('Not Approved'); else if($row['approval']==0) echo('Pending');?></font></td></tr>
							<tr><td><font style="font-size: 12px">Dated : <?php echo($row['application_date']);?></font></td></tr>
							<tr><td><font style="font-size: 12px">To : <?php echo(getUserName($row['to_id']));?></font></td></tr>
							</table>
							</div>
							<?php
						}
					}else{
						echo('You did not created any Application till now');
					}
				}else if(isset($_GET['id']) && !empty($_GET['id'])){
					$app_id=$_GET['id'];
					$sql="select * from application where application_id='$app_id' and from_id='$user_id'";
					$sql=@mysql_query($sql);
					if(@mysql_num_rows($sql)){
						$sql=@mysql_fetch_array($sql);
						?>
						<table align="center" width="100%">
						<tr><td colspan="2" align="center"><h3><?php echo($sql['subject']);?></h3></td></tr>
						<tr><td width="25%">To</td><td><?php echo(getUserName($sql['to_id']));?></td></tr>
						<tr><td>Dated</td><td><?php echo($sql['application_date']);?></td></tr>
						<tr><td>Status</td><td><?php if($sql['approval']=='1') echo('Approved'); else if($sql['approval']=='0') echo('Pending'); else if($sql['approval']=='2') echo('Not Approved');?></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><?php echo($sql['body']);?></td></tr>
						</table>
						<?php
					}else{
						echo('Invalid Application');
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
		<script type="text/javascript" src="js.js"></script>
	</body>
</html>