var xmlHttp=createXmlHttpRequestObject();
function createXmlHttpRequestObject(){
	var xmlHttp;
	if(window.ActiveXObject){
		try{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP")
		}catch(e){
			xmlHttp=false;
		}
	}else{
		try{
			xmlHttp=new XMLHttpRequest();
		}catch(e){
			xmlHttp=false;
		}
	}
	if(!xmlHttp)
		echo('Something Went Wrong');
	else
		return xmlHttp;
}

/*********************************************
 *Logout user
 * ******************************************** 
 */
function logout_user(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.open("GET","/edrp/ajax/logout.php",true);
		xmlHttp.onreadystatechange=logoutResponse;   // function using ajax request
		xmlHttp.send(null);
	}else
		setTimeout('logout()',1000);
}
function logoutResponse(){
	if(xmlHttp.readyState==4){
		if(xmlHttp.status==200){
			xmlResponse=xmlHttp.responseXML;
			xmlDocumentElement=xmlResponse.documentElement;
			message=0;
			message=xmlDocumentElement.firstChild.data;
			if(message=='1'){
				document.location.href="index.php";
			}
			else
				alert('Something went Wrong. Logout again');
		}
	}
}

function checkForChanges(){
	$('.notify-change').slideDown('fast', function() {
		
	});

	setTimeout('hideNotifyChange()',3000);
}

function hideNotifyChange(){
	$('.notify-change').fadeOut('slow', function() {
		
	});
}




function confirm_pass(){
	pass=document.getElementById('pass').value;
	conf=document.getElementById('confirm_pass').value;
	if(pass!=conf){
		document.getElementById('check_pass').innerHTML="Incorrect Confirm Password";
	}
		
		//document.getElementById('check_pass').innerHTML="Incorrect Confirm Password";
	else
		document.getElementById('check_pass').innerHTML=" ";
}

function search_ins(){	
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		ins_name=document.getElementById("ins_name").value;
		if(ins_name!=''){
			document.getElementById('institute_list').style.display='none';
			xmlHttp.open("GET","../ajax/search_ins.php?ins_name="+ins_name,true);
			xmlHttp.onreadystatechange=function(){
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
					document.getElementById('ins_result').innerHTML=xmlHttp.responseText;
				}
			};
			xmlHttp.send(null);	
		}else{
			document.getElementById('ins_result').innerHTML='';
			document.getElementById('institute_list').style.display='block';
		}
	}else
		setTimeout('search_ins()',1000);
}

function cls(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		u=document.getElementById('username').value;
		p=document.getElementById('password').value;
		xmlHttp.open("GET","ajax/cls.php?u="+u+"&p="+p,true);
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText==1)
					window.location.assign("/EdRP/sna/index.php");	//sna -> School network admin
				else if(xmlHttp.responseText==2)
					window.location.assign("/EdRP/sa/index.php");		//sa ->school admin
				else if(xmlHttp.responseText==3)
					document.location.href="/EdRP/st/index.php";		// school teacher
				else if(xmlHttp.responseText==4)
					document.location.href="/EdRP/ss/index.php";		//school student
				else
					alert('Incorrect Login');
			}
		};
		xmlHttp.send(null);
	}else
		setTimeout('cls()',5000);
}





function check_contact_no(){
	input=document.getElementById('contact_no').value;
	if(!(input>=0) && !(input<=9)){
		document.getElementById('contact_no').value='';	
	}
}

function search_admin(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		search_name=document.getElementById('search_query').value;
		if(search_name==''){
			document.getElementById('admin_list').style.display='block';
			document.getElementById('admin_search_result').innerHTML='';
		}else{
			document.getElementById('admin_list').style.display='none';
			xmlHttp.open("GET","../ajax/search_admin.php?s_name="+search_name,true);
			xmlHttp.onreadystatechange=function(){
				message=xmlHttp.responseText;
				if(message==0){
					document.getElementById('admin_search_result').innerHTML='No Result found';
				}else{
					document.getElementById('admin_search_result').innerHTML=message;
				}
			};
			xmlHttp.send(null);
		}
	}else
		setTimeout('search_admin',2000);
}




