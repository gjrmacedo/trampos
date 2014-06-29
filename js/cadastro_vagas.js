$(document).ready(function()
{
	CarregaEmpresas();
	CarregaCargos();
	
	$("#inputCodigo").val($("#inputCodigoPrincipal").val());
	$("#inputCodigoPrincipal").val("");
	$("#inputData").mask("9999-99-99");

	Abrir();
	
	$("#buttonCancelar").click(function(){
		$("#divBody").load("principal.html");
	});
	
	$("#buttonGravar").click(function(){
		if (!ValidaObrigatorios()) {
			return false;
		}
	
		$.ajax({
			url: "cadastro_vagas_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao 	: "G",
				cdVaga 		: document.getElementById("inputCodigo").value,
				cdEmpresa 	: document.getElementById("selectEmpresa").value,
				cdCargo 	: document.getElementById("selectCargo").value,
				vlSalario	: document.getElementById("inputSalario").value,
				stVaga 		: document.getElementById("selectStatus").value,
				dtVaga		: document.getElementById("inputData").value,
				dsObervacao : document.getElementById("textObservacoes").value
			},
			success: function () {
			},
			error: function(pXHR) {
				alert(pXHR.responseText);
			},
			complete : function () {
				$("#divBody").load("principal.html");
			}
		});
	});
	
});

function CarregaEmpresas()
{
	$.ajax({
		url: "cadastro_vagas_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "CE",
		},
		success: function (pJSON) {
			pJSON.forEach(function(objJSON){
				$("#selectEmpresa").append($("<option/>").attr("value", objJSON.identificador).text(objJSON.identificador + " - " + objJSON.nomefantasia)); 
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
}

function CarregaCargos()
{
	$.ajax({
		url: "cadastro_vagas_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "CC",
		},
		success: function (pJSON) {
			pJSON.forEach(function(objJSON){
				$("#selectCargo").append($("<option />").attr("value", objJSON.identificador).text(objJSON.identificador + " - " + objJSON.descricao)); 
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
}

function Abrir()
{
	var $inputCodigo = document.getElementById("inputCodigo");
		
	if ($inputCodigo.value == "") {
		return;
	}
	
	$.ajax({
		url: "cadastro_vagas_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "A",
			cdVaga : $inputCodigo.value
		},
		success: function (pJSON) {
			pJSON.forEach(function(objJSON){
				$inputCodigo.value = objJSON.identificador;
				document.getElementById("selectEmpresa").value = objJSON.idempresa;
				document.getElementById("selectCargo").value = objJSON.idcargo;	
				document.getElementById("selectStatus").value = objJSON.status;
				document.getElementById("inputSalario").value = objJSON.salario;
				document.getElementById("inputData").value = objJSON.datalancamento;
				document.getElementById("textObservacoes").value = objJSON.observacao;
			});
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
	
}

function ValidaObrigatorios()
{
	var arrayRequired = document.querySelectorAll('[requiredfield]'),
		msgRequired = "";
	
	for (var indexElement in arrayRequired){
		if (!arrayRequired[indexElement].type){
			continue;
		}
		
		if (arrayRequired[indexElement].value == "") {
			if (msgRequired != "") {
				msgRequired = msgRequired + "\n";
			}
			
			msgRequired = msgRequired + arrayRequired[indexElement].name;
		}
	}	
	
	if (msgRequired != "") {
		msgRequired = "Os campos listados abaixo são obrigatórios:\n" + msgRequired;
		alert(msgRequired);
		return false;
	}
	
	return true;
}
