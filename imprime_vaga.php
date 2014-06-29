<?php
	include_once("classes/Conexao.php");
	
	Conexao::Conectar();
	
	$cdOperacao = isset($_GET["cdOperacao"]) ? $_GET["cdOperacao"] : "";
	$cdVaga = $_GET["cdVaga"];
	
	if ($cdOperacao == "V") {
		$strSQL = "SELECT v.Identificador,
						v.IdEmpresa,
						v.IdCargo,
						v.DataLancamento,
						v.Observacao,
						c.Descricao AS Cargo,
						c.Ordem,
						e.NomeFantasia,
						e.Porte,
						r.Descricao AS Ramo,
						to_char(v.Salario,'L9G999G990D99') AS Salario,
						to_char(CalculaSalario(v.Identificador),'L9G999G990D99') AS SalarioTotal
					FROM Vaga v 
					INNER JOIN Cargo c ON c.Identificador = v.IdCargo
					INNER JOIN Empresa e ON e.Identificador = v.IdEmpresa
					LEFT JOIN Ramo r ON r.Identificador = e.IdRamo
					WHERE v.Identificador = '". $cdVaga ."'";
	} else {
		$strSQL = "SELECT b.Descricao, 
					CASE 
						WHEN b.TipoValor = 'P' THEN 
							vb.ValorPercentual::VARCHAR || '(%)'
						ELSE 
							vb.Valor::VARCHAR || '(R$)' END Valor, 
					CASE
						WHEN b.TipoDesconto = 'P' THEN 
							vb.DescontoPercentual::VARCHAR || '(%)'
						ELSE 
							to_char(vb.Desconto,'L9G999G990D99') END ValorDesconto
				FROM VagaBeneficio vb
				INNER JOIN Beneficio b ON b.Identificador = vb.IdBeneficio
				WHERE IdVaga = '". $cdVaga ."'";
	}	
	
	$vResultado = pg_query($strSQL);
	$vResultado = pg_fetch_all($vResultado); 
	
	echo json_encode($vResultado);
?>