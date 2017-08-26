-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-08-2017 a las 02:07:31
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ezic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accumulated_note`
--

CREATE TABLE `accumulated_note` (
  `idAccumulated` int(15) NOT NULL,
  `idSubject` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `acc` float NOT NULL,
  `approved` varchar(1) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `accumulated_note`
--

INSERT INTO `accumulated_note` (`idAccumulated`, `idSubject`, `idStudent`, `acc`, `approved`) VALUES
(1, 1, 'AF5943', 2.24, '0'),
(2, 1, 'AG7857', 2.24, '0'),
(3, 1, 'CR3842', 2.24, '0'),
(4, 1, 'CR6335', 2.24, '0'),
(5, 1, 'CR9637', 2.24, '0'),
(6, 1, 'EH1733', 2.24, '0'),
(7, 1, 'FL8465', 2.24, '0'),
(8, 1, 'FR1268', 2.24, '0'),
(9, 1, 'FR8837', 2.24, '0'),
(10, 1, 'GR8123', 2.24, '0'),
(11, 1, 'MA2133', 2.24, '0'),
(12, 1, 'MG4595', 2.24, '0'),
(13, 1, 'MG8115', 2.24, '0'),
(14, 1, 'MG9131', 2.24, '0'),
(15, 1, 'MP6846', 2.24, '0'),
(16, 1, 'MP8679', 2.24, '0'),
(17, 1, 'MS3438', 2.24, '0'),
(18, 1, 'MS3721', 2.24, '0'),
(19, 1, 'RA7444', 2.24, '0'),
(20, 1, 'SG3999', 2.24, '0'),
(21, 3, 'AF5943', 0.2, '0'),
(22, 3, 'AG7857', 0.2, '0'),
(23, 3, 'CR3842', 0.2, '0'),
(24, 3, 'CR6335', 0.2, '0'),
(25, 3, 'CR9637', 0.2, '0'),
(26, 3, 'EH1733', 0.2, '0'),
(27, 3, 'FL8465', 0.2, '0'),
(28, 3, 'FR1268', 0.2, '0'),
(29, 3, 'FR8837', 0.2, '0'),
(30, 3, 'GR8123', 0.2, '0'),
(31, 3, 'MA2133', 0.2, '0'),
(32, 3, 'MG4595', 0.2, '0'),
(33, 3, 'MG8115', 0.2, '0'),
(34, 3, 'MG9131', 0.2, '0'),
(35, 3, 'MP6846', 0.2, '0'),
(36, 3, 'MP8679', 0.2, '0'),
(37, 3, 'MS3438', 0.2, '0'),
(38, 3, 'MS3721', 0.2, '0'),
(39, 3, 'RA7444', 0.2, '0'),
(40, 3, 'SG3999', 0.2, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `applied_code`
--

CREATE TABLE `applied_code` (
  `idApplied_Code` int(11) NOT NULL,
  `hour` time NOT NULL,
  `date` date NOT NULL,
  `idApplier` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `applierType` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `idCode` int(11) NOT NULL,
  `idPeriod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `applied_code`
--

