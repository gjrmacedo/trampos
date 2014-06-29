<?php
	include_once("classes/Conexao.php");
	include("classes/Vaga.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdVaga = isset($_GET["cdVaga"]) ? $_GET["cdVaga"] : "";
	
	if ($cdOperacao == "E") {
		Vaga::Excluir($cdVaga);
	} else if ($cdOperacao == "L") {
		$objConsulta = Vaga::Consulta();
		echo json_encode($objConsulta);	
	}
?>