<?php 
	session_start();
	include "conexao.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title> Cadastrando empresa no banco</title>
	<meta charset="utf-8">
</head>
<body>
	<section>

		<?php

			if(isset($_POST['nome']) && isset($_POST['senha']) && isset($_POST['e-mail']))
			{							
			
				$nome = mysqli_real_escape_string($bd,addslashes($_POST['nome']));
				$email = mysqli_real_escape_string($bd,addslashes($_POST['e-mail']));
				$senha = mysqli_real_escape_string($bd,addslashes($_POST['senha']));
				$confirma_senha = mysqli_real_escape_string($bd,addslashes($_POST['confirma_senha'])); 
				$cidade = mysqli_real_escape_string($bd,addslashes($_POST['campoCidade']));
				$uf = mysqli_real_escape_string($bd,addslashes($_POST['campoUF']));
				$cpf= mysqli_real_escape_string($bd,addslashes($_POST['cpf-cnpj']));
				$telefone = mysqli_real_escape_string($bd,addslashes($_POST['campoContato']));

				if($_POST['valida'] == 1)
				{
					if(!strcmp($uf, "") == 0)
					{
						if(!strcmp($cidade, "") == 0)
						{						
							$result = $bd->query("call sp_cadastraUsuario('$nome','$email','$senha','$confirma_senha','$cpf','$cidade','$telefone')");
								
							$dados = $result->fetch_object();
								
							if(strcmp($dados->Mensagem,"Usuário Cadastrado com sucesso!") == 0)
							{
								//liberando banco para nova consulta
								$result->close();
								$bd->next_result();
								
								//obtendo os dados do usuário
								$result2 = $bd->query("SELECT cd_usuario,nm_usuario,ic_instituicao FROM tb_usuario where cd_usuario = (SELECT max(cd_usuario) from tb_usuario)");
								//fazendo um objeto com as informãções
								$dados2 = $result2->fetch_object();

								//setando os dados na sessão e direcionando-o para sua respectova página
								$_SESSION["logado"] = true;
					 			$_SESSION["codigoUsuario"] = $dados2->cd_usuario;
					 			$_SESSION["nomeUsuario"] = $dados2->nm_usuario;
					 			$_SESSION["tipoUsuario"] = $dados2->ic_instituicao;
								header("Location:perfilPessoa.php");
							}
							else
							{
								$_SESSION["mensagemErro"] = $dados->Mensagem;
								header("Location:cadastroPessoa.php");
							}	
						}
						else
						{
							$_SESSION["mensagemErro"] = "Selecione uma cidade";
							header("Location:cadastroPessoa.php");
						}										 	
				 	}
				 	else
				 	{
				 		$_SESSION["mensagemErro"] = "Selecione um estado e uma cidade";
						header("Location:cadastroPessoa.php");
				 	}	
				}
				else
				{
					$_SESSION["mensagemErro"] = "CPF Inválido";
					header("Location:cadastroPessoa.php");
				}			
			}
			else
			{
				$_SESSION["mensagemErro"] = "Preencha todos os campos!";
				header("Location:cadastroPessoa.php");
			}
			$_bd->close();
		?>
	</section>
</body>
</html>