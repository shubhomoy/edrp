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
			if($user_type=='s'){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Application Approve</h3>
				<hr />
				<div class="menu_bar"><a href="index.php">View</a><a href="create.php">Create</a></div>
				
				<?php
				$check=checkAdminFeature($user_id);
				if(isset($_GET['id'])){
					$id=$_GET['id'];

					$sql="select * from application where application_id='$id'";
					$sql=@mysql_query($sql);
					$flag=0;
					if(@mysql_num_rows($sql)){
						$sql=@mysql_fetch_array($sql);
						if($sql['to_id']==$user_id){
							if(($sql['from_type']=='t' && $check['approve_application_teacher']==1) ||
								($sql['from_type']=='s' && $check['approve_application_student']==1) || 
								($sql['from_type']=='a' && $check['approve_application_student']==1)){
									$flag=1;
									if(isset($_GET['q']) && !empty($_GET['q'])){
										if($_GET['q']==1){
											$sql2="update application set approval=1 where application_id='$id'";
											@mysql_query($sql2);
										}else if($_GET['q']=2){
											$sql2="update application set approval=2 where application_id='$id'";
											@mysql_query($sql2);
										}
									}
									?>
									<table align="center" width="100%">
									<tr><td colspan="2" align="center"><h3><?php echo($sql['subject']);?></h3></td></tr>
									<tr><td width="25%">From</td><td><?php echo(getUserName($sql['from_id']));?></td></tr>
									<tr><td>Dated</td><td><?php echo($sql['application_date']);?></td></tr>
									<tr><td>Status</td><td><?php if($sql['approval']=='1') echo('Approved'); else if($sql['approval']=='0') echo('Pending'); else if($sql['approval']=='2') echo('Not Approved');?></td></tr>
									<tr><td colspan="2"><hr /></td></tr>
									<tr><td></td><td><?php echo($sql['body']);?></td></tr>
									<tr><td colspan="2"><br /><br /></td></tr>
									<tr><td></td><td><?php 
									$sql2="select approval from application where application_id='$id'";
									$sql2=@mysql_fetch_array(@mysql_query($sql2));
									if($sql2['approval']==0){
										?><a href="?id=<?=$sql['application_id'];?>&q=1">Approve</a> | <a href="?id=<?=$sql['application_id'];?>&q=2">Decline</a> | <a href="#">Forward</a><?php
									}else if($sql2['approval']==1){
										?>Approved
										<?php
									}else if($sql2['approval']==2){
										?>Declined
										<?php
									}?> </td></tr>
									</table>
									<?php
									
								}
						}
					}
					if($flag==0)
						echo('No Such Application Found');
				}else{
					if($check['approve_application_teacher']){
						$sql="select application_id,subject,application_date,from_id,approval from application where to_id='$user_id' and (approval=0 or approval=2) and (from_type='t' || from_type='a') order by application_id desc";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							while($row=@mysql_fetch_array($sql)){
								?>
								<div class="mail_entry">
								<table align="center" width="100%" cellspacing="0">
								<tr><td><font style="font-size: 18px"><a href="?id=<?=$row['application_id'];?>"><?php echo($row['subject']);?></a></font></td><td rowspan="3" width="20%">
								<font style="font-size: 12px"><?php if($row['approval']==1)echo('Approved'); else if($row['approval']==2) echo('Not Approved'); else if($row['approval']==0) echo('Pending');?></font></td></tr>
								<tr><td><font style="font-size: 12px">Dated : <?php echo($row['application_date']);?></font></td></tr>
								<tr><td><font style="font-size: 12px">From : <?php echo(getUserName($row['from_id']));?></font></td></tr>
								</table>
								</div>
								<?php
							}
						}else{
							echo('No Pending Application for Approval');
						}
					}
					if($check['approve_application_student']){
						$sql="select application_id,subject,application_date,from_id,approval from application where to_id='$user_id' and (approval=0 or approval=2) and from_type='s' order by application_id desc";
						$sql=@mysql_query($sql);
						if(@mysql_num_rows($sql)){
							while($row=@mysql_fetch_array($sql)){
								?>
								<div class="mail_entry">
								<table align="center" width="100%" cellspacing="0">
								<tr><td><font style="font-size: 18px"><a href="?id=<?=$row['application_id'];?>"><?php echo($row['subject']);?></a></font></td><td rowspan="3" width="20%">
								<font style="font-size: 12px"><?php if($row['approval']==1)echo('Approved'); else if($row['approval']==2) echo('Not Approved'); else if($row['approval']==0) echo('Pending');?></font></td></tr>
								<tr><td><font style="font-size: 12px">Dated : <?php echo($row['application_date']);?></font></td></tr>
								<tr><td><font style="font-size: 12px">From : <?php echo(getUserName($row['from_id']));?></font></td></tr>
								</table>
								</div>
								<?php
							}
						}else{
							echo('No Pending Application for Approval');
						}
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