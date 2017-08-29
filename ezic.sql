-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-08-2017 a las 02:59:48
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ezic_franklin`
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `specialty`
--

CREATE TABLE `specialty` (
  `idSpecialty` int(15) NOT NULL,
  `sName` varchar(40) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

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
  `average` decimal(2,2) NOT NULL,
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
('D1754', 'Daniel Alejandro', 'Fuentes Lizama', '85214796-3', '115193!9702*9812/10143-10143-10143?', 'alejandrofuentes85@gmail.com', '1998-09-26', 'M', 'Ingeniero en Redes', 'Santa Tecla', '2255-7755', 1, 'D1754.jpg');

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
  MODIFY `idAccumulated` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `applied_code`
--
ALTER TABLE `applied_code`
  MODIFY `idApplied_Code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `assistance`
--
ALTER TABLE `assistance`
  MODIFY `idAssistance` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `averages`
--
ALTER TABLE `averages`
  MODIFY `idAverage` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `code`
--
ALTER TABLE `code`
  MODIFY `idCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `evaluation_profile`
--
ALTER TABLE `evaluation_profile`
  MODIFY `idProfile` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
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
  MODIFY `idGrade` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `justification`
--
ALTER TABLE `justification`
  MODIFY `idJustification` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `idMandated` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `period`
--
ALTER TABLE `period`
  MODIFY `idPeriod` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `permission`
--
ALTER TABLE `permission`
  MODIFY `idPermission` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permission_grade`
--
ALTER TABLE `permission_grade`
  MODIFY `idPermission_Grade` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `pg_profiles`
--
ALTER TABLE `pg_profiles`
  MODIFY `idRP` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `pg_students`
--
ALTER TABLE `pg_students`
  MODIFY `idRegisterPermission` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `record`
--
ALTER TABLE `record`
  MODIFY `idRecord` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `register_subject`
--
ALTER TABLE `register_subject`
  MODIFY `idRegisterSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `schedule_register`
--
ALTER TABLE `schedule_register`
  MODIFY `idS_Register` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `schedule_teacher_gnrl_info`
--
ALTER TABLE `schedule_teacher_gnrl_info`
  MODIFY `idScheduleInfo` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `section`
--
ALTER TABLE `section`
  MODIFY `idSection` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `specialty`
--
ALTER TABLE `specialty`
  MODIFY `idSpecialty` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `student_acc`
--
ALTER TABLE `student_acc`
  MODIFY `idAcc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `student_average`
--
ALTER TABLE `student_average`
  MODIFY `idAverage` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `subject`
--
ALTER TABLE `subject`
  MODIFY `idSubject` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
  ADD CONSTRAINT `student_average_ibfk_1` FOREIGN KEY (`idStudent`) REFERENCES `student` (`idStudent`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