function add_teacher(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	name=document.getElementById('name').value;
	address=document.getElementById('address').value;
	contact_no=document.getElementById('contact_no').value;
	designation=document.getElementById('designation').value;
	xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
			document.getElementById('add_result').innerHTML=xmlHttp.responseText;
			}
		};
		p1='name='+name+'&address='+address+'&contact_no='+contact_no+'&designation='+designation;
		xmlHttp.open("POST","../ajax/add_teacher.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
		setTimeout('add_teacher()',5000);
}

function registerStudent(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	name=document.getElementById('name').value;
	address=document.getElementById('address').value;
	contact_no=document.getElementById('contact_no').value;
	reg_no=document.getElementById('reg_no').value;
	xmlHttp.onreadystatechange=function(){
		//document.location.href="student.php";
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText=='1')
					document.location.href="student.php?success";
				else
					document.location.href="student.php?failed";
			}
		};
		p1='name='+name+'&address='+address+'&contact_no='+contact_no+'&reg_no='+reg_no;
		xmlHttp.open("POST","../ajax/add_student.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
		setTimeout('registerStudent()',5000);
}




function checkSubjectValidity(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		sub_name=document.getElementById('sub_name').value;
		standard=document.getElementById('standard').value;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$("#subjectValidResult").fadeIn();
				document.getElementById('add_subject_btn').disabled=true;
				document.getElementById('subjectValidResult').innerHTML=xmlHttp.responseText;
			}
		};
		p1='sub_name='+sub_name+'&standard='+standard;
		xmlHttp.open("POST","../ajax/subject_validity.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
	setTimeout('checkSubjectValidity()',5000);
}

function add_subject(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		sub_name=document.getElementById('sub_name_add').value;
		standard=document.getElementById('standard_add').value;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$("#subjectValidResult").fadeIn();
				document.getElementById('add_subject_btn').disabled=true;
				document.getElementById('subjectValidResult').innerHTML=sub_name+' has been added to standard '+standard;
				document.location.href='index.php?addsubject';
			}
		};
		p1='sub_name='+sub_name+'&standard='+standard;
		xmlHttp.open("POST","../ajax/add_subject.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
	setTimeout('add_subject()',5000);
}

