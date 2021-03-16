DELIMITER $$
CREATE PROCEDURE sp_filtrar_anuncios(
	IN tipoUsuario INT,
    IN tipoAnuncio INT,
    IN categoria VARCHAR(60),
    IN cidade VARCHAR(100),
    IN uf VARCHAR(2),
    IN pesquisa VARCHAR(512)
)
BEGIN
	IF (tipoUsuario = 0) THEN -- ambos os usuários
		IF (tipoAnuncio = 0) THEN -- ambos os tipos de anúncios
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
                    an.nm_anuncio AS nomeAnuncio,
                    us.nm_usuario AS nomeUsuario,
                    ci.nm_cidade AS cidadeUsuario,
                    ci.sg_uf AS ufUsuario,
                    ca.nm_categoria AS categoriaAnuncio,
                    DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im -- LEFT porque talvez o anúncio não detenha imagens
                    ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
                        ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
                            ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
                                ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
                                    ON an.cd_categoria = ca.cd_categoria
				WHERE 	ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
                        ci.sg_uf LIKE CONCAT('%', uf, '%') AND
                        (an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa);
        ELSEIF (tipoAnuncio = 1) THEN -- anúncios de objetos encontrados
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
                    an.nm_anuncio AS nomeAnuncio,
                    us.nm_usuario AS nomeUsuario,
                    ci.nm_cidade AS cidadeUsuario,
                    ci.sg_uf AS ufUsuario,
                    ca.nm_categoria AS categoriaAnuncio,
                    DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im
                    ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
                        ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
                            ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
                                ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
                                    ON an.cd_categoria = ca.cd_categoria
				WHERE 	ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
                        ci.sg_uf LIKE CONCAT('%', uf, '%') AND
                        an.ic_perda = 0 AND
                        (an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa);
        ELSE -- anúncios de objetos perdidos
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
                    an.nm_anuncio AS nomeAnuncio,
                    us.nm_usuario AS nomeUsuario,
                    ci.nm_cidade AS cidadeUsuario,
                    ci.sg_uf AS ufUsuario,
                    ca.nm_categoria AS categoriaAnuncio,
                    DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im -- LEFT porque talvez o anúncio não detenha imagens
                    ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
                        ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
                            ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
                                ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
                                    ON an.cd_categoria = ca.cd_categoria
				WHERE 	ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
                        ci.sg_uf LIKE CONCAT('%', uf, '%') AND
                        an.ic_perda = 1 AND
                        (an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa);
        END IF;
    ELSEIF (tipoUsuario = 1) THEN -- anúncios de instituição (somente anúncios de objetos encontrados)
		SELECT 	an.cd_anuncio AS codigoAnuncio,
				im.cd_caminho AS urlImagem,
				an.nm_anuncio AS nomeAnuncio,
				us.nm_usuario AS nomeUsuario,
				ci.nm_cidade AS cidadeUsuario,
				ci.sg_uf AS ufUsuario,
				ca.nm_categoria AS categoriaAnuncio,
				DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
			FROM tb_anuncio AS an
				LEFT JOIN tb_imagem AS im -- LEFT porque talvez o anúncio não detenha imagens
				ON an.cd_anuncio = im.cd_anuncio
					JOIN tb_usuario AS us
					ON an.cd_usuario = us.cd_usuario
						JOIN tb_endereco AS en 
						ON us.cd_cep = en.cd_cep
							JOIN tb_cidade AS ci
							ON en.cd_cidade = ci.cd_cidade
								JOIN tb_categoria AS ca
								ON an.cd_categoria = ca.cd_categoria
			WHERE 	us.ic_instituicao = 1 AND
					ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
					en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
					ci.sg_uf LIKE CONCAT('%', uf, '%') AND
					(an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa);   
    ELSE -- anúncios de pessoas
		IF (tipoAnuncio = 0) THEN -- anúncios de ambos os tipos
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
					an.nm_anuncio AS nomeAnuncio,
					us.nm_usuario AS nomeUsuario,
					ci.nm_cidade AS cidadeUsuario,
					ci.sg_uf AS ufUsuario,
					ca.nm_categoria AS categoriaAnuncio,
					DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im -- LEFT porque talvez o anúncio não detenha imagens
					ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
						ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
							ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
								ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
									ON an.cd_categoria = ca.cd_categoria
				WHERE 	us.ic_instituicao = 0 AND
						ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
						ci.sg_uf LIKE CONCAT('%', uf, '%') AND
						(an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa); 
        ELSEIF (tipoAnuncio = 1) THEN -- anúncios de objetos encontrados
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
					an.nm_anuncio AS nomeAnuncio,
					us.nm_usuario AS nomeUsuario,
					ci.nm_cidade AS cidadeUsuario,
					ci.sg_uf AS ufUsuario,
					ca.nm_categoria AS categoriaAnuncio,
					DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im 
					ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
						ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
							ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
								ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
									ON an.cd_categoria = ca.cd_categoria
				WHERE 	us.ic_instituicao = 0 AND
						an.ic_perda = 0 AND
						ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
						ci.sg_uf LIKE CONCAT('%', uf, '%') AND
						(an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa); 
        ELSE -- anúncios de objetos perdidos
			SELECT 	an.cd_anuncio AS codigoAnuncio,
					im.cd_caminho AS urlImagem,
					an.nm_anuncio AS nomeAnuncio,
					us.nm_usuario AS nomeUsuario,
					ci.nm_cidade AS cidadeUsuario,
					ci.sg_uf AS ufUsuario,
					ca.nm_categoria AS categoriaAnuncio,
					DATE_FORMAT(an.dt_anuncio, "%d/%m/%Y às %H:%i") AS dataAnuncio
				FROM tb_anuncio AS an
					LEFT JOIN tb_imagem AS im 
					ON an.cd_anuncio = im.cd_anuncio
						JOIN tb_usuario AS us
						ON an.cd_usuario = us.cd_usuario
							JOIN tb_endereco AS en 
							ON us.cd_cep = en.cd_cep
								JOIN tb_cidade AS ci
								ON en.cd_cidade = ci.cd_cidade
									JOIN tb_categoria AS ca
									ON an.cd_categoria = ca.cd_categoria
				WHERE 	us.ic_instituicao = 0 AND
						an.ic_perda = 1 AND
						ca.nm_categoria LIKE CONCAT('%', categoria, '%') AND
						en.cd_cidade LIKE CONCAT('%', cidade, '%') AND
						ci.sg_uf LIKE CONCAT('%', uf, '%') AND
						(an.nm_anuncio LIKE CONCAT('%', pesquisa, '%') OR an.ds_anuncio LIKE pesquisa); 
        END IF;
    END IF;
END$$