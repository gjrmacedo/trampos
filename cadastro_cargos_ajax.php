<?php

	include_once("classes/Conexao.php");
	include("classes/Cargo.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdCargo = isset($_GET["cdCargo"]) ? $_GET["cdCargo"] : "";
	$dsCargo = isset($_GET["dsCargo"]) ? $_GET["dsCargo"] : "";
	$cdOrdem = isset($_GET["cdOrdem"]) ? $_GET["cdOrdem"] : "";
	
	If ($cdOrdem == "") {
		$cdOrdem = "NULL";
	}
	
	if ($cdOperacao == "G") {
		if ($cdCargo == "")  {
			$objCargo = new Cargo();
		} else {
			$objCargo = Cargo::Abrir($cdCargo);
		}
		
		$objCargo->Descricao = $dsCargo;
		$objCargo->Ordem = $cdOrdem;
		$objCargo->Salvar();
	
	} else if ($cdOperacao == "L") {
		$vResultado = Cargo::BuscaTodos();
		echo json_encode($vResultado);
	
	} else if ($cdOperacao == "A") {
		$vResultado = Cargo::BuscaPorId($cdCargo);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "E") {
		Cargo::Excluir($cdCargo);
	}
	
	
?>