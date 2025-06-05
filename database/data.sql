DROP DATABASE myNotes;
CREATE DATABASE IF NOT EXISTS myNotes CHARACTER SET utf8;
use myNotes;

CREATE TABLE enderecos(
	pkEndereco INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	rua VARCHAR(100) NOT NULL,
	numero int NOT NULL,
	complemento VARCHAR(80),
	bairro VARCHAR(100) NOT NULL,
	cep INT(8) NOT NULL,
	cidade VARCHAR(80) NOT NULL,
	estado CHAR(2) NOT NULL
)CHARACTER SET utf8;

CREATE TABLE telefones(
	pkTelefone INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	ddd INT(2) NOT NULL,
	numero INT(11) NOT NULL
)CHARACTER SET utf8;

CREATE TABLE pessoas(
	pkPessoa INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(120) NOT NULL,
	email VARCHAR(180) NOT NULL UNIQUE KEY,
	senha VARCHAR(128) NOT NULL CHECK (CHAR_LENGTH(senha) >= 8),
	dataDeNascimento DATE NOT NULL,
	RG VARCHAR(10) NOT NULL UNIQUE KEY,
	CPF VARCHAR(11) NOT NULL UNIQUE KEY,
	sexo ENUM ('M', 'F', 'N/A') DEFAULT 'N/A',
	imageLocal VARCHAR(90) DEFAULT "default-profile.webp", -- "Caminho das imagens"
	fkTelefone INT NOT NULL,
	fkEndereco INT NOT NULL,
	FOREIGN KEY (fkTelefone) REFERENCES telefones(pkTelefone),
	FOREIGN KEY (fkEndereco) REFERENCES enderecos(pkEndereco)
)CHARACTER SET utf8;

CREATE TABLE psicologos(
	pkPsicologo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	CRP VARCHAR(10) NOT NULL UNIQUE KEY,
	fkPessoa INT NOT NULL,
	FOREIGN KEY (fkPessoa) REFERENCES pessoas(pkPessoa)
)CHARACTER SET utf8;

CREATE TABLE responsaveis(
	pkResponsavel INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPessoa INT NOT NULL,
	FOREIGN KEY (fkPessoa) REFERENCES pessoas(pkPessoa)
)CHARACTER SET utf8;


CREATE TABLE pacientes(
	pkPaciente INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPessoa INT NOT NULL UNIQUE KEY,
	fkPsicologo INT NOT NULL,
	fkResponsavel INT NULL,
	FOREIGN KEY (fkPessoa) REFERENCES pessoas(pkPessoa),
	FOREIGN KEY (fkPsicologo) REFERENCES psicologos(pkPsicologo),
	FOREIGN KEY (fkResponsavel) REFERENCES responsaveis(pkResponsavel)
)CHARACTER SET utf8;

CREATE TABLE secretarios(
	pkSecretario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPessoa INT NOT NULL,
	FOREIGN KEY (fkPessoa) REFERENCES pessoas(pkPessoa)
)CHARACTER SET utf8;

CREATE TABLE flags(
	pkFlag INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	color VARCHAR(12) NOT NULL, -- cor em HEX
	tituloDaFlag VARCHAR(50) NOT NULL,
	descricao VARCHAR(120)
)CHARACTER SET utf8;

CREATE TABLE anotacoesPacientes(
	pkAnotacaoPaciente INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPaciente INT NOT NULL,
	diaDaAnotacao DATETIME NOT NULL,
	anotacao TEXT NOT NULL,
	FOREIGN KEY (fkPaciente) REFERENCES pacientes(pkPaciente)
)CHARACTER SET utf8;

CREATE TABLE anotacoesPsicologos(
	pkAnotacoesPsicologo INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPsicologo INT NOT NULL,
	fkFlag INT NOT NULl,
	fkAnotacoesPaciente INT NOT NULL,
	observacao TEXT NOT NULL,
	diaDaObservacao DATETIME,
	FOREIGN KEY (fkPsicologo) REFERENCES psicologos(pkPsicologo),
	FOREIGN KEY (fkFlag) REFERENCES flags(pkFlag),
	FOREIGN KEY (fkAnotacoesPaciente) REFERENCES anotacoesPacientes(pkAnotacaoPaciente)
)CHARACTER SET utf8;

