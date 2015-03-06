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


function search_name(){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
		name=document.getElementById('name_search').value;
		xmlHttp.open("GET","ajax/search_name.php?name="+name,true);
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4 && xmlHttp.status==200){
				document.getElementById('name_search_result').innerHTML=xmlHttp.responseText;
			}
		};
		xmlHttp.send(null);
	}else{
		setTimeout('search_name()',1000);
	}
}

