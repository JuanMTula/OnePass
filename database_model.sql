-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `OnePassDB` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `OnePassDB`;

CREATE TABLE `claves` (
  `claves_id` int(11) NOT NULL AUTO_INCREMENT,
  `claves_contid` int(11) NOT NULL,
  `claves_titulo` longtext NOT NULL,
  `claves_texto` longtext,
  `claves_tipo` longtext,
  `claves_url` longtext,
  `claves_tel` longtext,
  `claves_cuenta` longtext,
  `claves_clave` longtext,
  PRIMARY KEY (`claves_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


CREATE TABLE `content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_usr_id` int(11) NOT NULL,
  `content_label` text NOT NULL,
  `content_icono` varchar(2) NOT NULL,
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


CREATE TABLE `usuarios` (
  `usr_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_nombre` text NOT NULL,
  `usr_mail` text NOT NULL,
  `usr_clave` text NOT NULL,
  PRIMARY KEY (`usr_id`),
  UNIQUE KEY `usr_mail` (`usr_mail`(70))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;


-- 2019-10-25 15:05:08