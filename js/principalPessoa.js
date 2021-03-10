var tipoAnuncio = 0;
var tipoUsuario = 0;
// Definir tipo de anúncio
function alterarTipoAnuncio(anuncio)
{    
    // 0 - nenhum
    // 1 - anúncios de encontro
    // 2 - anúncios de perda
    // 3 - ambos
    
    var btnEncontrei = document.getElementById("encontrei");
    var btnPerdi = document.getElementById("perdi");
    if(tipoAnuncio == 0) // Não há nenhum filtro
    {
        tipoAnuncio = anuncio;
        if(anuncio == 2) // ele apertou em PERDI
        {
            btnEncontrei.style.backgroundColor = "midnightblue";
            btnEncontrei.style.color = "white";
            
            // Somente pessoas anunciam perda
            document.getElementById("btnInstituicao").style.display = "none";
            document.getElementById("btnInstituicao").style.backgroundColor = "white";
            document.getElementById("btnInstituicao").style.color = "midnightblue";
            if(tipoUsuario == 3)
            {
                tipoUsuario = 2;
                document.getElementById("txtUsuario").value = tipoUsuario;
            }
            else if(tipoUsuario == 1)
            {
                tipoUsuario = 0;
                document.getElementById("txtUsuario").value = tipoUsuario;
            }
            
            document.getElementById("txtUsuario").value = tipoUsuario;
            
        }
        else // Ele apertou EM PERDI
        {
            btnPerdi.style.backgroundColor = "midnightblue";
            btnPerdi.style.color = "white";
            document.getElementById("btnInstituicao").style.display = "inline-block";
        }
    }
    else if(tipoAnuncio == 1) // Filtrando por anúncios de encontro
    {
        if(anuncio == 2) // Ele apertou em encontrei, então
        {            
            // Volto a exibir opção de filtrar por instituição            
            tipoAnuncio = 3;
            btnEncontrei.style.backgroundColor = "midnightblue";
            btnEncontrei.style.color = "white";
        }
        else // ele apertou em perdi, então
        {
            document.getElementById("btnInstituicao").style.display = "inline-block";
            tipoAnuncio = 0;
            btnPerdi.style.backgroundColor = "white";
            btnPerdi.style.color = "midnightblue";
        }
    }
    else if (tipoAnuncio == 2)
    {
        if(anuncio == 2)
        {
            tipoAnuncio = 0;
            document.getElementById("btnInstituicao").style.display = "inline-block";
            btnEncontrei.style.backgroundColor = "white";
            btnEncontrei.style.color = "midnightblue";
            
        }
        else
        {
            tipoAnuncio = 3;
            btnPerdi.style.backgroundColor = "midnightblue";
            btnPerdi.style.color = "white";
            document.getElementById("btnInstituicao").style.display = "inline-block";
        }
    }
    else
    {
        if(anuncio == 2)
        {
            tipoAnuncio = 1;
            document.getElementById("btnInstituicao").style.display = "inline-block";
            btnEncontrei.style.backgroundColor = "white";
            btnEncontrei.style.color = "midnightblue";
        }
        else
        {
            tipoAnuncio = 2;
            btnPerdi.style.backgroundColor = "white";
            btnPerdi.style.color = "midnightblue";
            document.getElementById("btnInstituicao").style.display = "none";
            document.getElementById("btnInstituicao").style.backgroundColor = "white";
            document.getElementById("btnInstituicao").style.color = "midnightblue";
            if(tipoUsuario == 3)
            {
                tipoUsuario = 2;
                document.getElementById("txtUsuario").value = tipoUsuario;
            }
            else if(tipoUsuario == 1)
            {
                tipoUsuario = 0;
                document.getElementById("txtUsuario").value = tipoUsuario;
            }
            
        }  
    }
    
    document.getElementById("txtAnuncio").value = tipoAnuncio;
}

// Definir tipo de usuário
function alterarTipoUsuario(usuario)
{
    // 0 - nenhum
    // 1 - anúncios de instituição
    // 2 - anúncios de pessoa
    // 3 - ambos
    var btnPessoa = document.getElementById("btnPessoa");
    var btnInstituicao = document.getElementById("btnInstituicao");
    if(tipoUsuario == 0)
    {
        tipoUsuario = usuario;
        if(usuario == 1)
        {
            btnInstituicao.style.backgroundColor = "midnightblue";
            btnInstituicao.style.color = "white";
        }
        else
        {
            btnPessoa.style.backgroundColor = "midnightblue";
            btnPessoa.style.color = "white";
        }
    }
    else if(tipoUsuario == 1)
    {
        if(usuario == 1)
        {
            tipoUsuario = 0;
            btnInstituicao.style.backgroundColor = "white";
            btnInstituicao.style.color = "midnightblue";
        }
        else
        {
            tipoUsuario = 3;
            btnPessoa.style.backgroundColor = "midnightblue";
            btnPessoa.style.color = "white";
        } 
    }
    else if(tipoUsuario == 2) 
    {
        if(usuario == 1)
        {
            tipoUsuario = 3;
            btnInstituicao.style.backgroundColor = "midnightblue";
            btnInstituicao.style.color = "white";
        }
        else
        {
            tipoUsuario = 0;
            btnPessoa.style.backgroundColor = "white";
            btnPessoa.style.color = "midnightblue";
        }
    }
    else
    {
        if(usuario == 1)
        {
            tipoUsuario = 2;
            btnInstituicao.style.backgroundColor = "white";
            btnInstituicao.style.color = "midnightblue";
        }
        else
        {
            tipoUsuario = 1;
            btnPessoa.style.backgroundColor = "white";
            btnPessoa.style.color = "midnightblue";
        }
    }
    
    
    document.getElementById("txtUsuario").value = tipoUsuario;
}

// Sobre as categorias
var exibindoCategoria = false;
function exibirCategorias()
{
    if (exibindoCategoria)
    {
        document.getElementById("categorias").style.display = 'none';
        document.getElementById("pnlSombra").style.display = 'none';
        exibindoCategoria = false;
    }
    else
    {
        document.getElementById("categorias").style.display = 'block';
        document.getElementById("pnlSombra").style.display = 'block';
        exibindoCategoria = true;
    }
}

function setarCategoria(objeto, numeroCategoria)
{
    if(document.getElementById("txtCategoria").value == numeroCategoria)
    {
        objeto.style.backgroundColor = "white";
        objeto.style.color = "midnightblue";
        document.getElementById("txtCategoria").value = "";
    }
    else
    {
        objeto.style.backgroundColor = "midnightblue";
        objeto.style.color = "white";
        var categorias = document.getElementsByClassName("opcaoCategoria");
        for(var i = 0; i < categorias.length; i = i + 1)
        {
            if(categorias[i].value != objeto.value)
            {
                categorias[i].style.backgroundColor = "white";
                categorias[i].style.color = "midnightblue";
            }

        }
        
        document.getElementById("txtCategoria").value = numeroCategoria;
    }
    
}


