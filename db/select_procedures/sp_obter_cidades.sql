DELIMITER $$
CREATE PROCEDURE sp_obter_cidades(
    IN uf VARCHAR(2)
)
BEGIN
    SELECT  ci.cd_cidade AS cd_cidade,
            ci.nm_cidade AS nm_cidade
        FROM tb_cidade AS ci
            JOIN tb_endereco AS en
            ON ci.cd_cidade = en.cd_cidade
                JOIN tb_usuario AS us
                ON en.cd_cep = us.cd_cep
                    JOIN tb_anuncio AS an
                    ON us.cd_usuario = an.cd_usuario
        WHERE ci.sg_uf = uf;
END$$