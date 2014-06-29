<?php 
class Beneficio
{
	public $Identificador;
	public $Descricao;
	public $TipoValor;
	public $TipoDesconto;
	public $Ordem;
		
	public function Inserir() {
		$vSql = "INSERT INTO Beneficio(Descricao, Ordem, TipoValor, TipoDesconto) VALUES ('". $this->Descricao ."'," . $this->Ordem . ",'". $this->TipoValor . "','". $this->TipoDesconto ."')";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador, Descricao, Ordem, TipoValor, TipoDesconto FROM Beneficio WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		$objRs = pg_fetch_object($vResultado);
		
		$objBeneficio= new Beneficio();
		$objBeneficio->Identificador = $objRs->identificador;
		$objBeneficio->Descricao = $objRs->descricao;
		$objBeneficio->Ordem = $objRs->ordem;
		$objBeneficio->TipoValor = $objRs->tipovalor;
		$objBeneficio->TipoDesconto = $objRs->tipodesconto;
		
		return $objBeneficio;
	}
	
	public function Alterar() {
		$vSql = "UPDATE Beneficio 
				SET Descricao = '". $this->Descricao ."', 
					Ordem = ". $this->Ordem .",
					TipoValor = '". $this->TipoValor ."',
					TipoDesconto = '". $this->TipoDesconto ."' 
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
	
	public static function BuscaTodos() {
		$vSql = "SELECT Identificador, Descricao, COALESCE((Ordem::VARCHAR),NULL,'') Ordem FROM Beneficio ORDER BY Identificador ";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) {
		$vSql = "SELECT Identificador, Descricao, Ordem, TipoValor, TipoDesconto FROM Beneficio WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
	
		$vSql = "DELETE FROM Beneficio WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>