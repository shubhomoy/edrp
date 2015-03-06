<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP - Mail </title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
		?>
	</head>
	<?php
	if(isset($_SESSION['notifyChange']) && $_SESSION['notifyChange']!=-1){
		?>
		<body onload="checkForChanges();">
		<?php
	}else{
		?>
		<body>
		<?php
	}
	?>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Mail</h3>
				<hr />
				<div class="menu_bar"><a href="compose.php">Compose</a><a href="index.php">Inbox</a>
				</div>
				<?php
				if(!isset($_GET['mailId'])){
					?>
					<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
					<?php
					$sql="select * from mail where to_id='$user_id' order by mail_id desc";
					$sql=@mysql_query($sql);
					while($row=@mysql_fetch_array($sql)){
						?>
						<tr class="mail_entry"><td><div class="mail_entry">
							<?php
							if($row['status']=='NR'){
								?>
								<strong>* <a href="?mailId=<?=$row['mail_id'];?>"><?php echo($row['subject']);?></a></strong>
								<?php
							}else{
								?><a href="?mailId=<?=$row['mail_id'];?>"><?php echo($row['subject']);?></a><?php
							}
							?>
							<br /><font style="font-size: 13px;">
							<?php echo(getUserName($row['from_id']));?> : <?php echo($row['msg_date']);?>
							</font></div>
							</td></tr>
						<?php
					}
					?></table>
					<?php
				}else if(isset($_GET['mailId']) && !isset($_GET['q'])){
					// read mail
					$mail_id=$_GET['mailId'];
					if(checkMailIsValid($mail_id,$user_id)){
						$sql="select * from mail where mail_id='$mail_id'";
						$sql=@mysql_fetch_array(@mysql_query($sql));
						?>
						<table align="center" width="100%">
						<tr><td width="15%"><strong>From</strong></td><td><?php echo(getUserName($sql['from_id']));?></td></tr>
						<tr><td></td><td><?php echo($sql['msg_date']);?></td></tr>
						<tr><td><strong>Subject</strong></td><td><?php echo($sql['subject']);?></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td colspan="2"><?php echo($sql['msg_body']);?></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><a href="compose.php?mailId=<?=$mail_id;?>&q=reply">Reply</a> | <a href="?mailId=<?=$sql['mail_id'];?>&q=del">Delete</a> | <a href="?mailId=<?=$sql['mail_id'];?>&q=mau">Mark as Unread</a></td></tr>
						</table>
						<?php
						$sql="update mail set status='R' where mail_id='$mail_id'";
						@mysql_query($sql);
					}else{
						header('Location: index.php');
					}
				}else if(isset($_GET['mailId']) && isset($_GET['q'])){
					$mail_id=$_GET['mailId'];
					if(checkMailIsValid($mail_id,$user_id)){
						if($_GET['q']=='mau'){	//mark as unread
							$sql="update mail set status='NR' where mail_id='$mail_id'";
							@mysql_query($sql);
							header('Location: index.php');
						}else if($_GET['q']=='del'){
							$sql="delete from mail where mail_id='$mail_id'";
							@mysql_query($sql);
							$_SESSION['notifyChange']='Message Deleted';
							header('Location:index.php');
						}
					}else{
						header('Location: index.php');
					}
				}
				?>
				</table>
				<div class="notify-change">
					<?php
					if(isset($_SESSION['notifyChange']) && $_SESSION['notifyChange']!=-1 && !isset($_GET['q'])){
						$text=$_SESSION['notifyChange'];
						$_SESSION['notifyChange']=-1;
						echo($text);
					}
					?>
				</div>
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id,$user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
	</body>
</html>