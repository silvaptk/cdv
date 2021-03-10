function adaptarImagem(imagem)
{
    // Como obter largura e altura de um elemento via JavaScript    
    if(imagem.width > imagem.height)
    {
        var continente = document.getElementsByClassName("imagemAnuncio")[0];
        var margemSuperior = continente.clientHeight / 2 - imagem.height / 2;
        imagem.style.height = "auto";
        imagem.style.position = "relative";
        imagem.style.top = "50%";
        imagem.style.transform = "translateY(-50%)";
        imagem.style.width = "100%";
    }
    else
    {        
        var continente = document.getElementsByClassName("imagemAnuncio")[0];
        var margemEsquerda = continente.clientWidth / 2 - imagem.width / 2; 
        imagem.style.width = "auto";
        imagem.style.position = "relative";
        imagem.style.left = "50%";
        imagem.style.transform = "translateX(-50%)";
        imagem.style.height = "100%";
    }
}
