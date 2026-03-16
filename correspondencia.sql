-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 05:50 AM
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
(19, 15, 'correspondencia/baI72QME9OMJGH5HJC9xLjBSttTcUdO2BAMrLu9p.pdf', '2.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `anexo_respuesta`
--

CREATE TABLE `anexo_respuesta` (
  `id_anexo_resp` int(11) NOT NULL,
  `id_detalle` int(10) NOT NULL,
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
(21, 15, '1070730214', '2026-03-13 04:06:30', 7, 'Documento recibido (Registro Externo)', NULL, NULL);

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
  `emple_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`emple_doc`, `nit_empresa`, `password`, `emple_nombres`, `emple_apellidos`, `emple_tel`, `emple_correo`, `emple_img`, `emple_estado`, `emple_rol`, `emple_area`) VALUES
('1005912003', '4565464564', '$2y$12$Ld5g59zFru6uK2Xr8MDBHeaaqH/DkGvsLc7ws9YU8BnLdteFAOLt6', 'Kevin', 'Villafrade', '3152782654', 'kevindany2222209@gmail.com', NULL, 1, 2, NULL),
('1005912004', NULL, '$2y$12$ObwJO1oSYusfcd1QRYO0Z.ZFVsVy.j4w/oiXPUa64GWMecLizJw2a', 'Kevin', 'Villafrade', NULL, 'kevindany2209@gmail.com', NULL, 1, 1, NULL),
('1005912005', '4354353454', '$2y$12$dsRE/4pK1lXTVNdR6zZrtORXIj2m9VEhCDjZEuKmj8funIyPz92AO', 'Kevin', 'Villafrade', '3152782654', 'kevindany222209@gmail.com', NULL, 1, 2, NULL),
('1005912006', '9887978978', '$2y$12$OHrgZT0tTor.BZ10PdMIa.5F0tqvEfTKl5hapYaWXDTxRIvMvocBi', 'Daniel', 'Perez', '545466545465', 'nikolas1993838@gmail.com', NULL, 1, 3, 9),
('1005912008', '9887978978', '$2y$12$gdPanlYye7fzZMveYoQg4Ojx.lFx5NNFOTjbQc0g409wAF1vgvuMi', 'Humber', 'Perez', '3142808076', 'humber@gmail.com', NULL, 1, 3, 6),
('1070730214', '9887978978', '$2y$12$qTSxTGQa105rqOxqNJHKduU.GchvUS3rOyXjmmtqXF3GuCcpXO2IW', 'Yuber', 'Paez', '3202534042', 'santiagopc333@gmail.com', NULL, 1, 3, 1),
('999001', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'SAdmin', '3009990001', 'superadmin.sadmin@gmail.com', NULL, 1, 1, 1),
('999002', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'Admin', '3009990002', 'superadmin.admin@gmail.com', NULL, 1, 2, 1),
('999003', '4354353454', '$2y$12$a7jL1mck5DcU9jZRCSJGjeSls5pB08WHwK3/ZFnmAITs62XxflSRq', 'Super Admin', 'Empleado', '3009990003', 'superadmin.empleado@gmail.com', NULL, 1, 3, 1);

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
  `empresa_correo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`nit_empresa`, `nomb_empresa`, `doc_representante`, `nomb_representante`, `direccion`, `contacto`, `empresa_correo`) VALUES
('4354353454', 'KFC & Food', '38144607', 'Emilio Casas', 'Avenida 37 N12 - 23 fdssfdsdfsdf', '3152782654', 'kfc@gmail.com'),
('4355466554', 'SUBWAY', '5654645645', 'Subway Dueño', 'Cra 12 N37 A16 PRUEBA PORUEBA', '3152782654', 'subway@gmail.com'),
('4565464564', 'LA MAZZA', '38144609', 'Adriana Perez', 'Avenida 37 N12 - 23 Gaitan', '3152782654', 'lamazzaibg@gmail.com'),
('9887978978', '657 Sport', '7866787678', 'Humbert Villein', 'Avenida 37 N12 - 23 fdgfgdgfdgdfgdfgdffgdfdgfgdgfdfdgdfg', '3152782654', '657sports@gmail.com');

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
  `licencia_origen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `id_estado`, `id_pago`, `fecha_inicio`, `fecha_fin`, `tipo_licencia`, `licencia_origen`) VALUES
(27, 1, 55, '2026-02-27 12:00:22', '2026-05-28 12:00:22', 'ACTIVACION', NULL),
(30, 1, 56, '2026-05-28 12:00:22', '2026-08-26 12:00:22', 'RENOVACION', 27),
(31, 1, 59, '2026-08-26 12:00:22', '2026-09-25 12:00:22', 'RENOVACION', 30),
(32, 1, 58, '2026-09-25 12:00:22', '2026-10-25 12:00:22', 'RENOVACION', 31),
(34, 1, 61, '2026-03-02 22:49:42', '2026-03-10 22:49:42', 'ACTIVACION', NULL),
(35, 1, 62, '2026-03-11 14:23:37', '2027-03-11 14:23:37', 'ACTIVACION', NULL);

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
  `fecha_inicio` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_plan`, `comprobante`, `id_admin`, `moneda`, `id_est_pago`, `fecha_pago`, `fecha_inicio`) VALUES
