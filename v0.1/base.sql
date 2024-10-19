-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-10-2024 a las 05:24:33
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
-- Base de datos: `jdmallau_almacen`
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `a`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `a`;
CREATE TABLE IF NOT EXISTS `a` (
`id` int unsigned
,`nombres` varchar(50)
,`apellidos` varchar(50)
,`numero_de_guia` varchar(50)
,`cuadrilla` varchar(100)
,`fecha` date
,`cantidad` varchar(100)
,`unidad` varchar(50)
,`descripcion` varchar(255)
,`asignacion` varchar(20)
,`codigo` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actasconsumido`
--

DROP TABLE IF EXISTS `actasconsumido`;
CREATE TABLE IF NOT EXISTS `actasconsumido` (
  `fecha` date NOT NULL,
  `numeroacta` varchar(80) NOT NULL,
  `cuadrilla` varchar(11) NOT NULL,
  `tecnico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `material` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad` float NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

DROP TABLE IF EXISTS `administradores`;
CREATE TABLE IF NOT EXISTS `administradores` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasea` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `intentos_fallidos` int NOT NULL DEFAULT '0',
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_intento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombres`, `apellidos`, `correo`, `contrasea`, `rol`, `intentos_fallidos`, `bloqueado`, `ultimo_intento`) VALUES
(1, 'persona', 'ficticia', 'correo@ejemplo.com', 'password', 'administrador', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE IF NOT EXISTS `asistencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `asistencias` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucion`
--

DROP TABLE IF EXISTS `devolucion`;
CREATE TABLE IF NOT EXISTS `devolucion` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `numero_de_guia` varchar(20) NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` varchar(100) DEFAULT NULL,
  `unidad` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `asignacion` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_ont`
--

DROP TABLE IF EXISTS `entrada_ont`;
CREATE TABLE IF NOT EXISTS `entrada_ont` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ctn` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prod` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mac` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sn` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_ont`
--

DROP TABLE IF EXISTS `entrega_ont`;
CREATE TABLE IF NOT EXISTS `entrega_ont` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ctn` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prod` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mac` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sn` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `cuadrilla` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tecnico1` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tecnico2` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

DROP TABLE IF EXISTS `herramientas`;
CREATE TABLE IF NOT EXISTS `herramientas` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_de_guia` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cuadrilla` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unidad` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `asignacion` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_asignaciones`
--

DROP TABLE IF EXISTS `lista_asignaciones`;
CREATE TABLE IF NOT EXISTS `lista_asignaciones` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `material` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lista_asignaciones`
--

INSERT INTO `lista_asignaciones` (`Id`, `codigo`, `material`) VALUES
(1, '0001', 'ejemplo 1'),
(2, '0002', 'ejemplo 2'),
(3, '0003', 'ejemplo 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

DROP TABLE IF EXISTS `materiales`;
CREATE TABLE IF NOT EXISTS `materiales` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_de_guia` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cuadrilla` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unidad` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `asignacion` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codigo` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla`
--

DROP TABLE IF EXISTS `tabla`;
CREATE TABLE IF NOT EXISTS `tabla` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_de_guia` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` float DEFAULT NULL,
  `unidad` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `provedor` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

DROP TABLE IF EXISTS `trabajadores`;
CREATE TABLE IF NOT EXISTS `trabajadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `documento` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores_reporte`
--

DROP TABLE IF EXISTS `trabajadores_reporte`;
CREATE TABLE IF NOT EXISTS `trabajadores_reporte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `documento` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nombres` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `estado` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` longblob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uniforme`
--

DROP TABLE IF EXISTS `uniforme`;
CREATE TABLE IF NOT EXISTS `uniforme` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `numero_de_guia` varchar(50) NOT NULL,
  `cuadrilla` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad` varchar(100) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `asignacion` varchar(50) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `documento` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nombres` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `foto` longblob,
  `rol` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `intentos_fallidos` int NOT NULL DEFAULT '0',
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `ultimo_intento` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ED_user` (`nombres`,`apellidos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `a`
--
DROP TABLE IF EXISTS `a`;

DROP VIEW IF EXISTS `a`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `a`  AS SELECT `materiales`.`id` AS `id`, `materiales`.`nombres` AS `nombres`, `materiales`.`apellidos` AS `apellidos`, `materiales`.`numero_de_guia` AS `numero_de_guia`, `materiales`.`cuadrilla` AS `cuadrilla`, `materiales`.`fecha` AS `fecha`, `materiales`.`cantidad` AS `cantidad`, `materiales`.`unidad` AS `unidad`, `materiales`.`descripcion` AS `descripcion`, `materiales`.`asignacion` AS `asignacion`, `materiales`.`codigo` AS `codigo` FROM `materiales` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
