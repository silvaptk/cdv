DELIMITER $$
CREATE PROCEDURE sp_cadastraInstituicao(
    IN nome VARCHAR(100),
    IN email VARCHAR(100),
    IN senha VARCHAR(40),
    IN confirma_senha VARCHAR(40),  
    IN cnpj VARCHAR(20),
    IN cep INT,
    IN telefone VARCHAR(20),
    IN numero INT,
    IN complemento VARCHAR(20),

    IN abreSegunda VARCHAR(20),
    IN fechaSegunda VARCHAR(20),
    IN abreTerca  VARCHAR(20),
    IN fechaTerca VARCHAR(20),
    IN abreQuarta VARCHAR(20),
    IN fechaQuarta VARCHAR(20),
    IN abreQuinta VARCHAR(20),
    IN fechaQuinta VARCHAR(20),
    IN abreSexta VARCHAR(20),
    IN fechaSexta VARCHAR(20),
    IN abreSabado VARCHAR(20),
    IN fechaSabado VARCHAR(20),
    IN abreDomingo VARCHAR(20),
    IN fechaDomingo VARCHAR(20),
    IN abreFeriado VARCHAR(20),
    IN fechaFeriado VARCHAR(20)
)
BEGIN
    DECLARE foundError BOOLEAN DEFAULT FALSE;
    DECLARE usuarioAtual INT DEFAULT 0;

    IF (nome = "") THEN
        SELECT concat('Insira o seu nome') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (email = "") THEN
        SELECT concat('Insira o seu e-mail') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (senha = "") THEN
        SELECT concat('Insira uma senha') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (confirma_senha = "") THEN
        SELECT concat('Confirme a sua senha') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (cnpj = "") THEN
        SELECT concat('Preencha seu CPF') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (cep = "") THEN
        SELECT concat('Selecione uma cidade') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (telefone = "") THEN
        SELECT concat('Preencha um telefone para contato') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (numero = "") THEN
        SELECT concat('Insira o número da sua instituição') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (senha = "") THEN
        SELECT concat('Insira uma senha') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreSegunda = "" OR fechaSegunda = "") THEN
        SELECT concat('Insira seus horários de segunda-feira') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreTerca = "" OR fechaTerca = "") THEN
        SELECT concat('Insira seus horários de terça-feira') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreQuarta = "" OR fechaQuarta = "") THEN
        SELECT concat('Insira seus horários de quarta-feira') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreQuinta = "" OR fechaQuinta = "") THEN
        SELECT concat('Insira seus horários de quinta-feira') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreSexta = "" OR fechaSexta = "") THEN
        SELECT concat('Insira seus horários de sexta-feira') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreSabado = "" OR fechaSabado = "") THEN
        SELECT concat('Insira seus horários de sábado') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreDomingo = "" OR fechaDomingo = "") THEN
        SELECT concat('Insira seus horários de domingo') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (abreFeriado = "" OR fechaFeriado = "") THEN
        SELECT concat('Insira seus horários de feriado') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (exists(SELECT cd_cadastro_nacional FROM tb_usuario WHERE cd_cadastro_nacional = cnpj)) THEN
        SELECT concat('Usuário existente') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;
    IF (senha != confirma_senha) THEN
        SELECT concat('As senhas dIF erem') AS 'Mensagem';
        SET foundError = TRUE;
    END IF;

    IF  (foundError != TRUE) THEN
        INSERT INTO tb_usuario(
            nm_usuario,
            cd_email_usuario,
            cd_senha_usuario,
            cd_cadastro_nacional,
            ic_instituicao,
            cd_cep,
            cd_numero,
            ds_complemento
        ) VALUES (
            nome,
            email,
            senha,
            cnpj,
            1,
            cep,
            numero,
            complemento
        );

        SELECT MAX(cd_usuario) INTO usuarioAtual FROM tb_usuario;

        INSERT INTO tb_contato(
            cd_telefone, 
            cd_usuario
        ) VALUES (
            telefone, 
            usuarioAtual
        );

        IF (abreSegunda = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                2,
                usuarioAtual);
        ELSEIF (abreSegunda = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                2,
                usuarioAtual);
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreSegunda,
                fechaSegunda,
                2,
                usuarioAtual
            );
        END IF;
                
        IF (abreTerca = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                3,
                usuarioAtual
            );
        ELSEIF (abreTerca = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                3,
                usuarioAtual
            );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreTerca,
                fechaTerca,
                3,
                usuarioAtual
            );
        END IF;
        
        IF (abreQuarta = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                4,
                usuarioAtual
            );
        ELSEIF (abreQuarta = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                4,
                usuarioAtual
            );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
                ) VALUES (
                    abreQuarta,
                    fechaQuarta,
                    4,
                    usuarioAtual
                );	
        END IF;
        
        IF (abreQuinta = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                5,
                usuarioAtual
            );
        ELSEIF (abreQuinta = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                5,
                usuarioAtual
            );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreQuinta,
                fechaQuinta,
                5,
                usuarioAtual
            );
        END IF;
        
        IF (abreSexta = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
                ) VALUES (
                    null,
                    null,
                    6,
                    usuarioAtual
                );
        ELSEIF (abreSexta = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
                ) VALUES (
                    '00:00',
                    '00:00',
                    6,
                    usuarioAtual
                );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
                ) VALUES (
                    abreSexta,
                    fechaSexta,
                    6,
                    usuarioAtual
                );
        END IF;
        
        IF (abreSabado = "Não abre") THEN
            INSERT INTO tb_hora_rotina(hr_abre,
            hr_fecha,
            cd_dia_rotina,
            cd_usuario
            ) VALUES (
                null,
                null,
                7,
                usuarioAtual
            );
        ELSEIF (abreSabado = "24 horas") THEN
            INSERT INTO tb_hora_rotina(hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                7,
                usuarioAtual);
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreSabado,
                fechaSabado,
                7,
                usuarioAtual);
        END IF;
        
        IF (abreDomingo = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                1,
                usuarioAtual
            );
        ELSEIF (abreDomingo = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                1,
                usuarioAtual
            );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreDomingo,
                fechaDomingo,
                1,
                usuarioAtual
            );
        END IF;
        
        IF (abreFeriado = "Não abre") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                null,
                null,
                8,
                usuarioAtual
            );
        ELSEIF (abreFeriado = "24 horas") THEN
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                '00:00',
                '00:00',
                8,
                usuarioAtual
            );
        ELSE
            INSERT INTO tb_hora_rotina(
                hr_abre,
                hr_fecha,
                cd_dia_rotina,
                cd_usuario
            ) VALUES (
                abreFeriado,
                fechaFeriado,
                8,
                usuarioAtual
            );
        END IF;
        
        SELECT CONCAT('Instituição cadastrada com sucesso!') AS 'Mensagem';
    END IF;
END$$