CREATE TABLE atividades(
	pkAtividade INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	titulo VARCHAR(80) NOT NULL,
	descricao TEXT NOT NULL
)CHARACTER SET utf8;


CREATE TABLE atividadesPacientes(
	pkAtividade INT NOT NULL,
	pkPaciente INT NOT NULL,
	PRIMARY KEY (pkAtividade, pkPaciente),
	FOREIGN KEY (pkAtividade) REFERENCES atividades(pkAtividade),
	FOREIGN KEY (pkPaciente) REFERENCES pacientes(pkPaciente)
);

CREATE TABLE consultas(
	pkCosulta INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	fkPaciente INT NOT NULL,
	horarioDaConsulta DATETIME NOT NULL,
	FOREIGN KEY (fkPaciente) REFERENCES pacientes(pkPaciente)
)CHARACTER SET utf8;

-- INSERT ENDERECO;

DELIMITER $$

CREATE PROCEDURE insertEndereco(

   IN _rua VARCHAR(100),
	IN _numero INT,
	IN _complemento VARCHAR(80),
	IN _bairro VARCHAR(100),
	IN _cep INT(8),
	IN _cidade VARCHAR(80),
	IN _estado CHAR(2)
)

BEGIN

    INSERT INTO Enderecos (pkEndereco, rua, numero, complemento, bairro, cep, cidade, estado) 
    VALUES (DEFAULT, _rua, _numero, _complemento, _bairro, _cep, _cidade, _estado);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT TELEFONE;

DELIMITER $$

CREATE PROCEDURE insertTelefone(

    IN _ddd INT(2),
	IN _numero INT(11)
	
)

BEGIN

    INSERT INTO telefones (pkTelefone, ddd, numero) 
    VALUES (DEFAULT, _ddd, _numero);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- INSERT PESSOAS;
DELIMITER $$

CREATE PROCEDURE insertPessoa(
    IN _nome VARCHAR(120),
	IN _email VARCHAR(180),
	IN _senha VARCHAR(128),
	IN _dataDeNasc DATE,
	IN _RG VARCHAR(10),
	IN _CPF VARCHAR(11),
	IN _sexo ENUM('M','F', 'N/A'),
	IN _imageLocal VARCHAR(90),
	IN _fkTelefone INT,
	IN _fkEndereco INT
)

BEGIN

    INSERT INTO pessoas (pkPessoa, nome, email, senha, dataDeNascimento, RG, CPF, sexo, imageLocal, fkTelefone, fkEndereco)
    VALUES (DEFAULT, _nome, _email, _senha, _dataDeNasc, _RG, _CPF, _sexo, _imageLocal, _fkTelefone, _fkEndereco);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT PSICOLOGOS

DELIMITER $$

CREATE PROCEDURE insertPsicologo(
    IN _fkPessoa INT,
	IN _CRP VARCHAR(10)
)

BEGIN

    INSERT INTO psicologos (pkPsicologo, CRP, fkPessoa)
    VALUES (DEFAULT, _CRP, _fkPessoa);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT RESPONSAVEL

DELIMITER $$

CREATE PROCEDURE insertResponsavel(
    IN _fkPessoa INT
)

BEGIN

    INSERT INTO responsaveis (pkResponsavel, fkPessoa)
    VALUES (DEFAULT, _fkPessoa);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT PACIENTES

DELIMITER $$

CREATE PROCEDURE insertPacientes(
    IN _fkPessoa INT,
	IN _fkPsicologo INT,
	IN _fkResponsavel INT
)

BEGIN

    INSERT INTO pacientes (pkPaciente, fkPessoa, fkPsicologo,fkResponsavel)
    VALUES (DEFAULT, _fkPessoa, _fkPsicologo, _fkResponsavel);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT SECRETARIO

DELIMITER $$

CREATE PROCEDURE insertSecretario(
    IN _fkPessoa INT
)

BEGIN

    INSERT INTO secretarios (pkSecretario, fkPessoa)
    VALUES (DEFAULT, _fkPessoa);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT FLAG

