function classificar(valorClassificacao)
{
    var estrela1 = document.getElementById("estrela1"),
        estrela2 = document.getElementById("estrela2"),
        estrela3 = document.getElementById("estrela3"),
        estrela4 = document.getElementById("estrela4"),
        estrela5 = document.getElementById("estrela5");
    var classificacao = document.getElementById("classificacao");
    
    switch(valorClassificacao)
    {
        case 1:
            estrela1.src = '../img/estrelaAzul.png';
            estrela2.src = '../img/estrelaBranca.png';
            estrela3.src = '../img/estrelaBranca.png';
            estrela4.src = '../img/estrelaBranca.png';
            estrela5.src = '../img/estrelaBranca.png';
            classificacao.value = "1";
            break;
        case 2:
            estrela1.src = '../img/estrelaAzul.png';
            estrela2.src = '../img/estrelaAzul.png';
            estrela3.src = '../img/estrelaBranca.png';
            estrela4.src = '../img/estrelaBranca.png';
            estrela5.src = '../img/estrelaBranca.png';
            classificacao.value = "2";
            break;
        case 3:
            estrela1.src = '../img/estrelaAzul.png';
            estrela2.src = '../img/estrelaAzul.png';
            estrela3.src = '../img/estrelaAzul.png';
            estrela4.src = '../img/estrelaBranca.png';
            estrela5.src = '../img/estrelaBranca.png';
            classificacao.value = "3";
            break;
        case 4:
            estrela1.src = '../img/estrelaAzul.png';
            estrela2.src = '../img/estrelaAzul.png';
            estrela3.src = '../img/estrelaAzul.png';
            estrela4.src = '../img/estrelaAzul.png';
            estrela5.src = '../img/estrelaBranca.png';
            classificacao.value = "4";
            break;
        case 5:
            estrela1.src = '../img/estrelaAzul.png';
            estrela2.src = '../img/estrelaAzul.png';
            estrela3.src = '../img/estrelaAzul.png';
            estrela4.src = '../img/estrelaAzul.png';
            estrela5.src = '../img/estrelaAzul.png';
            classificacao.value = "5";
            break;           
    }
}

function enviar()
{
    //obtendo os valores digitados
    var titulo = document.getElementById("titulo_avaliacao").value;
    var descricao = document.getElementById("descricao").value;
    var classificacao = document.getElementById("classificacao").value;

    //verificando
    if(titulo.length < 2)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira o título.";
        document.getElementById("titulo_avaliacao").focus();
        return true;
    }

    if(descricao.length < 2)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira a descrição.";
        document.getElementById("descricao").focus();
        return true;
    }

    if(classificacao == 0)
    {
        document.getElementById("mensagemErro").innerHTML = "Selecione uma estrela.";
        document.getElementById("descricao").focus();
        return true;
    }

    //se tudo ok, chamo o PHP    
    document.formularioCadastro.submit();
    document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";//limpando
    return true;
}


