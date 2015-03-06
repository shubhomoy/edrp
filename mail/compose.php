<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<link rel="stylesheet" href="style.css" />
		<title>EdRP</title>
		<?php
		session_start();
		require_once '../config.php';
		require_once '../function.php';

		$user_id = $_SESSION['user_id'];
		$user_type = $_SESSION['user_type'];
		
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
				<h3>Mail - Compose</h3>
				<hr />
				<div class="menu_bar"><a href="compose.php">Compose</a><a href="index.php">Inbox</a>
				</div>

				<?php
				if(isset($_GET['id']) && !empty($_GET['id'])){
					$to_id=$_GET['id'];
					?>
				    	
					<table align="center" width="100%" border="0">
					<form action="send.php" method="post">
					<tr><td >To</td><td><input type="text" id="name_search" disabled="disabled"  size="60" value="<?php echo(getUserName($to_id));?>" /></td></tr>
					<tr><td >Subject</td><td><input type="text" name="subject" id="subject" size="60" /></td></tr>
					<tr><td colspan="2" ><textarea rows="10" cols="130" resize="none" name="msg_body" id="msg_body"></textarea></td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<input type="hidden" name="to_id" id="to_id" value="<?php echo($to_id);?>" />
					<tr><td></td><td><input type="submit" value="Send" class="std_btn"></td></tr>
					</form>
					</table>
					
					<?php
				}else if(!isset($_GET['mailId']) && !isset($_GET['q'])){
					// create a new mail
					?>
				<table align="center" width="100%" border="0">
					<form action="send.php" method="post">
					<tr><td >To</td><td><input type="text" autocomplete="off" name="to_msg" id="name_search" onkeyup="search_name()" size="60" /></td></tr>
					<tr><td >Subject</td><td><input type="text" name="subject" id="subject" size="60" /></td></tr>
					<tr><td colspan="2" ><textarea rows="10" cols="130" name="msg_body" resize="none" id="msg_body"></textarea></td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<input type="hidden" name="to_id" id="to_id" value="x" />
					<tr><td></td><td><input type="submit" value="Send" class="std_btn" /></td></tr>
					</form>
				</table>
				
				
				<?php
				}else if(isset($_GET['mailId']) && isset($_GET['q'])){
					$mail_id=$_GET['mailId'];
					if(checkMailIsValid($mail_id, $user_id) && $_GET['q']=='reply'){
						$sql="select from_id,subject from mail where mail_id='$mail_id'";
						$sql=@mysql_query($sql);
						$sql=@mysql_fetch_array($sql);
						$to_id=$sql['from_id'];
						$to_name=getUserName($to_id);
						$subject=$sql['subject'];
						?>
	
						
						<table align="center" width="100%" border="0">
						<form action="send.php" method="post">
						<tr><td >To</td><td><input type="text" id="name_search" disabled="disabled"  size="60" value="<?php echo($to_name);?>" /></td></tr>
						<tr><td >Subject</td><td><input type="text" name="subject" id="subject" size="60" value="Re : <?php echo($subject);?>" /></td></tr>
						<tr><td colspan="2" ><textarea rows="10" cols="130" resize="none" name="msg_body" id="msg_body"></textarea></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<input type="hidden" name="to_id" id="to_id" value="<?php echo($to_id);?>" />
						<tr><td></td><td><input type="submit" value="Send" class="std_btn"></td></tr>
						</form>
						</table>
						<?php
					}else{
						header('Location: compose.php');
					}
				}
				?>
				<div id="name_search_result"></div>
				<div class="notify-change" style="background:#B00B0B;color:#fff;">
					<?php
					if(isset($_SESSION['notifyChange']) && $_SESSION['notifyChange']!=-1){
						if($_SESSION['notifyChange']==0){
							$_SESSION['notifyChange']=-1;
							echo('Invalid Mailing ID. Message delivery failed');
						}else if($_SESSION['notifyChange']==1){
							$_SESSION['notifyChange']=-1;
							echo('Message Body Field was empty.');
						}
					}
					?>
				</div>
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
		<script type="text/javascript" src="function.js"></script>
	</body>
</html>