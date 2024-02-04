-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: mysql.twi.com.br:3306
-- Tempo de Geração: 06/10/2022 às 12:17:00
-- Versão do Servidor: 5.6.49-log
-- Versão do PHP: 7.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `pibemaprgovbr`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_admin`
--

CREATE TABLE IF NOT EXISTS `cl_admin` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(25) NOT NULL,
  `senha` varchar(25) NOT NULL,
  `cad_user` tinyint(1) NOT NULL,
  `gerar` tinyint(1) NOT NULL,
  `responder` tinyint(1) NOT NULL,
  `relatorio` tinyint(1) NOT NULL,
  `nome` varchar(25) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_criterio`
--

CREATE TABLE IF NOT EXISTS `cl_criterio` (
  `cod_criterio` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cod_sub_rotina` int(11) NOT NULL,
  `descricao` mediumtext NOT NULL,
  PRIMARY KEY (`cod_criterio`),
  KEY `cod_sub_rotina` (`fk_cod_sub_rotina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=341 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_img`
--

CREATE TABLE IF NOT EXISTS `cl_img` (
  `cod_img` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cod_preenchimento` int(11) NOT NULL,
  `img` varchar(150) NOT NULL,
  PRIMARY KEY (`cod_img`),
  KEY `fk_cod_preenchimento` (`fk_cod_preenchimento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_preencher`
--

CREATE TABLE IF NOT EXISTS `cl_preencher` (
  `cod_preenchimento` int(11) NOT NULL AUTO_INCREMENT,
  `data_preenchimento` date NOT NULL,
  `cod_rotina` int(11) NOT NULL,
  `cod_sub_rotina` int(11) NOT NULL,
  `cod_criterio` int(11) NOT NULL,
  `cod_sub_criterio` int(11) NOT NULL,
  `resposta` varchar(2) NOT NULL,
  `obs` longtext NOT NULL,
  PRIMARY KEY (`cod_preenchimento`),
  KEY `fk_cod_rotina` (`cod_rotina`),
  KEY `fk_cod_sub_rotina` (`cod_sub_rotina`),
  KEY `fk_cod_criterio` (`cod_criterio`),
  KEY `fk_cod_sub_criterio` (`cod_sub_criterio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_rotina`
--

CREATE TABLE IF NOT EXISTS `cl_rotina` (
  `cod_rotina` int(11) NOT NULL AUTO_INCREMENT,
  `nome_rotina` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_rotina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_sub_criterio`
--

CREATE TABLE IF NOT EXISTS `cl_sub_criterio` (
  `cod_sub_criterio` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cod_criterio` int(11) NOT NULL,
  `descricao_criterio` mediumtext NOT NULL,
  PRIMARY KEY (`cod_sub_criterio`),
  KEY `fk_cod_criterio` (`fk_cod_criterio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cl_sub_rotina`
--

CREATE TABLE IF NOT EXISTS `cl_sub_rotina` (
  `cod_sub_rotina` int(11) NOT NULL AUTO_INCREMENT,
  `fk_cod_rotina` int(11) NOT NULL,
  `nome_sub_rotina` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_sub_rotina`),
  KEY `cod_rotina` (`fk_cod_rotina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `cl_criterio`
--
ALTER TABLE `cl_criterio`
  ADD CONSTRAINT `cl_criterio_ibfk_1` FOREIGN KEY (`fk_cod_sub_rotina`) REFERENCES `cl_sub_rotina` (`cod_sub_rotina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `cl_img`
--
ALTER TABLE `cl_img`
  ADD CONSTRAINT `cl_img_ibfk_1` FOREIGN KEY (`fk_cod_preenchimento`) REFERENCES `cl_preencher` (`cod_preenchimento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `cl_preencher`
--
ALTER TABLE `cl_preencher`
  ADD CONSTRAINT `cl_preencher_ibfk_1` FOREIGN KEY (`cod_rotina`) REFERENCES `cl_rotina` (`cod_rotina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cl_preencher_ibfk_2` FOREIGN KEY (`cod_sub_rotina`) REFERENCES `cl_sub_rotina` (`cod_sub_rotina`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cl_preencher_ibfk_3` FOREIGN KEY (`cod_criterio`) REFERENCES `cl_criterio` (`cod_criterio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `cl_sub_criterio`
--
ALTER TABLE `cl_sub_criterio`
  ADD CONSTRAINT `cl_sub_criterio_ibfk_1` FOREIGN KEY (`fk_cod_criterio`) REFERENCES `cl_criterio` (`cod_criterio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `cl_sub_rotina`
--
ALTER TABLE `cl_sub_rotina`
  ADD CONSTRAINT `cl_sub_rotina_ibfk_1` FOREIGN KEY (`fk_cod_rotina`) REFERENCES `cl_rotina` (`cod_rotina`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
