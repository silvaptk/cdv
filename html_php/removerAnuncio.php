<?php
session_start();
if (isset($_SESSION["logado"]))
{
    include "conexao.php";
    $codigoUsuario = mysqli_real_escape_string($bd, $_SESSION["codigoUsuario"]);
    $sql = "CALL sp_obter_informacoes_pessoa($codigoUsuario);";
    $resultado = $bd->query($sql);
    $registro = $resultado->fetch_object();
}
else
{
    $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
    header("Location: index.php");    
}
if(isset($_GET["codigoAnuncio"]))
{
    include "conexao.php";
    $codigoAnuncio = mysqli_real_escape_string($bd, $_GET["codigoAnuncio"]);
    $sql = "UPDATE tb_anuncio SET ic_ativo = 0 WHERE cd_anuncio = $codigoAnuncio";
    $bd->query($sql) or die("Erro ao desativar anúncio - " . mysqli_error($bd));
    $_SESSION["mensagemErro"] = "Anúncio removido com sucesso!";
    $_SESSION["tipoMensagem"] = "removerAnuncio"; 
    
    if($_SESSION["tipoUsuario"] == 1)
        header("location: perfilInstituicao.php");
    else
        header("location: perfilPessoa.php");
}
else if(isset($_SESSION["logado"]))
{
    if($_SESSION["tipoUsuario"] == 1)
        header("location: perfilInstituicao.php");
    else
        header("location: perfilPessoa.php");
}
else    
    header("location: index.php"); 
?>