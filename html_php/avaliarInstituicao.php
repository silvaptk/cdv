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
    $codigoInstituicao = mysqli_real_escape_string($bd, $_GET["codigoInstituicao"]);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Cabeça de Vento</title>
        <link rel = "stylesheet" type = "text/css" href = "../css/avaliarInstituicao.css">        
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
     </head>
    <body>
        <div id = "principal">	
            <div class = "titulo"> Avaliar Instituição </div>
            <?php
                echo '<form id = "formularioCadastro" name = "formularioCadastro" method = "POST" action = "insertAvaliacao.php?codigoInstituicao=' . $codigoInstituicao . '">';
            ?>
                <div class = "campo">
                    Título <input type = "text" name = "titulo_avaliacao" id = "titulo_avaliacao" maxlength="100">
                </div>
                <div class = "campoDescricao">
                    Descrição</div> 
                <textarea name = "descricao" id = "descricao" rows = "7" maxlength="512"></textarea>
                <input type = "button" id = "imagens" onclick = "" value = "Classificação">
                <div class = "estrelas">
                    <img src = "../img/estrelaBranca.png" id = "estrela1" onclick = "classificar(1)">
                    <img src = "../img/estrelaBranca.png" id = "estrela2" onclick = "classificar(2)">
                    <img src = "../img/estrelaBranca.png" id = "estrela3" onclick = "classificar(3)">
                    <img src = "../img/estrelaBranca.png" id = "estrela4" onclick = "classificar(4)">
                    <img src = "../img/estrelaBranca.png" id = "estrela5" onclick = "classificar(5)">
                    <script rel = "text/javascript" src = "../js/avaliarInstituicao.js"></script>
                </div>
                <input type = "hidden" id = "classificacao" name = "classificacao" value = "0">
                <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <input type = "button" value = "Enviar" id = "botao" onclick="enviar()"> <input type = "button" id = "voltar" onclick = "history.go(-1)" value = "Voltar"> 
            </form>            
        </div>		
    </body>
</html>