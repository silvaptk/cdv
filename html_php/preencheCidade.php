<?php
	include("conexao.php");
	$estado = $_REQUEST['campoUF'];
	$result = $bd->query("SELECT cd_cidade, nm_cidade FROM tb_cidade WHERE sg_uf = '$estado' ORDER BY nm_cidade ASC;");
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