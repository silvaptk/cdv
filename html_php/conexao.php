<?php
	class foo_mysqli extends mysqli
	{
		public function __construct($host, $usr, $pass, $bd)
		{
			parent::__construct($host, $usr, $pass, $bd);
			if (mysqli_connect_error())
			{
				die("Erro de conexão(" . mysqli_connect_errno() . "): " . mysqli_connect_error());
			}
		}
	}	
	
    // É preciso preencher as credenciais a seguir para que a conexão suceda
    $bdHost = ''; 
    $bdPwd = '';
	$bd = new foo_mysqli('localhost', $bdHost, $bdPwd, 'cabeca_de_vento');
?>
