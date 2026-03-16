-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 11:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `correspondencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `anexo_envio`
--

CREATE TABLE `anexo_envio` (
  `id_anexo` int(11) NOT NULL,
  `id_envio` int(10) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anexo_envio`
--

INSERT INTO `anexo_envio` (`id_anexo`, `id_envio`, `ruta_archivo`, `nombre_original`) VALUES
(12, 14, 'correspondencia/Vxoyp3QQlIlMjApdMWfyAdznBiSzVuC4eLPKvAkl.pdf', '141230623434 (2).pdf'),
(13, 15, 'correspondencia/2i3zwoDyNxMOz7iKZbieXVyhFXKB0wb1rbQpffPQ.pdf', 'LEGALIZACION 2586-2026 (2) (1).pdf');

-- --------------------------------------------------------

--
-- Table structure for table `anexo_recibido`
--

CREATE TABLE `anexo_recibido` (
  `id_anexo` int(11) NOT NULL,
  `id_recibido` int(20) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anexo_recibido`
--

INSERT INTO `anexo_recibido` (`id_anexo`, `id_recibido`, `ruta_archivo`, `nombre_original`) VALUES
(18, 14, 'correspondencia/dofzcvOQOiHHA2SQGFe01rGqYBRndf7a5sMKJSHI.pdf', 'cedula.pdf'),
(19, 15, 'correspondencia/baI72QME9OMJGH5HJC9xLjBSttTcUdO2BAMrLu9p.pdf', '2.pdf'),
(20, 16, 'correspondencia/20lEAdZDCmliqMTbl965Xudyu4I9tUdc9qBNMDd7.pdf', 'PLAN DE PRUEBAS.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `anexo_respuesta`
--

CREATE TABLE `anexo_respuesta` (
  `id_anexo_resp` int(11) NOT NULL,
  `id_detalle` int(10) NOT NULL,
  `id_det_interna` int(10) DEFAULT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id_area` int(20) NOT NULL,
  `area_nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id_area`, `area_nom`) VALUES
(1, 'Administrativa'),
(4, 'Gerencia General'),
(5, 'Recursos Humanos'),
(6, 'Contabilidad'),
(7, 'Correspondencia'),
(8, 'Archivo Central'),
(9, 'Oficina Asesora Juridica');

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_empleado`
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
-- Dumping data for table `auditoria_empleado`
--

INSERT INTO `auditoria_empleado` (`id_log`, `doc_empleado_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, '1005912003', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:07:26', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany2222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Vin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany2222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}'),
(2, '1005912005', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:14:46', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafrade\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}', '{\"nombres\": \"Kevin\", \"apellidos\": \"Villafradeeee\", \"correo\": \"kevindany222209@gmail.com\", \"estado\": 1, \"rol\": 2, \"area\": null}');

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_empresa`
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
-- Dumping data for table `auditoria_empresa`
--

INSERT INTO `auditoria_empresa` (`id_log`, `nit_empresa_afectada`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, '4354353454', '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:36:10', '{\"nomb_empresa\": \"KFC & Food\", \"doc_representante\": \"38144607\", \"nomb_representante\": \"Emilio Casas\", \"direccion\": \"Avenida 37 N12 - 23 fdssfdsdfsdf\", \"contacto\": \"3152782654\", \"empresa_correo\": \"kfc@gmail.com\"}', '{\"nomb_empresa\": \"KFC &amp\", \"doc_representante\": \"38144607\", \"nomb_representante\": \"Emilio Casas\", \"direccion\": \"Avenida 37 N12 - 23 fdssfdsdfsdf\", \"contacto\": \"3152782654\", \"empresa_correo\": \"kfc@gmail.com\"}');

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_licencia`
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
-- Dumping data for table `auditoria_licencia`
--

