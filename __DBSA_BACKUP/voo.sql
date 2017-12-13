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
-- Estrutura da tabela `voo`
--

CREATE TABLE `voo` (
  `idvoo` int(11) NOT NULL,
  `voo_status` enum('0','1') NOT NULL,
  `data_do_voo` date NOT NULL,
  `numero_voo` int(11) NOT NULL,
  `idaeronave` int(11) NOT NULL,
  `comandante` varchar(40) NOT NULL,
  `copiloto` varchar(40) NOT NULL,
  `topD` varchar(40) NOT NULL,
  `topE` varchar(40) NOT NULL,
  `natureza` varchar(80) NOT NULL,
  `partida` time NOT NULL,
  `corte` time NOT NULL,
  `ciclo` float NOT NULL,
  `tempo_total_de_voo` int(11) NOT NULL,
  `total_de_pousos` int(11) NOT NULL,
  `combustivel_total_consumido` varchar(10) NOT NULL,
  `historico` text NOT NULL,
  `ocorrencia` text NOT NULL,
  `discrepancia` text NOT NULL,
  `relprev` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `voo`
--

INSERT INTO `voo` (`idvoo`, `voo_status`, `data_do_voo`, `numero_voo`, `idaeronave`, `comandante`, `copiloto`, `topD`, `topE`, `natureza`, `partida`, `corte`, `ciclo`, `tempo_total_de_voo`, `total_de_pousos`, `combustivel_total_consumido`, `historico`, `ocorrencia`, `discrepancia`, `relprev`) VALUES
(175, '0', '2017-12-08', 4488, 1, 'Pinheiro', 'Laura', 'Erick', 'Freitas', 'I3 - Instrução revisória/Experiência Recente', '10:18:00', '11:02:00', 0, 44, 2, '70', 'dflkmcsam', '', '', ''),
(176, '0', '2017-11-11', 1, 1, 'Caus', 'Laura', 'Erick', 'Erick', 'A1 - Abastecimento', '00:00:00', '00:00:00', 0, 2, 120, '20', 'fdgsdg', 'sdfgsdg', 'dghjfgjh', 'fhgkjhfjk'),
(177, '0', '1999-11-11', 1, 1, 'Caus', 'Laura', 'Erick', 'Andrade', 'A2 - Traslado', '00:00:00', '00:00:00', 0, 250, 5, '45', 'ffffffffffffffff', 'gggggggggggggg', 'eeeeeeeeeeeeeee', 'qqqqqqqqqqq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `voo`
--
ALTER TABLE `voo`
  ADD PRIMARY KEY (`idvoo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `voo`
--
ALTER TABLE `voo`
  MODIFY `idvoo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
