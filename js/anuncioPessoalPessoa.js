var maisVisivel = false;

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

function alterarImagem(imagem)
{
    document.getElementById("exibirImagem").src = imagem.src;
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
