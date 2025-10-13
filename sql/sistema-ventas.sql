-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-10-2025 a las 05:10:10
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema-ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones_productos`
--

CREATE TABLE `asignaciones_productos` (
  `id` int NOT NULL,
  `id_producto` int NOT NULL,
  `id_vendedor` int NOT NULL,
  `cantidad_asignada` decimal(10,3) NOT NULL,
  `fecha_asignacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `telefono`, `estado`) VALUES
(1, 'CLIENTE LIBRE', '', 1),
(2, 'Camilo Sanchez', '2481002233', 0),
(3, 'Angela Vazquez', '2481014042', 1),
(4, 'Lizeth Ortiz', '5656747772', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_proveedor` int NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `id_usuario`, `id_proveedor`, `fecha`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-10-11', 19.00, '2025-10-11 06:11:21', '2025-10-11 06:11:21'),
(2, 1, 4, '2025-10-11', 126.20, '2025-10-11 06:12:28', '2025-10-11 06:12:28'),
(3, 1, 6, '2025-10-11', 206.60, '2025-10-11 06:15:05', '2025-10-11 06:15:05'),
(4, 1, 3, '2025-10-11', 150.00, '2025-10-11 08:48:32', '2025-10-11 08:48:32'),
(5, 1, 6, '2025-10-12', 86.40, '2025-10-12 21:55:58', '2025-10-12 21:55:58'),
(6, 1, 5, '2025-10-12', 47.00, '2025-10-13 01:52:37', '2025-10-13 01:52:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` int NOT NULL,
  `id_compra` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `descuento` decimal(5,2) DEFAULT '0.00',
  `precio_final` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`, `descuento`, `precio_final`, `total`, `created_at`) VALUES
(1, 1, 1, 1.00, 19.00, 0.00, 19.00, 19.00, '2025-10-11 06:11:21'),
(2, 2, 6, 20.00, 6.64, 5.00, 6.31, 126.20, '2025-10-11 06:12:28'),
(3, 3, 10, 20.00, 11.48, 10.00, 10.33, 206.60, '2025-10-11 06:15:05'),
(4, 4, 4, 10.00, 15.00, 0.00, 15.00, 150.00, '2025-10-11 08:48:32'),
(5, 5, 9, 12.00, 7.20, 0.00, 7.20, 86.40, '2025-10-12 21:55:58'),
(6, 6, 13, 1.00, 17.00, 0.00, 17.00, 17.00, '2025-10-13 01:52:37'),
(7, 6, 12, 3.00, 10.00, 0.00, 10.00, 30.00, '2025-10-13 01:52:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int NOT NULL,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` decimal(10,3) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `total`) VALUES
(2, 2, 9, 2.000, 10.00, 20.00),
(3, 2, 7, 2.000, 10.00, 20.00),
(4, 2, 1, 1.000, 22.00, 22.00),
(5, 2, 5, 2.000, 16.00, 32.00),
(6, 2, 8, 1.000, 12.00, 12.00),
(7, 3, 9, 3.000, 10.00, 30.00),
(8, 3, 10, 1.000, 16.00, 16.00),
(9, 4, 9, 2.000, 10.00, 20.00),
(10, 4, 4, 2.000, 17.00, 34.00),
(11, 5, 9, 1.000, 10.00, 10.00),
(12, 6, 10, 2.000, 16.00, 32.00),
(13, 6, 7, 1.000, 10.00, 10.00),
(14, 6, 6, 3.000, 8.00, 24.00),
(15, 7, 1, 24.000, 22.00, 528.00),
(16, 7, 9, 3.000, 10.00, 30.00),
(17, 8, 9, 1.000, 10.00, 10.00),
(18, 8, 1, 2.000, 22.00, 44.00),
(19, 9, 10, 1.000, 16.00, 16.00),
(20, 9, 4, 2.000, 17.00, 34.00),
(21, 9, 5, 1.000, 16.00, 16.00),
(22, 9, 7, 1.000, 10.00, 10.00),
(23, 10, 9, 9.000, 10.00, 90.00),
(24, 11, 9, 4.000, 10.00, 40.00),
(25, 11, 4, 1.000, 17.00, 17.00),
(26, 12, 9, 1.000, 10.00, 10.00),
(27, 13, 10, 2.000, 16.00, 32.00),
(28, 13, 8, 1.000, 12.00, 12.00),
(29, 13, 4, 1.000, 17.00, 17.00),
(30, 13, 7, 1.000, 10.00, 10.00),
(31, 13, 2, 1.000, 20.00, 20.00),
(32, 13, 6, 1.000, 8.00, 8.00),
(33, 14, 15, 2.000, 16.00, 32.00),
(34, 14, 11, 1.000, 6.55, 6.55),
(35, 14, 12, 3.000, 12.00, 36.00),
(36, 14, 14, 3.000, 8.00, 24.00),
(37, 14, 13, 2.000, 14.89, 29.78),
(38, 14, 10, 3.000, 16.00, 48.00),
(39, 14, 8, 1.000, 12.00, 12.00),
(40, 14, 3, 1.000, 20.00, 20.00),
(41, 14, 4, 1.000, 17.00, 17.00),
(42, 15, 11, 1.000, 6.55, 6.55),
(43, 15, 4, 1.000, 17.00, 17.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `codigo_barras` varchar(50) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `stock_total` decimal(10,3) NOT NULL,
  `id_proveedor` int DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `codigo_barras`, `precio_venta`, `precio_compra`, `stock_total`, `id_proveedor`, `estado`) VALUES
