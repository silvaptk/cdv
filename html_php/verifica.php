<?php
	session_start();

	// Verifica se existe os dados da sessão de login
	if(!isset($_SESSION["cd_usuario"]) || !isset($_SESSION["nm_usuario"])){
		// Usuário não está logado. Falou meu chapa
		header("Locarion: index.php");
		exit;
	}
?>