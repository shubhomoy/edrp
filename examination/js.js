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

function showSection(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		if(document.getElementById('standardSelector').value!=0){
			$('#section').show();
			xmlHttp.onreadystatechange=function(){
				document.getElementById('sectionSelector').innerHTML='<option>Please Wait...</option>'
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('sectionSelector').innerHTML=xmlHttp.responseText;
				}
			};
			p1='standard='+document.getElementById('standardSelector').value;
			xmlHttp.open("POST","../ajax/sectionSelector.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}else{
			$('#section').hide();
		}
	}else
		setTimeout('showSection()',1000);
}


function checkMaxMark(maxMark,id){
	mark=document.getElementById(id).value;
	if(mark>maxMark){
		alert('Invalid Marks');
		document.getElementById(id).value='';
	}
}