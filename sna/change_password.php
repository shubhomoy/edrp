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
	if($user_type!='x')	//user is not of network admin type
		header('Location: ../error.php');
	?>
</head>
<body>
	<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
	<div id="container">
		<div class="container_body_main">
			<h3>Change Password</h3>
			<hr />
			<table width="100%" align="center">
				<tr><td width="25%">Old Password</td><td><input type="password" /></td></tr>
				<tr><td>New Password</td><td><input type="password" /></td></tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr><td></td><td><input type="button" value="Change Password" class="std_btn" /> (link not created)</td></tr>
			</table>
		</div>
		<div id="container_body_link">
			<?php
			require_once 'sna_links.php';
			?>
		</div>
	</div>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
</body>
</html>