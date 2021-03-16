DELIMITER $$
CREATE PROCEDURE sp_obter_categorias()
BEGIN
	SELECT ca.cd_categoria, ca.nm_categoria 
		FROM tb_categoria AS ca
			JOIN tb_anuncio AS an
			ON ca.cd_categoria = an.cd_categoria;
END$$