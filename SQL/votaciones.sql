-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2024 a las 18:31:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `votacionesbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `candidatos`
--

CREATE TABLE `candidatos` (
  `Rut` varchar(12) NOT NULL,
  `Nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `candidatos`
--

INSERT INTO `candidatos` (`Rut`, `Nombre`) VALUES
('17.572.223-1', 'Manuel Rosales'),
('18.756.743-K', 'Jazmine Gatica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunas`
--

CREATE TABLE `comunas` (
  `ID` int(11) NOT NULL,
  `Region` varchar(50) NOT NULL,
  `Comuna` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comunas`
--

INSERT INTO `comunas` (`ID`, `Region`, `Comuna`) VALUES
(1, 'Valparaiso', 'Villa Alemana'),
(2, 'Valparaiso', 'Quilpue'),
(3, 'Metropolitana', 'Huechuraba'),
(4, 'Metropolitana', 'Renca');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `region`
--

CREATE TABLE `region` (
  `Region` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `region`
--

INSERT INTO `region` (`Region`) VALUES
('Metropolitana'),
('Valparaiso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votantes`
--

CREATE TABLE `votantes` (
  `Rut` varchar(12) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Alias` varchar(100) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Region` varchar(50) NOT NULL,
  `Comuna` varchar(50) NOT NULL,
  `Web` varchar(5) NOT NULL,
  `Amigo` varchar(5) NOT NULL,
  `Redes` varchar(5) NOT NULL,
  `TV` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `ID` int(11) NOT NULL,
  `Rut_Votante` varchar(12) NOT NULL,
  `Rut_Candidato` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `candidatos`
--
ALTER TABLE `candidatos`
  ADD PRIMARY KEY (`Rut`);

--
-- Indices de la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Region` (`Region`);

--
-- Indices de la tabla `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`Region`);

--
-- Indices de la tabla `votantes`
--
ALTER TABLE `votantes`
  ADD PRIMARY KEY (`Rut`);

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Rut_Candidato` (`Rut_Candidato`),
  ADD KEY `Rut_Votante` (`Rut_Votante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comunas`
--
ALTER TABLE `comunas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comunas`
--
ALTER TABLE `comunas`
  ADD CONSTRAINT `comunas_ibfk_1` FOREIGN KEY (`Region`) REFERENCES `region` (`Region`);

--
-- Filtros para la tabla `votos`
--
ALTER TABLE `votos`
  ADD CONSTRAINT `votos_ibfk_1` FOREIGN KEY (`Rut_Candidato`) REFERENCES `candidatos` (`Rut`),
  ADD CONSTRAINT `votos_ibfk_2` FOREIGN KEY (`Rut_Votante`) REFERENCES `votantes` (`Rut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
