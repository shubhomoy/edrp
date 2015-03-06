<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="/edrp/style.css" />
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../config.php';
			require_once '../function.php';
			require_once 'function.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];
			
			$check=checkAdminFeature($user_id);

		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
			<h3>Examination</h3>
			<hr />
			<?php
			getMenu($user_id);
			?>
			</div>
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>

		<script type="text/javascript">
			function checkField(id){
				var field=document.getElementById(id).value;
				if(field==''){
					alert('Field is Empty');
				}
			}
		</script>
		<script type="text/javascript" src="/edrp/ajax/ajax.js"></script>
		<script type="text/javascript" src="/edrp/js/jquery.js"></script>
	</body>
</html>