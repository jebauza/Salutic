-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para salutic
CREATE DATABASE IF NOT EXISTS `salutic` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `salutic`;

-- Volcando estructura para tabla salutic.centro
CREATE TABLE IF NOT EXISTS `centro` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(200) NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  `IDZONA` bigint(20) NOT NULL,
  `CODIGO` varchar(15) NOT NULL,
  `LATENCIASEGURIDAD` int(10) unsigned NOT NULL,
  `LOGO` varchar(300) DEFAULT NULL,
  `GMT` decimal(14,2) NOT NULL,
  `URLMapa` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `UNICA_CODIGO` (`CODIGO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla salutic.centro: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `centro` DISABLE KEYS */;
REPLACE INTO `centro` (`ID`, `NOMBRE`, `ACTIVO`, `IDZONA`, `CODIGO`, `LATENCIASEGURIDAD`, `LOGO`, `GMT`, `URLMapa`) VALUES
	(1, 'Centro Sur', 1, 1, 'CENSUR', 0, NULL, 2.00, NULL),
	(2, 'Centro Norte', 1, 1, 'CENNOR', 0, NULL, 1.00, NULL),
	(3, 'Centro Este', 0, 1, 'CENEST', 0, NULL, 1.00, NULL),
	(4, 'Centro Oeste', 1, 2, 'CENOEST', 0, NULL, 1.00, NULL);
/*!40000 ALTER TABLE `centro` ENABLE KEYS */;

-- Volcando estructura para tabla salutic.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla salutic.migrations: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_resets_table', 1),
	(2, '2022_03_21_183728_create_usuario_and_centro_tables', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla salutic.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla salutic.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla salutic.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `EMAIL` varchar(100) NOT NULL,
  `NOMBRE` varchar(100) NOT NULL,
  `APELLIDO1` varchar(100) NOT NULL,
  `APELLIDO2` varchar(100) NOT NULL,
  `TELEFONO1` varchar(100) NOT NULL,
  `TELEFONO2` varchar(100) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ACTIVO` tinyint(1) NOT NULL,
  `PASSWORD2` varchar(255) DEFAULT NULL,
  `PASSWORD3` varchar(255) DEFAULT NULL,
  `PASSWORD4` varchar(255) DEFAULT NULL,
  `PASSWORD5` varchar(255) DEFAULT NULL,
  `INDEXPASSWORD` int(11) NOT NULL,
  `FECHAMODIFICACIONPASSWORD` datetime NOT NULL,
  `NUMERO_INTENTOS` int(11) NOT NULL,
  `FECHAHORA_OPERACION` datetime DEFAULT NULL,
  `CODIGO_OPERACION` bigint(20) DEFAULT NULL,
  `IDIDIOMA` bigint(20) NOT NULL DEFAULT '1',
  `NUEVO` tinyint(1) NOT NULL,
  `IDCENTRO` bigint(20) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `IDCENTRO` (`IDCENTRO`),
  CONSTRAINT `FK_USUARIOS_CENTRO` FOREIGN KEY (`IDCENTRO`) REFERENCES `centro` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla salutic.usuario: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
REPLACE INTO `usuario` (`ID`, `EMAIL`, `NOMBRE`, `APELLIDO1`, `APELLIDO2`, `TELEFONO1`, `TELEFONO2`, `PASSWORD`, `ACTIVO`, `PASSWORD2`, `PASSWORD3`, `PASSWORD4`, `PASSWORD5`, `INDEXPASSWORD`, `FECHAMODIFICACIONPASSWORD`, `NUMERO_INTENTOS`, `FECHAHORA_OPERACION`, `CODIGO_OPERACION`, `IDIDIOMA`, `NUEVO`, `IDCENTRO`) VALUES
	(2, 'sara.manzano@orquestasoluciones.es', 'Sara', 'Manzano', 'Perez', '900675400', '626489874', '1234', 1, NULL, NULL, NULL, NULL, 1, '2018-03-08 10:13:27', 0, '2018-03-08 10:13:32', NULL, 1, 0, 1),
	(3, 'magracia@orquestasoluciones.es', 'MªÁngeles', 'Gracia', 'Campos', '952782091', '687543908', '789456', 1, NULL, NULL, NULL, NULL, 1, '2018-03-08 12:19:17', 0, '2018-03-08 12:19:17', NULL, 1, 0, 1),
	(7, 'prueb115@gmail.com', 'Merkasi', 'Prueba', 'Prueba', '622783646', '622783646', '$2y$10$uIDuK3r9ut8SHe2p7VgUc.J.lbRd.mHu1jPyFLKfPPVtlzf8NjcZK', 1, NULL, NULL, NULL, NULL, 1, '2022-03-23 00:23:07', 0, NULL, NULL, 1, 1, 1),
	(8, 'prueb118@gmail.com', 'Poli', 'Prueba', 'Prueba', '622783646', '622783646', '$2y$10$8CHXEtdSRLthulxPpNw/fuy00mLR6uiiVVGYJ6vW1KXTJMnZR.yIy', 1, NULL, NULL, NULL, NULL, 1, '2022-03-23 00:25:53', 0, NULL, NULL, 1, 1, 1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
