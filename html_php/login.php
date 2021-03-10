 <?php
    session_start(); 
 	include "conexao.php"; 	
 	
 	if(isset($_POST['cpf-cnpj']))
 	{	
		// Variável global da sessão 'logado'
		$_SESSION['logado'] = false;
	 	
	 	// Recuperar login e senha
	 	$login = mysqli_real_escape_string($bd,$_POST["cpf-cnpj"]);
		$senha = mysqli_real_escape_string($bd,$_POST["senha"]);
		
		// Executando a consultando banco, se numero de linhas retonado = 1, login valido, caso seja 0, login invalido
	 	$result_id = $bd->query("SELECT cd_usuario, nm_usuario, cd_cadastro_nacional, cd_senha_usuario, ic_instituicao, cd_imagem_perfil, cd_imagem_capa FROM tb_usuario WHERE cd_cadastro_nacional = '$login'")or die("Erro na verificação de usuário");

	 	//obtendo a quantia de registros
	 	$total = mysqli_num_rows($result_id);

	 	// Caso o usuário tenha digitado um login válido o número de lnhas será 1
	 	if($total >= 1)
	 	{
	 		// Obtém os dados do usuário
	 		$dados = $result_id->fetch_object();

	 		if(!strcmp($senha, $dados->cd_senha_usuario))
	 		{
	 			// Por enquanto ta tudo tranquilo. Agora passar os dados para a sessão e redirecionar o usuário
	 			$_SESSION["logado"] = true;
	 			$_SESSION["codigoUsuario"] = $dados->cd_usuario;
	 			$_SESSION["nomeUsuario"] = $dados->nm_usuario;
	 			$_SESSION["tipoUsuario"] = $dados->ic_instituicao;
                $_SESSION["imagemPerfil"] = $dados->cd_imagem_perfil;
                $_SESSION["imagemCapa"] = $dados->cd_imagem_capa;
	 			$_SESSION["novaConversa"] = 0;

	 			if($dados->ic_instituicao == 0)
	 			{
	 				//caso seja uma pessoa comum, direcianos para o feed
	 				header("Location: principalPessoa.php");
	 			}
	 			else
	 			{
	 				//caso seja uma empresa, direcionamos para o seu perfil
	 				header("Location: perfilInstituicao.php");
	 			}	 			
	 		}
	 		else
	 		{
	 			//senhas diferem, mas conforme SD: "Dados incorretos"
	 			$_SESSION["mensagemErro"] = "Dados incorretos";
                $_SESSION["tipoMensagem"] = "erroLogIn"; 
				header("Location: index.php");
	 		}
	 	}
	 	else
	 	{
	 		//nenhum usuário encontrado
	 		$_SESSION["mensagemErro"] = "Dados incorretos";
			header("Location: index.php");
	 	}
	}
	else
	{
		$_SESSION["mensagemErro"] = "Preencha os campos de login";
		header("Location:index.php");
	}
 ?>