<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			require_once 'function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			
			$check=checkAdminFeature($user_id);
			if($user_type=='s'){
				header('Location:../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Student</h3>
				<hr />
				<?php
				if($user_type=='a')
					getMenu($user_id);
				else if($user_type=='t'){
					?>
					<div class="menu_bar"><a href="/edrp/examination/view/index.php?reg_no=<?=$_GET['rno'];?>">View Marks</a><a href="#">Attendance</a></div>
					<?php
				}
				if(isset($_GET['rno']) && !empty($_GET['rno'])){
					showStudentDetails($_GET['rno']);
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