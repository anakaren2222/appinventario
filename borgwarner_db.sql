-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 23:07:23
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
-- Base de datos: `borgwarner_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idInventario` int(50) NOT NULL,
  `Cantidad` int(50) NOT NULL,
  `No_Parte_id` int(255) NOT NULL,
  `Costo` double NOT NULL,
  `Ubicacion` varchar(50) NOT NULL,
  `Linea` varchar(50) NOT NULL,
  `Responsable` varchar(45) NOT NULL,
  `Descripcion` varchar(45) NOT NULL,
  `CostoTotal` float NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `CreateDate` datetime DEFAULT current_timestamp(),
  `UpdateDate` datetime DEFAULT NULL,
  `DeleteDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idInventario`, `Cantidad`, `No_Parte_id`, `Costo`, `Ubicacion`, `Linea`, `Responsable`, `Descripcion`, `CostoTotal`, `Status`, `CreateDate`, `UpdateDate`, `DeleteDate`) VALUES
(1, 4, 1, 2.52, 'asda', 'asdasd', 'ada', 'asdad', 10.08, 0, '2024-06-27 11:47:15', '2024-06-27 12:20:09', '2024-06-27 12:26:31'),
(2, 3, 2, 2.68, 'asda', 'asdasd', 'ada', 'asdad', 8.04, 0, '2024-06-27 11:59:53', NULL, '2024-06-27 12:28:07'),
(3, 16, 2, 2.52, 'asdasd', 'asdasd', 'dasdas', 'dasda', 40.32, 0, '2024-06-27 12:25:22', '2024-06-27 12:25:29', '2024-06-27 12:28:09'),
(4, 5, 2, 2.52, 'asdasd', 'asdasd', 'dasdas', 'dasda', 12.6, 1, '2024-06-27 12:29:46', '2024-06-27 12:29:58', NULL),
(5, 34, 2, 2.68, 'asdasd', 'asdasd', 'dasdas', 'dasda', 91.12, 1, '2024-06-27 12:38:28', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nopartes`
--

CREATE TABLE `nopartes` (
  `idParte` int(255) NOT NULL,
  `Codigo` bigint(255) NOT NULL,
  `Costo` float NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `createDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nopartes`
--

INSERT INTO `nopartes` (`idParte`, `Codigo`, `Costo`, `status`, `createDate`) VALUES
(1, 28641941, 3.96, 1, '2024-06-27 00:00:00'),
(2, 345, 1.65, 1, '2024-06-27 00:00:00'),
(3, 345345, 1.52, 1, '2024-06-27 13:47:14'),
(4, 123, 123, 1, '2024-06-27 14:35:51'),
(5, 123, 50, 1, '2024-06-27 14:38:14'),
(6, 123, 40, 1, '2024-06-27 14:48:19');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `No_Parte_id` (`No_Parte_id`);

--
-- Indices de la tabla `nopartes`
--
ALTER TABLE `nopartes`
  ADD PRIMARY KEY (`idParte`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idInventario` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `nopartes`
--
ALTER TABLE `nopartes`
  MODIFY `idParte` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`No_Parte_id`) REFERENCES `nopartes` (`idParte`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