DELIMITER $$

CREATE PROCEDURE insertFlags(
   IN _color VARCHAR(7),
	IN _tituloDaFlag VARCHAR(50),
	IN _descricao VARCHAR(120)
)	

BEGIN

    INSERT INTO flags (pkFlag, color, tituloDaFlag, descricao)
    VALUES (DEFAULT, _color, _tituloDaFlag, _descricao);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;




-- INSERT ANOTACOESPACIENTE

DELIMITER $$

CREATE PROCEDURE insertAnotacoesPacientes(
    IN _fkPaciente INT,
	IN _diaDaAnotacao DATETIME,
	IN _anotacao TEXT
)

BEGIN

    INSERT INTO anotacoesPacientes (pkAnotacaoPaciente, fkPaciente, diaDaAnotacao, anotacao)
    VALUES (DEFAULT, _fkPaciente, _diaDaAnotacao, _anotacao);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT ANOTACOESPACIENTE

DELIMITER $$

CREATE PROCEDURE insertAnotacoesPsicologos(
    IN _fkPsicologo INT,
	IN _fkFlag INT,
	IN _fkAnotacoesPaciente INT,
	IN _observacao TEXT,
	IN _diaDaObservacao DATETIME
)

BEGIN

    INSERT INTO anotacoesPsicologos (pkAnotacoesPsicologo, fkPsicologo, fkFlag, fkAnotacoesPaciente, observacao, diaDaObservacao)
    VALUES (DEFAULT, _fkPsicologo, _fkFlag, _fkAnotacoesPaciente, _observacao, _diaDaObservacao);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT ATIVIDADE

DELIMITER $$

CREATE PROCEDURE insertAtividades(
    IN _titulo VARCHAR(80),
	IN _descricao TEXT
)

BEGIN

    INSERT INTO atividades (pkAtividade, titulo, descricao)
    VALUES (DEFAULT, _titulo, _descricao);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT ATIVIDADESPACIENTE

DELIMITER $$

CREATE PROCEDURE insertAtividadesPaciente(
    IN _pkAtividade INT,
	IN _pkPaciente INT
)

BEGIN

    INSERT INTO atividadesPacientes (pkAtividade, pkPaciente)
    VALUES (_pkAtividade, _pkPaciente);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- INSERT CONSULTA

DELIMITER $$

CREATE PROCEDURE insertConsulta(
	IN _fkPaciente INT,
	IN _horarioDaConsulta DATETIME
)

BEGIN

    INSERT INTO consultas (pkCosulta, fkPaciente, horarioDaConsulta)
    VALUES (DEFAULT, _fkPaciente, _horarioDaConsulta);

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- Enderecos

CALL insertEndereco('Rua A', 123, 'Apto 101', 1, 12345678, 'São Paulo', 'SP');
CALL insertEndereco('Rua B', 456, 'Casa 2', 2, 87654321, 'Rio de Janeiro', 'RJ');
CALL insertEndereco('Avenida Central', 789, NULL, 3, 11223344, 'Belo Horizonte', 'MG');

-- Telefones

CALL insertTelefone(11, 987654321);
CALL insertTelefone(21, 998877665);
CALL insertTelefone(31, 912345678);
CALL insertTelefone(11, 987654345);
CALL insertTelefone(21, 998877632);
CALL insertTelefone(31, 912345428);

-- Pessoas

-- A senha é a palavra ("*_ 'senha' _*") em md5, e8d95a51f3af4a3b134bf6bb680a213a

