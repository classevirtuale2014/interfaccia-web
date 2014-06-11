-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Giu 11, 2014 alle 21:55
-- Versione del server: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `loccioniserver`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `infoplants`
--

CREATE TABLE IF NOT EXISTS `infoplants` (
  `IdPlants` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `HumMaxAir` double NOT NULL,
  `HumMinAir` float NOT NULL,
  `HumMaxLand` double NOT NULL,
  `HumMinLand` float NOT NULL,
  `TempMax` double NOT NULL,
  `TempMin` double NOT NULL,
  `Light` double NOT NULL,
  PRIMARY KEY (`IdPlants`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `infoplants`
--

INSERT INTO `infoplants` (`IdPlants`, `Name`, `HumMaxAir`, `HumMinAir`, `HumMaxLand`, `HumMinLand`, `TempMax`, `TempMin`, `Light`) VALUES
(1, 'Margherita', 100, 20, 100, 50, 50, 0, 10);

-- --------------------------------------------------------

--
-- Struttura della tabella `storico`
--

CREATE TABLE IF NOT EXISTS `storico` (
  `IdVase` int(11) NOT NULL,
  `HumAir` double NOT NULL,
  `HumLand` double NOT NULL,
  `Temp` double NOT NULL,
  `Light` double NOT NULL,
  `UpdateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `IdUser` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text NOT NULL,
  `LastName` text NOT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`IdUser`, `Name`, `LastName`) VALUES
(1, 'Dennis', 'Santinelli');

-- --------------------------------------------------------

--
-- Struttura della tabella `uservase`
--

CREATE TABLE IF NOT EXISTS `uservase` (
  `IdVase` int(11) NOT NULL AUTO_INCREMENT,
  `IdUser` int(11) NOT NULL,
  `IdPlant` int(11) NOT NULL,
  `DateTime` datetime NOT NULL,
  PRIMARY KEY (`IdVase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
