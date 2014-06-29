var CLASSNAME = "",
	QUERY = "";
	
$(document).ready(function() {
	$form = document.getElementsByTagName("form")[0],
	$tbody = document.getElementsByTagName("tbody")[0];
	
	CLASSNAME = $form.getAttribute("data-class");
	QUERY = $tbody.getAttribute("data-query");
	
	Listagem();
	
});


function Listagem()
{
	var trData = "";
	//$("#tbodyListagem tr").remove();
	
	$.ajax({
		url: "comum.php",
		dataType: "json",
		type : "GET",
		data: {
			cdOperacao 	: "L",
			className 	: CLASSNAME,
			classQuery 	: QUERY
		},
		success: function (pJSON) {
			
			pJSON.forEach(function(objJSON){
				trData = ""
				
				$.each(objJSON, function(index, item){
					trData = trData + "<td>" + item + "</td>"
				});
				
				if (trData != "") {
					$("#" + $tbody.id).append("<tr>" + trData + "</tr>");
				}								
			});
		},
		error: function(pXHR) {
			alert("ERRO:" + pXHR.responseText);
		}
	});
	
}