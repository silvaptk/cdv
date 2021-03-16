DELIMITER $$
CREATE PROCEDURE sp_obter_anuncio_pessoal(
	IN codigoAnuncio INT
)
BEGIN
	SELECT 	u.nm_usuario AS nomeUsuario, 
			DATE_FORMAT(a.dt_anuncio, "%d" '/' "%m" '/' "%Y" ' às ' "%k" ':' "%i" 'h') AS dataAnuncio, 
            a.ic_perda AS tipoAnuncio, 
            ca.nm_categoria AS nomeCategoria, 
            a.nm_anuncio AS nomeAnuncio, 
            a.ds_anuncio AS descricaoAnuncio, 
            co.cd_telefone AS contatoUsuario, 
            ci.nm_cidade AS nomeCidade, 
            ci.sg_uf AS cidadeUF 
		FROM tb_anuncio AS a 
			JOIN tb_categoria AS ca 
            ON a.cd_categoria = ca.cd_categoria 
				JOIN tb_usuario AS u 
                ON a.cd_usuario = u.cd_usuario 
					JOIN tb_contato AS co 
                    ON u.cd_usuario = co.cd_usuario 	
						JOIN tb_endereco AS e 
                        ON u.cd_cep = e.cd_cep 
							JOIN tb_cidade AS ci 
							ON e.cd_cidade = ci.cd_cidade 
			WHERE a.cd_anuncio = codigoAnuncio;
END$$