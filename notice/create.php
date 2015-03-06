<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="../style.css" />
		<meta http-equiv="x-ua-compatible" content="IE=9,chrome=1" >
		<title>EdRP</title>
		<?php
			session_start();
			require_once '../function.php';
			require_once '../config.php';
			
			$user_id=$_SESSION['user_id'];
			$user_type=$_SESSION['user_type'];

			$check=checkAdminFeature($user_id);
			if($check['notice']!=1){
				header('Location:index.php');
			}
		
		?>
	</head>
	<body>
		<div id="header">EdRP <font size="4">- <?php echo(get_ins_name());?></font></div>
		<div id="container">
			<div class="container_body_main">
				<h3>Notices - Create New</h3>
				<hr />
				<div class="menu_bar"><a href="index.php">View</a></div>

				<table align="center" width="100%" cellspacing="0">
					<tr><td colspan="2"><font style="font-size:13px;">Fields marked with (*) are mandatory</font></td></tr>
					<tr><td width="25%"><strong>Notice for</strong></td><td><select onchange="noticeToChange('noticeFor');" onafterupdate="noticeToChange('noticeFor');" id="noticeFor">
						
						<?php
						if($user_type=='a'){
							?>
							<option value="all">All</option>
							<option value="a">Administrators</option>
							<?php
						}
						?>
						<option value="t">Teachers</option>
						<option value="s">Students</option>
					</select></td></tr>
					<tr id="pStandard" style="display: none;"><td><strong>Particular Standard</strong></td><td>
						<select id="pStandardSelector"  onclick="noticeToChange('pStandard');">
							<option value="0">No</option>
							<?php
							$sql="select distinct standard from class_detail";
							$sql=@mysql_query($sql);
							if(@mysql_num_rows($sql)){
								while($row=@mysql_fetch_array($sql)){
									?>
									<option value="<?php echo($row['standard']);?>"><?php echo($row['standard']);?></option>
									<?php
								}
							}
							?>
						</select></td></tr>
					<tr id="pClass" style="display: none;"><td><strong>Particular Section/Batch</strong></td><td>
						<span id="pClassContainer"></span></td></tr>
						<tr><td><strong>Heading *</strong></td><td><input type="text" style="width: 100%;" id="noticeHeading" /></td></tr>
						<tr><td colspan="2"><strong>Notice Body *</strong></td></tr>
						<tr><td></td><td><textarea rows="6" style="width: 100%;" id="noticeBody"></textarea></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><input type="button" id="reviewBtn" value="Review Notice" class="std_btn" onclick="publishNotice();" /></td></tr>
				</table>
				<div class="review-screen"></div>
			</div>
			
			<div id="container_body_link">
				<?php
				getLinks($user_id, $user_type);
				?>
			</div>
		</div>
		<script type="text/javascript" src="../ajax/ajax.js"></script>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/js.js"></script>
		<script type="text/javascript" src="ajax.js"></script>
	</body>
</html>