-- Criação do banco
CREATE DATABASE IF NOT EXISTS livraria;
USE livraria;

-- Tabela autor
CREATE TABLE IF NOT EXISTS autor (
  codigo INT(5) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  pais VARCHAR(10) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Tabela categoria
CREATE TABLE IF NOT EXISTS categoria (
  codigo INT(5) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Tabela editora
CREATE TABLE IF NOT EXISTS editora (
  codigo INT(5) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- Tabela livro
CREATE TABLE IF NOT EXISTS livro (
  codigo INT(5) NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  nrpaginas INT(4) NOT NULL,
  ano INT(4) NOT NULL,
  codautor INT(5) NOT NULL,
  codcategoria INT(5) NOT NULL,
  codeditora INT(5) NOT NULL,
  resenha TEXT NOT NULL,
  preco FLOAT(6,2) NOT NULL,
  fotocapa1 VARCHAR(100) NOT NULL,
  fotocapa2 VARCHAR(105) NOT NULL,
  PRIMARY KEY (codigo),
  KEY codautor (codautor),
  KEY codcategoria (codcategoria),
  KEY codeditora (codeditora),
  CONSTRAINT livro_ibfk_1 FOREIGN KEY (codautor) REFERENCES autor (codigo),
  CONSTRAINT livro_ibfk_2 FOREIGN KEY (codcategoria) REFERENCES categoria (codigo),
  CONSTRAINT livro_ibfk_3 FOREIGN KEY (codeditora) REFERENCES editora (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
