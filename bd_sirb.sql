DROP TABLE IF EXISTS agendamentos;
DROP TABLE IF EXISTS horarios_bloqueados;
DROP TABLE IF EXISTS barbeiros;
DROP TABLE IF EXISTS itens;
DROP TABLE IF EXISTS usuarios;

-- =========================
-- Tabela de usuários
-- =========================

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  perfil ENUM('cliente','barbeiro','admin') NOT NULL DEFAULT 'cliente',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- Tabela de serviços
-- =========================

CREATE TABLE itens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(120) NOT NULL,
  descricao TEXT NULL,
  preco DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- Tabela de barbeiros
-- =========================

CREATE TABLE barbeiros (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  ativo TINYINT(1) DEFAULT 1,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

-- =========================
-- Tabela de agendamentos
-- =========================

CREATE TABLE agendamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  item_id INT NOT NULL,
  barbeiro_id INT NOT NULL,
  data DATE NOT NULL,
  hora TIME NOT NULL,
  status ENUM('agendado','cancelado','finalizado') DEFAULT 'agendado',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY (item_id) REFERENCES itens(id),
  FOREIGN KEY (barbeiro_id) REFERENCES barbeiros(id)
) ENGINE=InnoDB;

-- =========================
-- Horários bloqueados
-- =========================

CREATE TABLE horarios_bloqueados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  barbeiro_id INT NOT NULL,
  data DATE NOT NULL,
  hora TIME NOT NULL,
  FOREIGN KEY (barbeiro_id) REFERENCES barbeiros(id)
) ENGINE=InnoDB;

-- =========================
-- Usuários iniciais
-- =========================

-- Admin
INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES
('Administrador', 'admin@sirb.local', '$2y$10$1k9iQdrx6V9QfXQ0v9dx2e9b9dQZbYJ4q6k9gVqQHzzcB3nB1n5wK', 'admin');

-- Barbeiro
INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES
('João Barbeiro', 'barbeiro@sirb.local', '$2y$10$1k9iQdrx6V9QfXQ0v9dx2e9b9dQZbYJ4q6k9gVqQHzzcB3nB1n5wK', 'barbeiro');

-- Cliente exemplo
INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES
('Cliente Teste', 'cliente@sirb.local', '$2y$10$1k9iQdrx6V9QfXQ0v9dx2e9b9dQZbYJ4q6k9gVqQHzzcB3nB1n5wK', 'cliente');

-- =========================
-- Serviços da barbearia
-- =========================

INSERT INTO itens (nome, descricao, preco, ativo) VALUES
('Corte Masculino', 'Corte tradicional ou moderno.', 35.00, 1),
('Barba', 'Modelagem e acabamento da barba.', 25.00, 1),
('Corte + Barba', 'Combo corte e barba.', 55.00, 1);

-- =========================
-- Registrar barbeiro
-- =========================

INSERT INTO barbeiros (usuario_id) VALUES (2);