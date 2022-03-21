-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2022 a las 18:32:42
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_project`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bib_personal`
--

CREATE TABLE `bib_personal` (
  `idpersona` int(11) NOT NULL,
  `per_dni` int(11) NOT NULL,
  `per_nombre` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `per_celular` int(11) NOT NULL,
  `per_direcc` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `per_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `bib_personal`
--

INSERT INTO `bib_personal` (`idpersona`, `per_dni`, `per_nombre`, `per_celular`, `per_direcc`, `per_fecha`) VALUES
(1, 76144152, 'leenh', 987654321, 'direccion', '2022-03-19 17:52:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_menus`
--

CREATE TABLE `sis_menus` (
  `idmenu` int(11) NOT NULL,
  `men_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `men_icono` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `men_url_si` tinyint(1) NOT NULL DEFAULT 0,
  `men_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `men_controlador` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `men_orden` int(11) NOT NULL,
  `men_visible` tinyint(1) NOT NULL,
  `men_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_menus`
--

INSERT INTO `sis_menus` (`idmenu`, `men_nombre`, `men_icono`, `men_url_si`, `men_url`, `men_controlador`, `men_orden`, `men_visible`, `men_fecha`) VALUES
(1, 'Módulo Usuarios', 'fa fa-users', 0, '#', NULL, 2, 1, '2022-03-20 00:25:46'),
(2, 'Módulo leenh', 'fa fa-circle-minus', 0, '#', NULL, 3, 1, '2022-03-20 01:30:56'),
(3, 'Dashboard', 'fas fa-tachometer-alt', 0, '#', NULL, 1, 1, '2022-03-20 11:23:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_permisos`
--

CREATE TABLE `sis_permisos` (
  `idpermisos` int(11) NOT NULL,
  `idrol` int(11) NOT NULL,
  `idsubmenu` int(11) NOT NULL,
  `perm_r` int(11) DEFAULT NULL,
  `perm_w` int(11) DEFAULT NULL,
  `perm_u` int(11) DEFAULT NULL,
  `perm_d` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_permisos`
--

INSERT INTO `sis_permisos` (`idpermisos`, `idrol`, `idsubmenu`, `perm_r`, `perm_w`, `perm_u`, `perm_d`) VALUES
(1, 1, 2, 1, 1, 1, 1),
(2, 1, 3, 1, 1, 1, 1),
(3, 1, 1, 1, 1, 1, 1),
(4, 1, 5, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_rol`
--

CREATE TABLE `sis_rol` (
  `idrol` int(11) NOT NULL,
  `rol_nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rol_cod` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rol_descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rol_estado` tinyint(1) NOT NULL DEFAULT 1,
  `rol_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_rol`
--

INSERT INTO `sis_rol` (`idrol`, `rol_nombre`, `rol_cod`, `rol_descripcion`, `rol_estado`, `rol_fecha`) VALUES
(1, 'root', '/', NULL, 1, '2022-03-20 00:34:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_server_email`
--

CREATE TABLE `sis_server_email` (
  `idserveremail` int(11) NOT NULL,
  `em_host` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `em_usermail` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `em_pass` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `em_port` int(11) NOT NULL,
  `em_estado` tinyint(1) NOT NULL DEFAULT 1,
  `em_default` tinyint(1) DEFAULT NULL,
  `em_fupdate` datetime NOT NULL DEFAULT current_timestamp(),
  `em_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_server_email`
--

INSERT INTO `sis_server_email` (`idserveremail`, `em_host`, `em_usermail`, `em_pass`, `em_port`, `em_estado`, `em_default`, `em_fupdate`, `em_fecha`) VALUES
(1, 'mail.leenhcraft.com', 'no-reply@leenhcraft.com', 'dC).Z)iqs96=', 465, 1, 0, '2022-03-19 23:12:56', '2022-03-19 23:12:56'),
(2, 'smtp.gmail.com', '2018100486facke@gmail.com', 'DJ-leenh-#1', 465, 1, 1, '2022-03-19 23:25:14', '2022-03-19 23:25:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_submenus`
--

CREATE TABLE `sis_submenus` (
  `idsubmenu` int(11) NOT NULL,
  `idmenu` int(11) NOT NULL,
  `sub_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sub_url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sub_controlador` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_icono` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_orden` int(11) NOT NULL,
  `sub_visible` tinyint(1) NOT NULL,
  `sub_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_submenus`
--

INSERT INTO `sis_submenus` (`idsubmenu`, `idmenu`, `sub_nombre`, `sub_url`, `sub_controlador`, `sub_icono`, `sub_orden`, `sub_visible`, `sub_fecha`) VALUES
(1, 1, 'Usuarios', 'usuarios', NULL, 'fa fa-user', 1, 1, '2022-03-20 00:28:14'),
(2, 1, 'Roles', 'roles', NULL, 'fa fa-user', 2, 1, '2022-03-20 01:20:38'),
(3, 2, 'sub menu 1', 'sub1', 'sub1', 'fa fa-user', 1, 1, '2022-03-20 01:32:06'),
(4, 2, 'sub menu 2', 'sub2', 'sub2', 'fa fa-user', 2, 1, '2022-03-20 01:32:37'),
(5, 3, 'Dashboard', 'dashboard', NULL, 'fas fa-tachometer-alt', 1, 1, '2022-03-20 13:14:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_usuarios`
--

CREATE TABLE `sis_usuarios` (
  `usu_id` int(11) NOT NULL,
  `idrol` int(11) DEFAULT NULL,
  `idpersona` int(11) NOT NULL,
  `usu_usuario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usu_pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `usu_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usu_activo` tinyint(1) NOT NULL,
  `usu_estado` tinyint(1) NOT NULL,
  `usu_primera` tinyint(1) NOT NULL,
  `usu_twoauth` tinyint(1) NOT NULL,
  `usu_code_twoauth` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usu_fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sis_usuarios`
--

INSERT INTO `sis_usuarios` (`usu_id`, `idrol`, `idpersona`, `usu_usuario`, `usu_pass`, `usu_token`, `usu_activo`, `usu_estado`, `usu_primera`, `usu_twoauth`, `usu_code_twoauth`, `usu_fecha`) VALUES
(4, 1, 1, 'hackingleenh@gmail.com', '$2y$10$Ti5KqllBAXjk.IZccayGnuZjpzfuGIk5yih06KOdRXcSyOBZ5rpk2', '', 1, 1, 0, 0, NULL, '2022-03-19 17:56:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sis_visitas`
--

CREATE TABLE `sis_visitas` (
  `idvisita` int(11) NOT NULL,
  `vis_ip` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `vis_agente` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vis_url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vis_fechahora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bib_personal`
--
ALTER TABLE `bib_personal`
  ADD PRIMARY KEY (`idpersona`);

--
-- Indices de la tabla `sis_menus`
--
ALTER TABLE `sis_menus`
  ADD PRIMARY KEY (`idmenu`);

--
-- Indices de la tabla `sis_permisos`
--
ALTER TABLE `sis_permisos`
  ADD PRIMARY KEY (`idpermisos`),
  ADD KEY `sis_submenus_sis_permisos_fk` (`idsubmenu`),
  ADD KEY `bib_rol_bib_permisos_fk` (`idrol`);

--
-- Indices de la tabla `sis_rol`
--
ALTER TABLE `sis_rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `sis_server_email`
--
ALTER TABLE `sis_server_email`
  ADD PRIMARY KEY (`idserveremail`);

--
-- Indices de la tabla `sis_submenus`
--
ALTER TABLE `sis_submenus`
  ADD PRIMARY KEY (`idsubmenu`),
  ADD KEY `sis_menus_sis_submenus_fk` (`idmenu`);

--
-- Indices de la tabla `sis_usuarios`
--
ALTER TABLE `sis_usuarios`
  ADD PRIMARY KEY (`usu_id`),
  ADD KEY `bib_personal_sis_usuarios_fk` (`idpersona`),
  ADD KEY `bib_rol_bib_usuarios_fk` (`idrol`);

--
-- Indices de la tabla `sis_visitas`
--
ALTER TABLE `sis_visitas`
  ADD PRIMARY KEY (`idvisita`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bib_personal`
--
ALTER TABLE `bib_personal`
  MODIFY `idpersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sis_menus`
--
ALTER TABLE `sis_menus`
  MODIFY `idmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sis_permisos`
--
ALTER TABLE `sis_permisos`
  MODIFY `idpermisos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sis_rol`
--
ALTER TABLE `sis_rol`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sis_server_email`
--
ALTER TABLE `sis_server_email`
  MODIFY `idserveremail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sis_submenus`
--
ALTER TABLE `sis_submenus`
  MODIFY `idsubmenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sis_usuarios`
--
ALTER TABLE `sis_usuarios`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sis_visitas`
--
ALTER TABLE `sis_visitas`
  MODIFY `idvisita` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `sis_permisos`
--
ALTER TABLE `sis_permisos`
  ADD CONSTRAINT `bib_rol_bib_permisos_fk` FOREIGN KEY (`idrol`) REFERENCES `sis_rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sis_submenus_sis_permisos_fk` FOREIGN KEY (`idsubmenu`) REFERENCES `sis_submenus` (`idsubmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sis_submenus`
--
ALTER TABLE `sis_submenus`
  ADD CONSTRAINT `sis_menus_sis_submenus_fk` FOREIGN KEY (`idmenu`) REFERENCES `sis_menus` (`idmenu`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sis_usuarios`
--
ALTER TABLE `sis_usuarios`
  ADD CONSTRAINT `bib_personal_sis_usuarios_fk` FOREIGN KEY (`idpersona`) REFERENCES `bib_personal` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `bib_rol_bib_usuarios_fk` FOREIGN KEY (`idrol`) REFERENCES `sis_rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
