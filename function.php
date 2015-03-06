
<?php
require_once 'config.php';
function get_ins_name(){
	$sql="select school_name from school_detail ";
	$sql=@mysql_query($sql);
	$res=@mysql_num_rows($sql);
	if($res==0)
		return "No Institute Found";
	$sql=@mysql_fetch_array($sql);
	return $sql['school_name'];
}

function getUserType($user_id){
	$sql="select user_type from user where user_id='$user_id'";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		$sql=@mysql_fetch_array($sql);
		return $sql['user_type'];
	}else{
		return 0;
	}
	return 0;
}

function get_user_name($user_id,$user_type,$detail){
	$sql='';
	if($user_type=='a'){
		if($detail=='address'){
			$sql="select address from admin_detail where admin_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['address'];	
		}else
		if($detail=='name'){
			$sql="select name from admin_detail where admin_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['name'];	
		}else
		if($detail=='contact'){
			$sql="select contact_no from admin_detail where admin_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['contact_no'];	
		}else
		if($detail=='post'){
			$sql="select post from admin_detail where admin_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['post'];
		}
	}else if($user_type=='t'){
		if($detail=='address'){
			$sql="select address from teacher_detail where teacher_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['address'];	
		}else
		if($detail=='name'){
			$sql="select name from teacher_detail where teacher_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['name'];	
		}else
		if($detail=='contact'){
			$sql="select contact_no from teacher_detail where teacher_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['contact_no'];	
		}else
		if($detail=='post'){
			$sql="select post from teacher_detail where teacher_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['post'];
		}
	}else if($user_type=='s'){
		if($detail=='address'){
			$sql="select address from student_detail where student_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['address'];	
		}else
		if($detail=='name'){
			$sql="select name from student_detail where student_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['name'];	
		}else
		if($detail=='contact'){
			$sql="select contact_no from student_detail where student_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['contact_no'];	
		}else if($detail=='standard'){
			$sql="select standard from student_detail where student_id='$user_id'";
			$sql=@mysql_fetch_array(@mysql_query($sql));
			return $sql['standard'];	
		}
	}
}


function getUserName($user_id){
	$sql="select name from user where user_id='$user_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql['name'];
}

function checkMailIsValid($mail_id,$user_id){
	$sql="select to_id from mail where mail_id='$mail_id'";
	$sql=@mysql_query($sql);
	$res=@mysql_num_rows($sql);
	if($res==0)
		return 0;
	else{
		$sql=@mysql_fetch_array($sql);
		if($sql['to_id']!=$user_id)
			return 0;
		else if($sql['to_id']==$user_id)
			return 1;
	}
}

function get_post($user_id,$user_type){
	$sql='';
	if($user_type=='a')
	$sql="select post from admin_detail where admin_id='$user_id'";
	else if($user_type=='t')
	$sql="select post from teacher_detail where teacher_id='$user_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql['post'];
}

function checkAdminFeature($user_id){
	$sql="select * from admin_features where admin_id='$user_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql;
}

function getRegistrationNumber(){
	$sql="select reg_no from student_detail order by reg_no desc";
	$sql=@mysql_query($sql);
	$res=@mysql_num_rows($sql);
	if($res==0){
		return 50000;
	}else{
		$res=@mysql_fetch_array($sql);
		$res=$res['reg_no'];
		$res++;
		return $res;
	}
}

function getPeriodStartTime($class_id){
	$sql="select from_time from class_detail where class_id='$class_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql['from_time'];
}


function convertTime($min){
	$hr=floor($min/60);
	$min=$min%60;
	$time['hr']=$hr;
	$time['min']=$min;
	return $time;
}

function getMinutes($hr,$min,$am_pm){
	$time=0;
	if($hr==12 && $am_pm=='am')
		$time=$min;
	else
		$time=($hr*60)+$min;
	if($am_pm=='pm' && $hr!=12)
	$time+=(12*60);
	return $time;
}

function getClassDetail($class_id,$detail){
	$sql="select ".$detail." from class_detail where class_id='$class_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql[$detail];
}

function showSubject($subjectID){
	$sql="select subject_name from subjects where subject_id='$subjectID'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	return $sql['subject_name'];
}

function getPeriodDuration($class_id,$period){
	$sql="select from_time,to_time from periods where class_id='$class_id' and period_no='$period'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	$from=$sql['from_time'];
	$to=$sql['to_time'];
	$from=$to-$from;	//duration
	return $from;
}

function showDay($day){
	if($day==1)
		return 'Monday';
	else if($day==2)
		return 'Tuesday';
	else if($day==3)
		return 'Wednesday';
	else if($day==4)
		return 'Thursday';
	else if($day==5)
		return 'Friday';
}



