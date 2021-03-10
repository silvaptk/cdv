<?php
	session_start();
	if (isset($_SESSION["logado"]) && $_SESSION["tipoUsuario"] == 1)
    {
        include "conexao.php";
    }
    else
    {
        $_SESSION["mensagemErro"] = "Insira suas credenciais primeiro!";
        $_SESSION["tipoMensagem"] = "erroLogIn";
        header("Location: index.php");    
    }	

	if(isset($_GET['nome']))
	{
		$nome = mysqli_real_escape_string($bd,addslashes($_GET['nome']));
		$email = mysqli_real_escape_string($bd,addslashes($_GET['email']));
		$cep = mysqli_real_escape_string($bd,addslashes($_GET['cep']));
		$numero = mysqli_real_escape_string($bd,addslashes($_GET['numero']));
		$complemento = mysqli_real_escape_string($bd,addslashes($_GET['complemento']));
		$contato = mysqli_real_escape_string($bd,addslashes($_GET['contato']));
		$usuario = $_SESSION['codigoUsuario'];

		$nome = "" . $nome;
		$email = "" . $email;
		$cep = ""  . $cep;
		$numero = "" . $numero;
		$complemento = "" . $complemento;
		$contato = "" . $contato;

		if(strlen($numero) <= 0)
			$numero = "0";

		if(strlen($cep) <= 0)
			$cep = "0";

		$abreSegunda = mysqli_real_escape_string($bd,addslashes($_GET['abreSegunda']));
		$fechaSegunda = mysqli_real_escape_string($bd,addslashes($_GET['fechaSegunda']));
		$abreTerca = mysqli_real_escape_string($bd,addslashes($_GET['abreTerca']));
		$fechaTerca = mysqli_real_escape_string($bd,addslashes($_GET['fechaTerca']));
		$abreQuarta = mysqli_real_escape_string($bd,addslashes($_GET['abreQuarta']));
		$fechaQuarta = mysqli_real_escape_string($bd,addslashes($_GET['fechaQuarta']));
		$abreQuinta = mysqli_real_escape_string($bd,addslashes($_GET['abreQuinta']));
		$fechaQuinta = mysqli_real_escape_string($bd,addslashes($_GET['fechaQuinta']));
		$abreSexta = mysqli_real_escape_string($bd,addslashes($_GET['abreSexta']));
		$fechaSexta = mysqli_real_escape_string($bd,addslashes($_GET['fechaSexta']));
		$abreSabado = mysqli_real_escape_string($bd,addslashes($_GET['abreSabado']));
		$fechaSabado = mysqli_real_escape_string($bd,addslashes($_GET['fechaSabado']));
		$abreDomingo = mysqli_real_escape_string($bd,addslashes($_GET['abreDomingo']));
		$fechaDomingo = mysqli_real_escape_string($bd,addslashes($_GET['fechaDomingo']));
		$abreFeriado = mysqli_real_escape_string($bd,addslashes($_GET['abreFeriado']));
		$fechaFeriado =  mysqli_real_escape_string($bd,addslashes($_GET['fechaFeriado']));

		if(!empty(trim($nome)) || !empty(trim($email)) || !empty(trim($cep))|| !empty(trim($numero)) || !empty(trim($complemento)) || !empty(trim($contato)) || !empty(trim($abreSegunda)) || !empty(trim($fechaSegunda)) || !empty(trim($abreTerca)) || !empty(trim($fechaTerca)) || !empty(trim($abreQuarta)) || !empty(trim($fechaQuarta)) || !empty(trim($abreQuinta)) || !empty(trim($fechaQuinta)) || !empty(trim($abreSexta)) || !empty(trim($fechaSexta)) || !empty(trim($abreSabado)) || !empty(trim($fechaSabado)) || !empty(trim($abreDomingo)) || !empty(trim($fechaDomingo)) || !empty(trim($abreFeriado)) || !empty(trim($fechaFeriado)))
		{

			$atualizar = $bd->query("CALL sp_modCadInstituicao($usuario, '$nome', '$email', $cep, $numero, '$complemento','$contato', '$abreSegunda', '$fechaSegunda', '$abreTerca', '$fechaTerca', '$abreQuarta', '$fechaQuarta', '$abreQuinta', '$fechaQuinta', '$abreSexta', '$fechaSexta', '$abreSabado', '$fechaSabado', '$abreDomingo', '$fechaDomingo', '$abreFeriado', '$fechaFeriado')") or die ("Erro no UPDATE da instituição - " . mysqli_error($bd));

				if($atualizar)
				{
					header("Location:perfilInstituicao.php");
				}
				else
				{
					$_SESSION["mensagemErro"] = "Erro ao atualizar os dados.";
					header("Location:modificarCadastroInstituicao.php");
				}
		}
		else
		{
			$_SESSION["mensagemErro"] = "Preencha pelo menos um campo para atualizar";
			header("Location:modificarCadInstituicao.php");
		}

		$_bd->close();
	}
	else
	{
		$_SESSION["mensagemErro"] = "Preencha pelo menos um campo para atualizar";
		header("Location:modificarCadInstituicao.php");
	}
?>