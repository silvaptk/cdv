<?php
	
	session_start();
	include("conexao.php");
	header('Content-Type: text/html; charset=utf-8');

	$codigo = $_REQUEST['codigoConversa'];
	$usuario = $_SESSION['codigoUsuario'];

	$result = $bd->query("SELECT m.cd_usuario, m.ds_mensagem, date_format(dt_mensagem, '%H:%i - %d/%m') as 'horaMensagem', (select nm_usuario from tb_usuario where cd_usuario = if($usuario = c.cd_destinatario, c.cd_usuario,c.cd_destinatario)) as 'Destinatario', (select nm_anuncio from tb_anuncio where cd_anuncio = c.cd_anuncio) as 'Anuncio' from tb_mensagem as m right join tb_conversa as c on c.cd_conversa = m.cd_conversa where c.cd_conversa = $codigo order by cd_mensagem");
	
	if($result)
	{
		while($dados = $result->fetch_object())
		{
			$mensagens[] = array
			(
				'mensagem' => $dados->ds_mensagem,
				'usuario' => $dados->cd_usuario,
				'destinatario' => $dados->Destinatario,
				'anuncio' => $dados->Anuncio,
				'horaMensagem' =>$dados->horaMensagem
			);
		}
		echo(json_encode($mensagens));
	}
	else
	{
		echo "Erro no SELECT da mensagem";
	}
	
	
?>
