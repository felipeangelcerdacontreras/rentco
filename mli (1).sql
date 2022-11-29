

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `modulo` varchar(45) DEFAULT NULL,
  `operacion` varchar(45) DEFAULT NULL,
  `modificacion` text,
  `url_pdf` text,
  `url_word` text,
  `usuario` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bitacora`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `clave` varchar(4) DEFAULT NULL,
  `estatus` int(1) DEFAULT NULL,
  `usuario_creacion` int(11) DEFAULT NULL,
  `usuario_edicion` int(11) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion`
--

CREATE TABLE `documentacion` (
  `id` int(11) NOT NULL,
  `id_estatus` int(11) DEFAULT NULL,
  `id_proceso` int(11) DEFAULT NULL,
  `id_tipo_documento` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `id_puesto` text,
  `clave_calidad` char(11) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `url_word` text,
  `url_pdf` text,
  `comentarios` text,
  `permisos` text,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `usr_creacion` int(11) DEFAULT NULL,
  `usr_modificacion` int(11) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



--
-- Estructura de tabla para la tabla `documentacion_permisos`
--

CREATE TABLE `documentacion_permisos` (
  `id` int(11) NOT NULL,
  `id_documento` varchar(45) DEFAULT NULL,
  `id_puesto` int(11) DEFAULT NULL,
  `ver` text,
  `editar` text,
  `imprimir` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `clave` varchar(4) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `user_id_modificacion` int(11) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `documento`
--



--
-- Estructura de tabla para la tabla `estatus_documento`
--

CREATE TABLE `estatus_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `user_id_modificacion` int(11) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estructura de tabla para la tabla `proceso`
--

CREATE TABLE `proceso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `user_id_modificacion` int(11) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `estatus` varchar(255) DEFAULT NULL,
  `id_departamento` int(1) DEFAULT NULL,
  `usuario_creacion` int(11) DEFAULT NULL,
  `usuario_edicion` int(11) DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `perfiles_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_usuario` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave_texto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puesto` int(11) DEFAULT NULL,
  `usuario_creacion` int(10) UNSIGNED NOT NULL,
  `usuario_edicion` int(10) UNSIGNED NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nvl_usuario` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `perfiles_id`, `nombre_usuario`, `correo`, `usuario`, `clave`, `clave_texto`, `puesto`, `usuario_creacion`, `usuario_edicion`, `fecha_creacion`, `fecha_modificacion`, `nvl_usuario`, `estado`) VALUES
(1, 'documentacion@bitacora@departamentos@puestos@usuarios@estatus_documento@proceso@documento@ver@editar@imprimir@agregar@actualizar@', 'Administrador', '1@123.com', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', '1234', 1, 1, 1, '2022-11-10 18:43:07', '2022-11-10 18:43:07', 1, 1);
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documentacion_permisos`
--
ALTER TABLE `documentacion_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estatus_documento`
--
ALTER TABLE `estatus_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proceso`
--
ALTER TABLE `proceso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `documentacion`
--
ALTER TABLE `documentacion`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `documentacion_permisos`
--
ALTER TABLE `documentacion_permisos`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estatus_documento`
--
ALTER TABLE `estatus_documento`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proceso`
--
ALTER TABLE `proceso`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
