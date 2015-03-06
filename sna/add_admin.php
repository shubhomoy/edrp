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
			<h3>Add Institute's Administrators</h3>
			<hr />
			<div class="menu_bar">
				<a href="?aa">Add Administrator</a><a href="vadmin.php">View Administrator's Details</a>
			</div>
			<?php
			if(isset($_GET['aa'])){
				//user wants to add administrator
				?>
				<table align="left" width="100%" border="0" cellspacing="0">
				<tr><td width="25%">Administrator's Name</td><td><input type="text" autofocus="true" size="40" id="admin_name" /></td></tr>
				<tr><td width="25%">Contact Number</td><td>+91<input type="text" size="36" maxlength="10" id="contact_no" onkeyup="check_contact_no()" /></td></tr>
				<tr><td width="25%">Address</td><td><input type="text" size="40" id="admin_addr" /></td></tr>
				<tr><td>Designation</td><td><input type="text" size="40" id="post" /></td></tr>
				<tr><td colspan="2">Add Features</td></tr>
				<tr><td></td><td><input type="checkbox" id="routine" />Make Routine<br />
					<input type="checkbox" id="hire" />Recruit Staff<br />
					<input type="checkbox" id="student" />Students' Registration<br />
					<input type="checkbox" id="approve_application_teacher" />Approve Staff's Applications<br />
				<!--	<input type="checkbox" id="approve_application_student" />Approve Student's Applications<br />
					<input type="checkbox" id="assignUnassignClassTeacher" />Assign/Unassign Class Teacher<br />
					<input type="checkbox" id="assignUnassignTeacherSubject" />Assign/Unassign Teacher's Subject<br />
					<input type="checkbox" id="classAdministration" />Class Administration<br />
					<input type="checkbox" id="academic" />Academics<br />
					<input type="checkbox" id="notice" />Publish Notices<br />
					<input type="checkbox" id="assignments" />Upload Assignments<br />
					<input type="checkbox" id="examSetup" />Examination Setup<br />
					<input type="checkbox" id="updateMarks" />Update Student's Marks<br />-->
				</td></tr>
				<tr><td colspan="2"><hr /></td></tr>
				<tr><td></td><td><input type="button" value="Review" class="std_btn" onclick="review_admin()" id="reviewBtn" /></td></tr>
				</table>
				<div id="add_response"></div>
				<?php
			}
			?>

			<div class="review-screen"></div>
		</div>
		<div id="container_body_link">
			<?php
			require_once 'sna_links.php';
			?>
		</div>
	</div>
	<script type="text/javascript" src="../ajax/ajax.js"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="function.js"></script>
</body>
</html>