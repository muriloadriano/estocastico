delete from produtos;
delete from usuarios;

-- Preenche a tabela produtos com alguns dados de exemplo
INSERT INTO produtos (nome, preco, criticidade, estoque, fornecedor) VALUES ('Teclado ABNT2', '23.98', '1', '10', 'Dell');
INSERT INTO produtos (nome, preco, criticidade, estoque, fornecedor) VALUES ('Mouse Optico', '53.00', '1', '10', 'Logitech');

-- Preenche a tabela usuarios com alguns dados de exemplo
INSERT INTO usuarios (nome, dataNascimento, insercao, senha, nomeUsuario, ultimaAtividade) VALUES ('João da Silva', '1985-11-10', DATETIME('NOW'), 'xyz', 'jsilva', DATETIME('NOW'));
INSERT INTO usuarios (nome, dataNascimento, insercao, senha, nomeUsuario, ultimaAtividade) VALUES ('Ana Júlia', '1988-05-03', DATETIME('NOW'), '1234', 'anajulia', DATETIME('NOW'));
