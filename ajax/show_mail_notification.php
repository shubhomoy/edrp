<?php
require_once '../config.php';
require_once '../function.php';
$user_id=$_POST['user_id'];

$sql="select from_id from mail where to_id='$user_id' and status='NR'";
$sql=@mysql_query($sql);
?>
<ul>
<?php
while($row=@mysql_fetch_array($sql)){
	?>
	<li>New Mail from <?php echo(getUserName($row['from_id']));?></li>
	<?php
}
?>
</ul>