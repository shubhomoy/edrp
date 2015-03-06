<?php
require_once '../function.php';
function getMenu($user_id){
	$check=checkAdminFeature($user_id);
	?>
	<div class="menu_bar">
	<a href="index.php">Student List</a>
	<?php
	if($check['student']==1){
		?><a href="register.php">Registration</a><?php
	}
	?>
	</div><?php
}
?>