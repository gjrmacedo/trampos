<?php 
class VagaBeneficio
{
	public $Identificador;
	public $IdVaga;
	public $IdBeneficio;
	public $ValorPercentual;
	public $Valor;
	public $Desconto;
	public $DescontoPercentual;
		
	public function Inserir() 
	{
		$vSql = "INSERT INTO VagaBeneficio(
									IdVaga
									,IdBeneficio
									,ValorPercentual
									,Valor
									,Desconto
									,DescontoPercentual) 
							VALUES (
									'". $this->IdVaga ."'
									,'". $this->IdBeneficio ."'
									,'". $this->ValorPercentual ."'
									,'". $this->Valor ."'
									,'". $this->Desconto ."'
									,'". $this->DescontoPercentual ."')";
		
		
		
		$vResultado = pg_query($vSql);
		$qtRegistros = pg_num_rows($vResultado);
		
		if ($qtRegistros == 0) {
			return false;
		}
		
		return true;		
	}
	
	public static function Abrir($pId)
	{
		$vSql = "SELECT Identificador,
						IdVaga,
						IdBeneficio,
						ValorPercentual,
						Valor,
						Desconto,
						DescontoPercentual 
					FROM VagaBeneficio 
					WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		$objRs = pg_fetch_object($vResultado);
		
		$objVagaBeneficio = new VagaBeneficio();
		$objVagaBeneficio->Identificador = $objRs->identificador;
		$objVagaBeneficio->IdVaga = $objRs->idvaga;
		$objVagaBeneficio->IdBeneficio = $objRs->idbeneficio;
		$objVagaBeneficio->ValorPercentual = $objRs->valorpercentual;
		$objVagaBeneficio->Valor = $objRs->valor;
		$objVagaBeneficio->Desconto = $objRs->desconto;
		$objVagaBeneficio->DescontoPercentual = $objRs->descontopercentual;
		
		return $objVagaBeneficio;
	}
	
	public function Alterar() {
		$vSql = "UPDATE VagaBeneficio 
				SET IdVaga = '". $this->IdVaga ."', 
					IdBeneficio = '". $this->IdBeneficio ."',
					ValorPercentual = '". $this->ValorPercentual ."',
					Valor = '". $this->Valor ."',
					Desconto = '". $this->Desconto ."',
					DescontoPercentual = '". $this->DescontoPercentual ."' 
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
	
	public static function BuscaTodosByVaga($pidVaga) {
		$vSql = "SELECT vb.Identificador, 
					b.Descricao, 
					CASE 
						WHEN b.TipoValor = 'P' THEN 
							vb.ValorPercentual::VARCHAR || '%'
						ELSE 
							to_char(vb.Valor,'L9G999G990D99') END Valor, 
					CASE
						WHEN b.TipoDesconto = 'P' THEN 
							vb.DescontoPercentual::VARCHAR || '%'
						ELSE 
							to_char(vb.Desconto,'L9G999G990D99') END ValorDesconto
				FROM VagaBeneficio vb
				INNER JOIN Beneficio b ON b.Identificador = vb.IdBeneficio
				WHERE IdVaga = '". $pidVaga ."'";
				
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function BuscaPorId($pId) {
		$vSql = "SELECT vb.Identificador, 
			vb.IdBeneficio, 
			CASE 
				WHEN b.TipoValor = 'P' THEN 
					vb.ValorPercentual
				ELSE 
					vb.Valor END Valor, 
			CASE
				WHEN b.TipoDesconto = 'P' THEN 
					vb.DescontoPercentual
				ELSE 
					vb.Desconto END ValorDesconto
		FROM VagaBeneficio vb
		INNER JOIN Beneficio b ON b.Identificador = vb.IdBeneficio
		WHERE vb.Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		$vResultado = pg_fetch_all($vResultado); 
		
		return $vResultado;
	}
	
	public static function Excluir($pId)
	{
	
		$vSql = "DELETE FROM VagaBeneficio WHERE Identificador = '". $pId ."'";
		
		$vResultado = pg_query($vSql);
		
		return true;	
	}
	
}
?>