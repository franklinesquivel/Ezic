-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2017 a las 06:59:39
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.0.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
  `color` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `hex` varchar(20) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `code_category`
--

INSERT INTO `code_category` (`idCategory`, `category`, `color`, `hex`) VALUES
('A', 'Asistencia', 'yellow', '#ffeb3b'),
('C', 'Comportamiento', 'purple lighten-1', '#ab47bc'),
('DA', 'Desempeño académico', 'teal', '#ab47bc'),
('ME', 'Moral y ética', 'blue', '#2196f3');

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
('C8692', 'Benito José', 'Martínez Escobar', '01235578-8', '57p2/10363-9922-10473/114183*10473?9922*50a2?', 'benito_martinez@gmail.com', '1981-02-01', 'M', 'Licenciado en Administración de Empresas', 'San Vicente', '2565-8595', 1, 'photo.png');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
(1, '2017-08-30', '2017-09-08', 20, 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pg_students`
--

CREATE TABLE `pg_students` (
  `idRegisterPermission` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idPermission` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `record`
--

CREATE TABLE `record` (
  `idRecord` int(11) NOT NULL,
  `idApplied_Code` int(11) NOT NULL,
  `idStudent` varchar(6) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
(5, 3, 1),
(6, 3, 3),
(7, 3, 4),
(8, 4, 6),
(9, 4, 7),
(10, 4, 8),
(11, 5, 2),
(12, 6, 5),
(13, 7, 3),
(14, 7, 4),
(15, 8, 7),
(16, 8, 8),
(17, 10, 6),
(18, 9, 1),
(19, 11, 1),
(20, 11, 2),
(21, 11, 3),
(22, 11, 4),
(23, 11, 5),
(24, 11, 6),
(25, 11, 7),
(26, 11, 8),
(27, 1, 3),
(28, 1, 4),
(29, 1, 5),
(30, 1, 6),
(31, 1, 7),
(32, 1, 8),
(33, 2, 3),
(34, 2, 4),
(35, 2, 5),
(36, 2, 6),
(37, 2, 7),
(38, 2, 8),
(39, 12, 2),
(40, 12, 3),
(41, 12, 4),
(42, 12, 5),
(43, 12, 6),
(44, 12, 7),
(45, 12, 8),
(46, 13, 2),
(47, 13, 3),
(48, 13, 4),
(49, 13, 5),
(50, 13, 6),
(51, 13, 7),
(52, 13, 8),
(53, 14, 2),
(54, 14, 3),
(55, 14, 4),
(56, 14, 5),
(57, 14, 6),
(58, 14, 7),
(59, 14, 8),
(60, 15, 2),
(61, 16, 5),
(62, 17, 9),
(63, 18, 9),
(64, 19, 11),
(65, 20, 10),
(66, 21, 12);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_teacher_gnrl_info`
--

CREATE TABLE `schedule_teacher_gnrl_info` (
  `idScheduleInfo` int(15) NOT NULL,
  `idTeacher` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idS_Register` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
(1, 1, 1, 'A', 0, 'D1466'),
(2, 1, 2, 'B', 0, 'D3132'),
(3, 1, 3, 'C', 0, 'D6151'),
(4, 1, 4, 'D', 0, 'D2182'),
(5, 2, 2, 'A', 0, 'D4994'),
(6, 2, 1, 'B', 0, 'D5587'),
(7, 2, 3, 'C', 0, 'D8495'),
(8, 2, 4, 'D', 0, 'D4198'),
(9, 3, 2, 'A', 0, 'D6979'),
(10, 3, 1, 'B', 0, 'D7647'),
(11, 3, 3, 'C', 0, 'D5991'),
(12, 3, 4, 'D', 0, 'D9292');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_1`
--

CREATE TABLE `section_schedule_1` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_2`
--

CREATE TABLE `section_schedule_2` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_3`
--

CREATE TABLE `section_schedule_3` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_4`
--

CREATE TABLE `section_schedule_4` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_5`
--

CREATE TABLE `section_schedule_5` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_6`
--

CREATE TABLE `section_schedule_6` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_7`
--

CREATE TABLE `section_schedule_7` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_8`
--

CREATE TABLE `section_schedule_8` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_9`
--

CREATE TABLE `section_schedule_9` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_10`
--

CREATE TABLE `section_schedule_10` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_11`
--

CREATE TABLE `section_schedule_11` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_schedule_12`
--

CREATE TABLE `section_schedule_12` (
  `idRegister` int(15) NOT NULL,
  `idScheduleRegister` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
(1, 'Electrónica'),
(2, 'Sistemas Informáticos'),
(3, 'Mantenimiento Automotriz'),
(4, 'Electromecánica'),
(5, 'Administración Contable'),
(6, 'Diseño Gráfico');

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
('AA9176', 'Anthony Francisco', 'Acosta Sosa', 'q9303NBT', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('AC4113', 'Adrían Miguel Angel', 'Castro Vera', '8nlxHCX4', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('AC5563', 'Alexander Samuel', 'Castillo Ortiz', 'y7s4ISV6', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('AC5755', 'Axel Leonardo', 'Carrizo Juárez', '315orzja', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('AC8372', 'Agustin Oscar', 'Cabrera Vega', 'd6es7us6', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('AC9757', 'Agustin Miguel', 'Castillo Ramírez', 'p8f0nxsr', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('AD8319', 'Alejandro Dylan', 'Díaz Flores', 'rg8pvvgr', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('AF6686', 'Antonio Leonardo', 'Fernández López', '3qqyCRG9', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('AG3433', 'Alejandro Juan Manuel', 'Gómez Flores', 'j1pbXD6G', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('ÁG3889', 'Álvaro Jorge', 'Gutiérrez Ferreyra', '1r4iLPCP', 'yaton2020@gmail.com', '1989-12-06', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('AG4952', 'Aaron Cesar', 'Gómez Gómez', 'zc4899wm', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Apopa', 10, 1, 'A', 'photo.png', 0),
('AG5462', 'Aaron Mauricio', 'González Pérez', '1vrhOWWCJLG', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('AJ3557', 'Agustin Eduardo', 'Juárez Sánchez', 'zlk5bqo9', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('AL1951', 'Aaron Juan Manuel', 'López Álvarez', '5kfx08qf', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('AM1481', 'Alejandro Mathew', 'Muñoz González', 'ljthOLBU', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('AM1638', 'Alexander Alexander', 'Martínez Gómez', '0ulnWFXF', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('AM3292', 'Adrían Cristobal', 'Medina Ortiz', '2l391K99BGK', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('ÁN9224', 'Ángel Luca', 'Núñez Peralta', '9d1yDDZ9', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('AP7669', 'Aaron Marcos', 'Peralta Ortiz', 'ivvpbpxm', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('AP9214', 'Axel Dylan', 'Peralta Pereyra', 'ka0zLRZV', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('AR5325', 'Alejandro Alexander', 'Romero Gutiérrez', 'm4qoscxn', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Ciudad Delgado', 5, 1, 'A', 'photo.png', 0),
('ÁR5923', 'Álvaro Francisco', 'Ramírez Pereyra', 'cwalVTBK', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('AR6451', 'Antonio Joshua', 'Rodríguez Silva', 'z3s2V87J', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 10, 1, 'A', 'photo.png', 0),
('AR6454', 'Agustin Jeronimo', 'Ríos Gómez', 'd762h9dr', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('AR7259', 'Andrés Samuel', 'Rodríguez Benítez', 'fki18zbb', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('AS1983', 'Aaron Juan David', 'Sosa Torres', '6pelgb7s', 'yaton2020@gmail.com', '1987-09-22', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('AS7999', 'Aaron Joshua', 'Sosa Suárez', 'ovpjRVVU', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('ÁT4399', 'Álvaro Juan Sebastian', 'Torres Ledesma', 'hii85CLF', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ilopango', 4, 1, 'A', 'photo.png', 0),
('AT5162', 'Aaron Gabriel', 'Torres Núñez', 'eaii0V2H', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('AT6834', 'Aaron Ricardo', 'Torres Benítez', '2ke9N49G', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('AV1432', 'Antonio Rodrigo', 'Vega Torres', 'r4xjm4sb', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Ilopango', 6, 1, 'A', 'photo.png', 0),
('AV2194', 'Andrés Juan Manuel', 'Vera Moreno', '19a0uds5', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('AV5191', 'Aaron Leonardo', 'Vázquez Ortiz', 'lf93rz5m', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('AV9782', 'Aaron Miguel', 'Vega Ríos', 'dq83alvh', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('BA3564', 'Bruno Fernando', 'Acosta Vera', '04np903n', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('BC3517', 'Benjamin Felipe', 'Castro Peralta', '2uc5R7ZEYM', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('BC4314', 'Benjamin Mario', 'Cabrera Vázquez', 'pj0reopn', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 10, 1, 'A', 'photo.png', 0),
('BG9639', 'Benjamin Juan Pablo', 'Gómez Molina', 'h1mvie2b', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('BH5175', 'Bautista Emiliano', 'Herrera Ojeda', 'mfc78mch', 'yaton2020@gmail.com', '1989-12-06', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('BL2957', 'Bruno Javier', 'Ledesma Ortiz', '3emiQIQG', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('BM7119', 'Bruno Alexander', 'Martínez Domínguez', 'e3n5qp75', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Soyanpango', 9, 1, 'A', 'photo.png', 0),
('BN8146', 'Benjamin Marcos', 'Núñez Pereyra', 'dibqVEJ7', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('BO2759', 'Benjamin Diego', 'Ojeda Gómez', 'sauwgaqm', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('BQ2628', 'Benjamin Diego', 'Quiroga Peralta', 'qepzJ91V', 'yaton2020@gmail.com', '1988-02-20', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('BR6494', 'Bruno Leonardo', 'Ramírez Vera', 'pz6u39CN', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Soyanpango', 10, 1, 'A', 'photo.png', 0),
('BR9523', 'Bruno Mateo', 'Rodríguez Vera', 'mnmhz1l7', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('BS8367', 'Bruno Felipe', 'Suárez Carrizo', 'mehmW1KE', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('BS9588', 'Bautista Alejandro', 'Sánchez Carrizo', 'i2tg3xlf', 'yaton2020@gmail.com', '1987-09-22', 'M', 'Apopa', 1, 1, 'A', 'photo.png', 0),
('CA5153', 'Cristian Jonathan', 'Aguirre Ledesma', 'eyfi1QBM', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('CC2413', 'Cesar Valentín', 'Castillo Cabrera', '4i1p825G', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('CD8339', 'Cristopher Luis', 'Domínguez Ojeda', 'yy3v6djl', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('CF7283', 'Cristobal Pedro', 'Flores González', '52i2V4UC', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('CG3314', 'Carlos Santiago', 'González Martínez', 'cgfep5i7', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('CG6284', 'Carlos Cristian', 'Gutiérrez Díaz', 'ca86eyjk', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('CG6862', 'Cesar Jorge', 'Gutiérrez Rojas', 'ljwotjfb', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('CG7763', 'Cristian Kevin', 'González Luna', 'vjtjMP14NWZ', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('CG8874', 'Cristopher Ángel', 'García Juárez', 'x5kp84pl', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('CL7913', 'Cristian Valentín', 'López Díaz', 'v2doi53m', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('CL9294', 'Cristian Isaac', 'Luna Peralta', 'xf23JLSPQR', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('CL9634', 'Cristian Mario', 'Ledesma Aguirre', 'z69556ev', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('CM1768', 'Cristobal Martín', 'Muñoz Sosa', '0n6njp5f6y', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('CM6312', 'Cristopher Leonardo', 'Moreno Carrizo', 'al1eMFBU', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('CP2577', 'Cristian Thiago', 'Ponce Morales', '4kp0QSJB', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Ilopango', 6, 1, 'A', 'photo.png', 0),
('CP7116', 'Cristobal Joshua', 'Peralta Ojeda', 'w2pe0umx', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('CP7186', 'Cesar Bruno', 'Peralta Pérez', 'jm36PONT', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('CR3815', 'Cristian Juan David', 'Ruiz Sosa', '6eq9FYL9', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('CV1817', 'Cristian Juan Pablo', 'Vera Ponce', '5vg4vd0v', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Ilopango', 6, 1, 'A', 'photo.png', 0),
('CV8946', 'Cristopher Ignacio', 'Vega Vera', 'mrwd2z98', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('DA6344', 'Dylan Esteban', 'Acosta Cabrera', 'j6p0ah69', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('DB4645', 'Diego Jorge', 'Benítez Romero', 'cmz18i0r', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('DC2479', 'Diego Rafael', 'Castro Torres', '8zpr572O', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('DC7557', 'David Guillermo', 'Castro Cabrera', '4yik9T0A', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('DJ1737', 'David Joshua', 'Juárez Rodríguez', 'bwvctp98', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('DM4228', 'David Mateo', 'Molina Ferreyra', 'nj1wnz3o', 'yaton2020@gmail.com', '1989-12-06', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('DR7348', 'Diego Axel', 'Romero González', 'kmwgv43h', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('DR7596', 'Diego Ricardo', 'Rodríguez Romero', '06lvejh8', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('DR7987', 'Daniel Agustin', 'Romero Silva', 'hjkj31CN', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('DR8694', 'Diego Samuel', 'Ríos Muñoz', 'eyq0H0JJ', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('DS5899', 'David Samuel', 'Silva Flores', 'hw7qlh19', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('DV2282', 'Dylan Samuel', 'Vázquez Acosta', 'rbqkp1rl', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('DV6321', 'Daniel Vicente', 'Vázquez Gómez', 'tsovG5IC', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('DV9275', 'David Aaron', 'Vega Carrizo', 'xdgixde4mh', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('EA1458', 'Esteban Álvaro', 'Acosta Moreno', 'xh1lf3f7', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('EA3693', 'Emmanuel Sergio', 'Acosta Moreno', '0xeqY8DQ6S', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('EA4795', 'Erick Álvaro', 'Acosta Aguirre', 'x3n9KRI3', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('EA6948', 'Eduardo Santiago', 'Aguirre Cabrera', 'z3ugBT5K', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('EF1291', 'Emiliano Santiago', 'Fernández Rojas', 'zoa9J3BG', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('EF2321', 'Esteban Ignacio', 'Ferreyra Domínguez', 'b8toOJ4Q', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('EH6526', 'Esteban Nicolás', 'Herrera Ponce', 'dmjie2re', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('EJ1516', 'Emmanuel Bruno', 'Juárez Godoy', '9t5qME7X', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Apopa', 10, 1, 'A', 'photo.png', 0),
('EJ7742', 'Esteban Rafael', 'Juárez Martínez', 'drxaEOZG', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ciudad Delgado', 12, 1, 'A', 'photo.png', 0),
('EJ8759', 'Emiliano Jorge', 'Juárez Ojeda', 'cqcljchj', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('EL4666', 'Emmanuel Gabriel', 'Ledesma Aguirre', 'cw1cv1th', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('EM7732', 'Emiliano Andrés', 'Medina Díaz', '9s3jrheq', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Apopa', 10, 1, 'A', 'photo.png', 0),
('EM8842', 'Emmanuel Maximiliano', 'Muñoz Benítez', 'on7673F3', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('EP2846', 'Emiliano Martín', 'Ponce Ruiz', 'nuphcyou', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('EP4352', 'Eduardo Kevin', 'Pérez Ponce', '6dqmn8og', 'yaton2020@gmail.com', '1987-11-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('EP9486', 'Emiliano Isaac', 'Pérez Juárez', 'oj0o6SL9', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('ER1325', 'Emilio Joaquin', 'Romero Torres', 's3ydlwgf', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('ER1971', 'Emmanuel Miguel Angel', 'Ruiz Silva', 'nyb3fe84', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('ER2461', 'Emilio Antonio', 'Ríos Benítez', '4obyvsoc', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('ER4698', 'Erick Nicolás', 'Romero García', 'j4688rkq', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ciudad Delgado', 12, 1, 'A', 'photo.png', 0),
('ER8335', 'Eduardo Eduardo', 'Rojas Juárez', 'gy0n7KXC', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('ER8677', 'Erick Guillermo', 'Romero Molina', '1x7bezgy', 'yaton2020@gmail.com', '1988-02-20', 'M', 'Ciudad Delgado', 5, 1, 'A', 'photo.png', 0),
('ES3336', 'Esteban Adrían', 'Sosa Pérez', '0642FHYQ', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('ES9328', 'Eduardo Oscar', 'Sánchez Ferreyra', 'yvu0xvjdqrg', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('ET6197', 'Eduardo Eduardo', 'Torres Vega', 'myxqNSKF', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Ciudad Delgado', 5, 1, 'A', 'photo.png', 0),
('FB7737', 'Francisco Lucas', 'Benítez Vázquez', 'zv04i8ak', 'yaton2020@gmail.com', '1988-02-20', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('FC1423', 'Francisco Guillermo', 'Cabrera López', 'kfk2X6BP', 'yaton2020@gmail.com', '1987-11-02', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('FD6561', 'Francisco Thiago', 'Díaz Cabrera', 'ywjd9ktr', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('FL3514', 'Felipe Matías', 'López Molina', '6zcl6TCH', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('FM6585', 'Fernando Pablo', 'Martínez Aguirre', 'w96mq7wg', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('FN9269', 'Francisco Valentín', 'Núñez López', '1gldHOOMM', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('FP2126', 'Fernando Esteban', 'Peralta Pereyra', 'dfv71w8k', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ilopango', 4, 1, 'A', 'photo.png', 0),
('FP9513', 'Francisco Luis', 'Peralta Acosta', 'rcv1f69g', 'yaton2020@gmail.com', '1989-12-06', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('FR8934', 'Francisco Diego', 'Rodríguez Luna', 'wg5s7GKN', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('FT1489', 'Francisco Ángel', 'Torres Gómez', 'gt0v66ot', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('FT9543', 'Fernando Jonathan', 'Torres Castro', 'jxz92H2FGO', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Ciudad Delgado', 1, 1, 'A', 'photo.png', 0),
('FV5372', 'Fernando Miguel', 'Vázquez Vázquez', '2sqcWK9J', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('FV5729', 'Felipe Sergio', 'Vázquez Godoy', 'fw83mdgi', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('GÁ5585', 'Gabriel Bruno', 'Álvarez Luna', 'fwd5qrx4', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('GF9739', 'Guillermo Miguel Angel', 'Ferreyra Rojas', 'n1p6LBWR', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('GG2548', 'Guillermo Simón', 'García Sosa', '1epltcy5', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('GG3259', 'Guillermo Andrés', 'García Rodríguez', 'op1na7a8', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('GG5559', 'Gael Benjamin', 'Godoy González', 'rj5fmrhe', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Ilopango', 1, 1, 'A', 'photo.png', 0),
('GL3842', 'Guillermo Maximiliano', 'López Díaz', 'abif1c0x', 'yaton2020@gmail.com', '1988-02-20', 'M', 'Ciudad Delgado', 5, 1, 'A', 'photo.png', 0),
('GM2229', 'Gael Jeronimo', 'Muñoz García', 'xe2tenhm', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('GM2599', 'Gael Cristopher', 'Martínez Fernández', 'o1ha6ayn', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('GM3695', 'Gael Emiliano', 'Martínez Martínez', '60t138e8', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('GR7387', 'Gabriel Agustin', 'Ríos Domínguez', 'yhfuhkfaa9a', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('GR8383', 'Gabriel Manuel', 'Ramírez Ledesma', '5bc24WKT', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('GR8429', 'Gabriel Eduardo', 'Rojas Gutiérrez', 'xwr02cch', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('GR9232', 'Gabriel Isaac', 'Rojas Ferreyra', 'p766LVWO', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Soyanpango', 9, 1, 'A', 'photo.png', 0),
('GR9663', 'Gael Lucas', 'Rodríguez Ruiz', 'fwz9do5k', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('GV2633', 'Gabriel Santiago', 'Vega Benítez', 'njx8kmtc', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('HP7681', 'Hugo Santiago', 'Peralta López', 'kfgq4DXH', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('IA3668', 'Iván Felipe', 'Aguirre Ramírez', 'f67qkahh', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Ciudad Delgado', 1, 1, 'A', 'photo.png', 0),
('IA8993', 'Iván Juan Sebastian', 'Aguirre Juárez', 'fx8r7A4T', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('IB1332', 'Ignacio Simón', 'Benítez Díaz', 'crm3OULR', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('IC9111', 'Isaac Juan Jose', 'Castillo Suárez', 'i0qeb4ig', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Soyanpango', 10, 1, 'A', 'photo.png', 0),
('IH1539', 'Iván Joshua', 'Herrera Cabrera', 'm32nvg6x', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('IH4598', 'Isaac Gael', 'Herrera Ponce', 'w4i1TJWC', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('IJ1129', 'Iván Samuel', 'Juárez Flores', '002ufyld', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('IJ2434', 'Isaac Ángel', 'Juárez Carrizo', 'r217K6X2', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('IM4233', 'Ignacio Juan', 'Moreno Ojeda', 'imndu12t', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('IP1554', 'Ignacio Luis', 'Pereyra Romero', '6yur1PE4', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('IP4186', 'Ignacio Iván', 'Pereyra Rojas', 'q6r35O1C', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('IP9464', 'Ignacio Agustin', 'Peralta Pérez', 'xjm3120g', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('IP9558', 'Isaac Luis', 'Pereyra Muñoz', '7rhdU1A5', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('IQ8729', 'Iván Eduardo', 'Quiroga Molina', '67vv45xo', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('IV6296', 'Ignacio Mathew', 'Vázquez Medina', '8u6f5gix', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('IV9459', 'Ignacio Cesar', 'Vázquez Vera', 'xn2400to', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('JÁ1787', 'Juan David Mateo', 'Álvarez Núñez', 'vwicIR0S', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('JA2924', 'Juan David Thiago', 'Acosta Torres', 'mzh6m1jo9', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('JA3561', 'Joaquin Oscar', 'Aguirre Acosta', 'cao1p1fq', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('JA6681', 'Jonathan Julían', 'Acosta Suárez', 'yv41urvg', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Ciudad Delgado', 1, 1, 'A', 'photo.png', 0),
('JA6979', 'Juan Pablo Juan Pablo', 'Acosta Ponce', 'e95t238sibr', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('JÁ7773', 'Juan Vicente', 'Álvarez Sosa', 'merjzfeh', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('JA9221', 'Jorge Jeronimo', 'Aguirre Herrera', 'pg5mxqhh', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('JB7154', 'Juan Manuel', 'Benítez Gómez', 'nf98R5XQ', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('JC1912', 'Juan Manuel Vicente', 'Carrizo Moreno', 'h0z8747t', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ilopango', 4, 1, 'A', 'photo.png', 0),
('JC7138', 'Juan David Oscar', 'Castillo Cabrera', 'y3gcaj8b', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('JC8281', 'Juan Sebastian Samuel', 'Cabrera Silva', 'lgvbECVR', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('JF4522', 'Jonathan Pedro', 'Ferreyra Peralta', 'f2nrBVYP', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('JF6695', 'Juan Sebastian David', 'Ferreyra Silva', 't22w637n', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('JF6817', 'Joaquin Juan Manuel', 'Fernández Morales', 'y8brdzug', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('JF6956', 'Jonathan Ignacio', 'Flores Díaz', 'v5kuY2HR', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('JF8851', 'Juan Jose Jorge', 'Fernández Vera', 'u8106r7r', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Apopa', 10, 1, 'A', 'photo.png', 0),
('JF9166', 'Joshua Mathew', 'Flores Aguirre', 'wtw7D9OHR', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('JG4856', 'Jesús Ignacio', 'Godoy Peralta', '0vfhBFYM', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Soyanpango', 11, 1, 'A', 'photo.png', 0),
('JG7323', 'Jose Emmanuel', 'Gómez Vega', 'jpl5MN1F', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('JG7617', 'Juan David Cristopher', 'García Moreno', 'pcpyU1DH', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('JG8253', 'Jose Agustin', 'García Benítez', 'eiqh17SF', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('JG8296', 'Juan Manuel Alejandro', 'Godoy López', '3leg0aey9', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('JG8863', 'Joshua Cristian', 'Gutiérrez Vera', '9gqz7qrh', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('JH1242', 'Jonathan Agustin', 'Herrera Ruiz', 'ikrbiv73', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('JJ2182', 'Jesús Francisco', 'Juárez Gómez', 'nnk3UMTF', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('JJ5873', 'Juan Nicolás', 'Juárez Gutiérrez', 'yujrglbk', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('JJ8389', 'Julían Jesús', 'Juárez Carrizo', 'g6wf9eps', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ilopango', 4, 1, 'A', 'photo.png', 0),
('JL5461', 'Jonathan Bautista', 'Luna Sosa', 'pyydsomo3gr', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('JL7274', 'Joshua Daniel', 'López Juárez', '2fpl18SU', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Ilopango', 1, 1, 'A', 'photo.png', 0),
('JM1958', 'Juan David Valentín', 'Medina Vázquez', 'vvkc3BIB', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('JM2892', 'Jeronimo Cesar', 'Medina Álvarez', 'abrit74o', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('JM3769', 'Jesús Valentín', 'Medina Ríos', 'kg4i99ww', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('JM4873', 'Juan Manuel Ignacio', 'Martínez Ortiz', 'tyx10llw', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('JM5279', 'Javier Mario', 'Martínez Cabrera', 'gmt8p4lf', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('JM6166', 'Juan Pablo Alexander', 'Molina Torres', 'xt9rc1na', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('JM7153', 'Joshua Juan Manuel', 'Molina Gutiérrez', 'c97kl5zq', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('JM9226', 'Juan Jose Ricardo', 'Medina López', '875d6akylo', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('JO5431', 'Julían Luis', 'Ortiz Rodríguez', 'f627LKV9', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('JP1338', 'Juan Jose Mateo', 'Pereyra González', 'l5yp491Q', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('JP6494', 'Jonathan Pedro', 'Pérez Álvarez', '8nom6glq', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('JP9542', 'Jesús Rafael', 'Pérez Flores', 'kt1fV1WGUC7', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('JQ8827', 'Jeronimo Jorge', 'Quiroga Pérez', 'fs93UVW04DF', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('JQ9587', 'Juan Jose Mathew', 'Quiroga López', 'expqRJ368L', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('JR2253', 'Jesús Vicente', 'Rojas Moreno', 'kqvqIDJM', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('JR2828', 'Julían Andrés', 'Rojas Pereyra', 'zderCU0F', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('JR3327', 'Jeronimo Alexander', 'Ríos Gutiérrez', 'wjjm7mmw', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('JR5157', 'Jorge Leonardo', 'Ruiz Benítez', 'o3q83sy8', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('JR6265', 'Juan Pablo Cristian', 'Romero Ramírez', 'leabra6n', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('JR7361', 'Joaquin Samuel', 'Ruiz Ponce', 'pvzytv03', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 10, 1, 'A', 'photo.png', 0),
('JR7753', 'Juan Sebastian Juan Jose', 'Ríos Ponce', 'dd2mmc9r', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('JR8381', 'Jose Ángel', 'Ruiz Domínguez', 'wgd6LK5Q', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('JR8687', 'Juan Jose Simón', 'Ríos López', '6w8hoidg', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('JR9444', 'Joshua Emiliano', 'Romero Torres', '7r3lSXCJ', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Apopa', 10, 1, 'A', 'photo.png', 0),
('JS1311', 'Juan Manuel Cristian', 'Suárez Morales', 'k1eeP5NF', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('JS1631', 'Jesús Juan Sebastian', 'Suárez Rojas', 'qxtfOY8W', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('JS5228', 'Juan Matías', 'Sánchez Sosa', 'dvm16DWE', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Ciudad Delgado', 6, 1, 'A', 'photo.png', 0),
('JS5299', 'Juan David Felipe', 'Sosa Pérez', 'nnwd0BJ1', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('JS7314', 'Javier Jorge', 'Sosa Molina', '5qtb7K88', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Soyanpango', 10, 1, 'A', 'photo.png', 0),
('JS9711', 'Juan Juan David', 'Silva Ponce', 'bxhgohwph', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('JT3175', 'Juan Jose Emmanuel', 'Torres Ramírez', 'klerL9OJ', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('JV1362', 'Javier Simón', 'Vera Fernández', 'e968I4KE', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ciudad Delgado', 12, 1, 'A', 'photo.png', 0),
('JV6346', 'Julían Marcos', 'Vázquez López', 'rio0lcgl', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('JV6732', 'Jorge Joaquin', 'Vera Domínguez', 'yccy2GV7H', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Soyanpango', 10, 1, 'A', 'photo.png', 0),
('JV9236', 'Joshua Mateo', 'Vega Pérez', '3mj9QFHPW', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('KÁ4733', 'Kevin Mathew', 'Álvarez Castillo', 'jxe3RR5Q', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Ilopango', 1, 1, 'A', 'photo.png', 0),
('KL8952', 'Kevin Mateo', 'Luna Suárez', 'aw3sK4H7', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('KM6618', 'Kevin Adrían', 'Moreno Fernández', 'd51r56OB', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('KO6831', 'Kevin Lucas', 'Ortiz Ojeda', 'f22kFY1SWQ', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('LA2352', 'Luis Fernando', 'Aguirre Gómez', 'v05xG1TQ', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('LB9832', 'Luis Mario', 'Benítez Ríos', 'xgir34q8', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('LC2335', 'Leonardo Adrían', 'Carrizo Fernández', 'zwqyO5YW', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('LC4825', 'Lucas Marcos', 'Castro Aguirre', 'j19zim5h', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('LC8432', 'Leonardo Mathew', 'Castillo Castillo', 'sus9en0q', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('LG3866', 'Luca Emilio', 'González García', 'vr2f2xpr', 'yaton2020@gmail.com', '1988-01-01', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('LM5852', 'Luis Mateo', 'Medina González', 'alaeJN3I', 'yaton2020@gmail.com', '1987-09-22', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('LM7791', 'Lucas Esteban', 'Muñoz Luna', '5xvlykra', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('LM8535', 'Lucas Luis', 'Moreno Sánchez', 'imzft9jp', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('LO5959', 'Lucas Agustin', 'Ortiz Martínez', 'j5g34EZS', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('LP3696', 'Leonardo Ignacio', 'Ponce Molina', 'xev6bqwe', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('LP6885', 'Luca Joaquin', 'Pereyra Ruiz', 'gmrrwwwn', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('LP9455', 'Luis Carlos', 'Peralta Gómez', '4sj8vqfk', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Ilopango', 4, 1, 'A', 'photo.png', 0),
('LQ3145', 'Lucas Guillermo', 'Quiroga Moreno', 'rvuopwv9', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('LR3335', 'Luis Cristian', 'Rojas Silva', 'wtcbtmctip', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Apopa', 1, 1, 'A', 'photo.png', 0),
('LR6137', 'Leonardo Juan Manuel', 'Rodríguez Vega', 'guqcV92D', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('LS1267', 'Leonardo Rodrigo', 'Silva Sosa', 'hcdvjqvj', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('MA1436', 'Miguel Angel Isaac', 'Aguirre Cabrera', 'yxe3tcb9', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('MÁ5258', 'Mauricio Luca', 'Álvarez Pérez', '630e6UB5', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('MA9567', 'Matías Anthony', 'Acosta Herrera', 'pkxlM0US', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('MA9739', 'Mauricio Juan', 'Acosta Rojas', 'zymfe2kg', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('MC4456', 'Mario Juan Sebastian', 'Castro Sánchez', 'hjlcgbtp', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Apopa', 4, 1, 'A', 'photo.png', 0),
('MC8646', 'Mauricio Nicolás', 'Cabrera González', 'lx5rache', 'yaton2020@gmail.com', '1987-11-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('MD4436', 'Martín Lucas', 'Díaz Peralta', 'tmauYM9P', 'yaton2020@gmail.com', '1988-10-01', 'M', 'Ciudad Delgado', 1, 1, 'A', 'photo.png', 0),
('MD9555', 'Miguel Angel Emiliano', 'Domínguez García', 'k9pul6fr', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('MF1821', 'Manuel Manuel', 'Ferreyra Rojas', 'rpreVBFO', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Soyanpango', 8, 1, 'A', 'photo.png', 0),
('MF8216', 'Mathew Valentín', 'Ferreyra Luna', 'e85sCHSW', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Ilopango', 12, 1, 'A', 'photo.png', 0),
('MG5738', 'Martín Juan Pablo', 'Gómez Martínez', '6hvi50rm', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('MH6433', 'Matías Vicente', 'Herrera Ramírez', 'x7rttl5c', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('MJ6199', 'Miguel Guillermo', 'Juárez Quiroga', '2ntfPYVC', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('ML9342', 'Martín Juan Sebastian', 'Luna Benítez', 'l3r9e19u', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('MM4383', 'Maximiliano Jorge', 'Medina Romero', 've4c6B38', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('MM4716', 'Mateo Axel', 'Morales Godoy', 'tgmk6891os', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('MM4921', 'Marcos Emiliano', 'Morales Ríos', '041bVRDB', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Ilopango', 1, 1, 'A', 'photo.png', 0),
('MN2956', 'Miguel Angel Miguel Angel', 'Núñez González', 'udwyw53v', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('MO3283', 'Martín Juan', 'Ortiz Ojeda', 'h5e98RYU', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('MP3665', 'Manuel Alexander', 'Pereyra Cabrera', '9qj102p5', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('MQ5455', 'Miguel Angel Jesús', 'Quiroga Castro', 'yn2d6sdo', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('MR3799', 'Maximiliano Juan David', 'Rodríguez Ruiz', 'wfi39ttg', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Apopa', 8, 1, 'A', 'photo.png', 0),
('MR6432', 'Miguel Angel Iván', 'Ramírez Castillo', '8dw460SG', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ciudad Delgado', 11, 1, 'A', 'photo.png', 0),
('MR6891', 'Matías Carlos', 'Ramírez Vázquez', 'bxepej7m', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Ciudad Delgado', 1, 1, 'A', 'photo.png', 0),
('MR9215', 'Manuel Bruno', 'Ríos Cabrera', 'zd0zngc8s2r', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('MS4199', 'Mateo Pablo', 'Sánchez Muñoz', '88uuPJ33', 'yaton2020@gmail.com', '1987-07-03', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('MS5346', 'Mathew Jesús', 'Sánchez Rojas', 'ukw0grxh', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('MS6856', 'Miguel David', 'Silva Ojeda', '6zn2y4yn', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Ilopango', 10, 1, 'A', 'photo.png', 0),
('MS8242', 'Matías Manuel', 'Sánchez Vega', '0rk8WQ4Z', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('MT4823', 'Matías Juan Pablo', 'Torres Gutiérrez', '12qg3w1d', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Ilopango', 6, 1, 'A', 'photo.png', 0),
('MV1492', 'Martín Juan Jose', 'Vega Quiroga', 'd8yhsrup', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Ciudad Delgado', 12, 1, 'A', 'photo.png', 0),
('MV3491', 'Matías Jonathan', 'Vázquez Pereyra', 'op3q3PTV', 'yaton2020@gmail.com', '1987-09-22', 'M', 'Ilopango', 1, 1, 'A', 'photo.png', 0),
('MV4899', 'Matías Alejandro', 'Vega Godoy', 'x3cxv78n', 'yaton2020@gmail.com', '1987-12-23', 'M', 'Soyanpango', 12, 1, 'A', 'photo.png', 0),
('MV6472', 'Maximiliano Mateo', 'Vázquez Rojas', 'y7go947oadl', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('NL7389', 'Nicolás Jose', 'López Martínez', '3y7ow1t4', 'yaton2020@gmail.com', '1989-10-26', 'M', 'Soyanpango', 6, 1, 'A', 'photo.png', 0),
('NR2346', 'Nicolás Joaquin', 'Ríos Sánchez', '7a9puj11', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('NR5288', 'Nicolás Thiago', 'Ruiz Luna', 'z6h28u0j', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('OD7389', 'Oscar Jesús', 'Díaz Pérez', '31z6YPDB', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('OO1499', 'Oscar Anthony', 'Ojeda Acosta', 'lptt1x02', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('OP9186', 'Oscar Joshua', 'Pereyra Ortiz', 'g9fw7mcv', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('OR5469', 'Oscar Cristobal', 'Rojas Herrera', 'gx25IDGR', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('PÁ9139', 'Pablo Iván', 'Álvarez Gutiérrez', '86trZ95S', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Ciudad Delgado', 4, 1, 'A', 'photo.png', 0),
('PC6556', 'Pablo Gael', 'Cabrera Sosa', 'yaypKDUJ', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('PF2525', 'Pablo Lucas', 'Ferreyra Suárez', 'wxlj8H6G', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Ilopango', 10, 1, 'A', 'photo.png', 0),
('PG4466', 'Pedro Eduardo', 'Gutiérrez Romero', '6qp2YUEC', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('PJ6839', 'Pablo Lucas', 'Juárez Cabrera', 'kgzrK9HO', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('PO7218', 'Pedro Guillermo', 'Ojeda Sosa', 'kg1i3HG9', 'yaton2020@gmail.com', '0000-00-00', 'M', 'Soyanpango', 1, 1, 'A', 'photo.png', 0),
('PQ1759', 'Pedro Julían', 'Quiroga Herrera', 'nuroj19a', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('PV2487', 'Pedro Benjamin', 'Vega Domínguez', 'v84tO60H', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Ciudad Delgado', 7, 1, 'A', 'photo.png', 0),
('RA5176', 'Rafael Emmanuel', 'Aguirre Vera', 'cqcgKE7M', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('RD2532', 'Rodrigo Gael', 'Díaz Gómez', 'tl5w7I0N', 'yaton2020@gmail.com', '1987-04-25', 'M', 'Soyanpango', 7, 1, 'A', 'photo.png', 0),
('RG8592', 'Rafael Cristopher', 'Gutiérrez Ferreyra', '0fncV5Y5', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('RH4492', 'Ricardo Dylan', 'Herrera Acosta', 'nwnvAYHN', 'yaton2020@gmail.com', '1987-10-20', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('RL8513', 'Rodrigo Carlos', 'López Vega', 'e4zw6f6k', 'yaton2020@gmail.com', '1987-02-17', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('RS9179', 'Ricardo Emmanuel', 'Suárez Ortiz', 'zsif3jgr', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Apopa', 2, 1, 'A', 'photo.png', 0),
('RV4421', 'Rafael Rodrigo', 'Vega Rojas', 'um5zxlzf', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Ciudad Delgado', 3, 1, 'A', 'photo.png', 0),
('RV4986', 'Rodrigo Erick', 'Vega Castro', 'z5a06OND', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('RV5182', 'Rodrigo Nicolás', 'Vera Suárez', '3n647HNP', 'yaton2020@gmail.com', '1989-07-02', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('SA1975', 'Santiago Matías', 'Acosta Díaz', 'b7fh4MA6', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Ilopango', 5, 1, 'A', 'photo.png', 0),
('SA3991', 'Santiago Santiago', 'Acosta Díaz', 'mopdLSZB', 'yaton2020@gmail.com', '1988-02-05', 'M', 'Ilopango', 7, 1, 'A', 'photo.png', 0),
('SA9292', 'Santiago Agustin', 'Aguirre González', 'o140G3QQ', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('SC3163', 'Santiago Cesar', 'Carrizo Quiroga', 'p6pd1k39', 'yaton2020@gmail.com', '1989-11-06', 'M', 'Apopa', 7, 1, 'A', 'photo.png', 0),
('SC6342', 'Samuel Vicente', 'Castro Silva', 'fa0fRVCT', 'yaton2020@gmail.com', '1987-11-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('SF6611', 'Sergio Ángel', 'Ferreyra Ledesma', 'nathLSP6', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('SF9413', 'Santiago Francisco', 'Ferreyra Juárez', 'm6j9klyq', 'yaton2020@gmail.com', '1989-02-27', 'M', 'Apopa', 6, 1, 'A', 'photo.png', 0),
('SG2151', 'Simón Antonio', 'García Muñoz', 'uwmnOXLA', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Apopa', 3, 1, 'A', 'photo.png', 0),
('SG3697', 'Santiago Ángel', 'García Ramírez', 'guj81ntb', 'yaton2020@gmail.com', '1988-02-19', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('SM2988', 'Santiago Daniel', 'Morales Luna', '8rjozkuv', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('SM5922', 'Samuel Agustin', 'Morales Rodríguez', '0jewRYVN', 'yaton2020@gmail.com', '1987-10-03', 'M', 'Soyanpango', 4, 1, 'A', 'photo.png', 0),
('SN1921', 'Santiago Emmanuel', 'Núñez Godoy', 'kq7n3FAC', 'yaton2020@gmail.com', '1987-09-22', 'M', 'Apopa', 1, 1, 'A', 'photo.png', 0),
('SN5436', 'Samuel Cesar', 'Núñez Gutiérrez', 'rrsfkg5t', 'yaton2020@gmail.com', '1987-02-09', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('SP1535', 'Sergio Mario', 'Peralta Ruiz', '6tz536U4', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Soyanpango', 9, 1, 'A', 'photo.png', 0),
('SP6718', 'Santiago Jeronimo', 'Ponce Gómez', 'uzp8qmoz', 'yaton2020@gmail.com', '1988-10-11', 'M', 'Soyanpango', 3, 1, 'A', 'photo.png', 0),
('SR9236', 'Samuel Andrés', 'Rojas Castillo', 'zv8u6t6c', 'yaton2020@gmail.com', '1987-06-14', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('SS6823', 'Simón Benjamin', 'Sosa Gómez', '8k8l2za7', 'yaton2020@gmail.com', '1989-05-02', 'M', 'Apopa', 9, 1, 'A', 'photo.png', 0),
('ST7337', 'Samuel Pedro', 'Torres Díaz', 'l7so1o7f', 'yaton2020@gmail.com', '1988-02-22', 'M', 'Ilopango', 11, 1, 'A', 'photo.png', 0),
('TC8337', 'Tomás Juan', 'Castillo Sosa', '3h4pO829', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Soyanpango', 5, 1, 'A', 'photo.png', 0),
('TD6176', 'Tomás Rafael', 'Díaz Ortiz', 'ewtrVBYKK', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('TF4321', 'Tomás Marcos', 'Ferreyra Castillo', '4021micb', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ciudad Delgado', 2, 1, 'A', 'photo.png', 0),
('TG6519', 'Thiago Álvaro', 'González Gutiérrez', 'ajlx6RXO', 'yaton2020@gmail.com', '1987-11-07', 'M', 'Ciudad Delgado', 5, 1, 'A', 'photo.png', 0),
('TM4163', 'Thiago Simón', 'Molina Pereyra', '29ryR67X', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('TM7295', 'Thiago Iván', 'Muñoz Silva', '9xcg33CS', 'yaton2020@gmail.com', '1989-02-08', 'M', 'Ciudad Delgado', 9, 1, 'A', 'photo.png', 0),
('TO1216', 'Tomás Oscar', 'Ojeda González', 'c354tpug', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Soyanpango', 2, 1, 'A', 'photo.png', 0),
('TP7975', 'Tomás Cristobal', 'Pérez Morales', 'jfw9a14o', 'yaton2020@gmail.com', '1989-02-02', 'M', 'Ilopango', 2, 1, 'A', 'photo.png', 0),
('TR1521', 'Thiago Ricardo', 'Ramírez Torres', 'ltwuWY7G', 'yaton2020@gmail.com', '1987-03-04', 'M', 'Apopa', 5, 1, 'A', 'photo.png', 0),
('TS6665', 'Tomás Mathew', 'Sosa Gutiérrez', 'mqrgJCGE', 'yaton2020@gmail.com', '1987-02-05', 'M', 'Ciudad Delgado', 8, 1, 'A', 'photo.png', 0),
('TV3337', 'Thiago Juan David', 'Vázquez Muñoz', 'kxopOL7N', 'yaton2020@gmail.com', '1987-02-21', 'M', 'Ilopango', 3, 1, 'A', 'photo.png', 0),
('TV5391', 'Thiago Anthony', 'Vázquez Ortiz', 'lyigJIW9', 'yaton2020@gmail.com', '1989-12-06', 'M', 'Apopa', 11, 1, 'A', 'photo.png', 0),
('TV6434', 'Thiago Álvaro', 'Vázquez Moreno', '72zr60GE', 'yaton2020@gmail.com', '1987-02-16', 'M', 'Ciudad Delgado', 10, 1, 'A', 'photo.png', 0),
('VM3416', 'Vicente Felipe', 'Moreno Ponce', 'xan2is4m', 'yaton2020@gmail.com', '1987-11-03', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0),
('VM5322', 'Vicente Bautista', 'Moreno Acosta', 'x1zudc0g', 'yaton2020@gmail.com', '1988-11-06', 'M', 'Ilopango', 9, 1, 'A', 'photo.png', 0),
('VP7753', 'Vicente Juan Sebastian', 'Pereyra Castro', 'w0k2NXGE', 'yaton2020@gmail.com', '1989-05-01', 'M', 'Apopa', 12, 1, 'A', 'photo.png', 0),
('VV4812', 'Valentín Julían', 'Vera Ferreyra', '5mxvNPWB', 'yaton2020@gmail.com', '1989-01-01', 'M', 'Ilopango', 8, 1, 'A', 'photo.png', 0);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_average`
--

CREATE TABLE `student_average` (
  `idAverage` int(11) NOT NULL,
  `idStudent` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `idPeriod` int(10) NOT NULL,
  `average` float NOT NULL,
  `approved` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
(3, 'Metalurgia', 'D4198', 'MLA', 'Todos sobre los metales.'),
(4, 'Metalurgia II', 'D4198', 'MLA II', 'Procesos de Industrialización'),
(5, 'Lenguajes de Programación', 'D5587', 'LP', 'Bases de la programación'),
(6, 'Lenguajes de Programación II', 'D5587', 'LP II', 'Procesos de complejidad avanzados y manejo de datos estructurados.'),
(7, 'Automatización', 'D2182', 'AUT', 'Conceptos básicos de los procesos de automatización'),
(8, 'Automatización II', 'D2182', 'AUT II', 'Manejo de automatización de procesos a nivel industrial'),
(9, 'Circuitos Digitales', 'D4994', 'CD', 'Conceptos básicos sobre el desarrollo, composición y funcionalidad de los distintos componentes elec'),
(10, 'Circuitos Digitales II', 'D4994', 'CD II', 'Introducción a la programación de componentes electrónicos y circuitos integrados.'),
(11, 'Matemáticas', 'D3132', 'MAT', ' partir de axiomas y siguiendo razonamientos lógicos, las matemáticas analizan estructuras, magnitud'),
(12, 'Ciencias Físicas', 'D4994', 'CF', 'Entender la estructura de las leyes de la Física y tomar parte en el descubrimiento de nuevos fenóme'),
(13, 'Ciencias Biológicas', 'D2414', 'CB', 'Es la disciplina que tiene como foco de estudio a los organismos vivos y todo lo inherente a los mis'),
(14, 'Ciencias Químicas', 'D3132', 'CQ', 'Es la ciencia que estudia tanto la composición, la estructura y las propiedades de la materia como l'),
(15, 'Redes de Área Local', 'D1466', 'LAN', 'Introducción a las redes informáticas.'),
(16, 'Redes de Área Local II', 'D1466', 'LAN II', 'Composición de Redes locales y comunicación entre ellas.'),
(17, 'Redes de Área Amplia', 'D1754', 'WAN', 'Abstracción de redes y complexión de estas.'),
(18, 'Programación Orientada a Objetos', 'D6979', 'POO', 'Paradigma de programación POO'),
(19, 'Sistemas Digitales y Electrónicos', 'D9292', 'SDE', 'Estudio de los sistemas eléctricos y digitales que componen los automóviles.'),
(20, 'Lenguajes de Programación', 'D6151', 'LP', 'Programación avanzada de circuitos integrados.'),
(21, 'Automatización Avanzada', 'D4198', 'AUTA', 'Procesos avanzados y profesionales');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suspended`
--

CREATE TABLE `suspended` (
  `idSuspended` int(15) NOT NULL,
  `idStudent` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `idCoordinator` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Justification` varchar(200) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
('D1754', 'Daniel Alejandro', 'Fuentes Lizama', '85214796-3', '115193!9702*9812/10143-10143-10143?', 'alejandrofuentes85@gmail.com', '1998-09-26', 'M', 'Ingeniero en Redes', 'Santa Tecla', '2255-7755', 1, 'D1754.jpg'),
('D2182', 'Josué Leonardo', 'Guevara Sanchez', '00005555-3', '55R2*49l2/10363/110133!10143?48e2/117213!111153-', 'yaton2020@gmail.com', '1990-09-29', 'M', 'Ing. Mecanico', 'San Salvador, Soyapango', '7002-2412', 1, 'photo.png'),
('D2414', 'Matilda Eleonor', 'Cruz Quintana', '12348174-5', '107103*9702?49l2/9922*49l2-85482!48e2/84472*', 'mat.cruz@gmail.com', '1980-04-09', 'F', 'Licenciada en Ciencias Naturales', 'Col. Los Ángeles', '65987421', 1, 'photo.png'),
('D3132', 'Vicentico Rodrigo', 'Bunbury Escalante', '09093311-1', '116203?113173*118223!109123*86492!86492*50a2!79422*', 'yaton2020@gmail.com', '1991-08-07', 'M', 'Ing. Químico', 'San Salvador, Soyapango', '7001-8001', 1, 'photo.png'),
('D4198', 'Valeria Ximena', 'Villafañe Sandoval', '00990099-3', '52A2/116203-53L2*10473!115193/116203-111153-55R2/', 'yaton2020@gmail.com', '1991-04-27', 'F', 'Ing. Industrial', 'San Salvador, Soyapango', '7271-1111', 1, 'photo.png'),
('D4994', 'Carlos Andres', 'Ayala Damasco', '00901234-4', '109123-111153?10033?120243/85482-86492!52A2!56o2*', 'yaton2020@gmail.com', '1981-01-31', 'M', 'Ing. Eléctrico', 'San Salvador, Soyapango', '7003-0005', 1, 'photo.png'),
('D5587', 'Camila Valentina', 'Sixtina Pinta', '00009993-8', '117213/109123?56o2/9812*81442*75372*65272!80432-', 'yaton2020@gmail.com', '1984-03-10', 'F', 'Ing. Sistema Informáticos', 'San Salvador, Soyapango', '7676-3434', 1, 'photo.png'),
('D5991', 'Isabel Juliana', 'Aguirre Suárez', '09022787-1', '110133?121253!9922/114183!49l2/79422!85482!72342!', 'yaton2020@gmail.com', '1990-10-20', 'F', 'Ing. Industrial', 'San Salvador, Ciudad Delgado', '7435-1100', 1, 'photo.png'),
('D6151', 'Kevin José', 'Aguilar Urquilla', '44440000-2', '9702/53L2/10143?49l2-10363-52A2/115193?10363*', 'yaton2020@gmail.com', '1998-04-11', 'M', 'Ing. Industrial', 'San Salvador, Soyapango', '7002-0001', 1, 'photo.png'),
('D6979', 'Ashley Agustina', 'Castro Rojas', '09098787-1', '10473?114183*56o2*9922?112163-57p2!55R2*113173?', 'yaton2020@gmail.com', '1982-01-15', 'F', 'Ing. Sistema Informáticos', 'San Salvador, Ciudad Delgado', '7878-1111', 1, 'photo.png'),
('D7647', 'Isabel Juliana', 'Aguirre Suárez', '33098787-1', '112163-114183!52A2/10583/72342!65272!65272?70322/68302!52A2/', 'yaton2020@gmail.com', '1988-06-25', 'F', 'Lic. Contaduría', 'San Salvador, Ciudad Delgado', '7778-7889', 1, 'photo.png'),
('D8495', 'Sara Victoria', 'Dulce Manzanar', '09123456-1', '49l2?120243!57p2/55R2/9702-110133!110133/10363/', 'yaton2020@gmail.com', '1988-03-19', 'F', 'Ing. Mecánica', 'San Salvador, Ciudad Delgado', '7801-1111', 1, 'photo.png'),
('D9292', 'Carla Vanessa', 'Silva Ortiz', '09038745-1', '108113-50a2?49l2/10253-113173?48e2/120243!10583!111153*', 'yaton2020@gmail.com', '1983-05-07', 'F', 'Ing. Mecánica', 'San Salvador, Ciudad Delgado', '7666-6789', 1, 'photo.png');

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
-- Indices de la tabla `section_schedule_3`
--
ALTER TABLE `section_schedule_3`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_4`
--
ALTER TABLE `section_schedule_4`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_5`
--
ALTER TABLE `section_schedule_5`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_6`
--
ALTER TABLE `section_schedule_6`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_7`
--
ALTER TABLE `section_schedule_7`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_8`
--
ALTER TABLE `section_schedule_8`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_9`
--
ALTER TABLE `section_schedule_9`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_10`
--
ALTER TABLE `section_schedule_10`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_11`
--
ALTER TABLE `section_schedule_11`
  ADD PRIMARY KEY (`idRegister`),
  ADD KEY `idScheduleRegister` (`idScheduleRegister`);

--
-- Indices de la tabla `section_schedule_12`
--
ALTER TABLE `section_schedule_12`
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
-- Indices de la tabla `student_average`
--
ALTER TABLE `student_average`
  ADD PRIMARY KEY (`idAverage`),
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idPeriod` (`idPeriod`);

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
  ADD KEY `idStudent` (`idStudent`),
  ADD KEY `idCoordinator` (`idCoordinator`);

--
-- Indices de la tabla `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`idTeacher`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accumulated_note`
--
ALTER TABLE `accumulated_note`
  MODIFY `idAccumulated` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `applied_code`
--
ALTER TABLE `applied_code`
  MODIFY `idApplied_Code` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `assistance`
--
ALTER TABLE `assistance`
  MODIFY `idAssistance` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `averages`
--
ALTER TABLE `averages`
  MODIFY `idAverage` int(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `code`
--
ALTER TABLE `code`
  MODIFY `idCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `evaluation_profile`
--
ALTER TABLE `evaluation_profile`
  MODIFY `idProfile` int(15) NOT NULL AUTO_INCREMENT;
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
  MODIFY `idGrade` int(15) NOT NULL AUTO_INCREMENT;
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
  MODIFY `idMandated` int(15) NOT NULL AUTO_INCREMENT;
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
  MODIFY `idPermission_Grade` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pg_profiles`
--
ALTER TABLE `pg_profiles`
  MODIFY `idRP` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pg_students`
--
ALTER TABLE `pg_students`
  MODIFY `idRegisterPermission` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `record`
--
ALTER TABLE `record`
  MODIFY `idRecord` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `register_subject`
--
ALTER TABLE `register_subject`
  MODIFY `idRegisterSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT de la tabla `schedule_register`
--
ALTER TABLE `schedule_register`
  MODIFY `idS_Register` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `schedule_teacher_gnrl_info`
--
ALTER TABLE `schedule_teacher_gnrl_info`
  MODIFY `idScheduleInfo` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `idSection` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `section_schedule_1`
--
ALTER TABLE `section_schedule_1`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_2`
--
ALTER TABLE `section_schedule_2`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_3`
--
ALTER TABLE `section_schedule_3`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_4`
--
ALTER TABLE `section_schedule_4`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_5`
--
ALTER TABLE `section_schedule_5`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_6`
--
ALTER TABLE `section_schedule_6`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_7`
--
ALTER TABLE `section_schedule_7`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_8`
--
ALTER TABLE `section_schedule_8`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_9`
--
ALTER TABLE `section_schedule_9`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_10`
--
ALTER TABLE `section_schedule_10`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_11`
--
ALTER TABLE `section_schedule_11`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `section_schedule_12`
--
ALTER TABLE `section_schedule_12`
  MODIFY `idRegister` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `specialty`
--
ALTER TABLE `specialty`
  MODIFY `idSpecialty` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `student_acc`
--
ALTER TABLE `student_acc`
  MODIFY `idAcc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `student_average`
--
ALTER TABLE `student_average`
  MODIFY `idAverage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `idSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `suspended`
--
ALTER TABLE `suspended`
  MODIFY `idSuspended` int(15) NOT NULL AUTO_INCREMENT;
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
-- Filtros para la tabla `section_schedule_3`
--
ALTER TABLE `section_schedule_3`
  ADD CONSTRAINT `section_schedule_3_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_4`
--
ALTER TABLE `section_schedule_4`
  ADD CONSTRAINT `section_schedule_4_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_5`
--
ALTER TABLE `section_schedule_5`
  ADD CONSTRAINT `section_schedule_5_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_6`
--
ALTER TABLE `section_schedule_6`
  ADD CONSTRAINT `section_schedule_6_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_7`
--
ALTER TABLE `section_schedule_7`
  ADD CONSTRAINT `section_schedule_7_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_8`
--
ALTER TABLE `section_schedule_8`
  ADD CONSTRAINT `section_schedule_8_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_9`
--
ALTER TABLE `section_schedule_9`
  ADD CONSTRAINT `section_schedule_9_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_10`
--
ALTER TABLE `section_schedule_10`
  ADD CONSTRAINT `section_schedule_10_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_11`
--
ALTER TABLE `section_schedule_11`
  ADD CONSTRAINT `section_schedule_11_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

--
-- Filtros para la tabla `section_schedule_12`
--
ALTER TABLE `section_schedule_12`
  ADD CONSTRAINT `section_schedule_12_ibfk_1` FOREIGN KEY (`idScheduleRegister`) REFERENCES `schedule_register` (`idS_Register`);

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
-- Filtros para la tabla `student_average`
--
ALTER TABLE `student_average`
  ADD CONSTRAINT `student_average_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`),
  ADD CONSTRAINT `student_average_ibfk_2` FOREIGN KEY (`idPeriod`) REFERENCES `period` (`idPeriod`);

--
-- Filtros para la tabla `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`idTeacher`) REFERENCES `teacher` (`idTeacher`);

--
-- Filtros para la tabla `suspended`
--
ALTER TABLE `suspended`
  ADD CONSTRAINT `suspended_ibfk_1` FOREIGN KEY (`idCoordinator`) REFERENCES `coordinator` (`idCoor`),
  ADD CONSTRAINT `suspended_ibfk_2` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
