DELIMITER $$
CREATE PROCEDURE sp_obter_avaliacoes_instituicao(
	IN codigoInstituicao INT
)
BEGIN
	SELECT 	av.nm_avaliacao AS tituloAvaliacao, 
		av.ds_avaliacao AS descricaoAvaliacao, 
		av.qt_avaliacao AS quantidadeAvaliacao, 
        DATE_FORMAT(av.dt_avaliacao, '%d' '/' '%m' '/' '%Y' ' às ' '%k' ':' '%i') AS dataAvaliacao, 
        u.nm_usuario AS nomeAvaliador 
	FROM tb_avaliacao AS av 
		JOIN tb_usuario AS u 
        ON av.cd_usuario = u.cd_usuario 
	WHERE av.cd_avaliado = codigoInstituicao;
END$$