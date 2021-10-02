-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-09-2021 a las 20:49:59
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`agentepr`@`localhost` PROCEDURE `Proc_Alta_Quejas` (IN `departamento` INT, IN `municipio` INT, IN `Estado` VARCHAR(20), IN `Tipo` VARCHAR(20), IN `tkconsulta` VARCHAR(10), IN `Q1nombre` VARCHAR(80), IN `Q1cui` INT, IN `Q1telefono` VARCHAR(9), IN `Q1celular` VARCHAR(9), IN `Q1correo` VARCHAR(50), IN `Q1direccion` VARCHAR(50), IN `Q2nit` INT, IN `Q2direccion` VARCHAR(50), IN `Q2zona` INT, IN `Q2telefono` VARCHAR(9), IN `Q2Correo` VARCHAR(50), IN `Q3factura` INT, IN `Q3fechaemitida` DATE, IN `Q3queja` TINYTEXT, IN `Q3requiere` TINYTEXT, OUT `ejecucion` INT)  BEGIN	
    DECLARE QUEJA_iD int;
    DECLARE QU_nocambios boolean DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET QU_nocambios = 1;   

		START TRANSACTION;
        INSERT INTO tb_quejas(ID_DEP, ID_MUN, ESTADO, TIPO, QUEJA_CONSULTA, FECHA_ALTA, FECHA_ACTUALIZA) VALUES (departamento,municipio,Estado,Tipo,tkconsulta,now(),now());
        SET QUEJA_iD = LAST_INSERT_ID();
        INSERT INTO tb_quejas_personas(ID_QUEJA, NOM_COMPLETO, CUI, TELEFONO, CELULAR, CORREO, DIRECCION, FECHA_ALTA, FECHA_ACTUALIZA) VALUES (QUEJA_iD,Q1nombre,Q1cui,Q1telefono,Q1celular,Q1correo,Q1direccion,now(),now());
INSERT INTO tb_quejas_proveedor(ID_QUEJA, NIT, DIRECCION, ZONA, TELEFONO, CORREO, FECHA_ALTA, FECHA_ACTUALIZA) VALUES (QUEJA_iD,Q2nit,Q2direccion,Q2zona,Q2telefono,Q2Correo,now(),now());
INSERT INTO tb_quejas_detalle(ID_QUEJA, NOFACTURA, FECHA_EMISION, QUEJA, REQUEIRE,FECHA_ALTA, FECHA__ACTUALIZA) VALUES (QUEJA_iD,Q3factura,Q3fechaemitida,Q3queja,Q3requiere,now(),now());
IF QU_nocambios THEN
        	SET ejecucion = 0;
        	ROLLBACK;
         ELSE
        	SET ejecucion = 1;
        	COMMIT;
         END IF;
END$$

CREATE DEFINER=`agentepr`@`localhost` PROCEDURE `Proc_dash_totales` (OUT `Tdia` INT, OUT `Tmes` INT, OUT `Tdiaantes` INT, OUT `Tanual` INT)  BEGIN

SELECT count(*) into Tdia FROM `tb_quejas` WHERE DAY (`tb_quejas`.`FECHA_ALTA`) = DAY(CURDATE());

SELECT count(*) into Tmes FROM `tb_quejas` WHERE MONTH (`tb_quejas`.`FECHA_ALTA`) = MONTH(CURDATE());

SELECT count(*) into Tdiaantes FROM `tb_quejas` WHERE DAY (`tb_quejas`.`FECHA_ALTA`) = DAY(CURDATE()-1);

SELECT count(*) into Tanual FROM `tb_quejas` WHERE year (`tb_quejas`.`FECHA_ALTA`) = year(CURDATE());
END$$

