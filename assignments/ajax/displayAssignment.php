<?php
require_once '../../function.php';
require_once '../../config.php';

$standard=$_POST['standard'];
$class_id=$_POST['class_id'];

if($standard!=0){
	if($class_id!=0){
		$sql="select * from assignment where class_id='$class_id' and standard='$standard'";
		$sql=@mysql_query($sql);
		if(@mysql_num_rows($sql)){
			while($row=@mysql_fetch_array($sql)){
				?>
				<div class="mail_entry">
					<table align="center" width="100%" cellpadding="0" cellspacing="0">
						<tr><td style="font-size: 17px;"><strong><a href="?view&id=<?=$row['assignment_id'];?>"><?php echo($row['title']);?></a></strong></td><td width="10%" style="font-size: 13px;"><a href="?view&id=<?=$row['assignment_id'];?>">Download</a></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">File : <?php echo($row['file_name']);?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">By : <?php echo(getUserName($row['from_id']));?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">Uploaded on : <?php echo($row['assignment_date']);?></td></tr>
					</table>
				</div>
				<?php
			}
		}else{
			echo('No Assignments Found');
		}
	}else{
		$sql="select * from assignment where class_id=0 and standard='$standard'";
		$sql=@mysql_query($sql);
		if(@mysql_num_rows($sql)){
			while($row=@mysql_fetch_array($sql)){
				?>
				<div class="mail_entry">
					<table align="center" width="100%" cellpadding="0" cellspacing="0">
						<tr><td style="font-size: 17px;"><strong><a href="?view&id=<?=$row['assignment_id'];?>"><?php echo($row['title']);?></a></strong></td><td width="10%" style="font-size: 13px;"><a href="?view&id=<?=$row['assignment_id'];?>">Download</a></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">File : <?php echo($row['file_name']);?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">By : <?php echo(getUserName($row['from_id']));?></td></tr>
						<tr><td colspan="2" style="font-size: 13px;">Uploaded on : <?php echo($row['assignment_date']);?></td></tr>
					</table>
				</div>
				<?php
			}
		}else{
			echo('No Assignments Found');
		}
	}
}else{
	$sql="select * from assignment where class_id=0 and standard=0";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		while($row=@mysql_fetch_array($sql)){
			?>
			<div class="mail_entry">
				<table align="center" width="100%" cellpadding="0" cellspacing="0">
					<tr><td style="font-size: 17px;"><strong><a href="?view&id=<?=$row['assignment_id'];?>"><?php echo($row['title']);?></a></strong></td><td width="10%" style="font-size: 13px;"><a href="?view&id=<?=$row['assignment_id'];?>">Download</a></td></tr>
					<tr><td colspan="2" style="font-size: 13px;">File : <?php echo($row['file_name']);?></td></tr>
					<tr><td colspan="2" style="font-size: 13px;">By : <?php echo(getUserName($row['from_id']));?></td></tr>
					<tr><td colspan="2" style="font-size: 13px;">Uploaded on : <?php echo($row['assignment_date']);?></td></tr>
				</table>
			</div>
			<?php
		}
	}else{
		echo('No Assignments Found');
	}
}
?>