<?php
require_once '../function.php';

$user_id=$_SESSION['user_id'];
function getMenu($user_id){
	$check=checkAdminFeature($user_id);
	?>
	<div class="menu_bar">
	<?php
	if($check['exam_setup']==1){
		?>
		<a href="/edrp/examination/setup/">Examination Setup</a>
		<?php
	}
	if($check['update_marks']==1){
		?>
		<a href="/edrp/examination/insert/">Update Students' Marks</a>
		<?php
	}
	?>
	<a href="/edrp/examination/view/">View Students' Marks</a>
	</div>
	<?php
}
?>