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


function checkClass(){
	document.getElementById('reviewBtn').disabled=true;
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	standard=document.getElementById('standard').value;
	section=document.getElementById('section').value;
	seat=document.getElementById('seat').value;
	from_hr=document.getElementById('from_hr').value;
	from_min=document.getElementById('from_min').value;
	from_am_pm=document.getElementById('from_am_pm').value;
	to_hr=document.getElementById('to_hr').value;
	to_min=document.getElementById('to_min').value;
	to_am_pm=document.getElementById('to_am_pm').value;
	xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$(".review-screen").fadeIn();
				$('.review-screen').html(xmlHttp.responseText);
			}
		};
		p1='standard='+standard+'&section='+section+'&seat='+seat+'&from_hr='+from_hr+'&from_min='+from_min+'&from_am_pm='+from_am_pm+'&to_hr='+to_hr+'&to_min='+to_min+'&to_am_pm='+to_am_pm;
		xmlHttp.open("POST","../academic/ajax/validateClass.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}else
		setTimeout('checkClass()',5000);
}