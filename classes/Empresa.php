<?php 
class Empresa
{
	public $Identificador;
	public $NomeFantasia;
	public $CEP;
	public $Porte;
	public $Ativo;
	public $Ramo;
		
	public function Inserir() {
		If ($this->Ramo == "") {
			$this->Ramo = "NULL";
		}
	
		$vSql = "INSERT INTO Empresa(NomeFantasia,CEP,Porte,Ativo,IdRamo) VALUES ('". $this->NomeFantasia ."','" . $this->CEP . "','". $this->Porte ."','". $this->Ativo ."',".$this->Ramo.")";
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador, NomeFantasia, Porte, Ativo, CEP FROM Empresa WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		$objRs = pg_fetch_object($vResultado);
		
		$objEmpresa= new Empresa();
		$objEmpresa->Identificador = $objRs->identificador;
		$objEmpresa->NomeFantasia = $objRs->nomefantasia;
		$objEmpresa->Porte = $objRs->porte;
		$objEmpresa->CEP = $objRs->cep;
		$objEmpresa->Ativo = $objRs->ativo;
		$objEmpresa->Ramo = $objRs->idramo;
		
		return $objEmpresa;
	}
	
	public function Alterar() 
	{
		If ($this->Ramo == "") {
			$this->Ramo = "NULL";
		}
	
		$vSql = "UPDATE Empresa SET NomeFantasia = '". $this->NomeFantasia ."', Porte = '". $this->Porte ."', CEP = '". $this->CEP ."', IdRamo = " . $this->Ramo . " WHERE Identificador = '". $this->Identificador ."'";
		
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
		$vSql = "SELECT E.Identificador 
					,E.NomeFantasia 
					,E.Porte 
					,E.Ativo 
					,COALESCE(R.Descricao,NULL,'') Descricao
				FROM Empresa E 
				LEFT JOIN Ramo R ON E.IdRamo = R.Identificador
				ORDER BY Identificador ";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) {
		$vSql = "SELECT Identificador, NomeFantasia, Porte, Ativo, IdRamo, CEP FROM Empresa WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
	
		$vSql = "DELETE FROM Empresa WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>