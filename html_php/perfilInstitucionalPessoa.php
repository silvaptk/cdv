<?php
session_start();
if ($_SESSION["logado"] && $_SESSION["tipoUsuario"] == 0 && isset($_GET["codigoInstituicao"]))
{
    include "conexao.php";
    $codigoInstituicao = mysqli_real_escape_string($bd, $_GET["codigoInstituicao"]);
    $sql = "CALL sp_obter_informacoes_instituicao($codigoInstituicao);";
    $resultado = $bd->query($sql);
    $registro = $resultado->fetch_object();
    $imagemPerfil = $registro->imagemPerfil;
    $imagemCapa = $registro->imagemCapa;
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
        <link rel = "stylesheet" type = "text/css" href = "../css/perfilInstitucionalPessoa.css"> 
        <script type = "text/javascript" src = "../js/perfilInstitucionalPessoa.js"></script>
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../css/modalMensagem.css">
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
	<body>
        <div class = "capa" id = "pnlCapa" onclick = "capaInstituicao()"></div>
		<div id = "barraSuperior">
            <div class = "logo" onclick = "window.location.href = 'principalPessoa.php'"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil" onclick = "window.location.href = 'perfilPessoa.php'">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroPessoa.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
		<div id = "principal">
            <div class = "imagemInstituicao"><img src = "../img/usuario_default.png" id = "imagemInstituicao"></div>
			<div class = "nomeInstituicao"><?php echo $registro->nomeInstituicao; ?></div><?php echo "<a href = 'avaliarInstituicao.php?codigoInstituicao=" . $codigoInstituicao . "'>"; ?><button id = "avaliarInstituicao">Avaliar</button></a>
			<div class = "selecao">
				<button id = "btnSobre" onclick = "alternar(1)">Sobre</button><button id = "btnAnuncios" onclick = "alternar(2)">Anúncios</button><button id = "btnAvaliacoes" onclick = "alternar(3)">Avaliações</button>			
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
                            $sql = "CALL sp_obter_rotina_instituicao($codigoInstituicao);";
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
					<div class = "listagem">
                        <?php
                        $resultado->close();
                        $bd->next_result();
                        $sql = "CALL sp_obter_anuncios_usuario($codigoInstituicao);";
                        $resultado = $bd->query($sql) or die('Erro - ' . mysqli_error($bd));
                        
                        while($registro = $resultado->fetch_object())
                        {
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
				            echo '<div class = "tituloAnuncio">' . $registro->nomeAnuncio . '</div>';		            
				            echo '<div class = "descricao">por ' . $registro->nomeUsuario . '</div>';
				            echo '<div class = "cidadeUF">' . $registro->cidadeUsuario . '/' . $registro->ufUsuario . '</div>';	
				            echo '<div class = "categoria">' . $registro->categoriaAnuncio . '</div>';
				            echo '<div class = "data">Anunciado em ' . $registro->dataAnuncio . '</div>';
							echo '</div>';
                            
				            echo '</div>'; 
                        }
                        ?>        
				    </div>
                </div>
				<div id = "avaliacoes">
                    <?php
                    $resultado->close();
                    $bd->next_result();
                    $sql = "CALL sp_obter_avaliacoes_instituicao($codigoInstituicao);";
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
			</div>
		</div>
        <?php
        if(isset($imagemPerfil))
        {
            echo "<script>";
            echo "definirPerfil('";
            echo $imagemPerfil;
            echo "');";
            echo "</script>";
        }
    
        if(isset($imagemCapa))
        {
            echo "<script>";
            echo "definirCapa('";
            echo $imagemCapa;
            echo "');";
            echo "</script>";
        }
    
        
        ?>
	</body>
    <script type = "text/javascript" src = "../js/modalMensagem.js"></script>
    <?php
        if(isset($_SESSION["mensagemErro"]) && strlen($_SESSION["mensagemErro"]) > 0)
        {
            if(strcmp($_SESSION["tipoMensagem"], "avaliarInstituicao") == 0)
            {
                echo "<script>mensagem('Avaliar instituição!', '" . $_SESSION["mensagemErro"] . "');";
                echo "document.getElementById('btnAvaliacoes').click();</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = "";
            }            
        }
    ?>
</html>