function getLinks($user_id,$user_type){
	?>
	<center><font color="black">
		<?php echo(getUserName($user_id));?>
	</font><hr />
	<a href="#" align="left">Recent Updates</a>
	<a href="/edrp/profile/" align="left">Profile</a>
	<?php $sql="select status from mail where to_id='$user_id' and status='NR'";
	$sql=@mysql_query($sql);
	$res=@mysql_num_rows($sql);
	if($res==0){
		?>
		<a href="/edrp/mail/" align="left">Mail</a>
		<?php
	}else{
		?>
		<a href="/edrp/mail/" style="background: #E37C74;" align="left" ><font color="#ffffff">Mail <?php echo('('.$res.' new)');?></font></a>
		<?php
	}
	?>
	<a href="/edrp/notice/" align="left">Notice</a>
	<?php
	if($user_type=='t'){
		?>
		<a href="/edrp/st/my_routine.php" align="left" onmouseover="showUpcomingSchedule(<?php echo($user_id);?>)" onmouseout="$('#sideNotify').fadeOut();">My Routine</a>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<?php
	}
	$sql="select * from admin_features where admin_id='$user_id'";
	$sql=@mysql_fetch_array(@mysql_query($sql));
	
	if($sql['hire']==1){
		?>
		<a href="/edrp/recruit/" align="left">Recruit</a>
		<?php
	}
	if($user_type!='s'){
		?>
		<a href="/edrp/student/index.php" align="left">Student</a>
		<?php
	}
	if($user_type=='a'){
		?>
		<a href="/edrp/teacher/" align="left">Teacher/Staff</a>
		<?php
	}
	if($sql['academic']==1 || $sql['routine'] || $sql['class_administration']){
		?>
		<a href="/edrp/academic/" align="left">Academic Administration</a>
		<?php
	}
	if($user_type!='a'){
		?>
		<a href="/edrp/assignments/" align="left">Assignments</a>
		<?php
	}
	$sql="select approval from application where approval=0 and to_id='$user_id' limit 1";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		?>
		<a href="/edrp/application/" align="left" style="background: #E37C74;"><font color="#ffffff">Application</font></a>
		<?php
	}else{
		?>
		<a href="/edrp/application/" align="left">Application</a>
		<?php
	}
	if($user_type=='s'){
		?>
		<a href="/edrp/examination/view/index.php" align="left">Result</a>
		<?php
	}
	?>
	<a href="/edrp/index.php" onclick="logout_user()" align="left">Logout</a>
	<div id="sideNotify" style="position:absolute; top: 150px; left: 250px; width: 300px; height: auto; background: rgba(130,104,205,0.9); color: rgb(255,255,255); display: none; padding: 25px;
	 border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
	 onmouseout="$('#sideNotify').fadeOut();">Upcoming Schedule</div>
	<?php
}

function showStudentDetails($reg_no){
	$sql="select * from student_detail where reg_no='$reg_no'";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		$sql=@mysql_fetch_array($sql);
		?>
		<table align="center" width="100%">
		<tr><td width="25%">Registration Number</td><td><?php echo($sql['reg_no']);?></td></tr>
		<tr><td>Name</td><td><?php echo($sql['name']);?></td></tr>
		<tr><td>Roll Number</td><td><?php echo($sql['roll_no']);?></td></tr>
		<tr><td>Standard/Section</td><td><?php 
		if($sql['class_id']!='0'){
			echo(getClassDetail($sql['class_id'], 'standard').' - '.getClassDetail($sql['class_id'], 'batch'));
		}
		else{
			echo('Not Assigned');		
		}?></td></tr>
		<tr><td>Address</td><td><?php echo($sql['address']);?></td></tr>
		<tr><td>Contact Number</td><td><?php echo($sql['contact_no']);?></td></tr>
		</table>
		<?php
	}else{
		echo('No Student Found');
	}
}

function getClassOfClassTeacher($teacher_id){
	$sql="select class_id from class_detail where class_teacher='$teacher_id' limit 1";
	$sql=@mysql_query($sql);
	if(@mysql_num_rows($sql)){
		$sql=@mysql_fetch_array($sql);
		return $sql['class_id'];
	}else{
		return 0;
	}
	return 0;
}


function getGuide($url){
	?>
	<div class="guide-icon"><a href="#" style="display:block;" onclick="$('.guide-container').fadeIn();" ><img src="/edrp/resources/guide-icon.png"></a></div>

	<div class="guide-container" onclick="$(this).fadeOut();">
		<?php
		include $url;
		?>
	</div>
	<?php
}
?>