<?php
session_start();
if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 0)
{
    include "conexao.php";
    $codigoUsuario = mysqli_real_escape_string($bd, $_SESSION["codigoUsuario"]);
    $sql = "CALL sp_obter_informacoes_pessoa($codigoUsuario);";
    $resultado = $bd->query($sql);
    $registro = $resultado->fetch_object();
}
else
{
    $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
    header("Location: index.php");    
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
        <title> Cabeça de Vento </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" href = "../css/perfilPessoa.css"> 
        <script type = "text/javascript" src = "../js/perfilPessoa.js"></script> 
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../css/modalMensagem.css">
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
            <div class = "cidadeUFTitulo"><?php echo $registro->nomeCidade . "/" . $registro->cidadeUF; ?></div>
			<div class = "nomeInstituicao"><?php echo $registro->nomeUsuario; ?></div>
            <div class = "contatoTitulo"><?php echo $registro->contatoUsuario; ?></div>
			<div class = "selecao">
				<button id = "btnAnuncio" onclick = "alternar(1)">Anúncios</button><button id = "btnMensagem" onclick = "window.location.href = 'chat.php'">Mensagens</button>
			</div>
			<div class = "alteracao">
				<div id = "anuncios">
					<button id = "anunciar" onclick = "window.location.href = 'anunciarPessoa.php'">Anunciar</button>
					<div class = "listagem">
                        <?php
                        $resultado->close();
                        $bd->next_result();
                        $sql = "CALL sp_obter_anuncios_usuario($codigoUsuario);";
                        $resultado = $bd->query($sql) or die('Erro - ' . mysqli_error($bd));
                        while($registro = $resultado->fetch_object())
                        {
                            echo '<a href = "anuncioPessoalPessoa.php?codigoAnuncio=' . $registro->codigoAnuncio . '">';
                            echo '<div class = "anuncioPerdaPessoa">';
                            echo '<div id = "pnlImagem" class = "imagemAnuncio">';
                            if(!empty($registro->urlImagem))
                            {                                
                                echo '<img onload = "adaptarImagem(this)" id = "imagemAnuncio" src = "' . stripslashes($registro->urlImagem) . '">';
                            }
                            else
                            {
                                echo '<img onload = "adaptarImagem(this)" id = "imagemAnuncio" src = "../img/semImagem.png">';  
                            }
				            echo '</div>';
							echo '<div class = "textoAnuncio">';
				            echo '<div class = "tituloAnuncio">';
                            if($registro->tipoAnuncio == 0)
                            {
                                echo "Achei &#8212; ";
                            }
                            else
                            {
                                echo "Perdi &#8212; ";
                            }
                            echo $registro->nomeAnuncio . '</div>';
                            echo '<a href = "modificarAnuncioPessoa.php?codigoAnuncio=' . $registro->codigoAnuncio . '"><button id = "alterar">&#8226;&#8226;&#8226;</button></a>';
				            echo '<a href = "removerAnuncio.php?codigoAnuncio=' . $registro->codigoAnuncio . '"><button id = "remover">X</button></a>';
				            echo '<div class = "descricao">por ' . $registro->nomeUsuario . '</div>';
				            echo '<div class = "cidadeUF">' . $registro->cidadeUsuario . '/' . $registro->ufUsuario . '</div>';	
				            echo '<div class = "categoria">' . $registro->categoriaAnuncio . '</div>';
				            echo '<div class = "data">Anunciado em ' . $registro->dataAnuncio . '</div>';
							echo '</div>';
                            
				            echo '</div>'; 
                            echo '</a>';
                        }
                        ?>
					</div>
                </div>
				<div id = "mensagens">
                    <?php
                    $resultado->close();
                    $bd->next_result();
                    $sql = "CALL sp_obter_conversas_usuario($codigoUsuario);";              
                    $resultado = $bd->query($sql);
                    while($registro = $resultado->fetch_object())
                    {
                        echo '<div class = "conversa" onclick = "chat(2)">';
                        echo '<div class = "nomeUsuario">' . $registro->nomeConversa . '</div>';
                        echo '<a href = "removerConversa.php?codigoConversa=' . $registro->codigoConversa . '"><button id = "removerConversa"><img src = "../img/botaoFechar.png" id = "btnRemover"></button></a>';
                        echo '</div>';
                    }
                    
                    $resultado->close();
                    $bd->next_result();
                    $sql = "CALL sp_obter_conversas_destinatario($codigoUsuario);";              
                    $resultado = $bd->query($sql);
                    while($registro = $resultado->fetch_object())
                    {
                        echo '<div class = "conversa" onclick = "chat(2)">';
                        echo '<div class = "nomeUsuario">' . $registro->nomeConversa . '</div>';
                        echo '<a href = "removerConversa.php?codigoConversa=' . $registro->codigoConversa . '"><button id = "removerConversa"><img src = "../img/botaoFechar.png" id = "btnRemover"></button></a>';
                        echo '</div>';
                    }    
                    ?>
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
			</div>
		</div>        
	</body>
    <script type = "text/javascript" src = "../js/modalMensagem.js"></script>
    <?php
        if(isset($_SESSION["mensagemErro"]) && strlen($_SESSION["mensagemErro"]) > 0)
        {
            if(strcmp($_SESSION["tipoMensagem"], "novoAnuncio") == 0)
            {
               echo "<script>mensagem('Novo anúncio!', '" . $_SESSION["mensagemErro"] . "'); document.getElementById('btnAnuncios').click();</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = "";
            }
            elseif(strcmp($_SESSION["tipoMensagem"], "alterarAnuncio") == 0)
            {
                echo "<script>mensagem('Alterar anúncio!', '" . $_SESSION["mensagemErro"] . "'); document.getElementById('btnAnuncios').click();</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = "";
            }
            elseif(strcmp($_SESSION["tipoMensagem"], "alterarInformacoes") == 0)
            {
                echo "<script>mensagem('Alterar informações!', '" . $_SESSION["mensagemErro"] . "')</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = "";                
            }
            else if(strcmp($_SESSION["tipoMensagem"], "removerAnuncio") == 0)
            {                
                echo "<script>mensagem('Remover anúncio!', '" . $_SESSION["mensagemErro"] . "');  document.getElementById('btnAnuncios').click();</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = ""; 
            }
        }
    ?>
</html>