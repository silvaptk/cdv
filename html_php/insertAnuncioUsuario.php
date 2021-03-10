<?php 
	session_start();
	include("conexao.php");
	header('Content-Type: text/html; charset=utf-8');	
?>

<!DOCTYPE html>
<html>
<head>
	<title> Cadastrando empresa no banco</title>
	<meta charset="UTF-8">
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
        
			if(isset($_POST['nome_anuncio']) && isset($_POST['descricao']) && isset($_POST['categoriaAnuncio']) && isset($_POST['tipoAnuncio']))
			{
				//tratando do anuncio
				$ic_perda= mysqli_real_escape_string($bd,addslashes($_POST['tipoAnuncio']));
				$anuncio = mysqli_real_escape_string($bd,addslashes($_POST['nome_anuncio']));
				$descricao = mysqli_real_escape_string($bd,addslashes($_POST['descricao']));
				$categoria = mysqli_real_escape_string($bd,addslashes($_POST['categoriaAnuncio']));
				$usuario = $_SESSION['codigoUsuario'];
				$documento = mysqli_real_escape_string($bd,addslashes($_POST['numDocumento']));
				$subCategoria = mysqli_real_escape_string($bd,addslashes($_POST['subCategoria']));

				$result = $bd->query("call sp_insertAnuncioPessoa('$anuncio','$descricao', $ic_perda , $usuario ,'$categoria',$subCategoria,'$documento')") or die ("Erro no insert");

				$dados = $result->fetch_object();
				$documentoExistente = $dados->documentoExistente;

				if($result)
				{
					if($documentoExistente != null && $documentoExistente > 0 && $documentoExistente != "")
					{	
                        $_SESSION["tipoMensagem"] = "documentoExistente";
                        $_SESSION["mensagemErro"] = "De acordo com as informações fornecidas, encontramos o seu documento e já iniciamos uma conversa para facilitar o seu trabalho!";
						//Iniciando a conversa entre os usuários
						header("Location:iniciarConversa.php?codigoAnuncio=$documentoExistente");
					}
					else
					{
						$result->close();
						$bd->next_result();
									
						//caso anuncio tenha sido inserido, vinculo as imagens ao anuncio
						
						#Indice de identificacao da ordem de tratamento do arquivos no servidor
						$i = 0;
						$suc = 0;
						$erro = 0;

						//selecionando o codigo do anuncio para concetenar ao nome da imagem
						$result = $bd->query("SELECT max(cd_anuncio) as codigoAnuncio from tb_anuncio");
						$dados = $result->fetch_object();
						
						//verificando se há alguma imagem
						if(!empty($_FILES["arquivos"]["name"][0]))
						{
							//caso tenha, verifico posição por posição e vinculo ao anuncio
							foreach ($_FILES["arquivos"]["error"] as $key => $error)  
							{				   
							    #Pasta e codigo do anuncio, para tornar a imagem unica perante a pasta
							    $destino = "../img/imagens_anuncios/".$dados->codigoAnuncio."_"; 
							    //concatenando o nome da imagem
							    $destino .=$_FILES["arquivos"]["name"][$i];
							    
							    #Move o arquivo para o diretório de destino
							    move_uploaded_file($_FILES["arquivos"]["tmp_name"][$i], $destino );
							    //adicionando barras invertidas antes de caracteres como ' para inserir no banco
							    $destino = addslashes($destino); 
							    
							    //Inserindo o caminho da imagem no banco
							    $result = $bd->query("INSERT INTO tb_imagem(cd_caminho,cd_anuncio) values ('$destino', (SELECT max(cd_anuncio) from tb_anuncio))");
							    
							    //verificando o sucesso ou fracasso
							    if($result)    
							    	$suc = $suc +1;
							    else
							    	$erro = $erro +1;
							 
							    #Próximo arquivo a ser analisado
							    $i++;
							}
						}					

						//$_SESSION["mensagemErro"] = "Anúncio inserido.";
						header("Location:perfilPessoa.php");
					}
				}
				else
				{
					$_SESSION["mensagemErro"] = "Anúncio não inserido";
					header("Location:anunciarPessoa.php");
				}
			}
			else
			{
				echo "Nada selecionado.";
			}		
		?>
	</section>
</body>
</html>