INSERT INTO `auditoria_licencia` (`id_log`, `id_licencia_afectada`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 34, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 19:34:51', '{\"id_estado\": 1, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}', '{\"id_estado\": 2, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}'),
(2, 34, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 19:35:06', '{\"id_estado\": 2, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}', '{\"id_estado\": 1, \"id_pago\": 61, \"fecha_inicio\": \"2026-03-02 22:49:42\", \"fecha_fin\": \"2026-03-10 22:49:42\", \"tipo_licencia\": \"ACTIVACION\", \"licencia_origen\": null}');

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_pagos`
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
-- Dumping data for table `auditoria_pagos`
--

INSERT INTO `auditoria_pagos` (`id_log`, `id_pago_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 63, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 18:56:35', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 0, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}', '{\"id_plan\": 10, \"comprobante\": null, \"id_admin\": \"999002\", \"moneda\": \"COP\", \"id_est_pago\": 4, \"fecha_pago\": \"2026-03-13 13:56:21\", \"fecha_inicio\": null}');

-- --------------------------------------------------------

--
-- Table structure for table `auditoria_plan`
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
-- Dumping data for table `auditoria_plan`
--

INSERT INTO `auditoria_plan` (`id_log`, `id_plan_afectado`, `usuario_app`, `usuario_bd`, `accion`, `fecha_cambio`, `datos_anteriores`, `datos_nuevos`) VALUES
(1, 6, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 20:49:22', '{\"nomb_plan\": \"Semestral\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}', '{\"nomb_plan\": \"Semestrallllll\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}'),
(2, 6, '1070730214', 'root@localhost', 'ACTUALIZACION', '2026-03-13 20:49:39', '{\"nomb_plan\": \"Semestrallllll\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}', '{\"nomb_plan\": \"Semestral\", \"valor\": 1040000, \"descripcion\": \"[\\\"Acceso completo al sistema.\\\",\\\"Soporte prioritario extendido.\\\",\\\"Garantía 30 días.\\\", \\\"Incluye 2 capacitaciones.\\\"]\\r\\n\", \"duracion\": 180, \"es_destacado\": 1}');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ciudad`
--

CREATE TABLE `ciudad` (
  `ciudad_cod_post` varchar(10) NOT NULL,
  `ciudad_nom` varchar(100) DEFAULT NULL,
  `ciudad_id_dpto` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ciudad`
--

INSERT INTO `ciudad` (`ciudad_cod_post`, `ciudad_nom`, `ciudad_id_dpto`) VALUES
('05001', 'Medellín', '05'),
('08001', 'Barranquilla', '08'),
('11001', 'Bogotá D.C.', '11'),
('13001', 'Cartagena', '13'),
('15001', 'Tunja', '15'),
('17001', 'Manizales', '17'),
('18001', 'Florencia', '18'),
('19001', 'Popayán', '19'),
('20001', 'Valledupar', '20'),
('23001', 'Montería', '23'),
('25001', 'Bogotá D.C.', '25'),
('27001', 'Quibdó', '27'),
('41001', 'Neiva', '41'),
('44001', 'Riohacha', '44'),
('47001', 'Santa Marta', '47'),
('50001', 'Villavicencio', '50'),
('52001', 'Pasto', '52'),
('54001', 'Cúcuta', '54'),
('63001', 'Armenia', '63'),
('66001', 'Pereira', '66'),
('68001', 'Bucaramanga', '68'),
('70001', 'Sincelejo', '70'),
('73001', 'Ibagué', '73'),
('76001', 'Cali', '76'),
('81001', 'Arauca', '81'),
('85001', 'Yopal', '85'),
('86001', 'Mocoa', '86'),
('88001', 'San Andrés', '88'),
('91001', 'Leticia', '91'),
('94001', 'Inírida', '94'),
('95001', 'San José del Guaviare', '95'),
('97001', 'Mitú', '97'),
('99001', 'Puerto Carreño', '99');

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `dpto_codigo_postal` varchar(10) NOT NULL,
  `dpto_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departamento`
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
-- Table structure for table `detalle_envio`
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
  `folios_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalle_envio`
--

INSERT INTO `detalle_envio` (`id_detalle`, `id_quien_envie`, `id_quien_recibe`, `id_envio`, `fecha_traslado`, `id_estado_rec`, `observaciones`, `archivo_respuesta`, `folios_respuesta`) VALUES
(40, '1005912006', '1005912008', 13, '2026-03-12 04:52:47', 7, 'no responder a esta resolucion', NULL, NULL),
(41, '1005912006', '1005912008', 13, '2026-03-12 04:53:20', 10, NULL, NULL, 0),
(42, '1005912006', '1005912008', 14, '2026-03-12 05:10:22', 7, 'PRUEBA', NULL, NULL),
(43, '1005912006', '1070730214', 14, '2026-03-12 05:10:22', 7, 'PRUEBA', NULL, NULL),
(44, '1005912006', '1070730214', 15, '2026-03-12 05:13:03', 7, 'PRUEBA', NULL, NULL),
(45, '1005912006', '1005912008', 14, '2026-03-12 05:13:59', 8, NULL, NULL, 0),
(46, '1005912006', '1005912008', 14, '2026-03-12 05:14:04', 9, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_recibido`
--

CREATE TABLE `detalle_recibido` (
  `id_det_recibido` int(15) NOT NULL,
  `det_id_recibido` int(20) NOT NULL,
  `det_doc_empleado` varchar(20) NOT NULL,
  `fecha_re` timestamp NULL DEFAULT NULL,
  `id_estado_rec` int(20) DEFAULT NULL,
  `observaciones` varchar(500) DEFAULT NULL,
  `archivo_res` varchar(500) DEFAULT NULL,
  `folios_res` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalle_recibido`
--

INSERT INTO `detalle_recibido` (`id_det_recibido`, `det_id_recibido`, `det_doc_empleado`, `fecha_re`, `id_estado_rec`, `observaciones`, `archivo_res`, `folios_res`) VALUES
(17, 14, '1070730214', NULL, NULL, NULL, NULL, NULL),
(18, 14, '1070730214', '2026-03-13 04:05:35', 7, 'Documento recibido (Registro Externo)', NULL, NULL),
(19, 15, '1070730214', NULL, NULL, NULL, NULL, NULL),
(20, 15, '1005912003', NULL, NULL, NULL, NULL, NULL),
(21, 15, '1070730214', '2026-03-13 04:06:30', 7, 'Documento recibido (Registro Externo)', NULL, NULL),
(22, 16, '1070730214', NULL, NULL, NULL, NULL, NULL),
(23, 16, '1070730214', '2026-03-13 17:44:55', 7, 'Documento recibido (Registro Externo)', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
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
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`emple_doc`, `nit_empresa`, `password`, `emple_nombres`, `emple_apellidos`, `emple_tel`, `emple_correo`, `emple_img`, `emple_estado`, `emple_rol`, `emple_area`, `actualizado_por`) VALUES
('1005912003', '4565464564', '$2y$12$Ld5g59zFru6uK2Xr8MDBHeaaqH/DkGvsLc7ws9YU8BnLdteFAOLt6', 'Vin', 'Villafrade', '3152782654', 'kevindany2222209@gmail.com', NULL, 1, 2, NULL, '1070730214'),
('1005912004', NULL, '$2y$12$ObwJO1oSYusfcd1QRYO0Z.ZFVsVy.j4w/oiXPUa64GWMecLizJw2a', 'Kevin', 'Villafrade', NULL, 'kevindany2209@gmail.com', NULL, 1, 1, NULL, NULL),
('1005912005', '4354353454', '$2y$12$dsRE/4pK1lXTVNdR6zZrtORXIj2m9VEhCDjZEuKmj8funIyPz92AO', 'Kevin', 'Villafradeeee', '3152782654', 'kevindany222209@gmail.com', NULL, 1, 2, NULL, '1070730214'),
('1005912006', '9887978978', '$2y$12$OHrgZT0tTor.BZ10PdMIa.5F0tqvEfTKl5hapYaWXDTxRIvMvocBi', 'Daniel', 'Perez', '545466545465', 'nikolas1993838@gmail.com', NULL, 1, 3, 9, NULL),
('1005912008', '9887978978', '$2y$12$gdPanlYye7fzZMveYoQg4Ojx.lFx5NNFOTjbQc0g409wAF1vgvuMi', 'Humber', 'Perez', '3142808076', 'humber@gmail.com', NULL, 1, 3, 6, NULL),
('1070730214', '9887978978', '$2y$12$qTSxTGQa105rqOxqNJHKduU.GchvUS3rOyXjmmtqXF3GuCcpXO2IW', 'Yuber', 'Paez', '3202534042', 'santiagopc333@gmail.com', NULL, 1, 1, 1, NULL),
('999001', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'SAdmin', '3009990001', 'superadmin.sadmin@gmail.com', NULL, 1, 1, 1, NULL),
('999002', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'Admin', '3009990002', 'superadmin.admin@gmail.com', NULL, 1, 2, 1, NULL),
('999003', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'Empleado', '3009990003', 'superadmin.empleado@gmail.com', NULL, 1, 3, 1, NULL);

--
-- Triggers `empleado`
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
-- Table structure for table `empresa`
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
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`nit_empresa`, `nomb_empresa`, `doc_representante`, `nomb_representante`, `direccion`, `contacto`, `empresa_correo`, `actualizado_por`) VALUES
('4354353454', 'KFC &amp', '38144607', 'Emilio Casas', 'Avenida 37 N12 - 23 fdssfdsdfsdf', '3152782654', 'kfc@gmail.com', '1070730214'),
('4355466554', 'SUBWAY', '5654645645', 'Subway Dueño', 'Cra 12 N37 A16 PRUEBA PORUEBA', '3152782654', 'subway@gmail.com', NULL),
('4565464564', 'LA MAZZA', '38144609', 'Adriana Perez', 'Avenida 37 N12 - 23 Gaitan', '3152782654', 'lamazzaibg@gmail.com', NULL),
('9887978978', '657 Sport', '7866787678', 'Humbert Villein', 'Avenida 37 N12 - 23 fdgfgdgfdgdfgdfgdffgdfdgfgdgfdfdgdfg', '3152782654', '657sports@gmail.com', NULL);

--
-- Triggers `empresa`
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
-- Table structure for table `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(10) NOT NULL,
  `num_radicado_int` int(20) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `doc_quien_dirigido` int(15) DEFAULT NULL,
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
-- Dumping data for table `envio`
--

INSERT INTO `envio` (`id_envio`, `num_radicado_int`, `asunto`, `doc_quien_dirigido`, `doc_quien_envia`, `fecha`, `destino`, `folio`, `id_tipo_envio`, `id_estado_envio`, `archivo`, `nit_empresa`) VALUES
(13, 35, 'RESOLUCION', NULL, '1005912006', '2026-03-12 04:52:47', 'Interno', 0, 8, 12, '', '9887978978'),
(14, 36, 'DERECHO', NULL, '1005912006', '2026-03-12 05:10:22', 'Interno', 3, 1, 12, 'correspondencia/mr8Rchi4xRWYRXfvuPPF5rES2AEXJZPWODgIUVjx.pdf', '9887978978'),
(15, 37, 'DERECHO', NULL, '1005912006', '2026-03-12 05:13:03', 'Interno', 5, 1, 12, 'correspondencia/v3ondxDmEoYLILtXRTaU1TPhcJbgTSx0Bnsx3GU7.pdf', '9887978978');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(20) NOT NULL,
  `estado_nomb` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estado`
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
(13, 'Digitalizado');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `licencia`
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
-- Dumping data for table `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `id_estado`, `id_pago`, `fecha_inicio`, `fecha_fin`, `tipo_licencia`, `licencia_origen`, `actualizado_por`) VALUES
(27, 1, 55, '2026-02-27 12:00:22', '2026-05-28 12:00:22', 'ACTIVACION', NULL, NULL),
(30, 1, 56, '2026-05-28 12:00:22', '2026-08-26 12:00:22', 'RENOVACION', 27, NULL),
(31, 1, 59, '2026-08-26 12:00:22', '2026-09-25 12:00:22', 'RENOVACION', 30, NULL),
(32, 1, 58, '2026-09-25 12:00:22', '2026-10-25 12:00:22', 'RENOVACION', 31, NULL),
(34, 1, 61, '2026-03-02 22:49:42', '2026-03-10 22:49:42', 'ACTIVACION', NULL, '1070730214'),
(35, 1, 62, '2026-03-11 14:23:37', '2027-03-11 14:23:37', 'ACTIVACION', NULL, NULL),
(36, 1, 63, '2027-03-11 14:23:37', '2028-03-10 14:23:37', 'RENOVACION', 35, NULL);

--
-- Triggers `licencia`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_16_162424_create_password_codes_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(10) NOT NULL,
  `id_plan` int(10) DEFAULT NULL,
  `comprobante` varchar(500) DEFAULT NULL,
  `id_admin` varchar(20) NOT NULL,
  `moneda` varchar(10) DEFAULT NULL,
  `id_est_pago` int(10) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `actualizado_por` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_plan`, `comprobante`, `id_admin`, `moneda`, `id_est_pago`, `fecha_pago`, `fecha_inicio`, `actualizado_por`) VALUES
(55, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 11:59:10', NULL, NULL),
(56, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 12:01:04', NULL, NULL),
(57, 6, NULL, '1005912005', 'COP', 4, '2026-02-27 12:01:17', NULL, NULL),
(58, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:03', NULL, NULL),
(59, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:09', NULL, NULL),
(60, 10, NULL, '1005912005', 'COP', 4, '2026-02-27 12:06:40', NULL, NULL),
(61, 4, NULL, '1005912003', 'COP', 4, '2026-03-02 22:49:33', NULL, NULL),
(62, 10, NULL, '999002', 'COP', 4, '2026-03-11 14:23:11', NULL, NULL),
(63, 10, NULL, '999002', 'COP', 4, '2026-03-13 13:56:21', NULL, '1070730214');

--
-- Triggers `pagos`
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
-- Table structure for table `password_codes`
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
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan`
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
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id_plan`, `nomb_plan`, `valor`, `descripcion`, `duracion`, `es_destacado`, `actualizado_por`) VALUES
(4, 'Mensual', 200000, '[\"Acceso completo al sistema.\",\"Soporte básico.\",\"Garantía 7 días.\"]', 30, 0, NULL),
(5, 'Trimestral', 540000, '[\"Acceso completo al sistema.\",\"Soporte prioritario.\",\"Garantía 14 días.\", \"Incluye 1 capacitación.\"]', 90, 0, NULL),
(6, 'Semestral', 1040000, '[\"Acceso completo al sistema.\",\"Soporte prioritario extendido.\",\"Garantía 30 días.\", \"Incluye 2 capacitaciones.\"]\r\n', 180, 1, '1070730214'),
(10, 'Anual', 1950000, '[\"Acceso completo al sistema.\",\"Soporte prioritario exclusivo.\",\"Garant\\u00eda 60 d\\u00edas.\",\"Incluye 6 capacitaciones.\"]', 365, 0, NULL);

--
-- Triggers `plan`
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
-- Table structure for table `prioridad`
--

CREATE TABLE `prioridad` (
  `id_prioridad` int(20) NOT NULL,
  `prioridad_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prioridad`
--

INSERT INTO `prioridad` (`id_prioridad`, `prioridad_nombre`) VALUES
(1, 'Alta'),
(2, 'Media'),
(3, 'Baja'),
(4, 'Urgente');

-- --------------------------------------------------------

--
-- Table structure for table `radicados`
--

CREATE TABLE `radicados` (
  `id_radicado` int(10) NOT NULL,
  `num_radicado` varchar(20) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `radicados`
--

INSERT INTO `radicados` (`id_radicado`, `num_radicado`, `nit_empresa`) VALUES
(35, 'INT-2026-00001', '9887978978'),
(36, 'INT-2026-00002', '9887978978'),
(37, 'INT-2026-00003', '9887978978'),
(39, 'INT-2026-00004', '9887978978'),
(40, 'INT-2026-00005', '9887978978'),
(41, 'INT-2026-00006', '9887978978');

-- --------------------------------------------------------

--
-- Table structure for table `recibido`
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
-- Dumping data for table `recibido`
--

INSERT INTO `recibido` (`id_recibido`, `num_radicado_ext`, `num_radicado_int`, `asunto`, `fecha_hora_recib`, `nom_institucion`, `ciudad_proveniente`, `folio`, `anexo`, `observaciones`, `doc_quien_registra`, `id_tipo`, `id_estado_rec`, `archivo`, `nit_empresa`, `nombre_persona`, `doc_persona`, `correo_persona`, `tel_persona`) VALUES
(14, '12345', 39, 'solicitud', '2026-03-12 23:05:35', 'Alcaldia', '05001', 8, NULL, 'ninguna', 1234567888, 4, 12, 'correspondencia/GCA64cEw69swXGwDjSNhqJnmYrV34YLBFRcIq2gv.pdf', '9887978978', NULL, NULL, NULL, NULL),
(15, NULL, 40, 'solicitud', '2026-03-12 23:06:30', NULL, '05001', 7, NULL, 'ninguna', 1234567888, 4, 12, 'correspondencia/4Do1qFnbyCDqjLYKNDRtDQQHHhgle5gXbGa4OYWX.pdf', '9887978978', 'Persona de prueba', '1234567890', 'prueba@gmail.com', '12345789'),
(16, '12345', 41, 'solicitud', '2026-03-13 12:44:55', 'Alcaldia', '18001', 7, NULL, 'no responder', 1234567888, 4, 12, 'correspondencia/pZXV0CtAKPNQq1Hwe0mUnLOxf4NcuaraB7PYjJhU.pdf', '9887978978', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `remitente`
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
  `rem_estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remitente`
--

INSERT INTO `remitente` (`rem_doc`, `nit_empresa`, `rem_nombres`, `rem_apellidos`, `rem_correo`, `password`, `rem_tel`, `rem_ciudad`, `rem_estado`) VALUES
(999004, '4354353454', 'Super Admin', 'Remitente', 'superadmin.remitente@gmail.com', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', '3000000000', '11001', 1),
(1234567888, '9887978978', 'Kevin', 'Daniel', 'kevin.daniel@gmail.com', '$2y$12$V/kBOsNQ33fJEcmod3oG.e2F/VDOtKa3dzc6TQjvpuTBb4WXy6DPe', '3001234567', '11001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(20) NOT NULL,
  `rol_nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rol`
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
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CfQ7hNNrxYTZFC9KVJ3oGPnepMYxyaIdn7kEVNIs', 1070730214, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQ25TRTRUME42TGhrSmdacDlmOVMzbDlWRnRZaWM3UG1taGZ4aU44ZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYWRtaW4vcGxhbmVzIjtzOjU6InJvdXRlIjtzOjc6ImNwbGFuZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7czoxMDoiMTA3MDczMDIxNCI7fQ==', 1773439132),
('xFLQ50Y5X482GBEXKrBfokLA4V1T6kFcBZKMfXrK', 1005912008, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU05vYXkxaDJmd0czaHlOaU9ZcllpSGs3cko4RXNZT3hieEVsbWZlcyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3NhZG1pbi9lbXByZXNhcyI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMwOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZW1wbGVhZG8iO3M6NToicm91dGUiO3M6MTQ6ImVtcGxlYWRvLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MTA6IjEwMDU5MTIwMDgiO30=', 1773426186);

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(20) NOT NULL,
  `tipo_nombre` varchar(100) DEFAULT NULL,
  `id_prioridad` int(10) DEFAULT NULL,
  `dias_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo_nombre`, `id_prioridad`, `dias_respuesta`) VALUES
(1, 'Derecho de Peticion', 4, 15),
(3, 'Reclamo', 1, 15),
(4, 'Solicitud', 2, 15),
(5, 'Carta', 2, 15),
(6, 'Memorando', 2, 5),
(7, 'Circular', 3, 0),
(8, 'Resolucion', 3, 0),
(9, 'Contrato', 1, 5),
(10, 'Queja', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@example.com', '2026-02-04 19:18:51', '$2y$12$pORhz2NEzasz12jNPTbBGuoiwM0BYLMMsNZohKEEo7.llJt3qazoS', 'D29faiXApN', '2026-02-04 19:18:54', '2026-02-04 19:18:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anexo_envio`
--
ALTER TABLE `anexo_envio`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `id_envio` (`id_envio`);

--
-- Indexes for table `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  ADD PRIMARY KEY (`id_anexo`),
  ADD KEY `id_recibido_idx` (`id_recibido`);

--
-- Indexes for table `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  ADD PRIMARY KEY (`id_anexo_resp`),
  ADD KEY `id_detalle_idx` (`id_detalle`),
  ADD KEY `fk_anexo_resp_interna` (`id_det_interna`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indexes for table `auditoria_empleado`
--
ALTER TABLE `auditoria_empleado`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `auditoria_empresa`
--
ALTER TABLE `auditoria_empresa`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `auditoria_licencia`
--
ALTER TABLE `auditoria_licencia`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `auditoria_pagos`
--
ALTER TABLE `auditoria_pagos`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `auditoria_plan`
--
ALTER TABLE `auditoria_plan`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `ciudad`
--
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`ciudad_cod_post`),
  ADD KEY `ciudad_id_dpto` (`ciudad_id_dpto`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`dpto_codigo_postal`);

--
-- Indexes for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_quien_envie` (`id_quien_envie`),
  ADD KEY `id_quien_recibe` (`id_quien_recibe`),
  ADD KEY `id_estado_rec` (`id_estado_rec`);

--
-- Indexes for table `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  ADD PRIMARY KEY (`id_det_recibido`),
  ADD KEY `det_doc_empleado` (`det_doc_empleado`),
  ADD KEY `det_id_recibido` (`det_id_recibido`),
  ADD KEY `id_estado_rec` (`id_estado_rec`);

--
-- Indexes for table `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`emple_doc`),
  ADD KEY `emple_estado` (`emple_estado`),
  ADD KEY `emple_rol` (`emple_rol`),
  ADD KEY `emple_area` (`emple_area`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`nit_empresa`),
  ADD KEY `id_representante` (`doc_representante`);

--
-- Indexes for table `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `doc_quien_envia` (`doc_quien_envia`),
  ADD KEY `id_tipo_envio` (`id_tipo_envio`),
  ADD KEY `id_estado_envio` (`id_estado_envio`),
  ADD KEY `envio_ibfk_1` (`doc_quien_dirigido`),
  ADD KEY `num_radicado_int` (`num_radicado_int`),
  ADD KEY `fk_empresa_envio` (`nit_empresa`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`id_licencia`),
  ADD KEY `id_estado` (`id_estado`),
  ADD KEY `id_pago` (`id_pago`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_est_pago` (`id_est_pago`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indexes for table `password_codes`
--
ALTER TABLE `password_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`id_plan`);

--
-- Indexes for table `prioridad`
--
ALTER TABLE `prioridad`
  ADD PRIMARY KEY (`id_prioridad`);

--
-- Indexes for table `radicados`
--
ALTER TABLE `radicados`
  ADD PRIMARY KEY (`id_radicado`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indexes for table `recibido`
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
-- Indexes for table `remitente`
--
ALTER TABLE `remitente`
  ADD PRIMARY KEY (`rem_doc`),
  ADD KEY `rem_ciudad` (`rem_ciudad`),
  ADD KEY `rem_estado` (`rem_estado`),
  ADD KEY `nit_empresa` (`nit_empresa`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`),
  ADD KEY `id_prioridad` (`id_prioridad`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anexo_envio`
--
ALTER TABLE `anexo_envio`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  MODIFY `id_anexo_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `auditoria_empleado`
--
ALTER TABLE `auditoria_empleado`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auditoria_empresa`
--
ALTER TABLE `auditoria_empresa`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auditoria_licencia`
--
ALTER TABLE `auditoria_licencia`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auditoria_pagos`
--
ALTER TABLE `auditoria_pagos`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `auditoria_plan`
--
ALTER TABLE `auditoria_plan`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  MODIFY `id_det_recibido` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `licencia`
--
ALTER TABLE `licencia`
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `password_codes`
--
ALTER TABLE `password_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `plan`
--
ALTER TABLE `plan`
  MODIFY `id_plan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `prioridad`
--
ALTER TABLE `prioridad`
  MODIFY `id_prioridad` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `radicados`
--
ALTER TABLE `radicados`
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `recibido`
--
ALTER TABLE `recibido`
  MODIFY `id_recibido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anexo_envio`
--
ALTER TABLE `anexo_envio`
  ADD CONSTRAINT `fk_anexo_envio` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`) ON DELETE CASCADE;

--
-- Constraints for table `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  ADD CONSTRAINT `fk_anexo_recibido` FOREIGN KEY (`id_recibido`) REFERENCES `recibido` (`id_recibido`) ON DELETE CASCADE;

--
-- Constraints for table `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  ADD CONSTRAINT `fk_anexo_resp_interna` FOREIGN KEY (`id_det_interna`) REFERENCES `detalle_envio` (`id_detalle`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_anexo_respuesta` FOREIGN KEY (`id_detalle`) REFERENCES `detalle_recibido` (`id_det_recibido`) ON DELETE CASCADE;

--
-- Constraints for table `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`ciudad_id_dpto`) REFERENCES `departamento` (`dpto_codigo_postal`);

--
-- Constraints for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD CONSTRAINT `detalle_envio_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`),
  ADD CONSTRAINT `detalle_envio_ibfk_2` FOREIGN KEY (`id_quien_envie`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_envio_ibfk_3` FOREIGN KEY (`id_quien_recibe`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_envio_ibfk_4` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`);

--
-- Constraints for table `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  ADD CONSTRAINT `detalle_recibido_ibfk_1` FOREIGN KEY (`det_doc_empleado`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_recibido_ibfk_2` FOREIGN KEY (`det_id_recibido`) REFERENCES `recibido` (`id_recibido`),
  ADD CONSTRAINT `detalle_recibido_ibfk_3` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`);

--
-- Constraints for table `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`emple_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`emple_rol`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `empleado_ibfk_3` FOREIGN KEY (`emple_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `empleado_ibfk_4` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Constraints for table `envio`
--
ALTER TABLE `envio`
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`doc_quien_dirigido`) REFERENCES `remitente` (`rem_doc`),
  ADD CONSTRAINT `envio_ibfk_3` FOREIGN KEY (`doc_quien_envia`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `envio_ibfk_4` FOREIGN KEY (`id_tipo_envio`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `envio_ibfk_5` FOREIGN KEY (`id_estado_envio`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `envio_ibfk_6` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`),
  ADD CONSTRAINT `fk_empresa_envio` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Constraints for table `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `licencia_ibfk_6` FOREIGN KEY (`id_pago`) REFERENCES `pagos` (`id_pago`);

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `plan` (`id_plan`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_est_pago`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `pagos_ibfk_4` FOREIGN KEY (`id_admin`) REFERENCES `empleado` (`emple_doc`);

--
-- Constraints for table `radicados`
--
ALTER TABLE `radicados`
  ADD CONSTRAINT `radicados_ibfk_2` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Constraints for table `recibido`
--
ALTER TABLE `recibido`
  ADD CONSTRAINT `fk_empresa_recibido` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`),
  ADD CONSTRAINT `recibido_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `recibido_ibfk_4` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `recibido_ibfk_5` FOREIGN KEY (`doc_quien_registra`) REFERENCES `remitente` (`rem_doc`),
  ADD CONSTRAINT `recibido_ibfk_8` FOREIGN KEY (`ciudad_proveniente`) REFERENCES `ciudad` (`ciudad_cod_post`),
  ADD CONSTRAINT `recibido_ibfk_9` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`);

--
-- Constraints for table `remitente`
--
ALTER TABLE `remitente`
  ADD CONSTRAINT `remitente_ibfk_2` FOREIGN KEY (`rem_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `remitente_ibfk_3` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`),
  ADD CONSTRAINT `remitente_ibfk_4` FOREIGN KEY (`rem_ciudad`) REFERENCES `ciudad` (`ciudad_cod_post`);

--
-- Constraints for table `tipo`
--
ALTER TABLE `tipo`
  ADD CONSTRAINT `tipo_ibfk_1` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad` (`id_prioridad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
