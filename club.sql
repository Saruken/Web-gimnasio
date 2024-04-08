-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-01-2023 a las 09:24:24
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `socio` bigint(20) NOT NULL,
  `servicio` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`socio`, `servicio`, `fecha`, `hora`) VALUES
(1, 1, '2022-12-16', '11:15:00'),
(1, 2, '2022-11-16', '17:00:00'),
(1, 3, '2023-02-25', '17:00:00'),
(4, 3, '2022-12-20', '17:00:00'),
(6, 2, '2023-01-16', '11:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` varchar(2000) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'El horario de verano permanente dañará nuestra salud, dicen los expertos', '“El llamado para poner fin a la práctica anticuada de cambiar el reloj está cobrando impulso en todo el país”, dijo el senador Marco Rubio, quien presentó inicialmente el proyecto de ley en el Senado de EE.UU., en un comunicado. La legislatura de Florida votó para hacer permanente el horario de verano en Florida en 2018, pero no puede entrar en vigencia hasta que también sea una ley federal.\r\n\r\nEl proyecto de ley todavía tiene que pasar por la Cámara de Representantes de EE.UU. y ser promulgado por el presidente. Si ese es el caso o cuando sea así, adelantaremos nuestros relojes y los dejaremos así, viviendo permanentemente una hora por delante del Sol.\r\n\r\nSin embargo, un número creciente de expertos en sueño dicen que el acto de adelantar nuestros relojes en la primavera está arruinando nuestra salud. Los estudios de los últimos 25 años han demostrado que el cambio de una hora interrumpe los ritmos corporales sintonizados con la rotación de la Tierra, echando leña al debate sobre si es una buena idea tener el horario de verano en cualquier forma.', 'img/noticias/noticia1.webp', '2022-11-15'),
(2, 'Salud mental en personas mayores: ¿es posible mantener la calidad de vida?', 'Me gusta decir cómo me siento. Sacar a la luz lo que está dentro, que es un foco de dolor y de aislamiento”. Juana, de 68 años, lleva desde muy joven viviendo con esquizofrenia. Amante del arte y de la literatura, reflexiona acerca de su enfermedad y de cómo sobrellevarla a medida que se hace mayor. Casi tan mayor como Manuel, de 73 años, que recuerda que a los 21 tuvo el primer brote de esquizofrenia: “Pasé toda mi juventud entrando y saliendo de unidades de psiquiatría. Sigo teniendo muchos brotes, sobre todo cuando estoy solo, y aquí estoy acompañado”. Ese ‘aquí’ es la residencia donde pasa sus días. Una residencia diferente, porque está especializada en personas que han cumplido 65 años, tienen diagnosticado un trastorno mental grave y necesitan de apoyos sociales y sanitarios vinculados a su dependencia. Tanto Juana como Manuel son compañeros de enfermedad, pero también de distracciones: escriben, pasean por la ciudad, visitan museos, hablan de arte. Mantienen ese nivel de autonomía que les permite estar atendidos y cuidados pero, al mismo tiempo, seguir', 'img/noticias/noticia2.jpg', '2022-11-04'),
(3, 'Los niños abordan la salud mental', 'Representantes de seis consejos locales de juventud e infancia  de la provincia repasaron ayer la situación en materia de salud mental y plantearon propuestas para abordar este problema entre los más jóvenes, además de trasladar toda una serie de preguntas sobre diversos temas a los alcaldes y concejales que ayer les acompañaban en el Salón de Plenos de la Diputación.\n\nEl motivo de este encuentro fue el II Foro Provincial por la Participación Infantil, que presidió la vicepresidenta de la institución provincial responsable del área de Atención a las Personas, Petra Sánchez. Junto a ella se encontraba el delegado de Unicef en Ciudad Real, Ángel María Rico Navas. Sánchez explicó a los participantes el papel de la Diputación y su composición.\n\nLos pequeños consejeros tuvieron un primer turno de intervenciones en el que analizaron la  situación en materia de salud mental infanto- juvenil, desde la incidencia en el entorno familiar y la vida cotidiana de los propios niños, como la influencia de las redes sociales, hasta diferentes propuestas de medidas a adoptar que afectarían tanto a la organización de los centros escolares como a los servicios de Atención Primaria o los hospitales.\n\nLos niños prepararon con esmero sus intervenciones, unos con textos cuidadosamente redactados, otros con un mural, algunos con un estilo conciso y los de al lado con discursos más desarrollados, pero quien sorprendió a los asistentes fue la delegación de Alcázar de San Juan, que de un modo muy teatral cambió el foco para que sus compañeros sentados en los asientos del público se unieran a su alegato mediante carteles y diferentes intervenciones.\n\nEntre las reivindicaciones expuestas surgieron cuestiones como la creación de grupos de autoayuda en los centros escolares, la inclusión de psicólogos en los colegios, analizar el papel de los tutores, intervenir para reducir las listas de espera en las unidades de salud mental infanto-juvenil, así como potenciar estas unidades en el Sescam', 'img/noticias/noticia3.webp', '2022-11-09'),
(4, 'Deporte y talento se dan cita en el MEH', 'El ex jugador de baloncesto español Juan Antonio Corbalán y la deportista paralímpica Marta Fernández inauguraron hoy el nuevo curso STEM Talent Girl 2022-2023, y lo hicieron animando a las jóvenes a ser \"ambiciosas\" y trabajar para conseguir sus objetivos. A lo largo de siete años, el programa STEM Talent Girl, ha ofrecido apoyo y orientación a más de mil niñas que aspiraban a estudiar carreras de ciencia, tecnología, ingeniería y matemáticas.\r\nEl Museo de la Evolución Humana (MEH) acogió el acto de apertura de esta séptima edición del curso STEM Talent Girl, durante el cual se puso en valor la importancia de este tipo de iniciativas. Un programa que, tal y como indicó el delegado territorial de la Junta, Roberto Saiz, es hoy \"menos necesario que cuando se creó\", pero sigue siendo muy importante recordar a las alumnas que deben luchar por seguir sus vocaciones científicas. \r\n\"En la vida no puedes elegir la comodidad y lo que es fácil si quieres aspirar a grandes cosas\", explicó Corbalán dirigiéndose a las jóvenes que hoy llenaban el salón de actos MEH. Así, recordó su experiencia con el deporte y como \"se le cumplían sueños antes de soñarlos\". Por ello, animó a las alumnas a ser \"ambiciosas y mirar lejos\", porque los constantes cambios han hechos que la gente sea cada vez \"más precoz\", debido a que dispone de más medios que antes. \r\n\"No hay conocimiento de ciencias o letras: es universal. El mundo va a cambiar exactamente igual con vosotras o sin vosotras, pero podéis pasar por la vida queriendo dejar una impronta allá donde estéis\", añadió. Recordando además la conocida película de \'El Club de los Poetas Muertos\', animó a las presentes a ser \"trascendentales\" y a no \"pasar desapercibidas\" .', 'img/noticias/noticia4.webp', '2022-12-31'),
(5, 'El deporte matutino reduce el riesgo de enfermedad cardíaca y accidente cerebrovascular', 'Está bien establecido que el ejercicio es bueno para la salud del corazón, pero existe controversia sobre cuál es el mejor momento del día para realizar deporte. Esta duda han conseguido despejarla investigadores del Centro Médico de la Universidad de Leiden, Países Bajos, quienes han publicado sus principales conclusiones en la revista \'European Journal of Preventive Cardiology\', de la Sociedad Europea de Cardiología.\r\nLa principal conclusión es que la actividad física matutina está asociada con el riesgo más bajo de enfermedad cardíaca y accidente cerebrovascular, según el estudio realizado en más de 85.000 personas. Es importante destacar que los hallazgos fueron consistentes independientemente de la cantidad total de actividad diaria, además fueron particularmente pronunciados en las mujeres y se aplicaron tanto a los madrugadores como a los noctámbulos.\r\nEl estudio utilizó datos del Biobanco del Reino Unido. Incluyó a 86.657 adultos de 42 a 78 años que no padecían enfermedades cardiovasculares al inicio del estudio. La edad promedio fue de 62 años y el 58 por ciento eran mujeres. Los participantes usaron un rastreador de actividad en la muñeca durante siete días consecutivos. Los participantes fueron seguidos por enfermedad cardiovascular incidente, que se definió como la primera admisión hospitalaria o muerte relacionada con enfermedad arterial coronaria o accidente cerebrovascular.\r\nDurante seis a ocho años de seguimiento, 2.911 participantes desarrollaron enfermedad arterial coronaria y 796 sufrieron un accidente cerebrovascular. Al comparar las horas pico de actividad en un período de 24 horas, estar más activo entre las 8 am y las 11 am se vinculó con los riesgos más bajos de enfermedad cardíaca y accidente cerebrovascular.\r\nEn un segundo análisis, los investigadores dividieron a los participantes en cuatro grupos según la hora pico de actividad física: 1) mediodía; 2) temprano en la mañana (8 am); 3) tarde en la mañana (10 am); y 4) tarde (7 pm).', 'img/noticias/noticia5.webp', '2022-08-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`) VALUES
(1, 'Set de Palos de Golf Inesis 100 Grafito Adulto Diestro Talla 2', 139.99),
(2, 'Pala de pádel Kuikma 990 Hybrid Hard adulto', 99.99),
(3, 'Bañador natación Hombre Jammer costuras termoselladas FINA Nabaiji negro', 149.99),
(4, 'Bicicleta de gravel aluminio freno de disco monoplato 10V Triban GRVL120 verde', 749.99),
(6, '2019 modelo Callaway Warbird palo Juego 10 Clubs R (carbono) con Caddie Bolsa', 749.99),
(7, 'Phelps Bañador natación Mujer Matrix Open Back Women EU Negro', 419.99),
(8, 'Bullpadel Paquito Navarro Hack 03 Swedish Open 2022', 348.95),
(9, 'Optimum Nutrition Proteína On 100% Whey Gold Standard 5 Lbs (2,27 Kg)', 79.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` bigint(20) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `duracion` int(3) NOT NULL,
  `precio` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id`, `descripcion`, `duracion`, `precio`) VALUES
(1, 'Masaje', 30, 24.95),
(2, 'Entrenador personal', 120, 39.99),
(3, 'Alquilar pista de padel', 120, 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `edad` int(2) DEFAULT NULL,
  `usuario` varchar(20) NOT NULL,
  `pass` varchar(32) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `foto` varchar(80) DEFAULT '../../img/usuarios/'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `nombre`, `edad`, `usuario`, `pass`, `telefono`, `foto`) VALUES
(0, 'Administrador', NULL, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', NULL, NULL),
(1, 'Vicki Medina Granados', 36, 'Wheres86', '48a44a3465937b25b804a1e430a54310', '650652502', 'img/usuarios/Wheres86.jpeg'),
(2, 'Menqui Fajardo Almaraz', 46, 'Oneve1975', 'a4e2c7a772be64d55b9542b9661bcc4f', '732993992', 'img/usuarios/Oneve1975.jpg'),
(3, 'Quinciano Prado Sepúlveda', 74, 'Rocklairling1948', '4612903434617f0616b5ccebefa5922c', '726503133', 'img/usuarios/Rocklairling1948.jpg'),
(4, 'Dalmiro Benavides Serna', 53, 'Danor1969', '1c1a814eee42221e4b147992b9b25626', '748953744', 'img/usuarios/Danor1969.jpg'),
(5, 'Hedda Ruiz Macías', 32, 'Prow1990', '8312c03862cf6fd6c5af688032c6dc73', '736424751', 'img/usuarios/Prow1990.jpeg'),
(6, 'Gregory Cazares Veliz', 41, 'Wasill', '2d95f55e7193cd4df70e027e3e30a667', '677502253', 'img/usuarios/Wasill.jpeg'),
(7, 'Yudit Gurule Salcido', 34, 'Boyough', 'e6d57ad740d87250bf711cbec2316b40', '779596426', 'img/usuarios/Boyough.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` bigint(20) NOT NULL,
  `autor` bigint(20) NOT NULL,
  `contenido` varchar(200) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id`, `autor`, `contenido`, `fecha`) VALUES
(1, 1, 'Muy buen servicio, me gusta mucho', '2022-11-01'),
(2, 3, 'Buenas instalaciones', '2022-11-06'),
(3, 2, 'Muy abarrotado, hay que ir pronto', '2022-11-22'),
(4, 4, 'De las mejores pistas de padel que he ido', '2022-11-22');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`socio`,`servicio`,`fecha`,`hora`),
  ADD KEY `fk_citas_servicio` (`servicio`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_testimonio_socio` (`autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`servicio`) REFERENCES `servicio` (`id`),
  ADD CONSTRAINT `fk_citas_socio` FOREIGN KEY (`socio`) REFERENCES `socio` (`id`);

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `fk_testimonio_socio` FOREIGN KEY (`autor`) REFERENCES `socio` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
