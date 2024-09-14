-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-09-2024 a las 19:18:30
-- Versión del servidor: 5.7.33
-- Versión de PHP: 8.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `telemedicina`
--
CREATE DATABASE IF NOT EXISTS `telemedicina` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `telemedicina`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adjuntos_correos`
--

CREATE TABLE `adjuntos_correos` (
  `id` int(11) NOT NULL,
  `id_correo` int(11) NOT NULL,
  `ruta_archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `adjuntos_correos`
--

TRUNCATE TABLE `adjuntos_correos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_subidos`
--

CREATE TABLE `archivos_subidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `estado_validacion` enum('valido','invalido') DEFAULT 'valido',
  `descripcion` text,
  `subido_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `archivos_subidos`
--

TRUNCATE TABLE `archivos_subidos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chats`
--

CREATE TABLE `chats` (
  `id` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `estado` enum('activo','completado','cancelado') DEFAULT 'activo',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `chats`
--

TRUNCATE TABLE `chats`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones_usuarios`
--

CREATE TABLE `configuraciones_usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `notificaciones` tinyint(1) DEFAULT '1',
  `tema_interfaz` varchar(50) DEFAULT 'claro',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `configuraciones_usuarios`
--

TRUNCATE TABLE `configuraciones_usuarios`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos_electronicos`
--

CREATE TABLE `correos_electronicos` (
  `id` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `cuerpo` text NOT NULL,
  `enviado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `correos_electronicos`
--

TRUNCATE TABLE `correos_electronicos`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_chat`
--

CREATE TABLE `mensajes_chat` (
  `id` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `enviado_a` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `mensajes_chat`
--

TRUNCATE TABLE `mensajes_chat`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `documento` int(11) NOT NULL,
  `tipo_documento` enum('TI','CC','CE','OTRO') NOT NULL DEFAULT 'OTRO',
  `contrasena` varchar(255) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `rol` enum('Paciente','Medico') NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `Ciudad` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('masculino','femenino','otro') DEFAULT 'otro',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `documento`, `tipo_documento`, `contrasena`, `correo_electronico`, `rol`, `telefono`, `direccion`, `Ciudad`, `fecha_nacimiento`, `genero`, `fecha_creacion`, `fecha_actualizacion`, `estado`) VALUES
(1, '12', 12, 'TI', '$2y$13$RsoGwZP8D7bbDTrNOAEI1.hKdSKgH54msheKECI4MV7aexicuCCDe', '12', 'Paciente', NULL, NULL, NULL, NULL, 'otro', '2024-09-10 18:37:33', '2024-09-10 18:38:05', 1),
(2, 'a', 3, 'CC', '$2y$13$PtbS7QWjz3WchOlsGD5EtOCjpdZGrl8sVC0T5FB5OB7Z4sQrUzUWi', 's', 'Medico', NULL, NULL, NULL, NULL, 'otro', '2024-09-10 18:52:06', '2024-09-10 18:52:27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `videollamadas`
--

CREATE TABLE `videollamadas` (
  `id` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `url_reunion` varchar(255) DEFAULT NULL,
  `fecha_programada` timestamp NOT NULL,
  `hora_inicio` timestamp NULL DEFAULT NULL,
  `hora_fin` timestamp NULL DEFAULT NULL,
  `estado` enum('programada','completada','cancelada') DEFAULT 'programada',
  `notas` text,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Truncar tablas antes de insertar `videollamadas`
--

TRUNCATE TABLE `videollamadas`;
--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adjuntos_correos`
--
ALTER TABLE `adjuntos_correos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_correo` (`id_correo`);

--
-- Indices de la tabla `archivos_subidos`
--
ALTER TABLE `archivos_subidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Indices de la tabla `configuraciones_usuarios`
--
ALTER TABLE `configuraciones_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `correos_electronicos`
--
ALTER TABLE `correos_electronicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Indices de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_chat` (`id_chat`),
  ADD KEY `id_remitente` (`id_remitente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD UNIQUE KEY `documento_UNIQUE` (`documento`);

--
-- Indices de la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `adjuntos_correos`
--
ALTER TABLE `adjuntos_correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivos_subidos`
--
ALTER TABLE `archivos_subidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `chats`
--
ALTER TABLE `chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuraciones_usuarios`
--
ALTER TABLE `configuraciones_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `correos_electronicos`
--
ALTER TABLE `correos_electronicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adjuntos_correos`
--
ALTER TABLE `adjuntos_correos`
  ADD CONSTRAINT `adjuntos_correos_ibfk_1` FOREIGN KEY (`id_correo`) REFERENCES `correos_electronicos` (`id`);

--
-- Filtros para la tabla `archivos_subidos`
--
ALTER TABLE `archivos_subidos`
  ADD CONSTRAINT `archivos_subidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `configuraciones_usuarios`
--
ALTER TABLE `configuraciones_usuarios`
  ADD CONSTRAINT `configuraciones_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `correos_electronicos`
--
ALTER TABLE `correos_electronicos`
  ADD CONSTRAINT `correos_electronicos_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `correos_electronicos_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  ADD CONSTRAINT `mensajes_chat_ibfk_1` FOREIGN KEY (`id_chat`) REFERENCES `chats` (`id`),
  ADD CONSTRAINT `mensajes_chat_ibfk_2` FOREIGN KEY (`id_remitente`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `videollamadas`
--
ALTER TABLE `videollamadas`
  ADD CONSTRAINT `videollamadas_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `videollamadas_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
