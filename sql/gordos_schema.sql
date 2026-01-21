-- Schema de tablas para Panel Gordos
-- Base de datos: MySQL (InnoDB)

-- Tabla: gordosResumen
CREATE TABLE IF NOT EXISTS `gordosResumen` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `mes` VARCHAR(10) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `kg` VARCHAR(50) NOT NULL,
  `cantidad` INT UNSIGNED NOT NULL DEFAULT 0,
  `posicion` INT UNSIGNED NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gr_fecha` (`fecha`),
  KEY `idx_gr_mes_tipo` (`mes`, `tipo`),
  KEY `idx_gr_cat_kg` (`categoria`, `kg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla: gordos
CREATE TABLE IF NOT EXISTS `gordos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `mes` VARCHAR(10) NOT NULL,
  `oferta` INT UNSIGNED NOT NULL DEFAULT 0,
  `demanda` INT UNSIGNED NOT NULL DEFAULT 0,
  `tipo` VARCHAR(20) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gd_fecha` (`fecha`),
  KEY `idx_gd_mes_tipo` (`mes`, `tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
