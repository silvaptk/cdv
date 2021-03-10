<?php
    session_start();
    
    if (isset($_SESSION["logado"]))
    {
        include "conexao.php";
        header('Content-Type: text/html; charset=utf-8');
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
    <script type="text/javascript">
        //Definindo variaveis para todo o escopo
        var codigoUsuario = <?php echo $_SESSION['codigoUsuario'] ?>;
        var tipoUsuario = <?php echo $_SESSION['tipoUsuario'] ?>;
        var novaConversa = <?php echo $_SESSION['novaConversa'] ?>;
        var conversaSelecionada = 0;
        var intervaloAtualizacao = null;
        var mensagensTotal = 0;
    </script>
    <head>
        <meta charset = "UTF-8">
        <title> Cabeça de Vento </title>
        <meta name = "viewport" content = "width=device-width, initial-scale=1.0">
        <link rel = "stylesheet" type = "text/css" href = "../css/chat.css"> 
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <link rel = "stylesheet" type = "text/css" href = "../css/modalMensagem.css">
        <script type = "text/javascript" src = "../js/chatPessoa.js"></script>
        <script type = "text/javascript" src = "../js/alterarLogo.js"></script>    
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">   
    </head>
    <body onload = "conversaNova();">
        <div id = "barraSuperior">
            <div class = "logo" onclick="redirecionar(3)"><img src = "../img/logoBlue.png" id = "logoBarra" onmouseover = "logoPrincipal(this)" onmouseout = "logoSecundario(this)"></div>
            <button id = "perfil" onclick = "redirecionar(1)">Meu perfil</button>
            <button id = "modificarInformacoes" onclick = "redirecionar(2)">Modificar informações</button>
            <button id = "sair" onclick = "window.location.href = 'index.php'">Sair</button>
        </div>
        <div class = "principal" id = "pnlPrincipal">
            <div class = "conversas" id = "pnlConversas">
                <?php
                    //Dispondo as conversas existentes do usuario
                    $usuario = $_SESSION['codigoUsuario'];

                    $result = $bd->query("SELECT c.cd_conversa as 'Conversa', (select nm_usuario from tb_usuario where cd_usuario = if($usuario = c.cd_destinatario, c.cd_usuario,c.cd_destinatario)) as 'nomeUsuario', (select nm_anuncio from tb_anuncio where cd_anuncio = c.cd_anuncio) as 'nomeAnuncio' from tb_conversa as c where cd_usuario = $usuario or c.cd_destinatario = $usuario order by c.cd_conversa desc;");

                    while($dados = $result->fetch_object())
                    {
                        echo '<div class = "conversa" id = "pnlConversa" onclick="atualizaConversa('.$dados->Conversa.');">';
                        echo '<div class = "nomeConversa" id = "lblNome">'.$dados->nomeUsuario.'</div>';
                        echo '<div class = "descricaoConversa" id = "lblDescricao">'.$dados->nomeAnuncio.' </div>';
                        echo '</div>';
                        echo '<hr>';
                    }
                ?>   

                <!-- MODELO                 
                <div class = "conversa" id = "pnlConversa" onclick="atualizaConversa();">
                    <div class = "nomeConversa" id = "lblNome">Nome do usuário</div>
                    <a href = "#" class = "removerConversa" id = "btnRemover"><img src = "../img/botaoFechar.png" class = "botaoFechar">
                    </a>
                    <div class = "descricaoConversa" id = "lblDescricao"> Nome do anúncio em questão </div>
                </div>                       
                <hr>
                -->                             
            </div>
            <div class = "conversaAtual" id = "pnlConversaAtual">
                <div class = "informacoesConversa" id = "pnlInformacoesConversa" style="display: none;">
                    <div class = "informacoesNomeConversa" id="informacoesNomeConversa">Nome do usuário</div>
                    <div class = "informacoesDescricaoConversa" id="informacoesDescricaoConversa">Nome do anúncio em questão</div>
                </div>
                <div class = "mensagensConversa" id="mensagensConversa" style="display: none;">
                    <div class = "mensagem mensagemDestinatario" id="mensagemDestinatario">Mensagem</div>
                    <div class = "mensagem mensagemUsuario" id="mensagemUsuario">Mensagem Mensagemn</div>
                    <div id="ancora"></div>
                </div>                

                <!-- Form de enviar mensagem -->
                <div class = "enviarMensagem" id="pnlEnviarMensagem" style="display: none;">
                    <form id = "frmEnviar" name="frmEnviar" class = "enviarMensagem" method="POST" action="enviarMensagem.php">
                        <textarea id = "txtMensagem" name="mensagem" class = "mensagem"></textarea>
                        <input type = "button" id = "btnEnviar" class = "mensagem" value = "Enviar" onclick="enviarMensagem();">
                    </form>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            google.load("jquery", "1.4.2");       

            function atualizaMensagens()
            {
                $(function(){
                    $.getJSON('preencheChat.php?search=',{codigoConversa: conversaSelecionada, ajax: 'true'}, function(msg)
                    {
                        var i = 0; 
                        //Informações do topo
                        document.getElementById('informacoesNomeConversa').innerHTML = msg[0].destinatario;
                        document.getElementById('informacoesDescricaoConversa').innerHTML = msg[0].anuncio;

                        if(mensagensTotal == 0)
                        {

                            //removendo a div que contém as mensagem para apagar as mensagens
                            document.getElementById("mensagensConversa").remove();

                            //recriando a div de mensagens
                            var div = document.createElement('div');
                            div.setAttribute( "id","mensagensConversa");
                            div.setAttribute( "class","mensagensConversa");
                            document.getElementById("pnlConversaAtual").appendChild(div);

                            //Guardando a quantia de mensagens para uma futura verificação
                            mensagensTotal = msg.length;

                            //Mensagens entre os usuários
                            if(msg[0].mensagem != "" && msg[0].mensagem != null)
                            {                                 
                                for (i = 0; i < msg.length; i++)
                                {
                                    if(msg[i].usuario == codigoUsuario)//se ele mandou a mensagem
                                    {           
                                        //USUARIO
                                        var div = document.createElement('div');
                                        div.setAttribute( "id","mensagemUsuario");
                                        div.setAttribute( "class","mensagem mensagemUsuario");
                                        div.innerHTML ="<span id='mensagem'>"+msg[i].mensagem+"</span> <span id='hora'>"+msg[i].horaMensagem+"</span>";
                                        document.getElementById('mensagensConversa').appendChild(div);
                                    }
                                    else // se recebeu
                                    {
                                        //DESTINARÁRIO
                                        var div = document.createElement( "div" );
                                        div.setAttribute( "id","mensagemDestinatario" );
                                        div.setAttribute( "class","mensagem mensagemDestinatario");
                                        div.innerHTML = "<span id='mensagem'>"+msg[i].mensagem+"</span> <span id='hora'>"+msg[i].horaMensagem+"</span>";
                                        document.getElementById('mensagensConversa').appendChild(div);
                                    }                            
                                }
                            }
                            //div de ancora para descer até a ultima mensagem
                            var div = document.createElement( "div" );
                            div.setAttribute( "id","ancora");
                            document.getElementById('mensagensConversa').appendChild(div);

                            //Definido as propriedades
                            camposMensagem(1);

                            //levando-o até a ultima mensagem
                            window.location.href = "#ancora";

                            //Definindo o focus para a caixa de texto, para caso esteja digitando
                            document.getElementById("txtMensagem").focus();
                        }
                        else
                        {  
                            //verificando se há novas mensagens
                            var diferenca = msg.length - mensagensTotal;
                            if(diferenca > 0)
                            {
                                for(i = msg.length - diferenca; i < msg.length; i++)
                                {
                                    if(msg[i].usuario != codigoUsuario)//se ele recebeu mensagem
                                    {           
                                       //DESTINARÁRIO
                                        var div = document.createElement( "div" );
                                        div.setAttribute( "id","mensagemDestinatario" );
                                        div.setAttribute( "class","mensagem mensagemDestinatario");
                                        div.innerHTML ="<span id='mensagem'>"+msg[i].mensagem+"</span> <span id='hora'>"+msg[i].horaMensagem+"</span>";
                                        document.getElementById('mensagensConversa').appendChild(div);
                                    }
                                } 

                                //removendo a ancora
                                document.getElementById("ancora").remove();

                                //Adicionando a ancora
                                var div = document.createElement( "div" );
                                div.setAttribute( "id","ancora");
                                document.getElementById('mensagensConversa').appendChild(div);    

                                //Atualizando
                                mensagensTotal = msg.length;

                                //levando-o até as mensagens novas
                                window.location.href = '#ancora';

                                //Definindo o focus para a caixa de texto, para caso esteja digitando
                                document.getElementById("txtMensagem").focus();

                            }//Fim diferença
                            
                        }//Fim else 1º vez
                    });
                });
            }

            function conversaNova()
            {
                if(novaConversa != 0)
                {
                    atualizaConversa(novaConversa);                 
                }
            }

            function atualizaConversa(conversa)
            {
                //Limpando a requisição de atualizar
                if(intervaloAtualizacao != null)
                {                 
                    clearInterval(intervaloAtualizacao); 
                    //Zerando as informações
                    mensagensTotal = 0;
                    sleep(550);                 
                }           
                //Mudando o valor do codigo da conversa
                conversaSelecionada = conversa;
                //Chamo e seto a atualização automatica
                atualizaMensagens();
                intervaloAtualizacao = setInterval(atualizaMensagens,2350);  
            }

            function enviarMensagem()
            {
                var mensagem = document.getElementById("txtMensagem").value;
                if(mensagem.length >= 1)
                {
                    //Fazendo um array para envia-lo com as informações
                    var dados = [mensagem,codigoUsuario,conversaSelecionada];

                    $(function(){
                        $.getJSON('enviarMensagem.php?search=',{dados:dados, ajax: 'true'}, function(enviar)
                        {
                            //alert("Mensagem cadastrada");
                        });
                    });

                    if(novaConversa == 0)// Se não for uma conversa nova
                    {
                        //removendo a ancora
                        document.getElementById("ancora").remove();  
                    }    

                    //Incrementando a mensagem nas quantia total
                    //Obtendo e formatando o horario de envio da mensagem
                    var data = new Date();
                    var hora = data.getHours();
                    var minutos = data.getMinutes()+"";//convertendo variavel p String
                    if(minutos.length < 2)
                    {
                        minutos = "0"+minutos; //Firula
                    }
                    var dia = data.getDate()+"";
                    if(dia.length < 2)
                    {
                        dia = "0"+dia; //firula
                    }
                    var mes = data.getMonth()+1+"";//convertendo variavel p String
                    if(mes.length < 2)
                    {
                        mes = "0"+mes; //Firula
                    }
                    var horario = hora+":"+minutos+" - "+dia+"/"+mes;

                    //Inserindo a mensagem no chat atual
                    var div = document.createElement('div');
                    div.setAttribute( "id","mensagemUsuario");
                    div.setAttribute( "class","mensagem mensagemUsuario");
                    div.innerHTML = "<span id='mensagem'>"+mensagem+"</span> <span id='hora'>"+horario+"</span>";
                    document.getElementById('mensagensConversa').appendChild( div );

                    //div de ancora para descer até a ultima mensagem
                    var div = document.createElement( "div" );
                    div.setAttribute( "id","ancora");
                    document.getElementById('mensagensConversa').appendChild( div );

                    //levando-o até a ultima mensagem
                    window.location.href = '#ancora'; 
                    //Limpando e definindo o focus
                    document.getElementById("txtMensagem").value = '';   
                    document.getElementById("txtMensagem").focus(); 
                }

                if(novaConversa != 0)
                {
                    //definindo que não é uma nova conversa
                    novaConversa = 0;
                    <?php $_SESSION['novaConversa'] = 0 ?>
                }
            }

            function camposMensagem(x)
            {
                if(x == 1)
                {
                    document.getElementById("pnlEnviarMensagem").style.display = "inline-block";
                    document.getElementById("pnlInformacoesConversa").style.display = "inline-block";
                    document.getElementById("mensagensConversa").style.display = "inline-block";
                }
                else
                {
                    document.getElementById("pnlEnviarMensagem").style.display = "none";
                    document.getElementById("pnlInformacoesConversa").style.display = "none";
                    document.getElementById("mensagensConversa").style.display = "none";
                }
            }

            function redirecionar(x)
            {
                if(x == 1) // Perfis
                {
                    if(tipoUsuario == 1)
                        window.location.href = 'perfilInstituicao.php';
                    else
                        window.location.href = 'perfilPessoa.php';

                }
                if(x == 2) //Modificar
                {
                    if(tipoUsuario == 1)
                        window.location.href = 'modificarCadastroInstituicao.php';
                    else
                        window.location.href = 'modificarCadastroPessoa.php';
                }  
                if(x == 3) //Página Principal
                {
                    if(tipoUsuario == 1)
                        window.location.href = 'principalInstituicao.php';
                    else
                        window.location.href = 'principalPessoa.php';
                }
            }

            function sleep(milliseconds)
            {
              var start = new Date().getTime();
              for (var i = 0; i < 1e7; i++)
              {
                if ((new Date().getTime() - start) > milliseconds)
                  break;  
              }
            }
        </script>
    </body>
    <script type = "text/javascript" src = "../js/modalMensagem.js"></script>
    <?php
        if(isset($_SESSION["mensagemErro"]) && strlen($_SESSION["mensagemErro"]) > 0)
        {
            if(strcmp($_SESSION["tipoMensagem"], "documentoExistente") == 0)
            {
               echo "<script>mensagem('Documento já existente!', '" . $_SESSION["mensagemErro"] . "');</script>";
                $_SESSION["mensagemErro"] = "  ";
                $_SESSION["tipoMensagem"] = "";
            }
        }
    ?>
</html>