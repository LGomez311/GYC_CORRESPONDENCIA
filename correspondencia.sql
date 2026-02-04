-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2026 at 10:05 PM
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
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id_area` int(20) NOT NULL,
  `area_nom` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_ciudad` int(20) NOT NULL,
  `ciudad_nom` varchar(100) DEFAULT NULL,
  `ciudad_cod_post` varchar(10) DEFAULT NULL,
  `ciudad_id_dpto` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(20) NOT NULL,
  `dpto_nombre` varchar(100) DEFAULT NULL,
  `dpto_codigo_postal` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_envio`
--

CREATE TABLE `detalle_envio` (
  `id_detalle` int(10) NOT NULL,
  `id_quien_envie` int(15) NOT NULL,
  `id_quien_recibe` int(15) NOT NULL,
  `id_envio` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE `empleado` (
  `emple_doc` int(20) NOT NULL,
  `nit_empresa` varchar(25) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `emple_nombres` varchar(25) DEFAULT NULL,
  `emple_apellidos` varchar(25) DEFAULT NULL,
  `emple_tel` varchar(25) DEFAULT NULL,
  `emple_correo` varchar(255) DEFAULT NULL,
  `emple_img` varchar(500) DEFAULT NULL,
  `emple_estado` int(20) DEFAULT NULL,
  `emple_rol` int(20) DEFAULT NULL,
  `emple_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`emple_doc`, `nit_empresa`, `password`, `emple_nombres`, `emple_apellidos`, `emple_tel`, `emple_correo`, `emple_img`, `emple_estado`, `emple_rol`, `emple_area`) VALUES
