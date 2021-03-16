DELIMITER $$
CREATE PROCEDURE sp_insertAvaliacao(
	IN titulo VARCHAR(100),
	IN descricao VARCHAR(512),
	IN qt_avaliacao INT,
	IN cd_avaliado INT,
	IN usuario INT
)
BEGIN
	DECLARE foundError BOOLEAN DEFAULT FALSE;

	IF (titulo = "") THEN
		SET foundError = TRUE;
		SELECT CONCAT('Insira um título para o anúncio') AS 'Mensagem';
	ELSEIF (valor = "" OR valor  = 0) THEN 
		SET foundError = TRUE;
		SELECT CONCAT('Selecione o valor da avaliação') AS 'Mensagem';
	ELSEIF (avaliado = "" OR avaliado = 0) THEN
		SET foundError = TRUE;
		SELECT CONCAT('Sem código da empresa') AS 'Mensagem';
	ELSEIF (usuario = "" OR usuario = 0) THEN
		SET foundError = TRUE;
		SELECT CONCAT('Sem código do usuário') AS 'Mensagem';
	END IF;

	IF (foundError = FALSE) THEN
		INSERT INTO tb_avaliacao(
			nm_avaliacao, 
			ds_avaliacao,
			qt_avaliacao,
			cd_avaliado,
			cd_usuario,
			dt_avaliacao 
		) VALUES (
			titulo, 
			descricao,
			valor,
			avaliado,
			usuario,
			now()
		);

		SELECT CONCAT('Avaliação inserida') AS 'Mensagem';
	END IF;
END$$