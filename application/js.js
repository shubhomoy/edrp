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

function displayReview(){
	$('#reviewBtn').attr({
					disabled: 'disabled'
	});;
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		if(document.getElementById('subject').value!='' && document.getElementById('body').value!='' && document.getElementById('to_id').value!=0){
			subject=document.getElementById('subject').value;
			body=document.getElementById('body').value;
			to_id=document.getElementById('to_id').value
			$('.review-screen').fadeIn();
			xmlHttp.onreadystatechange=function(){
				$('.review-screen').html('Please Wait...');
				if(xmlHttp.readyState==4 && xmlHttp.status==200){
					$('.review-screen').html(xmlHttp.responseText);
				}
			};
			p1='to_id='+to_id+'&subject='+subject+'&body='+body;
			xmlHttp.open("POST","../application/ajax/review.php",true);
			xmlHttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
			xmlHttp.send(p1);
		}else if((document.getElementById('subject').value=='' || document.getElementById('body').value=='') && document.getElementById('to_id').value!=0){
			$('.review-screen').fadeIn();
			$('.review-screen').text('Some Fields Are Empty');
		}else{
			$('.review-screen').fadeIn();
			$('.review-screen').text('Cannot Send');
		}
	}
}

function changeBtn(){
	document.getElementById('applyBtn').value='Submit';
	$('#applyBtn').attr('type','submit');
	$('#applyBtn').removeAttr('onclick');
}