<?php

	include_once("classes/Conexao.php");
	include("classes/Ramo.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdRamo = isset($_GET["cdRamo"]) ? $_GET["cdRamo"] : "";
	$dsRamo = isset($_GET["dsRamo"]) ? $_GET["dsRamo"] : "";
	
	if ($cdOperacao == "G") {
		if ($cdRamo == "")  {
			$objRamo = new Ramo();
		} else {
			$objRamo = Ramo::Abrir($cdRamo);
		}
		
		$objRamo->Descricao = $dsRamo;
		$objRamo->Ativo = True;
		$objRamo->Salvar();
	
	} else if ($cdOperacao == "L") {
		$vResultado = Ramo::BuscaTodos();
		echo json_encode($vResultado);
	
	} else if ($cdOperacao == "A") {
		$vResultado = Ramo::BuscaPorId($cdRamo);
		echo json_encode($vResultado);
	} else if ($cdOperacao == "E") {
		Ramo::Excluir($cdRamo);
	}
?>