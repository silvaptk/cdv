<?php    
    include("conexao.php");
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Cabeça de Vento</title>
        <link rel = "stylesheet" type = "text/css" href = "../css/cadastroInstituicao.css">
        <script type = "text/javascript" src = "../js/cadastroInstituicao.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
     </head>
    <body>
        <header>
            <img src = "../img/logoBlue.png" id = "logo">
            <div class = "cabecalho">
                <div class = "titulo"> Registro </div>
                <div class = "usuario"> Instituição </div>
            </div>
        </header>
        <main> 		
            <form id = "formularioCadastro" name = "formularioCadastro">
                <fieldset>
                    <label>
                        <span>Nome</span>
                        <input type = "text" name = "nome" id = "nome" maxlength="65">
                    </label>
                    <label>
                        <span>E-mail</span>
                        <input type = "email" name = "email_usuario" id = "email_usuario" maxlength="100" placeholder = "exemplo@domininio.com">
                    </label>
                </fieldset>
                <fieldset>
                    <label>
                        <span>Senha</span>
                        <input type = "password" name = "senha" id = "senha" maxlength="40">
                    </label>
                    <label>
                        <span>Confirme</span>
                        <input type = "password" name = "confirma_senha" id = "confirma_senha" maxlength="40">
                    </label>
                </fieldset>
                <fieldset>
                    <label>
                        <span>CPNJ</span>
                        <input type = "text" name = "cpf-cnpj" id = "cpf-cnpj-txt" onkeydown = "javascript: fMasc(this)" onchange="validarCNPJ(this)" placeholder = "00.000.000/0000-00">
                        <input type = "hidden" id = "valida" name = "valida" value ="0">
                    </label>
                    <label>
                        <span>CEP</span>
                        <input type = "text" name = "cep" id = "cep" maxlength="9" placeholder = "00000-000"> 
                    </label>
                </fieldset>                
                <fieldset>
                    <label class = "campoUF">
                        <span>UF</span>
                        <input type = "text" max-length = "2" name = "uf" id = "campoUF" maxlength="2" placeholder = "SG">
                    </label>
                    <label class = "campoCidade">
                        <span>Cidade</span>
                        <input type = "text" name = "campoCidade" id = "campoCidade" maxlength="100">
                    </label>
                </fieldset>
                <fieldset>
                    <label class = "logradouro">
                        <span>Rua/Avenida</span>
                        <input type = "text" name = "logradouro" id = "logradouro" maxlength="200" placeholder = "Av. dos Ventos Cabeçudos">
                    </label>
                    <label class = "bairro">
                        <span>Bairro</span>
                        <input type = "text" name = "bairro" id = "bairro" maxlength = "50" placeholder = "Ventania">
                    </label>
                </fieldset>
                <fieldset>
                    <label class = "campoNumero">
                        <span>Número</span>
                        <input type = "text" name = "numero" id = "numeroEndereco" maxlength = "7" placeholder = "000">
                    </label>
                    <label class = "campoComplemento">
                        <span>Complemento</span>
                        <input type = "text" name = "complemento" id = "complementoEndereco" maxlength="20" placeholder = "Bloco Z, 0º andar">
                    </label>
                </fieldset>
                <input id = "rotinaAtendimento" type = "button" onclick = "exibirRotina()" value = "Rotina de atendimento">
                <div id = "dadosRotina">
                    <input type = "hidden" id = "abreSegunda" name = "abreSegunda" >
                    <input type = "hidden" id = "fechaSegunda" name = "fechaSegunda">
                    <input type = "hidden" id = "abreTerca" name = "abreTerca" >
                    <input type = "hidden" id = "fechaTerca" name = "fechaTerca" >
                    <input type = "hidden" id = "abreQuarta" name = "abreQuarta" >
                    <input type = "hidden" id = "fechaQuarta" name = "fechaQuarta" >
                    <input type = "hidden" id = "abreQuinta" name = "abreQuinta" >
                    <input type = "hidden" id = "fechaQuinta" name = "fechaQuinta" >
                    <input type = "hidden" id = "abreSexta" name = "abreSexta">
                    <input type = "hidden" id = "fechaSexta" name = "fechaSexta" >
                    <input type = "hidden" id = "abreSabado" name = "abreSabado" >
                    <input type = "hidden" id = "fechaSabado" name = "fechaSabado">
                    <input type = "hidden" id = "abreDomingo" name = "abreDomingo">
                    <input type = "hidden" id = "fechaDomingo" name = "fechaDomingo">    
                    <input type = "hidden" id = "abreFeriado" name = "abreFeriado">
                    <input type = "hidden" id = "fechaFeriado" name = "fechaFeriado">
                </div>
                <label>
                    <span>Telefone</span>
                    <input type = "text" name = "campoContato" id = "campoContato" maxlength = "15" onkeyup = "mascara( this, mtel );" placeholder = "(00) 0000-0000">
                </label>
                <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <div class = "finalizar">
                    <input type = "button" name= "Enviar" value = "Enviar" id = "botao" onclick = "enviar()">
                    <input type = "button" id = "voltar" onclick = "window.location.href = 'index.php';" value = "Voltar">
                </div>
            </form>

            <!-- Preenchendo os campos automaticamente -->
            <script type="text/javascript">
              google.load("jquery", "1.4.2");
            </script>
            <script type="text/javascript">
                $(function(){
                    $('#cep').keyup(function(){
                        if( $(this).val().length == 8 ) {
                            $.getJSON('preencheLocalizacao.php?search=',{cep: $(this).val(), ajax: 'true'}, function(j)
                            {
                                	for(var i=0; i < j.length ; i++)
						            {
						                document.getElementById("logradouro").value = j[i].rua;
						                document.getElementById("bairro").value = j[i].bairro;
						                document.getElementById("campoUF").value = j[i].uf;
						                document.getElementById("campoCidade").value = j[i].cidade;
						            }                                 
                            });
                        } else {
                            //espera o cara digitar tudo
                        }
                    });
                });
            </script>
            
        </main>
		
        <div id = "fundoPreto"  onclick = "fechar()"></div>
		
		<div id = "formularioRotina">
            <div class = "informacaoSair">Clique fora para sair.</div>
            <div class = "tituloRotina">
                Rotina de atendimento
            </div>
            <div class = "preencher">
                <div class = "botoesDia">
                    <button class = "diaSemana" id = "btnSegunda" onclick = "alterarDia(1)">Segunda-feira</button>
                    <button class = "diaSemana" id = "btnTerca" onclick = "alterarDia(2)">Terça-feira</button>
                    <button class = "diaSemana" id = "btnQuarta" onclick = "alterarDia(3)">Quarta-feira</button>
                    <button class = "diaSemana" id = "btnQuinta" onclick = "alterarDia(4)">Quinta-feira</button>
                    <button class = "diaSemana" id = "btnSexta" onclick = "alterarDia(5)">Sexta-feira</button>
                    <button class = "diaSemana" id = "btnSabado" onclick = "alterarDia(6)">Sábado</button>
                    <button class = "diaSemana" id = "btnDomingo" onclick = "alterarDia(7)">Domingo</button>
                    <button class = "diaSemana" id = "btnFeriado" onclick = "alterarDia(8)">Feriado</button>
                </div>
                <div class = "camposHora">
                    <div id = "diaAtual">Segunda-feira</div>
                    <div class = "informacaoPreenchimento">
                        Preencha sobre os horários a seguir e, em seguida, altere o respectivo dia
                    </div>
                    <fieldset>
                        <label>
                            <span>De</span>
                            <input type = "time" name = "horaEntrada" id = "campoDe">
                        </label>
                        <label>
                            <span>Até as</span>
                            <input type = "time" name = "horaSaida" id = "campoAte">
                        </label>
                    </fieldset>
                    <fieldset>
                        <input type = "button" value = "Integral" id = "integral" value = "24 horas">
                        <input type = "button" name = "naoAbre" id = "naoAbre" value = "Fechado">
                    </fieldset>
                </div>
            </div>
            <div class = "mensagemErro" id = "mensagemErroRotina">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
            </div>
            <div class = "finalizar">
                <button id = "verificar" onclick = "inserirHorario()">Definir horário</button>
            </div>
		</div>		
		
    </body>
</html>