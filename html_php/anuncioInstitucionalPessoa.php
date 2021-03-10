<?php
session_start();
if(isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 0)
{
    if(isset($_GET["codigoAnuncio"]))
    {
        include 'conexao.php';
        $codigo = mysqli_real_escape_string($bd, $_GET["codigoAnuncio"]);
        $comando = "CALL sp_obter_anuncio_institucional($codigo)";
        $executar = $bd->query($comando) or die("Comando furado - " . mysqli_error($bd));
        $registro = $executar->fetch_object();
        $nomeAnuncio = $registro->nomeAnuncio;
        $codigoInstituicao = $registro->codigoInstituicao;
        $nomeUsuario = $registro->nomeUsuario;
        $descricaoAnuncio = $registro->descricaoAnuncio;
        $nomeCategoria = $registro->nomeCategoria;
        $dataAnuncio = $registro->dataAnuncio;
        $executar->close();
        $bd->next_result();
    }
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
        <link rel = "stylesheet" type = "text/css" href = "../css/anuncioInstitucionalPessoa.css"> 
        <script type = "text/javascript" src = "../js/anuncioInstitucionalPessoa.js"></script>
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
	<body>
		<div id = "barraSuperior">
            <div class = "logo" onclick = "window.location.href = 'principalPessoa.php'"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil" onclick = "window.location.href = 'perfilPessoa.php'">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroPessoa.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
        <div id = "principal">
            <div class = "nomeUsuario">por <?php echo $nomeUsuario; ?></div>
            <div class = "dataAnuncio">Anunciado em <?php echo $dataAnuncio; ?></div>
            <div class = "tituloAnuncio">Achou &#8212;
                <?php 
                echo "(" . $nomeCategoria . ") ";
                echo $nomeAnuncio;
                ?>
            </div>
            <div class = "imagens">
                <div class = "exibirImagem imagemAnuncio"><img onload = "adaptarImagem(this)" onchange = "adaptarImagem(this)" src = "../img/imagemAnuncio1.png" id = "exibirImagem"></div>
                <div id = "selecionarImagem">
                    <?php
                    $comando = "CALL sp_obter_imagens_anuncio($codigo);";
                    $resultado = $bd->query($comando) or die("Comando furado " . mysqli_error($bd));
                    $exibiuImagem = false;
                    $primeiro = true;
                    while($registro = $resultado->fetch_object())
                    {
                        if($primeiro)
                        {
                            echo "<script>document.getElementById('exibirImagem').src = '" . stripslashes($registro->urlImagem) . "';</script>";
                        }
                        echo "<div class = 'opcaoImagem'>";
                        echo "<img src = '" . stripslashes($registro->urlImagem) . "' id = 'opcaoImagem' onclick = 'alterarImagem(this)'>";
                        echo "</div>";
                        $exibiuImagem = true;
                        
                    }
                    
                    if(!$exibiuImagem)
                    {
                        echo "<script>";
                        echo "document.getElementById('selecionarImagem').style.display = 'none';";
                        echo "document.getElementById('exibirImagem').src = '../img/semImagem.png';";
                        echo "</script>";
                    }
                    
                    ?>
                </div>
            </div>
            <div class = "descricaoAnuncio">
                <div class = "tituloDescricao">Descrição do anúncio</div>
                <div class = "descricao"><?php echo $descricaoAnuncio; ?></div>
            </div>
            <div class = "opcoesAcao">
                <a href = "iniciarConversa.php?codigoAnuncio=<?php echo $_GET['codigoAnuncio'] ?>"><button id = "btnIniciarConversa">Iniciar conversa</button></a>
                <a href = "perfilInstitucionalPessoa.php?codigoInstituicao=<?php echo $codigoInstituicao ?>"><button id = "btnPaginaInstituicao">Página da instituição</button></a>
                <button id = "btnVoltar" onclick = "window.history.back();">Voltar</button>
            </div>
        </div>
        <div id = "chat">
            <div class = "opcoesChat">
                <div class = "nomeChat">Nome do usuário</div>
                <div class = "fecharChat"><img src = "../img/botaoFecharBranco.png" id = "fecharChat" onclick = "chat(1)"></div>
            </div>
            <div class = "exibirMensagens">
                <div class = "mensagemMinha">Mensagem Mensagem Mensagem Mensagem</div>
                <div class = "mensagemDele">Mensagem Mensagem Mensagem Mensagem Mensagem Mensagem Mensagem Mensagem
                    Mensagem Mensagem</div>
                
            </div>
            <div class = "enviarMensagem">
                <div class = "txtMensagem"><textarea id = "txtMensagem" name = "txtMensagem" rows = 2></textarea></div>
                <div class = "btnMensagem"><input type = "submit" id = "btnMensagem" name = "btnMensagem" value = "Enviar"></div>
            </div>            
        </div>
    </body>
</html>