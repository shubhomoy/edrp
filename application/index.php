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
				<h3>Application</h3>
				<hr />
				<div class="menu_bar"><a href="index.php">View</a><a href="create.php">Create</a></div>
				<?php
				if($user_type!='s'){
					?>
					<ul>
						<li><a href="my_application.php">My Applications</a></li>
						<?php
						$check=checkAdminFeature($user_id);
						if($user_type=='t'){
							if($check['approve_application_student']==1){
								?>
								<li><a href="approve.php">Approve Application</a></li>
								<?php
							}
						}else if($user_type=='a'){
							if($check['approve_application_teacher']){
								?>
								<li><a href="approve.php">Approve Application</a></li>
								<?php
							}
						}
						?>
					</ul>
					<?php
				}else if($user_type=='s'){
					?>
					<ul>
						<li><a href="my_application.php">My Applications</a></li>
					</ul>
					<?php
				}else{
					header('Location:../index.php');
				}
				?>
				
				<div class="notify-change">
					<?php
					if(isset($_SESSION['notifyChanges']) && $_SESSION['notifyChanges']!=-1){
						echo($_SESSION['notifyChanges']);
						$_SESSION['notifyChanges']=-1;
					}
					?>
				</div>


				<?php
				getGuide('../guideTips/application-guide.html');
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