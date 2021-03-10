<?php
	session_start();
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

	
		$tipoAnuncio = mysqli_real_escape_string($bd,addslashes($_POST['tipoAnuncio']));
		$titulo = mysqli_real_escape_string($bd,addslashes($_POST['titulo']));
		$descricao = mysqli_real_escape_string($bd,addslashes($_POST['descricao']));
		$categoria = mysqli_real_escape_string($bd,addslashes($_POST['categoriaAnuncio']));
		$anuncio = $_GET['codigoAnuncio'];
		$modificou = false;

		if(!empty(trim($tipoAnuncio)) || !empty(trim($titulo)) || !empty(trim($descricao)) || !empty(trim($categoria)))
		{
			$modificou = true;
			$atualizar = $bd->query("CALL sp_modAnunUsuario($anuncio, $tipoAnuncio, '$titulo', '$descricao', '$categoria')") or die ("Erro no UPDATE da instituição - " . mysqli_error($bd));

				if($atualizar)	
				{				
					$_SESSION["mensagemErro"] = "&nbsp;&nbsp;";
					header("Location:perfilPessoa.php");
				}
				else
				{
					$_SESSION["mensagemErro"] = "Erro ao atualizar os dados.";
					header("Location:modificarAnuncioPessoa.php");
				}
		}
		if(!empty($_FILES["arquivos"]["name"][0]))
		{
			$modificou = true;
			#Indice de identificacao da ordem de tratamento do arquivos no servidor
			$i = 0;
			//variaveis de controle (Finalidade de teste)
			$suc = 0;
			$erro = 0;						 
				
			//verificando se há alguma imagem
			
			if(!empty($_FILES["arquivos"]["name"][0]))
			{
				$del = $bd->query("DELETE FROM tb_imagem WHERE cd_anuncio = $anuncio") or die ("Erro no DELETE das imagens - " . mysqli_error($bd));

				
					//caso tenha, verifico posição por posição e vinculo ao anuncio
					foreach ($_FILES["arquivos"]["error"] as $key => $error)  
					{				   
					    #Pasta e codigo do anuncio, para tornar a imagem unica perante a pasta
					    $destino = "../img/imagens_anuncios/".$anuncio."_"; 
					    //concatenando o nome da imagem
					    $destino .=$_FILES["arquivos"]["name"][$i];
					    
					    #Move o arquivo para o diretório de destino
					    move_uploaded_file($_FILES["arquivos"]["tmp_name"][$i], $destino );
					    //adicionando barras invertidas antes de caracteres como ' para inserir no banco
					    $destino = addslashes($destino); 
					    
					    //Inserindo o caminho da imagem no banco
					    $result = $bd->query("INSERT INTO tb_imagem(cd_caminho,cd_anuncio) values ('$destino', $anuncio)");
							    
					    //verificando o sucesso ou fracasso
					    if($result)    
					    	$suc = $suc +1;
					    else
					    	$erro = $erro +1;
					 
					    #Próximo arquivo a ser analisado
					    $i++;
					}
					$_SESSION["mensagemErro"] = "&nbsp;&nbsp;";
					header("Location:perfilPessoa.php");				
			}
		}
		if(!$modificou)
		{
			$_SESSION["mensagemErro"] = "Preencha pelo menos um campo para atualizar";
			header("Location:modificarAnuncioPessoa.php");
		}		

	$_bd->close();
?>