﻿# Host: localhost  (Version: 5.6.17)
# Date: 2014-12-22 04:51:24
# Generator: MySQL-Front 5.2  (Build 5.106)

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;

DROP DATABASE IF EXISTS `cantina`;
CREATE DATABASE `cantina` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `cantina`;

#
# Source for table "cliente"
#

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tel` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# Source for table "cliente_credito"
#

DROP TABLE IF EXISTS `cliente_credito`;
CREATE TABLE `cliente_credito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `valor` double(7,2) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL COMMENT 'C = Credito(+), D = Debito(-)',
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# Source for table "produto"
#

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `preco` double(7,2) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# Source for table "venda"
#

DROP TABLE IF EXISTS `venda`;
CREATE TABLE `venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `cliente_nome` varchar(100) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `valor` double(7,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

#
# Source for table "venda_produto"
#

DROP TABLE IF EXISTS `venda_produto`;
CREATE TABLE `venda_produto` (
  `id_venda` int(11) NOT NULL DEFAULT '0',
  `produto_id` int(11) NOT NULL DEFAULT '0',
  `produto_qnt` int(11) NOT NULL DEFAULT '0',
  `produto_preco` double(7,2) DEFAULT NULL,
  PRIMARY KEY (`id_venda`,`produto_id`,`produto_qnt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `cantina`.`cliente_credito`
  ADD COLUMN `id_venda` int(11) NOT NULL DEFAULT '0';

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
