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
			
			$check=checkAdminFeature($user_id);
			if($check['routine']!=1){
				header('Location: ../index.php');
			}
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Routine</h3>
				<hr />
				
				<div class="menu_bar"><a href="?view">View Routine</a><a href="?set">Set Routine</a></div>
				<?php
				if(isset($_GET['view'])){
					$sql="select standard,batch,class_id from class_detail  order by standard ASC";
					$sql=@mysql_query($sql);
					$res=@mysql_num_rows($sql);
					if($res==0){
						echo('No Class/Standard have been added. First Create a Class/Standard in '.get_ins_name());
					}else{
						?>
						<table align="center" width="100%" cellspacing="0" cellpadding="5">
							<tr><td>View Routine</td></tr>
							<?php
							while($row=@mysql_fetch_array($sql)){
								$class_id=$row['class_id'];
								$sql2="select distinct class_id from routine where class_id='$class_id' ";
								$sql2=@mysql_query($sql2);
								$notSet=1;
								if(@mysql_num_rows($sql2)==0){
									$notSet=0;
								}?>
								<tr <?php if($notSet==0) echo('bgcolor="#FFD3CF"');?>><td><a href="view_routine.php?id=<?=$row['class_id'];?>"><?php echo($row['standard'].' - '.$row['batch']);?></a><?php if($notSet==0)echo(' <i>(Routine not Set)</i>');?></td></tr>
								<?php
							}
							?>
						</table>
						<?php
					}
				}else if(isset($_GET['set'])){
					$sql="select standard,batch,class_id from class_detail  order by standard ASC";
					$sql=@mysql_query($sql);
					$res=@mysql_num_rows($sql);
					if($res==0){
						echo('No Class/Standard have been added. First Create a Class/Standard in '.get_ins_name());
					}else{
						?>
						<table align="center" width="100%" cellpadding="5" cellspacing="0">
							<tr><td>Set Routine For...</td></tr>
							<?php
							while($row=@mysql_fetch_array($sql)){
								$class_id=$row['class_id'];
								$sql2="select distinct class_id from routine where class_id='$class_id' ";
								$sql2=@mysql_query($sql2);
								$notSet=1;
								if(@mysql_num_rows($sql2)==0){
									$notSet=0;
								}?>
								<tr><td <?php if($notSet==0) echo('bgcolor="#FFD3CF"');?>><a href="set_routine.php?id=<?=$row['class_id'];?>"><?php echo($row['standard'].' - '.$row['batch']);?></a><?php if($notSet==0)echo(' <i>(Routine not Set)</i>');?></td></tr>
								<?php
							}
							?>
						</table>
						<?php
					}
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
	</body>
</html>