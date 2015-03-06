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

function getSubject(t_id){
	$('#assignBtn').attr('disabled','disabled');
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			document.getElementById('subjectSelector').innerHTML='<option>Please Wait...</option>';
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
			document.getElementById('subjectSelector').innerHTML=xmlHttp.responseText;
			document.getElementById('subject').innerHTML='Subjects for Standard '+document.getElementById('standardSelector').value;
			$('#assignBtn').removeAttr('disabled');
			if(document.getElementById('standardSelector').value==0)
				$('#assignBtn').attr('disabled','disabled');
			}
		};
		p1='standard='+document.getElementById('standardSelector').value+'&teacher_id='+t_id;
		xmlHttp.open("POST","../profile/ajax/subjectSelector.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}

function unassignSubject(subject_id,teacher_id){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			document.getElementById('unassignSpan'+subject_id).innerHTML='Unassigning';
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText==1)
				document.location.href='assign.php?id='+teacher_id;
				else{
					document.getElementById('unassignSpan'+subject_id).innerHTML="Cannot Unassign (Why?)";	
					$('#unassignSpan'+subject_id).addClass('hoverText');
					show();
				}
			}
		};
		p1='subject_id='+subject_id+'&teacher_id='+teacher_id;
		xmlHttp.open("POST","../profile/ajax/unassignSubject.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}
function show(){
$('.hoverText').mousemove(function(e){
	$('#hover').css('top',e.clientY+10).css('left',e.clientX+10);
	$('#hover').show();
	$('#hover').text('This teacher is already assigned to this Subject in Routine. Unassign from there first');
}).mouseout(function(){
	$('#hover').hide();
});
}


function assignClassTeacher(id,class_id){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('classTeacher').innerHTML=xmlHttp.responseText;
			}
		};
		p1='teacher_id='+id+'&class_id='+class_id;
		xmlHttp.open("POST","../profile/ajax/assignClassTeacher.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}

function unassignClassTeacher(id){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('classTeacher').innerHTML='<a href=\"#\" onclick=\"$(\'#assignClassTeacherDisplay\').fadeIn();\">Assign</a>';
			}
		};
		p1='teacher_id='+id;
		xmlHttp.open("POST","../profile/ajax/unassignClassTeacher.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}

function showReview(){
	$('#reviewBtn').attr({
		disabled: 'disabled',
	});
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		addr=document.getElementById('addr').value;
		contact_no=document.getElementById('contact_no').value;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$('.review-screen').fadeIn();
				$('.review-screen').html(xmlHttp.responseText);
			}
		};
		p1='addr='+addr+'&contact_no='+contact_no;
		xmlHttp.open("POST","../profile/ajax/editProfileReview.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}



function makeChangesToProfile(){
	$('#reviewBtn').attr({
		disabled: 'disabled',
	});
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		addr=document.getElementById('addr').value;
		contact_no=document.getElementById('contact_no').value;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText==1){
					$('#reviewBtn').attr({
						disabled: 'disabled',
					});
					document.getElementById('reviewBtn').value='Updating...';
					window.location.href="index.php";
				}
			}
		};
		p1='addr='+addr+'&contact_no='+contact_no;
		xmlHttp.open("POST","../profile/ajax/editProfile.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);		
	}
}

