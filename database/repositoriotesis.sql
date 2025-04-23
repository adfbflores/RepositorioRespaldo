-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2022 a las 21:57:06
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repositoriotesis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archive_list`
--

CREATE TABLE `archive_list` (
  `id` int(30) NOT NULL,
  `archive_code` varchar(100) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `year` year(4) NOT NULL,
  `title` text NOT NULL,
  `abstract` text NOT NULL,
  `members` text NOT NULL,
  `banner_path` text NOT NULL,
  `document_path` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `student_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `archive_list`
--

INSERT INTO `archive_list` (`id`, `archive_code`, `curriculum_id`, `year`, `title`, `abstract`, `members`, `banner_path`, `document_path`, `status`, `student_id`, `date_created`, `date_updated`) VALUES
(4, '2022080001', 9, 2022, ' Resultados del Ranking Mundial del Talento 2021 ï»¿', '&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;El Ranking Mundial del Talento es elaborado por el Institute of Management Development (IMD) de Suiza, en asociaci&oacute;n con Centrum PUCP para el desarrollo del cap&iacute;tulo de Per&uacute;. Este ranking es considerado como uno de los instrumentos m&aacute;s importantes para la implementaci&oacute;n de pol&iacute;ticas de gesti&oacute;n del talento humano que busquen mejores condiciones para el desarrollo profesional y personal, as&iacute; como aumentar la calidad de educaci&oacute;n desde la etapa escolar hasta superior. Asimismo, este estudio permite clasificar a 64 pa&iacute;ses por medio de una evaluaci&oacute;n en los aspectos de Inversi&oacute;n y Desarrollo, Atracci&oacute;n, y Preparaci&oacute;n para el Futuro. Con este estudio, Centrum PUCP reafirma su compromiso con la sociedad como instituci&oacute;n generadora de informaci&oacute;n de alta calidad y de gran impacto. Adem&aacute;s, se presenta este ranking con el fin de que sea usado como una herramienta base por los tomadores de decisiones, que buscan promover una mejor situaci&oacute;n del talento nacional en el futuro .&lt;/span&gt;', '&lt;p&gt;- Luis Tito&lt;/p&gt;&lt;p&gt;- Nelson zabala&lt;/p&gt;', 'uploads/banners/archive-4.png?v=1660251697', 'uploads/pdf/archive-4.pdf?v=1660175222', 1, 6, '2022-08-10 18:47:01', '2022-08-11 16:01:37'),
(8, '2022080002', 9, 2022, 'Resultados del Ranking de Competitividad Mundial 2022', '&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;Centrum PUCP, escuela de negocios de la Pontificia Universidad del Per&uacute; (PUCP) y el Institute of Management Development (IMD) de Suiza, presentan los resultados del Ranking de Competitividad Mundial edici&oacute;n 2022, como una herramienta importante para medir la competitividad de una muestra de 63 pa&iacute;ses desde un enfoque hol&iacute;stico. En esta edici&oacute;n 2022, Per&uacute; se ubica en el puesto 54 subiendo cuatro posiciones en el ranking general a comparaci&oacute;n del a&ntilde;o 2021, pero cae en 3 de los cuatro pilares. La medici&oacute;n se realiza por medio de cuatro pilares: (a) Desempe&ntilde;o Econ&oacute;mico, (b) Eficiencia del Gobierno, (c) Eficiencia de Negocios e (d) infraestructura, Asimismo, cinco factores son medidos en cada pilar y un n&uacute;mero determinado de indicadores forman parte de cada factor. Seg&uacute;n el &uacute;ltimo reporte, Per&uacute; alcanza 49.6 puntos (en una escala de 0 a 100 puntos) y se ubica en el puesto 54 de una muestra de 63 pa&iacute;ses, lo cual evidencia un incremento de 4.2 puntos y una mejora de cuatro posiciones, en comparaci&oacute;n con los resultados del a&ntilde;o pasado. El Ranking de Competitividad Mundial 2022 clasifica a los pa&iacute;ses de acuerdo con el nivel de competitividad, cuya definici&oacute;n es la capacidad que tiene cada pa&iacute;s de generar prosperidad al usar todos los recursos disponibles y competencias de su econom&iacute;a. En esta edici&oacute;n 2022, los resultados muestran con claridad la complejidad de la crisis peruana, su profundidad y sobre todo el riesgo inminente de perder los fundamentos de la estabilidad econ&oacute;mica.&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;-Jhoel&lt;/p&gt;', 'uploads/banners/archive-8.png?v=1660256939', 'uploads/pdf/archive-8.pdf?v=1660256939', 1, 6, '2022-08-11 17:28:58', '2022-08-11 17:29:10'),
(13, '2022080003', 9, 2022, 'Resultados del Ranking Mundial del Talento 2023', '&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;El Ranking Mundial del Talento es elaborado por el Institute of Management Development (IMD) de Suiza, en asociaci&oacute;n con Centrum PUCP para el desarrollo del cap&iacute;tulo de Per&uacute;. Este ranking es considerado como uno de los instrumentos m&aacute;s importantes para la implementaci&oacute;n de pol&iacute;ticas de gesti&oacute;n del talento humano que busquen mejores condiciones para el desarrollo profesional y personal, as&iacute; como aumentar la calidad de educaci&oacute;n desde la etapa escolar hasta superior. Asimismo, este estudio permite clasificar a 64 pa&iacute;ses por medio de una evaluaci&oacute;n en los aspectos de Inversi&oacute;n y Desarrollo, Atracci&oacute;n, y Preparaci&oacute;n para el Futuro. Con este estudio, Centrum PUCP reafirma su compromiso con la sociedad como instituci&oacute;n generadora de informaci&oacute;n de alta calidad y de gran impacto. Adem&aacute;s, se presenta este ranking con el fin de que sea usado como una herramienta base por los tomadores de decisiones, que buscan promover una mejor situaci&oacute;n del talento nacional en el futuro .&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;- saul&lt;/p&gt;&lt;p&gt;-raul&lt;/p&gt;', 'uploads/banners/archive-13.png?v=1660608491', 'uploads/pdf/archive-13.pdf?v=1660608491', 1, 6, '2022-08-15 19:08:10', '2022-08-15 19:10:57'),
(14, '2022080004', 11, 2022, 'Resultados del Ranking Mundial del Talento 2024', '&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, Arial, sans-serif; font-size: 14px; text-align: justify;&quot;&gt;El Ranking Mundial del Talento es elaborado por el Institute of Management Development (IMD) de Suiza, en asociaci&oacute;n con Centrum PUCP para el desarrollo del cap&iacute;tulo de Per&uacute;. Este ranking es considerado como uno de los instrumentos m&aacute;s importantes para la implementaci&oacute;n de pol&iacute;ticas de gesti&oacute;n del talento humano que busquen mejores condiciones para el desarrollo profesional y personal, as&iacute; como aumentar la calidad de educaci&oacute;n desde la etapa escolar hasta superior. Asimismo, este estudio permite clasificar a 64 pa&iacute;ses por medio de una evaluaci&oacute;n en los aspectos de Inversi&oacute;n y Desarrollo, Atracci&oacute;n, y Preparaci&oacute;n para el Futuro. Con este estudio, Centrum PUCP reafirma su compromiso con la sociedad como instituci&oacute;n generadora de informaci&oacute;n de alta calidad y de gran impacto. Adem&aacute;s, se presenta este ranking con el fin de que sea usado como una herramienta base por los tomadores de decisiones, que buscan promover una mejor situaci&oacute;n del talento nacional en el futuro .&lt;/span&gt;&lt;br&gt;&lt;/p&gt;', '&lt;p&gt;-loco&lt;/p&gt;', 'uploads/banners/archive-14.png?v=1660609984', 'uploads/pdf/archive-14.pdf?v=1660609986', 1, 8, '2022-08-15 19:33:03', '2022-08-15 19:34:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curriculum_list`
--

CREATE TABLE `curriculum_list` (
  `id` int(30) NOT NULL,
  `department_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `curriculum_list`
--

INSERT INTO `curriculum_list` (`id`, `department_id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(9, 7, 'INGENIERIA DE SISTEMAS', 'Cursos relacionados a la ingenierÃ­a de sistemas', 1, '2022-08-10 16:52:13', NULL),
(11, 7, 'INGENIERIA DE ELECTRONICA', 'hshjddj', 1, '2022-08-15 18:57:45', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `department_list`
--

CREATE TABLE `department_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `department_list`
--

INSERT INTO `department_list` (`id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(7, 'FACULTAD DE INGENIERÃA', 'Facultad para todas las carreras de ingenierÃ­as', 1, '2022-08-10 16:40:55', '2022-08-15 18:56:40'),
(8, 'FACULTAD DE CIENCIAS AGRAGARIAS', 'Facultad para todas las carreras afines a ello', 1, '2022-08-10 16:42:30', '2022-08-15 18:28:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text NOT NULL,
  `lastname` text NOT NULL,
  `department_id` int(30) NOT NULL,
  `curriculum_id` int(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `avatar` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `student_list`
--

INSERT INTO `student_list` (`id`, `firstname`, `middlename`, `lastname`, `department_id`, `curriculum_id`, `email`, `password`, `gender`, `status`, `avatar`, `date_created`, `date_updated`) VALUES
(6, 'Jhoel', '', 'Perez', 7, 9, 'joel@gmail.com', 'c000ccf225950aac2a082a59ac5e57ff', 'Male', 1, 'uploads/student-6.png?v=1660171687', '2022-08-10 17:11:11', '2022-08-10 17:48:07'),
(8, 'raul', '', 'torres', 7, 11, 'raul@gmail.com', 'c2f004a05fffa487f826003604b87de1', 'Male', 1, 'uploads/student-8.png?v=1660608222', '2022-08-15 19:01:50', '2022-08-15 19:03:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Repositorio de Archivos de Tesis/Proyectos'),
(6, 'short_name', 'REPO'),
(11, 'logo', 'uploads/logo-1660167000.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1660167000.png'),
(15, 'content', 'Array'),
(16, 'email', 'tareacompleto@gmail.com'),
(17, 'contact', '927630025'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'Tarea Completo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Tarea', NULL, 'Completo', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'uploads/avatar-1.png?v=1660175469', NULL, 1, 1, '2021-01-20 14:02:37', '2022-08-10 20:07:36'),
(2, 'Joel', NULL, 'Perez', 'joel', 'c000ccf225950aac2a082a59ac5e57ff', 'uploads/avatar-2.png?v=1660167901', NULL, 2, 1, '2021-12-13 14:38:02', '2022-08-10 16:45:01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archive_list`
--
ALTER TABLE `archive_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indices de la tabla `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indices de la tabla `department_list`
--
ALTER TABLE `department_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`) USING HASH,
  ADD KEY `department_id` (`department_id`),
  ADD KEY `curriculum_id` (`curriculum_id`);

--
-- Indices de la tabla `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archive_list`
--
ALTER TABLE `archive_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `curriculum_list`
--
ALTER TABLE `curriculum_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `department_list`
--
ALTER TABLE `department_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archive_list`
--
ALTER TABLE `archive_list`
  ADD CONSTRAINT `archive_list_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `curriculum_list`
--
ALTER TABLE `curriculum_list`
  ADD CONSTRAINT `curriculum_list_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `student_list`
--
ALTER TABLE `student_list`
  ADD CONSTRAINT `student_list_ibfk_1` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_list_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
