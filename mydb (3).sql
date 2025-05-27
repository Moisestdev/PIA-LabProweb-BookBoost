-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-05-2025 a las 21:14:05
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
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id_autores` int(11) NOT NULL,
  `nombre_autor` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id_autores`, `nombre_autor`) VALUES
(2, 'AAA'),
(1, 'Prueba'),
(4, 'Test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(11) NOT NULL,
  `nombre_genero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `nombre_genero`) VALUES
(1, 'Acción'),
(5, 'Hola'),
(4, 'Prueba'),
(3, 'Test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL,
  `nombre_libro` varchar(100) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `portada_url` varchar(255) NOT NULL,
  `id_autores` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id_libro`, `nombre_libro`, `id_autor`, `id_genero`, `id_usuario`, `portada_url`, `id_autores`) VALUES
(1, 'Prueba', 1, 1, 5, 'https://r-charts.com/es/miscelanea/procesamiento-imagenes-magick_files/figure-html/color-fondo-imagen-r.png', 1),
(8, 'Hola', 4, 1, 6, 'https://m.media-amazon.com/images/M/MV5BNWE5Y2JmZjUtZDlhZS00Njg3LWJlODUtMjhmMGFjYzZmNmU0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', NULL),
(9, 'Test', 4, 1, 6, 'https://m.media-amazon.com/images/M/MV5BNWE5Y2JmZjUtZDlhZS00Njg3LWJlODUtMjhmMGFjYzZmNmU0XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ocupacion`
--

CREATE TABLE `ocupacion` (
  `id_ocupacion` int(11) NOT NULL,
  `nombre_ocupacion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ocupacion`
--

INSERT INTO `ocupacion` (`id_ocupacion`, `nombre_ocupacion`) VALUES
(1, 'Estudiante'),
(3, 'Otro'),
(2, 'Profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseña`
--

CREATE TABLE `reseña` (
  `id_reseña` int(11) NOT NULL,
  `fecha_reseña` date NOT NULL,
  `contenido_reseña` text NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `reseña`
--

INSERT INTO `reseña` (`id_reseña`, `fecha_reseña`, `contenido_reseña`, `id_libro`, `id_usuario`) VALUES
(1, '2022-05-25', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 5),
(7, '2025-05-27', 'aaa', 9, 6),
(8, '2025-05-27', 'Wow', 8, 5),
(9, '2025-05-27', 'Holamasdoimasdasdoaksdpoqkwodqkwpodkqwopdkqopwdkopqwdkpoqwkdopqwkdopqwkdopqkwdopkqwpodkqwpodkqopwkd', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL,
  `nombre_rol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `nombre_rol`) VALUES
(1, 'admin'),
(3, 'editor'),
(2, 'lector');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `edad_usuario` int(11) NOT NULL,
  `contraseña_usuario` varchar(16) NOT NULL,
  `ocupacion_usuario` int(11) NOT NULL,
  `rol_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `edad_usuario`, `contraseña_usuario`, `ocupacion_usuario`, `rol_usuario`) VALUES
(5, 'test', 'asd@asd.com', 3, 'test', 1, 2),
(6, 'Reyna 1', 'ReynaValo@gmail.com', 20, 'Reyna:3', 1, 1),
(7, 'Usuario 2', 'usuario2@gmai.com', 20, 'asdasd', 1, 2),
(8, 'Usuario 3', 'usuario3@gmai.com', 20, 'asdasd', 1, 2),
(9, 'AAA', 'usuario@gmail.com', 20, 'asdasd', 2, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autores`),
  ADD UNIQUE KEY `nombre_autor_UNIQUE` (`nombre_autor`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`),
  ADD UNIQUE KEY `nombre_genero_UNIQUE` (`nombre_genero`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `fk_libros_autores_idx` (`id_autor`),
  ADD KEY `fk_libros_generos1_idx` (`id_genero`),
  ADD KEY `fk_libros_usuario1_idx` (`id_usuario`),
  ADD KEY `fk_libro_autor` (`id_autores`);

--
-- Indices de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  ADD PRIMARY KEY (`id_ocupacion`),
  ADD UNIQUE KEY `nombre_ocupacion_UNIQUE` (`nombre_ocupacion`);

--
-- Indices de la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `fk_reseña_libro_idx` (`id_libro`),
  ADD KEY `fk_reseña_usuario_idx` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`),
  ADD UNIQUE KEY `nombre_rol_UNIQUE` (`nombre_rol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario_UNIQUE` (`correo_usuario`),
  ADD KEY `fk_usuario_ocupacion1_idx` (`ocupacion_usuario`),
  ADD KEY `fk_usuario_roles1_idx` (`rol_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ocupacion`
--
ALTER TABLE `ocupacion`
  MODIFY `id_ocupacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reseña`
--
ALTER TABLE `reseña`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `fk_libro_autor` FOREIGN KEY (`id_autores`) REFERENCES `autor` (`id_autores`),
  ADD CONSTRAINT `fk_libros_autores` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autores`),
  ADD CONSTRAINT `fk_libros_generos1` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id_genero`),
  ADD CONSTRAINT `fk_libros_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `reseña`
--
ALTER TABLE `reseña`
  ADD CONSTRAINT `fk_reseña_libro` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  ADD CONSTRAINT `fk_reseña_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_ocupacion1` FOREIGN KEY (`ocupacion_usuario`) REFERENCES `ocupacion` (`id_ocupacion`),
  ADD CONSTRAINT `fk_usuario_roles1` FOREIGN KEY (`rol_usuario`) REFERENCES `roles` (`id_roles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
