<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			require_once '../config.php';
			require_once '../function.php';
			session_start();
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			if($user_type!='x')
				header('Location: ../error.php');
		?>
	</head>
	<?php
	if(isset($_SESSION['notifyChanges']) && $_SESSION['notifyChanges']!=-1){
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
				<?php
				$sql="select * from school_detail ";
				$sql=@mysql_fetch_array(@mysql_query($sql));
				if(isset($_GET['q']) && $_GET['q']=='edit'){
					?>
					<h3>Institute Details - Edit</h3>
					<hr />
					<table align="left" width="100%" border="0" cellspacing="0">
					<tr><td><strong>Institute Name</strong></td><td><input type="text" id="ins_name" size="60" value="<?php echo($sql['school_name']);?>" /></td></tr>
					<tr><td width="25%"><strong>Contact Number</strong></td><td>+91<input id="ins_contact_no" type="text" maxlength="10" onkeyup="check_contact_no()" id="contact_no" value="<?php echo($sql['contact_no']);?>" /></td></tr>
					<tr><td><strong>Address</strong></td><td><input type="text" id="ins_addr" name="ins_addr" size="60" value="<?php echo($sql['address']);?>" /></td></tr>
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td></td><td><input type="button" value="Review" id="reviewBtn" class="std_btn" onclick="reviewInsDetails()" /></td></tr>
					</table>
					<?php
				}else{
					?>
					<h3>Institute Details</h3>
					<hr />
					<table align="left" width="100%" border="0" cellspacing="0">
					<tr><td align="left" width="25%"><strong>Institutional's Name</strong></td><td><?php echo(get_ins_name());?></td></tr>
					<tr><td align="left"><strong>Address</strong></td><td><?php echo($sql['address']);?></td></tr>
					<tr><td align="left"><strong>Contact Number</strong></td><td>+91<?php echo($sql['contact_no']);?></td></tr>
				
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td></td><td><a href="?q=edit">Edit Details</a></td></tr>
					</table>
					<?php
				}
				?>
				<div class="review-screen"></div>
				<div class="notify-change">
					<?php
					if(isset($_SESSION['notifyChanges']) && $_SESSION['notifyChanges']!=-1){
						echo($_SESSION['notifyChanges']);
						$_SESSION['notifyChanges']=-1;
					}
					?>
				</div>
			</div>
			<div id="container_body_link">
				<?php
				require_once 'sna_links.php';
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/js.js"></script>
		<script type="text/javascript" src="function.js"></script>
	</body>
</html>