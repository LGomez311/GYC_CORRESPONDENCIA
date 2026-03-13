-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2026 at 07:14 PM
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
(3, 7, 'archivos/unSMNxx6XdLhqb7bh1Hx5waaiVmvaiu98iIHNQNY.pdf', 'LEGALIZACION 2586-2026 (3) (1) (1).pdf'),
(4, 7, 'archivos/5mxVv0ix5paQrOtU7Yz8Yjq0Ownk2SUS7iNu6Lq7.pdf', 'EVALUACION (1).PDF'),
(5, 8, 'archivos/0kclb2r2uAb8bb6iHbVN3ZOkpo8yMlKWt3m1Ci3W.pdf', 'CO1_PCCNTR_9148107_En ejecución (2).pdf'),
(6, 8, 'archivos/fj5HcBzaPcPvZQH8M8QaVi8pHXhkAm8GMEwZ4CN0.pdf', 'CO1_PCCNTR_9148107_Firmado (1).pdf'),
(7, 9, 'archivos/gc6qlPyUlZhPNQSEcmFbrdjNXp08iLBGfSRjofpa.pdf', 'Coursera Como Resolver Problemas.pdf'),
(8, 9, 'archivos/cRLr9nx0FqkAJcTNhoy8eNS2MP24f5pzOWYZtYRk.pdf', 'Coursera Generative IA.pdf'),
(9, 9, 'archivos/pR72DJdDBBa2TDuJyCC4uMt1SC2Obze2lMfjWJ0l.pdf', 'ACTIVITY COMPARATIVE AND SUPERLATIVE.pdf');

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
(1, 4, 'correspondencia/OGeGdHbG0Q2AluON4C2zDhrsvbSaiYVYf3nLe0WT.pdf', 'cedula.pdf'),
(2, 5, 'correspondencia/6Na9vbl7kNdXXG4nmMvB5Bztr3BwIVZ5Wsxdu5X8.pdf', 'cedula.pdf'),
(3, 5, 'correspondencia/3O1NBZ0s4Eh8eYjNHqZHICVvRpat2fDEgQREv83E.pdf', '2.pdf'),
(4, 5, 'correspondencia/MhK4u9WEzrdQ9a9CCtS03LDelXTNfFIgV5WXkwM3.pdf', '1.pdf'),
(5, 6, 'correspondencia/Bl5QN8X7D54KSqYwukk8qZFHoOkc3EtEkqiA8bIT.pdf', 'cedula.pdf'),
(6, 6, 'correspondencia/XLTAWv4H3kTZUvoxunUj2PSSwZ2UPkiZTUWBA3Kf.pdf', '2.pdf'),
(7, 6, 'correspondencia/MYj8hgWj6EKriVKkCGrlxPTM6nzLhoX838oIuuYe.pdf', '1.pdf'),
(8, 7, 'correspondencia/v2RSvKXkvhVSjuXGWCzuXUbYz20OkDcqD9ixOJhq.pdf', 'cedula.pdf'),
(9, 7, 'correspondencia/ssMLBIXgpwEBVAvXHZDR8CsuO8Wp4SoPAVFTpyxE.pdf', '2.pdf'),
(10, 7, 'correspondencia/CEvqdzQtgnBZ1sL3c7rGN1jtib09HW3X6n53tuj8.pdf', '1.pdf'),
(11, 9, 'correspondencia/2M0Yqmu9pBjEcsQUaKrvOq8yO98pASbvlzD41Zol.pdf', 'cedula.pdf'),
(12, 9, 'correspondencia/czUgS16MIqpEZgAOKKMRik6rE7U9eHBpJYXKouMg.pdf', '2.pdf'),
(13, 9, 'correspondencia/B3MsDb3JKAHnS92Yj6OdpgZq0lRzqd8Icpp0mmQe.pdf', '1.pdf'),
(14, 10, 'correspondencia/c8PoqM40ia1KiaRu8owt4Ij4snzy4B2Hm3ECFD8P.pdf', 'cedula.pdf'),
(15, 10, 'correspondencia/d7p8gjpYoQUi12WimlcyxJfbsrFLt95WZFxt8wAe.pdf', '2.pdf'),
(16, 10, 'correspondencia/Edc4f281yirKzvCyB3Mxf0mrcLM3tRSykKhKCwLp.pdf', '1.pdf');

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

--
-- Dumping data for table `anexo_respuesta`
--

