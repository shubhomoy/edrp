<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../function.php';
			require_once '../config.php';
			require_once 'function.php';
			
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
				<h3>Notices</h3>
				<hr />
				<?php
				$sql="select notice from admin_features where admin_id='$user_id'";
				$sql=@mysql_query($sql);
				$sql=@mysql_fetch_array($sql);
				?>
				<div class="menu_bar"><a href="index.php">View</a>
					<?php
					if($sql['notice']==1){
						?>
						<a href="create.php">Create New</a>
						<?php
					}
					?>
				</div>
				<?php
				if($user_type=='a')
				showNotices('a',0,0);
				else if($user_type=='t')
				showNotices('t',0,0);
				else if($user_type=='s'){
					showNotices('s',0,0);
					showNotices('s',5,22);
				}
				?>

				<div class="notify-change">
					<?php
					if(isset($_SESSION['notifyChange']) && $_SESSION['notifyChange']!=-1){
						echo($_SESSION['notifyChange']);
						$_SESSION['notifyChange']=-1;
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
	</body>
</html>