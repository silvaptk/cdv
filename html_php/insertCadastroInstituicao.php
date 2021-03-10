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
			
			if(!strcmp($_GET['nome'],"") == 0 && !strcmp($_GET['cpf-cnpj'],"")==0 && !strcmp($_GET['senha'], "") == 0)
			{
				if($_GET['valida'] == 1)
				{
					//dados sobre o usuario e sua localização
					$nome = mysqli_real_escape_string($bd,addslashes($_GET['nome']));
					$email = mysqli_real_escape_string($bd,addslashes($_GET['email_usuario']));
					$senha = mysqli_real_escape_string($bd,addslashes($_GET['senha']));
					$confirma_senha = mysqli_real_escape_string($bd,addslashes($_GET['confirma_senha'])); 
					$cep = mysqli_real_escape_string($bd,addslashes($_GET['cep']));
					$numero = mysqli_real_escape_string($bd,addslashes($_GET['numero']));
					$complemento = mysqli_real_escape_string($bd,addslashes($_GET['complemento']));
					$cnpj= mysqli_real_escape_string($bd,addslashes($_GET['cpf-cnpj']));
					$telefone = mysqli_real_escape_string($bd,addslashes($_GET['campoContato']));

					//dados sobre a rotina da empresa
					$abreSegunda = mysqli_real_escape_string($bd,addslashes($_GET['abreSegunda']));
					$fechaSegunda = mysqli_real_escape_string($bd,addslashes($_GET['fechaSegunda']));
					$abreTerca = mysqli_real_escape_string($bd,addslashes($_GET['abreTerca']));
					$fechaTerca = mysqli_real_escape_string($bd,addslashes($_GET['fechaTerca']));
					$abreQuarta = mysqli_real_escape_string($bd,addslashes($_GET['abreQuarta']));
					$fechaQuarta = mysqli_real_escape_string($bd,addslashes($_GET['fechaQuarta']));
					$abreQuinta = mysqli_real_escape_string($bd,addslashes($_GET['abreQuinta']));
					$fechaQuinta = mysqli_real_escape_string($bd,addslashes($_GET['fechaQuinta']));
					$abreSexta = mysqli_real_escape_string($bd,addslashes($_GET['abreSexta']));
					$fechaSexta = mysqli_real_escape_string($bd,addslashes($_GET['fechaSexta']));
					$abreSabado = mysqli_real_escape_string($bd,addslashes($_GET['abreSabado']));
					$fechaSabado = mysqli_real_escape_string($bd,addslashes($_GET['fechaSabado']));
					$abreDomingo = mysqli_real_escape_string($bd,addslashes($_GET['abreDomingo']));
					$fechaDomingo = mysqli_real_escape_string($bd,addslashes($_GET['fechaDomingo']));
					$abreFeriado = mysqli_real_escape_string($bd,addslashes($_GET['abreFeriado']));
					$fechaFeriado =  mysqli_real_escape_string($bd,addslashes($_GET['fechaFeriado']));
				
				
					if(!strcmp($cep, "") == 0)
					{		

						$result = $bd->query("call sp_cadastraInstituicao('$nome','$email','$senha','$confirma_senha','$cnpj','$cep','$telefone','$numero','$complemento','$abreSegunda','$fechaSegunda','$abreTerca','$fechaTerca','$abreQuarta','$fechaQuarta','$abreQuinta','$fechaQuinta','$abreSexta','$fechaSexta','$abreSabado','$fechaSabado','$abreDomingo','$fechaDomingo','$abreFeriado','$fechaFeriado')") or die("Erro ao chamar a procedure");

						$dados = $result->fetch_object();
						if(strcmp($dados->Mensagem,"Instituição Cadastrada com sucesso!") == 0)
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
							header("Location:perfilInstituicao.php");
						}
						else
						{
							$_SESSION["mensagemErro"] = $dados->Mensagem;
							header("Location:cadastroInstituicao.php");
						}
					}
					else
					{
						$_SESSION["mensagemErro"] = "CEP inválido";
						header("Location:cadastroInstituicao.php");
					}										 	
			 	}
			 	else
			 	{
			 		$_SESSION["mensagemErro"] = "CNPJ Inválido";
					header("Location:cadastroInstituicao.php");
			 	}
			 	$_bd->close();			
			}
			else
			{
				$_SESSION["mensagemErro"] = "Preencha todos os campos!";
				header("Location:cadastroInstituicao.php");
			}
			
		?>
	</section>
</body>
</html>