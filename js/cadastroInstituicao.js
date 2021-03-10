function exibirRotina()
{    
    document.getElementById("fundoPreto").style.display = "block";
    document.getElementById("formularioRotina").style.display = "block";
    const body = document.querySelector('body'); 
    console.log(body);
    body.style.overflowY = "hidden";
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
        document.getElementById("mensagemErro").innerHTML = "Preencha todas as datas antes de submeter o registro."; 
    else
        document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";
    
        
    document.querySelector('body').style.overflowY = "auto";
}

function fMasc(objeto) 
{
    obj = objeto;
    masc = mCNPJ;
    document.getElementById("cpf-cnpj-txt").maxLength = 18;   
    
    setTimeout("fMascEx()", 1);
}

function fMascEx() 
{
    obj.value = masc(obj.value)
}

function mCNPJ(cnpj)
{
    cnpj = cnpj.replace(/\D/g,"");
    cnpj = cnpj.replace(/^(\d{2})(\d)/,"$1.$2");
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
    cnpj = cnpj.replace(/\.(\d{3})(\d)/,".$1/$2");
    cnpj = cnpj.replace(/(\d{4})(\d)/,"$1-$2");
    return cnpj;
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

function validarCNPJ(cnpj) 
{

    cnpj = cnpj.value;
    cnpj = cnpj.replace(/[^\d]+/g,'');
    
    if(cnpj == '') return msgErro("CNPJ Inválido");
    tcnpj=false;
     
    if (cnpj.length != 14)
        return msgErro("CNPJ Inválido");
        tcnpj=false;
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        return msgErro("CNPJ Inválido");
        tcnpj=false; 
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        return msgErro("CNPJ Inválido");
        tcnpj=false; 
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
    return msgErro("CNPJ Inválido");
    tcnpj=false;
    
    tcnpj=true;
    return msgErro("&nbsp;&nbsp;");
    return true;
}

function msgErro(mensagem)
{
    //<input type = "hidden" id = "valida" name = "valida" value ="0">
    if(mensagem == "&nbsp;&nbsp;")
    {
        document.getElementById("valida").value = 1;
    }
    else
    {
        document.getElementById("valida").value = 0;
    }
    document.getElementById("mensagemErro").innerHTML = mensagem;
    
}

function enviar()
{
    //obtendo os valores digitados
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email_usuario").value;
    var senha = document.getElementById("senha").value;
    var confirma_senha = document.getElementById("confirma_senha").value;
    var cnpj = document.getElementById("valida").value;
    var cep = document.getElementById("cep").value;
    var logradouro = document.getElementById("logradouro").value;
    var bairro = document.getElementById("bairro").value;
    var cidade = document.getElementById("campoCidade").value;
    var uf = document.getElementById("campoUF").value;
    var numero = document.getElementById("numeroEndereco").value;
    var contato = document.getElementById("campoContato").value;

    //validando campo a campo

    if(nome.length < 2)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira um nome válido.";
        document.getElementById("nome").focus();
        return false;
    }

    //validando email
    var usuario = email.substring(0, email.indexOf("@")); // obtendo o usuario
    var dominio = email.substring(email.indexOf("@")+ 1, email.length); //obtendo o provedor
    //verificando as condições

    if(!(usuario.length >=1) || //se não existir caracteres antes do @
    !(dominio.length >=3) || //no minimo 3 caracteres de dominio (a.a)
    !(usuario.search("@")==-1) || //Não existir @
    !(dominio.search("@")==-1) || //Não existir @
    !(usuario.search(" ")==-1) || //Não existir espaço
    !(dominio.search(" ")==-1) || //Não existir espaço
    !(dominio.search(".")!=-1) || //Deve existir.
    !(dominio.indexOf(".") >=1)|| //Posição do primeiro "." após 1 caractere depois do @
    !(dominio.lastIndexOf(".") < dominio.length - 1)) //Existir caracteres após o ponto
    {
        document.getElementById("mensagemErro").innerHTML = "Insira um e-mail válido.";
        document.getElementById("email_usuario").focus();
        return false;
    }

    if(senha.length < 6)
    {
      document.getElementById("mensagemErro").innerHTML = "Insira uma senha com ao menos 6 caracteres.";
      document.getElementById("senha").focus();
      return false;
    }

    if(confirma_senha == "")
    {
        document.getElementById("mensagemErro").innerHTML = "Insira a confirmação da senha.";
        document.getElementById("confirma_senha").focus();
        return false;
    }

    if(senha != confirma_senha)
    {
        document.getElementById("mensagemErro").innerHTML = "Senhas diferentes.";
        document.getElementById("confirma_senha").focus();
        return false;
    }

    if(cnpj == 0)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira um CNPJ válido.";
        document.getElementById("cpf-cnpj-txt").focus();
        return false;
    }

    if(cep.length != 8 || logradouro == "" || bairro == "" || cidade == "" || uf == "")
    {
        document.getElementById("mensagemErro").innerHTML = "Insira um CEP válido.";
        document.getElementById("cep").focus();
        return false;
    }

    if(numero == "")
    {
        document.getElementById("mensagemErro").innerHTML = "Insira o número do endereço.";
        document.getElementById("numeroEndereco").focus();
        return false;
    }

    if(contato.length < 7)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira um telefone válido."; 
        document.getElementById("campoContato").focus();
        return false;
    }

    //verificando a rotina
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
        {            
            teste = false; // se 1 campo não preenchido
        }
    });

    if(teste)//se toda a rotina estiver preenchida
    {
       //se tudo ok, envio o formulário para o PHP.
        document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";// limpando a mensagem de erro
        document.formularioCadastro.action = "insertCadastroInstituicao.php";
        document.formularioCadastro.submit();    
        return true; 
    }
    else
    {
        document.getElementById("mensagemErro").innerHTML = "Preencha a rotina de atendimento para prosseguir.";   
        return false;
    } 
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

