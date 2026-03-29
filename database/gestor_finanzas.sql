-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2026 a las 00:24:59
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
-- Base de datos: `gestor_finanzas`
--

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
('laravel-cache-filament-clear-cache', 'i:0;', 2088348701),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6', 'i:1;', 1773002842),
('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer', 'i:1773002842;', 1773002842);

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
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` enum('ingreso','egreso') NOT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `tipo`, `icono`, `color`, `descripcion`, `activa`, `created_at`, `updated_at`) VALUES
(1, 'Sueldo', 'ingreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:52:15', '2026-03-08 19:52:15'),
(2, 'Deudas', 'ingreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:52:25', '2026-03-08 19:52:25'),
(3, 'Dinero Encontrado', 'ingreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:53:19', '2026-03-08 19:53:35'),
(4, 'Cachuelitos', 'ingreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:54:05', '2026-03-08 19:54:05'),
(5, 'Transporte', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:54:39', '2026-03-08 19:54:39'),
(6, 'Vivienda', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:56:56', '2026-03-08 19:56:56'),
(7, 'Servicios', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:57:18', '2026-03-08 19:57:18'),
(8, 'Alimentación', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:57:27', '2026-03-08 19:57:27'),
(10, 'Finanzas', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:57:54', '2026-03-08 19:57:54'),
(11, 'Compras personales', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:03', '2026-03-08 19:58:03'),
(12, 'Entretenimiento', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:13', '2026-03-08 19:58:13'),
(13, 'Salud', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:23', '2026-03-08 19:58:23'),
(14, 'Educación', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:30', '2026-03-08 19:58:30'),
(15, 'Regalos y donaciones', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:41', '2026-03-08 19:58:41'),
(16, 'Viajes', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:49', '2026-03-08 19:58:49'),
(17, 'Otros gastos', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 19:58:59', '2026-03-08 19:58:59'),
(18, 'Sporting Cristal', 'egreso', NULL, '#3b82f6', NULL, 1, '2026-03-08 20:00:52', '2026-03-08 20:00:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo_cuenta` enum('banco','efectivo','billetera_digital','ahorro') NOT NULL,
  `saldo_inicial` decimal(12,2) NOT NULL DEFAULT 0.00,
  `saldo_actual` decimal(12,2) NOT NULL DEFAULT 0.00,
  `moneda` varchar(255) NOT NULL DEFAULT 'PEN',
  `descripcion` text DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`id`, `nombre`, `tipo_cuenta`, `saldo_inicial`, `saldo_actual`, `moneda`, `descripcion`, `activa`, `created_at`, `updated_at`) VALUES
