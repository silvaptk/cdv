<?php
    session_start(); 
    include ("conexao.php");
?>
 
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Cabeça de Vento</title>
        <link rel = "stylesheet" type = "text/css" href = "../css/cadastroPessoa.css">
        <script rel = "text/javascript" src = "../js/cadastroPessoa.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
     </head>
    <body>
        <header>
            <img src = "../img/logoBlue.png">
            <div class = "cabecalho">
                <div class = "titulo"> Registro </div>
                <div class = "usuario"> Pessoa </div>
            </div>
        </header>

        <main>
            <form id = "formularioCadastro" name = "formularioCadastro">
                <label for = "nome">
                    <span>Nome</span>
                    <input type = "text" name = "nome" id = "nome" maxlength = "65" tabindex = "1">
                </label>
                <label for = "e-mail">
                    <span>E-mail</span>
                    <input type = "email" name = "e-mail" id = "e-mail" maxlength = "100" tabindex = "2">
                </label>
                <label for = "senha">
                    <span>Senha</span>
                    <input type = "password" name = "senha" id = "senha" maxlength = "40" tabindex = "3">
                </label>
                <label for = "confirma_senha">
                    <span>Repetir a senha</span>
                    <input type = "password" name = "confirma_senha" id = "confirma_senha" maxlength = "40" tabindex = "4">
                </label>
                <label for = "cpf-cnpj-txt">
                    <span>CPF</span>
                    <input type = "text" name = "cpf-cnpj" id = "cpf-cnpj-txt" onkeydown = "javascript: fMasc(this)" onchange = "validarCPF(this)" tabindex = "5">
                </label>
                <input type = "hidden" id = "valida" name = "valida" value = "0">
                <fieldset>
                    <label class = "UF" for = "campoUF">
                        <span>UF</span> 
                        <select name = "campoUF" id = "campoUF" class = "campoUF" tabindex = "6">
                            <option value = ""> &nbsp;&nbsp; Selecione...</option>
                            <?php
                                $result = $bd->query("SELECT sg_uf from tb_cidade group by sg_uf order by sg_uf asc;");
                                while($dados = $result->fetch_object())
                                {       
                                    echo "<option value ='".$dados->sg_uf."'> &nbsp;&nbsp;".$dados->sg_uf."</option>";
                                }
                            ?>
                        </select>
                    </label>  
                    <label class = "cidade" for = "campoCidade">
                        <span>Cidade</span>
                        <span class = "carregando" id = "carregando">Atualizando...</span>
                        <select name = "campoCidade" id="campoCidade" tabindex = "7">
                            <option value= ""> &nbsp;&nbsp;Selecione um estado...</option>
                        </select> 
                    </label>
                </fieldset>
                <label for = "campoContato">
                    <span>Contato</span>
                    <input type = "text" name = "campoContato" id = "campoContato" maxlength = "15" onkeyup = "mascara( this, mtel );" tabindex = "8">
                </label>
                <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <input type = "button" name = "Enviar" value = "Enviar" id = "botao" onclick="enviar()" tabindex = "9"><input type = "button" id = "voltar" onclick = "window.location.href = 'index.php'" value = "Voltar" tabindex = "10">		
            </form>

            <!-- Preenchendo campo de cidades -->
            <script type="text/javascript">
              google.load("jquery", "1.4.2");
            </script>
            <script type="text/javascript">
                $(function(){
                    $('#campoUF').change(function(){
                        if( $(this).val() ) {
                            
                            document.getElementById('carregando').style.display = 'inline-block';
                            document.getElementById('campoCidade').style.display = 'none';
                            $.getJSON('preencheCidade.php?search=',{campoUF: $(this).val(), ajax: 'true'}, function(j){
                                var options = '<option value=""> &nbsp;&nbsp; Selecione...</option>'; 
                                for (var i = 0; i < j.length; i++) {
                                    options += '<option value="' + j[i].cd_cidade + '"> &nbsp;&nbsp; ' + j[i].nm_cidade + '</option>';
                                }   
                                $('#campoCidade').html(options).show();
                                document.getElementById('carregando').style.display = 'none';
                            });
                        } else {
                            $('#campoCidade').html('<option value=""> &nbsp;&nbsp; Selecione um estado...</option>');
                        }
                    });
                });
            </script>
            <br>            
        </main>		
    </body>
</html>