<?php 
class Ramo
{
	public $Identificador;
	public $Descricao;
	public $Ativo;
	
	public function Inserir() {
		$vSql = "INSERT INTO Ramo(Descricao, Ativo) VALUES ('". $this->Descricao ."','". $this->Ativo ."')";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador, Descricao, Ativo FROM Ramo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		$objRs = pg_fetch_object($vResultado);
		
		$objRamo= new Ramo();
		$objRamo->Identificador = $objRs->identificador;
		$objRamo->Descricao = $objRs->descricao;
		$objRamo->Ativo = $objRs->ativo;
		
		return $objRamo;
	}
	
	public function Alterar() {
		$vSql = "UPDATE Ramo SET Descricao = '". $this->Descricao ."' WHERE Identificador = '". $this->Identificador ."'";
		
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
	
	public static function BuscaTodos() {
		$vSql = "SELECT Identificador, Descricao, Ativo FROM Ramo ORDER BY Identificador ";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) {
		$vSql = "SELECT Identificador, Descricao, Ativo FROM Ramo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
	
		$vSql = "DELETE FROM Ramo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>