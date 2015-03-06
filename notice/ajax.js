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


function publishNotice(){
	userType=document.getElementById('noticeFor').value;
	noticeHeading=encodeURIComponent(document.getElementById('noticeHeading').value);
	noticeBody=encodeURIComponent(document.getElementById('noticeBody').value);
	class_id=0;
	standard='';
	if(userType=='s'){
		standard=document.getElementById('pStandardSelector').value;
		if(standard!=0){
			class_id=document.getElementById('pClassSelector').value;
		}
	}
	$('#reviewBtn').attr({
		disabled: 'disabled'
	});
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				$('.review-screen').fadeIn();
				$('.review-screen').html(xmlHttp.responseText);
			}
		};
		p1='user_type='+userType+'&class_id='+class_id+'&standard='+standard+'&noticeHeading='+noticeHeading+'&noticeBody='+noticeBody;
		xmlHttp.open("POST","../notice/ajax/publish_notice.php",true);
		xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlHttp.send(p1);
	}
}