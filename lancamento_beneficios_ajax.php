<?php

	include_once("classes/Conexao.php");
	include("classes/VagaBeneficio.php");
	include("classes/Beneficio.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdVagaBeneficio = isset($_GET["cdVagaBeneficio"]) ? $_GET["cdVagaBeneficio"] : "";
	$cdBeneficio = isset($_GET["cdBeneficio"]) ? $_GET["cdBeneficio"] : "";
	$cdVaga = isset($_GET["cdVaga"]) ? $_GET["cdVaga"] : "";
	$vlBeneficio = isset($_GET["vlBeneficio"]) ? $_GET["vlBeneficio"] : "";
	$vlDesconto = isset($_GET["vlDesconto"]) ? $_GET["vlDesconto"] : "";
	
	$vlBeneficio = ($vlBeneficio != "") ? $vlBeneficio : 0;
	$vlDesconto = ($vlDesconto != "") ? $vlDesconto : 0;
		
	if ($cdOperacao == "G") {
		if ($cdVagaBeneficio == "")  {
			$objVagaBeneficio = new VagaBeneficio();
		} else {
			$objVagaBeneficio = VagaBeneficio::Abrir($cdVagaBeneficio);
		}
		
		$objBeneficio = Beneficio::Abrir($cdBeneficio);
		
		$objVagaBeneficio->IdVaga = $cdVaga;
		$objVagaBeneficio->IdBeneficio = $cdBeneficio;
		
		if ($objBeneficio->TipoValor == "V") {
			$objVagaBeneficio->Valor = $vlBeneficio;
			$objVagaBeneficio->ValorPercentual = 0;
		} else {
			$objVagaBeneficio->Valor = 0;
			$objVagaBeneficio->ValorPercentual = $vlBeneficio;
		} 
		
		if ($objBeneficio->TipoDesconto == "V") {
			$objVagaBeneficio->Desconto = $vlDesconto;
			$objVagaBeneficio->DescontoPercentual = 0;
		} else {
			$objVagaBeneficio->Desconto = 0;
			$objVagaBeneficio->DescontoPercentual = $vlDesconto;
		}	
		
		$objVagaBeneficio->Salvar();
	
	} else if ($cdOperacao == "L") {
		$vResultado = VagaBeneficio::BuscaTodosByVaga($cdVagaBeneficio);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "A") {
		$vResultado = VagaBeneficio::BuscaPorId($cdVagaBeneficio);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "C") {
		$vResultado = Beneficio::BuscaTodos();
		echo json_encode($vResultado);
	} else if ($cdOperacao == "E") {
		VagaBeneficio::Excluir($cdVagaBeneficio);
	}
	
	
?>