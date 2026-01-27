CREATE TABLE IF NOT EXISTS `gordosresumenmensual` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mes` DATE NOT NULL,
  `tipo` VARCHAR(50) NOT NULL,
  `feedlot_novillos` INT UNSIGNED NOT NULL DEFAULT 0,
  `campo_vaquillona` INT UNSIGNED NOT NULL DEFAULT 0,
  `hotel` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `idx_mes_tipo` (`mes`, `tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;