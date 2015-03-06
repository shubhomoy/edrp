<?php
require_once '../../config.php';
require_once '../../function.php';


$user_type=$_POST['user_type'];
$class_id=$_POST['class_id'];
$standard=$_POST['standard'];
$noticeHeading=$_POST['noticeHeading'];
$noticeBody=$_POST['noticeBody'];
session_start();
$user_id=$_SESSION['user_id'];

if(!isset($_POST['submit'])){
?>
<center><h3>Review</h3></center>
<center><h4><?php if(trim($noticeHeading)=='') echo('Null Heading'); else echo($noticeHeading);?></h4></center>
<hr />
<?php
if(trim($noticeHeading)!='' && trim($noticeBody!='')){
	?>
<table align="center" width="100%" cellspacing="0" cellpadding="3">
	<tr><td width="25%">Notice For</td><td>
		<?php
		if($user_type=='all')
			echo('All');
		else if($user_type=='a')
			echo('Administrators');
		else if($user_type=='t')
			echo('Teachers');
		else if($user_type=='s')
			echo('Students');
		?>
	</td></tr>
	<?php
	if($user_type=='s'){
		?>
		<tr><td>Particular Standard</td><td>
			<?php
			if($standard!=0)
				echo($standard);
			else {
				echo('No');
			}
			?>
		</td></tr>
		<?php
		if($class_id!=0){
			?>
			<tr><td>Particular Standard/Class</td><td>
				<?php
				echo(getClassDetail($class_id, 'standard').' - '.getClassDetail($class_id, 'batch'));
				?>
			</td></tr>
			<?php
		}
	}
	?>
	<tr><td colspan="2">Notice</td></tr>
	<tr><td></td><td><?php echo(nl2br($_POST['noticeBody']));?></td></tr>
	<tr><td colspan="2"><hr /></td></tr>
	<form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<input type="hidden" name="user_type" value="<?php echo($user_type);?>" />
	<input type="hidden" name="standard" value="<?php echo($standard);?>" />
	<input type="hidden" name="class_id" value="<?php echo($class_id);?>" />
	<input type="hidden" name="noticeHeading" value="<?php echo($noticeHeading);?>" />
	<input type="hidden" name="noticeBody" value="<?php echo($noticeBody);?>" />
	<tr><td></td><td><input type="submit" value="Publish" class="std_btn" name="submit" /></td></tr></form>
</table>
<?php
}else{
	echo('Some Fields are Empty');
}
}else if(isset($_POST['submit'])){
	$noticeBody=nl2br($noticeBody);
	$sql="insert into notice set from_id='$user_id', user_type='$user_type', class_id='$class_id', standard='$standard',notice_heading='$noticeHeading', notice_body='$noticeBody',notice_date=NOW()";
	$sql=@mysql_query($sql);
	if($sql>0){
		$_SESSION['notifyChange']=1;
		$_SESSION['notifyChange']='Notice Published';
		header('Location:../index.php');
	}
}



