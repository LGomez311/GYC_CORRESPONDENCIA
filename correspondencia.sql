-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2026 a las 22:53:16
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
(11, 12, 'correspondencia/LUl2rKdwhoFDhVQfEZ4hPoGGzg9fF6jspKT5LvBR.pdf', 'WSC_TP17_Modulo_B (1).pdf'),
(12, 13, 'correspondencia/TEaeQLWgoDEzG4dNidiTvAdixP72ZRFfeqKl77ZI.pdf', 'admins_empresas.pdf'),
(13, 14, 'correspondencia/jpKd09oxxn4Gh7UpvFOyxGo3Kq7AdftN8DwInKJl.pdf', 'VISTAS.pdf');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anexo_respuesta`
--

CREATE TABLE `anexo_respuesta` (
  `id_anexo_resp` int(11) NOT NULL,
  `id_detalle` int(10) NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `nombre_original` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 'Oficina Asesora Juridica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `folios_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_envio`
--

INSERT INTO `detalle_envio` (`id_detalle`, `id_quien_envie`, `id_quien_recibe`, `id_envio`, `fecha_traslado`, `id_estado_rec`, `observaciones`, `archivo_respuesta`, `folios_respuesta`) VALUES
(32, '1005912006', '1005912008', 11, '2026-03-11 20:57:31', 7, 'PRUEBA', NULL, NULL),
(33, '1005912006', '1070730214', 11, '2026-03-11 20:57:31', 7, 'PRUEBA', NULL, NULL),
(34, '1005912006', '1005912008', 12, '2026-03-11 20:58:35', 7, NULL, NULL, NULL),
(35, '1005912006', '1070730214', 12, '2026-03-11 20:58:35', 7, NULL, NULL, NULL),
(36, '1005912006', '1005912008', 13, '2026-03-11 21:16:53', 7, 'SOLICITUD FACTURA', NULL, NULL),
(37, '1005912006', '1070730214', 13, '2026-03-11 21:16:53', 7, 'SOLICITUD FACTURA', NULL, NULL),
(38, '1005912006', '1005912008', 13, '2026-03-11 21:19:38', 8, 'SE INICIO CON EL TRAMITE DE Radicado INT-2026-00003', NULL, 0),
(39, '1005912006', '1005912008', 13, '2026-03-11 21:21:11', 9, 'se finalizo con el tramite Radicado INT-2026-00003', 'correspondencia/ugqftu2VURhjJbhrnXGNrms2EXh70Lt0n0UGKAt0.pdf', 0),
(40, '1005912006', '1005912008', 14, '2026-03-11 21:29:21', 7, 'SE SOLICITA LA FACTURA NUMERO 2', NULL, NULL),
(41, '1005912006', '1005912008', 14, '2026-03-11 21:33:52', 8, NULL, NULL, 0),
(42, '1005912006', '1005912008', 14, '2026-03-11 21:34:04', 9, NULL, NULL, 0),
(43, '1005912006', '1005912008', 12, '2026-03-11 21:39:01', 8, NULL, NULL, 0),
(44, '1005912006', '1005912008', 12, '2026-03-11 21:41:32', 9, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_recibido`
--

CREATE TABLE `detalle_recibido` (
  `id_det_recibido` int(15) NOT NULL,
  `det_id_recibido` int(20) NOT NULL,
  `det_doc_empleado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `emple_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`emple_doc`, `nit_empresa`, `password`, `emple_nombres`, `emple_apellidos`, `emple_tel`, `emple_correo`, `emple_img`, `emple_estado`, `emple_rol`, `emple_area`) VALUES
