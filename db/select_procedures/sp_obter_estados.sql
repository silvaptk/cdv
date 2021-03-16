DELIMITER $$
CREATE PROCEDURE sp_obter_estados()
BEGIN 
    SELECT ci.sg_uf AS sg_uf 
        FROM tb_cidade AS ci
            JOIN tb_endereco AS en
            ON ci.cd_cidade  = en.cd_cidade
                JOIN tb_usuario AS us
                ON en.cd_cep = us.cd_cep
                    JOIN tb_anuncio AS an
                    ON us.cd_usuario = an.cd_usuario; 
END$$