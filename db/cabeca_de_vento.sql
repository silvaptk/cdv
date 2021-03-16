DROP DATABASE IF EXISTS cabeca_de_vento;
CREATE DATABASE cabeca_de_vento;
USE cabeca_de_vento;

CREATE TABLE IF NOT EXISTS tb_cidade(
	cd_cidade INT(11) NOT NULL AUTO_INCREMENT,
    nm_cidade VARCHAR(100) NOT NULL,
    sg_uf VARCHAR(2) NOT NULL,
    
    CONSTRAINT pk_cidade
		PRIMARY KEY(cd_cidade)        
);

CREATE TABLE IF NOT EXISTS tb_bairro(
	cd_bairro INT(11) AUTO_INCREMENT,
    nm_bairro VARCHAR(50),
    cd_cidade INT(11),
    
    CONSTRAINT pk_bairro
		PRIMARY KEY(cd_bairro,cd_cidade),
        
	CONSTRAINT fk_bairro_cidade
		FOREIGN KEY(cd_cidade)
			REFERENCES tb_cidade(cd_cidade)
);

CREATE TABLE IF NOT EXISTS tb_endereco(
	cd_cep INT NOT NULL AUTO_INCREMENT,
	nm_endereco VARCHAR(200),
    cd_cidade INT(11),
	cd_bairro INT(11),
    
    CONSTRAINT pk_endereco
		PRIMARY KEY(cd_cep),
        
	CONSTRAINT fk_endereco_cidade
		FOREIGN KEY(cd_cidade)
			REFERENCES tb_cidade(cd_cidade),
            
	CONSTRAINT fk_endereco_bairro
		FOREIGN KEY(cd_bairro)
			REFERENCES tb_bairro(cd_bairro)
);

CREATE TABLE IF NOT EXISTS tb_usuario(
	cd_usuario INT NOT NULL AUTO_INCREMENT,
    nm_usuario VARCHAR(100) NOT NULL,
    cd_email_usuario VARCHAR(100) NOT NULL,
    cd_senha_usuario VARCHAR(40) NOT NULL,
    cd_cadastro_nacional VARCHAR(20) NOT NULL,
    ic_instituicao BIT NOT NULL,
    cd_cep INT, 
    cd_numero INT(4),
    ds_complemento VARCHAR(20),
	cd_imagem_perfil VARCHAR(500),
	cd_imagem_capa VARCHAR(500)
    
    CONSTRAINT pk_usuario
		PRIMARY KEY(cd_usuario,cd_cep),
        
	CONSTRAINT fk_usuario_endereco
		FOREIGN KEY(cd_cep)
			REFERENCES tb_endereco(cd_cep)
);

CREATE TABLE IF NOT EXISTS tb_contato(
	cd_contato INT NOT NULL AUTO_INCREMENT,
    cd_telefone VARCHAR(20) NOT NULL,
    cd_usuario INT,
    
    CONSTRAINT pk_contato
		PRIMARY KEY(cd_contato),
        
	CONSTRAINT fk_contato_usuario
		FOREIGN KEY(cd_usuario)
			REFERENCES tb_usuario(cd_usuario)
);

CREATE TABLE IF NOT EXISTS tb_avaliacao(
	cd_avaliacao INT NOT NULL AUTO_INCREMENT,
    nm_avaliacao VARCHAR(100) NOT NULL,
    ds_avaliacao VARCHAR(512) NOT NULL,
    qt_avaliacao INT(2) NOT NULL,
    cd_avaliado INT NOT NULL,
    cd_usuario INT,
    dt_avaliacao datetime,
    
    CONSTRAINT pk_avaliacao
		PRIMARY KEY(cd_avaliacao, cd_usuario),
        
	CONSTRAINT fk_avaliacao_usuario
		FOREIGN KEY(cd_usuario)
			REFERENCES tb_usuario(cd_usuario)
    
);

CREATE TABLE IF NOT EXISTS tb_dia_rotina(
	cd_dia_rotina INT NOT NULL AUTO_INCREMENT,
    nm_dia VARCHAR(20),
    
    CONSTRAINT pk_cd_dia_rotina
		PRIMARY KEY(cd_dia_rotina)
);

