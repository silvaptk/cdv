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

function alternar(botao)
{
    switch (botao)
    {
        case 1:
            document.getElementById("sobre").style.display = 'block';
            document.getElementById("anuncios").style.display = 'none';
            document.getElementById("avaliacoes").style.display = 'none';
            document.getElementById("mensagens").style.display = 'none';
            document.getElementById("btnSobre").style.backgroundColor = 'midnightblue';
            document.getElementById("btnAnuncios").style.backgroundColor = 'white';
            document.getElementById("btnAvaliacoes").style.backgroundColor = 'white';
            document.getElementById("btnMensagens").style.backgroundColor = 'white';
            document.getElementById("btnSobre").style.color = 'white';
            document.getElementById("btnAnuncios").style.color = 'midnightblue';
            document.getElementById("btnAvaliacoes").style.color = 'midnightblue';
            document.getElementById("btnMensagens").style.color = 'midnightblue';
            document.getElementById("btnSobre").style.cursor = 'default';
            document.getElementById("btnAnuncios").style.color = 'pointer';
            document.getElementById("btnAvaliacoes").style.color = 'pointer';
            document.getElementById("btnMensagens").style.color = 'pointer';
            break;
        case 2:
            document.getElementById("sobre").style.display = 'none';
            document.getElementById("anuncios").style.display = 'block';
            document.getElementById("avaliacoes").style.display = 'none';
            document.getElementById("mensagens").style.display = 'none';
            document.getElementById("btnSobre").style.backgroundColor = 'white';
            document.getElementById("btnAnuncios").style.backgroundColor = 'midnightblue';
            document.getElementById("btnAvaliacoes").style.backgroundColor = 'white';
            document.getElementById("btnMensagens").style.backgroundColor = 'white';
            document.getElementById("btnSobre").style.color = 'midnightblue';
            document.getElementById("btnAnuncios").style.color = 'white';
            document.getElementById("btnAvaliacoes").style.color = 'midnightblue';
            document.getElementById("btnMensagens").style.color = 'midnightblue';
            document.getElementById("btnSobre").style.cursor = 'pointer';
            document.getElementById("btnAnuncios").style.color = 'default';
            document.getElementById("btnAvaliacoes").style.color = 'pointer';
            document.getElementById("btnMensagens").style.color = 'pointer';
            break;
        case 3:
            document.getElementById("sobre").style.display = 'none';
            document.getElementById("anuncios").style.display = 'none';
            document.getElementById("avaliacoes").style.display = 'block';
            document.getElementById("mensagens").style.display = 'none';
            document.getElementById("btnSobre").style.backgroundColor = 'white';
            document.getElementById("btnAnuncios").style.backgroundColor = 'white';
            document.getElementById("btnAvaliacoes").style.backgroundColor = 'midnightblue';
            document.getElementById("btnMensagens").style.backgroundColor = 'white';
            document.getElementById("btnSobre").style.color = 'midnightblue';
            document.getElementById("btnAnuncios").style.color = 'midnightblue';
            document.getElementById("btnAvaliacoes").style.color = 'white';
            document.getElementById("btnMensagens").style.color = 'midnightblue';
            document.getElementById("btnSobre").style.cursor = 'pointer';
            document.getElementById("btnAnuncios").style.color = 'pointer';
            document.getElementById("btnAvaliacoes").style.color = 'default';
            document.getElementById("btnMensagens").style.color = 'pointer';
            break;
        case 4:
            document.getElementById("sobre").style.display = 'none';
            document.getElementById("anuncios").style.display = 'none';
            document.getElementById("avaliacoes").style.display = 'none';
            document.getElementById("mensagens").style.display = 'block';
            document.getElementById("btnSobre").style.backgroundColor = 'white';
            document.getElementById("btnAnuncios").style.backgroundColor = 'white';
            document.getElementById("btnAvaliacoes").style.backgroundColor = 'white';
            document.getElementById("btnMensagens").style.backgroundColor = 'midnightblue';
            document.getElementById("btnSobre").style.color = 'midnightblue';
            document.getElementById("btnAnuncios").style.color = 'midnightblue';
            document.getElementById("btnAvaliacoes").style.color = 'midnightblue';
            document.getElementById("btnMensagens").style.color = 'white';
            document.getElementById("btnSobre").style.cursor = 'pointer';
            document.getElementById("btnAnuncios").style.color = 'pointer';
            document.getElementById("btnAvaliacoes").style.color = 'pointer';
            document.getElementById("btnMensagens").style.color = 'default';
            break;
            
            
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

function imagemInstituicao()
{
    document.getElementById("imgPerfil").click();
}

function capaInstituicao()
{    
    document.getElementById("imgCapa").click();
}

function enviarImagens()
{
    document.getElementById("formularioPerfil").action = "alterarImagens.php";
    document.getElementById("formularioPerfil").method = "POST";
    document.getElementById("formularioPerfil").submit();
}

function definirPerfil(imagem)
{
    document.getElementById("imagemInstituicao").src = imagem;
}

function definirCapa(imagem)
{
    var valor = "url('" + imagem + "')";
    document.getElementById("pnlCapa").style.backgroundImage = valor;
}