INSERT INTO `applied_code` (`idApplied_Code`, `hour`, `date`, `idApplier`, `applierType`, `idCode`, `idPeriod`) VALUES
(21, '11:49:00', '2017-08-24', 'C1425', 'C', 2, 1),
(22, '11:50:00', '2017-08-24', 'C1425', 'C', 2, 1),
(23, '11:50:00', '2017-08-24', 'C1425', 'C', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `assistance`
--

CREATE TABLE `assistance` (
  `idAssistance` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `date` date NOT NULL,
  `attended` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `idSchedule` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `averages`
--

CREATE TABLE `averages` (
  `idAverage` int(20) NOT NULL,
  `idSubject` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idPeriod` int(15) NOT NULL,
  `average` float NOT NULL,
  `approved` varchar(1) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `averages`
--

INSERT INTO `averages` (`idAverage`, `idSubject`, `idStudent`, `idPeriod`, `average`, `approved`) VALUES
(1, 1, 'AF5943', 1, 8.96, '1'),
(2, 1, 'AG7857', 1, 8.96, '1'),
(3, 1, 'CR3842', 1, 8.96, '1'),
(4, 1, 'CR6335', 1, 8.96, '1'),
(5, 1, 'CR9637', 1, 8.96, '1'),
(6, 1, 'EH1733', 1, 8.96, '1'),
(7, 1, 'FL8465', 1, 8.96, '1'),
(8, 1, 'FR1268', 1, 8.96, '1'),
(9, 1, 'FR8837', 1, 8.96, '1'),
(10, 1, 'GR8123', 1, 8.96, '1'),
(11, 1, 'MA2133', 1, 8.96, '1'),
(12, 1, 'MG4595', 1, 8.96, '1'),
(13, 1, 'MG8115', 1, 8.96, '1'),
(14, 1, 'MG9131', 1, 8.96, '1'),
(15, 1, 'MP6846', 1, 8.96, '1'),
(16, 1, 'MP8679', 1, 8.96, '1'),
(17, 1, 'MS3438', 1, 8.96, '1'),
(18, 1, 'MS3721', 1, 8.96, '1'),
(19, 1, 'RA7444', 1, 8.96, '1'),
(20, 1, 'SG3999', 1, 8.96, '1'),
(21, 3, 'AF5943', 1, 0.8, '0'),
(22, 3, 'AG7857', 1, 0.8, '0'),
(23, 3, 'CR3842', 1, 0.8, '0'),
(24, 3, 'CR6335', 1, 0.8, '0'),
(25, 3, 'CR9637', 1, 0.8, '0'),
(26, 3, 'EH1733', 1, 0.8, '0'),
(27, 3, 'FL8465', 1, 0.8, '0'),
(28, 3, 'FR1268', 1, 0.8, '0'),
(29, 3, 'FR8837', 1, 0.8, '0'),
(30, 3, 'GR8123', 1, 0.8, '0'),
(31, 3, 'MA2133', 1, 0.8, '0'),
(32, 3, 'MG4595', 1, 0.8, '0'),
(33, 3, 'MG8115', 1, 0.8, '0'),
(34, 3, 'MG9131', 1, 0.8, '0'),
(35, 3, 'MP6846', 1, 0.8, '0'),
(36, 3, 'MP8679', 1, 0.8, '0'),
(37, 3, 'MS3438', 1, 0.8, '0'),
(38, 3, 'MS3721', 1, 0.8, '0'),
(39, 3, 'RA7444', 1, 0.8, '0'),
(40, 3, 'SG3999', 1, 0.8, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `code`
--

CREATE TABLE `code` (
  `idCode` int(11) NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `category` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `code`
--

INSERT INTO `code` (`idCode`, `description`, `type`, `category`) VALUES
(1, 'Porta armas de fuego', 'MG', 'C'),
(2, 'Es mal amigo', 'G', 'C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `code_category`
--

CREATE TABLE `code_category` (
  `idCategory` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `category` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `color` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `code_category`
--

INSERT INTO `code_category` (`idCategory`, `category`, `color`) VALUES
('A', 'Asistencia', 'yellow'),
('C', 'Comportamiento', 'purple lighten-1'),
('DA', 'Desempeño académico', 'teal'),
('ME', 'Moral y ética', 'blue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `code_type`
--

CREATE TABLE `code_type` (
  `idType` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `color` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `code_type`
--

INSERT INTO `code_type` (`idType`, `type`, `color`) VALUES
('G', 'Grave', 'red lighten-2'),
('L', 'Leve', 'yellow'),
('MG', 'Muy grave', 'red'),
('P', 'Positivo', 'green');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coordinator`
--

CREATE TABLE `coordinator` (
  `idCoor` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `lastName` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `dui` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(900) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `profession` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `residence` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `phone` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `state` int(1) NOT NULL,
  `photo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `coordinator`
--

INSERT INTO `coordinator` (`idCoor`, `name`, `lastName`, `dui`, `password`, `email`, `birthdate`, `sex`, `profession`, `residence`, `phone`, `state`, `photo`) VALUES
('C1425', 'Glenda Luisa', 'Martinez Cocoa', '12345678-9', '10473!111153?108113*9702!73352*110133*10363!108113-10583/115193/10473-53L2?', 'lopezleonardo282@gmail.com', '1998-09-26', 'F', 'Licenciada en Idiomas', 'Santa Elena', '7499-2136', 1, 'C1425.jpg'),
('C1625', 'Oscar Antonio', 'Acosta Ramos', '98745612-3', '9702!112163-111153-114183*108113/9702?49l2!50a2*65272!', 'franklin.esquivel@outlook.com', '1955-10-09', 'M', 'Licenciado en comunicaciones', 'Santa Ana', '2598-3122', 1, 'C1625.jpeg'),
('C8692', 'Benito José', 'Martínez Escobar', '01235578-8', '57p2/10363-9922-10473/114183*10473?9922*50a2?', 'lopezleonardo282@gmail.com', '1981-02-01', 'M', 'Licenciado en Administración de Empresas', 'San Vicente', '2565-8595', 1, 'photo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluation_profile`
--

CREATE TABLE `evaluation_profile` (
  `idProfile` int(15) NOT NULL,
  `name` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `percentage` float NOT NULL,
  `idPeriod` int(15) NOT NULL,
  `description` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `idSubject` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `evaluation_profile`
--

INSERT INTO `evaluation_profile` (`idProfile`, `name`, `percentage`, `idPeriod`, `description`, `idSubject`) VALUES
(1, 'Prueba Objetiva', 20, 1, '', 1),
(2, 'Prueba Objetiva', 20, 1, '', 2),
(3, 'Tarea Exaula', 10, 1, '', 1),
(4, 'Tarea Exaula', 10, 1, '', 2),
(5, 'Exámen Periódico', 30, 1, '', 1),
(6, 'Exámen Periódico', 30, 1, '', 2),
(7, 'Tareas Integradoras', 40, 1, '', 1),
(8, 'Tareas Integradoras', 40, 1, '', 2),
(9, 'Corto', 10, 1, 'Fácil, como los de Miranda', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gnrl_code`
--

CREATE TABLE `gnrl_code` (
  `id_GnrlCode` int(11) NOT NULL,
  `code_reference` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `cant_code` int(11) NOT NULL,
  `code_result` int(15) NOT NULL,
  `type_result` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `gnrl_code`
--

INSERT INTO `gnrl_code` (`id_GnrlCode`, `code_reference`, `cant_code`, `code_result`, `type_result`) VALUES
(1, 'L', 6, 2, 'G'),
(2, 'G', 2, 1, 'MG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gnrl_info`
--

CREATE TABLE `gnrl_info` (
  `id_Info` int(15) NOT NULL,
  `num_hour` int(11) NOT NULL,
  `duration_hour` time NOT NULL,
  `num_breaks` int(11) NOT NULL,
  `duration_breaks` time NOT NULL,
  `max_student` int(11) NOT NULL,
  `expulsion_state` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `days_expulsion` int(11) NOT NULL,
  `cant_days` int(11) NOT NULL,
  `start_day` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `end_day` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `approved_grade` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `gnrl_info`
--

INSERT INTO `gnrl_info` (`id_Info`, `num_hour`, `duration_hour`, `num_breaks`, `duration_breaks`, `max_student`, `expulsion_state`, `days_expulsion`, `cant_days`, `start_day`, `end_day`, `approved_grade`) VALUES
(1, 10, '00:45:00', 2, '00:15:00', 40, 'E', 3, 5, 'Lunes', 'Viernes', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grade`
--

CREATE TABLE `grade` (
  `idGrade` int(15) NOT NULL,
  `grade` float NOT NULL,
  `idProfile` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `grade`
--

INSERT INTO `grade` (`idGrade`, `grade`, `idProfile`, `idStudent`) VALUES
(163, 10, 3, 'AF5943'),
(164, 10, 3, 'AG7857'),
(165, 10, 3, 'CR3842'),
(166, 10, 3, 'CR6335'),
(167, 10, 3, 'CR9637'),
(168, 10, 3, 'EH1733'),
(169, 10, 3, 'FL8465'),
(170, 10, 3, 'FR1268'),
(171, 10, 3, 'FR8837'),
(172, 10, 3, 'GR8123'),
(173, 10, 3, 'MA2133'),
(174, 10, 3, 'MG4595'),
(175, 10, 3, 'MG8115'),
(176, 10, 3, 'MG9131'),
(177, 10, 3, 'MP6846'),
(178, 10, 3, 'MP8679'),
(179, 10, 3, 'MS3438'),
(180, 10, 3, 'MS3721'),
(181, 10, 3, 'RA7444'),
(182, 10, 3, 'SG3999'),
(183, 10, 1, 'AF5943'),
(184, 10, 1, 'AG7857'),
(185, 10, 1, 'CR3842'),
(186, 10, 1, 'CR6335'),
(187, 10, 1, 'CR9637'),
(188, 10, 1, 'EH1733'),
(189, 10, 1, 'FL8465'),
(190, 10, 1, 'FR1268'),
(191, 10, 1, 'FR8837'),
(192, 10, 1, 'GR8123'),
(193, 10, 1, 'MA2133'),
(194, 10, 1, 'MG4595'),
(195, 10, 1, 'MG8115'),
(196, 10, 1, 'MG9131'),
(197, 10, 1, 'MP6846'),
(198, 10, 1, 'MP8679'),
(199, 10, 1, 'MS3438'),
(200, 10, 1, 'MS3721'),
(201, 10, 1, 'RA7444'),
(202, 10, 1, 'SG3999'),
(203, 9.2, 5, 'AF5943'),
(204, 9.2, 5, 'AG7857'),
(205, 9.2, 5, 'CR3842'),
(206, 9.2, 5, 'CR6335'),
(207, 9.2, 5, 'CR9637'),
(208, 9.2, 5, 'EH1733'),
(209, 9.2, 5, 'FL8465'),
(210, 9.2, 5, 'FR1268'),
(211, 9.2, 5, 'FR8837'),
(212, 9.2, 5, 'GR8123'),
(213, 9.2, 5, 'MA2133'),
(214, 9.2, 5, 'MG4595'),
(215, 9.2, 5, 'MG8115'),
(216, 9.2, 5, 'MG9131'),
(217, 9.2, 5, 'MP6846'),
(218, 9.2, 5, 'MP8679'),
(219, 9.2, 5, 'MS3438'),
(220, 9.2, 5, 'MS3721'),
(221, 9.2, 5, 'RA7444'),
(222, 9.2, 5, 'SG3999'),
(223, 8, 7, 'AF5943'),
(224, 8, 7, 'AG7857'),
(225, 8, 7, 'CR3842'),
(226, 8, 7, 'CR6335'),
(227, 8, 7, 'CR9637'),
(228, 8, 7, 'EH1733'),
(229, 8, 7, 'FL8465'),
(230, 8, 7, 'FR1268'),
(231, 8, 7, 'FR8837'),
(232, 8, 7, 'GR8123'),
(233, 8, 7, 'MA2133'),
(234, 8, 7, 'MG4595'),
(235, 8, 7, 'MG8115'),
(236, 8, 7, 'MG9131'),
(237, 8, 7, 'MP6846'),
(238, 8, 7, 'MP8679'),
(239, 8, 7, 'MS3438'),
(240, 8, 7, 'MS3721'),
(241, 8, 7, 'RA7444'),
(242, 8, 7, 'SG3999'),
(243, 8, 9, 'AF5943'),
(244, 8, 9, 'AG7857'),
(245, 8, 9, 'CR3842'),
(246, 8, 9, 'CR6335'),
(247, 8, 9, 'CR9637'),
(248, 8, 9, 'EH1733'),
(249, 8, 9, 'FL8465'),
(250, 8, 9, 'FR1268'),
(251, 8, 9, 'FR8837'),
(252, 8, 9, 'GR8123'),
(253, 8, 9, 'MA2133'),
(254, 8, 9, 'MG4595'),
(255, 8, 9, 'MG8115'),
(256, 8, 9, 'MG9131'),
(257, 8, 9, 'MP6846'),
(258, 8, 9, 'MP8679'),
(259, 8, 9, 'MS3438'),
(260, 8, 9, 'MS3721'),
(261, 8, 9, 'RA7444'),
(262, 8, 9, 'SG3999');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justification`
--

CREATE TABLE `justification` (
  `idJustification` int(15) NOT NULL,
  `idAssistance` int(15) NOT NULL,
  `justification` varchar(300) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justify_abscense`
--

CREATE TABLE `justify_abscense` (
  `idJustify` int(15) NOT NULL,
  `idCoor` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idGrade` int(15) NOT NULL,
  `grade_before` float NOT NULL,
  `grade_after` float NOT NULL,
  `justification` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `justify_down`
--

CREATE TABLE `justify_down` (
  `idDown` int(10) NOT NULL,
  `idUser` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `type` char(1) COLLATE utf8_spanish2_ci NOT NULL,
  `justification` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `level`
--

CREATE TABLE `level` (
  `idLevel` int(15) NOT NULL,
  `level` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `level`
--

INSERT INTO `level` (`idLevel`, `level`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mandated`
--

CREATE TABLE `mandated` (
  `idMandated` int(15) NOT NULL,
  `name` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `lastName` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `relation` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `dui` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `phone` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `sex` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `birthdate` date NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mandated`
--

INSERT INTO `mandated` (`idMandated`, `name`, `lastName`, `relation`, `dui`, `email`, `phone`, `sex`, `birthdate`, `idStudent`) VALUES
(1, 'César Claudio', 'Flores Henrique', 'Padre', '00000000-0', 'yaton2020@gmail.com', '7645-1234', 'M', '1980-08-17', 'AF5943'),
(2, 'Alejandro Julio', 'Gonzales', 'Padre', '00000001-0', 'yaton2020@gmail.com', '7634-1234', 'M', '2017-08-09', 'AG7857'),
(3, 'Script Javier', 'Ríos Alcantara', 'Padre', '00000011-0', 'yaton2020@gmail.com', '7809-1234', 'M', '1981-03-19', 'CR3842'),
(4, 'Arcadia Marta', 'Rojas', 'Madre', '00000111-0', 'yaton2020@gmail.com', '7823-2154', 'F', '1985-08-02', 'CR6335'),
(5, 'Bella Elvira', 'Reyes Torres de Cruz', 'Madre', '00001111-0', 'yaton2020@gmail.com', '7900-1123', 'F', '1980-08-02', 'CR9637'),
(6, 'Berta Diana', 'Espinoza Hernadez', 'Hermana', '00011111-0', 'yaton2020@gmail.com', '7823-4123', 'F', '2000-08-12', 'EH1733'),
(7, 'Blanca Erlina', 'Fuentes Lopez', 'Hermana', '00111111-0', 'yaton2020@gmail.com', '7243-4176', 'F', '1999-11-19', 'FL8465'),
(8, 'Reyna Liliana', 'Flores Rivera', 'Hermana', '01111111-0', 'yaton2020@gmail.com', '7667-9999', 'F', '1983-12-15', 'FR1268'),
(9, 'Leya Esma', 'Ferreyra Rosario', 'Hermana', '11111111-0', 'yaton2020@gmail.com', '7667-8866', 'F', '1978-09-06', 'FR8837'),
(10, 'Rocio Lorena', 'García Rodriguez', 'Hermana', '11111111-0', 'yaton2020@gmail.com', '7111-8866', 'F', '1991-09-21', 'GR8123'),
(11, 'Rosa Estella', 'Mejía Alfaro', 'Hermana', '11111112-0', 'yaton2020@gmail.com', '7111-8866', 'F', '1993-03-24', 'MA2133'),
(12, 'Flor Cassandra', 'Marroquin Gomez', 'Hermana', '11111122-0', 'yaton2020@gmail.com', '7131-8769', 'F', '1993-08-20', 'MG4595'),
(13, 'Carmen Feliciana', 'Morales Gutierre', 'Hermana', '11111222-0', 'yaton2020@gmail.com', '7131-2345', 'F', '1994-07-21', 'MG8115'),
(14, 'Clarisa Guadalupe', 'Moz Gonzales', 'Hermana', '11112222-0', 'yaton2020@gmail.com', '7555-0908', 'F', '1995-03-15', 'MG9131'),
(15, 'Cindy Liliana', 'Marroquin Pérez', 'Tía', '11122222-0', 'yaton2020@gmail.com', '7657-0908', 'F', '1991-02-22', 'MP6846'),
(16, 'Mercedes Michelle', 'Moreno Peralta', 'Tía', '11222222-0', 'yaton2020@gmail.com', '7657-3333', 'F', '1989-06-22', 'MP8679'),
(17, 'Monica Daniela', 'Martinez Sanchez', 'Tía', '12222222-0', 'yaton2020@gmail.com', '7657-3689', 'F', '1988-05-19', 'MS3438'),
(18, 'Nelia Jovana', 'Molina Silva', 'Hermana', '22222222-0', 'yaton2020@gmail.com', '7003-5556', 'F', '1998-09-26', 'MS3721'),
(19, 'Olivia Juliana', 'Ruiz Alvarez', 'Hermana', '22222222-0', 'yaton2020@gmail.com', '7003-5456', 'F', '1994-08-25', 'RA7444'),
(20, 'Dora Saraí', 'Script Guevara', 'Hermana', '22222223-1', 'yaton2020@gmail.com', '7443-8899', 'F', '1985-08-18', 'SG3999'),
(21, 'Norma Noemi', 'Arce Chavez', 'Hermana', '22222333-0', 'yaton2020@gmail.com', '7631-1234', 'F', '1986-08-30', 'AC9613'),
(22, 'Juanita Judith', 'Ayala Oporto', 'Hermana', '22223333-0', 'yaton2020@gmail.com', '7631-1200', 'F', '1992-01-10', 'AO9978'),
(23, 'Delphia Denisa', 'Ávila Soriano', 'Hermana', '22233333-0', 'yaton2020@gmail.com', '7631-1299', 'F', '1993-11-12', 'ÁS5815'),
(24, 'Miranda Mirari', 'Barrios Escobar', 'Hermana', '22233333-0', 'yaton2020@gmail.com', '7631-1000', 'F', '1989-08-05', 'BE4759'),
(25, 'Irune Isabel', 'Blanco Mendoza', 'Hermana', '22333333-0', 'yaton2020@gmail.com', '7631-1996', 'F', '1994-08-13', 'BM1667'),
(26, 'Bellida Bella', 'Campos Duarte', 'Hermana', '23333333-0', 'yaton2020@gmail.com', '7781-1796', 'F', '1988-08-05', 'CD6489'),
(27, 'Raquelia Rosmery', 'Cruz Ponce', 'Hermana', '33333333-0', 'yaton2020@gmail.com', '7001-1426', 'F', '1991-08-31', 'CP3677'),
(28, 'Adolfo Adrian', 'Espinoza Valenzuela', 'Hermano', '33333334-0', 'yaton2020@gmail.com', '7244-1426', 'M', '1997-08-30', 'EV6774'),
(29, 'Alberto Josue', 'Flores Torres', 'Hermano', '33333344-0', 'yaton2020@gmail.com', '7244-8888', 'M', '1990-02-24', 'FT5433'),
(30, 'Alexis Alfonso', 'Guardo Espinoza', 'Hermano', '33333444-0', 'yaton2020@gmail.com', '7244-0077', 'M', '1994-07-20', 'GE3168'),
(31, 'angel Aníbal', 'Lucero Cruz', 'Hermano', '33334444-0', 'yaton2020@gmail.com', '7244-0079', 'M', '1997-12-19', 'LC4232'),
(32, 'Ariel Antonio', 'Mejía Alfaro', 'Hermano', '33344444-0', 'yaton2020@gmail.com', '7244-2279', 'M', '1998-02-13', 'MA8967'),
(33, 'Bruno Benito', 'Miranda Roldán', 'Hermano', '33444444-0', 'yaton2020@gmail.com', '7244-2273', 'M', '1993-06-24', 'MR4469'),
(34, 'Carlos Camilo', 'Ocean Escalante', 'Hermano', '33444444-0', 'yaton2020@gmail.com', '7244-2289', 'M', '1995-08-14', 'OE3966'),
(35, 'Edwin Donato', 'Ramirez Castillo', 'Hermano', '34444444-0', 'yaton2020@gmail.com', '7244-0000', 'M', '1990-08-04', 'RC4965'),
(36, 'Ernesto Ezequiel', 'Rivero Paz', 'Hermano', '44444444-0', 'yaton2020@gmail.com', '7456-0000', 'M', '1996-08-10', 'RP8739'),
(37, 'Cristian David', 'Torres Araya', 'Hermano', '44444445-0', 'yaton2020@gmail.com', '7346-9899', 'M', '1998-08-14', 'TA9185'),
(38, 'Fabián Agustin', 'Trance Hernandez', 'Hermano', '44444455-0', 'yaton2020@gmail.com', '7346-1891', 'M', '1994-11-30', 'TH8851'),
(39, 'Felix Fermin', 'Toledo Valdez', 'Hermano', '44444555-0', 'yaton2020@gmail.com', '7346-1333', 'M', '1988-02-12', 'TV3686'),
(40, 'Fernando Fidel', 'Vargas Carrasco', 'Hermano', '44445555-0', 'yaton2020@gmail.com', '7346-1389', 'M', '1986-08-09', 'VC3344');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `period`
--

CREATE TABLE `period` (
  `idPeriod` int(15) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `percentage` float NOT NULL,
  `nthPeriod` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `period`
--

INSERT INTO `period` (`idPeriod`, `startDate`, `endDate`, `percentage`, `nthPeriod`) VALUES
(1, '2017-06-10', '2017-08-30', 25, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission`
--

CREATE TABLE `permission` (
  `idPermission` int(15) NOT NULL,
  `justification` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idSchedule` int(15) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_grade`
--

CREATE TABLE `permission_grade` (
  `idPermission_Grade` int(15) NOT NULL,
  `startDate` date NOT NULL,
  `idCoor` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `description` varchar(400) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `permission_grade`
--

INSERT INTO `permission_grade` (`idPermission_Grade`, `startDate`, `idCoor`, `approved`, `description`) VALUES
(1, '2017-08-24', 'C1425', 1, 'Me equivoqué'),
(2, '2017-08-25', '', 0, 'ss');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pg_profiles`
--

CREATE TABLE `pg_profiles` (
  `idRP` int(15) NOT NULL,
  `idProfile` int(15) NOT NULL,
  `idPermission` int(15) NOT NULL,
  `modified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pg_profiles`
--

INSERT INTO `pg_profiles` (`idRP`, `idProfile`, `idPermission`, `modified`) VALUES
(1, 9, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pg_students`
--

CREATE TABLE `pg_students` (
  `idRegisterPermission` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idPermission` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pg_students`
--

INSERT INTO `pg_students` (`idRegisterPermission`, `idStudent`, `idPermission`) VALUES
(1, 'RA7444', 1),
(2, 'SG3999', 1),
(3, 'MS3721', 1),
(4, 'MS3438', 1),
(5, 'MP6846', 1),
(6, 'MP8679', 1),
(7, 'MG9131', 1),
(8, 'MG8115', 1),
(9, 'MA2133', 1),
(10, 'MG4595', 1),
(11, 'GR8123', 1),
(12, 'LE3448', 1),
(13, 'FR8837', 1),
(14, 'FR1268', 1),
(15, 'EH1733', 1),
(16, 'FL8465', 1),
(17, 'CR9637', 1),
(18, 'CR6335', 1),
(19, 'BP2125', 1),
(20, 'CR3842', 1),
(21, 'AG7857', 1),
(22, 'AF5943', 1),
(23, 'RA7444', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `record`
--

CREATE TABLE `record` (
  `idRecord` int(11) NOT NULL,
  `idApplied_Code` int(11) NOT NULL,
  `idStudent` varchar(6) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `record`
--

INSERT INTO `record` (`idRecord`, `idApplied_Code`, `idStudent`) VALUES
(21, 21, 'AC9613'),
(22, 22, 'AC9613'),
(23, 23, 'AC9613');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `register_subject`
--

CREATE TABLE `register_subject` (
  `idRegisterSubject` int(15) NOT NULL,
  `idSubject` int(15) NOT NULL,
  `idSection` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `register_subject`
--

INSERT INTO `register_subject` (`idRegisterSubject`, `idSubject`, `idSection`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_register`
--

CREATE TABLE `schedule_register` (
  `idS_Register` int(15) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `day` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `nthHour` int(11) NOT NULL,
  `idSection` int(15) NOT NULL,
  `idSubject` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `schedule_register`
--

INSERT INTO `schedule_register` (`idS_Register`, `startTime`, `endTime`, `day`, `nthHour`, `idSection`, `idSubject`) VALUES
(1, '07:00:00', '07:45:00', 'Lunes', 1, 1, 2),
(2, '07:00:00', '07:45:00', 'Martes', 1, 2, 2),
(3, '07:00:00', '07:45:00', 'Jueves', 1, 1, 2),
(4, '07:45:00', '08:30:00', 'Lunes', 2, 1, 2),
(5, '07:45:00', '08:30:00', 'Jueves', 2, 1, 2),
(6, '08:50:00', '09:35:00', 'Lunes', 3, 1, 2),
(7, '08:50:00', '09:35:00', 'Martes', 3, 2, 2),
(8, '08:50:00', '09:35:00', 'Jueves', 3, 1, 2),
(9, '09:35:00', '10:20:00', 'Lunes', 4, 1, 2),
(10, '09:35:00', '10:20:00', 'Martes', 4, 2, 2),
(11, '09:35:00', '10:20:00', 'Jueves', 4, 1, 2),
(12, '10:40:00', '11:25:00', 'Lunes', 5, 1, 2),
(13, '10:40:00', '11:25:00', 'Jueves', 5, 2, 2),
(14, '11:25:00', '12:10:00', 'Lunes', 6, 1, 2),
(15, '11:25:00', '12:10:00', 'Martes', 6, 2, 2),
(16, '11:25:00', '12:10:00', 'Jueves', 6, 2, 2),
(17, '07:00:00', '07:45:00', 'Lunes', 1, 2, 1),
(18, '07:00:00', '07:45:00', 'Martes', 1, 1, 1),
(19, '07:00:00', '07:45:00', 'Jueves', 1, 2, 1),
(20, '07:45:00', '08:30:00', 'Lunes', 2, 2, 1),
(21, '07:45:00', '08:30:00', 'Martes', 2, 1, 1),
(22, '07:45:00', '08:30:00', 'Jueves', 2, 2, 1),
(23, '08:50:00', '09:35:00', 'Lunes', 3, 2, 1),
(24, '08:50:00', '09:35:00', 'Martes', 3, 1, 1),
(25, '08:50:00', '09:35:00', 'Jueves', 3, 2, 1),
(26, '09:35:00', '10:20:00', 'Lunes', 4, 2, 1),
(27, '09:35:00', '10:20:00', 'Martes', 4, 1, 1),
(28, '09:35:00', '10:20:00', 'Jueves', 4, 2, 1),
(29, '10:40:00', '11:25:00', 'Lunes', 5, 2, 1),
(30, '10:40:00', '11:25:00', 'Martes', 5, 2, 1),
(31, '10:40:00', '11:25:00', 'Jueves', 5, 1, 1),
(32, '11:25:00', '12:10:00', 'Lunes', 6, 2, 1),
(33, '11:25:00', '12:10:00', 'Martes', 6, 1, 1),
(34, '11:25:00', '12:10:00', 'Jueves', 6, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_teacher_gnrl_info`
--

CREATE TABLE `schedule_teacher_gnrl_info` (
  `idScheduleInfo` int(15) NOT NULL,
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idS_Register` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `schedule_teacher_gnrl_info`
--

INSERT INTO `schedule_teacher_gnrl_info` (`idScheduleInfo`, `idTeacher`, `idS_Register`) VALUES
(1, 'D1466', 1),
(2, 'D1466', 2),
(3, 'D1466', 3),
(4, 'D1466', 4),
(5, 'D1466', 5),
(6, 'D1466', 6),
(7, 'D1466', 7),
(8, 'D1466', 8),
(9, 'D1466', 9),
(10, 'D1466', 10),
(11, 'D1466', 11),
(12, 'D1466', 12),
(13, 'D1466', 13),
(14, 'D1466', 14),
(15, 'D1466', 15),
(16, 'D1466', 16),
(17, 'D1754', 17),
(18, 'D1754', 18),
(19, 'D1754', 19),
(20, 'D1754', 20),
(21, 'D1754', 21),
(22, 'D1754', 22),
(23, 'D1754', 23),
(24, 'D1754', 24),
(25, 'D1754', 25),
(26, 'D1754', 26),
(27, 'D1754', 27),
(28, 'D1754', 28),
(29, 'D1754', 29),
(30, 'D1754', 30),
(31, 'D1754', 31),
(32, 'D1754', 32),
(33, 'D1754', 33),
(34, 'D1754', 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section`
--

CREATE TABLE `section` (
  `idSection` int(15) NOT NULL,
  `idLevel` int(15) NOT NULL,
  `idSpecialty` int(15) NOT NULL,
  `sectionIdentifier` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `sState` tinyint(1) NOT NULL,
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `section`
--

INSERT INTO `section` (`idSection`, `idLevel`, `idSpecialty`, `sectionIdentifier`, `sState`, `idTeacher`) VALUES
(1, 1, 9, 'A', 1, 'D1754'),
(2, 1, 10, 'C', 1, 'D1466');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_1`
--

CREATE TABLE `section_schedule_1` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `section_schedule_1`
--

INSERT INTO `section_schedule_1` (`idRegister`, `idScheduleRegister`) VALUES
(1, 1),
(2, 3),
(3, 4),
(4, 5),
(5, 6),
(6, 8),
(7, 9),
(8, 11),
(9, 12),
(10, 14),
(11, 18),
(12, 21),
(13, 24),
(14, 27),
(15, 31),
(16, 33),
(17, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_2`
--

CREATE TABLE `section_schedule_2` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `section_schedule_2`
--

INSERT INTO `section_schedule_2` (`idRegister`, `idScheduleRegister`) VALUES
(1, 2),
(2, 7),
(3, 10),
(4, 13),
(5, 15),
(6, 16),
(7, 17),
(8, 19),
(9, 20),
(10, 22),
(11, 23),
(12, 25),
(13, 26),
(14, 28),
(15, 29),
(16, 30),
(17, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `specialty`
--

CREATE TABLE `specialty` (
  `idSpecialty` int(15) NOT NULL,
  `sName` varchar(40) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `specialty`
--

INSERT INTO `specialty` (`idSpecialty`, `sName`) VALUES
(9, 'Electrónica'),
(10, 'Sistemas Informáticos'),
(11, 'Mantenimiento Automotriz'),
(12, 'Electromecánica'),
(13, 'Administración Contable'),
(14, 'Diseño Gráfico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `state_academic`
--

CREATE TABLE `state_academic` (
  `idState` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `state_academic`
--

INSERT INTO `state_academic` (`idState`, `description`, `color`) VALUES
('A', 'Excelente', 'green'),
('E', 'Expulsado', 'red'),
('R', 'Regular', 'orange'),
('W', 'Advertido', 'yellow');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student`
--

CREATE TABLE `student` (
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `lastName` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(900) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `residence` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `idSection` int(15) NOT NULL,
  `state` int(1) NOT NULL,
  `stateAcademic` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `photo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `student`
--

INSERT INTO `student` (`idStudent`, `name`, `lastName`, `password`, `email`, `birthdate`, `sex`, `residence`, `idSection`, `state`, `stateAcademic`, `photo`, `verified`) VALUES
('AC9613', 'Juan Carlos', 'Arce Chavez', '9812!10583!10583?112163*51y2-81442?81442!68302/', 'yaton2020@gmail.com', '1999-08-22', 'M', 'Ciudad Delgado', 2, 1, 'E', 'photo.png', 1),
('AF5943', 'Alejandro Daniel', 'Azir Flores', '118223*113173!10693!114183*122263-119233*114183/113173/', 'yaton2020@gmail.com', '2001-08-17', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('AG7857', 'Daniel Henrique', 'Ayala Gonzales', '117213*117213?54F2?118223!118223-52A2?54F2/116203-55R2?49l2?109123*', 'yaton2020@gmail.com', '1999-09-15', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('AO9978', 'Andy Josué', 'Ayala Oporto', '110133/54F2-108113-110133/56o2*81442!49l2-79422-', 'yaton2020@gmail.com', '2017-08-10', 'M', 'Ilopango', 2, 1, 'R', 'photo.png', 1),
('ÁS5815', 'Thomas Julían', 'Ávila Soriano', '10693*54F2*10363!9922?112163?115193/117213!9812!', 'yaton2020@gmail.com', '1999-08-28', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('BE4759', 'Josue Ivan', 'Barrios Escobar', '10693/54F2/9702*9922*118223/109123?10033!115193/', 'yaton2020@gmail.com', '2001-08-12', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('BM1667', 'Noah Eduardo', 'Blanco Mendoza', '114183-10033?108113*56o2-48e2?119233/117213/10143!', 'yaton2020@gmail.com', '1999-08-13', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('BP2125', 'Jose Luis', 'Bardales Paniagua', '10363!122263/113173/55R2!72342-87502*89522!81442/', 'marioneta96@gmail.com', '1999-07-21', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 0),
('CD6489', 'Alessandro Adalberto', 'Campos Duarte', '49l2/118223-115193-50a2/83462?56o2?79422*66282?', 'yaton2020@gmail.com', '1999-02-17', 'M', 'Ciudad Delgado', 2, 1, 'R', 'photo.png', 1),
('CP3677', 'Jose Alejandro', 'Cruz Ponce', '48e2?121253*54F2?118223?10363*9922*117213-10473-', 'yaton2020@gmail.com', '1998-10-22', 'M', 'Ciudad delgado', 2, 1, 'R', 'photo.png', 1),
('CR3842', 'Adam Thiago', 'Cabrera Ríos', '49l2!57p2?10253?56o2?10363/119233-10363?115193/', 'yaton2020@gmail.com', '2001-08-25', 'M', 'Ilopango', 1, 1, 'R', 'photo.png', 1),
('CR6335', 'Marco Jacob', 'Castro Rojas', '49l2/117213-10143*112163?111153!115193?49l2?9812-', 'yaton2020@gmail.com', '1999-01-27', 'M', 'Ciudad Delgado', 1, 1, 'R', 'photo.png', 1),
('CR9637', 'Nicolas Jorge', 'Cruz Reyes', '53L2/121253?10473-9922*81442/51y2/57p2?77392-', 'yaton2020@gmail.com', '2002-08-16', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('EH1733', 'Pablo Santiago', 'Espinoza Hernandez', '51y2/9702*54F2!53L2!52A2?68302!75372*78402?', 'yaton2020@gmail.com', '2000-07-07', 'M', 'Altavista', 1, 1, 'R', 'photo.png', 1),
('EV6774', 'Agustino Amadeo', 'Espinoza Valenzuela', '9812!55R2/53L2-121253/9702*56o2/111153?10473*', 'yaton2020@gmail.com', '2000-12-16', 'M', 'Ciudad Delgado', 2, 1, 'R', 'photo.png', 1),
('FL8465', 'David Adrian', 'Fuentes Lopez', '10363?112163/10033-107103!50a2!10143/52A2?108113*', 'yaton2020@gmail.com', '2001-02-12', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 1),
('FR1268', 'Manuel Iker', 'Flores Rivera', '119233?10473*120243/9922-67292/84472!53L2*53L2?', 'yaton2020@gmail.com', '2000-08-07', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 1),
('FR8837', 'Leonel Andres', 'Ferreyra Rosario', '115193-53L2!52A2?119233!89522-68302?68302!66282?', 'yaton2020@gmail.com', '1998-08-21', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('FT5433', 'Cristian Esteban', 'Flores Torres', '118223-110133?109123/113173-110133?55R2-122263?10693*', 'yaton2020@gmail.com', '1998-08-30', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('GE3168', 'Daniel Alejandro', 'Guardo Espinoza', '49l2/57p2/55R2/52A2-112163?10253/117213*114183!', 'yaton2020@gmail.com', '1998-04-25', 'M', 'SAn Salvador', 2, 1, 'R', 'photo.png', 1),
('GR8123', 'Mario Sergio', 'García Rodriguez', '51y2!48e2?10473!114183*66282!87502!85482*83462?', 'yaton2020@gmail.com', '2001-08-18', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('LC4232', 'Lucas Santiago', 'Lucero Cruz', '10143/9812!107103!116203*10143*54F2-116203-9702?', 'yaton2020@gmail.com', '2000-08-19', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('LE3448', 'Rodrigo Eduardo', 'Lemus Escalante', '9702-118223*107103?110133*76382?54F2*56o2-70322-49l2!66282*50a2?', 'rodriguito2@gmail.com', '2017-08-30', 'M', 'Tonacatepeque', 1, 1, 'R', 'photo.png', 0),
('MA2133', 'Oscar Armando', 'Mejía Alfaro', '56o2*113173!120243-54F2?118223/9812-120243?117213*', 'yaton2020@gmail.com', '2000-08-25', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 1),
('MA8967', 'Carlos Orlando', 'Mejía Alfaro', '49l2*114183*10143!122263!9812*108113-55R2?111153*', 'yaton2020@gmail.com', '1998-02-18', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('MG4595', 'Carlos Daniel', 'Marroquin Gomez', '49l2!109123?120243/55R2/57p2*10583-10693-112163*', 'yaton2020@gmail.com', '1999-08-21', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('MG8115', 'Samuel Mateo', 'Morales Gutierrez', '10363?10033/10033?117213!81442-67292-89522!77392-', 'yaton2020@gmail.com', '1999-05-21', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('MG9131', 'Luis Humberto', 'Moz Gonzales', '10033?50a2?111153-9922/84472?69312/79422?65272-', 'yaton2020@gmail.com', '1999-08-28', 'M', 'Ciudad Delgado', 1, 1, 'R', 'photo.png', 1),
('MP6846', 'Hugo Álvaro', 'Marroquin Pérez', '117213-50a2-57p2*10253/85482!87502/84472/87502*', 'yaton2020@gmail.com', '1999-08-14', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 1),
('MP8679', 'Samuel Alfredo', 'Moreno Peralta', '9922*57p2!9922/9812?9702*55R2?10033*112163!', 'yaton2020@gmail.com', '2003-08-31', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('MR4469', 'Eric Leonardo', 'Miranda Roldán', '56o2?56o2*57p2/113173?53L2!119233/110133!55R2/', 'yaton2020@gmail.com', '1999-08-28', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('MS3438', 'Marcos Manuel', 'Martinez Sanchez', '116203*10143*116203?48e2/71332-80432/67292!65272-', 'yaton2020@gmail.com', '1999-08-27', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('MS3721', 'Matías Salvador', 'Molina Silva', '110133/120243!114183-118223/90532!75372-80432/78402?', 'yaton2020@gmail.com', '2001-11-29', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('OE3966', 'Daniel Eduardo', 'Ocean Escalante', '9812/122263/55R2/107103/56o2!83462*52A2-82452/', 'yaton2020@gmail.com', '2001-08-12', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('RA7444', 'Lucas Benjamín', 'Ruiz Alvarez', '55R2*113173!108113/113173?69312-48e2-75372?75372*', 'yaton2020@gmail.com', '1999-08-14', 'M', 'Soyapango', 1, 1, 'R', 'photo.png', 1),
('RC4965', 'Antonia Aparicio', 'Ramirez Castillo', '111153*122263-108113!10473/9812/51y2-111153-57p2?', 'yaton2020@gmail.com', '1998-06-27', 'M', 'Ilopango', 2, 1, 'R', 'photo.png', 1),
('RP8739', 'Mael Nicolas', 'Rivero Paz', '10583!120243*56o2/118223-52A2?69312?48e2?82452*', 'yaton2020@gmail.com', '1999-08-14', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('SG3999', 'Diego Javier', 'Script Guevara', '10033/56o2!120243?115193!87502/89522*49l2*70322/', 'yaton2020@gmail.com', '2001-11-23', 'M', 'Ilopango', 1, 1, 'R', 'photo.png', 1),
('TA9185', 'Andres Esteban', 'Torres Araya', '118223/117213?56o2-108113-85482-51y2-83462/51y2-', 'yaton2020@gmail.com', '1999-08-23', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('TH8851', 'Agustin Luciano', 'Trance Hernandez', '107103*9922?49l2-114183!10033/10363/51y2-108113/', 'yaton2020@gmail.com', '2001-08-25', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('TV3686', 'Juan Diego', 'Toledo Valdez', '53L2!120243/9702/57p2-57p2*53L2?10693*10033?', 'yaton2020@gmail.com', '1998-08-21', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('VC3344', 'Augusto José', 'Vargas Carrasco', '114183-120243!116203*111153!70322-69312*84472?87502!', 'yaton2020@gmail.com', '1998-08-11', 'M', 'Ilopango', 2, 1, 'R', 'photo.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_acc`
--

CREATE TABLE `student_acc` (
  `idAcc` int(11) NOT NULL,
  `idStudent` varchar(6) COLLATE utf8_spanish2_ci NOT NULL,
  `acc` float NOT NULL,
  `approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `student_acc`
--

INSERT INTO `student_acc` (`idAcc`, `idStudent`, `acc`, `approved`) VALUES
(1, 'AF5943', 1.22, 0),
(2, 'AG7857', 1.22, 0),
(3, 'CR3842', 1.22, 0),
(4, 'CR6335', 1.22, 0),
(5, 'CR9637', 1.22, 0),
(6, 'EH1733', 1.22, 0),
(7, 'FL8465', 1.22, 0),
(8, 'FR1268', 1.22, 0),
(9, 'FR8837', 1.22, 0),
(10, 'GR8123', 1.22, 0),
(11, 'MA2133', 1.22, 0),
(12, 'MG4595', 1.22, 0),
(13, 'MG8115', 1.22, 0),
(14, 'MG9131', 1.22, 0),
(15, 'MP6846', 1.22, 0),
(16, 'MP8679', 1.22, 0),
(17, 'MS3438', 1.22, 0),
(18, 'MS3721', 1.22, 0),
(19, 'RA7444', 1.22, 0),
(20, 'SG3999', 1.22, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject`
--

CREATE TABLE `subject` (
  `idSubject` int(15) NOT NULL,
  `nameSubject` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `acronym` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `subject`
--

INSERT INTO `subject` (`idSubject`, `nameSubject`, `idTeacher`, `acronym`, `description`) VALUES
(1, 'Estudios Sociales', 'D1754', 'SOC', 'El campo de los estudios sociales es un campo amplio y multidisciplinario que comprende las ciencias'),
(2, 'Lenguaje y Literatura', 'D1466', 'LN', 'El lenguaje y la literatura son los medios que la humanidad ha establecido para facilitar la comunic'),
(3, 'Ciencias Quimicas', 'D1754', 'QUIMIC', 'El dolor, sufrimiento y angustia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspended`
--

CREATE TABLE `suspended` (
  `idSuspended` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `suspended`
--

INSERT INTO `suspended` (`idSuspended`, `idStudent`, `StartDate`, `EndDate`) VALUES
(5, 'AC9613', '2017-08-24', '2017-08-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher`
--

CREATE TABLE `teacher` (
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `name` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `lastName` varchar(85) COLLATE utf8_spanish2_ci NOT NULL,
  `dui` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `password` varchar(900) COLLATE utf8_spanish2_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `birthdate` date NOT NULL,
  `sex` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `profession` varchar(40) COLLATE utf8_spanish2_ci NOT NULL,
  `residence` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `phone` varchar(9) COLLATE utf8_spanish2_ci NOT NULL,
  `state` int(1) NOT NULL,
  `photo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `teacher`
--

INSERT INTO `teacher` (`idTeacher`, `name`, `lastName`, `dui`, `password`, `email`, `birthdate`, `sex`, `profession`, `residence`, `phone`, `state`, `photo`) VALUES
('D1466', 'Marco Elías', 'Montano', '32659874-8', '112163!55R2-53L2?48e2*112163-107103/109123!10253/', 'marco.montano@gmail.com', '1990-04-25', 'M', 'Licenciado en Seguridad Informática', 'Los Ángeles', '2154-6598', 1, 'photo.png'),
('D1754', 'Daniel Alejandro', 'Fuentes Lizama', '85214796-3', '115193!9702*9812/10143-10143-10143?', 'alejandrofuentes85@gmail.com', '1998-09-26', 'M', 'Ingeniero en Redes', 'Santa Tecla', '2255-7755', 1, 'D1754.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher_schedule_d1466`
--

CREATE TABLE `teacher_schedule_d1466` (
  `idRegister` int(11) NOT NULL,
  `idScheduleInfo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `teacher_schedule_d1466`
--

INSERT INTO `teacher_schedule_d1466` (`idRegister`, `idScheduleInfo`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher_schedule_d1754`
--

CREATE TABLE `teacher_schedule_d1754` (
  `idRegister` int(11) NOT NULL,
  `idScheduleInfo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `teacher_schedule_d1754`
--

INSERT INTO `teacher_schedule_d1754` (`idRegister`, `idScheduleInfo`) VALUES
(1, 17),
(2, 18),
(3, 19),
(4, 20),
(5, 21),
(6, 22),
(7, 23),
(8, 24),
(9, 25),
(10, 26),
(11, 27),
(12, 28),
(13, 29),
(14, 30),
(15, 31),
(16, 32),
(17, 33),
(18, 34);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accumulated_note`
--
ALTER TABLE `accumulated_note`
  ADD PRIMARY KEY (`idAccumulated`),
  ADD KEY `idSubject` (`idSubject`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `applied_code`
--
ALTER TABLE `applied_code`
  ADD PRIMARY KEY (`idApplied_Code`),
  ADD KEY `idCode` (`idCode`),
  ADD KEY `idPeriod` (`idPeriod`);

--
-- Indices de la tabla `assistance`
--
ALTER TABLE `assistance`
  ADD PRIMARY KEY (`idAssistance`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idSchedule` (`idSchedule`);

--
-- Indices de la tabla `averages`
--
ALTER TABLE `averages`
  ADD PRIMARY KEY (`idAverage`),
  ADD KEY `idSubject` (`idSubject`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idPeriod` (`idPeriod`);

--
-- Indices de la tabla `code`
--
ALTER TABLE `code`
  ADD PRIMARY KEY (`idCode`),
  ADD KEY `type` (`type`),
  ADD KEY `category` (`category`);

--
-- Indices de la tabla `code_category`
--
ALTER TABLE `code_category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `code_type`
--
ALTER TABLE `code_type`
  ADD PRIMARY KEY (`idType`);

--
-- Indices de la tabla `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`idCoor`);

--
-- Indices de la tabla `evaluation_profile`
--
ALTER TABLE `evaluation_profile`
  ADD PRIMARY KEY (`idProfile`),
  ADD KEY `nthPeriod` (`idPeriod`),
  ADD KEY `idSubject` (`idSubject`);

--
-- Indices de la tabla `gnrl_code`
--
ALTER TABLE `gnrl_code`
  ADD PRIMARY KEY (`id_GnrlCode`),
  ADD KEY `code_reference` (`code_reference`),
  ADD KEY `code_result` (`code_result`),
  ADD KEY `type_result` (`type_result`);

--
-- Indices de la tabla `gnrl_info`
--
ALTER TABLE `gnrl_info`
  ADD PRIMARY KEY (`id_Info`),
  ADD KEY `state_expulsed` (`expulsion_state`);

--
-- Indices de la tabla `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`idGrade`),
  ADD KEY `idProfile` (`idProfile`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `justification`
--
ALTER TABLE `justification`
  ADD PRIMARY KEY (`idJustification`),
  ADD KEY `idAssistance` (`idAssistance`);

--
-- Indices de la tabla `justify_abscense`
--
ALTER TABLE `justify_abscense`
  ADD PRIMARY KEY (`idJustify`),
  ADD KEY `idCoor` (`idCoor`),
  ADD KEY `idTeacher` (`idTeacher`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idGrade` (`idGrade`);

--
-- Indices de la tabla `justify_down`
--
ALTER TABLE `justify_down`
  ADD PRIMARY KEY (`idDown`);

--
-- Indices de la tabla `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`idLevel`);

--
-- Indices de la tabla `mandated`
--
ALTER TABLE `mandated`
  ADD PRIMARY KEY (`idMandated`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`idPeriod`);

--
-- Indices de la tabla `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`idPermission`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idSchedule` (`idSchedule`);

--
-- Indices de la tabla `permission_grade`
--
ALTER TABLE `permission_grade`
  ADD PRIMARY KEY (`idPermission_Grade`),
  ADD KEY `idCoor` (`idCoor`);

--
-- Indices de la tabla `pg_profiles`
--
ALTER TABLE `pg_profiles`
  ADD PRIMARY KEY (`idRP`),
  ADD KEY `idProfile` (`idProfile`),
  ADD KEY `idPermission` (`idPermission`);

--
-- Indices de la tabla `pg_students`
--
ALTER TABLE `pg_students`
  ADD PRIMARY KEY (`idRegisterPermission`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idPermission` (`idPermission`);

--
-- Indices de la tabla `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`idRecord`),
  ADD KEY `idApplied_Code` (`idApplied_Code`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `register_subject`
--
ALTER TABLE `register_subject`
  ADD PRIMARY KEY (`idRegisterSubject`),
  ADD KEY `idSubject` (`idSubject`),
  ADD KEY `idSection` (`idSection`);

--
-- Indices de la tabla `schedule_register`
--
ALTER TABLE `schedule_register`
  ADD PRIMARY KEY (`idS_Register`),
  ADD KEY `idSection` (`idSection`),
  ADD KEY `idSubject` (`idSubject`);

--
-- Indices de la tabla `schedule_teacher_gnrl_info`
--
ALTER TABLE `schedule_teacher_gnrl_info`
  ADD PRIMARY KEY (`idScheduleInfo`),
  ADD KEY `idTeacher` (`idTeacher`),
  ADD KEY `idS_Register` (`idS_Register`);

--
-- Indices de la tabla `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`idSection`),
  ADD KEY `idLevel` (`idLevel`),
  ADD KEY `specialtyName` (`idSpecialty`),
  ADD KEY `idTeacher` (`idTeacher`);

--
-- Indices de la tabla `section_schedule_1`
--
ALTER TABLE `section_schedule_1`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_2`
--
ALTER TABLE `section_schedule_2`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `specialty`
--
ALTER TABLE `specialty`
  ADD PRIMARY KEY (`idSpecialty`);

--
-- Indices de la tabla `state_academic`
--
ALTER TABLE `state_academic`
  ADD PRIMARY KEY (`idState`);

--
-- Indices de la tabla `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`idStudent`),
  ADD KEY `idSection` (`idSection`),
  ADD KEY `stateAcademic` (`stateAcademic`);

--
-- Indices de la tabla `student_acc`
--
ALTER TABLE `student_acc`
  ADD PRIMARY KEY (`idAcc`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`idSubject`),
  ADD KEY `idTeacher` (`idTeacher`);

--
-- Indices de la tabla `suspended`
--
ALTER TABLE `suspended`
  ADD PRIMARY KEY (`idSuspended`),
  ADD KEY `idStudent` (`idStudent`);

--
-- Indices de la tabla `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`idTeacher`);

--
-- Indices de la tabla `teacher_schedule_d1466`
--
ALTER TABLE `teacher_schedule_d1466`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleInfo` (`idScheduleInfo`);

--
-- Indices de la tabla `teacher_schedule_d1754`
--
ALTER TABLE `teacher_schedule_d1754`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleInfo` (`idScheduleInfo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accumulated_note`
--
ALTER TABLE `accumulated_note`
  MODIFY `idAccumulated` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `applied_code`
--
ALTER TABLE `applied_code`
  MODIFY `idApplied_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `assistance`
--
ALTER TABLE `assistance`
  MODIFY `idAssistance` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `averages`
--
ALTER TABLE `averages`
  MODIFY `idAverage` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `code`
--
ALTER TABLE `code`
  MODIFY `idCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `evaluation_profile`
--
ALTER TABLE `evaluation_profile`
  MODIFY `idProfile` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `gnrl_code`
--
ALTER TABLE `gnrl_code`
  MODIFY `id_GnrlCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `gnrl_info`
--
ALTER TABLE `gnrl_info`
  MODIFY `id_Info` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `grade`
--
ALTER TABLE `grade`
  MODIFY `idGrade` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT de la tabla `justification`
--
ALTER TABLE `justification`
  MODIFY `idJustification` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `justify_abscense`
--
ALTER TABLE `justify_abscense`
  MODIFY `idJustify` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `justify_down`
--
ALTER TABLE `justify_down`
  MODIFY `idDown` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `level`
--
ALTER TABLE `level`
  MODIFY `idLevel` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `mandated`
--
ALTER TABLE `mandated`
  MODIFY `idMandated` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `idPeriod` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `idPermission` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permission_grade`
--
ALTER TABLE `permission_grade`
  MODIFY `idPermission_Grade` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `pg_profiles`
--
ALTER TABLE `pg_profiles`
  MODIFY `idRP` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pg_students`
--
ALTER TABLE `pg_students`
  MODIFY `idRegisterPermission` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `record`
--
ALTER TABLE `record`
  MODIFY `idRecord` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `register_subject`
--
ALTER TABLE `register_subject`
  MODIFY `idRegisterSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `schedule_register`
--
ALTER TABLE `schedule_register`
  MODIFY `idS_Register` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `schedule_teacher_gnrl_info`
--
ALTER TABLE `schedule_teacher_gnrl_info`
  MODIFY `idScheduleInfo` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `idSection` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `section_schedule_1`
--
ALTER TABLE `section_schedule_1`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `section_schedule_2`
--
ALTER TABLE `section_schedule_2`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `specialty`
--
ALTER TABLE `specialty`
  MODIFY `idSpecialty` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `student_acc`
--
ALTER TABLE `student_acc`
  MODIFY `idAcc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `idSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `suspended`
--
ALTER TABLE `suspended`
  MODIFY `idSuspended` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `teacher_schedule_d1466`
--
ALTER TABLE `teacher_schedule_d1466`
  MODIFY `idRegister` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `teacher_schedule_d1754`
--
ALTER TABLE `teacher_schedule_d1754`
  MODIFY `idRegister` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accumulated_note`
--
ALTER TABLE `accumulated_note`
  ADD CONSTRAINT `accumulated_note_ibfk_1` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`),
  ADD CONSTRAINT `accumulated_note_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `applied_code`
--
ALTER TABLE `applied_code`
  ADD CONSTRAINT `applied_code_ibfk_1` FOREIGN KEY (`idCode`) REFERENCES `code` (`idCode`),
  ADD CONSTRAINT `applied_code_ibfk_2` FOREIGN KEY (`idPeriod`) REFERENCES `period` (`idPeriod`);

--
-- Filtros para la tabla `assistance`
--
ALTER TABLE `assistance`
  ADD CONSTRAINT `assistance_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `assistance_ibfk_2` FOREIGN KEY (`idSchedule`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `averages`
--
ALTER TABLE `averages`
  ADD CONSTRAINT `averages_ibfk_1` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`),
  ADD CONSTRAINT `averages_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `averages_ibfk_3` FOREIGN KEY (`idPeriod`) REFERENCES `period` (`idPeriod`);

--
-- Filtros para la tabla `code`
--
ALTER TABLE `code`
  ADD CONSTRAINT `code_ibfk_1` FOREIGN KEY (`type`) REFERENCES `code_type` (`idType`),
  ADD CONSTRAINT `code_ibfk_2` FOREIGN KEY (`category`) REFERENCES `code_category` (`idCategory`);

--
-- Filtros para la tabla `evaluation_profile`
--
ALTER TABLE `evaluation_profile`
  ADD CONSTRAINT `evaluation_profile_ibfk_1` FOREIGN KEY (`idPeriod`) REFERENCES `period` (`idPeriod`),
  ADD CONSTRAINT `evaluation_profile_ibfk_2` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`);

--
-- Filtros para la tabla `gnrl_code`
--
ALTER TABLE `gnrl_code`
  ADD CONSTRAINT `gnrl_code_ibfk_1` FOREIGN KEY (`code_reference`) REFERENCES `code_type` (`idType`),
  ADD CONSTRAINT `gnrl_code_ibfk_3` FOREIGN KEY (`type_result`) REFERENCES `code_type` (`idType`),
  ADD CONSTRAINT `gnrl_code_ibfk_4` FOREIGN KEY (`code_result`) REFERENCES `code` (`idCode`);

--
-- Filtros para la tabla `gnrl_info`
--
ALTER TABLE `gnrl_info`
  ADD CONSTRAINT `gnrl_info_ibfk_1` FOREIGN KEY (`expulsion_state`) REFERENCES `state_academic` (`idState`);

--
-- Filtros para la tabla `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`idProfile`) REFERENCES `evaluation_profile` (`idProfile`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `justification`
--
ALTER TABLE `justification`
  ADD CONSTRAINT `justification_ibfk_1` FOREIGN KEY (`idAssistance`) REFERENCES `assistance` (`idAssistance`);

--
-- Filtros para la tabla `justify_abscense`
--
ALTER TABLE `justify_abscense`
  ADD CONSTRAINT `justify_abscense_ibfk_1` FOREIGN KEY (`idCoor`) REFERENCES `coordinator` (`idCoor`),
  ADD CONSTRAINT `justify_abscense_ibfk_2` FOREIGN KEY (`idTeacher`) REFERENCES `teacher` (`idTeacher`),
  ADD CONSTRAINT `justify_abscense_ibfk_3` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `justify_abscense_ibfk_4` FOREIGN KEY (`idGrade`) REFERENCES `grade` (`idGrade`);

--
-- Filtros para la tabla `mandated`
--
ALTER TABLE `mandated`
  ADD CONSTRAINT `mandated_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `permission`
--
ALTER TABLE `permission`
  ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `permission_ibfk_2` FOREIGN KEY (`idSchedule`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `pg_profiles`
--
ALTER TABLE `pg_profiles`
  ADD CONSTRAINT `pg_profiles_ibfk_1` FOREIGN KEY (`idProfile`) REFERENCES `evaluation_profile` (`idProfile`),
  ADD CONSTRAINT `pg_profiles_ibfk_2` FOREIGN KEY (`idPermission`) REFERENCES `permission_grade` (`idPermission_Grade`);

--
-- Filtros para la tabla `pg_students`
--
ALTER TABLE `pg_students`
  ADD CONSTRAINT `pg_students_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `pg_students_ibfk_2` FOREIGN KEY (`idPermission`) REFERENCES `permission_grade` (`idPermission_Grade`);

--
-- Filtros para la tabla `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `record_ibfk_1` FOREIGN KEY (`idApplied_Code`) REFERENCES `applied_code` (`idApplied_Code`),
  ADD CONSTRAINT `record_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `register_subject`
--
ALTER TABLE `register_subject`
  ADD CONSTRAINT `register_subject_ibfk_1` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`),
  ADD CONSTRAINT `register_subject_ibfk_2` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`);

--
-- Filtros para la tabla `schedule_register`
--
ALTER TABLE `schedule_register`
  ADD CONSTRAINT `schedule_register_ibfk_1` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`),
  ADD CONSTRAINT `schedule_register_ibfk_2` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`);

--
-- Filtros para la tabla `schedule_teacher_gnrl_info`
--
ALTER TABLE `schedule_teacher_gnrl_info`
  ADD CONSTRAINT `schedule_teacher_gnrl_info_ibfk_1` FOREIGN KEY (`idS_Register`) REFERENCES `schedule_register` (`idS_Register`),
  ADD CONSTRAINT `schedule_teacher_gnrl_info_ibfk_2` FOREIGN KEY (`idTeacher`) REFERENCES `teacher` (`idTeacher`);

--
-- Filtros para la tabla `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_ibfk_1` FOREIGN KEY (`idLevel`) REFERENCES `level` (`idLevel`),
  ADD CONSTRAINT `section_ibfk_2` FOREIGN KEY (`idSpecialty`) REFERENCES `specialty` (`idSpecialty`),
  ADD CONSTRAINT `section_ibfk_3` FOREIGN KEY (`idTeacher`) REFERENCES `teacher` (`idTeacher`);

--
-- Filtros para la tabla `section_schedule_1`
--
ALTER TABLE `section_schedule_1`
  ADD CONSTRAINT `section_schedule_1_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_2`
--
ALTER TABLE `section_schedule_2`
  ADD CONSTRAINT `section_schedule_2_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`idSection`) REFERENCES `section` (`idSection`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`stateAcademic`) REFERENCES `state_academic` (`idState`);

--
-- Filtros para la tabla `student_acc`
--
ALTER TABLE `student_acc`
  ADD CONSTRAINT `student_acc_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`idTeacher`) REFERENCES `teacher` (`idTeacher`);

--
-- Filtros para la tabla `suspended`
--
ALTER TABLE `suspended`
  ADD CONSTRAINT `suspended_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

--
-- Filtros para la tabla `teacher_schedule_d1466`
--
ALTER TABLE `teacher_schedule_d1466`
  ADD CONSTRAINT `teacher_schedule_D1466_ibfk_1` FOREIGN KEY (`idScheduleInfo`) REFERENCES `schedule_teacher_gnrl_info` (`idScheduleInfo`);

--
-- Filtros para la tabla `teacher_schedule_d1754`
--
ALTER TABLE `teacher_schedule_d1754`
  ADD CONSTRAINT `teacher_schedule_D1754_ibfk_1` FOREIGN KEY (`idScheduleInfo`) REFERENCES `schedule_teacher_gnrl_info` (`idScheduleInfo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