CALL insertPessoa('Ana Souza', 'ana@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1995-06-30', '44332211', '12345678900', 'F', DEFAULT, 1, 1);
CALL insertPessoa('Pedro Lima', 'pedro@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1988-11-12', '66778899', '09876543211', 'M', DEFAULT, 2, 2);
CALL insertPessoa('Mariana Costa', 'mariana@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '2002-09-05', '22334455', '11223344556', 'F', DEFAULT, 3, 3);
CALL insertPessoa('Ricardo Almeida', 'ricardo@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1993-04-20', '77889900', '22334455667', 'M', DEFAULT, 4, 1);
CALL insertPessoa('Juliana Mendes', 'juliana@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1980-07-18', '33445566', '33445566778', 'F', DEFAULT, 5, 2);
CALL insertPessoa('Fernando Rocha', 'fernando@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1997-03-25', '55667788', '44556677889', 'M', DEFAULT, 6, 3);
CALL insertPessoa('Lucas Martins', 'lucas@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1992-02-14', '99887766', '55667788990', 'M', DEFAULT, 1, 1);
CALL insertPessoa('Camila Ferreira', 'camila@email.com', 'e8d95a51f3af4a3b134bf6bb680a213a', '1999-10-08', '11221133', '66778899000', 'F', DEFAULT, 2, 2);


-- Psicólogos
CALL insertPsicologo(1, 'CRP44556');
CALL insertPsicologo(2, 'CRP77889');

-- Responsáveis
CALL insertResponsavel(3);
CALL insertResponsavel(4);

-- Pacientes (Associados a Psicólogos e Responsáveis)
CALL insertPacientes(6, 1, NULL);
CALL insertPacientes(7, 2, NULL);
-- CALL insertPacientes(5, 1, NULL);
-- CALL insertPacientes(8, 2, NULL);

-- Secretários
CALL insertSecretario(8);
CALL insertSecretario(5);

-- Flags

CALL insertFlags('#FF0000', 'Alerta', 'Necessita atenção urgente');
CALL insertFlags('#00FF00', 'Seguro', 'Sem riscos aparentes');
CALL insertFlags('#0000FF', 'Monitoramento', 'Requer observação periódica');
CALL insertFlags('#FF0000', 'Alerta', 'Necessita atenção urgente');
CALL insertFlags('#00FF00', 'Seguro', 'Sem riscos aparentes');
CALL insertFlags('#0000FF', 'Monitoramento', 'Requer observação periódica');

CALL insertAnotacoesPacientes(1, '2024-02-25 14:30:00', 'Melhora significativa.');
CALL insertAnotacoesPacientes(2, '2024-02-24 10:00:00', 'Dificuldades para dormir.');

-- PAREI
CALL insertAnotacoesPsicologos(1, 1, 1, 'Paciente respondeu bem ao tratamento.', '2024-02-25 15:00:00');
CALL insertAnotacoesPsicologos(2, 3, 2, 'Paciente apresentou sinais de ansiedade.', '2024-02-24 11:00:00');

CALL insertAtividades('Exercícios de Relaxamento', 'Sessão de meditação guiada para pacientes.');
CALL insertAtividades('Treino Cognitivo', 'Atividades de memória e concentração.');

CALL insertConsulta(1, '2024-02-27 09:00:00');
CALL insertConsulta(2, '2024-02-28 14:00:00');

-- PAREI
CALL insertAtividadesPaciente(1, 1);
CALL insertAtividadesPaciente(2, 2);

-- seleciona o paciente pelo pk;

DELIMITER $$

CREATE PROCEDURE findPacienteByPk(
	IN _pkPaciente INT
)
BEGIN

	START TRANSACTION;

	SELECT * FROM pacientes
	INNER JOIN pessoas ON (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pacientes.pkPaciente = _pkPaciente; 

	COMMIT;
		ROLLBACK;
END $$
DELIMITER ;

-- seleciona todos os pacientes;

DELIMITER $$

CREATE PROCEDURE findAllPacientes(
)

BEGIN

    SELECT * FROM pacientes
	INNER JOIN pessoas ON (pessoas.pkPessoa = pacientes.fkPessoa); 

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

DELIMITER $$


-- seleciona o paciente pelo email;
CREATE PROCEDURE findPacienteByEmail(
	IN _email VARCHAR(180)
)

BEGIN

    SELECT * FROM pacientes
	INNER JOIN pessoas ON (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pessoas.email = _email; 

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

DELIMITER $$

CREATE PROCEDURE findAllPsicologos(
	
)

BEGIN

    SELECT * FROM psicologos
	INNER JOIN pessoas ON (pessoas.pkPessoa = psicologos.fkPessoa); 

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- seleciona o psicologo pelo email;

DELIMITER $$

CREATE PROCEDURE findPsicologoByEmail(
	IN _email VARCHAR(180)
)

BEGIN

    SELECT * FROM psicologos
	INNER JOIN pessoas ON (pessoas.pkPessoa = psicologos.fkPessoa)
	WHERE pessoas.email = _email;

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- seleciona o psicologo pelas PK;

DELIMITER $$

CREATE PROCEDURE findPsicologoByPk(
	IN _pkPsicologo INT
)

BEGIN

    SELECT * FROM psicologos
	INNER JOIN pessoas ON (pessoas.pkPessoa = psicologos.fkPessoa)
	WHERE psicologos.pkPsicologo = _pkPsicologo;

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- seleciona todos os secretario;


DELIMITER $$

CREATE PROCEDURE findAllSecretarios(
)
BEGIN

	START TRANSACTION;

	SELECT * FROM secretarios INNER JOIN pessoas ON (secretarios.fkPessoa = pessoas.pkPessoa);

	COMMIT;
		ROLLBACK;
END$$
DELIMITER ;

-- seleciona o secretario pelo email;

DELIMITER $$

CREATE PROCEDURE findSecretarioByEmail(
	IN _email VARCHAR(180)
)

BEGIN
	START TRANSACTION;

    SELECT * FROM secretarios
	INNER JOIN pessoas ON (pessoas.pkPessoa = secretarios.fkPessoa)
	WHERE pessoas.email = _email;

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- seleciona o secretario pela PK;

DELIMITER $$

CREATE PROCEDURE findSecretarioByPk(
	IN _pkSecretario INT
)

BEGIN

    SELECT * FROM secretarios
	INNER JOIN pessoas ON (pessoas.pkPessoa = secretarios.fkPessoa)
	WHERE secretarios.pkSecretario = _pkSecretario;

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- seleciona todsas derivantes de pessoas;

DELIMITER $$

CREATE PROCEDURE findAllTypePessoasByEmailAndPassword(
	IN _email VARCHAR(180),
	IN _senha VARCHAR(128)
)

BEGIN

   SELECT 	*
	FROM pessoas
	LEFT JOIN pacientes ON (pessoas.pkPessoa = pacientes.fkPessoa)
	LEFT JOIN psicologos ON (pessoas.pkPessoa = psicologos.fkPessoa)
	LEFT JOIN secretarios ON (pessoas.pkPessoa = secretarios.fkPessoa)
	LEFT JOIN responsaveis ON (pessoas.pkPessoa = responsaveis.fkPessoa)
	WHERE pessoas.email = _email AND pessoas.senha = _senha;

    COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- seleciona todas as consultas;

DELIMITER $$

CREATE PROCEDURE findAllconsultas()
BEGIN

   SELECT 	*
	FROM consultas
	INNER JOIN pacientes on (pacientes.pkPaciente = consultas.fkPaciente)
	INNER JOIN pessoas on (pessoas.pkPessoa = pacientes.fkPessoa);
    
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- encontra as consultas de um psicologo;

-- call findAllConsultasPsicologo(2);


DELIMITER $$

CREATE PROCEDURE findAllConsultasPsicologo(
_pk INT
)
BEGIN

   SELECT 	*
	FROM consultas
	INNER JOIN pacientes on (pacientes.pkPaciente = consultas.fkPaciente)
	INNER JOIN pessoas on (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pacientes.fkPsicologo = _pk;
    
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- CALL findAllConsultasPaciente(1);

DELIMITER $$

CREATE PROCEDURE findAllConsultasPaciente(
_pk INT
)
BEGIN

   SELECT 	*
	FROM consultas
	INNER JOIN pacientes on (pacientes.pkPaciente = consultas.fkPaciente)
	INNER JOIN pessoas on (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pacientes.pkPaciente = _pk;
    
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- seleciona as consultas pela pk;

DELIMITER $$
CREATE PROCEDURE findByPkconsultas(
	IN _pk INT
)
BEGIN

   SELECT 	
			consultas.pkCosulta,
			pessoas.nome,
			consultas.horarioDaConsulta,
			pacientes.pkPaciente
	FROM consultas
	INNER JOIN pacientes on (pacientes.pkPaciente = consultas.fkPaciente)
	INNER JOIN pessoas on (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pkCosulta = _pk;
    
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- selciona todas as anotacoesPacientes de um paciente

DELIMITER $$
CREATE PROCEDURE findAnotacoesByPkPacientes(
	IN _pk INT
)
BEGIN

	SELECT	anotacoespacientes.pkAnotacaoPaciente,
				anotacoespacientes.anotacao,
				pessoas.pkPessoa,
				pacientes.pkPaciente,
				pessoas.nome,
				anotacoespacientes.diaDaAnotacao,
				anotacoespsicologos.*,
				flags.color
	FROM anotacoespacientes
	LEFT JOIN anotacoespsicologos ON (anotacoespacientes.pkAnotacaoPaciente = anotacoespsicologos.fkAnotacoesPaciente)
	LEFT JOIN flags ON (flags.pkFlag = anotacoespsicologos.fkFlag)
	INNER JOIN pacientes ON (anotacoespacientes.fkPaciente = pacientes.pkPaciente)
	INNER JOIN pessoas ON (pessoas.pkPessoa = pacientes.fkPessoa)
	WHERE pacientes.pkPaciente = _pk
	ORDER BY anotacoesPacientes.diaDaAnotacao;
    
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- pega as anotacoes do psicologo pelo id da anoatacao do paciente;

DELIMITER $$
CREATE PROCEDURE findAnotacoesPsicologosByPkAnotacoesPacientes(
	IN _pk INT
)
BEGIN

SELECT	anotacoesPsicologos.pkAnotacoesPsicologo,
			anotacoespsicologos.observacao,
			pessoas.nome,
			anotacoespacientes.pkAnotacaoPaciente,
			anotacoespacientes.anotacao,
			flags.*
FROM anotacoesPsicologos
INNER JOIN flags ON (anotacoesPsicologos.fkFlag = flags.pkFlag)
INNER JOIN anotacoesPacientes ON (anotacoesPsicologos.fkAnotacoesPaciente = anotacoesPacientes.pkAnotacaoPaciente)
INNER JOIN pacientes ON (anotacoesPacientes.fkPaciente = pacientes.pkPaciente)
INNER JOIN pessoas ON (pacientes.fkPessoa = pessoas.pkPessoa)
WHERE anotacoespacientes.pkAnotacaoPaciente = _pk;

	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- procedure para encontra todos os dados de uma pessoa

DELIMITER $$
CREATE PROCEDURE findAllADataOfPessoaByPk(
	IN _pk INT
)
BEGIN

SELECT 
		pessoas.*,
		telefones.*,
		enderecos.*,
		telefones.numero AS 'numeroDeTelefone',
		enderecos.numero AS 'numeroDaCasa',
		pacientes.*,
		psicologos.*,
		secretarios.*,
		responsaveis.*
FROM pessoas
LEFT JOIN telefones ON (pessoas.fkTelefone = telefones.pkTelefone)
LEFT JOIN enderecos ON (pessoas.fkEndereco = enderecos.pkEndereco)
LEFT JOIN pacientes ON (pessoas.pkPessoa = pacientes.fkPessoa)
LEFT JOIN psicologos ON (pessoas.pkPessoa = psicologos.fkPessoa)
LEFT JOIN secretarios ON (pessoas.pkPessoa = secretarios.fkPessoa)
LEFT JOIN responsaveis ON (pessoas.pkPessoa = responsaveis.fkPessoa)
WHERE pessoas.pkPessoa = _pk;


	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- update de psicologos

DELIMITER $$
CREATE PROCEDURE updatePsicologos(
IN _pk INT,
IN _CRP VARCHAR(20),
IN _nome VARCHAR(100),
IN _email VARCHAR(100),
IN _senha VARCHAR(100),

IN _dataDeNascimento DATE,
IN _RG VARCHAR(20),
IN _CPF VARCHAR(20),
IN _sexo CHAR(1),
IN _imageLocal VARCHAR(255),

IN _rua VARCHAR(100),
IN _numeroDaCasa VARCHAR(10),
IN _complemento VARCHAR(100),
IN _bairro VARCHAR(100),
IN _cep VARCHAR(10),

IN _cidade VARCHAR(100),
IN _estado VARCHAR(50),
IN _ddd VARCHAR(3),
IN _numeroDeTelefone VARCHAR(20)
)
BEGIN

UPDATE psicologos
INNER JOIN pessoas ON (psicologos.fkPessoa = pessoas.pkPessoa)
INNER JOIN telefones ON (pessoas.fkTelefone = telefones.pkTelefone)
INNER JOIN enderecos ON (pessoas.fkEndereco = enderecos.pkEndereco)
SET 	psicologos.CRP = _CRP,
        pessoas.nome = _nome,
        pessoas.email = _email,
        pessoas.senha = _senha,
        pessoas.dataDeNascimento = _dataDeNascimento,
        pessoas.RG = _RG,
        pessoas.CPF = _CPF,
        pessoas.sexo = _sexo,
        pessoas.imageLocal = _imageLocal,
        enderecos.rua = _rua,
        enderecos.numero = _numeroDaCasa,
        enderecos.complemento = _complemento,
        enderecos.bairro = _bairro,
        enderecos.cep = _cep,
        enderecos.cidade = _cidade,
        enderecos.estado = _estado,
        telefones.ddd = _ddd,
        telefones.numero = _numeroDeTelefone
    WHERE psicologos.pkPsicologo = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- update de PacientesEsecretarios

DELIMITER $$
CREATE PROCEDURE updatePacientesAndSecretarios(
IN _pk INT,
IN _nome VARCHAR(100),
IN _email VARCHAR(100),
IN _senha VARCHAR(100),
IN _dataDeNascimento DATE,

IN _RG VARCHAR(20),
IN _CPF VARCHAR(20),
IN _sexo CHAR(1),
IN _imageLocal VARCHAR(255),
IN _rua VARCHAR(100),

IN _numeroDaCasa VARCHAR(10),
IN _complemento VARCHAR(100),
IN _bairro VARCHAR(100),
IN _cep VARCHAR(10),
IN _cidade VARCHAR(100),

IN _estado VARCHAR(50),
IN _ddd VARCHAR(3),
IN _numeroDeTelefone VARCHAR(20)
)
BEGIN

UPDATE pessoas
INNER JOIN telefones ON (pessoas.fkTelefone = telefones.pkTelefone)
INNER JOIN enderecos ON (pessoas.fkEndereco = enderecos.pkEndereco)
SET 	pessoas.nome = _nome,
        pessoas.email = _email,
        pessoas.senha = _senha,
        pessoas.dataDeNascimento = _dataDeNascimento,
        pessoas.RG = _RG,
        pessoas.CPF = _CPF,
        pessoas.sexo = _sexo,
        pessoas.imageLocal = _imageLocal,
        enderecos.rua = _rua,
        enderecos.numero = _numeroDaCasa,
        enderecos.complemento = _complemento,
        enderecos.bairro = _bairro,
        enderecos.cep = _cep,
        enderecos.cidade = _cidade,
        enderecos.estado = _estado,
        telefones.ddd = _ddd,
        telefones.numero = _numeroDeTelefone
    WHERE pessoas.pkPessoa = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

/*
-- procedure para encontra todas atividades de um paciente

DELIMITER $$
CREATE PROCEDURE findAllADataOfPessoaByPk(
	IN _pk INT
)
BEGIN

SELECT 
		pessoas.*,
		telefones.*,
		enderecos.*,
		telefones.numero AS 'numeroDeTelefone',
		enderecos.numero AS 'numeroDaCasa',
		pacientes.*,
		psicologos.*,
		secretarios.*,
		responsaveis.*
FROM pessoas
LEFT JOIN telefones ON (pessoas.fkTelefone = telefones.pkTelefone)
LEFT JOIN enderecos ON (pessoas.fkEndereco = enderecos.pkEndereco)
LEFT JOIN pacientes ON (pessoas.pkPessoa = pacientes.fkPessoa)
LEFT JOIN psicologos ON (pessoas.pkPessoa = psicologos.fkPessoa)
LEFT JOIN secretarios ON (pessoas.pkPessoa = secretarios.fkPessoa)
LEFT JOIN responsaveis ON (pessoas.pkPessoa = responsaveis.fkPessoa)
WHERE pessoas.pkPessoa = _pk;


	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;
*/
-- update de PacientesEsecretarios

DELIMITER $$
CREATE PROCEDURE findAllAtividadesOfPacientes(
IN _pk INT
)
BEGIN

	SELECT * FROM atividadesPacientes
	INNER JOIN atividades ON (atividadespacientes.pkAtividade = atividades.pkAtividade)
	WHERE atividadesPacientes.pkPaciente = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- procedure para encontra todos os pacientes de um psicologo

DELIMITER $$
CREATE PROCEDURE findAllPacientesOfPsicologo(
IN _pk INT
)
BEGIN

	SELECT * FROM pacientes
	INNER JOIN pessoas ON (pacientes.fkPessoa = pessoas.pkPessoa)
	WHERE pacientes.fkPsicologo = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

/*
	teste de atividades inseridas
	call findAllAtividadesOfPacientes(2);
	
	CALL insertAtividades('Cubo Magico', 'Atividade de treinamento coginitivo.');
	CALL insertAtividades('Leitura', 'Atividades de aprimoramento de mémoria.');
	
	CALL insertAtividadesPaciente(3, 2);
	CALL insertAtividadesPaciente(3, 2);
	CALL insertAtividadesPaciente(4, 2);
	CALL insertAtividadesPaciente(4, 1);
	
*/

-- update das anotações do psicolo

DELIMITER $$
CREATE PROCEDURE updateAnotacoesPsicologo(
IN _pk INT,
IN _observacao TEXT,
IN _dia DATE,
IN _pkFlag INT
)
BEGIN

	UPDATE anotacoespsicologos
	SET anotacoespsicologos.fkFlag = _pkFlag,
	anotacoespsicologos.observacao = _observacao,
	anotacoespsicologos.diaDaObservacao = _dia
	WHERE anotacoespsicologos.pkAnotacoesPsicologo = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;

-- update das flags;

DELIMITER $$
CREATE PROCEDURE updateFlags(
IN _pk INT,
IN _color VARCHAR(7),
IN _tituloDaFlag VARCHAR(50),
IN _descricao VARCHAR(120)
)
BEGIN

	UPDATE flags
	SET flags.color = _color,
	flags.tituloDaFlag = _tituloDaFlag,
	flags.descricao = _descricao
	WHERE flags.pkFlag = _pk;
		
	COMMIT;
        ROLLBACK;
END $$
DELIMITER ;


-- update das consultas

DELIMITER $$

CREATE PROCEDURE updateConsultas(
_pkConsulta INT,
_data dateTime
)
BEGIN
	START TRANSACTION;
	UPDATE consultas SET horarioDaConsulta = _data WHERE pkCosulta = _pkConsulta;
	COMMIT;
     ROLLBACK;
END $$
DELIMITER ;

-- pesquisa pacientes usando o like
/*  

	!!!Não tive competencia para essa procedure... @~@
	Vamo para o PHP.

DELIMITER $$

CREATE PROCEDURE findPacienteComLike(
_nome VARCHAR(150)
)
BEGIN
	START TRANSACTION;
	
	SELECT * FROM pacientes
	INNER JOIN pessoas ON (pacientes.fkPessoa = pessoas.pkPessoa)
	WHERE pessoas.nome LIKE "%""_nome""%";
	
	COMMIT;
     ROLLBACK;
END $$
DELIMITER ;

CALL findPacienteComLike("fer");

drop PROCEDURE findPacienteComLike
*/

SELECT * FROM anotacoespacientes;
SELECT * FROM anotacoespsicologos;
SELECT * FROM atividades;
SELECT * FROM atividadespacientes;
SELECT * FROM consultas;
SELECT * FROM enderecos;
SELECT * FROM flags;
SELECT * FROM pacientes;
SELECT * FROM pessoas;
SELECT * FROM psicologos;
SELECT * FROM responsaveis;
SELECT * FROM secretarios;
SELECT * FROM telefones;
SELECT * FROM atividadespacientes;