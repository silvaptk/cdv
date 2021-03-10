<?php
session_start();
$codigoAnuncio;
if(isset($_GET["codigoAnuncio"]))
{
    $codigoAnuncio = $_GET["codigoAnuncio"];
}
else
{
    $codigoAnuncio = 1;
}

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
$codigo = mysqli_real_escape_string($bd, $codigoAnuncio);
$sql = "CALL sp_obter_anuncio_pessoal($codigo);";
$executar = $bd->query($sql);
$registro = $executar->fetch_object();
$nomeUsuario = $registro->nomeUsuario;
$nomeAnuncio = $registro->nomeAnuncio;
$dataAnuncio = $registro->dataAnuncio;
$tipoAnuncio = $registro->tipoAnuncio;
$nomeCategoria = $registro->nomeCategoria;
$descricaoAnuncio = $registro->descricaoAnuncio;
$contatoUsuario = $registro->contatoUsuario;
$cidadeUsuario = $registro->nomeCidade;
$estadoUsuario = $registro->cidadeUF;
$executar->close();
$bd->next_result();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
        <title> Cabeça de Vento </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" href = "../css/anuncioPessoalInstituicao.css"> 
        <script type = "text/javascript" src = "../js/anuncioInstitucionalPessoa.js"></script>
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
	<body>
		<div id = "barraSuperior">
            <div class = "logo" onclick = "window.location.href = 'principalInstituicao.php'"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil" onclick = "window.location.href = 'perfilInstituicao.php'">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroInstituicao.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
        <div id = "principal">
            <div class = "nomeUsuario">por <?php echo $nomeUsuario; ?></div>
            <div class = "dataAnuncio">Anunciado em <?php echo $dataAnuncio; ?></div>
            <div class = "tituloAnuncio">
                <?php 
                if ($tipoAnuncio == 0)
                {
                    echo "Achou ";
                }
                else
                {
                    echo "Perdeu ";
                }
                echo "&#8212; (" . $nomeCategoria . ") ";
                echo $nomeAnuncio; 
                ?>
            </div>
            <div class = "imagens">
                <div class = "exibirImagem imagemAnuncio"><img onchange = "adaptarImagem(this)" onload = "adaptarImagem(this)" src = "../img/imagemAnuncio1.png" id = "exibirImagem"></div>
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
            <div class = "informacoesAnunciante">
                <div class = "tituloInformacoes">Informações do anunciante</div>
                <ul id = "informacoes">
                    <li>Nome do usuário: <?php echo $nomeUsuario; ?></li>
                    <li>Telefone/Celular: <?php echo $contatoUsuario; ?></li>
                    <li>Cidade/UF: <?php echo $cidadeUsuario . "/" . $estadoUsuario; ?></li>
                </ul>
            </div>
            <div class = "opcoesAcao">
                <button id = "btnVoltar" onclick = "window.history.back();">Voltar</button>
            </div>
        </div>
    </body>
</html>