('1005912003', '4565464564', '$2y$12$Ld5g59zFru6uK2Xr8MDBHeaaqH/DkGvsLc7ws9YU8BnLdteFAOLt6', 'Kevin', 'Villafrade', '3152782654', 'kevindany2222209@gmail.com', NULL, 1, 2, NULL),
('1005912004', NULL, '$2y$12$ObwJO1oSYusfcd1QRYO0Z.ZFVsVy.j4w/oiXPUa64GWMecLizJw2a', 'Kevin', 'Villafrade', NULL, 'kevindany2209@gmail.com', NULL, 1, 1, NULL),
('1005912005', '4354353454', '$2y$12$dsRE/4pK1lXTVNdR6zZrtORXIj2m9VEhCDjZEuKmj8funIyPz92AO', 'Kevin', 'Villafrade', '3152782654', 'kevindany222209@gmail.com', NULL, 1, 2, NULL),
('1005912006', '9887978978', '$2y$12$OHrgZT0tTor.BZ10PdMIa.5F0tqvEfTKl5hapYaWXDTxRIvMvocBi', 'Daniel', 'Perez', '545466545465', 'nikolas1993838@gmail.com', NULL, 1, 3, 9),
('1005912008', '9887978978', '$2y$12$gdPanlYye7fzZMveYoQg4Ojx.lFx5NNFOTjbQc0g409wAF1vgvuMi', 'Humber', 'Perez', '3142808076', 'humber@gmail.com', NULL, 1, 3, 6),
('1070730214', '9887978978', '$2y$12$qTSxTGQa105rqOxqNJHKduU.GchvUS3rOyXjmmtqXF3GuCcpXO2IW', 'Yuber', 'Paez', '3202534042', 'santiagopc333@gmail.com', NULL, 1, 3, 1);

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
  `empresa_correo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`nit_empresa`, `nomb_empresa`, `doc_representante`, `nomb_representante`, `direccion`, `contacto`, `empresa_correo`) VALUES
('4354353454', 'KFC & Food', '38144607', 'Emilio Casas', 'Avenida 37 N12 - 23 fdssfdsdfsdf', '3152782654', 'kfc@gmail.com'),
('4355466554', 'SUBWAY', '5654645645', 'Subway Dueño', 'Cra 12 N37 A16 PRUEBA PORUEBA', '3152782654', 'subway@gmail.com'),
('4565464564', 'LA MAZZA', '38144609', 'Adriana Perez', 'Avenida 37 N12 - 23 Gaitan', '3152782654', 'lamazzaibg@gmail.com'),
('9887978978', '657 Sport', '7866787678', 'Humbert Villein', 'Avenida 37 N12 - 23 fdgfgdgfdgdfgdfgdffgdfdgfgdgfdfdgdfg', '3152782654', '657sports@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(10) NOT NULL,
  `num_radicado_int` int(20) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `doc_quien_dirigido` int(15) DEFAULT NULL,
  `doc_quien_envia` varchar(20) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `destino` varchar(200) DEFAULT NULL,
  `anexo` varchar(500) DEFAULT NULL,
  `folio` int(20) NOT NULL,
  `id_tipo_envio` int(11) DEFAULT NULL,
  `id_estado_envio` int(10) DEFAULT NULL,
  `archivo` varchar(500) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `envio`
--

INSERT INTO `envio` (`id_envio`, `num_radicado_int`, `asunto`, `doc_quien_dirigido`, `doc_quien_envia`, `fecha`, `destino`, `anexo`, `folio`, `id_tipo_envio`, `id_estado_envio`, `archivo`, `nit_empresa`) VALUES
(11, 33, 'PRUEBA 1', NULL, '1005912006', '2026-03-11 20:57:30', 'Interno', NULL, 0, 3, 12, 'correspondencia/mTo4JGpSW7LawnY5H1XJbNmsXH1cNyr7OVds8WVF.pdf', '9887978978'),
(12, 34, 'prueba 2', NULL, '1005912006', '2026-03-11 20:58:35', 'Interno', NULL, 0, 2, 12, 'correspondencia/dS4avmTCTzsn8CDfuj8zUtU4xSdzXhccaOnqYqLB.pdf', '9887978978'),
(13, 35, 'SOLICITUD FACTURA', NULL, '1005912006', '2026-03-11 21:16:53', 'Interno', NULL, 0, 4, 12, 'correspondencia/ZKAJ39oHPqa6Xf4C50e8xt8EwQGPBf6BYYMncZkE.pdf', '9887978978'),
(14, 36, 'SOLICITUD FACTURA NUMERO 2', NULL, '1005912006', '2026-03-11 21:29:20', 'Interno', NULL, 0, 4, 12, 'correspondencia/Rga68dAOd4lPZ8G8lc6zMvABVEZOUOcizg0ybCSH.pdf', '9887978978');

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
(12, 'Enviado');

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
  `licencia_origen` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `licencia`
--

INSERT INTO `licencia` (`id_licencia`, `id_estado`, `id_pago`, `fecha_inicio`, `fecha_fin`, `tipo_licencia`, `licencia_origen`) VALUES
(27, 1, 55, '2026-02-27 12:00:22', '2026-05-28 12:00:22', 'ACTIVACION', NULL),
(30, 1, 56, '2026-05-28 12:00:22', '2026-08-26 12:00:22', 'RENOVACION', 27),
(31, 1, 59, '2026-08-26 12:00:22', '2026-09-25 12:00:22', 'RENOVACION', 30),
(32, 1, 58, '2026-09-25 12:00:22', '2026-10-25 12:00:22', 'RENOVACION', 31),
(34, 1, 61, '2026-03-02 22:49:42', '2026-03-10 22:49:42', 'ACTIVACION', NULL);

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
(4, '2026_02_16_162424_create_password_codes_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
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
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id_pago`, `id_plan`, `comprobante`, `id_admin`, `moneda`, `id_est_pago`, `fecha_pago`, `fecha_inicio`) VALUES
(55, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 11:59:10', NULL),
(56, 5, NULL, '1005912006', 'COP', 4, '2026-02-27 12:01:04', NULL),
(57, 6, NULL, '1005912005', 'COP', 4, '2026-02-27 12:01:17', NULL),
(58, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:03', NULL),
(59, 4, NULL, '1005912006', 'COP', 4, '2026-02-27 12:05:09', NULL),
(60, 10, NULL, '1005912005', 'COP', 4, '2026-02-27 12:06:40', NULL),
(61, 4, NULL, '1005912003', 'COP', 4, '2026-03-02 22:49:33', NULL);

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
  `es_destacado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plan`
--

INSERT INTO `plan` (`id_plan`, `nomb_plan`, `valor`, `descripcion`, `duracion`, `es_destacado`) VALUES
(4, 'Mensual', 200000, '[\"Acceso completo al sistema.\",\"Soporte básico.\",\"Garantía 7 días.\"]', 30, 0),
(5, 'Trimestral', 540000, '[\"Acceso completo al sistema.\",\"Soporte prioritario.\",\"Garantía 14 días.\", \"Incluye 1 capacitación.\"]', 90, 0),
(6, 'Semestral', 1040000, '[\"Acceso completo al sistema.\",\"Soporte prioritario extendido.\",\"Garantía 30 días.\", \"Incluye 2 capacitaciones.\"]\r\n', 180, 0),
(10, 'Anual', 1950000, '[\"Acceso completo al sistema.\",\"Soporte prioritario exclusivo.\",\"Garant\\u00eda 60 d\\u00edas.\",\"Incluye 6 capacitaciones.\"]', 365, 0),
(12, 'Sotfware tuyo', 0, '[\"Es totalmente tuyo el sistema\"]', 7, 0);

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
  `id_est_radicado` int(11) NOT NULL DEFAULT 1,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `radicados`
--

INSERT INTO `radicados` (`id_radicado`, `num_radicado`, `id_est_radicado`, `nit_empresa`) VALUES
(33, 'INT-2026-00001', 1, '9887978978'),
(34, 'INT-2026-00002', 2, '9887978978'),
(35, 'INT-2026-00003', 1, '9887978978'),
(36, 'INT-2026-00004', 2, '9887978978');

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
  `rem_estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `remitente`
--

INSERT INTO `remitente` (`rem_doc`, `nit_empresa`, `rem_nombres`, `rem_apellidos`, `rem_correo`, `password`, `rem_tel`, `rem_ciudad`, `rem_estado`) VALUES
(1234567888, '9887978978', 'Kevin', 'Daniel', 'kevin.daniel@gmail.com', '$2y$12$V/kBOsNQ33fJEcmod3oG.e2F/VDOtKa3dzc6TQjvpuTBb4WXy6DPe', '3001234567', '11001', 1);

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
(3, 'Empleado');

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
('4VAKCLpVDbEbEvI3tiFmTVIcaViDzKSOZHjUvJ9c', 1005912006, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMDlrRWF5T0pIeWpHSU9sbVdBdmFnNWc1VU9kN3J2NlVKSXVYQ1hQMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsZWFkby9jb3JyZXNwb25kZW5jaWEtcmVjaWJpZGEiO3M6NToicm91dGUiO3M6MzM6ImVtcGxlYWRvLmNvcnJlc3BvbmRlbmNpYV9yZWNpYmlkYSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjEwOiIxMDA1OTEyMDA2Ijt9', 1773265966),
('BacLH4WNox4g0OgpJOFqu29Ut2Jkn4lycW6v7wAG', 1234567888, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieEF3cjBvWUlJbm9WaHh0eW5JYmRxM0JGM1BMZmRSbTZ5cnpnNm5XbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlbWl0ZW50ZS9leHRlcm5hcmVjIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZW1pdGVudGUvZXh0ZXJuYXJlYyI7czo1OiJyb3V0ZSI7czoyMDoicmVtaXRlbnRlLmV4dGVybmFyZWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9yZW1pdGVudGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjM0NTY3ODg4O30=', 1773181497),
('ijBXE59PeCJrfB9B2liz5xfiy6p0zhA6XKfDvT8i', 1005912008, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidklzMmJEeXd0dkZqMUNqYWc2UnZZR1FhYkd2QUlPcWdYWkRoYzljaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2VtcGxlYWRvIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lbXBsZWFkby9jb3JyZXNwb25kZW5jaWEtcmVjaWJpZGEiO3M6NToicm91dGUiO3M6MzM6ImVtcGxlYWRvLmNvcnJlc3BvbmRlbmNpYV9yZWNpYmlkYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjEwOiIxMDA1OTEyMDA4Ijt9', 1773265833),
('VZRhZmL9sCDPHY8RZa27EIc2GAgCmpNdw0G7RihZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUk9RbzRBVWxlWkZDc3F5a0hMYkhDdHdGMEJpMThDaDVEcHAyejg4YyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlbWl0ZW50ZS9leHRlcm5hcmVjIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTU6ImxvY2tvdXRfc2Vjb25kcyI7aTozMDA7czo1NjoibG9naW5fcmVtaXRlbnRlXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTIzNDU2Nzg4ODt9', 1773171254),
('xgQQKFKvQGOQiq1X0NTALCILxvgyGMyqubZRaeOb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1lkd0pQYjM2WXNQc21zd2tCeUNmTThwWkZueTlCWVAzM2phVER5dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo5OiJ3ZWIuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1773180888);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(20) NOT NULL,
  `tipo_nombre` varchar(100) DEFAULT NULL,
  `id_prioridad` int(10) DEFAULT NULL,
  `dias_respuesta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo_nombre`, `id_prioridad`, `dias_respuesta`) VALUES
(1, 'Derecho de Peticion', 1, NULL),
(2, 'Queja', NULL, NULL),
(3, 'Reclamo', NULL, NULL),
(4, 'Solicitud', 1, 10),
(5, 'Carta', NULL, NULL),
(6, 'Memorando', NULL, NULL),
(7, 'Circular', NULL, NULL),
(8, 'Resolucion', NULL, NULL),
(9, 'Contrato', NULL, NULL);

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
  ADD KEY `id_detalle_idx` (`id_detalle`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

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
  ADD KEY `det_id_recibido` (`det_id_recibido`);

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
  ADD KEY `envio_ibfk_1` (`doc_quien_dirigido`),
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
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `anexo_respuesta`
--
ALTER TABLE `anexo_respuesta`
  MODIFY `id_anexo_resp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_envio`
--
ALTER TABLE `detalle_envio`
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  MODIFY `id_det_recibido` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `password_codes`
--
ALTER TABLE `password_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `recibido`
--
ALTER TABLE `recibido`
  MODIFY `id_recibido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `fk_anexo_respuesta` FOREIGN KEY (`id_detalle`) REFERENCES `detalle_envio` (`id_detalle`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `detalle_recibido_ibfk_2` FOREIGN KEY (`det_id_recibido`) REFERENCES `recibido` (`id_recibido`);

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
  ADD CONSTRAINT `envio_ibfk_1` FOREIGN KEY (`doc_quien_dirigido`) REFERENCES `remitente` (`rem_doc`),
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
