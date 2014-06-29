<?php 
class Conexao
{
	private $DatabaseName;
    private $User;
    private $Host;
    private $Connection;
    private $Port;
        
    private function Conexao() {
        $this->DatabaseName = "empregos";
        $this->User = "postgres";
        $this->Host = "localhost";
        $this->Port = "5432";
        $this->Password = "macedo";
    }
    
    public function getConnection() 
    {
		$this->Connection = pg_connect(  "host=".$this->Host." ".
										"port=".$this->Port." ".
										"dbname=".$this->DatabaseName." ".
										"user=".$this->User." ".
										"password=".$this->Password)
								or die('Não foi possivel se conectar ao banco de dados. ERRO:'.
										pg_last_error($this->Connection));                                        
                                
    }
    
    public static function Conectar() 
    {
		$objConnection = new Conexao();
        $objConnection->getConnection();
		
		return $objConnection;
    }
}
?>