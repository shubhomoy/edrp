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

function sectionSelector(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		if(document.getElementById('standardSelect').value!=0){
			$('#section').show();
			xmlHttp.onreadystatechange=function(){
				document.getElementById('sectionSelect').innerHTML='<option>Please Wait...</option>'
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('sectionSelect').innerHTML=xmlHttp.responseText;
				}
			};
			p1='standard='+document.getElementById('standardSelect').value;
			xmlHttp.open("POST","../assignments/ajax/sectionSelector.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}else{
			$('#section').hide();
		}
	}else
		setTimeout('sectionSelector()',1000);
}

function reviewAssignment(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		$('#reviewDisplay').show();
		$('#reviewDisplay').html('Please Wait...');
		standard=document.getElementById('standardSelect').value;
		class_id=0;
		file=document.getElementById('file').value;
		if(document.getElementById('sectionSelect'))
			class_id=document.getElementById('sectionSelect').value;
		
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('reviewDisplay').innerHTML=xmlHttp.responseText;
				$('#upload').attr('type','submit');
				$('#upload').attr('value','Upload Assignment');
				$('#upload').removeAttr('onclick');
			}
		};
		p1='standard='+standard+'&class_id='+class_id+'&file='+file;
		xmlHttp.open("POST","../assignments/ajax/reviewAssignment.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else{
		setTimeout('reviewAssignment()',5000);
	}
}

function updateSortViewDisplay(){
	sort=document.getElementById('sort').value;
	if(sort==0){
		$('#sectionSelect').hide();
	}else{
		standard=sort;
		$('#sectionSelect').show();
		$('#sectionSelector').html('<option>Please Wait...</option>');
		$('#sectionSelector').attr('disabled','disabled');
		
		if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
			xmlHttp.onreadystatechange=function(){
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
					document.getElementById('sectionSelector').innerHTML=xmlHttp.responseText;
					$('#sectionSelector').removeAttr('disabled');
				}
			};
			p1='standard='+standard;
			xmlHttp.open("POST","../assignments/ajax/sectionSelector.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}else{
			setTimeout('updateSortViewDisplay()',1000);
		}
	}
}

function displayAssignment(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		$('#displayAssignment').show();
		$('#displayAssignment').html('Searching for Assignments...');
		standard=document.getElementById('sort').value;
		class_id=0;
		if(document.getElementById('sectionSelector'))
			class_id=document.getElementById('sectionSelector').value;
		
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('displayAssignment').innerHTML=xmlHttp.responseText;
			}
		};
		p1='standard='+standard+'&class_id='+class_id;
		xmlHttp.open("POST","../assignments/ajax/displayAssignment.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else{
		setTimeout('displayAssignment()',5000);
	}
}

function deleteAssignment(ass_id){
	if(confirm('Are you sure you want to Delete the Assignment?')){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.location.href='myassignment.php';
			}
		};
		p1='ass_id='+ass_id;
		xmlHttp.open("POST","../assignments/ajax/deleteAssignment.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else{
		setTimeout('deleteAssignment()',5000);
	}
	}
}

$('.hover').mousemove(function(e){
	$('#mousehoverdiv').css('top',e.clientY+10).css('left',e.clientX+10);
	$('#mousehoverdiv').show();
	$('#mousehoverdiv').text('Deleting this Assignment will permanently remove it from the Database');
}).mouseout(function(){
	$('#mousehoverdiv').hide();
})
