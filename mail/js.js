$("#name_search").keyup(function() {
	if (document.getElementById('name_search').value != '') {
		$("#name_search_result").show();
		
	}else {
		$("#name_search_result").hide();
		
	}
});

$("#name_search_result").click(function() {
	//		if(document.getElementById('name_search').value=='' )
	$("#name_search_result").hide();
	
});

$("#name_search").blur(function() {
	
		$("#name_search_result").fadeOut();
		
	
});