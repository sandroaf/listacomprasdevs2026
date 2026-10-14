-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 14/10/2026 às 19:54
-- Versão do servidor: 8.4.11-0ubuntu0.26.04.1
-- Versão do PHP: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `listadecompras`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `items`
--

CREATE TABLE `items` (
  `codigo` int NOT NULL COMMENT 'Código do Item',
  `descricao` varchar(100) NOT NULL COMMENT 'Descrição (nome) do item na lista',
  `quantidade` decimal(12,2) DEFAULT NULL,
  `datahora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo_lista` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista`
--

CREATE TABLE `lista` (
  `codigo` int NOT NULL COMMENT 'Código da Lista de Compra',
  `nome` varchar(100) NOT NULL COMMENT 'Nome da Lista de Compras'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `lista`
--

INSERT INTO `lista` (`codigo`, `nome`) VALUES
(1, 'Casa'),
(2, 'Trabalho'),
(3, 'Viagem');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`codigo`);

--
-- Índices de tabela `lista`
--
ALTER TABLE `lista`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `nome_lista` (`nome`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `items`
--
ALTER TABLE `items`
  MODIFY `codigo` int NOT NULL AUTO_INCREMENT COMMENT 'Código do Item';

--
-- AUTO_INCREMENT de tabela `lista`
--
ALTER TABLE `lista`
  MODIFY `codigo` int NOT NULL AUTO_INCREMENT COMMENT 'Código da Lista de Compra', AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
