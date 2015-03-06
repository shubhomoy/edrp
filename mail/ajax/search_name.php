<?php
require_once '../../config.php';
session_start();
$user_id=$_SESSION['user_id'];
$name=$_GET['name'];
$sql="select user_id,name,user_type from user where name like '%$name%' and user_id!='$user_id' order by name asc";
$sql=@mysql_query($sql);
if(@mysql_num_rows($sql) && $name!=''){
	?>
	<table align="center" width="100%" cellspacing="0" cellpadding="0" border="0">
	<?php
	while($row=@mysql_fetch_array($sql)){
		$id=$row['user_id'];
		$uType=$row['user_type'];
		$post='Student';
		$sql2='';
		if($uType=='a'){
			$sql2="select post from admin_detail where admin_id='$id'";
		}else if($uType=='t'){
			$sql2="select post from teacher_detail where teacher_id='$id'";
		}

		if($uType!='s'){
			$sql2=@mysql_query($sql2);
			$sql2=@mysql_fetch_array($sql2);
			$post=$sql2['post'];
		}
		?>
		<tr><td>
		<a onclick="document.getElementById('name_search').value='<?php echo($row['name']);?>';  document.getElementById('to_id').value='<?php echo($row['user_id']);?>';" href="#"><?php echo($row['name']);?>
		<br />
		<font style="font-size:13px;">&nbsp&nbsp&nbsp<?php echo($post);?></font></a>
		</td></tr>
		<?php
	}
	?>
	</table>
	<?php
}else{
	echo('No Results Found');
}
?>