<?php
require_once '../../config.php';

$name=$_POST['name'];
$reg_no=$_POST['reg_no'];
$addr=$_POST['addr'];
$contact_no=$_POST['contact_no'];
$standard=$_POST['standard'];

$sql="select student_id from student_detail where reg_no='$reg_no'";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql)){
	echo('0');
}else{
	if(trim($name)!='' && trim($addr)!='' && trim($reg_no!=0) && trim($contact_no)!='' && $standard!=0){
		?>
		<strong>Review Details</strong><br />
		<?php
		echo('Name : '.$name.'<br/>');
		echo('Registration No : '.$reg_no.'<br/>');
		echo('Standard : '.$standard.'<br/>');
		echo('Address : '.$addr.'<br/>');
		echo('Contact No. : '.$contact_no.'<br/>');
	}else{
		echo('1');
	}
}
?>