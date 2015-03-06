<?php
function getMenu($user_id){
	$check=checkAdminFeature($user_id);
	?>
	<div class="menu_bar">
	<?php
	if($check['routine']){
		?>
		<a href="routine.php?view">View Routine</a><a href="routine.php?set">Set Routine</a>
		<?php
	}
	if($check['class_administration']){
		?>
		<a href="classadministration.php">Class Administration</a>
		<?php
	}
	if($check['academic']){
		?>
		<a href="?addsubject">Add New Subject</a>
		<?php
	}?>
	<a href="/edrp/examination/">Examination</a>
	</div>
	<?php
}
?>