INSERT INTO `anexo_respuesta` (`id_anexo_resp`, `id_detalle`, `ruta_archivo`, `nombre_original`) VALUES
(1, 23, 'archivos/3L4zvedcK82TMhrY46WMYuv8TDX9sniI6PsLMiMz.pdf', 'ds08001136720892600011e0a.pdf'),
(2, 26, 'archivos/0qgWgVnTYK44xvgw92pQz4brgElValSzX89cLbkG.pdf', 'pagos (1).pdf'),
(3, 26, 'archivos/VMPNjduOJzVdbi4p0H47251L8Rsk2DLTyhbjZH5Y.pdf', 'empresas_sistema.pdf'),
(4, 29, 'archivos/lRmMfpZM1ZLzKkeV5VlCdQk6pKECVg6S6wAHTJAv.pdf', 'DOCUMENTOS COMPLETOS DANIEL.pdf'),
(5, 29, 'archivos/0lLxVJCGKSxvDjcXkAfpMl65NAIWT7V37s12QpGr.pdf', 'CARRO SEGUIDOR DE LINEA DANIEL GOMEZ Y RAMIRO GOMEZ.pdf');

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
(21, '1005912006', '1005912008', 7, '2026-03-08 06:01:14', 7, 'Necesito saber que paso con mis cuentas', NULL, NULL),
(22, '1005912006', '1005912008', 7, '2026-03-08 06:01:57', 8, NULL, NULL, 0),
(23, '1005912006', '1005912008', 7, '2026-03-08 06:02:41', 9, 'proceso INT-2026-50234 finalizado', 'archivos/rlzxqUpMBGaGYf5zB3kkj0pySMgys2rNn3W1wnK3.pdf', 5),
(24, '1005912008', '1005912006', 8, '2026-03-08 06:04:56', 7, NULL, NULL, NULL),
(25, '1005912008', '1005912006', 8, '2026-03-08 06:05:04', 8, NULL, NULL, 0),
(26, '1005912008', '1005912006', 8, '2026-03-08 06:06:37', 9, 'se dio respuesta a Radicado INT-2026-64218', 'archivos/ZBsGSrmu9o2XcMbEXqQY5NZOCjqcELs2g5svlhLv.pdf', 5),
(27, '1005912008', '1005912006', 9, '2026-03-09 18:18:24', 7, 'Follatón', NULL, NULL),
(28, '1005912008', '1005912006', 9, '2026-03-09 18:23:14', 8, 'se empezo con el tramite del Radicado INT-2026-65886', NULL, 0),
(29, '1005912008', '1005912006', 9, '2026-03-09 18:25:44', 9, 'se resolvio  Radicado INT-2026-65886', 'archivos/vNvKCTgdy55RIRaMI7V64r4K4ubgD9JGoj06EHfb.pdf', 5);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_recibido`
--

CREATE TABLE `detalle_recibido` (
  `id_det_recibido` int(15) NOT NULL,
  `det_id_recibido` int(20) NOT NULL,
  `det_doc_empleado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detalle_recibido`
--

INSERT INTO `detalle_recibido` (`id_det_recibido`, `det_id_recibido`, `det_doc_empleado`) VALUES
(1, 6, '1005912008'),
(2, 6, '1070730214'),
(3, 6, '1005912003'),
(4, 7, '1070730214'),
(5, 7, '1005912008'),
(6, 8, '1070730214'),
(7, 9, '1005912008'),
(8, 9, '1070730214'),
(9, 9, '1005912003'),
(10, 10, '1005912008'),
(11, 10, '1070730214'),
(12, 10, '1005912003'),
(13, 11, '1070730214'),
(14, 12, '1070730214');

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
('1070730214', '9887978978', '$2y$12$qTSxTGQa105rqOxqNJHKduU.GchvUS3rOyXjmmtqXF3GuCcpXO2IW', 'Yuber', 'Paez', '3202534042', 'santiagopc333@gmail.com', NULL, 1, 3, 1);

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
  `anexo` varchar(500) DEFAULT NULL,
  `folio` int(20) NOT NULL,
  `id_tipo_envio` int(11) DEFAULT NULL,
  `id_estado_envio` int(10) DEFAULT NULL,
  `archivo` varchar(500) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `envio`
--

INSERT INTO `envio` (`id_envio`, `num_radicado_int`, `asunto`, `doc_quien_dirigido`, `doc_quien_envia`, `fecha`, `destino`, `anexo`, `folio`, `id_tipo_envio`, `id_estado_envio`, `archivo`, `nit_empresa`) VALUES
(7, 16, 'CUENTAS', NULL, '1005912006', '2026-03-08 06:01:14', 'Interno', NULL, 20, 4, 7, 'archivos/hJlORhHG46cMVdvzTZLejYUSvW2QkLuC7pJXlgAL.pdf', '9887978978'),
(8, 17, 'Reclamo no me llega tal', NULL, '1005912008', '2026-03-08 06:04:56', 'Interno', NULL, 20, 3, 7, 'archivos/jpluLhMPzQfdalDII5yuMB6Al9whgyiEGGgTQ2wR.pdf', '9887978978'),
(9, 18, 'Follatón', NULL, '1005912008', '2026-03-09 18:18:24', 'Interno', NULL, 8, 4, 7, 'archivos/oSEbDI0eVS16z3waOUKdh5akhj8LeRajEn3D37jX.pdf', '9887978978');

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
(12, 'Enviado');

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
(34, 1, 61, '2026-03-02 22:49:42', '2026-03-10 22:49:42', 'ACTIVACION', NULL);

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
(61, 4, NULL, '1005912003', 'COP', 4, '2026-03-02 22:49:33', NULL);

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
(16, 'INT-2026-50234', '9887978978'),
(17, 'INT-2026-64218', '9887978978'),
(18, 'INT-2026-65886', '9887978978'),
(19, 'INT-2026-34564', '9887978978'),
(20, 'INT-2026-95974', '9887978978'),
(21, 'INT-2026-64115', '9887978978'),
(22, 'INT-2026-43279', '9887978978'),
(25, 'INT-2026-94852', '9887978978'),
(26, 'INT-2026-14031', '9887978978'),
(27, 'INT-2026-56022', '9887978978'),
(28, 'INT-2026-44876', '9887978978'),
(29, 'INT-2026-56415', '9887978978'),
(30, 'INT-2026-54102', '9887978978'),
(31, 'INT-2026-61963', '9887978978');

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
(1, '12345', 16, 'Follatón', '2026-03-09 13:35:59', 'Alcaldia', '25001', 5, 'pdf', 'ninguna', 1234567888, 1, 7, 'correspondencia/mZBduSfmhO7wcPr5HDLSflksITLoaMdwjuTtUfuZ.pdf', '9887978978', NULL, NULL, NULL, NULL),
(2, '12345', 19, 'Derecho de peticion', '2026-03-09 14:54:31', 'Alcaldia', '25001', 5, 'ninguno', 'nada', 1234567888, 9, 12, 'correspondencia/5NXH2r6ixLKWf98SwCjFd7JDXzdr1gtmjok4xRvI.pdf', '9887978978', NULL, NULL, NULL, NULL),
(3, '12345', 20, 'Derecho de peticion', '2026-03-09 16:47:25', 'Alcaldia', '11001', 5, 'nada', 'ninguna', 1234567888, 1, 12, 'correspondencia/pxqE7t9I9a906LDR30HWMzL86qV7GWzrjxqCLvwu.pdf', '9887978978', NULL, NULL, NULL, NULL),
(4, NULL, 21, 'Derecho de peticion', '2026-03-09 17:20:55', 'Alcaldia', '05001', 6, 'nada', 'nada', 1234567888, 1, 12, 'correspondencia/ninSNDBNasg4jwsHiUXqWKyT2X1esYsMVkTEAOqS.pdf', '9887978978', NULL, NULL, NULL, NULL),
(5, NULL, 22, 'Derecho de peticion', '2026-03-10 13:07:09', 'Alcaldia', '05001', 15, NULL, NULL, 1234567888, 4, 12, 'correspondencia/AY8DTZb8nVGA3Z0AS0PItTZV8srgOf3u5Dth7sQS.pdf', '9887978978', NULL, NULL, NULL, NULL),
(6, '12345', 25, 'Derecho de peticion', '2026-03-10 13:57:22', 'Alcaldia', '05001', 50, NULL, 'nadaaaaaaa', 1234567888, 1, 12, 'correspondencia/bNNdNrWsP3JlGP58yiE06GT897aMCC0baWV3YAq5.pdf', '9887978978', NULL, NULL, NULL, NULL),
(7, NULL, 26, 'Derecho de peticion', '2026-03-10 14:35:23', 'Persona de prueba', '05001', 60, NULL, 'no responder', 1234567888, 1, 12, 'correspondencia/FLKKPTb6LEk13tVFFiVYpob1xpDzxgXCIchIyFdM.pdf', '9887978978', 'Persona de prueba', '1234567890', 'prueba@gmail.com', '3202534042'),
(8, '12345', 27, 'Derecho de peticion', '2026-03-10 14:36:37', 'Persona de pruebaaaaaaaa', '73001', 1, NULL, 'no rrrrr', 1234567888, 1, 12, 'correspondencia/Dsps1PyfY55DJTWLMzT59auFugi95dPodGpV24of.pdf', '9887978978', 'Persona de pruebaaaaaaaa', '1234567890', 'prueba@gmail.com', '3202534042222'),
(9, NULL, 28, 'solicitud', '2026-03-10 16:11:35', 'Persona de pruebaa', '05001', 50, NULL, 'nada', 1234567888, 4, 12, 'correspondencia/sbD1G62UzsEpbgxwUFqLWryHGsaea88fdoejesyN.pdf', '9887978978', 'Persona de pruebaa', '1234567890', 'prueba@gmail.com', '3202534042222'),
(10, '12345', 29, 'solicitud', '2026-03-10 16:15:57', 'Alcaldia', '05001', 50, NULL, 'nada', 1234567888, 4, 12, 'correspondencia/Yvj0lKWReW0mwHULGIWVyWYjRtLzS1L020OJbNhC.pdf', '9887978978', NULL, NULL, NULL, NULL),
(11, NULL, 30, 'solicitud', '2026-03-10 16:16:57', NULL, '05001', 1, NULL, 'nada', 1234567888, 4, 12, 'correspondencia/0gPl9nRHPL4nuhJVdew0JVS5pitASqPgjYQpVwJr.pdf', '9887978978', 'Persona de prueba', '1234567890', 'prueba@gmail.com', '3202534042222'),
(12, '12345', 31, 'solicitud', '2026-03-10 16:35:45', 'Alcaldia', '05001', 1, NULL, 'nada', 1234567888, 1, 12, 'correspondencia/faDBHfrroemyJV2ZqS9kKWtnFJui1BLuBrdNLrya.pdf', '9887978978', NULL, NULL, NULL, NULL);

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
(3, 'Empleado');

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
('BacLH4WNox4g0OgpJOFqu29Ut2Jkn4lycW6v7wAG', 1234567888, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoieEF3cjBvWUlJbm9WaHh0eW5JYmRxM0JGM1BMZmRSbTZ5cnpnNm5XbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlbWl0ZW50ZS9leHRlcm5hcmVjIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZW1pdGVudGUvZXh0ZXJuYXJlYyI7czo1OiJyb3V0ZSI7czoyMDoicmVtaXRlbnRlLmV4dGVybmFyZWMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU2OiJsb2dpbl9yZW1pdGVudGVfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxMjM0NTY3ODg4O30=', 1773181497),
('VZRhZmL9sCDPHY8RZa27EIc2GAgCmpNdw0G7RihZ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUk9RbzRBVWxlWkZDc3F5a0hMYkhDdHdGMEJpMThDaDVEcHAyejg4YyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3JlbWl0ZW50ZS9leHRlcm5hcmVjIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTU6ImxvY2tvdXRfc2Vjb25kcyI7aTozMDA7czo1NjoibG9naW5fcmVtaXRlbnRlXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTIzNDU2Nzg4ODt9', 1773171254),
('xgQQKFKvQGOQiq1X0NTALCILxvgyGMyqubZRaeOb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1lkd0pQYjM2WXNQc21zd2tCeUNmTThwWkZueTlCWVAzM2phVER5dyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo5OiJ3ZWIuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1773180888);

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
(1, 'Derecho de Peticion', 1, NULL),
(2, 'Queja', NULL, NULL),
(3, 'Reclamo', NULL, NULL),
(4, 'Solicitud', NULL, NULL),
(5, 'Carta', NULL, NULL),
(6, 'Memorando', NULL, NULL),
(7, 'Circular', NULL, NULL),
(8, 'Resolucion', NULL, NULL),
(9, 'Contrato', NULL, NULL);

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
  ADD KEY `det_id_recibido` (`det_id_recibido`);

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
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `anexo_recibido`
--
ALTER TABLE `anexo_recibido`
  MODIFY `id_anexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `detalle_recibido`
--
ALTER TABLE `detalle_recibido`
  MODIFY `id_det_recibido` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `envio`
--
ALTER TABLE `envio`
  MODIFY `id_envio` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id_licencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

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
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `recibido`
--
ALTER TABLE `recibido`
  MODIFY `id_recibido` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `detalle_recibido_ibfk_2` FOREIGN KEY (`det_id_recibido`) REFERENCES `recibido` (`id_recibido`);

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
