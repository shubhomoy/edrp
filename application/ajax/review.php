<?php
require_once '../../function.php';
require_once '../../config.php';
session_start();
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];


$to_id=$_POST['to_id'];
$subject=$_POST['subject'];
$body=nl2br($_POST['body']);

if(isset($_POST['submit'])){
	if(trim($_POST['subject'])!='' && trim($_POST['body'])!=''){
		$subject=$_POST['subject'];
		$body=nl2br($_POST['body']);
		$to_id=$_POST['to_id'];
		$sql="insert into application set from_id='$user_id', to_id='$to_id', subject='$subject', application_date=NOW(), body='$body',from_type='$user_type'";
		@mysql_query($sql);
		$_SESSION['notifyChanges']='Application Sent';
		header('Location:../index.php');
	}
}else{

?>


<table align="center" width="100%">
	<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<tr><td colspan="2" align="center">Application</td></tr>
	<tr><td width="25%">To</td><td><?php echo(getUserName($to_id));?></td></tr>
	<tr><td>Subject</td><td><?php echo($subject);?></td></tr>
	<tr><td colspan="2"><hr /></td></tr>
	<tr><td></td><td><?php echo($body);?></td></tr>
	<tr><td colspan="2"><br /><br /></td></tr>


	<input type="hidden" name="to_id" value="<?php echo($to_id);?>">
	<input type="hidden" name="subject" value="<?php echo($subject);?>">
	<input type="hidden" name="body" value="<?php echo($body);?>">
	<tr><td></td><td><input type="submit" name="submit" class="std_btn" value="Send" /></td></tr>
	</form>
</table>
<?php
}
?>