(1, 'Coca cola 600 ml', 'refresco sabor cola con contenido de 600ml', '155652', 22.00, 19.00, 23.000, 1, 1),
(2, 'Fanta naranja 600 ml', 'Refresco sabor naranja de 600 militros en envase no retornable', '11122334', 20.00, 16.00, 23.000, 1, 1),
(3, 'Fanta naranja 2 L', 'Refresco sabor naranja de 2 Litros en envase no retornable', '11122334', 20.00, 16.00, 23.000, 1, 1),
(4, 'Doritos Nacho 58g', 'Doritos sabor nacho con contenido de 58 gramos edit', '7501011123588', 17.00, 15.00, 8.000, 3, 1),
(5, 'Gansito 50 g', 'Pastelito gansito de 50 g', '7501000153107', 16.00, 13.50, 9.000, 4, 1),
(6, 'Mini Gansito 24g', 'Pastelito mini gansito de 24 gramos', '7501030419037', 8.00, 6.64, 43.000, 4, 1),
(7, 'Papirringas chile y limon', 'Papirringas a la francesa chile y limon', '604722013863', 10.00, 8.50, 3.000, 5, 1),
(8, 'Ke Chidos Puff Extremo 40g', 'Ke Chidos Puff Extremo 40g bolsa morada botana tipo chetos', '604722008001', 12.00, 10.00, 1.000, 5, 1),
(9, 'Boing Guayaba 250ml (Boing chico)', 'Jugo boing sabor guayaba tamaño chico de 250ml', '75001773', 10.00, 7.20, 12.000, 6, 1),
(10, 'Boing Mango 500ml (Boing mediano)', 'Jugo boing sabor mango tamaño mediano de 500ml', '75003104', 16.00, 11.48, 17.000, 6, 1),
(11, 'Del valle fizz limonada lata 235ml', 'Del valle fizz lata chica de 235 ml sabor limonada', '7501055382590', 6.55, 10.00, 10.000, 1, 1),
(12, 'Ke Chidos Queso Chile 48g', 'Ke Chidos sabor Queso Chile 48g bolsa naranja botana tipo chetos', '60472201232', 12.00, 10.00, 6.000, 5, 1),
(13, 'Sabritas Originales 42g', 'Papas sabritas originales bolsa amarilla de 42 gramos', '7500478043927', 14.89, 17.00, 4.000, 3, 1),
(14, 'Rocko 44g ', 'Galleta con chocolate rocko de 44gramos color azul', '7501000153763', 8.00, 6.22, 9.000, 4, 1),
(15, 'Barritas fresa 75g', 'Galleta Barritas sabor fresa empaque rojo de 75 gramos', '7500810014721', 16.00, 13.44, 4.000, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `contacto` text,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `contacto`, `telefono`, `correo`, `estado`) VALUES
(1, 'Coca-Cola', '+528001230000', '2481851234', 'coca-cola@femsa.com.mx', 1),
(2, 'Bimbo', '', '', 'contacto@bimbo.com', 2),
(3, 'Sabritas', '', '', '', 1),
(4, 'Marinela', '+52 1 55 3808 1690', '222 285 2266', '', 1),
(5, 'Botanas Leo', '52 81 81509100', '', '', 1),
(6, 'Jorge ', '', '2481391718', 'jasp509@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `password` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `rol` int NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `telefono`, `password`, `rol`, `estado`) VALUES
(1, 'Admin', 'admin@correo.com', '248 100 22 33', '12345', 1, 1),
(2, 'Prueba', 'pruebaxdd@trucker.com', '(248) 139 1718', 'xdxdxdxdddd', 2, 0),
(3, 'Ruth Sanchez', 'ruth@gmail.com', '2481014455', '12345', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_vendedor` int NOT NULL,
  `fecha` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `id_vendedor`, `fecha`, `total`) VALUES
(1, 1, 1, '2025-10-03', 10.00),
(2, 1, 1, '2025-10-03', 106.00),
(3, 1, 1, '2025-10-04', 46.00),
(4, 1, 1, '2025-10-04', 54.00),
(5, 1, 1, '2025-10-04', 10.00),
(6, 1, 1, '2025-10-04', 66.00),
(7, 1, 1, '2025-10-07', 558.00),
(8, 1, 1, '2025-10-07', 54.00),
(9, 4, 1, '2025-10-07', 76.00),
(10, 3, 1, '2025-10-08', 90.00),
(11, 1, 1, '2025-10-10', 57.00),
(12, 1, 1, '2025-10-11', 10.00),
(13, 1, 1, '2025-10-12', 99.00),
(14, 1, 1, '2025-10-12', 225.33),
(15, 4, 1, '2025-10-12', 23.55);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones_productos`
--
ALTER TABLE `asignaciones_productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones_productos`
--
ALTER TABLE `asignaciones_productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
