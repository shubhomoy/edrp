<?php
require_once '../../config.php';

$ins_name=$_POST['ins_name'];
$ins_contact_no=$_POST['ins_contact_no'];
$ins_addr=$_POST['ins_addr'];

session_start();
if(isset($_POST['submit'])){
	$sql="update school_detail set school_name='$ins_name', address='$ins_addr', contact_no='$ins_contact_no'";
	$sql=@mysql_query($sql);
	
	$_SESSION['notifyChanges']='Institute Details Updated';
	header('Location:../ins_details.php');

}else if(trim($ins_name)!='' && trim($ins_addr)!='' && trim($ins_contact_no)!='' && !isset($_POST['submit'])){

?>
<p align="center">Review</p>
<hr />
<table align="center" width="100%">
	<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<tr><td width="25%">Institute Name</td><td><?php echo($ins_name);?></td></tr>
	<tr><td>Address</td><td><?php echo($ins_addr);?></td></tr>
	<tr><td>Contact Number</td><td><?php echo($ins_contact_no);?></td></tr>
	<tr><td colspan="2"><hr /></td></tr>
	<tr><td></td><td><input type="submit" value="Make Changes" class="std_btn" name="submit">

	<input type="hidden" name="ins_name" value="<?php echo($ins_name);?>">
	<input type="hidden" name="ins_addr" value="<?php echo($ins_addr);?>">
	<input type="hidden" name="ins_contact_no" value="<?php echo($ins_contact_no);?>">
	</form>
</table>
<?php
}else{
	echo('Some fields are empty');
}