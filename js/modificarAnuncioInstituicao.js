function categorizar(objeto)
{
    document.getElementById("categoriaAnuncio").value = objeto.value;    
    var botoes = document.getElementsByName("categoria");
    
    for(var i = 0; i < botoes.length; i = i + 1)
    {
        if(botoes[i].value == document.getElementById("categoriaAnuncio").value)
        {
            botoes[i].style.backgroundColor = "midnightblue";
            botoes[i].style.color = "white";
        }
        else
        {
            botoes[i].style.backgroundColor = "white";
            botoes[i].style.color = "midnightblue";
        }
    }
}
// FUTURA VERIFICAÇÃO

function enviar(){
    /*
    //obtendo as informações digitadas
    var titulo = document.getElementById("titulo").value;
    var descricao = document.getElementById("descricao").value;
    var categoria = document.getElementById("categoriaAnuncio").value;

    if(titulo.length < 3)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira o título do anuncio";
        document.getElementById("titulo").focus();
        return false;
    }

    if(descricao.length < 3)
    {
        document.getElementById("mensagemErro").innerHTML = "Insira a descrição do anuncio";
        document.getElementById("descricao").focus();
        return false;
    }

    if(categoria == "")
    {
        document.getElementById("mensagemErro").innerHTML = "Selecione uma categoria";
        return false;
    }
    */
    //se tudo ok, envio o formulário para o PHP
    document.getElementById("mensagemErro").innerHTML = "&nbsp;&nbsp;";//limpando
    document.formularioCadastro.method = "POST";
    document.formularioCadastro.submit();
    return true;

 }

function preencherFormulario(titulo, descricao, categoria, subCategoria, numeroDocumento)
{
    // Adicionando título e descrição ao anúncio
    document.getElementById("titulo").value = titulo;
    document.getElementById("descricao").value = descricao;
    
    // Indicando categoria
    var categorias = document.getElementsByName("categoria");
    for(var i = 0; i < categorias.length; i = i + 1)
    {
        if(categorias[i].value == categoria)
        {
            categorias[i].click();
            verificaSubCategoria(categorias[i]);
        }
    }
    
    // Indicando subcategoria, se for o caso
    if(subCategoria != null && subCategoria > 0)
    {
        document.getElementById("subCategoria").value = subCategoria;    
    }
    
    // Indicando número do documento, se for o caso
    if(numeroDocumento != null && numeroDocumento.length > 0)
    {
        document.getElementById("numDocumento").value = numeroDocumento;
    }
}