CREATE DEFINER=`agentepr`@`localhost` PROCEDURE `proc_resumensemana` ()  BEGIN
select COUNT(*),dayOFWEEK(FECHA_ALTA),FECHA_ALTA from tb_quejas where WEEKOFYEAR(FECHA_ALTA)=WEEKOFYEAR(now()) GROUP BY DAYOFWEEK(FECHA_ALTA);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_bitacora_quejas`
--

CREATE TABLE `tb_bitacora_quejas` (
  `ID_BITACORA` int(11) NOT NULL,
  `USUARIO` varchar(50) DEFAULT NULL,
  `TABLA` varchar(60) DEFAULT NULL,
  `DATO_ANTERIOR` varchar(100) DEFAULT NULL,
  `DATO_NUEVO` varchar(100) DEFAULT NULL,
  `FECHA_ACTUALIZADO` datetime DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_departamento`
--

CREATE TABLE `tb_departamento` (
  `ID_DEP` int(11) NOT NULL,
  `ID_REGION` int(11) DEFAULT NULL,
  `DEPARTAMENTO` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='tabla catalogo departamentos de guatemala';

--
-- Volcado de datos para la tabla `tb_departamento`
--

INSERT INTO `tb_departamento` (`ID_DEP`, `ID_REGION`, `DEPARTAMENTO`) VALUES
(1, 1, 'Guatemala'),
(2, 2, 'Coban'),
(3, 4, 'Huehuetenango'),
(4, 4, 'Quiché'),
(5, 3, 'Quetzaltenango'),
(6, 3, 'San Marcos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_diaco_sucursal`
--

CREATE TABLE `tb_diaco_sucursal` (
  `ID_SUC` int(11) NOT NULL,
  `ID_REGION` int(11) DEFAULT NULL,
  `ID_USER` int(11) DEFAULT NULL,
  `SUCURSAL` varchar(15) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_diaco_usuarios`
--

CREATE TABLE `tb_diaco_usuarios` (
  `ID_USER` int(11) NOT NULL,
  `USUARIO` varchar(50) DEFAULT NULL,
  `PASS` varchar(80) DEFAULT NULL,
  `ROL` varchar(15) DEFAULT NULL,
  `TOK` varchar(10) DEFAULT NULL,
  `ESTADO` varchar(10) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_diaco_usuarios`
--

INSERT INTO `tb_diaco_usuarios` (`ID_USER`, `USUARIO`, `PASS`, `ROL`, `TOK`, `ESTADO`, `FECHA_ALTA`, `FECHA_ACTUALIZA`) VALUES
(1, 'agiovannylutin@gmail.com', '76acf372a56513410216105e06476c5ac928a62f', 'administrador', 'abc1245ppu', 'activo', '2021-09-11 16:08:59', '2021-09-11 16:08:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_municipio`
--

CREATE TABLE `tb_municipio` (
  `ID_MUN` int(11) NOT NULL,
  `ID_DEP` int(11) DEFAULT NULL,
  `MUNICIPIO` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='tabla que hace referencia a los muncipios en el cual se encu';

--
-- Volcado de datos para la tabla `tb_municipio`
--

INSERT INTO `tb_municipio` (`ID_MUN`, `ID_DEP`, `MUNICIPIO`) VALUES
(1, 1, 'San José Pinula'),
(2, 1, 'Fraijanes'),
(3, 2, 'Alta verapaz');

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
(2, 1, 1, 'recibido', 'Queja', 'AB9Msw0921', '2021-09-04 17:57:28', '2021-09-04 17:57:28'),
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
(37, 1, 1, 'Recibido', 'Queja anonima', 'Aais9Z0921', '2021-09-19 18:11:10', '2021-09-19 18:11:10'),
(38, 1, 1, 'enproceso', 'Queja no anonima', 'BiGVqU0921', '2021-09-22 18:50:47', '2021-09-22 18:50:47'),
(39, 2, 3, 'rechazado', 'Queja anonima', 'AHvXRz0921', '2021-09-23 20:09:48', '2021-09-23 20:09:48'),
(40, 2, 3, 'recibido', 'Queja no anonima', 'BF1vm70921', '2021-09-23 20:33:11', '2021-09-23 20:33:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_quejas_detalle`
--

CREATE TABLE `tb_quejas_detalle` (
  `ID_DETALLEQ` int(11) NOT NULL,
  `ID_QUEJA` int(11) DEFAULT NULL,
  `NOFACTURA` int(11) DEFAULT NULL,
  `FECHA_EMISION` date DEFAULT NULL,
  `QUEJA` tinytext DEFAULT NULL,
  `REQUEIRE` tinytext DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA__ACTUALIZA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla hija de la tbla quejas ';

--
-- Volcado de datos para la tabla `tb_quejas_detalle`
--

INSERT INTO `tb_quejas_detalle` (`ID_DETALLEQ`, `ID_QUEJA`, `NOFACTURA`, `FECHA_EMISION`, `QUEJA`, `REQUEIRE`, `FECHA_ALTA`, `FECHA__ACTUALIZA`) VALUES
(1, 2, 457812, '2021-08-31', 'se me cobro de mas en la compra teniendo promoción ', 'que se proceda a la devolución del dinero extra', '2021-09-04 17:57:28', '2021-09-04 17:57:28'),
(2, 3, 454512, '2021-08-09', 'no se sabe', 'no se sabe', '2021-09-04 18:07:10', '2021-09-04 18:07:10'),
(3, 4, 0, '2021-08-09', 'j', 'j', '2021-09-04 20:16:58', '2021-09-04 20:16:58'),
(4, 5, 0, '2021-09-04', 'j', 'j', '2021-09-04 20:17:33', '2021-09-04 20:17:33'),
(5, 6, NULL, '2021-09-04', 'j', 'j', '2021-09-04 20:19:17', '2021-09-04 20:19:17'),
(6, 7, 45, '2021-09-04', 'j', 'j', '2021-09-04 20:20:26', '2021-09-04 20:20:26'),
(8, 9, 45, '2021-09-04', 'hola', 'hola', '2021-09-04 20:30:27', '2021-09-04 20:30:27'),
(9, 10, 7878, '2021-09-02', 'kkkkk', 'kkkkkk', '2021-09-04 20:33:33', '2021-09-04 20:33:33'),
(10, 11, 4545121, '2021-09-05', 'test de nuestra app', 'nada', '2021-09-05 21:32:43', '2021-09-05 21:32:43'),
(11, 12, 787888, '2021-09-10', 'tets', 'test', '2021-09-10 23:03:34', '2021-09-10 23:03:34'),
(12, 13, 7845126, '2021-09-10', 'test para cuando tenga muchos datos', 'nada', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(13, 14, 7845126, '2021-09-10', 'test para cuando tenga muchos datos', 'nada', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(14, 15, 1122334, '2021-09-06', 'test', 'test', '2021-09-12 16:36:31', '2021-09-12 16:36:31'),
(20, 21, 454545, '2021-09-15', 'test', '', '2021-09-15 17:05:31', '2021-09-15 17:05:31'),
(24, 25, 7845451, '2021-09-19', 'test', 'test', '2021-09-19 16:45:31', '2021-09-19 16:45:31'),
(25, 26, 7845451, '2021-09-17', 'test', NULL, '2021-09-19 17:41:01', '2021-09-19 17:41:01'),
(36, 37, 7845451, '2021-09-17', 'tt', 'tt', '2021-09-19 18:11:10', '2021-09-19 18:11:10'),
(37, 38, 455455, '2021-09-22', 'pruebas para los demás formularios y estadísticas semanales', 'nada solo es una prueba', '2021-09-22 18:50:47', '2021-09-22 18:50:47'),
(38, 39, 7845451, '2021-09-23', 'esta es una queja de prueba antes de entregar', 'nada ', '2021-09-23 20:09:48', '2021-09-23 20:09:48'),
(39, 40, 1122331, '2021-09-21', 'esta es una prueba para validar funcionamiento', 'esta es una pruebapara validar funcionamiento ', '2021-09-23 20:33:11', '2021-09-23 20:33:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_quejas_empresas`
--

CREATE TABLE `tb_quejas_empresas` (
  `NIT` int(11) NOT NULL,
  `EMPRESA` varchar(50) DEFAULT NULL,
  `FECHA__ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZADO` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_quejas_empresas`
--

INSERT INTO `tb_quejas_empresas` (`NIT`, `EMPRESA`, `FECHA__ALTA`, `FECHA_ACTUALIZADO`) VALUES
(1122333, 'test', '2021-09-19 18:11:10', '2021-09-19 18:11:10'),
(7845129, 'Pollo Campero S.A.', '2021-09-04 17:32:50', '2021-09-04 17:32:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_quejas_personas`
--

CREATE TABLE `tb_quejas_personas` (
  `ID_PERSONAQ` int(11) NOT NULL,
  `ID_QUEJA` int(11) DEFAULT NULL,
  `NOM_COMPLETO` varchar(80) DEFAULT NULL,
  `CUI` bigint(11) DEFAULT NULL,
  `TELEFONO` varchar(9) DEFAULT NULL,
  `CELULAR` varchar(9) DEFAULT NULL,
  `CORREO` varchar(50) DEFAULT NULL,
  `DIRECCION` varchar(50) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='tabla hija que recive datos personales solo si el cliente lo';

--
-- Volcado de datos para la tabla `tb_quejas_personas`
--

INSERT INTO `tb_quejas_personas` (`ID_PERSONAQ`, `ID_QUEJA`, `NOM_COMPLETO`, `CUI`, `TELEFONO`, `CELULAR`, `CORREO`, `DIRECCION`, `FECHA_ALTA`, `FECHA_ACTUALIZA`) VALUES
(1, 1, 'Giovanny', 2557737490103, '45454545', '12121212', 'agio@gmail.com', '5av 3-19 san José Pinula', '2021-09-04 17:37:48', '2021-09-04 17:37:48'),
(2, 2, 'Giovanny', 2147483647, '45454545', '78787878', 'agio@gmail.com', '5av 3-29 zona2', '2021-09-04 17:57:28', '2021-09-04 17:57:28'),
(3, 3, 'adam', 2147483647, '42668998', '', 'agio@hotmail.com', '5avenida 3-29 zona2', '2021-09-04 18:07:10', '2021-09-04 18:07:10'),
(4, 4, 'adam giovanny', 45454, '42668998', '4545', 'h@gmail.com', '', '2021-09-04 20:16:58', '2021-09-04 20:16:58'),
(5, 5, 'adam giovanny', 45454, '42668998', '4545', 'h@gmail.com', '', '2021-09-04 20:17:33', '2021-09-04 20:17:33'),
(6, 6, 'adam giovanny', 45454, '42668998', '4545', 'h@gmail.com', '', '2021-09-04 20:19:17', '2021-09-04 20:19:17'),
(7, 7, 'adam giovanny', 45454, '42668998', '4545', 'h@gmail.com', '', '2021-09-04 20:20:26', '2021-09-04 20:20:26'),
(9, 9, '', 0, '', '', '', '', '2021-09-04 20:30:27', '2021-09-04 20:30:27'),
(10, 10, 'adam giovanny', 78789564, '42668998', '45451233', 'pollos@outlook.com', '', '2021-09-04 20:33:33', '2021-09-04 20:33:33'),
(11, 11, '', 0, '', '', '', '', '2021-09-05 21:32:43', '2021-09-05 21:32:43'),
(12, 12, '', 0, '', '', '', '', '2021-09-10 23:03:34', '2021-09-10 23:03:34'),
(13, 13, '', 0, '', '', '', '', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(14, 14, '', 0, '', '', '', '', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(15, 15, '', 0, '', '', '', '', '2021-09-12 16:36:31', '2021-09-12 16:36:31'),
(21, 21, '', 0, '', '', '', '', '2021-09-15 17:05:31', '2021-09-15 17:05:31'),
(25, 25, '', 0, '', '', '', '', '2021-09-19 16:45:31', '2021-09-19 16:45:31'),
(26, 26, '', 0, '', '', '', '', '2021-09-19 17:41:01', '2021-09-19 17:41:01'),
(37, 37, '', 0, '', '', '', '', '2021-09-19 18:11:10', '2021-09-19 18:11:10'),
(38, 38, 'adam giovanny', 2147483647, '42668998', '42668998', '', '', '2021-09-22 18:50:47', '2021-09-22 18:50:47'),
(39, 39, '', 0, '', '', '', '', '2021-09-23 20:09:48', '2021-09-23 20:09:48'),
(40, 40, 'Henrry test', 2147483647, '47293845', '45454545', 'test@gmail.com', '', '2021-09-23 20:33:11', '2021-09-23 20:33:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_quejas_proveedor`
--

CREATE TABLE `tb_quejas_proveedor` (
  `ID_PROVEEDORQ` int(11) NOT NULL,
  `ID_QUEJA` int(11) DEFAULT NULL,
  `NIT` int(11) DEFAULT NULL,
  `DIRECCION` varchar(50) DEFAULT NULL,
  `ZONA` int(11) DEFAULT NULL,
  `TELEFONO` varchar(9) DEFAULT NULL,
  `CORREO` varchar(50) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZA` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla hija de la tabla quejas';

--
-- Volcado de datos para la tabla `tb_quejas_proveedor`
--

INSERT INTO `tb_quejas_proveedor` (`ID_PROVEEDORQ`, `ID_QUEJA`, `NIT`, `DIRECCION`, `ZONA`, `TELEFONO`, `CORREO`, `FECHA_ALTA`, `FECHA_ACTUALIZA`) VALUES
(1, 1, 7845129, 'calle principal ', 4, '4545', '', '2021-09-04 17:37:48', '2021-09-04 17:37:48'),
(2, 2, 7845129, 'calle principal', 2, '45454545', '', '2021-09-04 17:57:28', '2021-09-04 17:57:28'),
(3, 3, 7845129, '5avenida 3-29 zona2', 0, '42668998', '', '2021-09-04 18:07:10', '2021-09-04 18:07:10'),
(4, 4, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-04 20:16:58', '2021-09-04 20:16:58'),
(5, 5, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-04 20:17:33', '2021-09-04 20:17:33'),
(6, 6, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-04 20:19:17', '2021-09-04 20:19:17'),
(7, 7, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-04 20:20:26', '2021-09-04 20:20:26'),
(9, 9, 7845129, '5avenida 3-29 zona2', 2, '42668998', '', '2021-09-04 20:30:27', '2021-09-04 20:30:27'),
(10, 10, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-04 20:33:33', '2021-09-04 20:33:33'),
(11, 11, 7845129, '5avenida 3-29 zona2', 1, '42668998', '', '2021-09-05 21:32:43', '2021-09-05 21:32:43'),
(12, 12, 7845129, '5avenida 3-29 zona2', 5, '42668998', '', '2021-09-10 23:03:34', '2021-09-10 23:03:34'),
(13, 13, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(14, 14, 7845129, '5avenida 3-29 zona2', 4, '42668998', '', '2021-09-12 16:31:14', '2021-09-12 16:31:14'),
(15, 15, 7845129, '5avenida 3-29 zona2', 8, '42668998', '', '2021-09-12 16:36:31', '2021-09-12 16:36:31'),
(21, 21, 7845129, '5avenida 3-29 zona2', 55, '42668998', '', '2021-09-15 17:05:31', '2021-09-15 17:05:31'),
(25, 25, 7845129, '5avenida 3-29 san jose pinula zona 2', 5, '47293845', '', '2021-09-19 16:45:31', '2021-09-19 16:45:31'),
(26, 26, 7845129, '5avenida 3-29 san jose pinula zona 2', 5, '7845129', '', '2021-09-19 17:41:01', '2021-09-19 17:41:01'),
(37, 37, 1122333, '5avenida 3-29 san jose pinula zona 2', 45, '47293845', '', '2021-09-19 18:11:10', '2021-09-19 18:11:10'),
(38, 38, 1122333, '5avenida 3-29 san jose pinula', 2, '42668998', '', '2021-09-22 18:50:47', '2021-09-22 18:50:47'),
(39, 39, 1122333, 'calle principal san jose', 5, '45454', '', '2021-09-23 20:09:48', '2021-09-23 20:09:48'),
(40, 40, 1122333, '2da av. esquina A', 5, '45787899', '', '2021-09-23 20:33:11', '2021-09-23 20:33:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_region`
--

CREATE TABLE `tb_region` (
  `ID_REGION` int(11) NOT NULL,
  `REGION` varchar(30) DEFAULT NULL,
  `FECHA_ALTA` datetime DEFAULT NULL,
  `FECHA_ACTUALIZADO` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tb_region`
--

INSERT INTO `tb_region` (`ID_REGION`, `REGION`, `FECHA_ALTA`, `FECHA_ACTUALIZADO`) VALUES
(1, 'Region-Centro', '2021-09-04 17:18:59', '2021-09-04 17:19:26'),
(2, 'Region-sur', '2021-09-04 20:43:49', '2021-09-04 20:43:49'),
(3, 'Region-Suroccidente', '2021-09-10 18:50:26', '2021-09-10 18:50:26'),
(4, 'Region-Noroccidente', '2021-09-10 18:50:26', '2021-09-10 18:50:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_web_contenidos`
--

CREATE TABLE `tb_web_contenidos` (
  `ID_CONTENIDO` int(11) NOT NULL,
  `CONTENIDO` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla designada para los contenidos para la web no es intern';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_bitacora_quejas`
--
ALTER TABLE `tb_bitacora_quejas`
  ADD PRIMARY KEY (`ID_BITACORA`);

--
-- Indices de la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD PRIMARY KEY (`ID_DEP`),
  ADD KEY `FK_REFERENCE_11` (`ID_REGION`);

--
-- Indices de la tabla `tb_diaco_sucursal`
--
ALTER TABLE `tb_diaco_sucursal`
  ADD PRIMARY KEY (`ID_SUC`),
  ADD KEY `FK_REFERENCE_13` (`ID_USER`),
  ADD KEY `FK_REFERENCE_12` (`ID_REGION`);

--
-- Indices de la tabla `tb_diaco_usuarios`
--
ALTER TABLE `tb_diaco_usuarios`
  ADD PRIMARY KEY (`ID_USER`);

--
-- Indices de la tabla `tb_municipio`
--
ALTER TABLE `tb_municipio`
  ADD PRIMARY KEY (`ID_MUN`),
  ADD KEY `FK_REFERENCE_6` (`ID_DEP`);

--
-- Indices de la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  ADD PRIMARY KEY (`ID_QUEJA`),
  ADD KEY `FK_REFERENCE_4` (`ID_DEP`),
  ADD KEY `FK_REFERENCE_5` (`ID_MUN`);

--
-- Indices de la tabla `tb_quejas_detalle`
--
ALTER TABLE `tb_quejas_detalle`
  ADD PRIMARY KEY (`ID_DETALLEQ`),
  ADD KEY `FK_REFERENCE_7` (`ID_QUEJA`);

--
-- Indices de la tabla `tb_quejas_empresas`
--
ALTER TABLE `tb_quejas_empresas`
  ADD PRIMARY KEY (`NIT`);

--
-- Indices de la tabla `tb_quejas_personas`
--
ALTER TABLE `tb_quejas_personas`
  ADD PRIMARY KEY (`ID_PERSONAQ`),
  ADD KEY `FK_REFERENCE_9` (`ID_QUEJA`);

--
-- Indices de la tabla `tb_quejas_proveedor`
--
ALTER TABLE `tb_quejas_proveedor`
  ADD PRIMARY KEY (`ID_PROVEEDORQ`),
  ADD KEY `FK_REFERENCE_10` (`NIT`),
  ADD KEY `FK_REFERENCE_8` (`ID_QUEJA`);

--
-- Indices de la tabla `tb_region`
--
ALTER TABLE `tb_region`
  ADD PRIMARY KEY (`ID_REGION`);

--
-- Indices de la tabla `tb_web_contenidos`
--
ALTER TABLE `tb_web_contenidos`
  ADD PRIMARY KEY (`ID_CONTENIDO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  MODIFY `ID_DEP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tb_diaco_sucursal`
--
ALTER TABLE `tb_diaco_sucursal`
  MODIFY `ID_SUC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tb_diaco_usuarios`
--
ALTER TABLE `tb_diaco_usuarios`
  MODIFY `ID_USER` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tb_municipio`
--
ALTER TABLE `tb_municipio`
  MODIFY `ID_MUN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  MODIFY `ID_QUEJA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `tb_quejas_detalle`
--
ALTER TABLE `tb_quejas_detalle`
  MODIFY `ID_DETALLEQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `tb_quejas_personas`
--
ALTER TABLE `tb_quejas_personas`
  MODIFY `ID_PERSONAQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `tb_quejas_proveedor`
--
ALTER TABLE `tb_quejas_proveedor`
  MODIFY `ID_PROVEEDORQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `tb_region`
--
ALTER TABLE `tb_region`
  MODIFY `ID_REGION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_departamento`
--
ALTER TABLE `tb_departamento`
  ADD CONSTRAINT `FK_REFERENCE_11` FOREIGN KEY (`ID_REGION`) REFERENCES `tb_region` (`ID_REGION`);

--
-- Filtros para la tabla `tb_diaco_sucursal`
--
ALTER TABLE `tb_diaco_sucursal`
  ADD CONSTRAINT `FK_REFERENCE_12` FOREIGN KEY (`ID_REGION`) REFERENCES `tb_region` (`ID_REGION`),
  ADD CONSTRAINT `FK_REFERENCE_13` FOREIGN KEY (`ID_USER`) REFERENCES `tb_diaco_usuarios` (`ID_USER`);

--
-- Filtros para la tabla `tb_municipio`
--
ALTER TABLE `tb_municipio`
  ADD CONSTRAINT `FK_REFERENCE_6` FOREIGN KEY (`ID_DEP`) REFERENCES `tb_departamento` (`ID_DEP`);

--
-- Filtros para la tabla `tb_quejas`
--
ALTER TABLE `tb_quejas`
  ADD CONSTRAINT `FK_REFERENCE_4` FOREIGN KEY (`ID_DEP`) REFERENCES `tb_departamento` (`ID_DEP`),
  ADD CONSTRAINT `FK_REFERENCE_5` FOREIGN KEY (`ID_MUN`) REFERENCES `tb_municipio` (`ID_MUN`);

--
-- Filtros para la tabla `tb_quejas_detalle`
--
ALTER TABLE `tb_quejas_detalle`
  ADD CONSTRAINT `FK_REFERENCE_7` FOREIGN KEY (`ID_QUEJA`) REFERENCES `tb_quejas` (`ID_QUEJA`);

--
-- Filtros para la tabla `tb_quejas_personas`
--
ALTER TABLE `tb_quejas_personas`
  ADD CONSTRAINT `FK_REFERENCE_9` FOREIGN KEY (`ID_QUEJA`) REFERENCES `tb_quejas` (`ID_QUEJA`);

--
-- Filtros para la tabla `tb_quejas_proveedor`
--
ALTER TABLE `tb_quejas_proveedor`
  ADD CONSTRAINT `FK_REFERENCE_10` FOREIGN KEY (`NIT`) REFERENCES `tb_quejas_empresas` (`NIT`),
  ADD CONSTRAINT `FK_REFERENCE_8` FOREIGN KEY (`ID_QUEJA`) REFERENCES `tb_quejas` (`ID_QUEJA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
