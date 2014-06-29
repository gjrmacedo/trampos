<?php

	include_once("classes/Conexao.php");
	include("classes/Empresa.php");
	include("classes/Ramo.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdEmpresa = isset($_GET["cdEmpresa"]) ? $_GET["cdEmpresa"] : "";
	$dsEmpresa = isset($_GET["dsEmpresa"]) ? $_GET["dsEmpresa"] : "";
	$cdCEP = isset($_GET["cdCEP"]) ? $_GET["cdCEP"] : "";
	$cdPorte = isset($_GET["cdPorte"]) ? $_GET["cdPorte"] : "";
	$cdRamo = isset($_GET["cdRamo"]) ? $_GET["cdRamo"] : "";
		
	if ($cdOperacao == "G") {
		if ($cdEmpresa == "")  {
			$objEmpresa = new Empresa();
		} else {
			$objEmpresa = Empresa::Abrir($cdEmpresa);
		}
		
		$objEmpresa->NomeFantasia = $dsEmpresa;
		$objEmpresa->CEP = $cdCEP;
		$objEmpresa->Porte = $cdPorte;
		$objEmpresa->Ativo = True;
		$objEmpresa->Ramo = $cdRamo;
		$objEmpresa->Salvar();
	
	} else if ($cdOperacao == "L") {
		$vResultado = Empresa::BuscaTodos();
		echo json_encode($vResultado);
	
	} else if ($cdOperacao == "A") {
		$vResultado = Empresa::BuscaPorId($cdEmpresa);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "E") {
		Empresa::Excluir($cdEmpresa);
	} else if ($cdOperacao == "CR") {
		$vResultado = Ramo::BuscaTodos();
		echo json_encode($vResultado);
	}
	
	
?>