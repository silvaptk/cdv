DELIMITER $$
CREATE PROCEDURE sp_obter_conversas_destinatario(
	IN codigoUsuario INT
)
BEGIN
	SELECT 	co.cd_conversa AS codigoConversa,
			(SELECT nm_usuario FROM tb_usuario WHERE cd_usuario = co.cd_usuario)
		FROM tb_conversa AS co
			WHERE co.cd_destinatario = codigoUsuario;
END$$