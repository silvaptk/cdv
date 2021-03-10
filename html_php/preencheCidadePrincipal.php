<?php
	include("conexao.php");
	$estado = $_REQUEST['campoUF'];
	$result = $bd->query("CALL sp_obter_cidades('$estado');") or die ("Erro na busca das cidades");
	while($dados = $result->fetch_object())
	{
		$cidades[] = array
		(
			'cd_cidade' => $dados->cd_cidade,
			'nm_cidade' => $dados->nm_cidade
		);
	}
	echo (json_encode($cidades));
?>