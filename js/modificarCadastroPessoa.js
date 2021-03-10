var intervalo;
var autoPreencher = false;
var cidade = "";

function preencherCidade()
{
    $(function(){
        if( $('#campoUF').val() ) {
        //$('#campoCidade').hide();
        document.getElementById("campoCidade").style.display = "none";
        document.getElementsByClassName("carregando")[0].style.display = "inline-block";
        //$('.carregando').show();
        $.getJSON('preencheCidade.php?search=',{campoUF: $('#campoUF').val(), ajax: 'true'}, function(j){
        var options = '<option value="0"> &nbsp;&nbsp; Selecione...</option>'; 
        for (var i = 0; i < j.length; i++) {
            options += '<option value="' + j[i].cd_cidade + '"> &nbsp;&nbsp; ' + j[i].nm_cidade + '</option>';
        }   
        $('#campoCidade').html(options).show();
        $('.carregando').hide();
            
        if(autoPreencher)
        {
            autoPreencher = false;
            var opcoes = document.getElementById("campoCidade").getElementsByTagName("option");

            for(var i = 0; i < opcoes.length; i = i + 1)
            {
                if(opcoes[i].innerText.trim() == cidade)
                {
                    document.getElementById("campoCidade").value = opcoes[i].value;
                }
            }
        }
    });
    } else {
        $('#campoCidade').html('<option value="0"> &nbsp;&nbsp; Selecione um estado...</option>');
    }
    });
    return true;
}

function preencherFormulario(nome, email, uf, cidade, contato)
{
    document.getElementById("nomeUsuario").value = nome;
    document.getElementById("E-mail").value = email;
    document.getElementById("campoUF").value = uf;
    autoPreencher = true;
    this.cidade = cidade;
    preencherCidade(); 
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



