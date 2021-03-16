DELIMITER $$
CREATE PROCEDURE sp_obter_conversas_usuario(
	IN codigoUsuario INT
)
BEGIN
	SELECT 	cd_conversa AS codigoConversa,
			(SELECT nm_usuario FROM tb_usuario WHERE cd_usuario = cd_destinatario) AS nomeConversa
		FROM tb_conversa
			WHERE cd_usuario = codigoUsuario;
END$$