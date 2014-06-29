$(document).ready(function() {
	
	Listagem();
	CarregaBeneficios();
	
	$("#inputCodigo").change(function() {
		Abrir();
	});
	
	$("#buttonVoltar").click(function(){
		$("#divBody").load("principal.html");
	});
	
	$("#buttonGravar").click(function() {
		$.ajax({
			url: "lancamento_beneficios_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao 		: "G",
				cdVagaBeneficio : document.getElementById("inputCodigo").value,
				cdVaga 			: document.getElementById("inputCodigoPrincipal").value,
				cdBeneficio 	: document.getElementById("selectBeneficio").value,
				vlBeneficio 	: document.getElementById("inputValor").value,
				vlDesconto		: document.getElementById("inputDesconto").value
			},
			success: function () {
				
			},
			error: function(pXHR) {
				alert(pXHR.responseText);
			},
			complete : function () {
				Recarrega();
			}
		});
		
	});
	
	$("#buttonExcluir").click(function() {
		var $inputCodigo = document.getElementById("inputCodigo");
		
		if ($inputCodigo.value != "") {
			$.ajax({
				url: "lancamento_beneficios_ajax.php",
				dataType: 'json',
				type : "GET",
				data: {
					cdOperacao : "E",
					cdVagaBeneficio : $inputCodigo.value
				},
				success: function () {
				
				},
				erro: function(pXHR) {
					alert(pXHR.responseText);
				},
				complete : function () {
					Recarrega();
				}
			});
		}
	});
	
	$("#buttonCancelar").click(function() {
		LimparCampos();
	});
});

function Listagem()
{
	$("#tbodyListagem tr").remove();
	
	$.ajax({
		url: "lancamento_beneficios_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "L",
			cdVagaBeneficio : document.getElementById("inputCodigoPrincipal").value
		},
		success: function (pJSON) {
			if (pJSON) {
				document.getElementById("tdQtdeRegistros").innerHTML = "Exibindo " + pJSON.length  + " registro(s).";
			}
			
			pJSON.forEach(function(objJSON){
				var tdEditar = "<a class='glyphicon glyphicon-edit' href='javascript:Editar(" + objJSON.identificador + ");'></a>";
				$("#tbodyListagem").append("<tr>" +
												"<td>" + objJSON.identificador + "</td>" +
												"<td>" + objJSON.descricao + "</td>" +
												"<td>" + objJSON.valor + "</td>" +
												"<td>" + objJSON.valordesconto + "</td>" +
												"<td>" + tdEditar + "</td>" +
											"</tr>");
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
	
}

function Editar(pcdBeneficio)
{
	$("#inputCodigo").val(pcdBeneficio);
	Abrir();
}

function LimparCampos()
{
	var $inputCodigo = document.getElementById("inputCodigo"),
		$selectBeneficio = document.getElementById("selectBeneficio"),
		$inputValor = document.getElementById("inputValor"),
		$inputDesconto = document.getElementById("inputDesconto");
	
	$inputCodigo.value = "";
	$selectBeneficio.value = "";
	$inputValor.value = "";
	$inputDesconto.value = "";
	
	$inputCodigo.focus();	
}

function Recarrega() 
{
	Listagem();
	
	LimparCampos();
}

function Abrir()
{
	var $inputCodigo = document.getElementById("inputCodigo");
	
	if ($inputCodigo.value != "") {
		$.ajax({
			url: "lancamento_beneficios_ajax.php",
			dataType: 'json',
			type : "GET",
			data: {
				cdOperacao : "A",
				cdVagaBeneficio : $inputCodigo.value
			},
			success: function (pJSON) {
				if (pJSON) {
					pJSON.forEach(function(objJSON){
						$inputCodigo.value = objJSON.identificador;
						document.getElementById("selectBeneficio").value = objJSON.idbeneficio;
						document.getElementById("inputValor").value = objJSON.valor;
						document.getElementById("inputDesconto").value = objJSON.valordesconto;						
					});
				} else {
					alert("Benefício não encontrado");
					$inputCodigo.focus();
				}
			},
			erro: function(pXHR) {
				alert(pXHR.responseText);
			}
		});
	}
}

function CarregaBeneficios()
{
	$.ajax({
		url: "lancamento_beneficios_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "C",
		},
		success: function (pJSON) {
			pJSON.forEach(function(objJSON){
				$("#selectBeneficio").append($("<option />").attr("value", objJSON.identificador).text(objJSON.identificador + " - " + objJSON.descricao)); 
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
}