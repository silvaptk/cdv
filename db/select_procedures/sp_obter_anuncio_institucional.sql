DELIMITER $$
CREATE PROCEDURE sp_obter_anuncio_institucional(
	IN codigoAnuncio INT
)
BEGIN
	SELECT 	u.nm_usuario AS nomeUsuario, 
			u.cd_usuario AS codigoInstituicao,
			a.cd_anuncio as codigoAnuncio, 
            DATE_FORMAT(a.dt_anuncio, '%d' '/' '%m' '/' '%Y' ' às ' '%k' ':' '%i') AS dataAnuncio, 
            a.ic_perda AS tipoAnuncio, 
            ca.nm_categoria AS nomeCategoria, 
            a.nm_anuncio AS nomeAnuncio, 
            a.ds_anuncio AS descricaoAnuncio
		FROM tb_anuncio AS a 
			JOIN tb_categoria AS ca 
            ON a.cd_categoria = ca.cd_categoria 
				JOIN tb_usuario AS u 
                ON a.cd_usuario = u.cd_usuario
			WHERE a.cd_anuncio = codigoAnuncio;
END$$