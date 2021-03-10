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
        <title> Cabeça de Vento </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" href = "../css/principalPessoa.css"> 
        <script type = "text/javascript" src = "../js/principalPessoa.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <script rel = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
    <body>
        <div id = "barraSuperior">
            <div class = "logo"><img src = "../img/logoBlue.png" id = "logoBarra"></div>
            <button id = "perfil" onclick = "window.location.href = 'perfilPessoa.php'">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroPessoa.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
        <img id = "logo" src = "../img/cabecaDeVento.png">
        <div id = "principal">
            <form id = "pesquisa" method = "GET" action = "principalPessoa.php">
                <!-- Para pesquisar por categoria -->
                <input type = "hidden" name = "categoria" value = "" id = "txtCategoria">
                
                <!-- Para pesquisar por tipo de usuário - ou instituição (1) ou pessoa (2) ou ambos (0) -->
                <input type = "hidden" name = "tipoUsuario" value = "0" id = "txtUsuario">
                
                <!-- Para pesquisar por tipo de anúncio - encontro (1) ou perda (2) ou ambos (0) -->
                <input type = "hidden" name = "tipoAnuncio" value = "0" id = "txtAnuncio">
                
                <div class = "campoPesquisa">
                    <input type = "text" id = "txtPesquisa" name = "palavrasChave" placeholder = "Digite palavras-chave aqui para otimizar a busca...">
                </div>
                <div class = "campoUF">                    
                    UF <select name = "uf" id="campoUF" class = "campoUF">
                        <option value=""> &nbsp;&nbsp; Selecione...</option>
                        <?php
                            $result = $bd->query("CALL sp_obter_estados();");
                            while($dados = $result->fetch_object())
                            {       
                                echo "<option value ='".$dados->sg_uf ."'> &nbsp;&nbsp;".$dados->sg_uf ."</option>";
                            }
                        ?>
                    </select>
                </div>  
                <div class = "campoCidade">
                   Cidade <div class="carregando" id="carregando"> Atualizando...</div>
                   <select name = "cidade" id="campoCidade">
                       <option value= ""> &nbsp;&nbsp;Selecione um estado...</option>
                   </select> 
                </div>
                <div class = "campoCategoria">
                    <input id = "btnCategoria" type = "button" onclick = "exibirCategorias()" value = "Selecionar categoria">
                </div>
                <div id = "categorias">
                    <?php
                    $bd->next_result();
                    $sql = "CALL sp_obter_categorias()";
                    $resultado = $bd->query($sql)or die("Problemas com o SELECT para as categorias");
                    
                    while($registro = $resultado->fetch_object())
                    {
                        echo "<input type = 'button' class = 'opcaoCategoria' value = " . $registro->nm_categoria . " onclick = 'setarCategoria(this, " . $registro->cd_categoria . ")'>";
                    }
                    
                    $resultado->close();
                    $bd->next_result();
                    ?>                    
                </div>
                <input type = "submit" id = "btnPesquisar" name = "filtrar" value = "Filtrar">
            </form>
            
            <!-- PREENCHENDO AS CIDADES -->
            <script type="text/javascript">
              google.load("jquery", "1.4.2");
            </script>
            <script type="text/javascript">
                $(function(){
                    $('#campoUF').change(function(){
                        if( $(this).val() ) {
                            
                            document.getElementById('carregando').style.display = 'inline-block';
                            document.getElementById('campoCidade').style.display = 'none';
                            //$('#campoCidade').hide();
                            //$('.carregando').show();
                            $.getJSON('preencheCidadePrincipal.php?search=',{campoUF: $(this).val(), ajax: 'true'}, function(j){
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
            <div class = "tituloAnuncios">TODOS OS ANÚNCIOS</div>
            <div class = "tipo"> 
                <button id = "encontrei" onclick = "alterarTipoAnuncio(2)">Perdidos</button><button id = "perdi" onclick = "alterarTipoAnuncio(1)">Encontrados</button> 
            </div>
            <button id = "btnPessoa" onclick = "alterarTipoUsuario(2)">Pessoais</button><button id = "btnInstituicao" onclick = "alterarTipoUsuario(1)">Institucionais</button>
            <hr>
            <div class = "anuncios">
                <div class = "listagem">
				    <?php
                    if(isset($_GET["filtrar"]))
                    {                        
                        $tipoUsuario = mysqli_real_escape_string($bd, $_GET["tipoUsuario"]); 
                        echo "<script>tipoUsuario = " . $tipoUsuario . "</script>";                       
                        $tipoAnuncio = mysqli_real_escape_string($bd, $_GET["tipoAnuncio"]);
                        echo "<script>tipoAnuncio = " . $tipoAnuncio . "</script>";   
                        $categoria = mysqli_real_escape_string($bd, $_GET["categoria"]);
                        if(strlen($_GET["categoria"]) == 0)
                            $categoria = "";
                        
                        $pesquisa = mysqli_real_escape_string($bd, $_GET["palavrasChave"]);
                        if(strlen($_GET["palavrasChave"]) == 0)
                            $pesquisa = "";                        
                        
                        $uf = mysqli_real_escape_string($bd, $_GET["uf"]);
                        if(strlen($_GET["uf"]) == 0)
                            $uf = "";
                        
                        $cidade = mysqli_real_escape_string($bd, $_GET["cidade"]);
                        if(strlen($_GET["cidade"]) == 0)
                            $cidade = "";
                                                
                        if($tipoUsuario == 1)
                        {
                            echo "<script>document.getElementById('btnInstituicao').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('btnInstituicao').style.color = 'white';</script>";
                        }
                        else if($tipoUsuario == 2)
                        {                            
                            echo "<script>document.getElementById('btnPessoa').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('btnPessoa').style.color = 'white';</script>";
                        }
                        else if($tipoUsuario == 3)
                        {
                            
                            echo "<script>document.getElementById('btnInstituicao').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('btnInstituicao').style.color = 'white';</script>";
                            echo "<script>document.getElementById('btnPessoa').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('btnPessoa').style.color = 'white';</script>";
                            $tipoUsuario = 0;
                        }
                        
                        if($tipoAnuncio == 1)
                        {
                            echo "<script>document.getElementById('perdi').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('perdi').style.color = 'white';</script>";
                        }
                        else if($tipoAnuncio == 2)
                        {                            
                            echo "<script>document.getElementById('encontrei').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('encontrei').style.color = 'white';</script>";
                        }
                        else if($tipoAnuncio == 3)
                        {                            
                            echo "<script>document.getElementById('perdi').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('perdi').style.color = 'white';</script>";
                            echo "<script>document.getElementById('encontrei').style.backgroundColor = 'midnightblue';</script>";
                            echo "<script>document.getElementById('encontrei').style.color = 'white';</script>";
                            $tipoAnuncio = 0;
                        }
                        
                        // Ordem de pesquisa: tipo do usuário, tipo do anúncio, categoria, cidade, UF, pesquisa
                        $sql = "CALL sp_filtrar_anuncios($tipoUsuario, $tipoAnuncio, '$categoria', '$cidade', '$uf', '$pesquisa')";
                    }
                    else
                    {                        
                        $sql = "CALL sp_filtrar_anuncios(0, 0, '', '', '', '');";
                    }
                    
                    $resultado = $bd->query($sql) or die ('Erro ao chamar PROCEDURE sp_filtrar_anuncios - ' . mysqli_error($bd));
                    while($registro = $resultado->fetch_object())
                    {
                        if($registro->verificarPerda == 1)
                        {
                            echo "<a href = 'anuncioPessoalPessoa.php?codigoAnuncio=" . $registro->codigoAnuncio . "'><div id = 'anuncioPerda'>";
                            echo "<div id = 'pnlImagem' class = 'imagemAnuncio'>";
                            if(!empty(stripslashes($registro->urlImagem)))
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '" . stripslashes($registro->urlImagem) . "'>";
                            }
                            else
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '../img/semImagem.png'>";
                            }                            
                            echo "</div>";
                            echo "<div class = 'textoAnuncio'>";
                            echo "<div class = 'tituloAnuncio''>Perdeu &#8212; " . $registro->nomeAnuncio . "</div>";
                            echo "<div class = 'descricao''>por " . $registro->nomeUsuario . "</div>";
                            echo "<div class = 'cidadeUF'>" . $registro->cidadeUsuario . "/" . $registro->ufUsuario . "</div>";
                            echo "<div class = 'categoria'>" . $registro->categoriaAnuncio . "</div>";
                            echo "<div class = 'data'>Anunciado em " . $registro->dataAnuncio . "</div>";
                            echo "</div></div></a>";
                        }
                        else if ($registro->verificarInstituicao == 0)
                        {
                            echo "<a href = 'anuncioPessoalPessoa.php?codigoAnuncio=" . $registro->codigoAnuncio . "'><div id = 'anuncioPerda'>";
                            echo "<div id = 'pnlImagem' class = 'imagemAnuncio'>";
                            if(!empty($registro->urlImagem))
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '" . $registro->urlImagem . "'>";
                            }
                            else
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '../img/semImagem.png'>";
                            }                            
                            echo "</div>";
                            echo "<div class = 'textoAnuncio'>";
                            echo "<div class = 'tituloAnuncio''>Achou &#8212; " . $registro->nomeAnuncio . "</div>";
                            echo "<div class = 'descricao''>por " . $registro->nomeUsuario . "</div>";
                            echo "<div class = 'cidadeUF'>" . $registro->cidadeUsuario . "/" . $registro->ufUsuario . "</div>";
                            echo "<div class = 'categoria'>" . $registro->categoriaAnuncio . "</div>";
                            echo "<div class = 'data'>Anunciado em " . $registro->dataAnuncio . "</div>";
                            echo "</div></div></a>";
                        }
                        else
                        {
                            echo "<a href = 'anuncioInstitucionalPessoa.php?codigoAnuncio=" . $registro->codigoAnuncio . "'><div id = 'anuncioPerda'>";
                            echo "<div id = 'pnlImagem' class = 'imagemAnuncio'>";
                            if(!empty($registro->urlImagem))
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '" . $registro->urlImagem . "'>";
                            }
                            else
                            {
                                echo "<img onload = 'adaptarImagem(this)' id = 'imagemAnuncio' src = '../img/semImagem.png'>";
                            }                            
                            echo "</div>";
                            echo "<div class = 'textoAnuncio'>";
                            echo "<div class = 'tituloAnuncio''>Achou &#8212; " . $registro->nomeAnuncio . "</div>";
                            echo "<div class = 'descricao''>por " . $registro->nomeUsuario . "</div>";
                            echo "<div class = 'cidadeUF'>" . $registro->cidadeUsuario . "/" . $registro->ufUsuario . "</div>";
                            echo "<div class = 'categoria'>" . $registro->categoriaAnuncio . "</div>";
                            echo "<div class = 'data'>Anunciado em " . $registro->dataAnuncio . "</div>";
                            echo "</div></div></a>";
                        }
                    }
                    ?>					
            </div>
        </div>
            <div class = "sombra" id = "pnlSombra" onclick = "exibirCategorias()"></div>
    </body>
</html>