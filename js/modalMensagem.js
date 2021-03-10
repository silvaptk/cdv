function mensagem(titulo, conteudo)
{
    var tituloModal = "Cabeça de Vento";
    if(titulo.length > 0)
        tituloModal = titulo;
    
    var conteudoModal = "Conteúdo da mensagem";
    if(conteudo.length > 0)
        conteudoModal = conteudo;
    
    if(conteudoModal.length > 252)
        document.getElementById("lblConteudoModalMensagem").style.fontSize = "2vh";
    else        
        document.getElementById("lblConteudoModalMensagem").style.fontSize = "2.5vh";
    
    document.getElementById("lblTituloModalMensagem").innerHTML = tituloModal;
    document.getElementById("lblConteudoModalMensagem").innerHTML = conteudoModal;
    document.getElementById("pnlSombraMensagem").style.display = "block";
    document.getElementById("pnlModalMensagem").style.display = "block";
    document.getElementsByTagName("body").item(0).style.overflowY = "hidden";
}

function fecharMensagem()
{    
    document.getElementById("pnlSombraMensagem").style.display = "none";
    document.getElementById("pnlModalMensagem").style.display = "none";document.getElementsByTagName("body").item(0).style.overflowY = "auto";
}

function preparacao()
{
    // Sombra de fundo
    var sombra = document.createElement("div");
    sombra.setAttribute("class", "sombraMensagem");
    sombra.setAttribute("id", "pnlSombraMensagem");
    document.getElementsByTagName("body").item(0).appendChild(sombra);

    // O modal
    var modal = document.createElement("div");
    modal.setAttribute("class", "modalMensagem");
    modal.setAttribute("id", "pnlModalMensagem");
    document.getElementsByTagName("body").item(0).appendChild(modal);    
    
    sombra.addEventListener("click", fecharMensagem);
    
    // Título do modal
    var tituloModal = document.createElement("div");
    tituloModal.setAttribute("class", "tituloModalMensagem");
    tituloModal.setAttribute("id", "lblTituloModalMensagem");
    tituloModal.innerHTML = "Título da mensagem";
    modal.appendChild(tituloModal);

    // Conteúdo do modal
    var conteudoModal = document.createElement("div");
    conteudoModal.setAttribute("class", "conteudoModalMensagem");
    conteudoModal.setAttribute("id", "lblConteudoModalMensagem");
    conteudoModal.innerHTML = "Conteúdo da mensagem";
    modal.appendChild(conteudoModal);

    // Botão para fechar modal
    var botaoFechar = document.createElement("button");
    botaoFechar.setAttribute("class", "fecharModalMensagem");
    botaoFechar.setAttribute("id", "btnFecharModalMensagem");
    botaoFechar.innerHTML = "Ok!";
    modal.appendChild(botaoFechar);
    botaoFechar.addEventListener("click", fecharMensagem);
}

document.getElementsByTagName("body").item(0).addEventListener("load", preparacao());

