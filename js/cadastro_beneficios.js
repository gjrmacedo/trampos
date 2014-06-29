$(document).ready(function() {
	
	Listagem();
	
	$("#inputCodigo").change(function() {
		Abrir();
	});
	
	$("#buttonGravar").click(function() {
		if (!ValidaObrigatorios()) {
			return false;
		}
	
		$.ajax({
			url: "cadastro_beneficios_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao 	: "G",
				cdBeneficio : document.getElementById("inputCodigo").value,
				dsBeneficio : document.getElementById("inputDescricao").value,
				cdOrdem 	: document.getElementById("inputOrdem").value,
				tpValor 	: document.getElementById("selectTipoValor").value,
				tpDesconto 	: document.getElementById("selectTipoDesconto").value
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
		
	});
	
	$("#buttonExcluir").click(function() {
		var $inputCodigo = document.getElementById("inputCodigo");
		
		if ($inputCodigo.value != "") {
			$.ajax({
				url: "cadastro_beneficios_ajax.php",
				dataType: 'json',
				type : "GET",
				data: {
					cdOperacao : "E",
					cdBeneficio : $inputCodigo.value
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
		url: "cadastro_beneficios_ajax.php",
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
				var tdEditar = "<a class='glyphicon glyphicon-edit' href='javascript:Editar(" + objJSON.identificador + ");'></a>";
				$("#tbodyListagem").append("<tr><td>" + objJSON.identificador + "</td><td>" + objJSON.descricao + "</td><td>" + tdEditar + "</td></tr>");
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
		$inputDescricao = document.getElementById("inputDescricao"),
		$inputOrdem = document.getElementById("inputOrdem"),
		$selectTipoValor = document.getElementById("selectTipoValor"),
		$selectTipoDesconto = document.getElementById("selectTipoDesconto");
	
	$inputOrdem.value = "";
	$inputCodigo.value = "";
	$inputDescricao.value = "";
	$selectTipoValor.value = "V";
	$selectTipoDesconto.value = "V";
	
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
			url: "cadastro_beneficios_ajax.php",
			dataType: 'json',
			type : "GET",
			data: {
				cdOperacao : "A",
				cdBeneficio : $inputCodigo.value
			},
			success: function (pJSON) {
				if (pJSON) {
					pJSON.forEach(function(objJSON){
						$inputCodigo.value = objJSON.identificador;
						document.getElementById("inputDescricao").value = objJSON.descricao;
						document.getElementById("inputOrdem").value = objJSON.ordem;
						document.getElementById("selectTipoValor").value = objJSON.tipovalor;
						document.getElementById("selectTipoDesconto").value = objJSON.tipodesconto;						
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