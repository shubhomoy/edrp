<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="../style.css" />
	<title>Add Institute Administrators</title>
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
<body>
	<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
	<div id="container">
		<div class="container_body_main">
			<h3>View Institute's Administrators' Details</h3>
			<hr />
			<div class="menu_bar">
				<a href="add_admin.php?aa">Add Administrator</a><a href="vadmin.php">View Administrator's Details</a>
			</div>
			<?php
			if(isset($_GET['id'])){
				//user have searched and clicked on a particular result
				$admin_id=$_GET['id'];
				
					?>
					<table align="left" width="100%" border="0" cellspacing="0">
					<tr bgcolor="#ebf2ff"><td align="left" width="25%"><strong>Name</strong></td><td><?php echo(get_user_name($admin_id,'a','name'));?><td></td></tr>
					<tr><td><strong>Post</strong></td><td><?php echo(get_user_name($admin_id, 'a', 'post'));?></td></tr>
					<tr bgcolor="#ebf2ff"><td align="left" width="25%"><strong>User ID</strong></td><td><?php echo($admin_id);?></td></tr>
					<tr><td align="left"><strong>Address</strong></td><td><?php echo(get_user_name($admin_id,'a','address'));?></td></tr>
					<tr bgcolor="#ebf2ff"><td align="left"><strong>Contact Number</strong></td><td>+91<?php echo(get_user_name($admin_id,'a','contact'));?></td></tr>		
					<tr><td colspan="2">Possess Features</td></tr>
					<?php
					$sql="select * from admin_features where admin_id='$admin_id'";
					$sql=@mysql_query($sql);
					while($row=@mysql_fetch_array($sql)){
						if($row['routine']==1){
							?>
							<tr><td></td><td>Decide and Make Routines</td></tr>
							<?php
						}
						if($row['approve_application']==1){
							?>
							<tr><td></td><td>Approve Applications</td></tr>
							<?php
						}
					}
					?>
					<tr><td colspan="2"><hr /></td></tr>
					<tr><td></td><td><a href="#">Edit Details</a> (Link not created yet)</td></tr>
				</table>
					<?php
				
			}else{
				?>
				<input type="text" size="70" placeholder="Search Administrator's Name" autofocus="true" id="search_query" onkeyup="search_admin()" /><br />
				<div id="admin_search_result"></div><hr />
				<div id="admin_list">
				<?php
				$sql="select name,admin_id from admin_detail where admin_id!='$user_id' order by name ASC";
				$sql=@mysql_query($sql);
				?>
				<table width="100%" align="center"><ul>
				<?php
				while($row=@mysql_fetch_array($sql)){
					?>
					<tr><td><li><a href="?id=<?=$row['admin_id'];?>"><?php echo($row['name']);?></a></li></td></tr>
					<?php
				}
				?></ul>
				</table>
				</div>
				<?php
			}
			?>
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