<?php

	include_once("classes/Conexao.php");
	include("classes/Beneficio.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdBeneficio = isset($_GET["cdBeneficio"]) ? $_GET["cdBeneficio"] : "";
	$dsBeneficio = isset($_GET["dsBeneficio"]) ? $_GET["dsBeneficio"] : "";
	$cdOrdem = isset($_GET["cdOrdem"]) ? $_GET["cdOrdem"] : "";
	$tpValor = isset($_GET["tpValor"]) ? $_GET["tpValor"] : "";
	$tpDesconto = isset($_GET["tpDesconto"]) ? $_GET["tpDesconto"] : "";
	
	If ($cdOrdem == "") {
		$cdOrdem = "NULL";
	}
	
	if ($cdOperacao == "G") {
		if ($cdBeneficio == "")  {
			$objBeneficio = new Beneficio();
		} else {
			$objBeneficio = Beneficio::Abrir($cdBeneficio);
		}
		
		$objBeneficio->Descricao = $dsBeneficio;
		$objBeneficio->TipoValor = $tpValor;
		$objBeneficio->TipoDesconto = $tpDesconto;
		$objBeneficio->Ordem = $cdOrdem;
		$objBeneficio->Salvar();
	
	} else if ($cdOperacao == "L") {
		$vResultado = Beneficio::BuscaTodos();
		echo json_encode($vResultado);
	
	} else if ($cdOperacao == "A") {
		$vResultado = Beneficio::BuscaPorId($cdBeneficio);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "E") {
		Beneficio::Excluir($cdBeneficio);
	}
	
	
?>