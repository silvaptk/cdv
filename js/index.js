let instituicao = true;

function alternar(botao)
{  
    document.getElementById("cpf-cnpj-txt").value = "";
    document.getElementById("senha").value = "";
    document.getElementById("cpf-cnpj-txt").focus();

    if (instituicao == true && botao == false)
    {        
        document.getElementById("botaoInstituicao").style.color = "midnightblue";
		document.getElementById("botaoInstituicao").style.backgroundColor = "white";
        document.getElementById("botaoInstituicao").style.cursor = "pointer";
        document.getElementById("botaoPessoa").style.color = "white";
        document.getElementById("botaoPessoa").style.backgroundColor = "midnightblue";
        document.getElementById("botaoPessoa").style.cursor = "default";
        document.getElementById("cpf-cnpj").innerHTML = "CPF";
        instituicao = false;
        document.getElementById("cpf-cnpj").style.paddingRight = "1.8%";
    }
    else if (instituicao == false && botao == true)
    {          
        document.getElementById("botaoPessoa").style.color = "midnightblue";
        document.getElementById("botaoPessoa").style.backgroundColor = "white";
        document.getElementById("botaoPessoa").style.cursor = "pointer";
        document.getElementById("botaoInstituicao").style.color = "white";
        document.getElementById("botaoInstituicao").style.backgroundColor = "midnightblue";
        document.getElementById("botaoInstituicao").style.cursor = "default";
        document.getElementById("cpf-cnpj").innerHTML = "CNPJ";
        instituicao = true;
        document.getElementById("cpf-cnpj").style.paddingRight = "1%";
    }
}

function fMasc(objeto) 
{
    obj = objeto;
    if (instituicao)
    {
        masc = mCNPJ;
        document.getElementById("cpf-cnpj-txt").maxLength = 18;
    }
    else
    {
        masc = mCPF;
        document.getElementById("cpf-cnpj-txt").maxLength = 14;
    }
    
    setTimeout("fMascEx()", 1);
}

function fMascEx() 
{
    obj.value = masc(obj.value)
}

function mCNPJ(cnpj)
{
    cnpj = cnpj.replace(/\D/g, "");
    cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
    cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");

    return cnpj;
}

function mCPF(cpf)
{
    cpf = cpf.replace(/\D/g, "");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    return cpf;
}

function cadastro()
{
    if(instituicao)
        window.location.href = "cadastroInstituicao.php";
    else
        window.location.href = "cadastroPessoa.php";
}

function entrar()
{
    //obtendo os valores digitados
    let login = document.getElementById("cpf-cnpj-txt").value;
    let senha = document.getElementById("senha").value;

    if(login.length > 10 && senha.length > 5)
    {
        document.formularioLogin.submit();
    }
    else
    {
        document.getElementById("mensagemErro").innerHTML = "Preencha as informações corretamente.";
    }
}