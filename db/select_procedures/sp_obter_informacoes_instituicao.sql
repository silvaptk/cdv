DELIMITER $$
CREATE PROCEDURE sp_obter_informacoes_instituicao(
	IN codigoInstituicao INT
)
BEGIN
	SELECT 	UPPER(u.nm_usuario) AS nomeInstituicao, 
			CONCAT((en.nm_endereco),', Nº ',(u.cd_numero),', ',(b.nm_bairro),', ',(c.nm_cidade),'/',(c.sg_uf)) AS enderecoInstituicao, 
        	u.cd_email_usuario AS emailInstituicao, 
        	cont.cd_telefone AS contatoInstituicao
	FROM tb_usuario AS u 		
		JOIN tb_contato AS cont 
		ON cont.cd_usuario = u.cd_usuario
			JOIN tb_endereco AS en 
			ON en.cd_cep = u.cd_cep 
				JOIN tb_bairro AS b 
				ON b.cd_bairro = en.cd_bairro 
					JOIN tb_cidade AS c 
					ON c.cd_cidade = b.cd_cidade 
		WHERE u.cd_usuario = codigoInstituicao;
END$$