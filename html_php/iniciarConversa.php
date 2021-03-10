<?php
	
	session_start();
    if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 0)
    {
        include "conexao.php";
	   header('Content-Type: text/html; charset=utf-8');
    }
    else
    {
        $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
        $_SESSION["tipoMensagem"] = "erroLogIn";
        header("Location: index.php");    
    }

	//Informações para iniciar uma conversa
	$codigoAnuncio = mysqli_real_escape_string($bd,addslashes($_GET['codigoAnuncio'])); //futuro GET
	$codigoRemetente = $_SESSION['codigoUsuario'];
		
	$result = $bd->query("call sp_verificaConversa($codigoAnuncio,$codigoRemetente)");

	if($result)
	{
		$dados = $result->fetch_object();
		//Redireciono ao chat
		$_SESSION['novaConversa'] = $dados->Conversa;
		header("Location:chat.php");

	}
	else
	{
		echo "Erro ao iniciar a conversa";
		//Não inseriu conversa, deu RUIM!
		/*
		$_SESSION["mensagemErro"] = "Não foi possível iniciar a conversa.";
		header("Location:x.php");
		*/
	}
?>