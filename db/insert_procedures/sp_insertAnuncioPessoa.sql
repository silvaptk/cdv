DELIMITER $$
CREATE PROCEDURE sp_insertAnuncioPessoa(
	IN anuncio varchar(128),
	IN descricao varchar(512),
	IN tipo_anuncio BIT,
	IN usuario INT,
	IN categoria varchar(60)
)
BEGIN
	DECLARE foundError BOOLEAN DEFAULT FALSE;
	
    IF (anuncio = "") THEN
		SELECT CONCAT('Preencha o titulo do anuncio') AS Mensagem;
		SET foundError = TRUE;
	END IF;
	IF (foundError = FALSE AND descricao = "") THEN
		SELECT CONCAT('Preencha a descrição do anuncio') AS Mensagem;
		SET foundError = TRUE;
	END IF;
	IF (foundError = FALSE AND tipo_anuncio != 0 AND tipo_anuncio != 1) THEN
		SELECT CONCAT('Selecione o tipo do anúncio') AS Mensagem;
		SET foundError = TRUE;
	END IF;
	IF (foundError = FALSE AND usuario = "") THEN              
		SELECT CONCAT('Sem código de usuário') AS Mensagem;
		SET foundError = TRUE;
	END IF;  

	IF (foundError = FALSE) THEN
		INSERT INTO tb_anuncio(
			nm_anuncio,
			ds_anuncio,
			dt_anuncio,
			ic_perda,
			cd_usuario,
			cd_categoria
		) values (
			anuncio, 
			descricao, 
			now(), 
			tipo_anuncio,
			usuario,
			(SELECT cd_categoria FROM tb_categoria WHERE nm_categoria = categoria)
		);
	END IF;
END$$