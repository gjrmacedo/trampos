<?php 
class Vaga
{
	public $Identificador;
	public $IdEmpresa;
	public $IdCargo;
	public $Data;
	public $Salario;
	public $Status;
	public $Observacao;
		
	public function Inserir() 
	{
		$vSql = "INSERT INTO Vaga (IdEmpresa,
							IdCargo,
							DataLancamento,
							Status,
							Salario,
							Observacao )
						VALUES (
							'". $this->IdEmpresa 	."',
							'". $this->IdCargo 		."',
							'". $this->Data 		."',
							'". $this->Status 		."',
							'". $this->Salario 		."',
							'". $this->Observacao 	."' ) ";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador, IdEmpresa, IdCargo, DataLancamento, Status, Salario, Observacao FROM Vaga WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$objRs = pg_fetch_object($vResultado);
		
		$objVaga= new Vaga();
		$objVaga->Identificador = $objRs->identificador;
		$objVaga->IdEmpresa = $objRs->idempresa;
		$objVaga->IdCargo = $objRs->idcargo;
		$objVaga->DataLancamento = $objRs->datalancamento;
		$objVaga->Status = $objRs->status;
		$objVaga->Salario = $objRs->salario;
		$objVaga->Observacao = $objRs->observacao;
		
		return $objVaga;
	}
	
	public function Alterar() 
	{
		$vSql = "UPDATE Vaga SET IdEmpresa = '". $this->IdEmpresa ."'
						,IdCargo = '". $this->IdCargo ."'
						,DataLancamento = '". $this->Data ."'
						,Status = '". $this->Status ."'
						,Salario = '". $this->Salario ."' 
						,Observacao = '". $this->Observacao ."' 
					WHERE Identificador = '". $this->Identificador ."'";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public function Salvar()
	{
		if ($this->Identificador == "") {
			return $this->Inserir();
		} else {
			return $this->Alterar();
		}
	}
	
	public static function Consulta() 
	{
		$vSql = "SELECT v.Identificador,
					v.DataLancamento,
					to_char(v.Salario,'L9G999G990D99') AS Salario,
					v.Status,
					e.NomeFantasia,
					c.Descricao,
					c.Ordem
				FROM Vaga v
				INNER JOIN Empresa e ON (e.Identificador = v.IdEmpresa)
				INNER JOIN Cargo c ON (c.Identificador = v.IdCargo)
				ORDER BY c.Ordem,
					v.DataLancamento";

		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) 
	{
		$vSql = "SELECT Identificador, IdCargo, IdEmpresa, Salario, Status, DataLancamento, Observacao FROM Vaga WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
		$vSql = "DELETE FROM Vaga WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>