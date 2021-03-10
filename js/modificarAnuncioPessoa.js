var encontrei = true;
function alternar(botao)
{      
    var tipoAnuncio = document.getElementById("tipoAnuncio");
    if (encontrei == true && botao == false)
    {        
        document.getElementById("encontrei").style.color = "midnightblue";
        document.getElementById("encontrei").style.backgroundColor = "white";
        document.getElementById("encontrei").style.cursor = "pointer";
        document.getElementById("perdi").style.color = "white";
        document.getElementById("perdi").style.backgroundColor = "midnightblue";
        document.getElementById("perdi").style.cursor = "default";
        tipoAnuncio.value = 1;
        encontrei = false;
    }
    else if (encontrei == false && botao == true)
    {          
        document.getElementById("perdi").style.color = "midnightblue";
        document.getElementById("perdi").style.backgroundColor = "white";
        document.getElementById("perdi").style.cursor = "pointer";
        document.getElementById("encontrei").style.color = "white";
        document.getElementById("encontrei").style.backgroundColor = "midnightblue";
        document.getElementById("encontrei").style.cursor = "default";
        tipoAnuncio.value = 0;
        encontrei = true;
    }
}

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

//FUTURA VERIFICAÇÃO

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
    document.getElementById("formularioCadastro").submit();
    return true;

 }

function preencherFormulario(tipo, titulo, descricao, categoria, subCategoria, numeroDocumento)
{
    // Adicionando tipo
    if(tipo == 0)
    {
        document.getElementById("encontrei").click();
    }
    else
    {
        document.getElementById("perdi").click();
    }
    
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

