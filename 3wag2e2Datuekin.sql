-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-02-2024 a las 09:42:10
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `3wag2e2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bezero_fitxa`
--

CREATE TABLE `bezero_fitxa` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `abizena` varchar(200) NOT NULL,
  `telefonoa` varchar(9) DEFAULT NULL,
  `azal_sentikorra` char(1) DEFAULT 'E',
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bezero_fitxa`
--

INSERT INTO `bezero_fitxa` (`id`, `izena`, `abizena`, `telefonoa`, `azal_sentikorra`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'Bruno', 'Mars', '745812645', 'E', '2024-01-31 09:06:13', '2024-01-31 09:06:13', NULL),
(5, 'Miquel', 'Urbeleguezaga', '323232321', 'E', '2024-01-31 09:08:00', '2024-02-02 13:04:29', '2024-02-02 00:00:00'),
(6, 'Miguel', 'Hurlesguezabaga', '456789123', 'E', '2024-01-31 09:09:18', '2024-01-31 09:09:18', NULL),
(10, 'Jony', 'Caballero', '23123123', 'B', '2024-02-02 10:16:29', '2024-02-02 11:40:57', '2024-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `erabiltzailea`
--

CREATE TABLE `erabiltzailea` (
  `username` varchar(15) NOT NULL,
  `pasahitza` varchar(100) DEFAULT NULL,
  `rola` varchar(2) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hitzordua`
--

