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
			url: "cadastro_cargos_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao : "G",
				cdCargo : document.getElementById("inputCodigo").value,
				dsCargo : document.getElementById("inputDescricao").value,
				cdOrdem : document.getElementById("inputOrdem").value
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
				url: "cadastro_cargos_ajax.php",
				dataType: 'json',
				type : "GET",
				data: {
					cdOperacao : "E",
					cdCargo : $inputCodigo.value
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
		url: "cadastro_cargos_ajax.php",
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
					$("#tbodyListagem").append("<tr><td>" + objJSON.identificador + "</td><td>" + objJSON.descricao + "</td><td>" + objJSON.ordem + "</td><td>" + tdEditar + "</td></tr>");
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

function Editar(pcdCargo)
{
	$("#inputCodigo").val(pcdCargo);
	Abrir();
}

function LimparCampos()
{
	var $inputCodigo = document.getElementById("inputCodigo"),
		$inputDescricao = document.getElementById("inputDescricao"),
		$inputOrdem = document.getElementById("inputOrdem");
		
	$inputCodigo.value = "";
	$inputDescricao.value = "";
	$inputOrdem.value = "";
	
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
			url: "cadastro_cargos_ajax.php",
			dataType: 'json',
			type : "GET",
			data: {
				cdOperacao : "A",
				cdCargo : $inputCodigo.value
			},
			success: function (pJSON) {
				if (pJSON) {
					pJSON.forEach(function(objJSON){
						$inputCodigo.value = objJSON.identificador;
						document.getElementById("inputDescricao").value = objJSON.descricao;
						document.getElementById("inputOrdem").value = objJSON.ordem;							
					});
				} else {
					alert("cargo não encontrado");
					$inputCodigo.focus();
				}
			},
			erro: function(pXHR) {
				alert(pXHR.responseText);
			}
		});
	}
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