<?php
    session_start(); 
    if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 1)
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
        <link rel = "stylesheet" type = "text/css" href = "../css/modificarAnuncioInstituicao.css">
        <script rel = "text/javascript" src = "../js/modificarAnuncioInstituicao.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
     </head>
    <body>
        <div id = "principal">  	
            <div class = "titulo"> Modificar Anúncio </div>
            <div class = "subtitulo"> Instituição </div>
            <div class = "informacao">Preencha somente os campos referentes a informações que deseja modificar!</div>
            <form enctype="multipart/form-data" id = "formularioCadastro" name="formularioCadastro"
            action="modificarAnunInstituicao.php?codigoAnuncio=<?php echo $_GET['codigoAnuncio'] ?>">
                <input type = "hidden" name = "tipoAnuncio" id = "tipoAnuncio" value ="0">
                <div class = "campo">
                    Título <input type = "text" name = "titulo" id = "titulo" maxlength="128">
                </div>
                <div class = "campoDescricao">
                    Descrição</div> 
                <textarea name = "descricao" id = "descricao" rows = "5" maxlength="512"></textarea>
                <input type = "button" onclick = "document.getElementById('imagens').click()" id = "imagensBotao" value = "Carregar imagens">
                <input type = "file" id = "imagens" name = "arquivos[]" multiple="multiple" accept="image/*">
                <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
                <div class = "campoCategoria">
                        <?php

                        $result = $bd->query("SELECT * from tb_categoria order by nm_categoria asc") or die("Erro no SELECT das categorias - ".mysqli_error($bd));                   

                        while($dados = $result->fetch_object())
                        {
                            echo '<input id = "categoria" type = "button" name = "categoria" value = "'.$dados->nm_categoria.'" onclick = "categorizar(this); verificaSubCategoria(this);">';
                        }
                    ?>
                </div>
                <input type = "hidden" name = "categoriaAnuncio" id = "categoriaAnuncio" value="0">
                <!-- Fazendo a parte dos documentos -->
                <div class = "campoSubCategoria" id="campoSubCategoria" style="display:none">
                     Documento <select name = "subCategoria" id="subCategoria" class = "subCategoria">
                       <option value= "0"> &nbsp;&nbsp; Selecione o documento...</option>
                   </select> 
                </div>
                <div class = "campoDocumento" id="campoDocumento" style="display:none">
                        Número <input type="text" name="numDocumento" id="numDocumento" maxlength="20">
                </div>                
                <!-- FIM-->  
                 <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <input type = "button" name="Enviar" value = "Enviar" id = "botao" onclick = "enviar();"><input type = "button" id = "voltar" onclick = "history.go(-1)" value = "Voltar"> 
            </form> 
            <script type="text/javascript">
            //carregando o JQUERY
            google.load("jquery", "1.4.2");
            //Fazendo os codigos
            function verificaSubCategoria(obj)
            {
                //obtendo a categoria selecionada
                var categoriaSelecionada = obj.value;
                //Por hora, trabalhando somente com a categoria de Documentos
                if(categoriaSelecionada == "Documentos") // se escolhida
                {
                    $(function(){     
                        //configurando a parte visual                        
                        document.getElementById('campoSubCategoria').style.display = 'inline-block';
                        document.getElementById('campoDocumento').style.display = 'inline-block';

                        //Enviando a categoria selecionada para obter a subCategoria
                        $.getJSON('preencheSubCategoria.php?search=',{categoriaSelecionada: $('#categoriaAnuncio').val(), ajax: 'true'}, function(j)
                        {
                            //alert(j[0].nm_subCategoria); // FUNCIONOU
                            //fazendo uma variável com as opções, iniciando pela "Escolha"
                            var options = '<option value="0"> &nbsp;&nbsp; Selecione o documento...</option>';
                            for(var i=0; i < j.length ; i++)
                            {
                                //adicionando as demais opções
                                options += '<option value="' + j[i].cd_subCategoria+ '"> &nbsp;&nbsp; ' + j[i].nm_subCategoria + '</option>';
                            }
                            //setando-as na SELECT
                            $('#subCategoria').html(options).show();
                        });                                    
                    });
                }
                else
                {
                    
                    $(function(){
                        //Desativo os campos    
                        document.getElementById('campoSubCategoria').style.display = 'none';
                        document.getElementById('campoDocumento').style.display = 'none';   
                    });
                }                
            }                
            </script>               
        </div>
        <?php
        $sql = "CALL sp_obter_anuncio_institucional(" . $_GET['codigoAnuncio'] . ");";
        $resultado = $bd->query($sql) or die("Erro - " . mysqli_error($bd));
        
        if($registro = $resultado->fetch_object())
        {
            echo "<script>";
            echo "preencherFormulario('";
            echo $registro->nomeAnuncio . "', '";
            echo $registro->descricaoAnuncio . "', '";
            echo $registro->nomeCategoria . "', ";
            echo "0, '');";
            echo "</script>";
        }
        
        $resultado->close();
        $bd->next_result();
        ?>
    </body>
</html>