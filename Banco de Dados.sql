-- ============================================
-- Banco de dados: TramandaAI
-- Tabelas: usuario, artigo, fale_conosco
-- ============================================

CREATE DATABASE IF NOT EXISTS TramandaAI;

USE TramandaAI;

-- ============================================
-- Tabela: usuario
-- ============================================
CREATE TABLE usuario (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nome    VARCHAR(100) NOT NULL,
    email   VARCHAR(150) NOT NULL UNIQUE,
    senha   VARCHAR(255) NOT NULL
);

-- ============================================
-- Tabela: artigo
-- Cada artigo pertence a um usuario (id_usuario)
-- ============================================
CREATE TABLE artigo (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    titulo           VARCHAR(200) NOT NULL,
    dataPublicacao   DATE NOT NULL,
    descricao        TEXT,
    img              VARCHAR(255),
    link             VARCHAR(255),
    id_usuario       INT NOT NULL,

    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

-- ============================================
-- Tabela: fale_conosco
-- ============================================
CREATE TABLE fale_conosco (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    comentario VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    nota  TEXT NOT NULL
);

