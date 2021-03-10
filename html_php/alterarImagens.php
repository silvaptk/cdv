<?php
session_start();
if(isset($_SESSION["logado"]))
{    
    include "conexao.php";
    
    if(!empty($_FILES["perfil"]["name"][0]))
    {
        echo "pao";
        $destino = "../img/imagens_usuarios/perfil_" . $_SESSION["codigoUsuario"] . "_"  . $_FILES["perfil"]["name"][0];
        move_uploaded_file($_FILES["perfil"]["tmp_name"][0], $destino);
        $comando = "UPDATE tb_usuario SET cd_imagem_perfil = '" . $destino . "' WHERE cd_usuario = " .  $_SESSION['codigoUsuario'] . ";";
        $resultado = $bd->query($comando) or die("Erro - " . mysqli_error($bd));
        $_SESSION["imagemPerfil"] = $destino;
        $_SESSION["mensagemErro"] = "Imagem de perfil alterada com sucesso!";
        $_SESSION["tipoMensagem"] = "alterarImagemPerfil";  
        header("location: perfilInstituicao.php");  
    }
    else
    {
        echo "Pão1";
    }

    if(!empty($_FILES["capa"]["name"][0]))
    {
        $destino = "../img/imagens_usuarios/capa_" . $_SESSION["codigoUsuario"] . "_" . $_FILES["capa"]["name"][0];
        move_uploaded_file($_FILES["capa"]["tmp_name"][0], $destino);
        $comando = "UPDATE tb_usuario SET cd_imagem_capa = '" . $destino . "' WHERE cd_usuario = " .  $_SESSION['codigoUsuario'] . ";";
        $resultado = $bd->query($comando) or die("Erro - " . mysqli_error($bd));
        $_SESSION["imagemCapa"] = $destino;
        $_SESSION["mensagemErro"] = "Imagem de capa alterada com sucesso!";
        $_SESSION["tipoMensagem"] = "alterarImagemCapa"; 
        header("location: perfilInstituicao.php");
    }
    else
    {
        echo "Pão2";
    }
    
}
else
{    
    $_SESSION["mensagemErro"] = "Insira as suas credenciais primeiro!";
    $_SESSION["tipoMensagem"] = "erroLogIn";
    header("location: index.php");
}

/*
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
*/
?>