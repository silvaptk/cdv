function exibirRotina()
{    
    document.getElementById("fundoPreto").style.display = "block";
    document.getElementById("formularioRotina").style.display = "block";
}

function fechar()
{
    document.getElementById("fundoPreto").style.display = "none";
    document.getElementById("formularioRotina").style.display = "none";
    
    var campos =  [document.getElementById("abreSegunda").value,
    document.getElementById("fechaSegunda").value,
    document.getElementById("abreTerca").value,
    document.getElementById("fechaTerca").value,
    document.getElementById("abreQuarta").value,
    document.getElementById("fechaQuarta").value,
    document.getElementById("abreQuinta").value,
    document.getElementById("fechaQuinta").value,
    document.getElementById("abreSexta").value,
    document.getElementById("fechaSexta").value,
    document.getElementById("abreSabado").value,
    document.getElementById("fechaSabado").value,
    document.getElementById("abreDomingo").value,
    document.getElementById("fechaDomingo").value,
    document.getElementById("abreFeriado").value,
    document.getElementById("fechaFeriado").value];
                   
    var teste = true;
    campos.forEach(function(elemento, indice, vetor)
    {
        if(elemento.toString().length < 1)
            teste = false;
    });
                   
    if(!teste)
        document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";
    else
        document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";
}

function esconderEntrada(opcao)
{
    if(opcao)
    {
        if(document.getElementById("chkIntegral").checked == true)
        {
            document.getElementById("chkNaoAbre").checked = false;
            document.getElementById("campoDe").disabled = true;
            document.getElementById("campoAte").disabled = true;
        }
        else
        {            
            
            document.getElementById("campoDe").disabled = false;
            document.getElementById("campoAte").disabled = false;            
        }
    }
    else
    {
        if(document.getElementById("chkNaoAbre").checked == true)
        {
            document.getElementById("chkIntegral").checked = false;
            document.getElementById("campoDe").disabled = true;
            document.getElementById("campoAte").disabled = true;
        }
        else
        {
            
            document.getElementById("campoDe").disabled = false;
            document.getElementById("campoAte").disabled = false;            
        }
    }    
    
}

var numeroDiaAtual = 0;
function alterarDia(numeroDia)
{
    numeroDiaAtual = numeroDia;
    var nomeDiaAtual = document.getElementById("diaAtual").innerText;   
    document.getElementById("chkIntegral").checked = false;
    document.getElementById("chkNaoAbre").checked = false;
    switch(numeroDia)
    {
        case 1:
            document.getElementById("diaAtual").innerHTML = "Segunda-feira";
            break;
        case 2:
            document.getElementById("diaAtual").innerHTML = "Terça-feira";
            break;
        case 3:
            document.getElementById("diaAtual").innerHTML = "Quarta-feira";
            break;
        case 4:
            document.getElementById("diaAtual").innerHTML = "Quinta-feira";
            break;
        case 5:
            document.getElementById("diaAtual").innerHTML = "Sexta-feira";
            break;
        case 6:
            document.getElementById("diaAtual").innerHTML = "Sábado";
            break;
        case 7:
            document.getElementById("diaAtual").innerHTML = "Domingo";
            break;
        case 8:
            document.getElementById("diaAtual").innerHTML = "Feriados";
            break;
    }
    
    document.getElementById("campoDe").value = "";
    document.getElementById("campoAte").value = "";
}    

function inserirHorario()
{
    var integral = document.getElementById("chkIntegral");
    var naoAbre = document.getElementById("chkNaoAbre");
    var inicioDia = document.getElementById("campoDe").value;
    var fimDia = document.getElementById("campoAte").value;
    var valorAbre = "", 
        valorFecha = "",
        alterar = false;
    
    if(!integral.checked && !naoAbre.checked)
    {
        var horaInicial = inicioDia.split(':');
        var horaFinal = fimDia.split(':');
        var d = new Date();
        var inicio = new Date(d.getYear(), d.getMonth(), d.getDate(), horaInicial[0], horaInicial[1]);
        var fim = new Date(d.getYear(), d.getMonth(), d.getDate(), horaFinal[0], horaFinal[1]);
        
        if(inicio < fim)
        {
            valorAbre = inicioDia;
            valorFecha = fimDia;
            alterar = true;
        }
        else
        {
            document.getElementById("mensagemErroRotina").innerHTML = "Verifique os campos de hora digitados!";
        }
    }
    else
    {
        if(integral.checked)
            valorAbre = "24 horas";
        else
            valorAbre = "Não abre";
        
        valorFecha = valorAbre;
        alterar = true;
    }
    
    if(alterar)
    {
        var nomeControle = "";

        switch(document.getElementById("diaAtual").innerText)
        {
            case "Segunda-feira": 
                nomeControle = "Segunda";
                break;
            case "Terça-feira": 
                nomeControle = "Terca";
                break;
            case "Quarta-feira": 
                nomeControle = "Quarta";
                break;
            case "Quinta-feira": 
                nomeControle = "Quinta";
                break;
            case "Sexta-feira": 
                nomeControle = "Sexta";
                break;
            case "Sábado": 
                nomeControle = "Sabado";
                break;
            case "Domingo": 
                nomeControle = "Domingo";
                break;
            case "Feriados": 
                nomeControle = "Feriado";
                break;            
        }

        document.getElementById("abre" + nomeControle).value = valorAbre;
        document.getElementById("fecha" + nomeControle).value = valorFecha;
        document.getElementById("btn" + nomeControle).style.color = "midnightblue";
        document.getElementById("btn" + nomeControle).style.backgroundColor = "white";
    }
}

function enviar()
{
    // aqui vc direciona pra página de UPDATE, e pega os campos pelo name por $_GET
    document.formularioCadastro.action = "modificarCadInstituicao.php";
    document.formularioCadastro.submit();
}

function preencherFormulario(nome, email, cep, numero, complemento, contato)
{
    document.getElementById("nome").value = nome;
    document.getElementById("email").value = email;
    document.getElementById("cep").value = cep;
    document.getElementById("campoNumero").value = numero;
    document.getElementById("CampoComplemento").value = complemento;
    document.getElementById("campoContato").value = contato;
}

function mascara(o,f)
{
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara()
{
v_obj.value=v_fun(v_obj.value)
}

function mtel(v)
{
v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
return v;
}

function id( el )
{
    return document.getElementById( el );
}


