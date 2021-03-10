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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Cabeça de Vento</title>
        <link rel = "stylesheet" type = "text/css" href = "../css/modificarCadastroPessoa.css">
        <script rel = "text/javascript" src = "../js/modificarCadastroPessoa.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
            <!-- PREENCHENDO AS CIDADES -->
        <script type="text/javascript">
              google.load("jquery", "1.4.2");
        </script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
     </head>
    <body>
        <div id = "principal">
			
            <div class = "titulo">Modificar Registro</div>
            <div class = "usuario"> Usuário </div>
            <div class = "informacao">Preencha somente os campos referentes a informações que deseja modificar!</div>
            <form id = "formularioCadastro" method = "POST" action = "modificarCadUsuario.php">
                <div class = "campo">
                    Nome <input type = "text" name = "nome" id = "nomeUsuario">
                </div>
                <div class = "campo">
                    E-mail <input type = "email" name = "e-mail" id = "E-mail">
                </div>
                <div class = "campoUF">                    
                    UF <select name = "campoUF" id="campoUF" class = "campoUF" onchange = "preencherCidade()">
                        <option value="0"> &nbsp;&nbsp; Selecione...</option>
                        <?php
                            $result = $bd->query("SELECT sg_uf from tb_cidade group by sg_uf order by sg_uf asc;");
                            while($dados = $result->fetch_object())
                            {       
                                echo "<option value ='".$dados->sg_uf."'> &nbsp;&nbsp;".$dados->sg_uf."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class = "campoCidade">
                   Cidade <div class="carregando"> Atualizando...</div>
                   <select name = "campoCidade" id="campoCidade" class = "campoCidade">
                       <option value= "0"> &nbsp;&nbsp; Selecione um estado...</option>
                   </select> 
                </div>                
                <div class = "campo">
                    Contato <input type = "text" name = "campoContato" id = "campoContato" maxlength = "15" onkeyup = "mascara( this, mtel );">
                </div>
                <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <input type = "submit" value = "Enviar" name="Enviar" id = "botao">
                <input type = "button" id = "voltar" value = "Voltar" onclick = "history.go(-1)">		
            </form>
            <br>            
        </div>	
        <?php
        $sql = "CALL sp_obter_dados_usuario(" . $_SESSION['codigoUsuario'] . ", 0)";
        $resultado = $bd->query($sql) or die("Erro - " . mysqli_error($bd));
        
        if($registro = $resultado->fetch_object())
        {
            echo "<script>preencherFormulario('";
            echo $registro->nome . "','";
            echo $registro->email . "','";
            echo $registro->uf . "','";
            echo $registro->cidade . "','";
            echo $registro->contato;
            echo "');</script>";
        }
        
        $resultado->close();
        $bd->next_result();
        ?>
    </body>
</html>