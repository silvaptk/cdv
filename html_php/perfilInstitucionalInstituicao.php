<?php
session_start();
if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 1)
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
        <link rel = "stylesheet" type = "text/css" href = "../css/perfilInstitucionalInstituicao.css"> 
        <script type = "text/javascript" src = "../js/perfilInstitucionalInstituicao.js"></script>
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>
        <script type = "text/javascript" src = "../js/imagensAnuncio.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
	</head>
	<body>
        <div class = "capa" id = "pnlCapa" onclick = "capaInstituicao()"></div>
		<div id = "barraSuperior">
            <div class = "logo" onclick = "window.location.href = 'principalInstituicao.php'"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil" onclick = "window.location.href = 'perfilInstituicao.php'">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "window.location.href = 'modificarCadastroInstituicao.php'">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
		</div>
		<div id = "principal">
            <div class = "imagemInstituicao"><img src = "../img/usuario_default.png" id = "imagemInstituicao"></div>
            <div class = "nomeInstituicao"><?php echo $registro->nomeInstituicao; ?></div>
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
                <div class = "btnMensagem"><input type = "submit" id = "btnMensagem" name = "btnMensagem"></div>
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
</html>