-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-03-2026 a las 02:01:00
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barloventoofi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

DROP TABLE IF EXISTS `produccion`;
CREATE TABLE IF NOT EXISTS `produccion` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `campania` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Campaña agrícola (ej: 2023/2024)',
  `lote` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identificación del lote',
  `cultivo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo de cultivo',
  `campo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del campo',
  `etapa` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Etapa del cultivo',
  `has` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Hectáreas',
  `costo` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Costo total',
  `kg` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'Kilogramos producidos',
  `rinde` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Rendimiento por hectárea',
  `flete` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Costo de flete',
  `cargado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de carga del registro',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_campania` (`campania`),
  KEY `idx_lote` (`lote`),
  KEY `idx_cultivo` (`cultivo`),
  KEY `idx_campo` (`campo`),
  KEY `idx_etapa` (`etapa`),
  KEY `idx_campania_cultivo` (`campania`,`cultivo`),
  KEY `idx_campo_lote` (`campo`,`lote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
