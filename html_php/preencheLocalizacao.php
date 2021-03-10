<?php
	
	include("conexao.php");

	$cep = $_REQUEST['cep'];

	$result = $bd->query("SELECT c.nm_cidade as 'Cidade', b.nm_bairro as 'Bairro', c.sg_uf as 'Uf', e.nm_endereco as 'Logradouro' from tb_endereco as e join tb_cidade as c on c.cd_cidade = e.cd_cidade join tb_bairro as b on b.cd_bairro = e.cd_bairro where e.cd_cep = $cep") or die ("Erro no SELECT do JQUERY");
		
	if($result)
	{
		while($dados = $result->fetch_object())
		{
			$info[] = array
			(
				'cidade' => $dados->Cidade,
				'bairro' => $dados->Bairro,
				'uf' 	 => $dados->Uf,
				'rua' 	 => $dados->Logradouro
			);
		}			
		echo (json_encode($info));			
	}		
?>
