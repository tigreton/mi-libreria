-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-05-2011 a las 20:53:29
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `milibreria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_tbl`
--

CREATE TABLE IF NOT EXISTS `user_tbl` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(20) CHARACTER SET latin1 NOT NULL,
  `Password` varchar(32) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci AUTO_INCREMENT=1 ;
