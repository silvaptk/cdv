<?php
session_start();
if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 1)
{
    include "conexao.php";
    $codigoUsuario = mysqli_real_escape_string($bd, $_SESSION["codigoUsuario"]);
    $sql = "CALL sp_obter_informacoes_instituicao($codigoUsuario);";
    $resultado = $bd->query($sql);
    $registro = $resultado->fetch_object();
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
        <link rel = "stylesheet" type = "text/css" href = "../css/perfilInstituicao.css"> 
        <script type = "text/javascript" src = "../js/perfilInstituicao.js"></script> 
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../css/modalMensagem.css">
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
	<body>        
        <div class = "capa" id = "pnlCapa" onclick = "capaInstituicao()"></div>
		<div id = "barraSuperior">
            <div class = "logo" onclick = "window.location.href = 'principalInstituicao.php'"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroInstituicao.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
		<div id = "principal">
            <div class = "imagemInstituicao" ><img src = "../img/usuario_default.png" id = "imagemInstituicao" onclick = "imagemInstituicao()"></div>
            <form enctype = "multipart/form-data" id = "formularioPerfil" name = "formularioPerfil">
                <input type = "file" id = "imgPerfil" name = "perfil[]" accept="image/*" onchange = "enviarImagens()">
                <input type = "file" id = "imgCapa" name = "capa[]" accept="image/*" onchange = "enviarImagens()">
                <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>
            </form>
			<div class = "nomeInstituicao"><?php echo $registro->nomeInstituicao; ?></div>
			<div class = "selecao">
				<button id = "btnSobre" onclick = "alternar(1)">Sobre</button><button id = "btnAnuncios" onclick = "alternar(2)">Anúncios</button><button id = "btnAvaliacoes" onclick = "alternar(3)">Avaliações</button><button id = "btnMensagens" onclick = "window.location.href = 'chat.php'">Mensagens</button>				
			</div>
			<div class = "alteracao">
				<div id = "sobre">	
					<div class = "rotinaAtendimento">
						<div class = "tituloRotina">ROTINA DE ATENDIMENTO</div>
						<div class = "dias">
							Segunda-feira <br>
							Terça-feira <br>
							Quarta-feira <br>
							Quinta-feira <br>
							Sexta-feira <br>
							Sábado <br>
							Domingo <br>
							Feriados <br>
						</div>
						<div class = "horarios">
							<?php
                            $enderecoInstituicao = $registro->enderecoInstituicao;
                            $contatoInstituicao = $registro->contatoInstituicao;
                            $emailInstituicao = $registro->emailInstituicao;
                            $resultado->close();
                            $bd->next_result();
                            $sql = "CALL sp_obter_rotina_instituicao($codigoUsuario);";
                            $resultado = $bd->query($sql) or die("Erro - " . mysqli_error($bd));
                            
                            $contar = 0;
                            while($registro = $resultado->fetch_object())
                            {
                                if(!empty($registro->horaAbre) && !empty($registro->horaFecha))
                                {
                                    if(strcmp($registro->horaAbre, $registro->horaFecha) != 0)
                                    {
                                        if($contar == 7)
                                            echo $registro->horaAbre . " &#8212 " . $registro->horaFecha;
                                        else
                                            echo $registro->horaAbre . " &#8212 " . $registro->horaFecha . "<br>";
                                    }
                                    else
                                    {
                                        if($contar == 7)
                                            echo "24 horas";
                                        else
                                            echo "24 horas<br>";
                                    }
                                }
                                else
                                {
                                    if($contar == 7)
                                        echo "Fechado";
                                    else
                                        echo "Fechado<br>";
                                } 
                                
                                $contar = $contar + 1;
                            }
                            ?>
						</div>
					</div> 
					<div class = "enderecoContato">
						<div class = "endereco">
							<div class = "tituloEndereco">ENDEREÇO</div>
							<div class = "enderecoCompleto"><?php echo $enderecoInstituicao; ?></div>
						</div> 
						<div class = "contato">
							<div class = "tituloContato">CONTATO</div>
							<div class = "contatos"><?php echo "Telefone/Celular: " . $contatoInstituicao . "<br>E-mail: " . $emailInstituicao; ?></div>
						</div>
					</div>
				</div>
				<div id = "anuncios">
					<button id = "anunciar" onclick = "window.location.href = 'anunciarInstituicao.php'">Anunciar</button>
					<div class = "listagem">
                        <?php
                        $resultado->close();
                        $bd->next_result();
                        $sql = "CALL sp_obter_anuncios_usuario($codigoUsuario);";
                        $resultado = $bd->query($sql) or die('Erro - ' . mysqli_error($bd));
                        
                        while($registro = $resultado->fetch_object())
                        {
                            echo '<a href = "anuncioInstitucionalInstituicao.php?codigoAnuncio=' . $registro->codigoAnuncio . '">';
                            echo '<div class = "anuncio">';
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
				            echo '<div class = "descricao">por ' . $registro->nomeUsuario . '</div>';
				            echo '<div class = "cidadeUF">' . $registro->cidadeUsuario . '/' . $registro->ufUsuario . '</div>';	
				            echo '<div class = "categoria">' . $registro->categoriaAnuncio . '</div>';
				            echo '<div class = "data">Anunciado em ' . $registro->dataAnuncio . '</div>';
							echo '</div>';
                            echo '<a href = "modificarAnuncioInstituicao.php?codigoAnuncio=' . $registro->codigoAnuncio . '"><button id = "alterar">&#8226;&#8226;&#8226;</button></a>';
				            echo '<a href = "removerAnuncio.php?codigoAnuncio=' . $registro->codigoAnuncio . '"><button id = "remover">X</button></a>';
				            echo '</div>';
                            echo '</a>';
                        }
                        ?>                        
					</div>
				</div>
				<div id = "avaliacoes">
                    <?php
                    $resultado->close();
                    $bd->next_result();
                    $sql = "CALL sp_obter_avaliacoes_instituicao($codigoUsuario);";
                    $resultado = $bd->query($sql);
                    while($registro = $resultado->fetch_object())
                    {
                        echo '<div class = "avaliacao">';
                        echo '<div class = "tituloAvaliacao">' . $registro->tituloAvaliacao . '</div>';
                        switch($registro->quantidadeAvaliacao)
                        {
                            case 0:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoNula.png" id = "grauAvaliacao"></div>'; 
                                break;
                            case 1:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoRuim.png" id = "grauAvaliacao"></div>'; 
                                break;
                            case 2:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoRazoavel.png" id = "grauAvaliacao"></div>'; 
                                break;
                            case 3:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoMedia.png" id = "grauAvaliacao"></div>'; 
                                break;
                            case 4:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoBoa.png" id = "grauAvaliacao"></div>'; 
                                break;
                            case 5:
                                echo '<div class = "grauAvaliacao"><img src = "../img/avaliacaoMuitoBoa.png" id = "grauAvaliacao"></div>'; 
                                break;
                        }                        
                        echo '<div class = "informacoesAvaliacao">Enviada por <span id = "avaliador">' . $registro->nomeAvaliador . '</span> em '. $registro->dataAvaliacao . '</div>';
                        echo '<div class = "descricaoAvaliacao">&nbsp;&nbsp;&nbsp;' . $registro->descricaoAvaliacao . '</div>';
                        echo '</div>';
                    }
                    ?>
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
			</div>
		</div>
	</body>
    <script type = "text/javascript" src = "../js/modalMensagem.js"></script>
    <?php
        if(isset($_SESSION["imagemCapa"]))
        {
            echo "<script>";
            echo "definirCapa('" . $_SESSION["imagemCapa"] . "');";
            echo "</script>";
        }
        
        if(isset($_SESSION["imagemPerfil"]))
        {
            echo "<script>";
            echo "definirPerfil('" . $_SESSION["imagemPerfil"] . "');";
            echo "</script>";
        }        
        
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