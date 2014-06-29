$(document).ready(function() {
	$("#buttonIncluir").click(function(){
		$("#divBody").load("cadastro_vagas.html");
	});
	
	$.ajax({
		url: "principal_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "L",
		},
		success: function (pJSON) {
			if (pJSON) {
				document.getElementById("tdQtdeRegistros").innerHTML = "Exibindo " + pJSON.length  + " registro(s).";
			}
			
			pJSON.forEach(function(objJSON){
				var tdEditar = "<a class='glyphicon glyphicon-edit' href='javascript:Editar(" + objJSON.identificador + ");' title='Editar'></a>";
				var tdExcluir = "<a class='glyphicon glyphicon-trash' href='javascript:Excluir(" + objJSON.identificador + ");' title='Excluir'></a>";
				var tdBeneficios = "<a class='glyphicon glyphicon-plus' href='javascript:Beneficios(" + objJSON.identificador + ");' title='Add Beneficios'></a>";
				var tdListar = "<a class='glyphicon glyphicon-print' href='javascript:Listagem(" + objJSON.identificador + ");' title='Listar'></a>";
				
				
				$("#tbodyListagem").append("<tr>" +
												"<td>" + objJSON.identificador + "</td>" +
												"<td>" + objJSON.datalancamento + "</td>" +
												"<td>" + objJSON.descricao + "</td>" +
												"<td>" + objJSON.salario + "</td>" +
												"<td>" + objJSON.nomefantasia + "</td>" +
												"<td>" + objJSON.status + "</td>" +
												"<td>" + objJSON.ordem + "</td>" +
												"<td>" + tdEditar + " " + tdExcluir + " " + tdBeneficios + " " + tdListar + "</td>" +
											"</tr>")
				
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
});

function Editar(pId)
{
	$("#divBody").load("cadastro_vagas.html");
	
	document.getElementById("inputCodigoPrincipal").value = pId;
}

function Excluir(pId)
{
	$.ajax({
		url: "principal_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao 	: "E",
			cdVaga 		: pId
		},
		success: function () {
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});	
	
	$("#divBody").load("principal.html");
}

function Beneficios(pId)
{
	$("#divBody").load("lancamento_beneficios.html");
	
	document.getElementById("inputCodigoPrincipal").value = pId;
}

function Listagem(pId)
{
	var windowImprimeVaga = window.open("imprime_vaga.html", '_blank');
	windowImprimeVaga.focus();
	document.getElementById("inputCodigoPrincipal").value = pId;
}