(1, 'Cuenta Sueldo BCP', 'banco', 979.98, 979.98, 'PEN', 'La plata que esta en mi cuenta de sueldo que me queda :c', 1, '2026-03-08 19:40:38', '2026-03-08 19:40:38'),
(2, 'Yape', 'billetera_digital', 0.00, 0.00, 'PEN', 'Mi billetera digital', 1, '2026-03-08 19:42:54', '2026-03-08 19:42:54'),
(3, 'Efectivo', 'efectivo', 15.70, 15.70, 'PEN', 'Monto en efetcivo', 1, '2026-03-08 19:45:27', '2026-03-08 19:45:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exports`
--

CREATE TABLE `exports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_disk` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `exporter` varchar(255) NOT NULL,
  `processed_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_rows` int(10) UNSIGNED NOT NULL,
  `successful_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_import_rows`
--

CREATE TABLE `failed_import_rows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `import_id` bigint(20) UNSIGNED NOT NULL,
  `validation_error` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Estructura de tabla para la tabla `imports`
--

CREATE TABLE `imports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `importer` varchar(255) NOT NULL,
  `processed_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `total_rows` int(10) UNSIGNED NOT NULL,
  `successful_rows` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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

--
-- Volcado de datos para la tabla `job_batches`
--

INSERT INTO `job_batches` (`id`, `name`, `total_jobs`, `pending_jobs`, `failed_jobs`, `failed_job_ids`, `options`, `cancelled_at`, `created_at`, `finished_at`) VALUES
('a13f92b1-a2a8-4a32-8345-976e3514ce75', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6126:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:42:\"App\\Filament\\Exports\\TransferenciaExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:29:20\";s:10:\"created_at\";s:19:\"2026-03-07 23:29:20\";s:2:\"id\";i:1;s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:29:20\";s:10:\"created_at\";s:19:\"2026-03-07 23:29:20\";s:2:\"id\";i:1;s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2699:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:42:\"App\\Filament\\Exports\\TransferenciaExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:29:20\";s:10:\"created_at\";s:19:\"2026-03-07 23:29:20\";s:2:\"id\";i:1;s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:29:20\";s:10:\"created_at\";s:19:\"2026-03-07 23:29:20\";s:2:\"id\";i:1;s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:23:\"export-1-transferencias\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:1;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c580000000000000000\";}\";s:4:\"hash\";s:44:\"Eu5iF8uiCMhmluKyK8a5/MtJ5wnt7QeuDPXipvLKH3M=\";}}}}', NULL, 1772944161, 1772944162),
('a13f9340-62dc-4c40-acc0-8d8bcf982394', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6126:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:42:\"App\\Filament\\Exports\\TransferenciaExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:30:54\";s:10:\"created_at\";s:19:\"2026-03-07 23:30:54\";s:2:\"id\";i:2;s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:30:54\";s:10:\"created_at\";s:19:\"2026-03-07 23:30:54\";s:2:\"id\";i:2;s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2699:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:42:\"App\\Filament\\Exports\\TransferenciaExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:30:54\";s:10:\"created_at\";s:19:\"2026-03-07 23:30:54\";s:2:\"id\";i:2;s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:42:\"App\\Filament\\Exports\\TransferenciaExporter\";s:10:\"total_rows\";i:2;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:30:54\";s:10:\"created_at\";s:19:\"2026-03-07 23:30:54\";s:2:\"id\";i:2;s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:23:\"export-2-transferencias\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:2;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:8:{s:2:\"id\";s:2:\"ID\";s:16:\"cuenta_origen_id\";s:16:\"Cuenta origen id\";s:17:\"cuenta_destino_id\";s:17:\"Cuenta destino id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c570000000000000000\";}\";s:4:\"hash\";s:44:\"8393h1hj/dEZlAA5297HWkOIb+zX2kDwVaXpyIOms4w=\";}}}}', NULL, 1772944254, 1772944255),
('a13f9458-bdb0-46e3-a103-9f9d2dda8d8d', '', 2, 0, 0, '[]', 'a:2:{s:13:\"allowFailures\";b:1;s:7:\"finally\";a:1:{i:0;O:47:\"Laravel\\SerializableClosure\\SerializableClosure\":1:{s:12:\"serializable\";O:46:\"Laravel\\SerializableClosure\\Serializers\\Signed\":2:{s:12:\"serializable\";s:6670:\"O:46:\"Laravel\\SerializableClosure\\Serializers\\Native\":5:{s:3:\"use\";a:1:{s:4:\"next\";O:46:\"Filament\\Actions\\Exports\\Jobs\\ExportCompletion\":8:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\MovimientoExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\MovimientoExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:33:58\";s:10:\"created_at\";s:19:\"2026-03-07 23:33:58\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\MovimientoExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:33:58\";s:10:\"created_at\";s:19:\"2026-03-07 23:33:58\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:12:{s:2:\"id\";s:2:\"ID\";s:15:\"tipo_movimiento\";s:15:\"Tipo movimiento\";s:9:\"cuenta_id\";s:9:\"Cuenta id\";s:12:\"categoria_id\";s:12:\"Categoria id\";s:15:\"subcategoria_id\";s:15:\"Subcategoria id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"referencia\";s:10:\"Referencia\";s:13:\"es_recurrente\";s:13:\"Es recurrente\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:12:{s:2:\"id\";s:2:\"ID\";s:15:\"tipo_movimiento\";s:15:\"Tipo movimiento\";s:9:\"cuenta_id\";s:9:\"Cuenta id\";s:12:\"categoria_id\";s:12:\"Categoria id\";s:15:\"subcategoria_id\";s:15:\"Subcategoria id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"referencia\";s:10:\"Referencia\";s:13:\"es_recurrente\";s:13:\"Es recurrente\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0formats\";a:2:{i:0;E:47:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Csv\";i:1;E:48:\"Filament\\Actions\\Exports\\Enums\\ExportFormat:Xlsx\";}s:10:\"\0*\0options\";a:0:{}s:12:\"\0*\0authGuard\";s:3:\"web\";s:7:\"chained\";a:1:{i:0;s:2971:\"O:44:\"Filament\\Actions\\Exports\\Jobs\\CreateXlsxFile\":4:{s:11:\"\0*\0exporter\";O:39:\"App\\Filament\\Exports\\MovimientoExporter\":3:{s:9:\"\0*\0export\";O:38:\"Filament\\Actions\\Exports\\Models\\Export\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";N;s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:1;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\MovimientoExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:33:58\";s:10:\"created_at\";s:19:\"2026-03-07 23:33:58\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:11:\"\0*\0original\";a:8:{s:7:\"user_id\";i:1;s:8:\"exporter\";s:39:\"App\\Filament\\Exports\\MovimientoExporter\";s:10:\"total_rows\";i:1;s:9:\"file_disk\";s:5:\"local\";s:10:\"updated_at\";s:19:\"2026-03-07 23:33:58\";s:10:\"created_at\";s:19:\"2026-03-07 23:33:58\";s:2:\"id\";i:3;s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:10:\"\0*\0changes\";a:1:{s:9:\"file_name\";s:20:\"export-3-movimientos\";}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:4:{s:12:\"completed_at\";s:9:\"timestamp\";s:14:\"processed_rows\";s:7:\"integer\";s:10:\"total_rows\";s:7:\"integer\";s:15:\"successful_rows\";s:7:\"integer\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:0:{}s:10:\"\0*\0guarded\";a:0:{}}s:12:\"\0*\0columnMap\";a:12:{s:2:\"id\";s:2:\"ID\";s:15:\"tipo_movimiento\";s:15:\"Tipo movimiento\";s:9:\"cuenta_id\";s:9:\"Cuenta id\";s:12:\"categoria_id\";s:12:\"Categoria id\";s:15:\"subcategoria_id\";s:15:\"Subcategoria id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"referencia\";s:10:\"Referencia\";s:13:\"es_recurrente\";s:13:\"Es recurrente\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}s:9:\"\0*\0export\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:38:\"Filament\\Actions\\Exports\\Models\\Export\";s:2:\"id\";i:3;s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"mysql\";s:15:\"collectionClass\";N;}s:12:\"\0*\0columnMap\";a:12:{s:2:\"id\";s:2:\"ID\";s:15:\"tipo_movimiento\";s:15:\"Tipo movimiento\";s:9:\"cuenta_id\";s:9:\"Cuenta id\";s:12:\"categoria_id\";s:12:\"Categoria id\";s:15:\"subcategoria_id\";s:15:\"Subcategoria id\";s:5:\"monto\";s:5:\"Monto\";s:5:\"fecha\";s:5:\"Fecha\";s:11:\"descripcion\";s:11:\"Descripcion\";s:10:\"referencia\";s:10:\"Referencia\";s:13:\"es_recurrente\";s:13:\"Es recurrente\";s:10:\"created_at\";s:10:\"Created at\";s:10:\"updated_at\";s:10:\"Updated at\";}s:10:\"\0*\0options\";a:0:{}}\";}s:19:\"chainCatchCallbacks\";a:0:{}}}s:8:\"function\";s:266:\"function (\\Illuminate\\Bus\\Batch $batch) use ($next) {\n                if (! $batch->cancelled()) {\n                    \\Illuminate\\Container\\Container::getInstance()->make(\\Illuminate\\Contracts\\Bus\\Dispatcher::class)->dispatch($next);\n                }\n            }\";s:5:\"scope\";s:27:\"Illuminate\\Bus\\ChainedBatch\";s:4:\"this\";N;s:4:\"self\";s:32:\"0000000000000c8a0000000000000000\";}\";s:4:\"hash\";s:44:\"wrkBC/PQyN96J0XZkzWiq4ZcPa16Z4C5Jkay286kpOM=\";}}}}', NULL, 1772944438, 1772944439);

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
(4, '2026_03_07_145246_create_cuentas_table', 2),
(5, '2026_03_07_145433_create_categorias_table', 2),
(6, '2026_03_07_145538_create_subcategorias_table', 2),
(7, '2026_03_07_145702_create_movimientos_table', 2),
(8, '2026_03_07_155536_create_transferencias_table', 3),
(9, '2026_03_07_193459_add_avatar_to_users_table', 4),
(10, '2026_03_07_200508_add_custom_fields_to_users_table', 5),
(11, '2026_03_07_200509_add_avatar_url_to_users_table', 6),
(12, '2026_03_07_200510_add_locale_to_users_table', 6),
(13, '2026_03_07_200511_add_theme_color_to_users_table', 6),
(14, '2026_03_07_201317_add_locale_to_users_table', 7),
(15, '2026_03_07_201349_add_theme_color_to_users_table', 8),
(16, '2026_03_07_222516_create_settings_table', 9),
(17, '2026_03_07_232456_create_notifications_table', 10),
(18, '2026_03_07_232458_create_imports_table', 10),
(19, '2026_03_07_232459_create_exports_table', 10),
(20, '2026_03_07_232500_create_failed_import_rows_table', 10),
(21, '2026_03_08_090624_create_presupuestos_table', 11),
(22, '2026_03_08_091933_add_subcategoria_id_to_presupuestos_table', 12),
(23, '2026_03_08_092458_update_presupuestos_table_add_fecha_inicio_fin', 13),
(24, '2026_03_08_104421_add_recurrencia_fields_to_movimientos_table', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_movimiento` enum('ingreso','egreso','transferencia') NOT NULL,
  `cuenta_id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `subcategoria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `monto` decimal(12,2) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `es_recurrente` tinyint(1) NOT NULL DEFAULT 0,
  `frecuencia_recurrencia` enum('diario','semanal','mensual') DEFAULT NULL,
  `fecha_fin_recurrencia` date DEFAULT NULL,
  `ultima_ejecucion` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
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
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `subcategoria_id` bigint(20) UNSIGNED DEFAULT NULL,
  `monto_limite` decimal(12,2) NOT NULL,
  `periodo` enum('mensual','semanal','anual') NOT NULL DEFAULT 'mensual',
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id`, `categoria_id`, `subcategoria_id`, `monto_limite`, `periodo`, `fecha_inicio`, `fecha_fin`, `activo`, `created_at`, `updated_at`) VALUES
(1, 5, 20, 12.00, 'semanal', '2026-03-09', '2026-03-14', 1, '2026-03-08 20:36:29', '2026-03-08 20:36:29');

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
('U6cjd7FCztZ5s2WbBiFCP3QbXbpFgirk7vmmTwGP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNnhPNTc2V2RrTXFBaGIwUWt3TEsyNW1VT2V4aUQ2RFNSM3hZcVV1WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnRlLW1lbnN1YWwiO3M6NToicm91dGUiO3M6MzY6ImZpbGFtZW50LmFkbWluLnBhZ2VzLnJlcG9ydGUtbWVuc3VhbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImU5YTQ0ZmJlOTYwZmJkODJmODE0YjY4YmQ2NzBkNzY5ODA0OGE3MmY0Mjg2ZjU0NDg5NTcyYWVmYTRkMjI5NzkiO3M6NjoidGFibGVzIjthOjE6e3M6NDA6ImE2ZTY5ZDVmMDM2Y2I0OTQyMmE5YTg4M2Q2ZTRiZTdmX2NvbHVtbnMiO2E6Njp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6ImZlY2hhIjtzOjU6ImxhYmVsIjtzOjU6IkZlY2hhIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNToidGlwb19tb3ZpbWllbnRvIjtzOjU6ImxhYmVsIjtzOjQ6IlRpcG8iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJjdWVudGEubm9tYnJlIjtzOjU6ImxhYmVsIjtzOjY6IkN1ZW50YSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTY6ImNhdGVnb3JpYS5ub21icmUiO3M6NToibGFiZWwiO3M6MTA6IkNhdGVnb3LDrWEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo0O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6Im1vbnRvIjtzOjU6ImxhYmVsIjtzOjU6Ik1vbnRvIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMToiZGVzY3JpcGNpb24iO3M6NToibGFiZWwiO3M6MTI6IkRlc2NyaXBjacOzbiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO319fX0=', 1773006689);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `logo_light` varchar(255) DEFAULT NULL,
  `logo_dark` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `logo_light`, `logo_dark`, `favicon`, `created_at`, `updated_at`) VALUES
(1, 'RICOX', 'settings/01KK5SGWM0AHZCKZAG3D5QNH9K.png', 'settings/01KK5SGWM258GKA2MK69SBTNBS.png', 'settings/01KK5SGWJZHNR6FWSXRMJCGXFX.png', '2026-03-08 03:58:11', '2026-03-08 16:57:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `activa` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`id`, `categoria_id`, `nombre`, `descripcion`, `activa`, `created_at`, `updated_at`) VALUES
(1, 6, 'Alquiler', NULL, 1, '2026-03-08 20:09:04', '2026-03-08 20:09:04'),
(2, 6, 'Mantenimiento del hogar', NULL, 1, '2026-03-08 20:09:19', '2026-03-08 20:09:19'),
(3, 6, 'Reparaciones', NULL, 1, '2026-03-08 20:09:31', '2026-03-08 20:09:31'),
(4, 6, 'Muebles', NULL, 1, '2026-03-08 20:09:41', '2026-03-08 20:09:41'),
(5, 6, 'Decoración', NULL, 1, '2026-03-08 20:09:51', '2026-03-08 20:09:51'),
(6, 6, 'Servicios del hogar', NULL, 1, '2026-03-08 20:10:03', '2026-03-08 20:10:03'),
(7, 7, 'Electricidad', NULL, 1, '2026-03-08 20:10:17', '2026-03-08 20:10:17'),
(8, 7, 'Agua', NULL, 1, '2026-03-08 20:10:29', '2026-03-08 20:10:29'),
(9, 7, 'Gas', NULL, 1, '2026-03-08 20:10:43', '2026-03-08 20:10:43'),
(10, 7, 'Internet', NULL, 1, '2026-03-08 20:11:00', '2026-03-08 20:11:00'),
(11, 7, 'Cable / Streaming', NULL, 1, '2026-03-08 20:11:14', '2026-03-08 20:11:14'),
(12, 7, 'Telefonía móvil', NULL, 1, '2026-03-08 20:11:42', '2026-03-08 20:11:42'),
(13, 8, 'Supermercado', NULL, 1, '2026-03-08 20:13:16', '2026-03-08 20:13:16'),
(14, 8, 'Mercado', NULL, 1, '2026-03-08 20:13:25', '2026-03-08 20:13:25'),
(15, 8, 'Restaurantes', NULL, 1, '2026-03-08 20:13:33', '2026-03-08 20:13:33'),
(16, 8, 'Comida rápida', NULL, 1, '2026-03-08 20:13:44', '2026-03-08 20:13:44'),
(17, 8, 'Cafeterías', NULL, 1, '2026-03-08 20:13:51', '2026-03-08 20:13:51'),
(18, 8, 'Delivery', NULL, 1, '2026-03-08 20:14:02', '2026-03-08 20:14:02'),
(19, 8, 'Snacks / antojos', NULL, 1, '2026-03-08 20:14:11', '2026-03-08 20:14:11'),
(20, 5, 'Pasajes / transporte público', NULL, 1, '2026-03-08 20:16:35', '2026-03-08 20:16:35'),
(21, 5, 'Taxi / apps', NULL, 1, '2026-03-08 20:16:45', '2026-03-08 20:16:45'),
(22, 5, 'Combustible', NULL, 1, '2026-03-08 20:16:56', '2026-03-08 20:16:56'),
(23, 5, 'Mantenimiento del vehículo', NULL, 1, '2026-03-08 20:17:07', '2026-03-08 20:17:07'),
(24, 5, 'Estacionamiento', NULL, 1, '2026-03-08 20:17:16', '2026-03-08 20:17:16'),
(25, 5, 'Peajes', NULL, 1, '2026-03-08 20:17:25', '2026-03-08 20:17:25'),
(26, 10, 'Pago de deudas', NULL, 1, '2026-03-08 20:18:31', '2026-03-08 20:18:31'),
(27, 10, 'Intereses', NULL, 1, '2026-03-08 20:18:42', '2026-03-08 20:18:42'),
(28, 10, 'Comisiones bancarias', NULL, 1, '2026-03-08 20:18:54', '2026-03-08 20:18:54'),
(29, 10, 'Mantenimiento de cuenta', NULL, 1, '2026-03-08 20:19:06', '2026-03-08 20:19:06'),
(30, 10, 'Transferencias', NULL, 1, '2026-03-08 20:19:16', '2026-03-08 20:19:16'),
(31, 11, 'Ropa', NULL, 1, '2026-03-08 20:20:04', '2026-03-08 20:20:04'),
(32, 11, 'Calzado', NULL, 1, '2026-03-08 20:20:14', '2026-03-08 20:20:14'),
(33, 11, 'Accesorios', NULL, 1, '2026-03-08 20:20:27', '2026-03-08 20:20:27'),
(34, 11, 'Electrónica', NULL, 1, '2026-03-08 20:20:36', '2026-03-08 20:20:36'),
(35, 11, 'Tecnología', NULL, 1, '2026-03-08 20:20:47', '2026-03-08 20:20:47'),
(36, 11, 'Artículos personales', NULL, 1, '2026-03-08 20:20:57', '2026-03-08 20:20:57'),
(37, 12, 'Cine', NULL, 1, '2026-03-08 20:22:11', '2026-03-08 20:22:11'),
(38, 12, 'Videojuegos', NULL, 1, '2026-03-08 20:22:26', '2026-03-08 20:22:26'),
(39, 12, 'Suscripciones', NULL, 1, '2026-03-08 20:22:35', '2026-03-08 20:22:35'),
(40, 12, 'Salidas', NULL, 1, '2026-03-08 20:22:44', '2026-03-08 20:22:44'),
(41, 12, 'Eventos', NULL, 1, '2026-03-08 20:22:53', '2026-03-08 20:22:53'),
(42, 12, 'Streaming', NULL, 1, '2026-03-08 20:23:04', '2026-03-08 20:23:04'),
(43, 13, 'Medicinas', NULL, 1, '2026-03-08 20:23:16', '2026-03-08 20:23:16'),
(44, 13, 'Consultas médicas', NULL, 1, '2026-03-08 20:23:28', '2026-03-08 20:25:35'),
(45, 13, 'Exámenes', NULL, 1, '2026-03-08 20:23:39', '2026-03-08 20:23:39'),
(46, 13, 'Seguro médico', NULL, 1, '2026-03-08 20:23:50', '2026-03-08 20:23:50'),
(47, 13, 'Farmacia', NULL, 1, '2026-03-08 20:24:02', '2026-03-08 20:24:02'),
(48, 14, 'Cursos', NULL, 1, '2026-03-08 20:24:16', '2026-03-08 20:24:16'),
(49, 14, 'Certificaciones', NULL, 1, '2026-03-08 20:24:28', '2026-03-08 20:24:28'),
(50, 14, 'Matrículas', NULL, 1, '2026-03-08 20:24:50', '2026-03-08 20:25:16'),
(51, 14, 'Pagos mensuales instituto', NULL, 1, '2026-03-08 20:26:56', '2026-03-08 20:26:56'),
(52, 15, 'Regalos', NULL, 1, '2026-03-08 20:27:15', '2026-03-08 20:27:15'),
(53, 15, 'Donaciones', NULL, 1, '2026-03-08 20:27:26', '2026-03-08 20:27:26'),
(54, 15, 'Apoyo familiar', NULL, 1, '2026-03-08 20:27:38', '2026-03-08 20:27:38'),
(55, 15, 'Apoyo a amigos', NULL, 1, '2026-03-08 20:28:10', '2026-03-08 20:28:10'),
(56, 16, 'Pasajes', NULL, 1, '2026-03-08 20:28:22', '2026-03-08 20:28:22'),
(57, 16, 'Hospedaje', NULL, 1, '2026-03-08 20:28:34', '2026-03-08 20:28:34'),
(58, 16, 'Alimentación en viaje', NULL, 1, '2026-03-08 20:28:45', '2026-03-08 20:28:45'),
(59, 16, 'Actividades turísticas', NULL, 1, '2026-03-08 20:28:57', '2026-03-08 20:28:57'),
(60, 17, 'Imprevistos', NULL, 1, '2026-03-08 20:29:07', '2026-03-08 20:29:07'),
(61, 17, 'Multas', NULL, 1, '2026-03-08 20:29:26', '2026-03-08 20:29:26'),
(62, 17, 'Reparaciones inesperadas', NULL, 1, '2026-03-08 20:29:39', '2026-03-08 20:29:39'),
(63, 17, 'Otros', NULL, 1, '2026-03-08 20:29:53', '2026-03-08 20:29:53'),
(64, 18, 'Entradas', NULL, 1, '2026-03-08 20:30:05', '2026-03-08 20:30:05'),
(65, 18, 'Camisetas oficiales', NULL, 1, '2026-03-08 20:30:22', '2026-03-08 20:30:22'),
(66, 18, 'Accesorios', NULL, 1, '2026-03-08 20:30:41', '2026-03-08 20:30:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencias`
--

CREATE TABLE `transferencias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cuenta_origen_id` bigint(20) UNSIGNED NOT NULL,
  `cuenta_destino_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(12,2) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `updated_at` timestamp NULL DEFAULT NULL,
  `custom_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`custom_fields`)),
  `avatar_url` varchar(255) DEFAULT NULL,
  `locale` varchar(255) DEFAULT NULL,
  `theme_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `custom_fields`, `avatar_url`, `locale`, `theme_color`) VALUES
(1, 'Abraham', 'ricoabraham879@gmail.com', NULL, '$2y$12$4gXtNyCw1jijZ94D373XH.ejN.r5q5RXBak48ewvDkzO/AKUDqm0y', 'KC0myHYTvLQYKhxo5rlvpn8h2Z18GIfPYDgdaQX8wZfvOzHPFCe9zqXlH3Ag', '2026-03-07 19:49:24', '2026-03-08 16:57:51', NULL, 'avatars/01KK5G4RZ69BHY9PE6VXATESAX.png', 'es', '#1c22de');

--
-- Índices para tablas volcadas
--

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
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exports_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `failed_import_rows_import_id_foreign` (`import_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `imports_user_id_foreign` (`user_id`);

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
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movimientos_cuenta_id_foreign` (`cuenta_id`),
  ADD KEY `movimientos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `movimientos_subcategoria_id_foreign` (`subcategoria_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presupuestos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `presupuestos_subcategoria_id_foreign` (`subcategoria_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategorias_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transferencias_cuenta_origen_id_foreign` (`cuenta_origen_id`),
  ADD KEY `transferencias_cuenta_destino_id_foreign` (`cuenta_destino_id`);

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
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `exports`
--
ALTER TABLE `exports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imports`
--
ALTER TABLE `imports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `transferencias`
--
ALTER TABLE `transferencias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `exports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `failed_import_rows`
--
ALTER TABLE `failed_import_rows`
  ADD CONSTRAINT `failed_import_rows_import_id_foreign` FOREIGN KEY (`import_id`) REFERENCES `imports` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `imports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `movimientos_cuenta_id_foreign` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`id`),
  ADD CONSTRAINT `movimientos_subcategoria_id_foreign` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`);

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `presupuestos_subcategoria_id_foreign` FOREIGN KEY (`subcategoria_id`) REFERENCES `subcategorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD CONSTRAINT `subcategorias_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `transferencias`
--
ALTER TABLE `transferencias`
  ADD CONSTRAINT `transferencias_cuenta_destino_id_foreign` FOREIGN KEY (`cuenta_destino_id`) REFERENCES `cuentas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transferencias_cuenta_origen_id_foreign` FOREIGN KEY (`cuenta_origen_id`) REFERENCES `cuentas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
