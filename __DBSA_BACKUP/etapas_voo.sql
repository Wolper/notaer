-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 13-Dez-2017 às 11:08
-- Versão do servidor: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manotaer`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapas_voo`
--

CREATE TABLE `etapas_voo` (
  `idvoo` int(11) NOT NULL,
  `origem` varchar(40) NOT NULL,
  `destino` varchar(40) NOT NULL,
  `partida` time NOT NULL,
  `decolagem` time NOT NULL,
  `pouso` time NOT NULL,
  `corte` time NOT NULL,
  `ng` float NOT NULL,
  `ntl` float NOT NULL,
  `diu` float NOT NULL,
  `not` float NOT NULL,
  `qtepouso` int(11) NOT NULL,
  `combustivel_consumido` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `etapas_voo`
--

INSERT INTO `etapas_voo` (`idvoo`, `origem`, `destino`, `partida`, `decolagem`, `pouso`, `corte`, `ng`, `ntl`, `diu`, `not`, `qtepouso`, `combustivel_consumido`) VALUES
(173, 'Rio de Janeiro', 'são paulo', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '30'),
(173, 'Vitória', '	vila velha', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '15'),
(174, 'Vitória', 'Vila Velha', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '11'),
(174, 'Vila Velha', 'Vitória', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '22'),
(175, 'Vila Velha', 's maria de jetiba', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '40'),
(175, 'santa maria', 'sihc', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, 0, '30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `etapas_voo`
--
ALTER TABLE `etapas_voo`
  ADD KEY `fk_voo` (`idvoo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
