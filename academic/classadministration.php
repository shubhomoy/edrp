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
			$check=$check['class_administration'];
			if($check!=1){
				header('Location: ../index.php');
			}
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
				<?php
				if((!isset($_GET['create'])) && (!isset($_GET['modify']))){
				?>
				<h3>Class Administration</h3>
				<hr />
				
				<div class="menu_bar">
					<a href="classadministration.php">Class Administration</a></div>
				<a href="?create">Create/Allot a new Class/Standard in <?php echo(get_ins_name());?></a><br />
				<a href="?modify">Modify/View an existing Class/Standard</a>
				<?php
				if(isset($_SESSION['class_added'])){
					?>
					<br /><br /><p><font color="red"><?php
					if($_SESSION['class_added']==1){
						?>A New Class has been Added<?php
					}else{
						?>An existing Class Already Exists.<?php
					}?></font></p>
					<?php
					unset($_SESSION['class_added']);
				}
				}else if(isset($_GET['create'])){
					?>
					<h3>Class Administration - Create</h3>
					<hr />
					<div class="menu_bar"><a href="routine.php?view">View Routine</a><a href="routine.php?set">Set Routine</a><a href="classadministration.php">Class Administration</a></div>
	
					
					<table align="center" width="100%">
						<tr><td colspan="2"><font style="font-size:13px;">Fields marked with (*) are mandatory</font></td></tr>
						<tr><td width="25%"><strong>Standard</strong></td><td><select id="standard">
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select></td></tr>
						<tr><td><strong>Section/Batch *</strong></td><td><input type="text" size="10" maxlength="9" id="section"  /></td></tr>
						<tr><td><strong>Total Seating Capacity *</strong></td><td><input type="text" id="seat" maxlength="4" size="10"
							onkeyup="seatCapacityCheck()" /></td></tr>
						<tr><td colspan="2"><strong>Class Duration *</strong></td></tr>
						<tr><td align="right">From</td><td><select id="from_hr" >
							<option value="1">01</option>
							<option value="2">02</option>
							<option value="3">03</option>
							<option value="4">04</option>
							<option value="5">05</option>
							<option value="6">06</option>
							<option value="7">07</option>
							<option value="8">08</option>
							<option value="9">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option></select> : <select id="from_min">
								<?php
								for($i=0;$i<=59;$i++){
									if($i>=0 && $i<=9){
										?>
										<option value="<?php echo($i);?>">0<?php echo($i); ?></option>
										<?php
									}else{
									?><option><?php echo($i); ?></option>
								<?php }}
								?>
							</select> <select id="from_am_pm"><option>AM</option><option>PM</option></select></td></tr> 
						<tr><td align="right">To</td><td><select id="to_hr"><option value="1">01</option>
							<option value="2">02</option>
							<option value="3">03</option>
							<option value="4">04</option>
							<option value="5">05</option>
							<option value="6">06</option>
							<option value="7">07</option>
							<option value="8">08</option>
							<option value="9">09</option>
							<option>10</option>
							<option>11</option>
							<option>12</option></select> : <select id="to_min">
								<?php
								for($i=0;$i<=59;$i++){
									if($i>=0 && $i<=9){
										?>
										<option value="<?php echo($i);?>">0<?php echo($i); ?></option>
										<?php
									}else{
									?><option><?php echo($i); ?></option>
								<?php }}
								?>
							</select> <select id="to_am_pm"><option>AM</option><option>PM</option></select></td></tr>
							<tr><td colspan="2"><hr /></td></tr>
							<tr><td></td><td><button class="std_btn" onclick="checkClass()" id="reviewBtn">Validate</button></td></tr>
					</table>
					<hr />

					<div class="review-screen"></div>

					<?php
					getGuide('../guideTips/createClass-guide.html');
				}else if(isset($_GET['modify'])){
					?>
					<h3>Class Administration - Modify/View Class</h3>
					<hr />
					<div class="menu_bar"><a href="classadministration.php">Class Administration</a></div>
					<table align="center" width="100%">
						<form action="search_class.php" method="post">
						<tr><td width="20%">Standard</td><td><input type="text" autocomplete="off" name="standard" maxlength="2" /></td></tr>
						<tr><td>Section/Batch</td><td><input type="text" autocomplete="off" name="section" maxlength="5" /></td></tr>
						<tr><td colspan="2"><hr /></td></tr>
						<tr><td></td><td><input type="submit" name="searchClass" class="std_btn" value="Search" /></td></tr>
						</form>
					</table>
					<?php
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
		<script type="text/javascript" src="function.js"></script>
		<script type="text/javascript">
			function seatCapacityCheck(){
				input=document.getElementById('seat').value;
				if(!(input>=0) && !(input<=9)){
					document.getElementById('seat').value='';
				}
			};
			function periodCheck(){
				input=document.getElementById('period').value;
				if(!(input>=0) && !(input<=9)){
					document.getElementById('period').value='';
				}
			};
			function breakCheck(){
				input=document.getElementById('interval').value;
				if(!(input>=0) && !(input<=9)){
					document.getElementById('interval').value='';
				}
			};
			
			function hide(){
				$("#result").fadeOut();
				$("#result_cancel").fadeOut();
				$("#result_container").fadeOut();
				document.getElementById('validate_btn').disabled=false;
			}
		</script>
	</body>
</html>