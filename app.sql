-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 12-12-2021 a las 21:10:54
-- Versión del servidor: 10.3.31-MariaDB-cll-lve
-- Versión de PHP: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blanquer_app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(3) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `especialidad` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anotaciones`
--

CREATE TABLE `anotaciones` (
  `id_anotacion` int(12) NOT NULL,
  `id_paciente` int(9) NOT NULL,
  `id_administrador` int(3) NOT NULL,
  `anotacion` longtext NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(50) NOT NULL,
  `peso` varchar(25) NOT NULL,
  `kg_perdidos` varchar(25) NOT NULL,
  `regla` varchar(25) NOT NULL,
  `ropa` varchar(250) NOT NULL,
  `banyo` varchar(250) NOT NULL,
  `tratamiento` longtext NOT NULL,
  `salud` longtext NOT NULL,
  `animos` longtext NOT NULL,
  `acontecimientos` longtext NOT NULL,
  `tratamiento_dado` longtext NOT NULL,
  `dieta` longtext NOT NULL,
  `nutricion` int(1) NOT NULL DEFAULT 0 COMMENT '0 no es una anotación de nutrición 1 si lo es ',
  `antecedentes` longtext NOT NULL,
  `motivo_consulta` longtext NOT NULL,
  `situacion_actual` longtext NOT NULL,
  `psicologia` int(1) NOT NULL DEFAULT 0 COMMENT '0 no es una anotación de psicologia 1 si lo es',
  `antecedentes_podologicos` longtext NOT NULL,
  `medicacion` longtext NOT NULL,
  `alergias` longtext NOT NULL,
  `seguimiento` longtext NOT NULL,
  `podologia` int(1) DEFAULT NULL COMMENT '0 no es una anotación de podología 1 si lo es'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(12) NOT NULL,
  `id_administrador` int(3) NOT NULL,
  `id_paciente` int(9) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(11) NOT NULL,
  `DNI` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Apellidos` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `NumExpe` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `FechaNacimiento` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Edad` int(11) NOT NULL,
  `Email` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Provincia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Poblacion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `calle` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `codpostal` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Observaciones` varchar(1000) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horas_disponibles`
--

CREATE TABLE `horas_disponibles` (
  `id` int(12) NOT NULL,
  `id_administrador` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(50) NOT NULL,
  `hora_inicio` varchar(50) NOT NULL,
  `hora_final` varchar(50) NOT NULL,
  `hora_inicio2` varchar(50) NOT NULL,
  `hora_final2` varchar(50) NOT NULL,
  `estado` int(1) NOT NULL COMMENT '0 libre 1 ocupada',
  `sesiones` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(9) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellidos` varchar(250) NOT NULL,
  `nif` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` int(1) NOT NULL DEFAULT 0 COMMENT '0 hombre 1 mujer',
  `observaciones` longtext NOT NULL,
  `telefono_fijo` int(9) DEFAULT NULL,
  `telefono_movil` int(9) DEFAULT NULL,
  `telefono_movil2` int(9) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `direccion` varchar(500) NOT NULL,
  `localidad` varchar(500) NOT NULL,
  `provincia` varchar(500) NOT NULL,
  `cp` int(5) NOT NULL DEFAULT 0,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `rgpd_firmado` int(1) NOT NULL COMMENT '0 no 1 si',
  `url_rgpd` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  ADD PRIMARY KEY (`id_anotacion`),
  ADD KEY `id_administrador` (`id_administrador`),
  ADD KEY `id_cliente` (`id_paciente`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_administrador` (`id_administrador`),
  ADD KEY `id_paciente` (`id_paciente`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `horas_disponibles`
--
ALTER TABLE `horas_disponibles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  MODIFY `id_anotacion` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horas_disponibles`
--
ALTER TABLE `horas_disponibles`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anotaciones`
--
ALTER TABLE `anotaciones`
  ADD CONSTRAINT `anotaciones_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administradores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `anotaciones_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administradores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
