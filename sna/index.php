<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../function.php';
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			if($user_type!='x')
				header('Location: ../error.php');
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Welcome Back</h3>
				<hr />
				Select the desired option
			</div>
			<div id="container_body_link">
				<?php
				require_once('sna_links.php');
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
	</body>
</html>
