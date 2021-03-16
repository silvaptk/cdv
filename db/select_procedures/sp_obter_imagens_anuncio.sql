DELIMITER $$
CREATE PROCEDURE sp_obter_imagens_anuncio(
	IN codigoAnuncio INT
)
BEGIN
	SELECT cd_caminho AS urlImagem FROM tb_imagem WHERE cd_anuncio = codigoAnuncio;
END$$