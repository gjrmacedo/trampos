<?php
	include_once("classes/Conexao.php");
	include("classes/Vaga.php");
	include("classes/Empresa.php");
	include("classes/Cargo.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdVaga = isset($_GET["cdVaga"]) ? $_GET["cdVaga"] : "";
	$cdEmpresa = isset($_GET["cdEmpresa"]) ? $_GET["cdEmpresa"] : "";
	$cdCargo = isset($_GET["cdCargo"]) ? $_GET["cdCargo"] : "";
	$stVaga = isset($_GET["stVaga"]) ? $_GET["stVaga"] : "";
	$vlSalario = isset($_GET["vlSalario"]) ? $_GET["vlSalario"] : "";
	$dtVaga = isset($_GET["dtVaga"]) ? $_GET["dtVaga"] : "";
	$dsObervacao = isset($_GET["dsObervacao"]) ? $_GET["dsObervacao"] : "";
	
	if($cdOperacao == "G"){
		if ($cdVaga == "") {
			$objVaga = new Vaga(); 
		} else {
			$objVaga = Vaga::Abrir($cdVaga);
		}
		
		$objVaga->IdEmpresa = $cdEmpresa;
		$objVaga->IdCargo = $cdCargo;
		$objVaga->Salario = $vlSalario;
		$objVaga->Status = $stVaga;
		$objVaga->Data = $dtVaga;
		$objVaga->Observacao = $dsObervacao;
		
		$objVaga->Salvar();
		
	} else if ($cdOperacao == "CE"){
		$objConsulta = Empresa::BuscaTodos();
		echo json_encode($objConsulta);
	} else if ($cdOperacao == "CC"){
		$objConsulta = Cargo::BuscaTodos();
		echo json_encode($objConsulta);
	} else if ($cdOperacao == "A") {
		$objConsulta = Vaga::BuscaPorId($cdVaga);
		echo json_encode($objConsulta);
	} 
?>