CREATE TABLE `hitzordua` (
  `id` int(11) NOT NULL,
  `eserlekua` int(11) NOT NULL,
  `data` date NOT NULL,
  `hasiera_ordua` time NOT NULL,
  `amaiera_ordua` time NOT NULL,
  `hasiera_ordua_erreala` time DEFAULT NULL,
  `amaiera_ordua_erreala` time DEFAULT NULL,
  `izena` varchar(100) NOT NULL,
  `telefonoa` varchar(9) DEFAULT NULL,
  `deskribapena` varchar(250) DEFAULT NULL,
  `etxekoa` char(1) NOT NULL,
  `prezio_totala` decimal(10,2) DEFAULT NULL,
  `id_langilea` int(11) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hitzordua`
--

INSERT INTO `hitzordua` (`id`, `eserlekua`, `data`, `hasiera_ordua`, `amaiera_ordua`, `hasiera_ordua_erreala`, `amaiera_ordua_erreala`, `izena`, `telefonoa`, `deskribapena`, `etxekoa`, `prezio_totala`, `id_langilea`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 1, '2024-01-23', '09:45:00', '11:45:00', NULL, NULL, 'Mikel Sanjose', '324523', 'Teñir Azul', 'E', NULL, 4, '2024-01-23 11:45:43', '2024-02-09 09:24:17', NULL),
(2, 1, '2024-01-02', '10:00:00', '11:00:00', NULL, NULL, 'Martin Cooper', '67123898', 'Corte Normal', 'E', NULL, 3, '2024-01-30 12:36:27', '2024-02-09 09:24:56', NULL),
(3, 1, '2024-02-08', '10:00:00', '11:00:00', NULL, NULL, 'Nathaniel Baldwin', '7987321', 'Calbo', 'E', NULL, 7, '2024-02-08 08:44:32', '2024-02-09 09:24:37', NULL),
(9, 1, '2024-02-08', '09:00:00', '09:30:00', '09:00:00', '09:30:00', 'Juan Pérez', '123456789', 'Corte de cabello', 'E', 25.00, 13, '2024-02-09 09:32:58', '2024-02-09 09:32:58', NULL),
(10, 2, '2024-02-08', '10:15:00', '10:45:00', '10:15:00', '10:45:00', 'María Gómez', '987654321', 'Tinte y peinado', 'K', 40.00, 6, '2024-02-09 09:32:58', '2024-02-09 09:32:58', NULL),
(11, 3, '2024-02-08', '11:30:00', '12:00:00', '11:30:00', '12:00:00', 'Carlos López', '654987321', 'Afeitado y arreglo de barba', 'E', 15.00, 13, '2024-02-09 09:32:58', '2024-02-09 09:32:58', NULL),
(12, 4, '2024-02-08', '12:45:00', '13:15:00', '12:45:00', '13:15:00', 'Ana Martínez', '789123654', 'Manicura y pedicura', 'K', 35.00, 6, '2024-02-09 09:32:58', '2024-02-09 09:32:58', NULL),
(13, 5, '2024-02-08', '14:00:00', '14:30:00', '14:00:00', '14:30:00', 'Laura Sánchez', '456789123', 'Maquillaje', 'E', 20.00, 13, '2024-02-09 09:32:58', '2024-02-09 09:32:58', NULL),
(14, 1, '2024-02-09', '09:00:00', '09:30:00', '09:00:00', '09:30:00', 'Juan Pérez', '123456789', 'Corte de cabello', 'E', 25.00, 13, '2024-02-09 09:33:38', '2024-02-09 09:33:38', NULL),
(15, 2, '2024-02-09', '10:15:00', '10:45:00', '10:15:00', '10:45:00', 'María Gómez', '987654321', 'Tinte y peinado', 'K', 40.00, 6, '2024-02-09 09:33:38', '2024-02-09 09:33:38', NULL),
(16, 3, '2024-02-09', '11:30:00', '12:00:00', '11:30:00', '12:00:00', 'Carlos López', '654987321', 'Afeitado y arreglo de barba', 'E', 15.00, 13, '2024-02-09 09:33:38', '2024-02-09 09:33:38', NULL),
(17, 4, '2024-02-09', '12:45:00', '13:15:00', '12:45:00', '13:15:00', 'Ana Martínez', '789123654', 'Manicura y pedicura', 'K', 35.00, 6, '2024-02-09 09:33:38', '2024-02-09 09:33:38', NULL),
(18, 5, '2024-02-09', '14:00:00', '14:30:00', '14:00:00', '14:30:00', 'Laura Sánchez', '456789123', 'Maquillaje', 'E', 20.00, 13, '2024-02-09 09:33:38', '2024-02-09 09:33:38', NULL),
(19, 6, '2024-02-08', '15:30:00', '16:00:00', '15:30:00', '16:00:00', 'Marta Rodríguez', '111222333', 'Tratamiento facial', 'E', 30.00, 13, '2024-02-09 09:35:01', '2024-02-09 09:35:01', NULL),
(20, 7, '2024-02-08', '16:45:00', '17:15:00', '16:45:00', '17:15:00', 'Pedro Sánchez', '444555666', 'Masaje relajante', 'K', 45.00, 6, '2024-02-09 09:35:01', '2024-02-09 09:35:01', NULL),
(21, 8, '2024-02-08', '17:30:00', '18:00:00', '17:30:00', '18:00:00', 'Sara García', '777888999', 'Depilación de cejas', 'E', 10.00, 13, '2024-02-09 09:35:01', '2024-02-09 09:35:01', NULL),
(22, 9, '2024-02-08', '09:45:00', '10:15:00', '09:45:00', '10:15:00', 'Javier Fernández', '222333444', 'Corte de barba', 'K', 12.00, 6, '2024-02-09 09:35:01', '2024-02-09 09:35:01', NULL),
(23, 10, '2024-02-08', '11:00:00', '11:30:00', '11:00:00', '11:30:00', 'Luisa Pérez', '555666777', 'Peluquería infantil', 'E', 15.00, 13, '2024-02-09 09:35:01', '2024-02-09 09:35:01', NULL),
(24, 11, '2024-02-09', '09:30:00', '10:00:00', '09:30:00', '10:00:00', 'Elena Martínez', '123456789', 'Tratamiento capilar', 'E', 35.00, 13, '2024-02-09 09:35:42', '2024-02-09 08:39:08', NULL),
(25, 12, '2024-02-09', '10:45:00', '11:15:00', '10:45:00', '11:15:00', 'David López', '987654321', 'Corte de pelo y tinte', 'K', 50.00, 6, '2024-02-09 09:35:42', '2024-02-09 09:35:42', NULL),
(26, 13, '2024-02-09', '11:30:00', '12:00:00', '11:30:00', '12:00:00', 'Marina García', '654987321', 'Maquillaje de noche', 'E', 25.00, 13, '2024-02-09 09:35:42', '2024-02-09 09:35:42', NULL),
(27, 14, '2024-02-09', '12:45:00', '13:15:00', '12:45:00', '13:15:00', 'Roberto Sánchez', '789123654', 'Pedicura', 'K', 30.00, 6, '2024-02-09 09:35:42', '2024-02-09 09:35:42', NULL),
(28, 15, '2024-02-09', '14:00:00', '14:30:00', '14:00:00', '14:30:00', 'Carmen Rodríguez', '456789123', 'Masaje facial', 'E', 20.00, 13, '2024-02-09 09:35:42', '2024-02-09 09:35:42', NULL),
(29, 16, '2024-02-09', '15:30:00', '16:00:00', '15:30:00', '16:00:00', 'Julia Fernández', '111222333', 'Depilación de piernas', 'E', 25.00, 13, '2024-02-09 09:36:06', '2024-02-09 09:36:06', NULL),
(30, 17, '2024-02-09', '16:15:00', '16:45:00', '16:15:00', '16:45:00', 'Diego Martínez', '444555666', 'Corte de cabello', 'K', 15.00, 6, '2024-02-09 09:36:06', '2024-02-09 09:36:06', NULL),
(31, 18, '2024-02-09', '17:00:00', '17:30:00', '17:00:00', '17:30:00', 'Natalia Gómez', '777888999', 'Manicura francesa', 'E', 20.00, 13, '2024-02-09 09:36:06', '2024-02-09 09:36:06', NULL),
(32, 19, '2024-02-09', '09:45:00', '10:15:00', '09:45:00', '10:15:00', 'Antonio Sánchez', '222333444', 'Afeitado y arreglo de barba', 'K', 12.00, 6, '2024-02-09 09:36:06', '2024-02-09 09:36:06', NULL),
(33, 20, '2024-02-09', '11:30:00', '12:00:00', '11:30:00', '12:00:00', 'Isabel Pérez', '555666777', 'Tinte y mechas', 'E', 40.00, 13, '2024-02-09 09:36:06', '2024-02-09 09:36:06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kategoria`
--

CREATE TABLE `kategoria` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `kategoria`
--

INSERT INTO `kategoria` (`id`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'Champú', '2024-01-26 10:15:04', '2024-01-26 10:15:04', NULL),
(2, 'Tinte', '2024-01-26 10:15:13', '2024-01-26 10:15:13', NULL),
(3, 'Laca', '2024-01-26 10:15:21', '2024-01-26 10:15:21', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kolore_historiala`
--

CREATE TABLE `kolore_historiala` (
  `id` int(11) NOT NULL,
  `id_bezeroa` int(11) NOT NULL,
  `id_produktua` int(11) NOT NULL,
  `data` date NOT NULL,
  `kantitatea` int(11) DEFAULT NULL,
  `bolumena` varchar(100) DEFAULT NULL,
  `oharrak` varchar(250) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `langilea`
--

CREATE TABLE `langilea` (
  `id` int(11) NOT NULL,
  `izena` varchar(30) NOT NULL,
  `kodea` int(5) NOT NULL,
  `abizenak` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `langilea`
--

INSERT INTO `langilea` (`id`, `izena`, `kodea`, `abizenak`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'Manolo', 1, 'Perez', '2024-01-17 10:40:43', '2024-02-09 09:20:04', NULL),
(2, 'Albert', 2, 'Flores', '2024-01-17 10:41:00', '2024-02-09 09:20:25', NULL),
(3, 'Marselo', 3, 'White', '2024-01-17 10:41:15', '2024-02-09 09:20:48', '2024-02-06 13:19:55'),
(4, 'Paco', 1, 'Garcia', '2024-01-23 13:05:18', '2024-02-09 09:20:58', NULL),
(5, 'Pedro', 1, 'Hernandez', '2024-01-23 13:05:39', '2024-02-09 09:21:34', NULL),
(6, 'Alex', 1, 'Gutierrez', '2024-01-26 09:42:39', '2024-02-09 09:21:56', NULL),
(7, 'Miquel', 1, 'Urceluaga', '2024-01-26 09:43:05', '2024-01-26 09:43:05', NULL),
(13, 'Aratz', 4, 'Facundo', '2024-02-09 09:32:47', '2024-02-09 09:32:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiala`
--

CREATE TABLE `materiala` (
  `id` int(11) NOT NULL,
  `etiketa` varchar(10) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiala`
--

INSERT INTO `materiala` (`id`, `etiketa`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(2, 'SEC1', 'Secador', '2024-01-26 10:59:46', '2024-01-26 10:59:46', NULL),
(3, 'SEC2', 'Secador', '2024-01-26 11:00:03', '2024-01-26 11:00:03', NULL),
(4, 'PLA1', 'Plancha', '2024-01-26 11:00:16', '2024-01-26 11:00:16', NULL),
(5, 'PLA2', 'Plancha', '2024-01-26 11:00:27', '2024-01-26 11:00:27', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiala_erabili`
--

CREATE TABLE `materiala_erabili` (
  `id` int(11) NOT NULL,
  `id_materiala` int(11) NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `hasiera_data` datetime NOT NULL,
  `amaiera_data` datetime DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiala_erabili`
--

INSERT INTO `materiala_erabili` (`id`, `id_materiala`, `id_langilea`, `hasiera_data`, `amaiera_data`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 4, 4, '2024-01-26 11:00:43', '2024-01-12 14:26:18', '2024-01-26 11:00:56', '2024-01-29 14:26:21', NULL),
(2, 5, 1, '2024-01-26 11:00:58', '2024-02-05 08:55:03', '2024-01-26 11:01:03', '2024-02-05 09:55:03', NULL),
(3, 2, 6, '2024-01-26 11:01:04', NULL, '2024-01-26 11:01:07', '2024-01-26 11:01:07', NULL),
(4, 3, 2, '2024-01-26 11:01:08', NULL, '2024-01-26 11:01:13', '2024-01-26 11:01:13', NULL),
(5, 4, 5, '2024-01-26 11:01:14', NULL, '2024-01-26 11:01:18', '2024-01-26 11:01:18', NULL),
(6, 5, 1, '2024-01-26 11:01:19', '2024-02-05 08:55:03', '2024-01-26 11:01:22', '2024-02-05 09:55:03', NULL),
(7, 2, 4, '2024-01-26 11:01:23', NULL, '2024-01-26 11:01:27', '2024-01-26 11:01:27', NULL),
(8, 4, 2, '2024-01-26 11:01:28', NULL, '2024-01-26 11:01:32', '2024-01-26 11:01:32', NULL),
(9, 5, 7, '2024-01-26 11:01:33', '2024-02-05 08:55:03', '2024-01-26 11:01:37', '2024-02-05 09:55:03', NULL),
(10, 4, 3, '2024-01-26 11:01:38', NULL, '2024-01-26 11:01:41', '2024-01-26 11:01:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordutegia`
--

CREATE TABLE `ordutegia` (
  `id` int(11) NOT NULL,
  `kodea` int(5) DEFAULT NULL,
  `eguna` int(1) NOT NULL,
  `hasiera_data` date DEFAULT NULL,
  `amaiera_data` date DEFAULT NULL,
  `hasiera_ordua` time NOT NULL,
  `amaiera_ordua` time NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordutegia`
--

INSERT INTO `ordutegia` (`id`, `kodea`, `eguna`, `hasiera_data`, `amaiera_data`, `hasiera_ordua`, `amaiera_ordua`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 4, 4, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 11:47:48', '2024-02-09 09:26:51', '2024-02-09 08:00:15'),
(2, 4, 4, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 11:49:13', '2024-02-09 09:26:51', '2024-02-09 08:00:15'),
(3, 2, 2, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 11:51:26', '2024-02-09 09:26:50', '2024-02-09 08:00:14'),
(4, 4, 4, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-17 10:41:47', '2024-02-09 09:26:51', '2024-02-09 08:00:15'),
(5, 1, 5, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-17 10:41:53', '2024-02-09 09:30:41', '2024-02-09 08:00:15'),
(6, 4, 4, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 11:52:31', '2024-02-09 09:26:51', '2024-02-09 08:00:15'),
(7, 3, 3, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 09:26:06', '2024-02-09 09:26:50', '2024-02-09 08:00:14'),
(8, 2, 2, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 09:35:57', '2024-02-09 09:26:50', '2024-02-09 08:00:14'),
(9, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 12:07:10', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(10, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 12:28:48', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(14, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 13:18:01', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(16, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 13:38:45', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(18, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 13:43:25', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(33, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 13:49:24', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(35, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 14:15:16', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(36, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-22 14:25:04', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(37, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-01-30 12:10:50', '2024-02-09 09:26:50', '2024-02-09 08:00:13'),
(38, 1, 1, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-02-09 09:00:21', '2024-02-09 09:26:50', NULL),
(39, 2, 2, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-02-09 09:00:34', '2024-02-09 09:26:50', NULL),
(40, 3, 3, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-02-09 09:00:40', '2024-02-09 09:26:50', NULL),
(41, 4, 4, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-02-09 09:01:05', '2024-02-09 09:26:51', NULL),
(42, 1, 5, '2024-02-01', '2024-02-15', '00:00:00', '00:00:00', '2024-02-09 09:13:04', '2024-02-09 09:30:41', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produktua`
--

CREATE TABLE `produktua` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `deskribapena` varchar(250) DEFAULT NULL,
  `id_kategoria` int(11) NOT NULL,
  `marka` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `stock_alerta` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produktua`
--

INSERT INTO `produktua` (`id`, `izena`, `deskribapena`, `id_kategoria`, `marka`, `stock`, `stock_alerta`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'H&S', 'Mu bueno', 1, 'H&S', 3, 5, '2024-01-26 10:18:33', '2024-01-26 10:18:33', NULL),
(2, 'Laca', 'Laca para el pelo', 3, 'LACAS SL', 5, 3, '2024-01-26 10:19:31', '2024-02-09 08:38:05', NULL),
(3, 'Tintador', 'Tinte mu bueno', 2, 'TINTES SL', 5, 10, '2024-01-26 10:19:53', '2024-01-26 10:19:53', NULL),
(4, 'Champú', 'Olor limon y anticaspa', 1, 'Loreal', 4, 2, '2024-02-09 09:38:41', '2024-02-09 08:38:51', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produktu_mugimendua`
--

CREATE TABLE `produktu_mugimendua` (
  `id` int(11) NOT NULL,
  `id_produktua` int(11) NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `kopurua` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produktu_mugimendua`
--

INSERT INTO `produktu_mugimendua` (`id`, `id_produktua`, `id_langilea`, `data`, `kopurua`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 1, 4, '2024-01-26 10:20:07', 1, '2024-01-26 10:20:17', '2024-01-26 10:20:17', NULL),
(2, 2, 7, '2024-01-26 10:20:22', 2, '2024-01-26 10:20:30', '2024-01-26 10:20:30', NULL),
(3, 3, 3, '2024-01-26 10:20:33', 4, '2024-01-26 10:20:40', '2024-01-26 10:20:40', NULL),
(4, 1, 6, '2024-01-26 10:21:52', 6, '2024-01-26 10:22:01', '2024-01-26 10:22:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `taldea`
--

CREATE TABLE `taldea` (
  `kodea` int(5) NOT NULL,
  `izena` varchar(100) DEFAULT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `taldea`
--

INSERT INTO `taldea` (`kodea`, `izena`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'PEL1', '2024-01-17 10:39:41', '2024-01-17 10:40:17', NULL),
(2, 'PEL2', '2024-01-17 10:39:50', '2024-01-17 10:40:22', NULL),
(3, 'PEL3', '2024-01-17 10:40:00', '2024-01-17 10:40:27', NULL),
(4, 'PEL4', '2024-01-22 10:46:59', '2024-01-22 10:46:59', NULL),
(5, 'PEL5', '2024-01-22 10:47:07', '2024-01-22 10:47:07', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket_lerroa`
--

CREATE TABLE `ticket_lerroa` (
  `id` int(11) NOT NULL,
  `id_hitzordua` int(11) NOT NULL,
  `id_tratamendua` int(11) NOT NULL,
  `prezioa` decimal(10,2) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ticket_lerroa`
--

INSERT INTO `ticket_lerroa` (`id`, `id_hitzordua`, `id_tratamendua`, `prezioa`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 1, 1, 50.00, '2024-01-30 12:36:50', '2024-02-06 08:01:11', NULL),
(2, 2, 1, 85.00, '2024-01-30 12:37:00', '2024-02-06 08:01:15', NULL),
(3, 1, 3, 33.00, '2024-01-30 12:37:06', '2024-02-05 09:46:46', NULL),
(6, 2, 1, 76.00, '2024-02-06 08:27:04', '2024-02-07 11:42:05', '2024-02-07 00:00:00'),
(7, 24, 2, 6.00, '2024-02-09 09:39:13', '2024-02-09 09:39:13', NULL),
(8, 24, 1, 3.00, '2024-02-09 09:39:15', '2024-02-09 09:39:15', NULL),
(9, 24, 3, 8.00, '2024-02-09 09:39:17', '2024-02-09 09:39:17', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tratamendua`
--

CREATE TABLE `tratamendua` (
  `id` int(11) NOT NULL,
  `izena` varchar(100) NOT NULL,
  `etxeko_prezioa` decimal(10,2) NOT NULL,
  `kanpoko_prezioa` decimal(10,2) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tratamendua`
--

INSERT INTO `tratamendua` (`id`, `izena`, `etxeko_prezioa`, `kanpoko_prezioa`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(0, 'Extra', 0.00, 0.00, '2024-02-09 09:41:40', '2024-02-09 09:41:46', NULL),
(1, 'Pelar', 3.00, 5.00, '2024-01-30 12:33:22', '2024-01-30 12:33:22', NULL),
(2, 'Teñir', 6.00, 10.00, '2024-01-30 12:33:36', '2024-01-30 12:33:36', NULL),
(3, 'Injerto capilar', 8.00, 15.00, '2024-01-30 12:34:03', '2024-01-30 12:34:03', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `txanda`
--

CREATE TABLE `txanda` (
  `id` int(11) NOT NULL,
  `mota` varchar(1) NOT NULL,
  `data` date NOT NULL,
  `id_langilea` int(11) NOT NULL,
  `sortze_data` datetime DEFAULT current_timestamp(),
  `eguneratze_data` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ezabatze_data` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `txanda`
--

INSERT INTO `txanda` (`id`, `mota`, `data`, `id_langilea`, `sortze_data`, `eguneratze_data`, `ezabatze_data`) VALUES
(1, 'M', '2024-01-23', 1, '2024-01-22 14:23:37', '2024-01-24 10:16:43', '2024-01-24 10:16:39'),
(2, 'G', '2024-01-23', 2, '2024-01-23 08:58:37', '2024-01-24 10:16:56', '2024-01-24 10:16:54'),
(5, 'M', '2024-01-10', 1, '2024-01-23 09:01:54', '2024-01-23 14:12:43', '2024-01-23 14:12:27'),
(6, 'G', '2024-01-18', 1, '2024-01-23 09:02:24', '2024-01-23 14:12:43', '2024-01-23 14:12:27'),
(7, 'M', '2024-01-03', 5, '2024-01-23 13:07:37', '2024-01-23 14:12:11', '2024-01-23 14:12:07'),
(8, 'G', '2024-01-04', 4, '2024-01-23 13:07:57', '2024-01-23 14:12:43', '2024-01-23 14:12:27'),
(9, 'G', '2024-01-16', 5, '2024-01-23 13:44:26', '2024-01-23 14:12:43', '2024-01-23 14:12:27'),
(14, 'G', '2024-01-24', 1, '2024-01-24 00:00:00', '2024-01-24 13:06:02', '2024-01-24 00:00:00'),
(21, 'M', '2024-01-24', 4, '2024-01-24 00:00:00', '2024-01-24 00:00:00', NULL),
(22, 'G', '2024-01-24', 5, '2024-01-24 00:00:00', '2024-01-24 00:00:00', NULL),
(23, 'G', '2024-01-26', 6, '2024-01-26 09:46:24', '2024-01-26 09:46:24', NULL),
(24, 'M', '2024-01-26', 7, '2024-01-26 09:46:34', '2024-01-26 09:46:34', NULL),
(25, 'G', '2024-01-30', 7, '2024-01-30 11:53:14', '2024-01-30 12:13:59', '2024-01-30 00:00:00'),
(26, 'M', '2024-01-30', 6, '2024-01-30 11:53:26', '2024-01-30 12:13:59', '2024-01-30 00:00:00'),
(27, 'M', '2024-01-30', 4, '2024-01-30 00:00:00', '2024-01-30 00:00:00', NULL),
(28, 'G', '2024-01-30', 1, '2024-01-30 00:00:00', '2024-01-30 00:00:00', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bezero_fitxa`
--
ALTER TABLE `bezero_fitxa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `erabiltzailea`
--
ALTER TABLE `erabiltzailea`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_hitzordua_langilea` (`id_langilea`);

--
-- Indices de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_kolore_historiala_produktua` (`id_produktua`),
  ADD KEY `FK_kolore_historiala_bezeroa` (`id_bezeroa`);

--
-- Indices de la tabla `langilea`
--
ALTER TABLE `langilea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_langilea_taldea` (`kodea`);

--
-- Indices de la tabla `materiala`
--
ALTER TABLE `materiala`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_materiala_erabili_langilea` (`id_langilea`),
  ADD KEY `FK_materiala_erabili_materiala` (`id_materiala`);

--
-- Indices de la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ordutegia_taldea` (`kodea`);

--
-- Indices de la tabla `produktua`
--
ALTER TABLE `produktua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_produktua_kategoria` (`id_kategoria`);

--
-- Indices de la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_produktu_mugimendua_produktua` (`id_produktua`),
  ADD KEY `FK_produktu_mugimendua_langilea` (`id_langilea`);

--
-- Indices de la tabla `taldea`
--
ALTER TABLE `taldea`
  ADD PRIMARY KEY (`kodea`);

--
-- Indices de la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ticket_lerroa_hitzordua` (`id_hitzordua`),
  ADD KEY `FK_ticket_lerroa_tratamendua` (`id_tratamendua`);

--
-- Indices de la tabla `tratamendua`
--
ALTER TABLE `tratamendua`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `txanda`
--
ALTER TABLE `txanda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_txanda_langilea` (`id_langilea`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bezero_fitxa`
--
ALTER TABLE `bezero_fitxa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `langilea`
--
ALTER TABLE `langilea`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `materiala`
--
ALTER TABLE `materiala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `produktua`
--
ALTER TABLE `produktua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `taldea`
--
ALTER TABLE `taldea`
  MODIFY `kodea` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tratamendua`
--
ALTER TABLE `tratamendua`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `txanda`
--
ALTER TABLE `txanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hitzordua`
--
ALTER TABLE `hitzordua`
  ADD CONSTRAINT `FK_hitzordua_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`);

--
-- Filtros para la tabla `kolore_historiala`
--
ALTER TABLE `kolore_historiala`
  ADD CONSTRAINT `FK_kolore_historiala_bezeroa` FOREIGN KEY (`id_bezeroa`) REFERENCES `bezero_fitxa` (`id`),
  ADD CONSTRAINT `FK_kolore_historiala_produktua` FOREIGN KEY (`id_produktua`) REFERENCES `produktua` (`id`);

--
-- Filtros para la tabla `langilea`
--
ALTER TABLE `langilea`
  ADD CONSTRAINT `FK_langilea_taldea` FOREIGN KEY (`kodea`) REFERENCES `taldea` (`kodea`);

--
-- Filtros para la tabla `materiala_erabili`
--
ALTER TABLE `materiala_erabili`
  ADD CONSTRAINT `FK_materiala_erabili_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`),
  ADD CONSTRAINT `FK_materiala_erabili_materiala` FOREIGN KEY (`id_materiala`) REFERENCES `materiala` (`id`);

--
-- Filtros para la tabla `ordutegia`
--
ALTER TABLE `ordutegia`
  ADD CONSTRAINT `FK_ordutegia_taldea` FOREIGN KEY (`kodea`) REFERENCES `taldea` (`kodea`);

--
-- Filtros para la tabla `produktua`
--
ALTER TABLE `produktua`
  ADD CONSTRAINT `FK_produktua_kategoria` FOREIGN KEY (`id_kategoria`) REFERENCES `kategoria` (`id`);

--
-- Filtros para la tabla `produktu_mugimendua`
--
ALTER TABLE `produktu_mugimendua`
  ADD CONSTRAINT `FK_produktu_mugimendua_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`),
  ADD CONSTRAINT `FK_produktu_mugimendua_produktua` FOREIGN KEY (`id_produktua`) REFERENCES `produktua` (`id`);

--
-- Filtros para la tabla `ticket_lerroa`
--
ALTER TABLE `ticket_lerroa`
  ADD CONSTRAINT `FK_ticket_lerroa_hitzordua` FOREIGN KEY (`id_hitzordua`) REFERENCES `hitzordua` (`id`),
  ADD CONSTRAINT `FK_ticket_lerroa_tratamendua` FOREIGN KEY (`id_tratamendua`) REFERENCES `tratamendua` (`id`);

--
-- Filtros para la tabla `txanda`
--
ALTER TABLE `txanda`
  ADD CONSTRAINT `FK_txanda_langilea` FOREIGN KEY (`id_langilea`) REFERENCES `langilea` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
