-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/08/2026 às 02:59
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
(6, 'Fox', 'VolksWagen', 2010, 2010, '', 'imgsCarros/5c4dbf8f08ce6377bb9dc35ca27bf5ff.jpg', 'branco'),
(7, 'Fox', 'VolksWagen', 2010, 2010, '1.5', 'imgsCarros/0fc42bf1997f1ee72fbc361a799d24a0.jpg', 'branco'),
(8, 'Ford', 'Escort', 1995, 1996, '1.6', 'imgsCarros/8da33203be3451908da846afbb020aa9.jpg', 'vermelho'),
(9, 'HR-V', 'Honda', 2018, 2019, '1.8', 'imgsCarros/06320877d345c1896f24dc145e1c43d9.jpg', 'prata'),
(10, 'City', 'Honda', 2021, 2022, '1.5', 'imgsCarros/cedc1e7c6a95efc07828ea563b730aa5.jpg', 'azul'),
(11, 'Tracker', 'Chevrolet', 2026, 2027, '1.0 Turbo', 'imgsCarros/4eca6e647dc2a5e964d8faf76735e229.jpg', 'preto'),
(12, 'Eclipse', 'Mitsubish', 2026, 2027, '1.5 turbo', 'imgsCarros/53aef3de242e7f321e03a080aae77e3c.jpg', 'branco'),
(13, '450H', 'Lexus', 2026, 2027, '2.0 turbo', 'imgsCarros/3515e2f24fbb3a36d0565b2cd711db0e.jpg', 'prata'),
(14, 'ES500e', 'Lexus', 2026, 2027, '2.0', 'imgsCarros/37ee416cbf0530a9907cbb00574d1380.jpg', 'bronze'),
(15, 'ES 500', 'Lexus', 2026, 2027, '2.0 turbo', 'imgsCarros/f59980e37c75f65d9dcb089adf48d85b.jpg', 'branco');

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
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
