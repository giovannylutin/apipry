-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 27-09-2021 a las 16:30:07
-- Versión del servidor: 10.3.31-MariaDB
-- Versión de PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agentepr_Quejas_Diaco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_quejas`
--

CREATE TABLE `tb_quejas` (
  `ID_QUEJA` int(11) NOT NULL,
  `ID_DEP` int(11) DEFAULT NULL,
  `ID_MUN` int(11) DEFAULT NULL,
  `ESTADO` varchar(20) DEFAULT NULL,
  `TIPO` varchar(20) DEFAULT NULL,
  `QUEJA_CONSULTA` varchar(10) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla padre que recive las quejas';

--
-- Volcado de datos para la tabla `tb_quejas`
--

INSERT INTO `tb_quejas` (`ID_QUEJA`, `ID_DEP`, `ID_MUN`, `ESTADO`, `TIPO`, `QUEJA_CONSULTA`, `FECHA_ALTA`, `FECHA_ACTUALIZA`) VALUES
(1, 1, 1, 'recibido', 'Queja no anonima', 'Bx0F2G0921', '2021-09-04 17:37:48', '2021-09-04 17:37:48'),
(2, 1, 1, 'recibido', 'Queja anonima', 'AB9Msw0921', '2021-09-04 17:57:28', '2021-09-04 17:57:28'),
(3, 1, 1, 'recibido', 'Queja no anonima', 'Bzl8vn0821', '2021-09-04 18:07:10', '2021-09-04 18:07:10'),
(4, 1, 1, 'recibido', 'Queja no anonima', 'BhIj7c0921', '2021-09-04 20:16:58', '2021-09-04 20:16:58'),
(5, 1, 1, 'recibido', 'Queja no anonima', 'BVOC8U0921', '2021-09-04 20:17:33', '2021-09-04 20:17:33'),
(6, 1, 1, 'recibido', 'Queja no anonima', 'BFu8pi0921', '2021-09-04 20:19:17', '2021-09-04 20:19:17'),
(7, 1, 1, 'recibido', 'Queja no anonima', 'BUukyF0921', '2021-09-04 20:20:26', '2021-09-04 20:20:26'),
(9, 1, 1, 'recibido', 'Queja anonima', 'AY1dhB0921', '2021-09-04 20:30:27', '2021-09-04 20:30:27'),
(10, 1, 1, 'recibido', 'Queja no anonima', 'BBVrwI0921', '2021-09-04 20:33:33', '2021-09-04 20:33:33'),
(11, 1, 2, 'recibido', 'Queja anonima', 'As9X1v0921', '2021-09-05 21:32:43', '2021-09-05 21:32:43'),
(12, 2, 3, 'recibido', 'Queja anonima', 'AKe8tE0921', '2021-09-10 23:03:34', '2021-09-10 23:03:34'),
(13, 1, 1, 'recibido', 'Queja anonima', 'AeCKbJ0921', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(14, 1, 1, 'recibido', 'Queja anonima', 'Ap4UmK0921', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(15, 2, 3, 'recibido', 'Queja anonima', 'Atqv5f0921', '2021-09-12 16:36:31', '2021-09-12 16:36:31'),
(21, 1, 1, 'recibido', 'Queja anonima', 'Actv2X0921', '2021-09-15 17:05:31', '2021-09-15 17:05:31'),
(25, 1, 2, 'recibido', 'Queja anonima', 'AIT3lo0921', '2021-09-19 16:45:31', '2021-09-19 16:45:31'),
(26, 1, 2, 'recibido', 'Queja anonima', 'AUl0u50921', '2021-09-19 17:41:01', '2021-09-19 17:41:01'),
(37, 1, 1, 'enproceso', 'Queja anonima', 'Aais9Z0921', '2021-09-19 18:11:10', '2021-09-27 14:30:47'),
(38, 1, 1, 'enproceso', 'Queja no anonima', 'BiGVqU0921', '2021-09-22 18:50:47', '2021-09-22 18:50:47'),
(39, 2, 3, 'rechazado', 'Queja anonima', 'AHvXRz0921', '2021-09-23 20:09:48', '2021-09-23 20:09:48'),
(40, 2, 3, 'recibido', 'Queja no anonima', 'BF1vm70921', '2021-09-23 20:33:11', '2021-09-23 20:33:11'),
(41, 1, 1, 'recibido', 'Queja anonima', 'AgfKOF0921', '2021-09-26 23:19:51', '2021-09-26 23:19:51'),
(42, 1, 1, 'finalizado', 'Queja anonima', 'ARvszV0921', '2021-09-26 23:22:58', '2021-09-26 23:31:26'),
(43, 1, 2, 'recibido', 'Queja anonima', 'AkNZEM0921', '2021-09-26 23:24:53', '2021-09-26 23:24:53'),
(44, 2, 3, 'recibido', 'Queja anonima', 'AHLJqT0921', '2021-09-27 00:13:19', '2021-09-27 00:13:19'),
(45, 1, 1, 'finalizado', 'Queja anonima', 'AyugPF0921', '2021-09-27 00:20:18', '2021-09-27 08:40:16'),
(46, 1, 2, 'recibido', 'Queja anonima', 'AgeWOn0921', '2021-09-27 10:19:44', '2021-09-27 10:19:44'),
(47, 2, 3, 'recibido', 'Queja anonima', 'AJWLNy0921', '2021-09-27 14:36:38', '2021-09-27 14:36:38'),
(48, 2, 3, 'recibido', 'Queja anonima', 'Ao1UG20921', '2021-09-27 14:42:47', '2021-09-27 14:42:47'),
(49, 2, 3, 'recibido', 'Queja anonima', 'AuiN9S0921', '2021-09-27 14:45:09', '2021-09-27 14:45:09'),
(50, 2, 3, 'recibido', 'Queja anonima', 'AdvYlA0921', '2021-09-27 14:47:42', '2021-09-27 14:47:42'),
(51, 1, 2, 'recibido', 'Queja anonima', 'AiT9680921', '2021-09-27 14:50:54', '2021-09-27 14:50:54'),
(52, 2, 3, 'recibido', 'Queja anonima', 'AQiMLb0921', '2021-09-27 14:53:20', '2021-09-27 14:53:20'),
(53, 2, 3, 'recibido', 'Queja anonima', 'AcZ4hA0921', '2021-09-27 14:57:40', '2021-09-27 14:57:40'),
(54, 2, 3, 'recibido', 'Queja anonima', 'Aols9A0921', '2021-09-27 15:02:37', '2021-09-27 15:02:37'),
(55, 2, 3, 'recibido', 'Queja anonima', 'AL2xOW0921', '2021-09-27 15:04:47', '2021-09-27 15:04:47'),
(56, 2, 3, 'recibido', 'Queja anonima', 'AX0ouI0921', '2021-09-27 15:08:09', '2021-09-27 15:08:09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  ADD PRIMARY KEY (`ID_QUEJA`),
  ADD KEY `FK_REFERENCE_4` (`ID_DEP`),
  ADD KEY `FK_REFERENCE_5` (`ID_MUN`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  MODIFY `ID_QUEJA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  ADD CONSTRAINT `FK_REFERENCE_4` FOREIGN KEY (`ID_DEP`) REFERENCES `tb_departamento` (`ID_DEP`),
  ADD CONSTRAINT `FK_REFERENCE_5` FOREIGN KEY (`ID_MUN`) REFERENCES `tb_municipio` (`ID_MUN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
