<?php
	session_start();
	if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 1)
    {
        include "conexao.php";
    }
    else
    {
        $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
        $_SESSION["tipoMensagem"] = "erroLogIn";
        header("Location: index.php");    
    }	

	if(isset($_POST['Enviar']))
	{
		$cidade = 0;

		$nome = mysqli_real_escape_string($bd,addslashes($_POST['nome'])).trim();
		$email = mysqli_real_escape_string($bd,addslashes($_POST['e-mail'])).trim();
		$cidade = mysqli_real_escape_string($bd,addslashes($_POST['campoCidade'])).trim();
		$contato = mysqli_real_escape_string($bd,addslashes($_POST['campoContato'])).trim();
		$usuario = $_SESSION['codigoUsuario'];

		if(!empty($nome) || !empty($email) || !empty($cidade) || !empty($contato))
		{

				$atualizar = $bd->query("CALL sp_modCadUsuario($usuario, '$nome', '$email', '$contato', $cidade)") or die ("Erro no UPDATE do usuário - " . mysqli_error($bd));

				if($atualizar)
				{
                    $_SESSION["tipoMensagem"] = "alterarInformacoes";
                    $_SESSION["mensagemErro"] = "Informações alteradas com sucesso!";
					header("Location:perfilPessoa.php");
				}
				else
				{
					$_SESSION["mensagemErro"] = "Erro ao atualizar os dados.";
					header("Location:modificarCadastroPessoa.php");
				}
		}
		else
		{
			$_SESSION["mensagemErro"] = "Preencha pelo menos um campo para atualizar";
			header("Location:modificarCadastroPessoa.php");
		}

		$_bd->close();
	}
?>