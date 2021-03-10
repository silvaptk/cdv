<?php
session_start();
?>
<!DOCTYPE html>
<html lang = "pt-BR">
    <head>
        <meta charset = "UTF-8">
        <title> Cabeça de Vento </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" href = "../css/index.css"> 
        <script type = "text/javascript" src = "../js/index.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
    </head>
    <body>
        <main>
            <div class = "logo"><img src = '../img/cabecaDeVento.png' id = "logo"><span>Cabeça de Vento</span></div>
            <div class = "alinhar">
                <div class = "descricao"> Plataforma online de objetos achados e perdidos</div>
                <div class = "entrar">
                    <button id = "botaoInstituicao" onclick = "alternar(true)" tabindex = "1">Institucional</button><button id = "botaoPessoa" onclick = "alternar(false)" tabindex = "2">Pessoal</button>
                    <div class = "formulario">
                        <div id = "mensagemErro">
                            <?php 
                                if (!empty($_SESSION["mensagemErro"]) && strcmp($_SESSION["tipoMensagem"], "erroLogIn") == 0)
                                    echo $_SESSION["mensagemErro"];
                                else
                                    echo "&nbsp;&nbsp;";
                                session_destroy(); 
                            ?> 
                        </div>
                        <form name = "formularioLogin" action = "login.php" method ="POST">
                            <div class = "campo">
                                <label id = "cpf-cnpj" for = "cpf-cnpj-txt">CNPJ</label><input type = "text" name = "cpf-cnpj" id = "cpf-cnpj-txt" onkeydown = "javascript: fMasc(this)" tabindex = "3">
                            </div>
                            <div class = "campo">
                                <label for = "senha">Senha</label><input type = "password" name = "senha" id = "senha" tabindex = "4">
                            </div>
                            <input type = "button" onclick = "entrar()" value = "Entrar" id = "botao" name = "enviar" tabindex = "5">                   
                        </form> 
                        <button id = "cadastro" onclick = "cadastro()" tabindex = "6"> Ainda não tem cadastro? <b>crie já!</b> </button>        
                    </div>
                </div>
            </div>
        </main>
        <script> 
            document.getElementById("cpf-cnpj-txt").focus();
        </script>
    </body>
</html>