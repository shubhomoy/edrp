<?php
require_once '../config.php';
session_start();

$s_name=$_GET['s_name'];
$sql="select name,admin_id from admin_detail where name like'%$s_name%' order by name ASC";
$sql=@mysql_query($sql);
$res=@mysql_num_rows($sql);
if($res!=0 && !empty($s_name)){
	?>
	<ul>
	<?php
	while($row=@mysql_fetch_array($sql)){
	?>
	<li><a href="?id=<?=$row['admin_id'];?>"><?php echo($row['name']);?></a></li>
	<?php
	}
	?>
	</ul>
	<?php
}else
	echo(0);
?>
