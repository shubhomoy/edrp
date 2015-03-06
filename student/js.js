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

function review(){
	$('#review2').hide();
	name=document.getElementById('name').value;
	reg_no=document.getElementById('reg_no').value;
	addr=document.getElementById('addr').value;
	contact_no=document.getElementById('contact_no').value;
	standard=document.getElementById('standard').value;
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		$('#reviewBtn').attr('value','Please Wait...');
		$('#reviewBtn').attr('disabled','disabled');
		xmlHttp.onreadystatechange=function(){
			document.getElementById('reviewBtn').value='Please Wait...';
			$('#reviewBtn').attr('disabled','disabled');
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText=='0'){
					document.getElementById('review').innerHTML='Registration Number Already Exists';
					$('#reviewBtn').attr('disabled','disabled');
				}else if(xmlHttp.responseText==1){
					document.getElementById('review').innerHTML='Some Fields Are Empty';
					$('#reviewBtn').removeAttr('disabled','disabled');
					$('#reviewBtn').attr('value','Review');
				}else{
					document.getElementById('review').innerHTML=xmlHttp.responseText;
					$('#reviewBtn').removeAttr('disabled');
					$('#reviewBtn').removeAttr('onclick');
					$('#reviewBtn').attr('value','Register');
					$('#reviewBtn').attr('type','submit');
					
				}
				
			}
		};
		p1='name='+name+'&reg_no='+reg_no+'&addr='+addr+'&contact_no='+contact_no+'&standard='+standard;
		xmlHttp.open("POST","../student/ajax/review.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
		setTimeout('review()',5000);
}

function assignStudent(student_id,class_id){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		$('#span'+class_id).text('Assigning...');
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				if(xmlHttp.responseText==1){
					$('#span'+class_id).text('Assigned');
				}else{
					$('#span'+class_id).text(xmlHttp.responseText);
				}
			}
				
		}
	};
	p1='student_id='+student_id+'&class_id='+class_id;
	xmlHttp.open("POST","../student/ajax/assignClass.php",true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlHttp.send(p1);
}

function displaySection(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		document.getElementById('sectionSelector').innerHTML='<option>Please Wait</option>';
		standard=document.getElementById('standardSelector').value;
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$('#section').show();
				document.getElementById('sectionSelector').innerHTML=xmlHttp.responseText;
			}
				
		}
	};
	p1='standard='+standard;
	xmlHttp.open("POST","../student/ajax/viewSection.php",true);
	xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlHttp.send(p1);
}