INSERT INTO `teacher` (`idTeacher`, `name`, `lastName`, `dui`, `password`, `email`, `birthdate`, `sex`, `profession`, `residence`, `phone`, `state`, `photo`) VALUES
('D2336', 'José Duarte', 'Cabrera Rivas', '12345678-9', '114183/10583*113173!112163?73352/50a2-73352!70322*', 'rodrigolemus3098@gmail.com', '1984-08-17', 'M', 'Ing. Sistemas Informaticos', 'San Salvador, Altavista', '7676-1234', 1, 'photo.png'),
('D5693', 'Nelson Jose', 'Trance Perez', '00991133-1', '118223!49l2/10143?110133*56o2-9812-10363/9922?', 'yaton2020@gmail.com', '1985-08-15', 'M', 'Ing. Mecanica', 'San Salvador, Soyapango', '7891-6632', 1, 'photo.png'),
('D9141', 'Emilio Edgardo', 'Flores Torres', '44440000-1', '113173?48e2?57p2/48e2*118223!49l2-9812*114183-', 'rodrigolemus3098@gmail.com', '1984-01-12', 'M', 'Ing. Electrónica', 'San Salvador, Soyapango', '7999-6660', 1, 'photo.png');



INSERT INTO `subject` (`idSubject`, `nameSubject`, `idTeacher`, `acronym`, `description`) VALUES
(1, 'Estudios Sociales', 'D1754', 'SOC', 'El campo de los estudios sociales es un campo amplio y multidisciplinario que comprende las ciencias'),
(2, 'Lenguaje y Literatura', 'D1466', 'LN', 'El lenguaje y la literatura son los medios que la humanidad ha establecido para facilitar la comunic');



INSERT INTO `specialty` (`idSpecialty`, `sName`) VALUES
(1, 'Electrónica'),
(2, 'Sistemas Informáticos'),
(3, 'Mantenimiento Automotriz'),
(4, 'Electromecánica'),
(4, 'Administración Contable'),
(6, 'Diseño Gráfico');



INSERT INTO `section` (`idSection`, `idLevel`, `idSpecialty`, `sectionIdentifier`, `sState`, `idTeacher`) VALUES
(1, 1, 1, 'A', 1, 'D1754'),
(2, 1, 2, 'B', 1, 'D1466'),
(3, 2, 1, 'A', 0, 'D2336'),
(4, 2, 2, 'C', 0, 'D9141'),
(5, 2, 4, 'D', 0, 'D5693');



INSERT INTO `register_subject` (`idRegisterSubject`, `idSubject`, `idSection`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 1),
(4, 2, 2);


INSERT INTO `student` (`idStudent`, `name`, `lastName`, `password`, `email`, `birthdate`, `sex`, `residence`, `idSection`, `state`, `stateAcademic`, `photo`, `verified`) VALUES
('AC9613', 'Juan Carlos', 'Arce Chavez', '9812!10583!10583?112163*51y2-81442?81442!68302/', 'yaton2020@gmail.com', '1999-08-22', 'M', 'Ciudad Delgado', 2, 1, 'R', 'photo.png', 1),
('AF5943', 'Alejandro Daniel', 'Azir Flores', '118223*113173!10693!114183*122263-119233*114183/113173/', 'yaton2020@gmail.com', '2001-08-17', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('AG7857', 'Daniel Henrique', 'Ayala Gonzales', '117213*117213?54F2?118223!118223-52A2?54F2/116203-55R2?49l2?109123*', 'yaton2020@gmail.com', '1999-09-15', 'M', 'San Salvador', 1, 1, 'R', 'photo.png', 1),
('AO9978', 'Andy Josué', 'Ayala Oporto', '110133/54F2-108113-110133/56o2*81442!49l2-79422-', 'yaton2020@gmail.com', '2017-08-10', 'M', 'Ilopango', 2, 1, 'R', 'photo.png', 1),
('ÁS5815', 'Thomas Julían', 'Ávila Soriano', '10693*54F2*10363!9922?112163?115193/117213!9812!', 'yaton2020@gmail.com', '1999-08-28', 'M', 'Soyapango', 2, 1, 'R', 'photo.png', 1),
('BE4759', 'Josue Ivan', 'Barrios Escobar', '10693/54F2/9702*9922*118223/109123?10033!115193/', 'yaton2020@gmail.com', '2001-08-12', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
('BM1667', 'Noah Eduardo', 'Blanco Mendoza', '114183-10033?108113*56o2-48e2?119233/117213/10143!', 'yaton2020@gmail.com', '1999-08-13', 'M', 'San Salvador', 2, 1, 'R', 'photo.png', 1),
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


INSERT INTO `evaluation_profile` (`idProfile`, `name`, `percentage`, `idPeriod`, `description`, `idSubject`) VALUES
(1, 'Prueba Objetiva', 20, 1, '', 1),
(2, 'Prueba Objetiva', 20, 1, '', 2),
(3, 'Exámen de período', 30, 1, '', 1),
(4, 'Exámen de período', 30, 1, '', 2),
(5, 'Tareas en el aula', 10, 1, '', 1),
(6, 'Tareas en el aula', 10, 1, '', 2),
(7, 'Tareas Integradoras', 40, 1, '', 1),
(8, 'Tareas Integradoras', 40, 1, '', 2);



