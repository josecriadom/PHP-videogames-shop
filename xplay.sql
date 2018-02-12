-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2018 a las 21:11:53
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `xplay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Texto` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Fecha` varchar(25) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprados`
--

CREATE TABLE `comprados` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comprados`
--

INSERT INTO `comprados` (`Titulo`, `Email`) VALUES
('Destiny 2', 'jose@usal.es'),
('Grand Theft Auto V', 'jose@usal.es'),
('Grand Theft Auto V', 'raul@usal.es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrasenasroot`
--

CREATE TABLE `contrasenasroot` (
  `Valor` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `contrasenasroot`
--

INSERT INTO `contrasenasroot` (`Valor`) VALUES
('123456789'),
('joseyraul'),
('raulyjose'),
('soyadmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Categoria` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`Titulo`, `Categoria`) VALUES
('Cuphead', 'Acción'),
('Cuphead', 'Rol'),
('Destiny 2', 'Acción'),
('Destiny 2', 'Aventura'),
('Fallout 4', 'Rol'),
('Grand Theft Auto V', 'Acción'),
('Grand Theft Auto V', 'Aventura'),
('Need For Speed Payback', 'Carreras'),
('Need For Speed Payback', 'Simuladores'),
('PLAYERUNKNOWNS BATTLEGROUNDS', 'Acción'),
('PLAYERUNKNOWNS BATTLEGROUNDS', 'Aventura'),
('PLAYERUNKNOWNS BATTLEGROUNDS', 'Multijugador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Posicion` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `inicio`
--

INSERT INTO `inicio` (`Titulo`, `Posicion`) VALUES
('Destiny 2', 'top ventas'),
('Grand Theft Auto V', 'destacados'),
('Destiny 2', 'destacados'),
('Cuphead', 'top ventas'),
('Fallout 4', 'ofertas'),
('Need For Speed Payback', 'destacados'),
('PLAYERUNKNOWNS BATTLEGROUNDS', 'top ventas'),
('PLAYERUNKNOWNS BATTLEGROUNDS', 'ofertas'),
('Grand Theft Auto V', 'ofertas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juego`
--

CREATE TABLE `juego` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Precio` int(3) NOT NULL,
  `Descripcion` varchar(400) COLLATE utf8_spanish_ci NOT NULL,
  `Desarrollador` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Editor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Lanzamiento` date NOT NULL,
  `Pegi` int(4) NOT NULL,
  `DescripcionPegi` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `juego`
--

INSERT INTO `juego` (`Titulo`, `Precio`, `Descripcion`, `Desarrollador`, `Editor`, `Lanzamiento`, `Pegi`, `DescripcionPegi`) VALUES
('Cuphead', 15, 'Cuphead es un juego de acción clásico estilo \"dispara y corre\" que se centra en combates contra el jefe. Inspirado en los dibujos animados de los años 30, los aspectos visual y sonoro están diseñados con esmero empleando las mismas técnicas de la época, es decir, animación tradicional a mano, fondos de acuarela y grabaciones originales de jazz. <br><br>Juega como Cuphead o Mugman (en modo de un ju', 'StudioMDHR Entertain', 'StudioMDHR Entertain', '2017-09-29', 3, ' '),
('Destiny 2', 35, 'Destiny 2 es una secuela directa del videojuego de acción en primera persona de Bungie distribuido por Activision.\r\nLa historia de este episodio amplía el universo de fantasía de la entrega original del 2014 al situar su propuesta shooter tras el ataque a la última ciudad de la Tierra a manos de Ghaul, el comandante de la Legión Roja de los cabal. La Vanguardia, formada por el cazador exo Cayde-6,', 'Bungie', 'Activision', '2017-09-06', 16, 'Violencia, Lenguaje ofensivo, Sexo'),
('Fallout 4', 20, 'Bethesda Game Studios, el galardonado creador de Fallout 3 y The Elder Scrolls V: Skyrim, os da la bienvenida al mundo de Fallout 4, su juego más ambicioso hasta la fecha y la siguiente generación de mundos abiertos. <br>Eres el único superviviente del Refugio 111 en un mundo destruido por la guerra nuclear. Cada segundo es una lucha por la supervivencia, y en tus manos estarán todas las decisione', 'Bethesda Game Studio', 'Bethesda Softworks', '2015-11-10', 18, 'Violencia<br>Lenguaje ofensivo<br>'),
('Grand Theft Auto V', 30, 'Cuando un joven estafador callejero, un ladrón de bancos retirado y un psicópata aterrador se ven involucrados con lo peor y más desquiciado del mundo criminal, del gobierno de los EE. UU. y de la industria del espectáculo, tendrán que llevar a cabo una serie de peligrosos golpes para sobrevivir en una ciudad implacable en la que no pueden confiar en nadie. Y mucho menos los unos en los otros.\r\n\r\n', 'Rockstar North', 'Rockstar Games', '2015-04-14', 18, 'Violencia, Juego Online, Lenguaje ofensivo'),
('Need For Speed Payback', 40, 'La serie Need for Speed vuelve a dominar las carreteras de la velocidad más arcade en 2017 con Need For Speed Payback, un juego desarrollado por Ghost Games, responsables del producto lanzado en 2015 bajo el escueto nombre de Need for Speed. En esta ocasión, el videojuego recupera algunas de las mejores historias de episodios tan emblemáticos de la serie como Most Wanted, y nos lleva a plantarle ', 'Ghost Games', 'EA', '2017-10-18', 12, ' '),
('PLAYERUNKNOWNS BATTLEGROUNDS', 20, 'PLAYERUNKNOWN’S BATTLEGROUNDS es un shooter basado en el modo Battle Royale que está siendo desarrollado a través de la retroalimentación con la comunidad.<br>Comenzando de la nada, los usuarios tienen que luchar uno contra el otro para localizar armas y suministros para ser el único sobreviviente.<br>Este juego realista de alta tensión se establece en una isla masiva de 8x8 km con un nivel de det', 'Bluehole Inc.', 'Bluehole Inc.', '2017-03-23', 18, 'Violencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitosmax`
--

CREATE TABLE `requisitosmax` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `SO` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Procesador` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `RAM` int(5) DEFAULT NULL,
  `Grafica` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Almacenamiento` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `requisitosmax`
--

INSERT INTO `requisitosmax` (`Titulo`, `SO`, `Procesador`, `RAM`, `Grafica`, `Almacenamiento`) VALUES
('Cuphead', ' ', ' ', 0, ' ', 0),
('Destiny 2', 'Windows 8.1, Windows', 'Intel Core i7- 3770 ', 8, 'NVIDIA GeForce GTX 7', 0),
('Fallout 4', 'Windows 7/8/10 (64-b', 'Intel Core i7 4790 3', 8, 'NVIDIA GTX 780 3GB/A', 30),
('Grand Theft Auto V', 'Windows 8.1 de 64 bits', 'Intel Core i5 3470 a', 8, 'NVIDIA GTX 660 2 GB', 72),
('Need For Speed Payback', 'Windows 8.1, Windows', 'Intel Core i5-2400s ', 6, 'NVIDIA GeForce GTX 6', 72),
('PLAYERUNKNOWNS BATTLEGROUNDS', ' ', ' ', 0, ' ', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `requisitosmin`
--

CREATE TABLE `requisitosmin` (
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `SO` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Procesador` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `RAM` int(5) DEFAULT NULL,
  `Grafica` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Almacenamiento` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `requisitosmin`
--

INSERT INTO `requisitosmin` (`Titulo`, `SO`, `Procesador`, `RAM`, `Grafica`, `Almacenamiento`) VALUES
('Cuphead', 'Windows 7.', 'Intel Core2 Duo E840', 2, 'Geforce 9600 GT or A', 20),
('Destiny 2', 'Windows 8.1, Windows', 'Intel Core i5-2400s ', 6, 'NVIDIA GeForce GTX 6', 72),
('Fallout 4', 'Windows 7/8/10 (64-b', 'Intel Core i5-2300 2', 8, 'NVIDIA GTX 550 Ti 2G', 30),
('Grand Theft Auto V', 'Windows 8.1 de 64 bits', 'Intel Core 2 Quad CP', 4, 'NVIDIA 9800 GT 1 GB', 72),
('Need For Speed Payback', 'Windows 8.1, Windows', 'Intel Core i7- 3770 ', 8, 'NVIDIA GeForce GTX 7', 0),
('PLAYERUNKNOWNS BATTLEGROUNDS', '64-bit Windows 7, Wi', 'Intel Core i3-4340 /', 6, 'NVIDIA GeForce GTX 6', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Apellidos` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Pais` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Nacimiento` date NOT NULL,
  `Email` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Contraseña` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `root` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Nombre`, `Apellidos`, `Pais`, `Nacimiento`, `Email`, `Contraseña`, `root`) VALUES
('Jose', 'Criado Miguel', 'España', '1996-05-30', 'jose@usal.es', '0000', 1),
('Raul', 'Piorno Ramos', 'El piornal', '1994-10-25', 'raul@usal.es', '1234', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `juego`
--
ALTER TABLE `juego`
  ADD PRIMARY KEY (`Titulo`);

--
-- Indices de la tabla `requisitosmax`
--
ALTER TABLE `requisitosmax`
  ADD PRIMARY KEY (`Titulo`);

--
-- Indices de la tabla `requisitosmin`
--
ALTER TABLE `requisitosmin`
  ADD PRIMARY KEY (`Titulo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