CREATE TABLE IF NOT EXISTS tb_hora_rotina(
	cd_hora_rotina INT NOT NULL AUTO_INCREMENT,
    hr_abre time,
    hr_fecha time,
    cd_usuario INT,
    cd_dia_rotina INT,
    
    CONSTRAINT pk_hora_rotina
		PRIMARY KEY(cd_hora_rotina,cd_usuario,cd_dia_rotina),
        
	CONSTRAINT fk_hora_rotina_usuario
		FOREIGN KEY (cd_usuario)
			REFERENCES tb_usuario(cd_usuario),
            
	CONSTRAINT fk_hora_rotina_dia_rotina
		FOREIGN KEY (cd_dia_rotina)
			REFERENCES tb_dia_rotina(cd_dia_rotina)
);

CREATE TABLE IF NOT EXISTS tb_categoria(
	cd_categoria INT NOT NULL AUTO_INCREMENT,
    nm_categoria VARCHAR(60) NOT NULL,
    ds_categoria VARCHAR(128) NOT NULL,
    
    CONSTRAINT pk_categoria
		PRIMARY KEY(cd_categoria)

);

CREATE TABLE IF NOT EXISTS tb_anuncio(
	cd_anuncio INT NOT NULL AUTO_INCREMENT,
    nm_anuncio VARCHAR(128) NOT NULL,
    ds_anuncio VARCHAR(512) NOT NULL,
    dt_anuncio datetime NOT NULL,
    ic_perda bit NOT NULL,
    cd_usuario INT,
    cd_categoria INT,
    
    CONSTRAINT pk_anuncio
		PRIMARY KEY(cd_anuncio,cd_usuario,cd_categoria),
        
	CONSTRAINT fk_anuncio_usuario
		FOREIGN KEY(cd_usuario)
			REFERENCES tb_usuario(cd_usuario),
            
	CONSTRAINT fk_anuncio_categoria
		FOREIGN KEY (cd_categoria)
			REFERENCES tb_categoria(cd_categoria)
);

CREATE TABLE IF NOT EXISTS tb_imagem(
	cd_imagem INT NOT NULL AUTO_INCREMENT,
	cd_caminho VARCHAR(200) NOT NULL,
    cd_anuncio INT,
    
    CONSTRAINT pk_imagem 
		PRIMARY KEY(cd_imagem,cd_anuncio),
        
	CONSTRAINT fk_imagem_anuncio
		FOREIGN KEY(cd_anuncio)
			REFERENCES tb_anuncio(cd_anuncio)
);

CREATE TABLE IF NOT EXISTS tb_conversa(
	cd_conversa INT NOT NULL AUTO_INCREMENT,
    cd_destinatario INT NOT NULL,
    cd_usuario INT,
	cd_anuncio INT,
    
    CONSTRAINT pk_conversa
		PRIMARY KEY(cd_conversa,cd_usuario),
        
	CONSTRAINT fk_conversa_usuario
		FOREIGN KEY(cd_usuario)
			REFERENCES tb_usuario(cd_usuario),
	CONSTRAINT fk_conversa_anuncio
		FOREIGN KEY(cd_anuncio)
			REFERENCES tb_anuncio(cd_anuncio)
);

CREATE TABLE IF NOT EXISTS tb_mensagem(
	cd_mensagem INT NOT NULL AUTO_INCREMENT,
	ds_mensagem VARCHAR(512) NOT NULL,
    dt_mensagem datetime NOT NULL,
    cd_conversa INT,
    
    CONSTRAINT pk_mensagem
		PRIMARY KEY(cd_mensagem,cd_conversa),
        
	CONSTRAINT fk_mensagem_conversa
		FOREIGN KEY (cd_conversa)
			REFERENCES tb_conversa(cd_conversa)
);

INSERT INTO tb_dia_rotina(
	cd_dia_rotina, 
	nm_dia
) VALUES
	(1,'Domingo'),
	(2,'Segunda-Feira'),
	(3,'Terça-Feira'),
	(4,'Quarta-Feira'),
	(5,'Quinta-Feira'),
	(6,'Sexta-Feira'),
	(7,'Sábado'),
	(8,'Feriados')
;

INSERT INTO tb_categoria VALUES 
	(1,'Material escolar','Um estojo, um esquadro, um compasso.'),
	(2,'Dispositivos eletrônicos','Celulares, tablets, notebooks, e etc.'),
	(3,'Acessórios do cotidiano','Guarda-chuva, bolsa, '),
	(4,'Vestimenta','Roupas de um modo geral.'),
	(5,'Documentos','CPF, RG e etc.'),
	(6, 'Valor sentimental', 'Objetos que têm somente valor sentimental.')
;