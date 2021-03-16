DELIMITER $$
CREATE PROCEDURE sp_obter_anuncios_usuario(
	IN codigoUsuario INT
)
BEGIN
	SELECT 	a.cd_anuncio AS codigoAnuncio, 
			a.nm_anuncio AS nomeAnuncio, 
			u.nm_usuario AS nomeUsuario, 
			ci.nm_cidade AS cidadeUsuario, 
			ci.sg_uf AS ufUsuario, 
			UPPER(ca.nm_categoria) AS categoriaAnuncio, 
			DATE_FORMAT(a.dt_anuncio, '%d' '/' '%m' '/' '%Y' ' às ' '%k' ':' '%i') AS dataAnuncio,
			(SELECT cd_caminho FROM tb_imagem WHERE cd_anuncio = a.cd_anuncio LIMIT 1) AS urlImagem
		FROM tb_categoria AS ca 
			JOIN tb_anuncio AS a 
        	ON ca.cd_categoria = a.cd_categoria 
				JOIN tb_usuario AS u 
            	ON a.cd_usuario = u.cd_usuario 
					JOIN tb_endereco AS e 
                	ON u.cd_cep = e.cd_cep 
						JOIN tb_cidade AS ci 
                    	ON e.cd_cidade = ci.cd_cidade 
		WHERE u.cd_usuario = codigoUsuario
			ORDER BY a.dt_anuncio DESC;
END$$