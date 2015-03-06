<?php
require_once '../config.php';
require_once '../function.php';
$sub_name=$_POST['sub_name'];
$standard=$_POST['standard'];
if(trim($sub_name)==''){
	echo('Please Enter a Subject Name');
}
else if($standard==0){
	echo('Select a Standard/Class');
}else{
	$sub_name=strtoupper($sub_name);
	$sql="select subject_id from subjects where subject_name='$sub_name' and standard='$standard'";
	$sql=@mysql_query($sql);
	$res=@mysql_num_rows($sql);
	if(trim($sub_name)==''){
		echo('Please Enter a Subject Name');
	}else if($res==0){
		?>
		<table align="center" width="100%">
			<input type="hidden" id="sub_name_add" value="<?php echo($sub_name);?>" />
			<input type="hidden" id="standard_add" value="<?php echo($standard);?>" />
		<tr><td align="center">Are you sure you want to add <?php echo($sub_name);?> in standard <?php echo($standard);?>?</td></tr>
		<tr><td align="center"><input type="button" class="std_btn" value="Add Subject" onclick="add_subject()" /></td></tr>
		</table>
		<?php
	}else if($res!=0){
		echo('Subject Already Exists');
	}
}
?>
<script type="text/javascript" src="ajax.js"></script>