function showSubject(class_id,spanID,no_of_periods){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$("#showSubjectDiv").fadeIn();
				document.getElementById('showSubjectDiv').innerHTML=xmlHttp.responseText;
				document.getElementById('span'+spanID).innerHTML='Please Wait';
			}
		};
		p1='class_id='+class_id+'&spanID='+spanID+'&no_of_periods='+no_of_periods;
		xmlHttp.open("POST","../../ajax/show_subject.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}

function setSubject(class_id,no_of_periods){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		flag=1;
		for(i=1;i<=(no_of_periods*5);i++){
			if(document.getElementById('slot'+i).value==0){
				$("#showSubjectDiv").fadeIn();
				document.getElementById('showSubjectDiv').innerHTML="There are empty fields";
				flag=0;
				break;
			}
		}
		if(flag==1){
			xmlHttp.onreadystatechange=function(){
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
					$("#showSubjectDiv").fadeIn();
					document.getElementById('showSubjectDiv').innerHTML=xmlHttp.responseText;
				}
			};
			p1='class_id='+class_id+'&no_of_periods='+no_of_periods;
			for(i=1;i<=(no_of_periods*5);i++){
				p1+='&slot'+i+'='+document.getElementById('slot'+i).value;
			}
			xmlHttp.open("POST","../../ajax/set_subject.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}
	}
}

function disableBtn(){
	$('#setSubjectBtn').attr('disabled','disabled');
	$('#setSubjectBtn').attr('value','Fill All Slots');
	
	$('#generateDetailsBtn').attr('disabled','disabled');
	$('#generateDetailsBtn').attr('value','Fill All Slots');
}
function checkRoutineSubjectAllSet(no_of_periods){
	flag=1
	for(i=1;i<=(no_of_periods*5);i++){
		if(document.getElementById('slot'+i).value==0){
			flag=0;
			break;
		}
	}
	if(flag==0){
		$('#setSubjectBtn').attr('disabled','disabled');
		$('#setSubjectBtn').attr('value','Fill All Slots');
		
		$('#generateDetailsBtn').attr('disabled','disabled');
		$('#generateDetailsBtn').attr('value','Fill All Slots');
	}else{
		$('#setSubjectBtn').removeAttr('disabled');
		$('#setSubjectBtn').attr('value','Set Subjects');
		
		$('#generateDetailsBtn').removeAttr('disabled');
		$('#generateDetailsBtn').attr('value','Generate Details');
	}
}



function showRoutineTeacher(class_id,subject_id,period,no_of_periods){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		t_id=$('.slot'+subject_id).val();
		periods=document.getElementsByClassName('slot'+subject_id);
		periods=periods.length;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$("#showTeacherDiv").fadeIn();
				document.getElementById('showTeacherDiv').innerHTML=xmlHttp.responseText;
			}
		};
		p1='class_id='+class_id+'&subject_id='+subject_id+'&period='+period+'&periods='+periods+'&no_of_periods='+no_of_periods+'&prevTeacher='+t_id;
		xmlHttp.open("POST","../../ajax/show_teacher.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}

function decreaseLoadHr(teacher_id,period_duration,subject_id,no_of_periods){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		t_id=$('.slot'+subject_id).val();
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				//document.getElementsByClassName('span'+subject_id).innerHTML=xmlHttp.responseText;
				$('.span'+subject_id).html(' '+xmlHttp.responseText);
				$('.slot'+subject_id).attr('value',teacher_id);
				flag=1
				for(i=1;i<=(no_of_periods*5);i++){
					if(document.getElementById('slot'+i).value==0){
						flag=0;
						break;
					}
				}
				if(flag==0){
					$('#generateDetailsBtn').attr('disabled','disabled');
					$('#generateDetailsBtn').attr('value','Fill All Slots');
				}else{
					$('#generateDetailsBtn').removeAttr('disabled');
					$('#generateDetailsBtn').attr('value','Generate Details');
				}
			}
		};
		p1='teacher_id='+teacher_id+'&period_duration='+period_duration+'&subject_id='+t_id;
		xmlHttp.open("POST","../../ajax/decrease_load_hr.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}

function unassignRoutineTeacher(teacher_id,duration,subject_id){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$('.span'+subject_id).html('Assign Teacher');
				$('.slot'+subject_id).attr('value',0);
				flag=1
				for(i=1;i<=(no_of_periods*5);i++){
					if(document.getElementById('slot'+i).value==0){
						flag=0;
						break;
					}
				}
				if(flag==0){
					$('#generateDetailsBtn').attr('disabled','disabled');
					$('#generateDetailsBtn').attr('value','Fill All Slots');
				}else{
					$('#generateDetailsBtn').removeAttr('disabled');
					$('#generateDetailsBtn').attr('value','Generate Details');
				}
			}
		};
		p1='teacher_id='+teacher_id+'&period_duration='+duration;
		xmlHttp.open("POST","../../ajax/unassign_load_hr.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}

function noticeToChange(id){
	if(id=='noticeFor'){
		val=document.getElementById('noticeFor').value;
		if(val=='s'){
			$('#pStandard').show();
		}else{
			$('#pStandard').hide();
			$('#pClass').hide();
		}
	}
	if(id=='pStandard'){
		val=document.getElementById('pStandardSelector').value;
		if(val==0){
			$('#pClass').hide();
		}else{
			if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
				xmlHttp.onreadystatechange=function(){
					if(xmlHttp.readyState==4 && xmlHttp.status==200){
						$('#pClass').show();
						document.getElementById('pClassContainer').innerHTML=xmlHttp.responseText;
					}
				}
			}
			p1='standard='+val;
			xmlHttp.open("POST","../ajax/show_section.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}
	}
}




function showUpcomingSchedule(user_id){
	$('#sideNotify').fadeIn();
	$("#sideNotify").html('Fetching Schedule Updates...');
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				//$("#sideNotify").fadeIn();
				document.getElementById('sideNotify').innerHTML=xmlHttp.responseText;
			}
		};
		p1='user_id='+user_id;
		xmlHttp.open("POST","/edrp/ajax/show_upcoming_schedule_notification.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}

function showNewMailNotification(user_id){
	$("#sideNotify").fadeIn();
	$("#sideNotify").html('Fetching Mail Updates...');
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$("#sideNotify").fadeIn();
				document.getElementById('sideNotify').innerHTML=xmlHttp.responseText;
			}
		};
		p1='user_id='+user_id;
		xmlHttp.open("POST","/edrp/ajax/show_mail_notification.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}
