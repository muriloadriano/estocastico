-- Cria as tabelas de banco de dados necessárias para a aplicação
-- De acordo com a Fig. A1 do Apêndice A do documento de projeto

CREATE TABLE produtos 
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	nome VARCHAR(250) NOT NULL,
	preco NUMBER,
	criticidade INTEGER,
	estoque INTEGER NOT NULL,
	fornecedor VARCHAR(250)	
);

CREATE INDEX "idproduto" ON "produtos" ("id");

CREATE TABLE usuarios
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	nome VARCHAR(250) NOT NULL,
	dataNascimento DATE,
	insercao DATETIME NOT NULL,
	ultimaAltenticacao DATETIME,
	senha VARCHAR(50),
	nomeUsuario VARCHAR(100)
);

CREATE INDEX "idusuario" ON "usuarios" ("id");
