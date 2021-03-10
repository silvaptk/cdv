<?php
	session_start();
    if (isset($_SESSION["logado"]))
    {
        include "conexao.php";
    }
    else
    {
        $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
        $_SESSION["tipoMensagem"] = "erroLogIn";
        header("Location: index.php");    
    }
	header('Content-Type: text/html; charset=utf-8');

	$dados = $_REQUEST['dados'];
	$mensagem = $dados[0];
	$usuario = $dados[1];
	$codigoConversa = $dados[2];	

	if($codigoConversa != 0)
	{
		if(strlen($mensagem) > 0)
		{
			$result = $bd->query("INSERT into tb_mensagem(ds_mensagem,cd_conversa,dt_mensagem,cd_usuario) values ('$mensagem',$codigoConversa,now(),$usuario)");
		}
	}
	

?>