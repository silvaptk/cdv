DELIMITER $$
CREATE PROCEDURE sp_cadastraUsuario(
	IN nome VARCHAR(100),
	IN email VARCHAR(100),
	IN senha VARCHAR(40),
	IN confirma_senha VARCHAR(40),
	IN cpf VARCHAR(20),
	IN codigoCidade INT,
	IN telefone VARCHAR(20)
)
BEGIN
	DECLARE foundError BOOLEAN DEFAULT FALSE;
	DECLARE codigo INT DEFAULT 0;
	DECLARE cep INT DEFAULT 0;

	IF (nome = "") THEN
		SELECT CONCAT('Insira o seu nome') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND email = "") THEN 
		SELECT CONCAT('Insira o seu e-mail') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND senha = "") THEN 
		SELECT CONCAT('Insira uma senha') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND confirma_senha = "") THEN 
		SELECT CONCAT('Preencha a confirmação de senha') AS 'Mensagem';
	END IF;

	IF (foundError != TRUE AND cpf = "") THEN 
		SELECT CONCAT('Preencha o seu CPF') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND codigoCidade = "") THEN
		SELECT CONCAT('Selecione uma cidade') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND telefone = "") THEN
		SELECT CONCAT('Preencha um telefone para contato') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND telefone = "") THEN
		SELECT CONCAT('Preencha um telefone para contato') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;
	
	IF (foundError != TRUE AND EXISTS(SELECT cd_cadastro_nacional FROM tb_usuario WHERE cd_cadastro_nacional = cpf)) THEN
		SELECT CONCAT('Usuário existente') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE AND senha != confirma_senha) THEN
		SELECT CONCAT('As senhas inseridas diferem') AS 'Mensagem';
		SET foundError = TRUE;
	END IF;

	IF (foundError != TRUE) THEN
		SELECT cd_cep 
			INTO cep 
			FROM tb_endereco 
			WHERE cd_cidade = codigoCidade;

		IF (cep = "") THEN 
			SELECT (MAX(cd_cep) + 1) 
				INTO cep
				FROM tb_endereco;
			
			INSERT INTO tb_endereco(
				cd_cep,
				cd_cidade
			) VALUES (
				cep,
				codigoCidade
			);
		END IF;

		INSERT INTO tb_usuario(
			nm_usuario,
			cd_email_usuario,
			cd_senha_usuario,
			cd_cadastro_nacional,
			ic_instituicao, 
			cd_cep
		) VALUES (
			nome,
			email,
			senha,
			cpf, 
			0,
			cep
		);

		SELECT MAX(cd_usuario)
			INTO codigo
			FROM tb_usuario;

		INSERT INTO tb_contato(
			cd_usuario,
			cd_telefone
		) VALUES (
			codigo,
			telefone
		);

		SELECT CONCAT('Usuário cadastrado com sucesso!') AS 'Mensagem';
	END IF;
END$$