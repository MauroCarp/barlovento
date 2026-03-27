-- phpMyAdmin SQL Dump
-- Tabla: contratosproduccion
-- Creado: 26-03-2026
-- Base de datos: barloventoofi

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
-- Estructura de tabla para la tabla `contratosproduccion`
--

DROP TABLE IF EXISTS `contratosproduccion`;
CREATE TABLE IF NOT EXISTS `contratosproduccion` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `campania` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Campaña agrícola (ej: 2023/2024)',
  `cultivo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Tipo de cultivo contractado',
  `fecha` date NOT NULL COMMENT 'Fecha del contrato',
  `precio` int NOT NULL DEFAULT '0' COMMENT 'Precio por unidad',
  `kilos` int NOT NULL DEFAULT '0' COMMENT 'Cantidad de kilos contractados',
  `corredor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del corredor',
  `comprador` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nombre del comprador',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_campania` (`campania`),
  KEY `idx_cultivo` (`cultivo`),
  KEY `idx_fecha` (`fecha`),
  KEY `idx_corredor` (`corredor`),
  KEY `idx_comprador` (`comprador`),
  KEY `idx_campania_cultivo` (`campania`,`cultivo`),
  KEY `idx_fecha_cultivo` (`fecha`,`cultivo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contratos de producción agrícola';

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;