<?php
	include("conexao.php");

	$categoria = $_REQUEST['categoriaSelecionada'];

	$result = $bd->query("SELECT nm_sub_categoria,cd_sub_categoria from tb_sub_categoria where cd_categoria = (SELECT cd_categoria from tb_categoria where nm_categoria = '$categoria') order by nm_sub_categoria asc") or die ("Erro na busca das sub categorias");

	while($dados = $result->fetch_object())
	{
		$subCategorias[] = array
		(
			'nm_subCategoria' => $dados->nm_sub_categoria,
			'cd_subCategoria' => $dados->cd_sub_categoria
		);
	}
	echo (json_encode($subCategorias));
?>