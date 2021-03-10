function voltar()
{
    window.location = "index.html";
}

function fMasc(objeto) 
{
    obj = objeto;
    masc = mCPF;
    document.getElementById("cpf-cnpj-txt").maxLength = 14;
    
    
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

function mCPF(cpf)
{
    cpf=cpf.replace(/\D/g,"");
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2");
    cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2");
    cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
    return cpf;
}

function validarCPF(elemento) 
{
  cpf = elemento.value;
  cpf = cpf.replace(/[^\d]+/g, '');
  if (cpf == '') return msgErro("CPF Inválido");
  // Elimina CPFs invalidos conhecidos    
  if (cpf.length != 11 ||
    cpf == "00000000000" ||
    cpf == "11111111111" ||
    cpf == "22222222222" ||
    cpf == "33333333333" ||
    cpf == "44444444444" ||
    cpf == "55555555555" ||
    cpf == "66666666666" ||
    cpf == "77777777777" ||
    cpf == "88888888888" ||
    cpf == "99999999999")
    return msgErro("CPF Inválido");
  // Valida 1o digito 
  add = 0;
  for (i = 0; i < 9; i++)
    add += parseInt(cpf.charAt(i)) * (10 - i);
  rev = 11 - (add % 11);
  if (rev == 10 || rev == 11)
    rev = 0;
  if (rev != parseInt(cpf.charAt(9)))
    return msgErro("CPF Inválido");
  // Valida 2o digito 
  add = 0;
  for (i = 0; i < 10; i++)
    add += parseInt(cpf.charAt(i)) * (11 - i);
  rev = 11 - (add % 11);
  if (rev == 10 || rev == 11)
    rev = 0;
  if (rev != parseInt(cpf.charAt(10)))
   return msgErro("CPF Inválido");
  return msgErro("&nbsp;&nbsp;");
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
    var email = document.getElementById("e-mail").value;
    var senha = document.getElementById("senha").value;
    var confirma_senha = document.getElementById("confirma_senha").value;
    var cpf = document.getElementById("valida").value;
    var cidade = document.getElementById("campoCidade").value;
    var uf = document.getElementById("campoUF").value;
    var contato = document.getElementById("campoContato").value;

    //validando campo a campo, usando return false para não prosseguir asism que achar 1 erro
    if(nome.length <= 1)
    {
      document.getElementById("mensagemErro").innerHTML = "Insira um nome válido";
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
      document.getElementById("e-mail").focus();
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

    if(cpf == 0)
    {
      document.getElementById("mensagemErro").innerHTML = "Insira um CPF válido.";
      document.getElementById("cpf-cnpj-txt").focus();
      return false;
    }

    if(cidade == "" || uf == "")
    {
      document.getElementById("mensagemErro").innerHTML = "Selecione uma localização.";
      return false;
    }

    if(contato.length <= 9)
    {
      document.getElementById("mensagemErro").innerHTML = "Insira um contato válido.";
      document.getElementById("campoContato").focus();
      return false;
    }

    //se tudo ok, envio o formulário para o PHP
    document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";// limpando a mensagem de erro
    document.formularioCadastro.method = "POST";
    document.formularioCadastro.action = "insertCadastroPessoa.php";
    document.formularioCadastro.submit();
    return true;    
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

