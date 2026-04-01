-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2026 a las 20:21:10
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
-- Base de datos: `correspondencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_envio`
--

CREATE TABLE `anexo_envio` (
  `id_anexo` int(11) NOT NULL,
  `id_envio` int(10) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_envio`
--

INSERT INTO `anexo_envio` (`id_anexo`, `id_envio`, `ruta_archivo`, `nombre_original`) VALUES
(33, 37, 'correspondencia/6bjaAvgH3W7QIDbkVa7fgQGE82NGbs7dlPAMcama.pdf', 'CV.pdf'),
(34, 38, 'correspondencia/VHdk6yWaYvnISFjOUjdonF3vNRjTmIb0e8OJJLzP.pdf', 'ACTA INDIVIDUAL DE GRADO.pdf'),
(35, 39, 'correspondencia/swpt9Q4mgS5ZRL9M3FV648JMcE1ZYSDPqU1yUfTS.pdf', 'CV Yuber Paez.pdf'),
(36, 41, 'correspondencia/O4PoaeTxQrtOkdRPdQrknJvDIngrbs4wEbVTIpls.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(37, 48, 'correspondencia/KwzKKOZ3dWFi8yzcAhWm1IrfpJdg0OVZ4n0t1k0k.pdf', 'Hoja de Vida Luis Gomez.pdf'),
(38, 51, 'correspondencia/EvM40cic9uaBDZ28iyJ3wHMXsSx0Sv7YjulyNTpD.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(39, 67, 'correspondencia/6FKQAOEPNxiJNChOwUbaVEo8N1yMcAMPtBnYtT8d.pdf', 'reporte_gestion_remitente (2).pdf'),
(40, 68, 'correspondencia/6uXGRQw7nL6Gu6xrJVMBpMte1m9ftt6rFl4xYlqY.pdf', 'reporte_avanzado (7).pdf'),
(41, 69, 'correspondencia/9tuueWN4MX9uAS8mjwfrbh3lySQrHDn1SyX5yVhq.pdf', 'reporte_avanzado (6).pdf'),
(42, 70, 'correspondencia/9mjEwqZLu7cUbnjn0Z2lG9X460S1GvXOcCFggkSW.pdf', 'listado_correspondencia.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_recibido`
--

CREATE TABLE `anexo_recibido` (
  `id_anexo` int(11) NOT NULL,
  `id_recibido` int(20) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_recibido`
--

INSERT INTO `anexo_recibido` (`id_anexo`, `id_recibido`, `ruta_archivo`, `nombre_original`) VALUES
(38, 39, 'correspondencia/K6rOqOMPs1VE0DrujDmHlXyBIB7MmPoHqsD9nRDV.pdf', 'CV Yuber Paez.pdf'),
(39, 41, 'correspondencia/S3wEbFPWD1Yw8rbDlR56R4Yn41s4sRau2e7A9PSV.pdf', 'ACTIVITY SHOW AND TELL.pdf'),
(40, 42, 'correspondencia/V9JXGdws3KF8oTtm9dsOJaVIiFdXhtsb8AYHQe2w.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(41, 43, 'correspondencia/Reu4R1wXQuk9DyjzVUsEOueOx9eUjDGmdBwB49lO.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(42, 44, 'correspondencia/IW5V2JENxZm3am1KRn99IFvtJ8HOOzq9kyCboIZj.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(43, 45, 'correspondencia/e6g72egGp4e30znO5Q9KHksoekbHhCbdAY4P1iBB.pdf', 'ACTIVITY COMPARATIVE AND SUPERLATIVE.pdf'),
(44, 46, 'correspondencia/MxJMWHUwKf7XrNewazxgmGJRyz9BH9k8JTPSrE0o.pdf', 'Hoja de Vida Luis Gomez.pdf'),
(45, 47, 'correspondencia/GSHCooWaBfMCNy943rCvxzBaJh52V5alV0HhzcdX.pdf', 'Hoja de Vida Luis Gomez.pdf'),
(46, 48, 'correspondencia/CwUiuZ8GmTtoG0tyq5AL00vhhAxNCr0ECFhAr9XV.pdf', 'ACTIVITY SHOW AND TELL.pdf'),
(47, 49, 'correspondencia/XqkMgE0fEFmRlE2qXHF8rDO4YFCxUhoB0VQNXUWf.pdf', 'ACTIVITY COMPARATIVE AND SUPERLATIVE.pdf'),
(48, 50, 'correspondencia/oXIdPbadneFs1N1kY8GdtDPbcdGTvpGiufCgMRqz.pdf', 'CARRO SEGUIDOR DE LINEA DANIEL GOMEZ Y RAMIRO GOMEZ.pdf'),
(49, 51, 'correspondencia/C5D5kie6DleCfdqLFR9bJWtqCzXhLW9ymV6hs5tW.pdf', 'DOC-20250612-WA0015._1.pdf'),
(50, 58, 'correspondencia/AQD2uIKAYxOH3TupO8Hce2fEWYxM7BbKCdzXNSG1.pdf', 'Bienvenido a la página del Sisbén IV.pdf'),
(51, 59, 'correspondencia/UFLTZ8xdSyCPBsAyV51BYxkcXhgIvYF1D41OCeMd.pdf', 'reporte_gestion_remitente (2).pdf'),
(52, 60, 'correspondencia/3OjBOLL9d3gCINZe70DNd4dsGRMHr3ECXCUEahV9.pdf', 'listado_correspondencia (2).pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_respuesta`
--

CREATE TABLE `anexo_respuesta` (
  `id_anexo_resp` int(11) NOT NULL,
  `id_detalle` int(10) DEFAULT NULL,
  `id_det_interna` int(10) DEFAULT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anexo_respuesta`
--

INSERT INTO `anexo_respuesta` (`id_anexo_resp`, `id_detalle`, `id_det_interna`, `ruta_archivo`, `nombre_original`) VALUES
(19, NULL, 84, 'correspondencia/1qPhOI32CvjkZJwQJRPs417OlJQUt4Qz9haif4s9.pdf', 'pagos (7).pdf'),
(20, 99, NULL, 'correspondencia/9piQKx6c46GETi2Qoj36o5Iqh15rHIXXwGCuwSOV.pdf', 'REPORTE_EMPRESA_2026-03_ANIO.pdf'),
(21, 118, NULL, 'correspondencia/EvM40cic9uaBDZ28iyJ3wHMXsSx0Sv7YjulyNTpD.pdf', 'ACTIVITY SUPERLATIVE.pdf'),
(22, 127, NULL, 'correspondencia/KwzKKOZ3dWFi8yzcAhWm1IrfpJdg0OVZ4n0t1k0k.pdf', 'Hoja de Vida Luis Gomez.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(20) NOT NULL,
  `area_nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `area_nom`) VALUES
(1, 'Administrativa'),
(4, 'Gerencia General'),
(5, 'Recursos Humanos'),
(6, 'Contabilidad'),
(7, 'Correspondencia'),
(8, 'Archivo Central'),
(9, 'Oficina Asesora Juridica'),
(10, 'Finanz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_empleado`
--

CREATE TABLE `auditoria_empleado` (
  `id_log` int(11) NOT NULL,
  `doc_empleado_afectado` varchar(20) NOT NULL,
  `usuario_app` varchar(20) DEFAULT NULL,
  `usuario_bd` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_empleado`
--

INSERT INTO `auditoria_empleado` (`id_log`, `doc_empleado_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:07:26', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany2222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany2222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(2, '1005912005', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:14:46', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafradeeee\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(3, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-14 01:32:30', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany2222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(4, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-14 01:33:16', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(5, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-14 01:34:01', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(6, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-21 17:18:19', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevinreal2209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"santiagopc333@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(7, '1005912008', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-21 19:09:07', '{\"nombres\": \"Humber\", \"apellidos\": \"Perez\", \"correo\": \"humber@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 6}', '{\"nombres\": \"Humber\", \"apellidos\": \"Perez\", \"correo\": \"humber@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 6}'),
(8, '1005912008', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-21 19:09:54', '{\"nombres\": \"Humber\", \"apellidos\": \"Perez\", \"correo\": \"humber@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 6}', '{\"nombres\": \"Humber\", \"apellidos\": \"Perez\", \"correo\": \"humber@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 6}'),
(9, '999002', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:33:54', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"superadmin.admin@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(10, '999002', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:35:00', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(11, '999002', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:35:48', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(12, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:36:25', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 2, \"rol\": 2, \"area\": 1}'),
(13, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:36:54', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 2, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(14, '999001', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:37:38', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"superadmin.sadmin@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"superadmin.sadmin@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}'),
(15, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:37:38', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(16, '999003', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 20:37:38', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}'),
(17, '999003', NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-25 21:42:37', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}'),
(18, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-26 18:50:07', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(19, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-26 18:53:01', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(20, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-26 20:06:06', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(21, '999002', '999002', 'root@localhost', 'ACTUALIZACION', '2026-03-26 21:38:21', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Admin\", \"correo\": \"lucho2007311@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": 1}'),
(22, '999001', NULL, 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:38:01', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"superadmin.sadmin@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007@@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}'),
(23, '999001', NULL, 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:38:39', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007@@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}'),
(24, '123321', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:42:36', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(25, '1005912005', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:42:48', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafradeeee\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafradeeee\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(26, '1005912003', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:43:10', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"santiagopc333@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"santigjhgjh@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(27, '999001', NULL, 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:45:12', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007s@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}'),
(28, '123321', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:47:01', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(29, '123321', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 16:04:11', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(30, '123321', '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 16:04:39', '{\"nombres\": \"Noe\", \"apellidos\": \"See\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Administrador\", \"apellidos\": \"nuevo\", \"correo\": \"luisodaniel7@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(31, '999001', NULL, 'root@localhost', 'ACTUALIZACION', '2026-04-01 16:12:40', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007s@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"SAdmin\", \"correo\": \"lucho3112007@gmail.com\", \"estado\": 1, \"rol\": 1, \"area\": 1}'),
(32, '111222', '123321', 'root@localhost', 'ACTUALIZACION', '2026-04-01 16:43:27', '{\"nombres\": \"Empleado\", \"apellidos\": \"Nuevo\", \"correo\": \"juangomez123382@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}', '{\"nombres\": \"Empleado\", \"apellidos\": \"Nuevo\", \"correo\": \"juangomez123382@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}'),
(33, '999003', '999002', 'root@localhost', 'ACTUALIZACION', '2026-04-01 17:12:03', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}', '{\"nombres\": \"Super Admin\", \"apellidos\": \"Empleado\", \"correo\": \"superadmin.empleado@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}'),
(34, '111222', '123321', 'root@localhost', 'ACTUALIZACION', '2026-04-01 17:39:53', '{\"nombres\": \"Empleado\", \"apellidos\": \"Nuevo\", \"correo\": \"juangomez123382@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}', '{\"nombres\": \"Empleado\", \"apellidos\": \"Nuevo\", \"correo\": \"juangomez123382@gmail.com\", \"estado\": 1, \"rol\": 3, \"area\": 1}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_empresa`
--

CREATE TABLE `auditoria_empresa` (
  `id_log` int(11) NOT NULL,
  `nit_empresa_afectada` varchar(25) NOT NULL,
  `usuario_app` varchar(20) DEFAULT NULL,
  `usuario_bd` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_empresa`
--

INSERT INTO `auditoria_empresa` (`id_log`, `nit_empresa_afectada`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, '4354353454', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:36:10', '{\"nomb_empresa\": \"KFC & Food\", \"doc_representante\": \"38144607\", \"nomb_representante\": \"Emilio Casas\", \"direccion\": \"Avenida 37 N12 - 23 fdssfdsdfsdf\", \"contacto\": \"3152782654\", \"empresa_correo\": \"kfc@gmail.com\"}', '{\"nomb_empresa\": \"KFC &amp\", \"doc_representante\": \"38144607\", \"nomb_representante\": \"Emilio Casas\", \"direccion\": \"Avenida 37 N12 - 23 fdssfdsdfsdf\", \"contacto\": \"3152782654\", \"empresa_correo\": \"kfc@gmail.com\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_licencia`
--

CREATE TABLE `auditoria_licencia` (
  `id_log` int(11) NOT NULL,
  `id_licencia_afectada` int(11) NOT NULL,
  `usuario_app` varchar(20) DEFAULT NULL,
  `usuario_bd` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_licencia`
--

INSERT INTO `auditoria_licencia` (`id_log`, `id_licencia_afectada`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 34, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 19:34:51', '{\"id_estado\": 1, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}', '{\"id_estado\": 2, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}'),
(2, 34, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 19:35:06', '{\"id_estado\": 2, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}', '{\"id_estado\": 1, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_pagos`
--

CREATE TABLE `auditoria_pagos` (
  `id_log` int(11) NOT NULL,
  `id_pago_afectado` int(10) NOT NULL,
  `usuario_app` varchar(20) DEFAULT NULL,
  `usuario_bd` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_pagos`
--

INSERT INTO `auditoria_pagos` (`id_log`, `id_pago_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 63, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:56:35', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}'),
(2, 64, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-20 19:37:26', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}'),
(3, 55, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}'),
(4, 56, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}'),
(5, 57, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}'),
(6, 58, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}'),
(7, 59, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}'),
(8, 60, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}'),
(9, 61, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}'),
(10, 62, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}'),
(11, 63, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}'),
(12, 64, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}'),
(13, 65, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}'),
(14, 58, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}'),
(15, 59, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}'),
(16, 61, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}'),
(17, 65, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}'),
(18, 55, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}'),
(19, 56, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}'),
(20, 57, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}'),
(21, 64, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}'),
(22, 60, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}'),
(23, 62, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}'),
(24, 63, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:17:40', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}'),
(25, 55, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 11:59:10\", \"fecha_inicio\": null}'),
(26, 56, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}', '{\"id_plan\": 5, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:04\", \"fecha_inicio\": null}'),
(27, 57, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:01:17\", \"fecha_inicio\": null}'),
(28, 58, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:03\", \"fecha_inicio\": null}'),
(29, 59, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912006\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:05:09\", \"fecha_inicio\": null}'),
(30, 60, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"1005912005\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-02-27 12:06:40\", \"fecha_inicio\": null}'),
(31, 61, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-02 22:49:33\", \"fecha_inicio\": null}'),
(32, 62, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-11 14:23:11\", \"fecha_inicio\": null}'),
(33, 63, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}'),
(34, 64, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}', '{\"id_plan\": 6, \"comprobante\": null, \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:37:12\", \"fecha_inicio\": null}'),
(35, 65, NULL, 'root@localhost', 'ACTUALIZACION', '2026-03-27 19:18:06', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}'),
(36, 65, '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 15:43:23', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}', '{\"id_plan\": 4, \"comprobante\": \"comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg\", \"id_admin\": \"1005912003\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-20 14:55:17\", \"fecha_inicio\": null}'),
(37, 66, '999001', 'root@localhost', 'ACTUALIZACION', '2026-04-01 16:38:05', '{\"id_plan\": 6, \"comprobante\": \"comprobantes/P4EiObGajpnFHt9KLMk2RoZIyToAVka2nj9mG27T.jpg\", \"id_admin\": \"123321\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-04-01 11:17:01\", \"fecha_inicio\": \"2026-04-01 00:00:00\"}', '{\"id_plan\": 6, \"comprobante\": \"comprobantes/P4EiObGajpnFHt9KLMk2RoZIyToAVka2nj9mG27T.jpg\", \"id_admin\": \"123321\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-04-01 11:17:01\", \"fecha_inicio\": \"2026-04-01 00:00:00\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria_plan`
--

CREATE TABLE `auditoria_plan` (
  `id_log` int(11) NOT NULL,
  `id_plan_afectado` int(10) NOT NULL,
  `usuario_app` varchar(20) DEFAULT NULL,
  `usuario_bd` varchar(100) NOT NULL,
  `accion` varchar(20) NOT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT current_timestamp(),
  `datos_anteriores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_anteriores`)),
  `datos_nuevos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_nuevos`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria_plan`
--

INSERT INTO `auditoria_plan` (`id_log`, `id_plan_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 6, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 20:49:22', '{\"nomb_plan\": \"Semestral\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}', '{\"nomb_plan\": \"Semestrallllll\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}'),
(2, 6, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 20:49:39', '{\"nomb_plan\": \"Semestrallllll\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}', '{\"nomb_plan\": \"Semestral\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('easycor-cache-5c785c036466adea360111aa28563bfd556b5fba', 'i:1;', 1775064215),
('easycor-cache-5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1775064215;', 1775064215),
('easycor-cache-a835608b18204c6f1de3ef119a18e01b333f713a', 'i:1;', 1775035143),
('easycor-cache-a835608b18204c6f1de3ef119a18e01b333f713a:timer', 'i:1775035143;', 1775035143),
('easycor-cache-login|::1:timer', 'i:1775022155;', 1775022155);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE `ciudad` (
  `ciudad_cod_post` varchar(10) NOT NULL,
  `ciudad_nom` varchar(100) DEFAULT NULL,
  `ciudad_id_dpto` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ciudad`
--

INSERT INTO `ciudad` (`ciudad_cod_post`, `ciudad_nom`, `ciudad_id_dpto`) VALUES
('05001', 'Medellín', '05'),
('05002', 'Abejorral', '05'),
('05004', 'Abriaquí', '05'),
('05021', 'Alejandría', '05'),
('05030', 'Amagá', '05'),
('05031', 'Amalfi', '05'),
('05034', 'Andes', '05'),
('05036', 'Angelópolis', '05'),
('05038', 'Angostura', '05'),
('05040', 'Anorí', '05'),
('05042', 'Santafé de Antioquia', '05'),
('05044', 'Anzá', '05'),
('05045', 'Apartadó', '05'),
('05051', 'Arboletes', '05'),
('05055', 'Argelia', '05'),
('05059', 'Armenia', '05'),
('05079', 'Barbosa', '05'),
('05086', 'Belmira', '05'),
('05088', 'Bello', '05'),
('05091', 'Betania', '05'),
('05093', 'Betulia', '05'),
('05107', 'Briceño', '05'),
('05113', 'Buriticá', '05'),
('05120', 'Cáceres', '05'),
('05125', 'Caicedo', '05'),
('05129', 'Caldas', '05'),
('05134', 'Campamento', '05'),
('05138', 'Cañasgordas', '05'),
('05142', 'Caracolí', '05'),
('05145', 'Caramanta', '05'),
('05147', 'Carepa', '05'),
('05148', 'El Carmen de Viboral', '05'),
('05150', 'Carolina', '05'),
('05154', 'Caucasia', '05'),
('05172', 'Chigorodó', '05'),
('05190', 'Cisneros', '05'),
('05206', 'Concepción', '05'),
('05209', 'Concordia', '05'),
('05212', 'Copacabana', '05'),
('05234', 'Dabeiba', '05'),
('05237', 'Donmatías', '05'),
('05240', 'Ebéjico', '05'),
('05250', 'El Bagre', '05'),
('05264', 'Entrerríos', '05'),
('05266', 'Envigado', '05'),
('05282', 'Fredonia', '05'),
('05284', 'Frontino', '05'),
('05306', 'Giraldo', '05'),
('05308', 'Girardota', '05'),
('05310', 'Gómez Plata', '05'),
('05313', 'Granada', '05'),
('05315', 'Guadalupe', '05'),
('05318', 'Guarne', '05'),
('05321', 'Guatapé', '05'),
('0532343', 'Nkd', '05'),
('05347', 'Heliconia', '05'),
('05353', 'Hispania', '05'),
('05360', 'Itagüí', '05'),
('05361', 'Ituango', '05'),
('05364', 'Jardín', '05'),
('05368', 'Jericó', '05'),
('05376', 'La Ceja', '05'),
('05380', 'La Estrella', '05'),
('05390', 'La Pintada', '05'),
('05400', 'La Unión', '05'),
('05411', 'Liborina', '05'),
('05425', 'Maceo', '05'),
('05440', 'Marinilla', '05'),
('05467', 'Montebello', '05'),
('05475', 'Murindó', '05'),
('05480', 'Mutatá', '05'),
('05483', 'Nariño', '05'),
('05490', 'Necoclí', '05'),
('05495', 'Nechí', '05'),
('05501', 'Olaya', '05'),
('05541', 'Peñol', '05'),
('05543', 'Peque', '05'),
('05576', 'Pueblorrico', '05'),
('05579', 'Puerto Berrío', '05'),
('05585', 'Puerto Nare', '05'),
('05591', 'Puerto Triunfo', '05'),
('05604', 'Remedios', '05'),
('05607', 'Retiro', '05'),
('05615', 'Rionegro', '05'),
('05628', 'Sabanalarga', '05'),
('05631', 'Sabaneta', '05'),
('05642', 'Salgar', '05'),
('05647', 'San Andrés de Cuerquía', '05'),
('05649', 'San Carlos', '05'),
('05652', 'San Francisco', '05'),
('05656', 'San Jerónimo', '05'),
('05658', 'San José de la Montaña', '05'),
('05659', 'San Juan de Urabá', '05'),
('05660', 'San Luis', '05'),
('05664', 'San Pedro de los Milagros', '05'),
('05665', 'San Pedro de Urabá', '05'),
('05667', 'San Rafael', '05'),
('05670', 'San Roque', '05'),
('05674', 'San Vicente Ferrer', '05'),
('05679', 'Santa Bárbara', '05'),
('05686', 'Santa Rosa de Osos', '05'),
('05690', 'Santo Domingo', '05'),
('05697', 'El Santuario', '05'),
('05736', 'Segovia', '05'),
('05756', 'Sonsón', '05'),
('05761', 'Sopetrán', '05'),
('05789', 'Támesis', '05'),
('05790', 'Tarazá', '05'),
('05792', 'Tarso', '05'),
('05809', 'Titiribí', '05'),
('05819', 'Toledo', '05'),
('05837', 'Turbo', '05'),
('05842', 'Uramita', '05'),
('05847', 'Urrao', '05'),
('05854', 'Valdivia', '05'),
('05856', 'Valparaíso', '05'),
('05861', 'Vegachí', '05'),
('05873', 'Yalí', '05'),
('05885', 'Yarumal', '05'),
('05887', 'Yolombó', '05'),
('05890', 'Yondó', '05'),
('05893', 'Zaragoza', '05'),
('08001', 'Barranquilla', '08'),
('08078', 'Baranoa', '08'),
('08137', 'Campo de la Cruz', '08'),
('08141', 'Candelaria', '08'),
('08296', 'Galapa', '08'),
('08372', 'Juan de Acosta', '08'),
('08421', 'Luruaco', '08'),
('08433', 'Malambo', '08'),
('08436', 'Manatí', '08'),
('08520', 'Palmar de Varela', '08'),
('08549', 'Piojó', '08'),
('08558', 'Polonuevo', '08'),
('08560', 'Ponedera', '08'),
('08573', 'Puerto Colombia', '08'),
('08606', 'Repelón', '08'),
('08634', 'Sabanagrande', '08'),
('08638', 'Sabanalarga', '08'),
('08675', 'Santa Lucía', '08'),
('08685', 'Santo Tomás', '08'),
('08758', 'Soledad', '08'),
('08770', 'Suan', '08'),
('08832', 'Tubará', '08'),
('08849', 'Usiacurí', '08'),
('11001', 'Bogotá D.C.', '11'),
('13001', 'Cartagena de Indias', '13'),
('13006', 'Achí', '13'),
('13030', 'Altos del Rosario', '13'),
('13042', 'Arenal', '13'),
('13052', 'Arjona', '13'),
('13062', 'Arroyohondo', '13'),
('13074', 'Barranco de Loba', '13'),
('13140', 'Calamar', '13'),
('13160', 'Cantagallo', '13'),
('13188', 'Cicuco', '13'),
('13212', 'Córdoba', '13'),
('13222', 'Clemencia', '13'),
('13244', 'El Carmen de Bolívar', '13'),
('13248', 'El Guamo', '13'),
('13268', 'El Peñón', '13'),
('13300', 'Hatillo de Loba', '13'),
('13430', 'Magangué', '13'),
('13433', 'Mahates', '13'),
('13440', 'Margarita', '13'),
('13442', 'María La Baja', '13'),
('13458', 'Montecristo', '13'),
('13468', 'Mompós', '13'),
('13473', 'Morales', '13'),
('13490', 'Norosí', '13'),
('13549', 'Pinillos', '13'),
('13580', 'Regidor', '13'),
('13600', 'Río Viejo', '13'),
('13620', 'San Cristóbal', '13'),
('13647', 'San Estanislao', '13'),
('13650', 'San Fernando', '13'),
('13654', 'San Jacinto', '13'),
('13655', 'San Jacinto del Cauca', '13'),
('13657', 'San Juan Nepomuceno', '13'),
('13667', 'San Martín de Loba', '13'),
('13670', 'San Pablo', '13'),
('13673', 'Santa Catalina', '13'),
('13683', 'Santa Rosa', '13'),
('13688', 'Santa Rosa del Sur', '13'),
('13744', 'Simití', '13'),
('13760', 'Soplaviento', '13'),
('13780', 'Talaigua Nuevo', '13'),
('13810', 'Tiquisio', '13'),
('13836', 'Turbaco', '13'),
('13838', 'Turbaná', '13'),
('13873', 'Villanueva', '13'),
('13894', 'Zambrano', '13'),
('15001', 'Tunja', '15'),
('15022', 'Almeida', '15'),
('15047', 'Aquitania', '15'),
('15051', 'Arcabuco', '15'),
('15087', 'Belén', '15'),
('15090', 'Berbeo', '15'),
('15092', 'Betéitiva', '15'),
('15097', 'Boavita', '15'),
('15104', 'Boyacá', '15'),
('15106', 'Briceño', '15'),
('15109', 'Buenavista', '15'),
('15114', 'Busbanzá', '15'),
('15131', 'Caldas', '15'),
('15135', 'Campohermoso', '15'),
('15162', 'Cerinza', '15'),
('15172', 'Chinavita', '15'),
('15176', 'Chiquinquirá', '15'),
('15180', 'Chiscas', '15'),
('15183', 'Chita', '15'),
('15185', 'Chitaraque', '15'),
('15187', 'Chivatá', '15'),
('15189', 'Ciénega', '15'),
('15204', 'Cómbita', '15'),
('15212', 'Coper', '15'),
('15215', 'Corrales', '15'),
('15218', 'Covarachía', '15'),
('15223', 'Cubará', '15'),
('15224', 'Cucaita', '15'),
('15226', 'Cuítiva', '15'),
('15232', 'Chíquiza', '15'),
('15236', 'Chivor', '15'),
('15238', 'Duitama', '15'),
('15244', 'El Cocuy', '15'),
('15248', 'El Espino', '15'),
('15272', 'Firavitoba', '15'),
('15276', 'Floresta', '15'),
('15293', 'Gachantivá', '15'),
('15296', 'Gámeza', '15'),
('15299', 'Garagoa', '15'),
('15317', 'Guacamayas', '15'),
('15322', 'Guateque', '15'),
('15325', 'Guayatá', '15'),
('15332', 'Güicán', '15'),
('15362', 'Iza', '15'),
('15367', 'Jenesano', '15'),
('15368', 'Jericó', '15'),
('15377', 'Labranzagrande', '15'),
('15380', 'La Capilla', '15'),
('15401', 'La Victoria', '15'),
('15425', 'Macanal', '15'),
('15442', 'Maripí', '15'),
('15455', 'Miraflores', '15'),
('15464', 'Mongua', '15'),
('15466', 'Monguí', '15'),
('15469', 'Moniquirá', '15'),
('15476', 'Motavita', '15'),
('15480', 'Muzo', '15'),
('15491', 'Nobsa', '15'),
('15494', 'Nuevo Colón', '15'),
('15500', 'Oicatá', '15'),
('15507', 'Otanche', '15'),
('15511', 'Pachavita', '15'),
('15514', 'Páez', '15'),
('15516', 'Paipa', '15'),
('15518', 'Pajarito', '15'),
('15522', 'Panqueba', '15'),
('15531', 'Pauna', '15'),
('15533', 'Paya', '15'),
('15537', 'Paz de Río', '15'),
('15542', 'Pesca', '15'),
('15550', 'Pisba', '15'),
('15572', 'Puerto Boyacá', '15'),
('15580', 'Quípama', '15'),
('15599', 'Ramiriquí', '15'),
('15600', 'Ráquira', '15'),
('15621', 'Rondón', '15'),
('15632', 'Saboyá', '15'),
('15638', 'Sáchica', '15'),
('15646', 'Samacá', '15'),
('15660', 'San Eduardo', '15'),
('15664', 'San José de Pare', '15'),
('15667', 'San Luis de Gaceno', '15'),
('15673', 'San Mateo', '15'),
('15676', 'San Miguel de Sema', '15'),
('15681', 'San Pablo de Borbur', '15'),
('15686', 'Santana', '15'),
('15690', 'Santa María', '15'),
('15693', 'Santa Rosa de Viterbo', '15'),
('15696', 'Santa Sofía', '15'),
('15720', 'Sativanorte', '15'),
('15723', 'Sativasur', '15'),
('15740', 'Siachoque', '15'),
('15753', 'Soatá', '15'),
('15755', 'Socotá', '15'),
('15757', 'Socha', '15'),
('15759', 'Sogamoso', '15'),
('15761', 'Somondoco', '15'),
('15762', 'Sora', '15'),
('15763', 'Sotaquirá', '15'),
('15764', 'Soracá', '15'),
('15774', 'Susacón', '15'),
('15776', 'Sutamarchán', '15'),
('15778', 'Sutatenza', '15'),
('15790', 'Tasco', '15'),
('15798', 'Tenza', '15'),
('15804', 'Tibaná', '15'),
('15806', 'Tibasosa', '15'),
('15808', 'Tinjacá', '15'),
('15810', 'Tipacoque', '15'),
('15814', 'Toca', '15'),
('15816', 'Togüí', '15'),
('15820', 'Tópaga', '15'),
('15822', 'Tota', '15'),
('15832', 'Tununguá', '15'),
('15835', 'Turmequé', '15'),
('15837', 'Tuta', '15'),
('15839', 'Tutazá', '15'),
('15842', 'Úmbita', '15'),
('15861', 'Ventaquemada', '15'),
('15879', 'Viracachá', '15'),
('15897', 'Zetaquira', '15'),
('17001', 'Manizales', '17'),
('17013', 'Aguadas', '17'),
('17042', 'Anserma', '17'),
('17050', 'Aranzazu', '17'),
('17088', 'Belalcázar', '17'),
('17174', 'Chinchiná', '17'),
('17272', 'Filadelfia', '17'),
('17380', 'La Dorada', '17'),
('17433', 'La Merced', '17'),
('17442', 'Marmato', '17'),
('17444', 'Marquetalia', '17'),
('17446', 'Marulanda', '17'),
('17486', 'Neira', '17'),
('17495', 'Norcasia', '17'),
('17513', 'Pácora', '17'),
('17524', 'Palestina', '17'),
('17541', 'Pensilvania', '17'),
('17614', 'Riosucio', '17'),
('17616', 'Risaralda', '17'),
('17653', 'Salamina', '17'),
('17662', 'Samaná', '17'),
('17665', 'San José', '17'),
('17777', 'Supía', '17'),
('17867', 'Victoria', '17'),
('17873', 'Villamaría', '17'),
('17877', 'Viterbo', '17'),
('18001', 'Florencia', '18'),
('18029', 'Albania', '18'),
('18094', 'Belén de Los Andaquies', '18'),
('18150', 'Cartagena del Chairá', '18'),
('18205', 'Curillo', '18'),
('18247', 'El Doncello', '18'),
('18256', 'El Paujil', '18'),
('18410', 'La Montañita', '18'),
('18460', 'Milán', '18'),
('18479', 'Morelia', '18'),
('18592', 'Puerto Rico', '18'),
('18610', 'San José del Fragua', '18'),
('18753', 'San Vicente del Caguán', '18'),
('18756', 'Solano', '18'),
('18785', 'Solita', '18'),
('18860', 'Valparaíso', '18'),
('19001', 'Popayán', '19'),
('19022', 'Almaguer', '19'),
('19050', 'Argelia', '19'),
('19075', 'Balboa', '19'),
('19100', 'Bolívar', '19'),
('19110', 'Buenos Aires', '19'),
('19130', 'Cajibío', '19'),
('19137', 'Caldono', '19'),
('19142', 'Caloto', '19'),
('19212', 'Corinto', '19'),
('19256', 'El Tambo', '19'),
('19290', 'Florencia', '19'),
('19300', 'Guachené', '19'),
('19318', 'Guapi', '19'),
('19355', 'Inzá', '19'),
('19364', 'Jambaló', '19'),
('19392', 'La Sierra', '19'),
('19397', 'La Vega', '19'),
('19418', 'López de Micay', '19'),
('19450', 'Mercaderes', '19'),
('19455', 'Miranda', '19'),
('19473', 'Morales', '19'),
('19513', 'Padilla', '19'),
('19517', 'Páez', '19'),
('19532', 'Patía', '19'),
('19533', 'Piamonte', '19'),
('19548', 'Piendamó', '19'),
('19573', 'Puerto Tejada', '19'),
('19585', 'Puracé', '19'),
('19622', 'Rosas', '19'),
('19693', 'San Sebastián', '19'),
('19698', 'Santander de Quilichao', '19'),
('19701', 'Santa Rosa', '19'),
('19743', 'Silvia', '19'),
('19760', 'Sotará', '19'),
('19780', 'Suárez', '19'),
('19785', 'Sucre', '19'),
('19807', 'Timbío', '19'),
('19809', 'Timbiquí', '19'),
('19821', 'Toribío', '19'),
('19824', 'Totoró', '19'),
('19845', 'Villa Rica', '19'),
('20001', 'Valledupar', '20'),
('20011', 'Aguachica', '20'),
('20013', 'Agustín Codazzi', '20'),
('20032', 'Astrea', '20'),
('20045', 'Becerril', '20'),
('20060', 'Bosconia', '20'),
('20175', 'Chimichagua', '20'),
('20178', 'Chiriguaná', '20'),
('20228', 'Curumaní', '20'),
('20238', 'El Copey', '20'),
('20250', 'El Paso', '20'),
('20295', 'Gamarra', '20'),
('20310', 'González', '20'),
('20383', 'La Gloria', '20'),
('20400', 'La Jagua de Ibirico', '20'),
('20443', 'Manaure', '20'),
('20517', 'Pailitas', '20'),
('20550', 'Pelaya', '20'),
('20570', 'Pueblo Bello', '20'),
('20614', 'Río de Oro', '20'),
('20621', 'La Paz', '20'),
('20710', 'San Alberto', '20'),
('20750', 'San Diego', '20'),
('20770', 'San Martín', '20'),
('20787', 'Tamalameque', '20'),
('23001', 'Montería', '23'),
('23068', 'Ayapel', '23'),
('23079', 'Buenavista', '23'),
('23090', 'Canalete', '23'),
('23162', 'Cereté', '23'),
('23168', 'Chimá', '23'),
('23182', 'Chinú', '23'),
('23189', 'Ciénaga de Oro', '23'),
('23300', 'Cotorra', '23'),
('23350', 'La Apartada', '23'),
('23417', 'Lorica', '23'),
('23419', 'Los Córdobas', '23'),
('23464', 'Momil', '23'),
('23466', 'Montelíbano', '23'),
('23500', 'Moñitos', '23'),
('23555', 'Planeta Rica', '23'),
('23570', 'Pueblo Nuevo', '23'),
('23574', 'Puerto Escondido', '23'),
('23580', 'Puerto Libertador', '23'),
('23586', 'Purísima', '23'),
('23660', 'Sahagún', '23'),
('23670', 'San Andrés Sotavento', '23'),
('23672', 'San Antero', '23'),
('23675', 'San Bernardo del Viento', '23'),
('23678', 'San Carlos', '23'),
('23682', 'San José de Uré', '23'),
('23686', 'San Pelayo', '23'),
('23807', 'Tierralta', '23'),
('23815', 'Tuchín', '23'),
('23855', 'Valencia', '23'),
('25035', 'Anapoima', '25'),
('25040', 'Anolaima', '25'),
('25053', 'Arbeláez', '25'),
('25086', 'Beltrán', '25'),
('25095', 'Bituima', '25'),
('25099', 'Bojacá', '25'),
('25120', 'Cabrera', '25'),
('25123', 'Cachipay', '25'),
('25126', 'Cajicá', '25'),
('25148', 'Caparrapí', '25'),
('25151', 'Cáqueza', '25'),
('25154', 'Carmen de Carupa', '25'),
('25168', 'Chaguaní', '25'),
('25175', 'Chía', '25'),
('25178', 'Chipaque', '25'),
('25181', 'Choachí', '25'),
('25183', 'Chocontá', '25'),
('25200', 'Cogua', '25'),
('25214', 'Cota', '25'),
('25224', 'Cucunubá', '25'),
('25245', 'El Colegio', '25'),
('25258', 'El Peñón', '25'),
('25260', 'El Rosal', '25'),
('25269', 'Facatativá', '25'),
('25279', 'Fómeque', '25'),
('25281', 'Fosca', '25'),
('25286', 'Funza', '25'),
('25288', 'Fúquene', '25'),
('25290', 'Fusagasugá', '25'),
('25293', 'Gachalá', '25'),
('25295', 'Gachancipá', '25'),
('25297', 'Gachetá', '25'),
('25299', 'Gama', '25'),
('25307', 'Girardot', '25'),
('25312', 'Granada', '25'),
('25317', 'Guachetá', '25'),
('25320', 'Guaduas', '25'),
('25322', 'Guasca', '25'),
('25324', 'Guataquí', '25'),
('25326', 'Guatavita', '25'),
('25328', 'Guayabal de Síquima', '25'),
('25335', 'Guayabetal', '25'),
('25339', 'Gutiérrez', '25'),
('25368', 'Jerusalén', '25'),
('25372', 'Junín', '25'),
('25377', 'La Calera', '25'),
('25386', 'La Mesa', '25'),
('25394', 'La Palma', '25'),
('25398', 'La Peña', '25'),
('25402', 'La Vega', '25'),
('25407', 'Lenguazaque', '25'),
('25426', 'Machetá', '25'),
('25430', 'Madrid', '25'),
('25436', 'Manta', '25'),
('25438', 'Medina', '25'),
('25473', 'Mosquera', '25'),
('25483', 'Nariño', '25'),
('25486', 'Nemocón', '25'),
('25488', 'Nilo', '25'),
('25489', 'Nimaima', '25'),
('25491', 'Nocaima', '25'),
('25506', 'Venecia', '25'),
('25513', 'Pacho', '25'),
('25518', 'Paime', '25'),
('25524', 'Pandi', '25'),
('25530', 'Paratebueno', '25'),
('25535', 'Pasca', '25'),
('25572', 'Puerto Salgar', '25'),
('25580', 'Pulí', '25'),
('25592', 'Quebradanegra', '25'),
('25594', 'Quetame', '25'),
('25596', 'Quipile', '25'),
('25599', 'Apulo', '25'),
('25612', 'Ricaurte', '25'),
('25645', 'San Antonio del Tequendama', '25'),
('25649', 'San Bernardo', '25'),
('25653', 'San Cayetano', '25'),
('25658', 'San Francisco', '25'),
('25662', 'San Juan de Rioseco', '25'),
('25718', 'Sasaima', '25'),
('25736', 'Sesquilé', '25'),
('25740', 'Sibaté', '25'),
('25743', 'Silvania', '25'),
('25745', 'Simijaca', '25'),
('25754', 'Soacha', '25'),
('25758', 'Sopó', '25'),
('25769', 'Subachoque', '25'),
('25772', 'Suesca', '25'),
('25777', 'Supatá', '25'),
('25779', 'Susa', '25'),
('25781', 'Sutatausa', '25'),
('25785', 'Tabio', '25'),
('25793', 'Tausa', '25'),
('25797', 'Tena', '25'),
('25799', 'Tenjo', '25'),
('25805', 'Tibacuy', '25'),
('25807', 'Tibirita', '25'),
('25815', 'Tocaima', '25'),
('25817', 'Tocancipá', '25'),
('25823', 'Topaipí', '25'),
('25839', 'Ubalá', '25'),
('25841', 'Ubaque', '25'),
('25843', 'Villa de San Diego de Ubaté', '25'),
('25845', 'Une', '25'),
('25851', 'Útica', '25'),
('25862', 'Vergara', '25'),
('25867', 'Vianí', '25'),
('25871', 'Villagómez', '25'),
('25873', 'Villapinzón', '25'),
('25875', 'Villeta', '25'),
('25878', 'Viotá', '25'),
('25885', 'Yacopí', '25'),
('25898', 'Zipacón', '25'),
('25899', 'Zipaquirá', '25'),
('27001', 'Quibdó', '27'),
('27006', 'Acandí', '27'),
('27025', 'Alto Baudó', '27'),
('27050', 'Atrato', '27'),
('27073', 'Bagadó', '27'),
('27075', 'Bahía Solano', '27'),
('27077', 'Bajo Baudó', '27'),
('27099', 'Bojayá', '27'),
('27135', 'El Cantón del San Pablo', '27'),
('27150', 'Carmen del Darién', '27'),
('27160', 'Cértegui', '27'),
('27205', 'Condoto', '27'),
('27245', 'El Carmen de Atrato', '27'),
('27250', 'El Litoral del San Juan', '27'),
('27361', 'Istmina', '27'),
('27400', 'Juradó', '27'),
('27413', 'Lloró', '27'),
('27425', 'Medio Atrato', '27'),
('27430', 'Medio Baudó', '27'),
('27450', 'Medio San Juan', '27'),
('27491', 'Nóvita', '27'),
('27495', 'Nuquí', '27'),
('27580', 'Río Iró', '27'),
('27600', 'Río Quito', '27'),
('27615', 'Riosucio', '27'),
('27660', 'San José del Palmar', '27'),
('27745', 'Sipí', '27'),
('27787', 'Tadó', '27'),
('27800', 'Unguía', '27'),
('27810', 'Unión Panamericana', '27'),
('41001', 'Neiva', '41'),
('41006', 'Acevedo', '41'),
('41013', 'Agrado', '41'),
('41016', 'Aipe', '41'),
('41020', 'Algeciras', '41'),
('41026', 'Altamira', '41'),
('41078', 'Baraya', '41'),
('41132', 'Campoalegre', '41'),
('41206', 'Colombia', '41'),
('41244', 'Elías', '41'),
('41298', 'Garzón', '41'),
('41306', 'Gigante', '41'),
('41319', 'Guadalupe', '41'),
('41349', 'Hobo', '41'),
('41357', 'Íquira', '41'),
('41359', 'Isnos', '41'),
('41378', 'La Argentina', '41'),
('41396', 'La Plata', '41'),
('41483', 'Nátaga', '41'),
('41503', 'Oporapa', '41'),
('41518', 'Paicol', '41'),
('41524', 'Palermo', '41'),
('41530', 'Palestina', '41'),
('41548', 'Pital', '41'),
('41551', 'Pitalito', '41'),
('41615', 'Rivera', '41'),
('41660', 'Saladoblanco', '41'),
('41668', 'San Agustín', '41'),
('41676', 'Santa María', '41'),
('41770', 'Suaza', '41'),
('41791', 'Tarqui', '41'),
('41797', 'Tesalia', '41'),
('41799', 'Tello', '41'),
('41801', 'Teruel', '41'),
('41807', 'Timaná', '41'),
('41872', 'Villavieja', '41'),
('41885', 'Yaguará', '41'),
('44001', 'Riohacha', '44'),
('44035', 'Albania', '44'),
('44078', 'Barrancas', '44'),
('44090', 'Dibulla', '44'),
('44098', 'Distracción', '44'),
('44110', 'El Molino', '44'),
('44279', 'Fonseca', '44'),
('44378', 'Hatonuevo', '44'),
('44420', 'La Jagua del Pilar', '44'),
('44430', 'Maicao', '44'),
('44560', 'Manaure', '44'),
('44650', 'San Juan del Cesar', '44'),
('44847', 'Uribia', '44'),
('44855', 'Urumita', '44'),
('44874', 'Villanueva', '44'),
('47001', 'Santa Marta', '47'),
('47030', 'Algarrobo', '47'),
('47053', 'Aracataca', '47'),
('47058', 'Ariguaní', '47'),
('47161', 'Cerro San Antonio', '47'),
('47170', 'Chibolo', '47'),
('47189', 'Ciénaga', '47'),
('47205', 'Concordia', '47'),
('47245', 'El Banco', '47'),
('47258', 'El Piñón', '47'),
('47268', 'El Retén', '47'),
('47288', 'Fundación', '47'),
('47318', 'Guamal', '47'),
('47460', 'Nueva Granada', '47'),
('47541', 'Pedraza', '47'),
('47545', 'Pijiño del Carmen', '47'),
('47551', 'Pivijay', '47'),
('47555', 'Plato', '47'),
('47570', 'Puebloviejo', '47'),
('47605', 'Remolino', '47'),
('47660', 'Sabanas de San Ángel', '47'),
('47675', 'Salamina', '47'),
('47692', 'San Sebastián de Buenavista', '47'),
('47703', 'San Zenón', '47'),
('47707', 'Santa Ana', '47'),
('47720', 'Santa Bárbara de Pinto', '47'),
('47745', 'Sitionuevo', '47'),
('47798', 'Tenerife', '47'),
('47889', 'Zapayán', '47'),
('47899', 'Zona Bananera', '47'),
('50001', 'Villavicencio', '50'),
('50006', 'Acacías', '50'),
('50110', 'Barranca de Upía', '50'),
('50124', 'Cabuyaro', '50'),
('50150', 'Castilla la Nueva', '50'),
('50223', 'Cubarral', '50'),
('50226', 'Cumaral', '50'),
('50245', 'El Calvario', '50'),
('50251', 'El Castillo', '50'),
('50270', 'El Dorado', '50'),
('50287', 'Fuente de Oro', '50'),
('50313', 'Granada', '50'),
('50318', 'Guamal', '50'),
('50325', 'Mapiripán', '50'),
('50330', 'Mesetas', '50'),
('50350', 'La Macarena', '50'),
('50370', 'Uribe', '50'),
('50400', 'Lejanías', '50'),
('50450', 'Puerto Concordia', '50'),
('50568', 'Puerto Gaitán', '50'),
('50573', 'Puerto Lleras', '50'),
('50577', 'Puerto López', '50'),
('50590', 'Puerto Rico', '50'),
('50606', 'Restrepo', '50'),
('50680', 'San Carlos de Guaroa', '50'),
('50683', 'San Juan de Arama', '50'),
('50686', 'San Juanito', '50'),
('50689', 'San Martín', '50'),
('50711', 'Vistahermosa', '50'),
('52001', 'Pasto', '52'),
('52019', 'Albán', '52'),
('52022', 'Aldana', '52'),
('52036', 'Ancuya', '52'),
('52051', 'Arboleda', '52'),
('52079', 'Barbacoas', '52'),
('52083', 'Belén', '52'),
('52110', 'Buesaco', '52'),
('52207', 'Consacá', '52'),
('52210', 'Contadero', '52'),
('52215', 'Córdoba', '52'),
('52224', 'Cuaspud', '52'),
('52227', 'Cumbal', '52'),
('52233', 'Cumbitara', '52'),
('52240', 'Chachagüí', '52'),
('52250', 'El Charco', '52'),
('52254', 'El Peñol', '52'),
('52256', 'El Rosario', '52'),
('52258', 'El Tablón de Gómez', '52'),
('52260', 'El Tambo', '52'),
('52287', 'Funes', '52'),
('52317', 'Guachucal', '52'),
('52320', 'Guaitarilla', '52'),
('52323', 'Gualmatán', '52'),
('52352', 'Iles', '52'),
('52354', 'Imúes', '52'),
('52356', 'Ipiales', '52'),
('52378', 'La Cruz', '52'),
('52381', 'La Florida', '52'),
('52385', 'La Llanada', '52'),
('52390', 'La Tola', '52'),
('52399', 'La Unión', '52'),
('52405', 'Leiva', '52'),
('52411', 'Linares', '52'),
('52418', 'Los Andes', '52'),
('52427', 'Magüí', '52'),
('52435', 'Mallama', '52'),
('52473', 'Mosquera', '52'),
('52480', 'Nariño', '52'),
('52490', 'Olaya Herrera', '52'),
('52506', 'Ospina', '52'),
('52520', 'Francisco Pizarro', '52'),
('52540', 'Policarpa', '52'),
('52560', 'Potosí', '52'),
('52565', 'Providencia', '52'),
('52573', 'Puerres', '52'),
('52585', 'Pupiales', '52'),
('52612', 'Ricaurte', '52'),
('52621', 'Roberto Payán', '52'),
('52678', 'Samaniego', '52'),
('52683', 'Sandoná', '52'),
('52685', 'San Bernardo', '52'),
('52687', 'San Lorenzo', '52'),
('52693', 'San Pablo', '52'),
('52694', 'San Pedro de Cartago', '52'),
('52696', 'Santa Bárbara', '52'),
('52699', 'Santacruz', '52'),
('52720', 'Sapuyes', '52'),
('52786', 'Taminango', '52'),
('52788', 'Tangua', '52'),
('52835', 'Tumaco', '52'),
('52838', 'Túquerres', '52'),
('52885', 'Yacuanquer', '52'),
('54001', 'Cúcuta', '54'),
('54003', 'Ábrego', '54'),
('54051', 'Arboledas', '54'),
('54099', 'Bochalema', '54'),
('54109', 'Bucarasica', '54'),
('54125', 'Cáchira', '54'),
('54128', 'Cácota', '54'),
('54172', 'Chinácota', '54'),
('54174', 'Chitagá', '54'),
('54206', 'Convención', '54'),
('54223', 'Cucutilla', '54'),
('54239', 'Durania', '54'),
('54245', 'El Carmen', '54'),
('54250', 'El Tarra', '54'),
('54261', 'El Zulia', '54'),
('54313', 'Gramalote', '54'),
('54344', 'Hacarí', '54'),
('54377', 'Herrán', '54'),
('54385', 'La Esperanza', '54'),
('54398', 'La Playa', '54'),
('54405', 'Los Patios', '54'),
('54418', 'Lourdes', '54'),
('54480', 'Mutiscua', '54'),
('54498', 'Ocaña', '54'),
('54518', 'Pamplona', '54'),
('54520', 'Pamplonita', '54'),
('54553', 'Puerto Santander', '54'),
('54599', 'Ragonvalia', '54'),
('54660', 'Salazar', '54'),
('54670', 'San Calixto', '54'),
('54673', 'San Cayetano', '54'),
('54680', 'Santiago', '54'),
('54720', 'Sardinata', '54'),
('54743', 'Silos', '54'),
('54800', 'Teorama', '54'),
('54810', 'Tibú', '54'),
('54820', 'Toledo', '54'),
('54871', 'Villa Caro', '54'),
('54874', 'Villa del Rosario', '54'),
('63001', 'Armenia', '63'),
('63111', 'Buenavista', '63'),
('63130', 'Calarcá', '63'),
('63190', 'Circasia', '63'),
('63212', 'Córdoba', '63'),
('63272', 'Filandia', '63'),
('63302', 'Génova', '63'),
('63401', 'La Tebaida', '63'),
('63470', 'Montenegro', '63'),
('63548', 'Pijao', '63'),
('63594', 'Quimbaya', '63'),
('63690', 'Salento', '63'),
('66001', 'Pereira', '66'),
('66045', 'Apía', '66'),
('66075', 'Balboa', '66'),
('66088', 'Belén de Umbría', '66'),
('66170', 'Dosquebradas', '66'),
('66318', 'Guática', '66'),
('66383', 'La Celia', '66'),
('66400', 'La Virginia', '66'),
('66440', 'Marsella', '66'),
('66456', 'Mistrató', '66'),
('66572', 'Pueblo Rico', '66'),
('66594', 'Quinchía', '66'),
('66682', 'Santa Rosa de Cabal', '66'),
('66687', 'Santuario', '66'),
('68001', 'Bucaramanga', '68'),
('68013', 'Aguada', '68'),
('68020', 'Albania', '68'),
('68051', 'Aratoca', '68'),
('68077', 'Barbosa', '68'),
('68079', 'Barichara', '68'),
('68081', 'Barrancabermeja', '68'),
('68132', 'California', '68'),
('68147', 'Capitanejo', '68'),
('68162', 'Cepitá', '68'),
('68167', 'Cerrito', '68'),
('68176', 'Charta', '68'),
('68190', 'Cimitarra', '68'),
('68207', 'Concepción', '68'),
('68211', 'Confines', '68'),
('68217', 'Contratación', '68'),
('68229', 'Coromoro', '68'),
('68235', 'Curití', '68'),
('68245', 'El Carmen de Chucurí', '68'),
('68250', 'El Guacamayo', '68'),
('68255', 'El Playón', '68'),
('68264', 'Encino', '68'),
('68266', 'Enciso', '68'),
('68271', 'Florián', '68'),
('68276', 'Floridablanca', '68'),
('68296', 'Galán', '68'),
('68307', 'Gámbita', '68'),
('68318', 'Girón', '68'),
('68320', 'Guaca', '68'),
('68322', 'Guadalupe', '68'),
('68324', 'Guapotá', '68'),
('68327', 'Guavatá', '68'),
('68344', 'Güepsa', '68'),
('68368', 'Hato', '68'),
('68370', 'Jesús María', '68'),
('68377', 'Jordán', '68'),
('68385', 'La Belleza', '68'),
('68397', 'Landázuri', '68'),
('68406', 'La Paz', '68'),
('68418', 'Lebrija', '68'),
('68425', 'Los Santos', '68'),
('68432', 'Macaravita', '68'),
('68444', 'Málaga', '68'),
('68464', 'Matanza', '68'),
('68468', 'Mogotes', '68'),
('68498', 'Ocamonte', '68'),
('68500', 'Oiba', '68'),
('68502', 'Onzaga', '68'),
('68522', 'Palmar', '68'),
('68524', 'Palmas del Socorro', '68'),
('68533', 'Páramo', '68'),
('68547', 'Piedecuesta', '68'),
('68549', 'Pinchote', '68'),
('68572', 'Puente Nacional', '68'),
('68573', 'Puerto Parra', '68'),
('68575', 'Puerto Wilches', '68'),
('68615', 'Rionegro', '68'),
('68655', 'Sabana de Torres', '68'),
('68669', 'San Andrés', '68'),
('68673', 'San Benito', '68'),
('68679', 'San Gil', '68'),
('68682', 'San Joaquín', '68'),
('68684', 'San José de Miranda', '68'),
('68686', 'San Miguel', '68'),
('68689', 'San Vicente de Chucurí', '68'),
('68705', 'Santa Bárbara', '68'),
('68720', 'Santa Helena del Opón', '68'),
('68745', 'Simacota', '68'),
('68755', 'Socorro', '68'),
('68770', 'Suaita', '68'),
('68773', 'Sucre', '68'),
('68780', 'Suratá', '68'),
('68820', 'Tona', '68'),
('68855', 'Valle de San José', '68'),
('68861', 'Vélez', '68'),
('68867', 'Vetas', '68'),
('68872', 'Villanueva', '68'),
('68895', 'Zapatoca', '68'),
('70001', 'Sincelejo', '70'),
('70110', 'Buenavista', '70'),
('70124', 'Caimito', '70'),
('70204', 'Colosó', '70'),
('70215', 'Corozal', '70'),
('70221', 'Coveñas', '70'),
('70230', 'Chalán', '70'),
('70233', 'El Roble', '70'),
('70235', 'Galeras', '70'),
('70265', 'Guaranda', '70'),
('70400', 'La Unión', '70'),
('70418', 'Los Palmitos', '70'),
('70429', 'Majagual', '70'),
('70473', 'Morroa', '70'),
('70508', 'Ovejas', '70'),
('70523', 'Palmito', '70'),
('70670', 'Sampués', '70'),
('70678', 'San Benito Abad', '70'),
('70702', 'San Juan de Betulia', '70'),
('70708', 'San Marcos', '70'),
('70713', 'San Onofre', '70'),
('70717', 'San Pedro', '70'),
('70742', 'Sincé', '70'),
('70771', 'Sucre', '70'),
('70820', 'Santiago de Tolú', '70'),
('70823', 'Tolú Viejo', '70'),
('73001', 'Ibagué', '73'),
('73024', 'Alpujarra', '73'),
('73026', 'Alvarado', '73'),
('73030', 'Ambalema', '73'),
('73043', 'Anzoátegui', '73'),
('73055', 'Armero Guayabal', '73'),
('73067', 'Ataco', '73'),
('73124', 'Cajamarca', '73'),
('73148', 'Carmen de Apicalá', '73'),
('73152', 'Casabianca', '73'),
('73168', 'Chaparral', '73'),
('73200', 'Coello', '73'),
('73217', 'Coyaima', '73'),
('73226', 'Cunday', '73'),
('73236', 'Dolores', '73'),
('73268', 'Espinal', '73'),
('73270', 'Falan', '73'),
('73275', 'Flandes', '73'),
('73283', 'Fresno', '73'),
('73319', 'Guamo', '73'),
('73347', 'Herveo', '73'),
('73349', 'Honda', '73'),
('73352', 'Icononzo', '73'),
('73408', 'Lérida', '73'),
('73411', 'Líbano', '73'),
('73443', 'Mariquita', '73'),
('73449', 'Melgar', '73'),
('73461', 'Murillo', '73'),
('73483', 'Natagaima', '73'),
('73504', 'Ortega', '73'),
('73520', 'Palocabildo', '73'),
('73547', 'Piedras', '73'),
('73555', 'Planadas', '73'),
('73563', 'Prado', '73'),
('73585', 'Purificación', '73'),
('73616', 'Rioblanco', '73'),
('73622', 'Roncesvalles', '73'),
('73624', 'Rovira', '73'),
('73671', 'Saldaña', '73'),
('73675', 'San Antonio', '73'),
('73678', 'San Luis', '73'),
('73686', 'Santa Isabel', '73'),
('73770', 'Suárez', '73'),
('73854', 'Valle de San Juan', '73'),
('73861', 'Venadillo', '73'),
('73870', 'Villahermosa', '73'),
('73873', 'Villarrica', '73'),
('76001', 'Cali', '76'),
('76020', 'Alcalá', '76'),
('76036', 'Andalucía', '76'),
('76041', 'Ansermanuevo', '76'),
('76054', 'Argelia', '76'),
('76100', 'Bolívar', '76'),
('76109', 'Buenaventura', '76'),
('76111', 'Guadalajara de Buga', '76'),
('76113', 'Bugalagrande', '76'),
('76122', 'Caicedonia', '76'),
('76126', 'Calima', '76'),
('76130', 'Candelaria', '76'),
('76147', 'Cartago', '76'),
('76233', 'Dagua', '76'),
('76243', 'El Águila', '76'),
('76246', 'El Cairo', '76'),
('76248', 'El Cerrito', '76'),
('76250', 'El Dovio', '76'),
('76275', 'Florida', '76'),
('76306', 'Ginebra', '76'),
('76318', 'Guacarí', '76'),
('76364', 'Jamundí', '76'),
('76377', 'La Cumbre', '76'),
('76400', 'La Unión', '76'),
('76403', 'La Victoria', '76'),
('76497', 'Obando', '76'),
('76520', 'Palmira', '76'),
('76563', 'Pradera', '76'),
('76606', 'Restrepo', '76'),
('76616', 'Riofrío', '76'),
('76622', 'Roldanillo', '76'),
('76670', 'San Pedro', '76'),
('76736', 'Sevilla', '76'),
('76823', 'Toro', '76'),
('76828', 'Trujillo', '76'),
('76834', 'Tuluá', '76'),
('76845', 'Ulloa', '76'),
('76863', 'Versalles', '76'),
('76869', 'Vijes', '76'),
('76890', 'Yotoco', '76'),
('76892', 'Yumbo', '76'),
('76895', 'Zarzal', '76'),
('81001', 'Arauca', '81'),
('81065', 'Arauquita', '81'),
('81220', 'Cravo Norte', '81'),
('81300', 'Fortul', '81'),
('81591', 'Puerto Rondón', '81'),
('81736', 'Saravena', '81'),
('81794', 'Tame', '81'),
('85001', 'Yopal', '85'),
('85010', 'Aguazul', '85'),
('85015', 'Chámeza', '85'),
('85125', 'Hato Corozal', '85'),
('85136', 'La Salina', '85'),
('85139', 'Maní', '85'),
('85162', 'Monterrey', '85'),
('85225', 'Nunchía', '85'),
('85230', 'Orocué', '85'),
('85250', 'Paz de Ariporo', '85'),
('85263', 'Pore', '85'),
('85279', 'Recetor', '85'),
('85300', 'Sabanalarga', '85'),
('85315', 'Sácama', '85'),
('85325', 'San Luis de Palenque', '85'),
('85400', 'Támara', '85'),
('85410', 'Tauramena', '85'),
('85430', 'Trinidad', '85'),
('85440', 'Villanueva', '85'),
('86001', 'Mocoa', '86'),
('86219', 'Colón', '86'),
('86320', 'Orito', '86'),
('86568', 'Puerto Asís', '86'),
('86569', 'Puerto Caicedo', '86'),
('86571', 'Puerto Guzmán', '86'),
('86573', 'Leguízamo', '86'),
('86749', 'Sibundoy', '86'),
('86755', 'San Francisco', '86'),
('86757', 'San Miguel', '86'),
('86760', 'Santiago', '86'),
('86865', 'Valle del Guamuez', '86'),
('86885', 'Villagarzón', '86'),
('88001', 'San Andrés', '88'),
('88564', 'Providencia', '88'),
('91001', 'Leticia', '91'),
('91263', 'El Encanto', '91'),
('91405', 'La Chorrera', '91'),
('91407', 'La Pedrera', '91'),
('91430', 'La Victoria', '91'),
('91460', 'Miriti - Paraná', '91'),
('91530', 'Puerto Alegría', '91'),
('91536', 'Puerto Arica', '91'),
('91540', 'Puerto Nariño', '91'),
('91669', 'Puerto Santander', '91'),
('91798', 'Tarapacá', '91'),
('94001', 'Inírida', '94'),
('94343', 'Barranco Minas', '94'),
('94663', 'Mapiripana', '94'),
('94883', 'San Felipe', '94'),
('94884', 'Puerto Colombia', '94'),
('94885', 'La Guadalupe', '94'),
('94886', 'Cacahual', '94'),
('94887', 'Pana Pana', '94'),
('94888', 'Morichal', '94'),
('95001', 'San José del Guaviare', '95'),
('95015', 'Calamar', '95'),
('95025', 'El Retorno', '95'),
('95200', 'Miraflores', '95'),
('97001', 'Mitú', '97'),
('97161', 'Carurú', '97'),
('97511', 'Pacoa', '97'),
('97666', 'Taraira', '97'),
('97777', 'Papunaua', '97'),
('97889', 'Yavaraté', '97'),
('99001', 'Puerto Carreño', '99'),
('99524', 'La Primavera', '99'),
('99624', 'Santa Rosalía', '99'),
('99773', 'Cumaribo', '99');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `dpto_codigo_postal` varchar(10) NOT NULL,
  `dpto_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`dpto_codigo_postal`, `dpto_nombre`) VALUES
('05', 'Antioquia'),
('08', 'Atlántico'),
('11', 'Bogotá D.C.'),
('13', 'Bolívar'),
('15', 'Boyacá'),
('17', 'Caldas'),
('18', 'Caquetá'),
('19', 'Cauca'),
('20', 'Cesar'),
('23', 'Córdoba'),
('25', 'Cundinamarca'),
('27', 'Chocó'),
('41', 'Huila'),
('44', 'La Guajira'),
('47', 'Magdalena'),
('50', 'Meta'),
('52', 'Nariño'),
('54', 'Norte de Santander'),
('63', 'Quindío'),
('66', 'Risaralda'),
('68', 'Santander'),
('70', 'Sucre'),
('73', 'Tolima'),
('76', 'Valle del Cauca'),
('766', 'Dsds'),
('81', 'Arauca'),
('85', 'Casanare'),
('86', 'Putumayo'),
('88', 'San Andrés y Providencia'),
('91', 'Amazonas'),
('94', 'Guainía'),
('95', 'Guaviare'),
('97', 'Vaupés'),
('99', 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_envio`
--

CREATE TABLE `detalle_envio` (
  `id_detalle` int(10) NOT NULL,
  `id_quien_envie` varchar(20) NOT NULL,
  `id_quien_recibe` varchar(20) NOT NULL,
  `id_envio` int(15) NOT NULL,
  `fecha_traslado` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_estado_rec` int(20) NOT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `archivo_respuesta` varchar(500) DEFAULT NULL,
  `folios_respuesta` int(11) DEFAULT NULL,
  `visto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_envio`
--

INSERT INTO `detalle_envio` (`id_detalle`, `id_quien_envie`, `id_quien_recibe`, `id_envio`, `fecha_traslado`, `id_estado_rec`, `observaciones`, `archivo_respuesta`, `folios_respuesta`, `visto`) VALUES
(82, '1005912008', '1005912006', 37, '2026-03-21 19:04:02', 7, 'prueba', NULL, NULL, 0),
(83, '1005912008', '1005912006', 37, '2026-03-21 19:06:21', 8, 'lo estoy resolviendo bro', NULL, 0, 0),
(84, '1005912008', '1005912006', 37, '2026-03-21 19:06:54', 9, 'ahi le envio mi respuesta bro', 'correspondencia/mRJc9ilqzmeIuGPxXSZEmyXi3Iyz9Ahzo2SeHGaM.pdf', 2, 1),
(85, '1005912006', '1005912001', 39, '2026-03-21 19:17:49', 7, 'prueba', NULL, NULL, 0),
(86, '1005912006', '1005912003', 39, '2026-03-21 19:17:49', 7, 'prueba', NULL, NULL, 0),
(87, '1005912006', '1005912008', 39, '2026-03-21 19:17:49', 7, 'prueba', NULL, NULL, 0),
(88, '1005912006', '1070730214', 39, '2026-03-21 19:17:49', 7, 'prueba', NULL, NULL, 0),
(89, '999003', '999003', 44, '2026-03-30 16:22:30', 12, 'Envío procesado por ventanilla. Prueba terminada [Correo Notificación: lucho3112007@gmail.com]', NULL, NULL, 0),
(90, '999003', '999003', 46, '2026-03-30 19:24:50', 12, 'Envío procesado por ventanilla. Terminado', NULL, NULL, 0),
(92, '1070730214', '1070730214', 68, '2026-04-01 15:43:46', 9, 'Correspondencia despachada y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 0),
(93, '1070730214', '1070730214', 67, '2026-04-01 15:43:52', 9, 'Correspondencia despachada y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 0),
(94, '999003', '999002', 69, '2026-04-01 17:33:36', 7, 'prueba', NULL, NULL, 0),
(95, '111222', '999003', 70, '2026-04-01 17:41:19', 7, 'prueba', NULL, NULL, 0),
(96, '111222', '999003', 70, '2026-04-01 18:15:25', 8, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibido`
--

CREATE TABLE `detalle_recibido` (
  `id_det_recibido` int(15) NOT NULL,
  `det_id_recibido` int(20) NOT NULL,
  `det_doc_empleado` varchar(20) DEFAULT NULL,
  `fecha_re` timestamp NULL DEFAULT NULL,
  `id_estado_rec` int(20) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `archivo_res` varchar(500) DEFAULT NULL,
  `folios_res` int(11) DEFAULT NULL,
  `visto` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_recibido`
--

INSERT INTO `detalle_recibido` (`id_det_recibido`, `det_id_recibido`, `det_doc_empleado`, `fecha_re`, `id_estado_rec`, `observaciones`, `archivo_res`, `folios_res`, `visto`) VALUES
(97, 39, '1005912008', '2026-03-24 21:31:14', 7, 'ninguna', NULL, NULL, 0),
(98, 39, '1005912008', '2026-03-24 21:31:47', 8, 'resolviendo', NULL, 0, 0),
(99, 39, '1005912008', '2026-03-24 21:32:08', 9, 'anexo respuesta', 'correspondencia/EGkRjVFvoe2vT3N5Vg6Mpsj2eL7QE4X9lA67ee50.pdf', 7, 0),
(100, 40, '1005912008', '2026-03-24 21:33:24', 7, 'prueba', NULL, NULL, 0),
(101, 40, '1005912008', '2026-03-24 21:33:45', 8, 'estoy trabajando en eso', NULL, 0, 0),
(102, 40, '1005912008', '2026-03-24 21:34:00', 9, 'finalizado', 'correspondencia/eV31XuDqraU11pJp2ypofCZrNqArP5gbNcO6oCFX.pdf', 1, 0),
(103, 40, '1005912008', '2026-03-24 21:35:56', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(104, 41, '999003', '2026-03-25 20:50:41', 7, 'ss', NULL, NULL, 0),
(105, 41, '999003', '2026-03-25 20:51:39', 8, NULL, NULL, 0, 0),
(106, 41, '999003', '2026-03-25 20:52:17', 9, 'resuelto', 'correspondencia/4mpMlL6hW3y9X7eUWQH9DwNnUxove7KlC5zdneUE.pdf', 3, 0),
(107, 42, '999003', '2026-03-25 21:50:03', 9, 'Asignación manual de destinatarios', NULL, NULL, 0),
(108, 42, '999003', '2026-03-25 21:50:35', 9, 'aa', NULL, 0, 0),
(109, 41, '999003', '2026-03-27 18:52:17', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(110, 42, '999003', '2026-03-27 21:01:56', 12, 'Correspondencia re-enviada tras corrección.', NULL, NULL, 0),
(111, 42, '999003', '2026-03-27 21:01:57', 7, 'Recibido para nueva gestión tras corrección: C', NULL, NULL, 0),
(112, 44, '999003', '2026-03-27 21:02:48', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(113, 43, '999003', '2026-03-27 21:05:54', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(114, 44, '999003', '2026-03-27 21:36:03', 8, 'En trámite', NULL, 0, 0),
(115, 43, '999003', '2026-03-27 21:36:30', 10, 'No se ve', NULL, 0, 0),
(116, 42, '999003', '2026-03-27 21:36:49', 8, 'tramite', NULL, 0, 0),
(117, 44, '999003', '2026-03-27 21:37:25', 9, 'Respuesta', 'correspondencia/UynOXUSRdScKm4xy2O8PmFVPQbeqzIG1eqQjPxyj.pdf', 4, 0),
(118, 42, '999003', '2026-03-27 21:57:54', 9, 'Respuesta', 'correspondencia/zHNfhm7lvETIhuYPC7RLpQXkfbEWzZogbTkJl3ET.pdf', 6, 0),
(119, 45, '999003', '2026-03-28 20:20:50', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(120, 45, '999003', '2026-03-28 20:29:07', 8, 'tramite', NULL, 0, 0),
(121, 46, '999003', '2026-03-30 16:46:28', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(122, 46, '999003', '2026-03-30 16:47:15', 8, 'tramitando', NULL, 0, 0),
(123, 46, '999003', '2026-03-30 16:48:04', 9, 'Solucionado', 'correspondencia/i1RR1y2eu0BhVFyzTZK1FOerDljXdTe4BqpPSMAE.pdf', 1, 0),
(124, 46, '999003', '2026-03-30 16:49:26', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(125, 47, '999003', '2026-03-30 17:23:37', 7, 'Prueba', NULL, NULL, 0),
(126, 47, '999003', '2026-03-30 17:24:50', 8, 'tramite', NULL, 0, 0),
(127, 47, '999003', '2026-03-30 17:25:29', 9, 'final', 'correspondencia/nRnHR1m3li9Wsvu9rx9za1v43gLNNhAKScu88iYs.pdf', 2, 0),
(128, 45, '999003', '2026-03-30 17:25:50', 9, 'listo', 'correspondencia/8P0JHFo5k3gWdtXUooEJS0HqVC9udepTVERpj0wG.pdf', 3, 0),
(129, 48, '999003', '2026-03-30 19:31:27', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(130, 48, '999003', '2026-03-30 19:32:47', 8, 'Prueba', NULL, 0, 0),
(131, 48, '999003', '2026-03-30 19:33:09', 9, 'Terminado', 'correspondencia/fNdubDuxfiDSOvGVQNcnphAj5QJSqG1uGPf5wH3o.pdf', 2, 0),
(132, 48, '999003', '2026-03-30 19:35:01', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(133, 49, NULL, '2026-03-31 01:15:46', 10, 'Correspondencia Rechazada por Remitente: Empresa equivocada', NULL, NULL, 0),
(134, 47, '999003', '2026-03-31 01:17:47', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(135, 45, '999003', '2026-03-31 01:18:08', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(136, 44, '999003', '2026-03-31 01:18:21', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(137, 42, '999003', '2026-03-31 01:18:33', 14, 'Registrado como envío saliente (Respuesta enviada).', NULL, NULL, 1),
(139, 50, '999003', '2026-04-01 02:13:08', 7, 'Asignación manual de destinatarios', NULL, NULL, 1),
(140, 51, '999003', '2026-04-01 01:15:05', 7, 'wswa', NULL, NULL, 1),
(141, 52, '999003', '2026-04-01 01:33:25', 7, 'sdfds', NULL, NULL, 1),
(142, 53, '999003', '2026-04-01 04:10:22', 7, 'www', NULL, NULL, 0),
(143, 53, '999003', '2026-04-01 04:24:27', 8, NULL, NULL, 0, 0),
(144, 53, '999003', '2026-04-01 04:24:37', 9, NULL, 'correspondencia/MH0X0ZPW3WQqqH2UGepkRKGYfBinXco6Aw4ZKviH.pdf', 2, 0),
(145, 55, '999003', '2026-04-01 06:33:57', 7, 'Asignación manual de destinatarios', NULL, NULL, 0),
(146, 55, '999003', '2026-04-01 06:34:44', 8, NULL, NULL, 0, 0),
(147, 55, '999003', '2026-04-01 06:35:10', 9, 'assda', 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', 2, 0),
(148, 55, '1070730214', '2026-04-01 06:56:34', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(149, 55, '1070730214', '2026-04-01 06:56:50', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(150, 55, '1070730214', '2026-04-01 06:57:35', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(151, 55, '1070730214', '2026-04-01 07:06:09', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(152, 55, '1070730214', '2026-04-01 07:08:45', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(153, 55, '1070730214', '2026-04-01 07:09:37', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(154, 53, '1070730214', '2026-04-01 07:16:38', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(155, 55, '1070730214', '2026-04-01 07:23:58', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(156, 55, '1070730214', '2026-04-01 07:24:08', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(157, 56, '999003', '2026-04-01 08:05:17', 7, 'ewrewr', NULL, NULL, 0),
(158, 57, '1070730214', '2026-04-01 08:24:40', 9, 'Rechazado por (Remitente) Super Admin Remitente: dsdf', NULL, NULL, 0),
(159, 57, '999003', '2026-04-01 08:26:30', 12, 'Correspondencia re-enviada tras corrección.', NULL, NULL, 0),
(160, 57, '999003', '2026-04-01 08:26:31', 7, 'Recibido para nueva gestión tras corrección: dfdsf', NULL, NULL, 0),
(161, 57, '999003', '2026-04-01 08:26:48', 10, 'porquesi', NULL, 0, 0),
(162, 58, '999003', '2026-04-01 08:29:49', 7, 'sdfd', NULL, NULL, 0),
(163, 58, '999003', '2026-04-01 08:30:46', 8, 'tin', NULL, 0, 0),
(164, 58, '999003', '2026-04-01 08:31:01', 9, 'tan', 'correspondencia/fkkVRyScD8JOpWaCCvx4l8Ute0zJ0Lx06ENWDn51.pdf', 2, 0),
(165, 58, '1070730214', '2026-04-01 08:39:20', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(166, 58, '1070730214', '2026-04-01 08:39:42', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(167, 56, '999003', '2026-04-01 09:16:08', 10, NULL, NULL, 0, 0),
(168, 56, '1070730214', '2026-04-01 09:18:46', 9, 'Respuesta enviada al ciudadano y radicado finalizado por (Remitente) Super Admin Remitente.', NULL, NULL, 1),
(169, 59, '1070730214', '2026-04-01 09:37:01', 10, 'Rechazado por (Remitente) Super Admin Remitente: ee', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `emple_doc` varchar(20) NOT NULL,
  `nit_empresa` varchar(25) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `emple_nombres` varchar(50) NOT NULL,
  `emple_apellidos` varchar(50) NOT NULL,
  `emple_tel` varchar(25) DEFAULT NULL,
  `emple_correo` varchar(255) NOT NULL,
  `emple_img` varchar(500) DEFAULT NULL,
  `emple_estado` int(20) NOT NULL,
  `emple_rol` int(20) NOT NULL,
  `emple_area` int(11) DEFAULT NULL,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`emple_doc`, `nit_empresa`, `password`, `emple_nombres`, `emple_apellidos`, `emple_tel`, `emple_correo`, `emple_img`, `emple_estado`, `emple_rol`, `emple_area`, `actualizado_por`) VALUES
('1005912001', '9887978978', '$2y$12$QbInKlg5gvKVn0/AOx3KVeo6jI3Fvj8rrTVEn6PdrhUZQw6FJBJTS', 'Dani', 'Villa', '3152782654', 'kevindany21993838@gmail.com', NULL, 1, 3, 1, NULL),
('1005912003', '9887978978', '$2y$12$iCEPRJZz7DIq04N0w2waNeuZThBpKxh4rs02ahzJvZxfzzQJ/zujO', 'Vin', 'Villafrade', '3152782654', 'santigjhgjh@gmail.com', '1775058190.jpeg', 1, 2, NULL, '999001'),
('1005912004', NULL, '$2y$12$ObwJO1oSYusfcd1QRYO0Z.ZFVsVy.j4w/oiXPUa64GWMecLizJw2a', 'Kevin', 'Villafrade', NULL, 'kevindany2209@gmail.com', NULL, 1, 1, NULL, NULL),
('1005912005', '4354353454', '$2y$12$dsRE/4pK1lXTVNdR6zZrtORXIj2m9VEhCDjZEuKmj8funIyPz92AO', 'Kevin', 'Villafradeeee', '3152782654', 'kevindany222209@gmail.com', '1775058168.jpeg', 1, 2, NULL, '999001'),
('1005912006', '9887978978', '$2y$12$OHrgZT0tTor.BZ10PdMIa.5F0tqvEfTKl5hapYaWXDTxRIvMvocBi', 'Daniel', 'Perez', '545466545465', 'nikolas1993838@gmail.com', NULL, 1, 3, 9, NULL),
('1005912008', '9887978978', '$2y$12$gdPanlYye7fzZMveYoQg4Ojx.lFx5NNFOTjbQc0g409wAF1vgvuMi', 'Humber', 'Perez', '3142808076', 'humber@gmail.com', '1774120194.jpeg', 1, 3, 6, NULL),
('1070730214', '9887978978', '$2y$12$qTSxTGQa105rqOxqNJHKduU.GchvUS3rOyXjmmtqXF3GuCcpXO2IW', 'Yuber', 'Paez', '3202534042', 'santiagopc333@gmail.com', NULL, 1, 1, 1, NULL),
('111222', '9887978978', '$2y$12$JXO34Rn2T01QJDy/umFK4uC8AGvyNplq4iXXWKKO7L4afyIBdKJFe', 'Empleado', 'Nuevo', '12312312', 'juangomez123382@gmail.com', '1775061807.jpeg', 1, 3, 1, '123321'),
('123321', '1232131231', '$2y$12$P/RmjOSjgiOVEE3qiDt4UuAQnzSjbDMcDb2G3nMY0FSI8DDZZ8yV.', 'Administrador', 'nuevo', '12313212', 'luisodaniel7@gmail.com', '1775059451.jpeg', 1, 2, NULL, '999001'),
('999001', '9887978978', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'SAdmin', '3009990001', 'lucho3112007@gmail.com', '1775058312.png', 1, 1, 1, NULL),
('999002', '9887978978', '$2y$12$o2SkYB9qoRckMi8EghaVy.NGED0vMGlw8//BWEwsF/qhdLc5iNBSG', 'Super Admin', 'Admin', '3009990002', 'lucho2007311@gmail.com', '1774561101.jpg', 1, 2, 1, '999002'),
('999003', '9887978978', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'Empleado', '3009990003', 'superadmin.empleado@gmail.com', '1775063523.png', 1, 3, 1, '999002');

--
-- Disparadores `empleado`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_empleado_update` AFTER UPDATE ON `empleado` FOR EACH ROW BEGIN
    INSERT INTO auditoria_empleado (
        doc_empleado_afectado, 
        usuario_app,
        usuario_bd, 
        accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.emple_doc, 
        NEW.actualizado_por, -- Capturamos al usuario logueado en tu sistema
        USER(), 
        'ACTUALIZACION',
        JSON_OBJECT(
            'nombres', OLD.emple_nombres,
            'apellidos', OLD.emple_apellidos,
            'correo', OLD.emple_correo,
            'estado', OLD.emple_estado,
            'rol', OLD.emple_rol,
            'area', OLD.emple_area
        ),
        JSON_OBJECT(
            'nombres', NEW.emple_nombres,
            'apellidos', NEW.emple_apellidos,
            'correo', NEW.emple_correo,
            'estado', NEW.emple_estado,
            'rol', NEW.emple_rol,
            'area', NEW.emple_area
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `nit_empresa` varchar(25) NOT NULL,
  `nomb_empresa` varchar(50) NOT NULL,
  `doc_representante` varchar(20) NOT NULL,
  `nomb_representante` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `contacto` varchar(15) DEFAULT NULL,
  `empresa_correo` varchar(150) NOT NULL,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit_empresa`, `nomb_empresa`, `doc_representante`, `nomb_representante`, `direccion`, `contacto`, `empresa_correo`, `actualizado_por`) VALUES
('1232131231', '123 Conduce', '123213', 'dddse es', 'weqwewqewqewq ssdwq2122312', '13231232', 'wwwwqg@gmd.om', NULL),
('4354353454', 'KFC &amp', '38144607', 'Emilio Casas', 'Avenida 37 N12 - 23 fdssfdsdfsdf', '3152782654', 'kfc@gmail.com', '1070730214'),
('4355466554', 'SUBWAY', '5654645645', 'Subway Dueño', 'Cra 12 N37 A16 PRUEBA PORUEBA', '3152782654', 'subway@gmail.com', NULL),
('4565464564', 'LA MAZZA', '38144609', 'Adriana Perez', 'Avenida 37 N12 - 23 Gaitan', '3152782654', 'lamazzaibg@gmail.com', NULL),
('9887978978', '657 Sport', '7866787678', 'Humbert Villein', 'Avenida 37 N12 - 23 fdgfgdgfdgdfgdfgdffgdfdgfgdgfdfdgdfg', '3152782654', '657sports@gmail.com', NULL);

--
-- Disparadores `empresa`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_empresa_update` AFTER UPDATE ON `empresa` FOR EACH ROW BEGIN
    INSERT INTO auditoria_empresa (
        nit_empresa_afectada, 
        usuario_app,
        usuario_bd, 
        accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.nit_empresa, 
        NEW.actualizado_por, -- Capturamos quién modificó la empresa
        USER(), 
        'ACTUALIZACION',
        JSON_OBJECT(
            'nomb_empresa', OLD.nomb_empresa,
            'doc_representante', OLD.doc_representante,
            'nomb_representante', OLD.nomb_representante,
            'direccion', OLD.direccion,
            'contacto', OLD.contacto,
            'empresa_correo', OLD.empresa_correo
        ),
        JSON_OBJECT(
            'nomb_empresa', NEW.nomb_empresa,
            'doc_representante', NEW.doc_representante,
            'nomb_representante', NEW.nomb_representante,
            'direccion', NEW.direccion,
            'contacto', NEW.contacto,
            'empresa_correo', NEW.empresa_correo
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(10) NOT NULL,
  `num_radicado_int` int(20) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `nom_institucion` varchar(255) DEFAULT NULL,
  `nombre_persona` varchar(255) DEFAULT NULL,
  `correo_persona` varchar(255) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `doc_quien_registra` int(15) DEFAULT NULL,
  `doc_quien_envia` varchar(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `destino` varchar(200) DEFAULT NULL,
  `folio` int(20) NOT NULL,
  `id_tipo_envio` int(11) DEFAULT NULL,
  `id_estado_envio` int(10) DEFAULT NULL,
  `archivo` varchar(500) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`id_envio`, `num_radicado_int`, `asunto`, `nom_institucion`, `nombre_persona`, `correo_persona`, `observaciones`, `doc_quien_registra`, `doc_quien_envia`, `fecha`, `destino`, `folio`, `id_tipo_envio`, `id_estado_envio`, `archivo`, `nit_empresa`) VALUES
(37, 85, 'Preuba', NULL, NULL, NULL, 'prueba', NULL, '1005912008', '2026-03-21 19:03:59', 'Interno', 2, 1, 12, 'correspondencia/l6JyCdEkQp8Ehzhy3MkkQwAlXPDb1luI1eyAs4Oc.pdf', '9887978978'),
(38, 86, 'Solicitud prueba', NULL, NULL, NULL, 'prueba', 1005912002, '1005912008', '2026-03-21 19:11:45', 'Ventanilla', 2, 4, 0, 'correspondencia/EtdxfUdFCp7ACQCNunmf3paOlwM0XkuDPOLTHMGO.pdf', '9887978978'),
(39, 87, 'Preuba', NULL, NULL, NULL, 'prueba', NULL, '1005912006', '2026-03-21 19:17:49', 'Interno', 2, 4, 12, 'correspondencia/seSOBPs3VcmgkfYp2PNusZmZiAl7edtg20jpnZAu.pdf', '9887978978'),
(40, 89, 'RESPUESTA: Preuba', NULL, NULL, NULL, NULL, 1234567888, '1005912008', '2026-03-24 21:35:56', 'prueba 1', 1, 1, 12, 'correspondencia/eV31XuDqraU11pJp2ypofCZrNqArP5gbNcO6oCFX.pdf', '9887978978'),
(41, 90, 'Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-25 20:47:16', 'Ventanilla', 7, 3, 9, 'correspondencia/cudw9i9x7jacOnUVbxFpvZSUrFCVTyzOtAmONKPu.pdf', '9887978978'),
(42, 91, 'RESPUESTA: qweqwe', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-27 18:52:17', 'weewer', 1, 3, 12, 'correspondencia/4mpMlL6hW3y9X7eUWQH9DwNnUxove7KlC5zdneUE.pdf', '9887978978'),
(43, 100, 'Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-27 18:56:49', 'mnn', 1, 17, 12, 'correspondencia/enviados/8rv74atyEfQ6CJ6hCDWVpxDW86WP4RwZ3qJkS9n5.pdf', '9887978978'),
(44, 102, 'Prueba', NULL, NULL, NULL, 'Prueba terminada [Correo Notificación: lucho3112007@gmail.com]', 999004, '999003', '2026-03-30 16:22:30', 'Sena', 2, 1, 12, 'correspondencia/BnEG7xoikbHXWORBNHx6ZYIzbL7zfSYTmA3QdD9U.pdf', '9887978978'),
(45, 103, 'RESPUESTA: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-30 16:49:26', 'Luis Alejandro Gomez Feria', 1, 4, 12, 'correspondencia/i1RR1y2eu0BhVFyzTZK1FOerDljXdTe4BqpPSMAE.pdf', '9887978978'),
(46, 105, 'qweqwe', NULL, NULL, NULL, 'Terminado', 999004, '999003', '2026-03-30 19:24:50', 'Luis', 2, 1, 12, 'correspondencia/ZzhhclaWBWxcHHBLH9sMRLafpMaU44qMMjRdsbBF.pdf', '9887978978'),
(47, 106, 'RESPUESTA: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-30 19:35:01', 'Luis Alejandro Gomez Feria', 2, 1, 12, 'correspondencia/fNdubDuxfiDSOvGVQNcnphAj5QJSqG1uGPf5wH3o.pdf', '9887978978'),
(48, 104, 'RESPUESTA: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-31 01:17:47', 'Luis Alejandro Gomez Feria', 2, 4, 12, 'correspondencia/nRnHR1m3li9Wsvu9rx9za1v43gLNNhAKScu88iYs.pdf', '9887978978'),
(49, 101, 'RESPUESTA: pepld', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-31 01:18:08', 'Adriana', 3, 4, 12, 'correspondencia/8P0JHFo5k3gWdtXUooEJS0HqVC9udepTVERpj0wG.pdf', '9887978978'),
(50, 99, 'RESPUESTA: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-31 01:18:21', 'asdsad', 4, 1, 12, 'correspondencia/UynOXUSRdScKm4xy2O8PmFVPQbeqzIG1eqQjPxyj.pdf', '9887978978'),
(51, 97, 'RESPUESTA: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-03-31 01:18:33', 'Luis Alejandro Gomez Feria', 6, 3, 12, 'correspondencia/zHNfhm7lvETIhuYPC7RLpQXkfbEWzZogbTkJl3ET.pdf', '9887978978'),
(53, 115, 'Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 06:56:34', 'Luis Alejandro Gomez Feria', 2, 3, 12, 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', '9887978978'),
(54, 116, 'Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 06:56:50', 'Luis Alejandro Gomez Feria', 2, 3, 12, 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', '9887978978'),
(55, 117, 'Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 06:57:35', 'Luis Alejandro Gomez Feria', 2, 3, 12, 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', '9887978978'),
(56, 118, 'Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 07:06:09', 'Luis Alejandro Gomez Feria', 2, 1, 12, 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', '9887978978'),
(59, 111, 'R: Prueba', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 07:16:38', 'Luis Alejandro Gomez Feria', 2, 1, 12, 'correspondencia/MH0X0ZPW3WQqqH2UGepkRKGYfBinXco6Aw4ZKviH.pdf', '9887978978'),
(61, 114, 'R: Prueba', NULL, NULL, NULL, NULL, 999004, '1005912006', '2026-04-01 07:24:08', 'Luis Alejandro Gomez Feria', 2, 3, 12, 'correspondencia/6tEcy4tfbMomOuYLVzsYypSnb9hnQxmOvWkJ6ph3.pdf', '9887978978'),
(62, 119, 'Pruebasal', NULL, NULL, NULL, NULL, 999004, '999003', '2026-04-01 07:36:50', 'dfsd', 2, 1, 12, 'correspondencia/enviados/bi1i9higX3NLfwdwPFmj82HgBqv6LvJKt3jfK406.pdf', '9887978978'),
(64, 122, 'R: Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999001', '2026-04-01 08:39:20', 'Luis Gomez', 4, 1, 12, 'correspondencia/fkkVRyScD8JOpWaCCvx4l8Ute0zJ0Lx06ENWDn51.pdf', '9887978978'),
(65, 122, 'R: Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999001', '2026-04-01 08:39:42', 'Luis Gomez', 4, 1, 12, 'correspondencia/fkkVRyScD8JOpWaCCvx4l8Ute0zJ0Lx06ENWDn51.pdf', '9887978978'),
(66, 120, 'R: Rpta: Prueba', NULL, NULL, NULL, NULL, 999004, '999001', '2026-04-01 09:18:46', 'Luis Gomez', 2, 1, 12, '', '9887978978'),
(67, 124, 'Prueba', NULL, NULL, NULL, '', 999004, '999003', '2026-04-01 15:43:52', 'Ventanilla', 3, 1, 9, 'correspondencia/FR5rtmHUq7zp2dX1w8x6jTh0hKMM1QjB2wlTm7WR.pdf', '9887978978'),
(68, 125, 'Prueba', NULL, NULL, NULL, '', 999004, '999003', '2026-04-01 15:43:46', 'Ventanilla', 13, 1, 9, 'correspondencia/wVb5OQe9gUKt4ocSkfX6wWD1dmcJ7NrTW4cR8yiM.pdf', '9887978978'),
(69, 127, 'Prueba', NULL, NULL, NULL, 'prueba', NULL, '999003', '2026-04-01 17:33:36', 'Interno', 13, 1, 12, 'correspondencia/WqrKYQvaT7zZsefyc09q4xvJKw6KN3qJxbz18dyj.pdf', '9887978978'),
(70, 128, 'PRUEBA', NULL, NULL, NULL, 'prueba', NULL, '111222', '2026-04-01 18:15:25', 'Interno', 2, 1, 8, 'correspondencia/h7rt70sbbBC8CAvP8Vrmxa9gmHA8FLgns8xFZJmw.pdf', '9887978978');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(20) NOT NULL,
  `estado_nomb` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estado_nomb`) VALUES
(0, 'En espera'),
(1, 'Activo'),
(2, 'Inactivo'),
(4, 'Aprobado'),
(5, 'No Aprobado'),
(7, 'Recibido'),
(8, 'En Tramite'),
(9, 'Resuelto'),
(10, 'Archivado'),
(11, 'Rechazado'),
(12, 'Enviado'),
(13, 'Digitalizado'),
(14, 'Saliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `id_licencia` int(11) NOT NULL,
  `id_estado` int(20) NOT NULL,
  `id_pago` int(10) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `tipo_licencia` enum('ACTIVACION','RENOVACION') NOT NULL,
  `licencia_origen` int(11) DEFAULT NULL,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `id_estado`, `id_pago`, `fecha_inicio`, `fecha_fin`, `tipo_licencia`, `licencia_origen`, `actualizado_por`) VALUES
(27, 1, 55, '2026-02-27 12:00:22', '2026-05-28 12:00:22', 'ACTIVACION', NULL, NULL),
(30, 1, 56, '2026-05-28 12:00:22', '2026-08-26 12:00:22', 'RENOVACION', 27, NULL),
(31, 1, 59, '2026-08-26 12:00:22', '2026-09-25 12:00:22', 'RENOVACION', 30, NULL),
(32, 1, 58, '2026-09-25 12:00:22', '2026-10-25 12:00:22', 'RENOVACION', 31, NULL),
(34, 1, 61, '2026-03-02 22:49:42', '2026-03-10 22:49:42', 'ACTIVACION', NULL, '1070730214'),
(35, 1, 62, '2026-03-11 14:23:37', '2027-03-11 14:23:37', 'ACTIVACION', NULL, NULL),
(36, 1, 63, '2027-03-11 14:23:37', '2028-03-10 14:23:37', 'RENOVACION', 35, NULL),
(37, 1, 64, '2026-10-25 12:00:22', '2027-04-23 12:00:22', 'RENOVACION', 32, NULL),
(38, 1, 65, '2028-03-10 14:23:37', '2028-04-09 14:23:37', 'RENOVACION', 36, NULL),
(39, 1, 66, '2026-04-01 00:00:00', '2026-09-28 00:00:00', 'ACTIVACION', NULL, NULL);

--
-- Disparadores `licencia`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_licencia_update` AFTER UPDATE ON `licencia` FOR EACH ROW BEGIN
    INSERT INTO auditoria_licencia (
        id_licencia_afectada, 
        usuario_app,
        usuario_bd, 
        accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.id_licencia, 
        NEW.actualizado_por, -- Capturamos quién modificó la licencia
        USER(), 
        'ACTUALIZACION',
        JSON_OBJECT(
            'id_estado', OLD.id_estado,
            'id_pago', OLD.id_pago,
            'fecha_inicio', OLD.fecha_inicio,
            'fecha_fin', OLD.fecha_fin,
            'tipo_licencia', OLD.tipo_licencia,
            'licencia_origen', OLD.licencia_origen
        ),
        JSON_OBJECT(
            'id_estado', NEW.id_estado,
            'id_pago', NEW.id_pago,
            'fecha_inicio', NEW.fecha_inicio,
            'fecha_fin', NEW.fecha_fin,
            'tipo_licencia', NEW.tipo_licencia,
            'licencia_origen', NEW.licencia_origen
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_16_162424_create_password_codes_table', 2),
(5, '2026_03_13_213627_add_visto_to_detalles_tables', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(10) NOT NULL,
  `id_plan` int(10) DEFAULT NULL,
  `comprobante` varchar(500) DEFAULT NULL,
  `id_admin` varchar(20) NOT NULL,
  `nit_empresa` varchar(20) DEFAULT NULL,
  `monto` decimal(15,2) DEFAULT 0.00,
  `moneda` varchar(10) DEFAULT NULL,
  `id_est_pago` int(10) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_plan`, `comprobante`, `id_admin`, `nit_empresa`, `monto`, `moneda`, `id_est_pago`, `fecha_pago`, `fecha_inicio`, `actualizado_por`) VALUES
(55, 5, NULL, '1005912006', '9887978978', 540000.00, 'COP', 4, '2026-02-27 11:59:10', NULL, NULL),
(56, 5, NULL, '1005912006', '9887978978', 540000.00, 'COP', 4, '2026-02-27 12:01:04', NULL, NULL),
(57, 6, NULL, '1005912005', '4354353454', 1040000.00, 'COP', 4, '2026-02-27 12:01:17', NULL, NULL),
(58, 4, NULL, '1005912006', '9887978978', 200000.00, 'COP', 4, '2026-02-27 12:05:03', NULL, NULL),
(59, 4, NULL, '1005912006', '9887978978', 200000.00, 'COP', 4, '2026-02-27 12:05:09', NULL, NULL),
(60, 10, NULL, '1005912005', '4354353454', 1950000.00, 'COP', 4, '2026-02-27 12:06:40', NULL, NULL),
(61, 4, NULL, '1005912003', '9887978978', 200000.00, 'COP', 4, '2026-03-02 22:49:33', NULL, NULL),
(62, 10, NULL, '999002', '9887978978', 1950000.00, 'COP', 4, '2026-03-11 14:23:11', NULL, NULL),
(63, 10, NULL, '999002', '9887978978', 1950000.00, 'COP', 4, '2026-03-13 13:56:21', NULL, '1070730214'),
(64, 6, NULL, '1005912003', '9887978978', 1040000.00, 'COP', 4, '2026-03-20 14:37:12', NULL, '1070730214'),
(65, 4, 'comprobantes/d8sMWq2R0zBrS0xVbWTeh7zoke2dbq9xFEYyBlV3.jpg', '1005912003', '9887978978', 200000.00, 'COP', 4, '2026-03-20 14:55:17', NULL, '999001'),
(66, 6, 'comprobantes/P4EiObGajpnFHt9KLMk2RoZIyToAVka2nj9mG27T.jpg', '123321', '1232131231', 1040000.00, 'COP', 4, '2026-04-01 11:17:01', '2026-04-01 00:00:00', '999001');

--
-- Disparadores `pagos`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_pagos_update` AFTER UPDATE ON `pagos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_pagos (
        id_pago_afectado, 
        usuario_app,
        usuario_bd, 
        accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.id_pago, 
        NEW.actualizado_por, -- Capturamos quién modificó el pago
        USER(), 
        'ACTUALIZACION',
        JSON_OBJECT(
            'id_plan', OLD.id_plan,
            'comprobante', OLD.comprobante,
            'id_admin', OLD.id_admin,
            'moneda', OLD.moneda,
            'id_est_pago', OLD.id_est_pago,
            'fecha_pago', OLD.fecha_pago,
            'fecha_inicio', OLD.fecha_inicio
        ),
        JSON_OBJECT(
            'id_plan', NEW.id_plan,
            'comprobante', NEW.comprobante,
            'id_admin', NEW.id_admin,
            'moneda', NEW.moneda,
            'id_est_pago', NEW.id_est_pago,
            'fecha_pago', NEW.fecha_pago,
            'fecha_inicio', NEW.fecha_inicio
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_codes`
--

CREATE TABLE `password_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `emple_correo` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan`
--

CREATE TABLE `plan` (
  `id_plan` int(10) NOT NULL,
  `nomb_plan` varchar(50) NOT NULL,
  `valor` int(12) NOT NULL,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`descripcion`)),
  `duracion` int(10) DEFAULT NULL,
  `es_destacado` tinyint(1) NOT NULL DEFAULT 0,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plan`
--

INSERT INTO `plan` (`id_plan`, `nomb_plan`, `valor`, `descripcion`, `duracion`, `es_destacado`, `actualizado_por`) VALUES
(4, 'Mensual', 200000, '[\"Acceso completo al sistema.\",\"Soporte básico.\",\"Garantía 7 días.\"]', 30, 0, NULL),
(5, 'Trimestral', 540000, '[\"Acceso completo al sistema.\",\"Soporte prioritario.\",\"Garantía 14 días.\", \"Incluye 1 capacitación.\"]', 90, 0, NULL),
(6, 'Semestral', 1040000, '[\"Acceso completo al sistema.\",\"Soporte prioritario extendido.\",\"Garantía 30 días.\", \"Incluye 2 capacitaciones.\"]\r\n', 180, 1, '1070730214'),
(10, 'Anual', 1950000, '[\"Acceso completo al sistema.\",\"Soporte prioritario exclusivo.\",\"Garant\\u00eda 60 d\\u00edas.\",\"Incluye 6 capacitaciones.\"]', 365, 0, NULL);

--
-- Disparadores `plan`
--
DELIMITER $$
CREATE TRIGGER `trg_auditoria_plan_update` AFTER UPDATE ON `plan` FOR EACH ROW BEGIN
    INSERT INTO auditoria_plan (
        id_plan_afectado, 
        usuario_app,
        usuario_bd, 
        accion, 
        datos_anteriores, 
        datos_nuevos
    ) VALUES (
        OLD.id_plan, 
        NEW.actualizado_por, -- Capturamos quién modificó el plan
        USER(), 
        'ACTUALIZACION',
        JSON_OBJECT(
            'nomb_plan', OLD.nomb_plan,
            'valor', OLD.valor,
            'descripcion', OLD.descripcion,
            'duracion', OLD.duracion,
            'es_destacado', OLD.es_destacado
        ),
        JSON_OBJECT(
            'nomb_plan', NEW.nomb_plan,
            'valor', NEW.valor,
            'descripcion', NEW.descripcion,
            'duracion', NEW.duracion,
            'es_destacado', NEW.es_destacado
        )
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prioridad`
--

CREATE TABLE `prioridad` (
  `id_prioridad` int(20) NOT NULL,
  `prioridad_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prioridad`
--

INSERT INTO `prioridad` (`id_prioridad`, `prioridad_nombre`) VALUES
(1, 'Alta'),
(2, 'Media'),
(3, 'Baja'),
(4, 'Urgente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `radicados`
--

CREATE TABLE `radicados` (
  `id_radicado` int(10) NOT NULL,
  `num_radicado` varchar(20) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `radicados`
--

INSERT INTO `radicados` (`id_radicado`, `num_radicado`, `nit_empresa`) VALUES
(85, 'INT-2026-00001', '9887978978'),
(86, 'SAL-2026-00001', '9887978978'),
(87, 'INT-2026-00002', '9887978978'),
(88, 'INT-2026-00003', '9887978978'),
(89, 'INT-2026-00004', '9887978978'),
(90, 'SAL-2026-00002', '9887978978'),
(91, 'INT-2026-00005', '9887978978'),
(92, '20261000000001', '4354353454'),
(93, '20261000000002', '4354353454'),
(94, '20261000000003', '4354353454'),
(95, '20261000000004', '4354353454'),
(96, '20261000000005', '4354353454'),
(97, 'INT-2026-00006', '9887978978'),
(98, 'INT-2026-00007', '9887978978'),
(99, 'INT-2026-00008', '9887978978'),
(100, 'INT-2026-00009', '9887978978'),
(101, 'INT-2026-00010', '9887978978'),
(102, 'SAL-2026-00003', '9887978978'),
(103, 'INT-2026-00011', '9887978978'),
(104, 'INT-2026-00012', '9887978978'),
(105, 'SAL-2026-00004', '9887978978'),
(106, 'INT-2026-00013', '9887978978'),
(107, 'INT-2026-00014', '9887978978'),
(108, 'EXT-2026-00001', '9887978978'),
(109, 'EXT-2026-00002', '9887978978'),
(110, 'EXT-2026-00003', '9887978978'),
(111, 'EXT-2026-00004', '9887978978'),
(112, 'EXT-2026-00001', '4565464564'),
(114, 'EXT-2026-00005', '9887978978'),
(115, 'SAL-2026-00005', '9887978978'),
(116, 'SAL-2026-00006', '9887978978'),
(117, 'SAL-2026-00007', '9887978978'),
(118, 'SAL-2026-00008', '9887978978'),
(119, 'SAL-2026-00009', '9887978978'),
(120, 'EXT-2026-00006', '9887978978'),
(121, 'EXT-2026-00007', '9887978978'),
(122, 'EXT-2026-00008', '9887978978'),
(123, 'EXT-2026-00009', '9887978978'),
(124, 'SAL-2026-00010', '9887978978'),
(125, 'SAL-2026-00011', '9887978978'),
(126, 'EXT-2026-00010', '9887978978'),
(127, 'INT-2026-00015', '9887978978'),
(128, 'INT-2026-00016', '9887978978');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibido`
--

CREATE TABLE `recibido` (
  `id_recibido` int(20) NOT NULL,
  `num_radicado_ext` varchar(20) DEFAULT NULL,
  `num_radicado_int` int(10) NOT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `fecha_hora_recib` datetime DEFAULT NULL,
  `nom_institucion` varchar(150) DEFAULT NULL,
  `ciudad_proveniente` varchar(20) NOT NULL,
  `folio` int(20) NOT NULL,
  `anexo` varchar(500) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `doc_quien_registra` int(20) DEFAULT NULL,
  `id_tipo` int(20) DEFAULT NULL,
  `id_estado_rec` int(10) DEFAULT NULL,
  `archivo` varchar(500) DEFAULT NULL,
  `nit_empresa` varchar(25) NOT NULL,
  `nombre_persona` varchar(100) DEFAULT NULL,
  `doc_persona` varchar(20) DEFAULT NULL,
  `correo_persona` varchar(255) DEFAULT NULL,
  `tel_persona` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recibido`
--

INSERT INTO `recibido` (`id_recibido`, `num_radicado_ext`, `num_radicado_int`, `asunto`, `fecha_hora_recib`, `nom_institucion`, `ciudad_proveniente`, `folio`, `anexo`, `observaciones`, `doc_quien_registra`, `id_tipo`, `id_estado_rec`, `archivo`, `nit_empresa`, `nombre_persona`, `doc_persona`, `correo_persona`, `tel_persona`) VALUES
(39, 'ext-12345', 88, 'Preuba', '2026-03-24 16:31:14', 'Alcaldia', '63001', 2, NULL, 'ninguna', 1234567888, 1, 9, 'correspondencia/MkhDavo6EA7lRwkVayr3h0oNfvinlSR2ZWIkk9aM.pdf', '9887978978', NULL, '1234568', NULL, NULL),
(40, 'ext-12345', 89, 'Preuba', '2026-03-24 16:33:24', 'prueba 1', '05001', 1, NULL, 'prueba', 1234567888, 1, 14, 'correspondencia/HBDT5wLLutbmRBQL3kQylpE9yvKWm3Hcvz0oEEFh.pdf', '9887978978', NULL, '1234568', NULL, NULL),
(41, NULL, 91, 'qweqwe', '2026-03-25 15:50:41', NULL, '81001', 6, NULL, 'ss', 999004, 3, 14, 'correspondencia/zb8lKhFi62tx5BrBHP7v8WWahdURkBqsFp2bfvYg.pdf', '9887978978', 'weewer', '12321321', 'correo@gmail.com', NULL),
(42, NULL, 97, 'Prueba', '2026-03-25 16:48:58', NULL, '73585', 7, NULL, 'C', 999004, 3, 14, 'correspondencia/YADkXZESS1IZcZVPXrMtiMfuyPM75KtCuOp1OsFw.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(43, NULL, 98, 'Prueba', '2026-03-27 13:43:17', NULL, '73585', 7, NULL, 'CE 1106394865 - iiiii', 999004, 3, 10, 'correspondencia/X0P986Tzx1PQZrTojpC7jdfLwguSCm1RCSm6TT8X.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(44, 'RAD-123213', 99, 'Prueba', '2026-03-27 13:45:02', 'asdsad', '54003', 7, NULL, 'NIT 23213213 - asdsads', 999004, 1, 14, 'correspondencia/mIY1A4194f721myPdQ1OJtcFlUhA3ZEdC5MPgdM4.pdf', '9887978978', NULL, '23213213', 'lucho3112007@gmail.com', '3153524586'),
(45, NULL, 101, 'pepld', '2026-03-28 15:15:34', NULL, '73585', 6, NULL, 'CC 1104940867 - sgdfsd', 999004, 4, 14, 'correspondencia/B2iFrz2UQWXWL4CSD5DUyO6ww0h4SrTj5XTYjXyG.pdf', '9887978978', 'Adriana', '1104940867', 'tabaresadriana1113@gmail.com', '3204219314'),
(46, NULL, 103, 'Prueba', '2026-03-30 11:03:06', NULL, '73585', 4, NULL, 'CC 1106394865 - Prueba', 999004, 4, 14, 'correspondencia/KvOqPb1PkRxO5CJmrSsngpJxgii5K6CSqtSHGFbl.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(47, NULL, 104, 'Prueba', '2026-03-30 12:23:37', NULL, '73585', 3, NULL, 'Prueba', 999004, 4, 14, 'correspondencia/yk0XzqCxsRgXJ5gPSOn8oUELaprIICH1IdkWehag.pdf', '9887978978', 'Luis Alejandro Gomez Feria', 'CC 1106394865', 'lucho3112007@gmail.com', '3153524586'),
(48, NULL, 106, 'Prueba', '2026-03-30 14:17:44', NULL, '73001', 5, NULL, 'CC 1106394865 - prueba', 999004, 1, 14, 'correspondencia/GHWjJk8xJRRwhcnnlfpieg2LcT23IQ7g966HbZQV.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(49, NULL, 107, 'Prueba', '2026-03-30 19:55:34', NULL, '19622', 5, NULL, 'CC 1106394865 - prueba', 999004, 1, 10, 'correspondencia/o4jjaWcPo3lx65dIX608033V9pyFRv5g1evGkip4.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(50, NULL, 108, 'Prueba', '2026-03-30 20:39:50', NULL, '54003', 7, NULL, 'CC 1106394865 - aaaa', 999004, 1, 7, 'correspondencia/k9v7TXpNcseBIhPHKdnAm1fCjNAzrylQahoe6abL.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(51, 'wqewqe', 109, 'Prueba', '2026-03-31 20:15:05', 'Luis Gomez', '05002', 15, NULL, 'wswa', 999004, 1, 7, 'correspondencia/jLaixhCK4T1t1b1SYjIGPajlX8Vr8RElnQbuN5H2.pdf', '9887978978', NULL, '2132321', 'lucho3112007@gmail.com', NULL),
(52, NULL, 110, 'Prueba', '2026-03-31 20:33:25', NULL, '05002', 14, NULL, 'sdfds', 999004, 1, 7, 'correspondencia/lvqohol0goVOR7V1O7Zp20LznhjLp5bwqaOBpdC9.pdf', '9887978978', 'Luis Alejandro Gomez Feria', 'CC 1106394865', 'lucho3112007@gmail.com', '31232321'),
(53, NULL, 111, 'Prueba', '2026-03-31 23:10:22', NULL, '05002', 2, NULL, 'www', 999004, 1, 9, 'correspondencia/wdlJu9gt9RXN3w1c0sLjFCFOJywY8qxDUctIqZ3o.pdf', '9887978978', 'Luis Alejandro Gomez Feria', 'CC 1106394865', 'lucho3112007@gmail.com', '31232321'),
(54, NULL, 112, 'Pruebaa', '2026-03-31 23:18:00', NULL, '05002', 2, NULL, 'CC 1106394865 - sasaa', NULL, 3, 12, 'correspondencia/oOnvxz4IuJq6q27NjiQkpUyz1S99tuWbmrN2JRME.pdf', '4565464564', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(55, NULL, 114, 'Prueba', '2026-04-01 01:33:45', NULL, '05002', 2, NULL, 'CC 1106394865 - asas', 999004, 3, 9, 'correspondencia/knVRGvCCLmCV0CrtZxccIxWiLGS3XFJRTyavLX1o.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(56, 'wqewqe', 120, 'Rpta: Prueba', '2026-04-01 03:05:17', 'Luis Gomez', '05002', 2, NULL, 'ewrewr', 999004, NULL, 9, 'correspondencia/wENatZ4mHbbwXdIkRiEsUNg7hUVR0qzPVhm0MnAs.pdf', '9887978978', NULL, '23432', 'lucho3112007@gmail.com', NULL),
(57, NULL, 121, 'Rpta: Prueba', '2026-04-01 03:09:39', NULL, '05002', 2, NULL, 'dfdsf', 999004, 1, 10, 'correspondencia/6t7L2gcNaADOj8WFJIJGXt2u3OUfqye2ibmZ8UG7.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(58, 'wqewqe', 122, 'Rpta: Prueba', '2026-04-01 03:29:49', 'Luis Gomez', '05002', 4, NULL, 'sdfd', 999004, 1, 9, 'correspondencia/YIb5S8QhulYK2FQmhIzlgTNOSbjSP5cRER9V0pU9.pdf', '9887978978', NULL, '2132321', 'lucho3112007@gmail.com', NULL),
(59, NULL, 123, 'Prueba', '2026-04-01 04:18:03', NULL, '05002', 3, NULL, 'CC 1106394865 - asdsad', 999004, 1, 10, 'correspondencia/An22AuNfo17xWrCakLfqcAgZasS0pfVkcG9zQsZw.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586'),
(60, NULL, 126, 'Prueba', '2026-04-01 12:22:35', NULL, '05002', 3, NULL, 'CC 1106394865 - Prueba', NULL, 1, 12, 'correspondencia/Uy3oJDLjyOO42DUthMiPMayBjLPIelfBrTc0HNdv.pdf', '9887978978', 'Luis Alejandro Gomez Feria', '1106394865', 'lucho3112007@gmail.com', '3153524586');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitente`
--

CREATE TABLE `remitente` (
  `rem_doc` int(20) NOT NULL,
  `nit_empresa` varchar(25) DEFAULT NULL,
  `rem_nombres` varchar(50) NOT NULL,
  `rem_apellidos` varchar(50) NOT NULL,
  `rem_correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rem_tel` varchar(20) NOT NULL,
  `rem_ciudad` varchar(10) NOT NULL,
  `rem_estado` int(10) NOT NULL,
  `rem_img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `remitente`
--

INSERT INTO `remitente` (`rem_doc`, `nit_empresa`, `rem_nombres`, `rem_apellidos`, `rem_correo`, `password`, `rem_tel`, `rem_ciudad`, `rem_estado`, `rem_img`) VALUES
(112233, '1232131231', 'Ventanilla', 'Nuevo', 'didl3509lg@gmail.com', '$2y$12$BZn05oeS3xya9MKu/JEO3.D.P27sPZUlS..DolCV.kAC3ELId8sBW', '3123213', '05001', 1, '1775061715.jpeg'),
(999004, '9887978978', 'Super Admin', 'Remitente', 'superadmin.remitente@gmail.com', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', '3000000000', '11001', 1, ''),
(12345678, '9887978978', 'Luis', 'Gomez', 'hgrfdfjfs@gmai.com', '$2y$12$r4jQ3pheW4tmFddEZomcnu0YK0L7nQHLZOq3x9vuEH3JxrxiAKJZG', '3153524586', '05002', 1, '1774561080.jpeg'),
(1005912002, '9887978978', 'Vin', 'Vin', 'kevinvin@gmail.com', '$2y$12$mMdpWhFKAQK9O3h0RYtIYeQIDe4AooSX7qchFGeb./geZQdiLww0W', '3873483743', '05001', 1, ''),
(1234567822, '4354353454', 'Luis', 'Gomez', 'hgjfs@gmai.com', '$2y$12$6Xx.BM2cqfS2dFvuytrpI.BOGT9ZMHjMl9AwEFUyefXake12CYLT2', '3153524586', '11001', 1, '1774468189.jpeg'),
(1234567888, '9887978978', 'Kevin', 'Daniel', 'kevin.daniel@gmail.com', '$2y$12$V/kBOsNQ33fJEcmod3oG.e2F/VDOtKa3dzc6TQjvpuTBb4WXy6DPe', '3001234567', '11001', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(20) NOT NULL,
  `rol_nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `rol_nom`) VALUES
(1, 'SuperAdmin'),
(2, 'AdminEmpresa'),
(3, 'Empleado'),
(7, 'SuperAdministrador'),
(8, 'Administrador'),
(9, 'Usuario Estandar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DpLLw4A0kmkrw1pW5g5Zf6Ove0KUZJDPZEx8pu4j', 999003, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZGFreXZVSU1LT21qMjh3U29jQnpvcWhoMmlhTEozRndXVE5UQW1iQSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2VtcGxlYWRvL2NvcnJlc3BvbmRlbmNpYS1maW5hbGl6YWRhIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsZWFkby9jb3JyZXNwb25kZW5jaWEtcmVjaWJpZGEiO3M6NToicm91dGUiO3M6MzM6ImVtcGxlYWRvLmNvcnJlc3BvbmRlbmNpYV9yZWNpYmlkYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjY6Ijk5OTAwMyI7fQ==', 1775067326),
('jO495XIA2zrQftR6Lv9EXNzl3qc5LKHNGQniy05r', 123321, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ2JFaHBIcTBKcFNHb21NcXNLUGFYT1RpMTIyZDU0blpDSFc5WnpVQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3JyZXNwb25kZW5jaWEiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLmNvcnJlc3BvbmRlbmNpYSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjY6IjEyMzMyMSI7fQ==', 1775063556),
('LSgscjngcD65sz7vvMeMFlxSyAD3sLnMwKpHvI5Z', 999001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib1d6bW15ZGtxbXNLWmgwR0oxYllUQ1ZLbWtQdjdheVdRTkxBNjdGUiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3BsYW5lcyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc2FkbWluL3BhZ29zIjtzOjU6InJvdXRlIjtzOjEyOiJzYWRtaW4ucGFnb3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czo2OiI5OTkwMDEiO30=', 1775061488),
('PYkww6lidzC7fayv1tUgS43L1JhGaPPEidZVEqwD', 111222, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieGs5UVF2cGJxZGJJbThMY0Rna3hHNXZPc2pNYlV0MDdCYXZCc1VsWSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NhZG1pbi9wYWdvcyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW1wbGVhZG8vY29ycmVzcG9uZGVuY2lhLXJlY2liaWRhIjtzOjU6InJvdXRlIjtzOjMzOiJlbXBsZWFkby5jb3JyZXNwb25kZW5jaWFfcmVjaWJpZGEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czo2OiIxMTEyMjIiO30=', 1775065279),
('svhON1HIuamPnEjTWTm0gHW7F0KkMUjDoUctuxJv', 999002, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic3NEaFgyMURkYmZxS3Fpcms5VkNuM0FTSFRGT0Vmazl3QW1UYXoxMyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3JyZXNwb25kZW5jaWEvZW52aW8vNDEvZXN0YWRvIjtzOjU6InJvdXRlIjtzOjM0OiJhZG1pbi5jb3JyZXNwb25kZW5jaWEuZXN0YWRvX2VudmlvIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6NjoiOTk5MDAyIjt9', 1775067618),
('WAR0M2PL3a37uXBveRVAAGNZ9bOhJk2rNpWIicK7', 999004, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSU5zeUZIbVd1a3pVYmd4dW04T3Nncml3eUR1a1hPOHp4MVhxU2taSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92ZW50YW5pbGxhL2hpc3RvcnkvMTI2P3R5cGU9RVhUIjtzOjU6InJvdXRlIjtzOjE4OiJ2ZW50YW5pbGxhLmhpc3RvcnkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9yZW1pdGVudGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo5OTkwMDQ7fQ==', 1775067435);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(20) NOT NULL,
  `tipo_nombre` varchar(100) DEFAULT NULL,
  `id_prioridad` int(10) DEFAULT NULL,
  `dias_respuesta` int(11) DEFAULT NULL,
  `requiere_respuesta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo_nombre`, `id_prioridad`, `dias_respuesta`, `requiere_respuesta`) VALUES
(1, 'Derecho de Peticion', 4, 15, 1),
(3, 'Reclamo', 1, 15, 1),
(4, 'Solicitud', 2, 15, 1),
(5, 'Carta', 2, 15, 1),
(6, 'Memorando', 2, 5, 1),
(7, 'Circular', 3, 0, 0),
(8, 'Resolucion', 3, 0, 0),
(9, 'Contrato', 1, 5, 1),
(10, 'Queja', 1, 15, 1),
(11, 'Peticion de Informacion', 1, 10, 1),
(12, 'Peticion de Consulta', 2, 30, 1),
(13, 'Denuncia', 4, 15, 1),
(14, 'Sugerencia', 2, 15, 1),
(15, 'Felicitacion', 3, 0, 0),
(16, 'Oficio', 2, 15, 1),
(17, 'Decreto / Acuerdo', 3, 0, 0),
(18, 'Acta', 3, 0, 0),
(19, 'Informe', 2, 0, 0),
(20, 'Accion de Tutela', 4, 2, 1),
(21, 'Notificacion Judicial', 4, 5, 1),
(22, 'Citacion', 4, 5, 1),
(23, 'Requerimiento', 4, 10, 1),
(24, 'Factura Electronica', 1, 3, 1),
(25, 'Cuenta de Cobro', 2, 5, 1),
(26, 'Cotizacion', 2, 5, 1),
(27, 'Orden de Compra', 1, 3, 1),
(28, 'Poliza / Garantia', 3, 0, 0),
(29, 'Propuesta / Licitacion', 1, 5, 1),
(30, 'Comprobante Contable', 3, 0, 0),
(31, 'Incapacidad Medica', 4, 3, 1),
(32, 'Hoja de Vida', 3, 0, 0),
(33, 'Carta de Renuncia', 1, 1, 1),
(34, 'Solicitud Certificado Laboral', 2, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-02-04 19:18:51', '$2y$12$pORhz2NEzasz12jNPTbBGuoiwM0BYLMMsNZohKEEo7.llJt3qazoS', 'D29faiXApN', '2026-02-04 19:18:54', '2026-02-04 19:18:54');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anexo_envio`
--
ALTER TABLE `anexo_envio`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `id_envio` (`id_envio`);

--
-- Indices de la tabla `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `id_recibido_idx` (`id_recibido`);

--
-- Indices de la tabla `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  ADD PRIMARY KEY (`id_anexo_resp`),
  ADD KEY `id_detalle_idx` (`id_detalle`),
  ADD KEY `fk_anexo_resp_interna` (`id_det_interna`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `auditoria_empleado`
--
ALTER TABLE `auditoria_empleado`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `auditoria_empresa`
--
ALTER TABLE `auditoria_empresa`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `auditoria_licencia`
--
ALTER TABLE `auditoria_licencia`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `auditoria_pagos`
--
ALTER TABLE `auditoria_pagos`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `auditoria_plan`
--
ALTER TABLE `auditoria_plan`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indices de la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`ciudad_cod_post`),
  ADD KEY `ciudad_id_dpto` (`ciudad_id_dpto`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`dpto_codigo_postal`);

--
-- Indices de la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_quien_envie` (`id_quien_envie`),
  ADD KEY `id_quien_recibe` (`id_quien_recibe`),
  ADD KEY `id_estado_rec` (`id_estado_rec`);

--
-- Indices de la tabla `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  ADD PRIMARY KEY (`id_det_recibido`),
  ADD KEY `det_doc_empleado` (`det_doc_empleado`),
  ADD KEY `det_id_recibido` (`det_id_recibido`),
  ADD KEY `id_estado_rec` (`id_estado_rec`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`emple_doc`),
  ADD KEY `emple_estado` (`emple_estado`),
  ADD KEY `emple_rol` (`emple_rol`),
  ADD KEY `emple_area` (`emple_area`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`nit_empresa`),
  ADD KEY `id_representante` (`doc_representante`);

--
-- Indices de la tabla `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `doc_quien_envia` (`doc_quien_envia`),
  ADD KEY `id_tipo_envio` (`id_tipo_envio`),
  ADD KEY `id_estado_envio` (`id_estado_envio`),
  ADD KEY `envio_ibfk_1` (`doc_quien_registra`),
  ADD KEY `num_radicado_int` (`num_radicado_int`),
  ADD KEY `fk_empresa_envio` (`nit_empresa`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_est_pago` (`id_est_pago`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indices de la tabla `password_codes`
--
ALTER TABLE `password_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indices de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id_prioridad`);

--
-- Indices de la tabla `radicados`
--
ALTER TABLE `radicados`
  ADD PRIMARY KEY (`id_radicado`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indices de la tabla `recibido`
--
ALTER TABLE `recibido`
  ADD PRIMARY KEY (`id_recibido`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_estado_rec` (`id_estado_rec`),
  ADD KEY `doc_quien_registra` (`doc_quien_registra`),
  ADD KEY `num_radicado_int` (`num_radicado_int`),
  ADD KEY `ciudad_proveniente` (`ciudad_proveniente`),
  ADD KEY `fk_empresa_recibido` (`nit_empresa`);

--
-- Indices de la tabla `remitente`
--
ALTER TABLE `remitente`
  ADD PRIMARY KEY (`rem_doc`),
  ADD KEY `rem_ciudad` (`rem_ciudad`),
  ADD KEY `rem_estado` (`rem_estado`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`),
  ADD KEY `id_prioridad` (`id_prioridad`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anexo_envio`
--
ALTER TABLE `anexo_envio`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  MODIFY `id_anexo_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `auditoria_empleado`
--
ALTER TABLE `auditoria_empleado`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `auditoria_empresa`
--
ALTER TABLE `auditoria_empresa`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `auditoria_licencia`
--
ALTER TABLE `auditoria_licencia`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `auditoria_pagos`
--
ALTER TABLE `auditoria_pagos`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `auditoria_plan`
--
ALTER TABLE `auditoria_plan`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  MODIFY `id_det_recibido` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `password_codes`
--
ALTER TABLE `password_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `plan`
--
ALTER TABLE `plan`
  MODIFY `id_plan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id_prioridad` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `radicados`
--
ALTER TABLE `radicados`
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `recibido`
--
ALTER TABLE `recibido`
  MODIFY `id_recibido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anexo_envio`
--
ALTER TABLE `anexo_envio`
  ADD CONSTRAINT `fk_anexo_envio` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  ADD CONSTRAINT `fk_anexo_recibido` FOREIGN KEY (`id_recibido`) REFERENCES `recibido` (`id_recibido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  ADD CONSTRAINT `fk_anexo_resp_interna` FOREIGN KEY (`id_det_interna`) REFERENCES `detalle_envio` (`id_detalle`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_anexo_respuesta` FOREIGN KEY (`id_detalle`) REFERENCES `detalle_recibido` (`id_det_recibido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`ciudad_id_dpto`) REFERENCES `departamento` (`dpto_codigo_postal`);

--
-- Filtros para la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD CONSTRAINT `detalle_envio_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`),
  ADD CONSTRAINT `detalle_envio_ibfk_2` FOREIGN KEY (`id_quien_envie`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_envio_ibfk_3` FOREIGN KEY (`id_quien_recibe`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_envio_ibfk_4` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  ADD CONSTRAINT `detalle_recibido_ibfk_1` FOREIGN KEY (`det_doc_empleado`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_recibido_ibfk_2` FOREIGN KEY (`det_id_recibido`) REFERENCES `recibido` (`id_recibido`),
  ADD CONSTRAINT `detalle_recibido_ibfk_3` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`emple_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`emple_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `empleado_ibfk_3` FOREIGN KEY (`emple_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `empleado_ibfk_4` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Filtros para la tabla `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`doc_quien_registra`) REFERENCES `remitente` (`rem_doc`),
  ADD CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`doc_quien_envia`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `envio_ibfk_4` FOREIGN KEY (`id_tipo_envio`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `envio_ibfk_5` FOREIGN KEY (`id_estado_envio`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `envio_ibfk_6` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`),
  ADD CONSTRAINT `fk_empresa_envio` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Filtros para la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `licencia_ibfk_6` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `plan` (`id_plan`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_est_pago`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `pagos_ibfk_4` FOREIGN KEY (`id_admin`) REFERENCES `empleado` (`emple_doc`);

--
-- Filtros para la tabla `radicados`
--
ALTER TABLE `radicados`
  ADD CONSTRAINT `radicados_ibfk_2` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Filtros para la tabla `recibido`
--
ALTER TABLE `recibido`
  ADD CONSTRAINT `fk_empresa_recibido` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`),
  ADD CONSTRAINT `recibido_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `recibido_ibfk_4` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `recibido_ibfk_5` FOREIGN KEY (`doc_quien_registra`) REFERENCES `remitente` (`rem_doc`),
  ADD CONSTRAINT `recibido_ibfk_8` FOREIGN KEY (`ciudad_proveniente`) REFERENCES `ciudad` (`ciudad_cod_post`),
  ADD CONSTRAINT `recibido_ibfk_9` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`);

--
-- Filtros para la tabla `remitente`
--
ALTER TABLE `remitente`
  ADD CONSTRAINT `remitente_ibfk_2` FOREIGN KEY (`rem_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `remitente_ibfk_3` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`),
  ADD CONSTRAINT `remitente_ibfk_4` FOREIGN KEY (`rem_ciudad`) REFERENCES `ciudad` (`ciudad_cod_post`);

--
-- Filtros para la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD CONSTRAINT `tipo_ibfk_1` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad` (`id_prioridad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
