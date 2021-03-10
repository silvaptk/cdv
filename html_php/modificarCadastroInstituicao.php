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
        <link rel = "stylesheet" type = "text/css" href = "../css/modificarCadastroInstituicao.css">
        <script rel = "text/javascript" src = "../js/modificarCadastroInstituicao.js"></script>
        <script rel = "text/javascript" src = "../js/jsiAPI.js"></script>
        <link rel = "icon" href = "../css/icone.ico" type = "image/x-icon">
    </head>
    <body>
        <div id = "principal"> 			
            <div class = "titulo"> Modificar Registro </div>
            <div class = "usuario"> Instituição </div>
            <div class = "informacao">Preencha somente os campos referentes a informações que deseja modificar!</div>
            <!-- Acessar o JS para direcionanto de página (ACTION); Não alterar nada aqui -->
            <form id = "formularioCadastro" name = "formularioCadastro">
                <div class = "metade">
                <div class = "campo">
                    Nome <input type = "text" name = "nome" id = "nome" maxlength="60">
                </div>
                <div class = "campo">
                    E-mail <input type = "text" name = "email" id = "email" maxlength="40">
                </div>
               <div class = "campo">
                    CEP <input type = "text" name = "cep" id = "cep" maxlength="8" value="" onkeyup="preencherLocalizacao()"> 
                </div>
                <div class = "campo">
                    Rua/Avenida <input type = "text" name = "logradouro" id = "logradouro">
                </div>
                </div>
                <div class = "campo">
                    Bairro <input type = "text" name = "bairro" id = "bairro">
                </div>
                <div class = "campoCidade">
                    Cidade <input type = "text" name = "campoCidade" id = "campoCidade">
                </div>
                <div class = "campoUF">
                    UF <input type = "text" max-length = "2" name = "campoUF" id = "campoUF">
                </div>
                <div class = "campoNumero">
                    Número <input type = "text" name = "numero" id = "campoNumero" maxlength="5" value="">
                </div>
                <div class = "campoComplemento">
                    Complemento <input type = "text" name = "complemento" id = "CampoComplemento">
                </div>
                <input id = "rotinaAtendimento" type = "button" onclick = "exibirRotina()" value = "Rotina de atendimento">
                <div id = "dadosRotina">
                    <input type = "hidden" id = "abreSegunda" name = "abreSegunda" >
                    <input type = "hidden" id = "fechaSegunda" name = "fechaSegunda"> 
                    <input type = "hidden" id = "abreTerca" name = "abreTerca">
                    <input type = "hidden" id = "fechaTerca" name = "fechaTerca">
                    <input type = "hidden" id = "abreQuarta" name = "abreQuarta">
                    <input type = "hidden" id = "fechaQuarta" name = "fechaQuarta"> 
                    <input type = "hidden" id = "abreQuinta" name = "abreQuinta" >
                    <input type = "hidden" id = "fechaQuinta" name = "fechaQuinta"> 
                    <input type = "hidden" id = "abreSexta" name = "abreSexta">
                    <input type = "hidden" id = "fechaSexta" name = "fechaSexta"> 
                    <input type = "hidden" id = "abreSabado" name = "abreSabado" >
                    <input type = "hidden" id = "fechaSabado" name = "fechaSabado"> 
                    <input type = "hidden" id = "abreDomingo" name = "abreDomingo" >
                    <input type = "hidden" id = "fechaDomingo" name = "fechaDomingo">    
                    <input type = "hidden" id = "abreFeriado" name = "abreFeriado">
                    <input type = "hidden" id = "fechaFeriado" name = "fechaFeriado">
                </div>
                <div class = "campoContato">
                    Contato <input type = "text" name = "contato" id = "campoContato" value="" maxlength = "15" onkeyup = "mascara( this, mtel );">
                </div>
                <div class = "mensagemErro" id = "mensagemErro">
                    <?php  
                        if(!empty($_SESSION['mensagemErro']))
                            echo $_SESSION['mensagemErro'];
                        else
                            echo "&nbsp;&nbsp;";
                    ?>
                </div>
                <input type = "button" name= "Enviar" value = "Enviar" id = "botao" onclick = "enviar()"> <input type = "button" id = "voltar" value = "Voltar" onclick = "history.go(-1)">
            </form>
            <!-- Preenchendo os campos automaticamente -->
            <script type="text/javascript">
              google.load("jquery", "1.4.2");
            </script>
            <script type="text/javascript">
                function preencherLocalizacao()
                {
                $(function(){                    
                        if( $('#cep').val().length == 8 ) {
                            $.getJSON('preencheLocalizacao.php?search=',{cep: $('#cep').val(), ajax: 'true'}, function(j)
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
                }
            </script>            
        </div>
		
		<div id = "fundoPreto"  onclick = "fechar()"></div>
        
        <div id = "formularioRotina">
            <div class = "informacaoSair">Clique fora para sair.</div>
            <div class = "tituloRotina">
                Rotina de Atendimento
            </div>
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
                    <div class = "informacaoPreenchimento">Preencha sobre os horários a seguir e, em seguida, altere o respectivo dia</div>
                    <div class = "campoDe">
                        De <input type = "time" name = "horaEntrada" id = "campoDe">
                    </div>
                    <div class = "campoAte">
                        Até as <input type = "time" name = "horaSaida" id = "campoAte">
                    </div>
                    <div class = "integral">
                        <input type = "checkbox" value = "" id = "chkIntegral" onchange= "esconderEntrada(true)"> 
                        <label for = "chkIntegral">&nbsp;24 horas</label>                    
                    </div>
                    <div class = "naoAbre">
                        <input type = "checkbox" value = "" id = "chkNaoAbre" onchange= "esconderEntrada(false)"> 
                        <label for = "chkNaoAbre">&nbsp;Não aberto</label>                    
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
        <?php
        $sql = "CALL sp_obter_dados_usuario(" . $_SESSION['codigoUsuario'] . ", 1)";
        $resultado = $bd->query($sql) or die("Erro - " . mysqli_error($bd));
        
        if($registro = $resultado->fetch_object())
        {
            echo "<script>preencherFormulario('";
            echo $registro->nome . "','";
            echo $registro->email . "','";
            echo $registro->cep . "','";
            echo $registro->numero . "','";
            echo $registro->complemento . "','";
            echo $registro->contato;
            echo "'); preencherLocalizacao();</script>";
        }
        $resultado->close();
        $bd->next_result();
        ?>
    </body>
</html>