(1001, NULL, '$2y$12$ipkGIRI86WapHF7i9cT6meu.6aVgg.qox1Y7t1Ek5hCE8ISDIb/c2', 'Kevin', 'Villafrade', NULL, 'kevin@gmail.com', NULL, 1, 1, NULL),
(1002, NULL, '$2y$12$LWO14So.uSotCedN4ZOsbedPxbXwu1Fer2DwScs0Rz1gybCkV2xBO', 'Luis', 'Gomez', NULL, 'luis@gmail.com', NULL, 1, 2, NULL),
(1003, NULL, '$2y$12$D/IFN/RIgdO.pfvfZql2WulD8j8abFaYrOdKC/JqJHTDheJ.avaOO', 'Yuber', 'Paez', NULL, 'yuber@gmail.com', NULL, 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE `empresa` (
  `nit_empresa` varchar(25) NOT NULL,
  `nomb_empresa` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `envio`
--

CREATE TABLE `envio` (
  `id_envio` int(10) NOT NULL,
  `num_radicado_int` int(20) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `doc_quien_dirigido` int(15) DEFAULT NULL,
  `doc_quien_envia` int(15) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `destino` varchar(200) DEFAULT NULL,
  `anexo` varchar(500) NOT NULL,
  `id_tipo_envio` int(11) DEFAULT NULL,
  `id_estado_envio` int(10) DEFAULT NULL,
  `archivo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Activo'),
(2, 'Inactivo');

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
  `id_licencia` int(10) NOT NULL,
  `id_plan` int(10) NOT NULL,
  `id_estado` int(20) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` varchar(10) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL,
  `id_plan` int(10) NOT NULL,
  `paypal_order_id` varchar(100) NOT NULL,
  `paypal_payer_id` varchar(100) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `moneda` varchar(10) NOT NULL,
  `id_est_pago` enum('CREATED','APPROVED','COMPLETE','FAILED','CANCELLED') NOT NULL,
  `entorno` enum('SANDBOX','PRODUCTION','','') NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `fecha_pago` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `descripcion` varchar(255) NOT NULL,
  `duracion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prioridad`
--

CREATE TABLE `prioridad` (
  `id_prioridad` int(20) NOT NULL,
  `prioridad_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radicados`
--

CREATE TABLE `radicados` (
  `id_radicado` int(10) NOT NULL,
  `num_radicado` varchar(100) NOT NULL,
  `id_est_radicado` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recibido`
--

CREATE TABLE `recibido` (
  `id_recibido` int(20) NOT NULL,
  `num_radicado_ext` int(20) DEFAULT NULL,
  `num_radicado_int` int(20) NOT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `fecha_hora_recib` datetime DEFAULT NULL,
  `nom_institucion` varchar(150) NOT NULL,
  `ciudad_proveniente` int(20) NOT NULL,
  `folio` int(20) NOT NULL,
  `anexo` varchar(500) DEFAULT NULL,
  `observaciones` varchar(250) DEFAULT NULL,
  `doc_quien_registra` int(20) DEFAULT NULL,
  `doc_quien_dirige` int(20) DEFAULT NULL,
  `id_tipo` int(20) DEFAULT NULL,
  `id_estado_rec` int(10) DEFAULT NULL,
  `archivo` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remitente`
--

CREATE TABLE `remitente` (
  `rem_doc` int(20) NOT NULL,
  `nit_empresa` varchar(25) NOT NULL,
  `rem_nombres` varchar(50) NOT NULL,
  `rem_apellidos` varchar(50) NOT NULL,
  `rem_correo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rem_tel` varchar(20) NOT NULL,
  `rem_ciudad` int(10) NOT NULL,
  `rem_estado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
('kXlpzQL25QFhJa8Wpkx8x9NUwZZUQRqeD0i07XJ6', 1001, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTFiU1lNYmY4RXhaN0oxeVQxU21wbFhJZENlTmcyOVJGa3YyVm1idiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYWRtaW4vdXN1YXJpb3MiO3M6NToicm91dGUiO3M6NjoiY3VzZXJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTAwMTt9', 1770237461);

-- --------------------------------------------------------

--
-- Table structure for table `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(20) NOT NULL,
  `tipo_nombre` varchar(100) DEFAULT NULL,
  `id_prioridad` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `ciudad_id_dpto` (`ciudad_id_dpto`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indexes for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_envio` (`id_envio`),
  ADD KEY `id_quien_envie` (`id_quien_envie`),
  ADD KEY `id_quien_recibe` (`id_quien_recibe`);

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
  ADD PRIMARY KEY (`nit_empresa`);

--
-- Indexes for table `envio`
--
ALTER TABLE `envio`
  ADD PRIMARY KEY (`id_envio`),
  ADD KEY `doc_quien_envia` (`doc_quien_envia`),
  ADD KEY `id_tipo_envio` (`id_tipo_envio`),
  ADD KEY `id_estado_envio` (`id_estado_envio`),
  ADD KEY `envio_ibfk_1` (`doc_quien_dirigido`),
  ADD KEY `num_radicado_int` (`num_radicado_int`);

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
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_estado` (`id_estado`);

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
  ADD KEY `nit_empresa` (`nit_empresa`),
  ADD KEY `id_plan` (`id_plan`);

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
  ADD KEY `id_est_radicado` (`id_est_radicado`);

--
-- Indexes for table `recibido`
--
ALTER TABLE `recibido`
  ADD PRIMARY KEY (`id_recibido`),
  ADD KEY `doc_quien_dirige` (`doc_quien_dirige`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `id_estado_rec` (`id_estado_rec`),
  ADD KEY `doc_quien_registra` (`doc_quien_registra`),
  ADD KEY `num_radicado_int` (`num_radicado_int`),
  ADD KEY `ciudad_proveniente` (`ciudad_proveniente`);

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
-- AUTO_INCREMENT for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  MODIFY `id_detalle` int(10) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `radicados`
--
ALTER TABLE `radicados`
  MODIFY `id_radicado` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ciudad`
--
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_ibfk_1` FOREIGN KEY (`ciudad_id_dpto`) REFERENCES `departamento` (`id_departamento`);

--
-- Constraints for table `detalle_envio`
--
ALTER TABLE `detalle_envio`
  ADD CONSTRAINT `detalle_envio_ibfk_1` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id_envio`),
  ADD CONSTRAINT `detalle_envio_ibfk_2` FOREIGN KEY (`id_quien_envie`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `detalle_envio_ibfk_3` FOREIGN KEY (`id_quien_recibe`) REFERENCES `empleado` (`emple_doc`);

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
  ADD CONSTRAINT `envio_ibfk_6` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`);

--
-- Constraints for table `licencia`
--
ALTER TABLE `licencia`
  ADD CONSTRAINT `licencia_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `plan` (`id_plan`),
  ADD CONSTRAINT `licencia_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`);

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`),
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_plan`) REFERENCES `plan` (`id_plan`);

--
-- Constraints for table `radicados`
--
ALTER TABLE `radicados`
  ADD CONSTRAINT `radicados_ibfk_1` FOREIGN KEY (`id_est_radicado`) REFERENCES `estado` (`id_estado`);

--
-- Constraints for table `recibido`
--
ALTER TABLE `recibido`
  ADD CONSTRAINT `recibido_ibfk_2` FOREIGN KEY (`doc_quien_dirige`) REFERENCES `empleado` (`emple_doc`),
  ADD CONSTRAINT `recibido_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id_tipo`),
  ADD CONSTRAINT `recibido_ibfk_4` FOREIGN KEY (`id_estado_rec`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `recibido_ibfk_5` FOREIGN KEY (`doc_quien_registra`) REFERENCES `remitente` (`rem_doc`),
  ADD CONSTRAINT `recibido_ibfk_7` FOREIGN KEY (`num_radicado_int`) REFERENCES `radicados` (`id_radicado`),
  ADD CONSTRAINT `recibido_ibfk_8` FOREIGN KEY (`ciudad_proveniente`) REFERENCES `ciudad` (`id_ciudad`);

--
-- Constraints for table `remitente`
--
ALTER TABLE `remitente`
  ADD CONSTRAINT `remitente_ibfk_1` FOREIGN KEY (`rem_ciudad`) REFERENCES `ciudad` (`id_ciudad`),
  ADD CONSTRAINT `remitente_ibfk_2` FOREIGN KEY (`rem_estado`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `remitente_ibfk_3` FOREIGN KEY (`nit_empresa`) REFERENCES `empresa` (`nit_empresa`);

--
-- Constraints for table `tipo`
--
ALTER TABLE `tipo`
  ADD CONSTRAINT `tipo_ibfk_1` FOREIGN KEY (`id_prioridad`) REFERENCES `prioridad` (`id_prioridad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
