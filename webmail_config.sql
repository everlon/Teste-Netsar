-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 03/06/2013 às 14:40:23
-- Versão do Servidor: 5.5.31
-- Versão do PHP: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `netsar_teste`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `webmail_config`
--

CREATE TABLE IF NOT EXISTS `webmail_config` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `imap` varchar(255) NOT NULL,
  `imap_port` int(12) NOT NULL,
  `imap_protocol` varchar(255) NOT NULL,
  `smtp` varchar(255) NOT NULL,
  `smtp_port` int(12) NOT NULL,
  `smtp_protocol` varchar(255) NOT NULL,
  `smtp_auth` int(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `executed` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `webmail_config`
--

INSERT INTO `webmail_config` (`id`, `user`, `domain`, `imap`, `imap_port`, `imap_protocol`, `smtp`, `smtp_port`, `smtp_protocol`, `smtp_auth`, `password`, `executed`) VALUES
(2, 'marcelo', 'netsar.com.br', 'imap.gmail.com', 993, 'ssl', 'smtp.gmail.com', 587, 'SSL', 1, '12345678', '2013-06-02 00:00:00'),
(5, 'treinamento', 'netsar.com.br', 'imap.gmail.com', 993, 'ssl', 'smtp.gmail.com', 587, 'NO', 1, 'treinamento1', '0000-00-00 00:00:00'),
(6, 'treinamento', 'netsar.com.br', 'imap.gmail.com', 993, 'ssl', 'smtp.gmail.com', 587, 'NO', 1, 'treinamento1', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
