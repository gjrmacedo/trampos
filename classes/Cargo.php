<?php 
class Cargo
{
	public $Identificador;
	public $Descricao;
	public $Ordem;
	public $Ativo;
		
	public function Inserir() {
		$vSql = "INSERT INTO Cargo(Descricao, Ordem, Ativo) VALUES ('". $this->Descricao ."'," . $this->Ordem . ",True)";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador, Descricao, Ordem, Ativo FROM Cargo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		$objRs = pg_fetch_object($vResultado);
		
		$objCargo= new Cargo();
		$objCargo->Identificador = $objRs->identificador;
		$objCargo->Descricao = $objRs->descricao;
		$objCargo->Ordem = $objRs->ordem;
		$objCargo->Ativo = $objRs->ativo;
		
		return $objCargo;
	}
	
	public function Alterar() {
		$vSql = "UPDATE Cargo SET Descricao = '". $this->Descricao ."', Ordem = ". $this->Ordem ." WHERE Identificador = '". $this->Identificador ."'";
		
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
		$vSql = "SELECT Identificador, Descricao, COALESCE((Ordem::VARCHAR),NULL,'') Ordem , Ativo FROM Cargo ORDER BY Identificador ";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) {
		$vSql = "SELECT Identificador, Descricao, Ordem, Ativo FROM Cargo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
	
		$vSql = "DELETE FROM Cargo WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>