DELIMITER $$
CREATE PROCEDURE sp_modAnunUsuario(
	IN codigo INT,
    IN tipo BIT(1),
    IN titulo VARCHAR(128),
    IN descricao VARCHAR(512),
    IN categoria VARCHAR(60)
)
BEGIN
	IF (tipo = 0 OR tipo = 1) THEN
		UPDATE tb_anuncio 
			SET ic_perda = tipo 
            WHERE cd_anuncio = codigo;
	END IF;
    
    IF (titulo != "") THEN
		UPDATE tb_anuncio 
			SET nm_anuncio = titulo
            WHERE cd_anuncio = codigo;
	END IF;
    
    IF (descricao != "") THEN
		UPDATE tb_anuncio
			SET ds_anuncio = descricao
			WHERE cd_anuncio = codigo;
	END IF;
    
    IF (categoria != "") THEN
		UPDATE tb_anuncio
			SET cd_categoria = (SELECT cd_categoria FROM tb_categoria WHERE nm_categoria = categoria)
            WHERE cd_anuncio = codigo;
	END IF;
    
    SELECT CONCAT('O anúncio foi atualizado com sucesso') AS Mensagem;
END$$
    