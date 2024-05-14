-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-05-2024 a las 15:54:08
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdblog_laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Clase', NULL, NULL),
(2, 'Gimnasio', NULL, NULL),
(3, 'Tiempo Libre', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

DROP TABLE IF EXISTS `entradas`;
CREATE TABLE IF NOT EXISTS `entradas` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `categoria_id` int NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hora` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prioridad` int DEFAULT NULL,
  `estado` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `entradas`
--

INSERT INTO `entradas` (`id`, `usuario_id`, `categoria_id`, `titulo`, `descripcion`, `imagen`, `fecha`, `created_at`, `updated_at`, `hora`, `lugar`, `prioridad`, `estado`) VALUES
(20, 18, 1, 'Examen Presencial', '<p>Examen presencial Laravel</p>', '1715700310-R.jpg', '2024-05-14', '2024-05-14 13:07:08', '2024-05-14 13:25:10', '16:10', 'IES San Sebastián', 4, 'pendiente'),
(21, 18, 2, 'Rutina de pierna', '<p>Rutina de pierna variada de 2h + cardio</p>', '----', '2024-05-16', '2024-05-14 13:08:10', '2024-05-14 13:08:10', '09:00', 'Gimnasio Aljaraque', 3, 'pendiente'),
(23, 18, 3, 'Carrera F1', '<p>Carrera F1 Emilglia Romania</p>', '1715700164-OIP.jpg', '2024-05-19', '2024-05-14 13:22:44', '2024-05-14 13:22:44', '17:00', 'Casa', 5, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `operacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `usuario`, `operacion`, `fecha`, `created_at`, `updated_at`) VALUES
(16, 'Admin', 'Registro', '2024-05-04 16:25:14', '2024-05-04 14:25:14', '2024-05-04 14:25:14'),
(17, 'user', 'Registro', '2024-05-04 16:28:25', '2024-05-04 14:28:25', '2024-05-04 14:28:25'),
(18, 'user', 'Registro', '2024-05-04 17:07:33', '2024-05-04 15:07:33', '2024-05-04 15:07:33'),
(19, 'user', 'Nueva entrada', '2024-05-04 17:10:36', '2024-05-04 15:10:36', '2024-05-04 15:10:36'),
(20, 'user', 'Nueva entrada', '2024-05-04 17:53:51', '2024-05-04 15:53:51', '2024-05-04 15:53:51'),
(21, 'user', 'Nueva entrada', '2024-05-04 17:53:59', '2024-05-04 15:53:59', '2024-05-04 15:53:59'),
(22, 'user', 'Nueva entrada', '2024-05-04 17:53:59', '2024-05-04 15:53:59', '2024-05-04 15:53:59'),
(23, 'user', 'Nueva entrada', '2024-05-04 17:54:05', '2024-05-04 15:54:05', '2024-05-04 15:54:05'),
(24, 'Admin', 'Registro', '2024-05-04 18:34:15', '2024-05-04 16:34:15', '2024-05-04 16:34:15'),
(25, 'user', 'Nueva entrada', '2024-05-04 18:50:57', '2024-05-04 16:50:57', '2024-05-04 16:50:57'),
(26, 'user', 'Entrada Eliminada', '2024-05-04 18:53:37', '2024-05-04 16:53:37', '2024-05-04 16:53:37'),
(27, 'Admin', 'Nueva entrada', '2024-05-14 14:26:47', '2024-05-14 12:26:47', '2024-05-14 12:26:47'),
(28, 'Admin', 'Edición entrada', '2024-05-14 14:42:52', '2024-05-14 12:42:52', '2024-05-14 12:42:52'),
(29, 'Admin', 'Entrada Eliminada', '2024-05-14 14:43:59', '2024-05-14 12:43:59', '2024-05-14 12:43:59'),
(30, 'Admin', 'Nueva entrada', '2024-05-14 14:45:24', '2024-05-14 12:45:24', '2024-05-14 12:45:24'),
(31, 'Admin', 'Entrada Eliminada', '2024-05-14 15:05:12', '2024-05-14 13:05:12', '2024-05-14 13:05:12'),
(32, 'Josema', 'Registro', '2024-05-14 15:05:51', '2024-05-14 13:05:51', '2024-05-14 13:05:51'),
(33, 'Josema', 'Nueva entrada', '2024-05-14 15:07:08', '2024-05-14 13:07:08', '2024-05-14 13:07:08'),
(34, 'Josema', 'Nueva entrada', '2024-05-14 15:08:10', '2024-05-14 13:08:10', '2024-05-14 13:08:10'),
(35, 'Josema', 'Nueva entrada', '2024-05-14 15:09:52', '2024-05-14 13:09:52', '2024-05-14 13:09:52'),
(36, 'Josema', 'Edición entrada', '2024-05-14 15:15:05', '2024-05-14 13:15:05', '2024-05-14 13:15:05'),
(37, 'Josema', 'Entrada Eliminada', '2024-05-14 15:22:11', '2024-05-14 13:22:11', '2024-05-14 13:22:11'),
(38, 'Josema', 'Nueva entrada', '2024-05-14 15:22:44', '2024-05-14 13:22:44', '2024-05-14 13:22:44'),
(39, 'Josema', 'Edición entrada', '2024-05-14 15:23:28', '2024-05-14 13:23:28', '2024-05-14 13:23:28'),
(40, 'Josema', 'Edición entrada', '2024-05-14 15:23:45', '2024-05-14 13:23:45', '2024-05-14 13:23:45'),
(41, 'Josema', 'Edición entrada', '2024-05-14 15:25:10', '2024-05-14 13:25:10', '2024-05-14 13:25:10'),
(42, 'Profesor', 'Registro', '2024-05-14 15:38:07', '2024-05-14 13:38:07', '2024-05-14 13:38:07'),
(43, 'Profesor', 'Nueva entrada', '2024-05-14 15:39:28', '2024-05-14 13:39:28', '2024-05-14 13:39:28'),
(44, 'Profesor', 'Entrada Eliminada', '2024-05-14 15:39:47', '2024-05-14 13:39:47', '2024-05-14 13:39:47'),
(45, 'Profesor', 'Nueva entrada', '2024-05-14 15:40:19', '2024-05-14 13:40:19', '2024-05-14 13:40:19'),
(46, 'Profesor', 'Entrada Eliminada', '2024-05-14 15:40:23', '2024-05-14 13:40:23', '2024-05-14 13:40:23'),
(47, 'Profesor', 'Nueva entrada', '2024-05-14 15:41:19', '2024-05-14 13:41:19', '2024-05-14 13:41:19'),
(48, 'Profesor', 'Edición entrada', '2024-05-14 15:43:00', '2024-05-14 13:43:00', '2024-05-14 13:43:00'),
(49, 'Profesor', 'Edición entrada', '2024-05-14 15:43:42', '2024-05-14 13:43:42', '2024-05-14 13:43:42'),
(50, 'Profesor', 'Entrada Eliminada', '2024-05-14 15:45:33', '2024-05-14 13:45:33', '2024-05-14 13:45:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2023_05_08_091806_create_usuarios_table', 1),
(18, '2023_05_08_092028_create_categorias_table', 1),
(19, '2023_05_08_092054_create_entradas_table', 1),
(20, '2023_05_10_085747_create_logs_table', 2),
(21, '0001_01_01_000000_create_users_table', 3),
(22, '0001_01_01_000001_create_cache_table', 3),
(23, '0001_01_01_000002_create_jobs_table', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nick` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen-avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `esAdmin` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nick`, `nombre`, `apellidos`, `email`, `password`, `imagen-avatar`, `esAdmin`, `created_at`, `updated_at`) VALUES
(18, 'Josema', 'Jose Maria', 'Cruz Regalado', 'test@test.com', '$2y$12$GlLeuzuncs6vhtfMvdZhYO4G1qFfQGEZO4boOYh7CUYWTYximxbsO', NULL, 0, '2024-05-14 13:05:51', '2024-05-14 13:05:51'),
(19, 'Profesor', 'Manuel Alfonso', 'Romero Caro', 'profesor@profesor.test', '$2y$12$0GCkyYlfeMXmC9YB1DK00ekvqCwHwdiV7e99ntsOLQEEuig0B1S6q', NULL, 0, '2024-05-14 13:38:07', '2024-05-14 13:38:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
