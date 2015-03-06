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
			
			$check=checkAdminFeature($user_id);
			
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Notices</h3>
				<hr />
				<div class="menu_bar"><a href="index.php">View</a>
					<?php
					if($check['notice']==1){
						?>
						<a href="create.php">Create New</a>
						<?php
					}
					?>
				</div>
				<?php
				$notice_id=$_GET['id'];
				if($user_type!=getNoticeDetails($notice_id,'user_type') && getNoticeDetails($notice_id, 'user_type')!='al'){
					echo('Sorry No Notice Found');
				}else if(isset($_GET['delete']) && isset($_GET['id']) && $user_id==getNoticeDetails($_GET['id'],'from_id') ){
					$sql="delete from notice where notice_id='$notice_id' and from_id='$user_id'";
					@mysql_query($sql);
					$_SESSION['notifyChange']='Notice Deleted';
					header('Location:index.php');
				}else{
					?>
					<table align="center" width="100%" border="0">
						<tr><td align="center"><font style="font-size: 25px;"><b><?php echo(getNoticeDetails($notice_id, 'notice_heading'));?></b></font></td></tr>
						<tr><td align="center"><font style="font-size: 13px;"><?php echo(getNoticeDetails($notice_id, 'notice_date'));?></font></td></tr>
						<tr><td align="center"><font style="font-size: 13px;"><?php echo('Issued By: '.getUserName(getNoticeDetails($notice_id, 'from_id')));?></font></td></tr>
						<tr><td><hr /></td></tr>
						<tr><td><?php echo(getNoticeDetails($notice_id, 'notice_body'));?></td></tr>
						<tr><td><hr /></td></tr>
						<tr><td align="center"><a href="createPdf.php?id=<?=$notice_id;?>&output=p">Preview</a> | <a href="createPdf.php?id=<?=$notice_id;?>&output=d">Download</a> | <?php 
						if(getNoticeDetails($notice_id, 'from_id')==$user_id){?><a href="?delete&id=<?=$notice_id;?>">Delete</a><?php }?></td></tr>
					</table>
					<?php
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