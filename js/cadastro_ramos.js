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
			url: "cadastro_ramos_ajax.php",
			dataType: 'json',
			type : "GET",
			async: false,
			data: {
				cdOperacao : "G",
				cdRamo : document.getElementById("inputCodigo").value,
				dsRamo : document.getElementById("inputDescricao").value
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
				url: "cadastro_ramos_ajax.php",
				dataType: 'json',
				type : "GET",
				data: {
					cdOperacao : "E",
					cdRamo : $inputCodigo.value
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
		url: "cadastro_ramos_ajax.php",
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
					$("#tbodyListagem").append("<tr><td>" + objJSON.identificador + "</td><td>" + objJSON.descricao + "</td><td>" + tdEditar + "</td></tr>");
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


function Editar(pcdRamo)
{
	$("#inputCodigo").val(pcdRamo);
	Abrir();
}

function LimparCampos()
{
	var $inputCodigo = document.getElementById("inputCodigo"),
		$inputDescricao = document.getElementById("inputDescricao");
		
	$inputCodigo.value = "";
	$inputDescricao.value = "";
	
	$inputCodigo.focus();
}

function Abrir()
{
	var $inputCodigo = document.getElementById("inputCodigo");
	
	if ($inputCodigo.value != "") {
		$.ajax({
			url: "cadastro_ramos_ajax.php",
			dataType: 'json',
			type : "GET",
			data: {
				cdOperacao : "A",
				cdRamo : $inputCodigo.value
			},
			success: function (pJSON) {
				if (pJSON) {
					pJSON.forEach(function(objJSON){
						$inputCodigo.value = objJSON.identificador;
						document.getElementById("inputDescricao").value = objJSON.descricao;
					});
				} else {
					alert("Ramo não encontrado");
					$inputCodigo.focus();
				}
			},
			erro: function(pXHR) {
				alert(pXHR.responseText);
			}
		});
	}
}


function Recarrega() 
{
	Listagem();
	LimparCampos();
}
