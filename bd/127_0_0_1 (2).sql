-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/08/2026 às 03:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bd_carros`
--
CREATE DATABASE IF NOT EXISTS `bd_carros` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_carros`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_carros`
--

CREATE TABLE `tb_carros` (
  `codigo` int(11) NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `montadora` varchar(20) NOT NULL,
  `ano_fabricacao` int(11) NOT NULL,
  `ano_modelo` int(11) NOT NULL,
  `motorizacao` varchar(20) NOT NULL,
  `foto` varchar(150) NOT NULL,
  `cor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_carros`
--

INSERT INTO `tb_carros` (`codigo`, `modelo`, `montadora`, `ano_fabricacao`, `ano_modelo`, `motorizacao`, `foto`, `cor`) VALUES
(1, 'corsa', '', 0, 0, '', '', ''),
(2, 'Fox', 'VolksWagen', 2010, 2010, '1.5', '', 'branco'),
(3, 'Fox', 'VolksWagen', 2010, 2010, '1.5', '', 'branco'),
(4, 'Fox', 'VolksWagen', 2010, 2010, '1.5', '', 'branco'),
(5, 'Fox', 'VolksWagen', 2010, 2010, '1.5', '', 'branco'),
(6, 'Fox', 'VolksWagen', 2010, 2010, '', 'imgsCarros/5c4dbf8f08ce6377bb9dc35ca27bf5ff.jpg', 'branco'),
(7, 'Fox', 'VolksWagen', 2010, 2010, '1.5', 'imgsCarros/0fc42bf1997f1ee72fbc361a799d24a0.jpg', 'branco');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_carros`
--
ALTER TABLE `tb_carros`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_carros`
--
ALTER TABLE `tb_carros`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
