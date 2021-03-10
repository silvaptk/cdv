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
                if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 0)
                {
                    include "conexao.php";
                }
                else
                {
                    $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
                    $_SESSION["tipoMensagem"] = "erroLogIn";
                    header("Location: index.php");    
                }	
				//valores digitados
				$titulo_avaliacao = mysqli_real_escape_string($bd,addslashes($_POST['titulo_avaliacao']));
				$descricao = mysqli_real_escape_string($bd,addslashes($_POST['descricao']));
				$classificacao = mysqli_real_escape_string($bd,addslashes($_POST['classificacao']));
				//codigos de usuarios
				$avaliado = $_GET['codigoInstituicao'];
				$usuario = $_SESSION['codigoUsuario'];

				//inserindo a avaliação
				$result = $bd->query("call sp_insertAvaliacao('$titulo_avaliacao','$descricao', $classificacao , $avaliado , $usuario)");

				//se inserida, prossigo
				if($result)
				{
					//$_SESSION["mensagemErro"] = "Obrigado pela avaliação!";
                    $_SESSION["mensagemErro"] = "Avaliação realizada com sucesso! muito obrigado";
                    $_SESSION["tipoMensagem"] = "avaliarInstituicao";
					header("Location: perfilInstitucionalPessoa.php?codigoInstituicao=" . $avaliado);
				}
				else
				{
					$_SESSION["mensagemErro"] = "Avaliação não inserida no banco :/";
					header("Location:avaliarInstituicao.php");
				}				
				$_bd->close();			
		?>
	</section>
</body>
</html>