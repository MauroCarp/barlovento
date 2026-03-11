-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-03-2026 a las 18:33:09
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barlovento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

DROP TABLE IF EXISTS `produccion`;
CREATE TABLE IF NOT EXISTS `produccion` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `campania` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Campaña agrícola (ej: 2023/2024)',
  `lote` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Identificación del lote',
  `cultivo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo de cultivo',
  `campo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del campo',
  `etapa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Etapa del cultivo',
  `has` int NOT NULL DEFAULT '0' COMMENT 'Hectáreas',
  `costo` float NOT NULL DEFAULT '0' COMMENT 'Costo total',
  `rinde` float NOT NULL DEFAULT '0' COMMENT 'Rendimiento por hectárea',
  `flete` float NOT NULL DEFAULT '0' COMMENT 'Costo de flete',
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`id`, `campania`, `lote`, `cultivo`, `campo`, `etapa`, `has`, `costo`, `rinde`, `flete`, `created_at`, `updated_at`) VALUES
(6, '2025/2026', 'Lote 7', 'maiz1', 'EL PICHI', 'gruesa', 15, 160.03, 112.41, 0, '2026-03-11 16:13:03', '2026-03-11 16:13:03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