(55, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 11:59:10', NULL),
(56, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 12:01:04', NULL),
(57, 6, NULL, '1005912005', 'COP', 4, '2026-02-27 12:01:17', NULL),
(58, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:03', NULL),
(59, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:09', NULL),
(60, 10, NULL, '1005912005', 'COP', 4, '2026-02-27 12:06:40', NULL),
(61, 4, NULL, '1005912003', 'COP', 4, '2026-03-02 22:49:33', NULL),
(62, 10, NULL, '999002', 'COP', 4, '2026-03-11 14:23:11', NULL);

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
  `es_destacado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan`
--

INSERT INTO `plan` (`id_plan`, `nomb_plan`, `valor`, `descripcion`, `duracion`, `es_destacado`) VALUES
(4, 'Mensual', 200000, '[\"Acceso completo al sistema.\",\"Soporte básico.\",\"Garantía 7 días.\"]', 30, 0),
(5, 'Trimestral', 540000, '[\"Acceso completo al sistema.\",\"Soporte prioritario.\",\"Garantía 14 días.\", \"Incluye 1 capacitación.\"]', 90, 0),
(6, 'Semestral', 1040000, '[\"Acceso completo al sistema.\",\"Soporte prioritario extendido.\",\"Garantía 30 días.\", \"Incluye 2 capacitaciones.\"]\r\n', 180, 0),
(10, 'Anual', 1950000, '[\"Acceso completo al sistema.\",\"Soporte prioritario exclusivo.\",\"Garant\\u00eda 60 d\\u00edas.\",\"Incluye 6 capacitaciones.\"]', 365, 0),
(12, 'Sotfware tuyo', 0, '[\"Es totalmente tuyo el sistema\"]', 7, 0);

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
(40, 'INT-2026-00005', '9887978978');

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
(15, NULL, 40, 'solicitud', '2026-03-12 23:06:30', NULL, '05001', 7, NULL, 'ninguna', 1234567888, 4, 12, 'correspondencia/4Do1qFnbyCDqjLYKNDRtDQQHHhgle5gXbGa4OYWX.pdf', '9887978978', 'Persona de prueba', '1234567890', 'prueba@gmail.com', '12345789');

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
('4RZmGS3Y29MorPrvyiFLfxIhVrKVl9BUZJ2yGoaT', 1234567888, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNTlSdWx3bmF1cnAyMmFFbEVRa0dTazBqOWppeTdISlMxazhtQUtXcCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZW1pdGVudGUvZXh0ZXJuYXJlYyI7czo1OiJyb3V0ZSI7czoyMDoicmVtaXRlbnRlLmV4dGVybmFyZWMiO31zOjU2OiJsb2dpbl9yZW1pdGVudGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjM0NTY3ODg4O30=', 1773374873),
('TPtaVDFyFi2gA0ngO4Pu7ChBeiZEsXMJyA0UWvB0', 1005912008, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTmNTbzRkbTBoRkVFYTdFeGllVnVIS2R6dFdDVEpQYlFRbGVTbzd5dSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1NzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2VtcGxlYWRvL2NvcnJlc3BvbmRlbmNpYS1maW5hbGl6YWRhIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsZWFkby9jb3JyZXNwb25kZW5jaWEtcmVjaWJpZGEiO3M6NToicm91dGUiO3M6MzM6ImVtcGxlYWRvLmNvcnJlc3BvbmRlbmNpYV9yZWNpYmlkYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjEwOiIxMDA1OTEyMDA4Ijt9', 1773292539),
('UCeTwfTBng2WfzNDuicNh4FsOuCMUiaArWc9lyLk', 1005912006, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoibGh0NW5oRW1SejMxQlVlR3p0UXFldmJsTmg4OURjSjBRem90YnBnRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsZWFkby9jb3JyZXNwb25kZW5jaWEtZmluYWxpemFkYSI7czo1OiJyb3V0ZSI7czozNToiZW1wbGVhZG8uY29ycmVzcG9uZGVuY2lhX2ZpbmFsaXphZGEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjE1OiJsb2Nrb3V0X3NlY29uZHMiO2k6MjgwO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjEwOiIxMDA1OTEyMDA2Ijt9', 1773292512);

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
  ADD KEY `id_detalle_idx` (`id_detalle`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

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
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
-- AUTO_INCREMENT for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  MODIFY `id_det_recibido` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `recibido`
--
ALTER TABLE `recibido`
  MODIFY `id_recibido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `fk_anexo_respuesta` FOREIGN KEY (`id_detalle`) REFERENCES `detalle_envio` (`id_detalle`) ON DELETE CASCADE;

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
