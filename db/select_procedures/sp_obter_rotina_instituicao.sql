DELIMITER $$
CREATE  PROCEDURE sp_obter_rotina_instituicao(
	IN codigoInstituicao INT
)
BEGIN
	SELECT 	DATE_FORMAT(hr_abre, "%k" ':' "%i") AS horaAbre,
			DATE_FORMAT(hr_fecha, "%k" ':' "%i") AS horaFecha
		FROM tb_hora_rotina
			WHERE cd_usuario = codigoInstituicao;
END$$