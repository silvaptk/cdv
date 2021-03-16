DELIMITER $$
CREATE PROCEDURE sp_obter_informacoes_pessoa(
	IN codigoPessoa INT
)
BEGIN
	SELECT 	u.nm_usuario AS nomeUsuario, 
			c.nm_cidade AS nomeCidade, 
			c.sg_uf AS cidadeUF, 
        	cont.cd_telefone AS contatoUsuario 
		FROM tb_usuario AS u 
			JOIN tb_contato AS cont 
			ON cont.cd_usuario = u.cd_usuario 
				JOIN tb_endereco AS en 
            	ON en.cd_cep = u.cd_cep 
					JOIN tb_bairro AS b 
                	ON b.cd_bairro = en.cd_bairro 
						JOIN tb_cidade AS c 
                    	ON c.cd_cidade = b.cd_cidade 
		WHERE u.cd_usuario = codigoPessoa;
END$$