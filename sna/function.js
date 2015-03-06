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

function reviewInsDetails(){
	$('#reviewBtn').attr({
		disabled: 'disabled'
	});
	ins_name=document.getElementById('ins_name').value;
	contact_no=document.getElementById('ins_contact_no').value;
	ins_addr=document.getElementById('ins_addr').value;
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$('.review-screen').fadeIn();
				$('.review-screen').html(xmlHttp.responseText);
			}
		};
		p1='ins_name='+ins_name+'&ins_contact_no='+contact_no+'&ins_addr='+ins_addr;
		xmlHttp.open("POST","../sna/ajax/editInsDetails.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}

}

function review_admin(){
	// a takes values of 1 or 2. 1 is for academic,admission,hra admins and 2 is for other admins
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		admin_name=document.getElementById('admin_name').value;
		admin_contact_no=document.getElementById('contact_no').value;
		admin_addr=document.getElementById('admin_addr').value;
		adminpost=document.getElementById('post').value;
		
		var routine=0;
		var hire=0;
		var student=0;
		var approveApplicationTeacher=0;
		var approveApplicationStudent=0;
		var assignUnassignClassTeacher=0;
		var assignUnassignTeacherSubject=0;
		var classAdministration=0;
		var academic=0;
		var notice=0;
		var assignments=0;
		var examSetup=0;
		var updateMarks=0;
		
		if(document.getElementById('routine').checked)
		routine=1;
		if(document.getElementById('approve_application_teacher').checked)
		approveApplicationTeacher=1;
		if(document.getElementById('hire').checked)
		hire=1;
		if(document.getElementById('student').checked)
		student=1;
		
		xmlHttp.onreadystatechange=function(){
				document.getElementById('add_response').innerHTML=xmlHttp.responseText;
		};
		
		p1='admin_name='+admin_name+'&admin_contact_no='+admin_contact_no+'&admin_addr='+admin_addr+'&adminpost='+adminpost+'&hire='+hire+'&routine='+routine+'&approve_application='+approveApplicationTeacher+'&hire='+hire+
		'&student='+student;
		xmlHttp.open("POST","../sna/ajax/add_admin.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}