-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/09/2026 às 03:18
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
(6, 'Fox', 'VolksWagen', 2010, 2010, '', 'imgsCarros/5c4dbf8f08ce6377bb9dc35ca27bf5ff.png', 'branco'),
(7, 'Fox', 'VolksWagen', 2010, 2010, '1.5', 'imgsCarros/0fc42bf1997f1ee72fbc361a799d24a0.png', 'branco'),
(8, 'Ford', 'Escort', 1995, 1996, '1.6', 'imgsCarros/8da33203be3451908da846afbb020aa9.png', 'vermelho'),
(9, 'HR-V', 'Honda', 2018, 2019, '1.8', 'imgsCarros/06320877d345c1896f24dc145e1c43d9.png', 'prata'),
(10, 'City', 'Honda', 2021, 2022, '1.5', 'imgsCarros/cedc1e7c6a95efc07828ea563b730aa5.png', 'azul'),
(11, 'Tracker', 'Chevrolet', 2026, 2027, '1.0 Turbo', 'imgsCarros/4eca6e647dc2a5e964d8faf76735e229.png', 'preto'),
(12, 'Eclipse', 'Mitsubish', 2026, 2027, '1.5 turbo', 'imgsCarros/53aef3de242e7f321e03a080aae77e3c.jpg', 'branco'),
(13, '450H', 'Lexus', 2026, 2027, '2.0 turbo', 'imgsCarros/3515e2f24fbb3a36d0565b2cd711db0e.png', 'prata'),
(14, 'ES500e', 'Lexus', 2026, 2027, '2.0', 'imgsCarros/37ee416cbf0530a9907cbb00574d1380.jpg', 'bronze'),
(15, 'ES 500', 'Lexus', 2026, 2027, '2.0 turbo', 'imgsCarros/f59980e37c75f65d9dcb089adf48d85b.jpg', 'branco'),
(16, 'opala', 'chevrolet', 1989, 1989, '2.0', 'imgsCarros/bed98468898ea28ee01fd22133f6b6b8.png', 'verde'),
(17, 'opala', 'chevrolet', 1989, 1989, '2.0', 'imgsCarros/e33c4a66c247e2be9503b5dfe9360831.png', 'verde'),
(18, 'Fastback 1.0 Impetus', 'Fiat', 2022, 2022, '1.0 turbo', 'imgsCarros/e59a3c034c101768a9293972ea0d20b2.jpg', 'prata'),
(19, 'spark uv', 'chevrolet', 2026, 2027, '75 kw', 'imgsCarros/d2cd3b645d45c153be86a687a9c53ffe.jpg', 'azul'),
(20, 'Kait', 'Nissan', 2026, 2027, '1.0 turbo', 'imgsCarros/5c864b883c852ae4a13f98faf757d097.jpg', 'vermelho'),
(21, 'Qashqai', 'Nissan', 2026, 2026, '1.5 turbo', 'imgsCarros/53327e1ceec4c3a19622eaf07d236ada.jpg', 'vermelho'),
(22, 'Territory', 'Ford', 2026, 2027, '1.5 turbo', 'imgsCarros/fc148fe50822c6c9588d048d68521133.png', 'verde'),
(23, 'Sonata', 'Hyundai', 2025, 2026, '2.0 turbo', 'imgsCarros/e6737e6b83f357bc082cad4b3041fe76.jpg', 'prata'),
(24, 'hb20', 'Hyundai', 2015, 2015, '1.0', 'imgsCarros/e2225e6871b0b9cddac80cf7be7b483f.png', 'prata'),
(25, 'creta', 'Hyundai', 2028, 2028, '1.0 turbo', 'imgsCarros/0946971635722b96d7f0ce083e9bbbdb.jpg', 'azul'),
(26, 'renegade', 'jeep', 2020, 2020, '1.3 turbo', 'imgsCarros/5921742e8ea9d7b0794fc63ec9f789fc.jpg', 'vermelho'),
(27, 'compass', 'jeep', 2021, 2021, '1.5 turbo', 'imgsCarros/27d15628e07ac67900131a631df8ef37.jpg', 'preto'),
(28, 'opala', 'chevrolet', 1988, 1989, '2.0', 'imgsCarros/a20a4cdc7ca91ec5eaa45a56952bdddc.jpg', 'verde');

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
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
