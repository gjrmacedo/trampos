$(document).ready(function() {
	
	Listagem();
	
	CarregaRamos();
	
	$("#inputCodigo").change(function() {
		Abrir();
	});
	
	$("#buttonGravar").click(function() {
		if (!ValidaObrigatorios()) {
			return false;
		}
		
		$.ajax({
			url: "cadastro_empresa_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao 	: "G",
				cdEmpresa 	: document.getElementById("inputCodigo").value,
				dsEmpresa 	: document.getElementById("inputNome").value,
				cdCEP 		: document.getElementById("inputCEP").value,
				cdPorte 	: document.getElementById("selectPorte").value,
				cdRamo 		: document.getElementById("selectRamo").value
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
				url: "cadastro_empresa_ajax.php",
				dataType: 'json',
				type : "GET",
				data: {
					cdOperacao : "E",
					cdEmpresa : $inputCodigo.value
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
		url: "cadastro_empresa_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "L",
		},
		success: function (pJSON) {
			if (pJSON) {
				document.getElementById("tdQtdeRegistros").innerHTML = "Exibindo " + pJSON.length  + " registro(s).";
			
				pJSON.forEach(function(objJSON){
					var tdEditar = "<a class='glyphicon glyphicon-edit' href='javascript:Editar(" + objJSON.identificador + ");'></a>";
					$("#tbodyListagem").append("<tr><td>" + objJSON.identificador + "</td><td>" + objJSON.nomefantasia + "</td><td>" + objJSON.descricao + "</td><td>" + objJSON.porte + "</td><td>" + tdEditar + "</td></tr>");
				});
			} else {
				document.getElementById("tdQtdeRegistros").innerHTML = "Exibindo 0 registro(s).";
			}
		},
		erro: function(pXHR) {
			alert(pXHR.responseText);
		}
	});
	
}


function Editar(pcdEmpresa)
{
	$("#inputCodigo").val(pcdEmpresa);
	Abrir();
}

function LimparCampos()
{
	var $inputCodigo = document.getElementById("inputCodigo"),
		$inputNome = document.getElementById("inputNome"),
		$inputCEP = document.getElementById("inputCEP"),
		$selectPorte = document.getElementById("selectPorte"),
		$selectRamo = document.getElementById("selectRamo");
		
	$inputCodigo.value = "";
	$inputNome.value = "";
	$inputCEP.value = "";
	$selectPorte.value = "P";
	$selectRamo.value = "";
	
	$inputCodigo.focus();
}

function Recarrega() 
{
	Listagem();
	
	LimparCampos();
}

function CarregaRamos()
{
	$.ajax({
		url: "cadastro_empresa_ajax.php",
		dataType: 'json',
		type : "GET",
		data: {
			cdOperacao : "CR",
		},
		success: function (pJSON) {
			pJSON.forEach(function(objJSON){
				$("#selectRamo").append($("<option />").attr("value", objJSON.identificador).text(objJSON.identificador + " - " + objJSON.descricao)); 
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
		
	if ($inputCodigo.value != "") {
		$.ajax({
			url: "cadastro_empresa_ajax.php",
			dataType: 'json',
			type : "GET",
			data: {
				cdOperacao : "A",
				cdEmpresa : $inputCodigo.value
			},
			success: function (pJSON) {
				if (pJSON) {
					pJSON.forEach(function(objJSON){
						$inputCodigo.value = objJSON.identificador;
						document.getElementById("inputNome").value = objJSON.nomefantasia;
						document.getElementById("inputCEP").value = objJSON.cep;	
						document.getElementById("selectPorte").value = objJSON.porte;
						
						if ((objJSON.idramo != "") && (objJSON.idramo != null)) {
							document.getElementById("selectRamo").value = objJSON.idramo;
						}								
					});
				} else {
					alert("Empresa não encontrada");
					$inputCodigo.focus();
				}
			},
			erro: function(pXHR) {
				alert(pXHR.responseText);
			}
		});
	}
}

