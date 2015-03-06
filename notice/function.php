
<?php
function showNotices($user_type,$standard,$class_id){
	?><link rel="stylesheet" src="style.css" />
	<?php
	$sql="select * from notice where (user_type='$user_type' or user_type='al') and standard='$standard' and class_id='$class_id' order by notice_id desc";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		?>
		<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
		while($row=@mysql_fetch_array($sql)){
			?>
			<tr class="mail_entry"><td><div class="mail_entry"><a href="view_notice.php?id=<?=$row['notice_id'];?>"><font style="font-size: 17px;"><?php echo($row['notice_heading']);?></font></a>
				<br />
				<font style="font-size: 13px;">Issued By : <?php echo(getUserName($row['from_id']));?> on <?php echo($row['notice_date']);?></font>
			</div></td></tr>
			<?php
		}
		?>
		</table>
		<?php
	}else{
		echo('There are no notices');
	}
}

function getNoticeDetails($notice_id,$detail){
	$sql="select $detail from notice where notice_id='$notice_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql[$detail];
}

?>