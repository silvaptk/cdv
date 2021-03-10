var anuncios = true;
var maisVisivel = false;

function alternar(botao)
{
    if (anuncios && botao == 2)
    {
        document.getElementById("anuncios").style.display = 'none';
        document.getElementById("mensagens").style.display = 'block';
        document.getElementById("btnMensagem").style.backgroundColor = 'midnightblue';
        document.getElementById("btnMensagem").style.color  = 'white';
        document.getElementById("btnMensagem").style.cursor = 'default';
        document.getElementById("btnAnuncio").style.backgroundColor = 'white';
        document.getElementById("btnAnuncio").style.color  = 'midnightblue';
        document.getElementById("btnAnuncio").style.cursor = 'pointer';
        anuncios = false;
    }
    else if (!anuncios && botao == 1)
    {
        document.getElementById("mensagens").style.display = 'none';
        document.getElementById("anuncios").style.display = 'block';
        document.getElementById("btnAnuncio").style.backgroundColor = 'midnightblue';
        document.getElementById("btnAnuncio").style.color  = 'white';
        document.getElementById("btnAnuncio").style.cursor = 'default';
        document.getElementById("btnMensagem").style.backgroundColor = 'white';
        document.getElementById("btnMensagem").style.color  = 'midnightblue';
        document.getElementById("btnMensagem").style.cursor = 'pointer';
        anuncios = true;
    }       
}

function exibirMais()
{
    if (!maisVisivel)
    {
        maisVisivel = true;
        document.getElementById("opcoes").innerHTML = "Mais &nbsp; &and;";
        document.getElementById("mais").style.display = 'block';
    }
    else
    {
        maisVisivel = false;
        document.getElementById("opcoes").innerHTML = "Mais &nbsp; &or;";
        document.getElementById("mais").style.display = 'none';
    }
}

function chat(acao)
{
    if (acao == 1)
    {
        document.getElementById("chat").style.display = 'none';
    }
    else
    {
        document.getElementById("chat").style.display = 'block';
    }
}
