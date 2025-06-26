CREATE DATABASE IF NOT EXISTS biblioteca_db;
USE biblioteca_db;

CREATE TABLE IF NOT EXISTS autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    nacionalidade VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    isbn VARCHAR(20) UNIQUE NOT NULL,
    ano_publicacao INT,
    genero VARCHAR(100),
    autor_id INT,
    FOREIGN KEY (autor_id) REFERENCES autores(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL, -- Armazenará o hash da senha
    tipo_usuario ENUM(\'membro\', \'bibliotecario\', \'admin\') DEFAULT \'membro\',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados mínimos para demonstração do CRUD
INSERT INTO autores (nome, sobrenome, nacionalidade) VALUES
(\'Machado\', \'de Assis\', \'Brasileira\'),
(\'Clarice\', \'Lispector\', \'Brasileira\'),
(\'Gabriel\', \'García Márquez\', \'Colombiana\');

INSERT INTO livros (titulo, isbn, ano_publicacao, genero, autor_id) VALUES
(\'Dom Casmurro\', \'978-85-8070-001-1\', 1899, \'Romance\', 1),
(\'Memórias Póstumas de Brás Cubas\', \'978-85-8070-002-8\', 1881, \'Romance\', 1),
(\'A Hora da Estrela\', \'978-85-325-1000-0\', 1977, \'Romance\', 2),
(\'Cem Anos de Solidão\', \'978-85-01-01200-0\', 1967, \'Realismo Mágico\', 3);

-- Inserção de um usuário admin padrão (senha: admin123)
-- A senha \'admin123\' será hashed usando password_hash() no PHP. Aqui, um hash de exemplo.
-- Você deve gerar o hash real no PHP e substituir este valor.
-- Para gerar o hash, você pode usar um script PHP simples:
-- <?php echo password_hash(\'admin123\', PASSWORD_DEFAULT); ?>
INSERT INTO usuarios (nome_usuario, email, senha, tipo_usuario) VALUES (
    \'admin\', 
    \'admin@biblioteca.com\', 
    \'$2y$10$e.g.somerandomhashhere.somerandomhashhere.somerandomhashhere\', 
    \'admin\'
);


