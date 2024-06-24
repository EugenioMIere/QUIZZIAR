-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-06-2024 a las 22:45:35
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
-- Base de datos: `preguntados`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `color` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `color`) VALUES
(1, 'Arte', '#F2293A'),
(2, 'Ciencia', '#21BF58'),
(3, 'Deportes', '#F28705'),
(4, 'Entretenimiento', '#F252BA'),
(5, 'Geografia', '#1575CF'),
(6, 'Historia', '#F8DE41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id` int(11) NOT NULL,
  `usuario_id` bigint(20) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `correctas` int(11) NOT NULL,
  `incorrectas` int(11) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidas`
--

INSERT INTO `partidas` (`id`, `usuario_id`, `fecha`, `correctas`, `incorrectas`, `fecha_creacion`) VALUES
(16, 5, '2024-06-20 12:47:08', 8, 3, '2024-06-22 16:07:31'),
(17, 5, '2024-06-20 21:21:34', 1, 10, '2024-06-22 16:07:31'),
(18, 5, '2024-06-20 22:18:55', 1, 5, '2024-06-22 16:07:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas_preguntas`
--

CREATE TABLE `partidas_preguntas` (
  `id` int(11) NOT NULL,
  `partida_id` int(11) DEFAULT NULL,
  `pregunta_id` bigint(20) DEFAULT NULL,
  `respuesta_id` bigint(20) DEFAULT NULL,
  `correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidas_preguntas`
--

INSERT INTO `partidas_preguntas` (`id`, `partida_id`, `pregunta_id`, `respuesta_id`, `correcta`) VALUES
(1, 16, 84, 334, 1),
(2, 16, 26, 102, 1),
(3, 16, 32, 126, 1),
(4, 16, 80, 317, 0),
(5, 16, 34, 135, 1),
(6, 16, 62, 247, 1),
(7, 16, 29, 115, 1),
(8, 16, 45, 177, 1),
(9, 16, 2, 7, 1),
(10, 16, 61, 241, 0),
(11, 16, 39, 154, 0),
(12, 16, 11, NULL, 0),
(13, 17, 48, 189, 0),
(14, 17, 54, 213, 0),
(15, 17, 66, 261, 1),
(16, 17, 53, 210, 0),
(17, 17, 8, 30, 0),
(18, 17, 72, 286, 0),
(19, 17, 51, 201, 0),
(20, 17, 77, 308, 0),
(21, 17, 55, 217, 0),
(22, 17, 43, 170, 0),
(23, 17, 57, NULL, 0),
(24, 18, 7, 25, 0),
(25, 18, 23, 90, 1),
(26, 18, 82, 327, 0),
(27, 18, 19, NULL, 0),
(28, 18, 12, 46, 0),
(29, 18, 30, 117, 0),
(30, 18, 69, 274, 0),
(31, 18, 14, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id` bigint(20) NOT NULL,
  `pregunta` varchar(255) NOT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `dificultad` enum('Facil','Medio','Dificil') DEFAULT 'Facil',
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id`, `pregunta`, `categoria_id`, `dificultad`, `fecha_creacion`) VALUES
(1, '¿Quién pintó la Mona Lisa?', 1, 'Facil', '2024-06-22 15:58:39'),
(2, '¿Quién esculpió la estatua del David?', 1, 'Facil', '2024-06-22 15:58:39'),
(3, '¿Qué famoso pintor neerlandés perdió una oreja?', 1, 'Facil', '2024-06-22 15:58:39'),
(4, '¿Qué artista es conocido por sus \"Latas de Sopa Campbell\"?', 1, 'Facil', '2024-06-22 15:58:39'),
(5, '¿Cuál es el nombre del famoso teatro de ópera ubicado en Sidney, Australia?', 1, 'Facil', '2024-06-22 15:58:39'),
(6, '¿Cuál es el título de la película ganadora del Oscar a la Mejor Película en 2020?', 1, 'Facil', '2024-06-22 15:58:39'),
(7, '¿Quién escribió “La divina comedia”?', 1, 'Dificil', '2024-06-22 15:58:39'),
(8, 'Según el cuento de \"El Principito\", ¿cuál fue el séptimo planeta que visitó?', 1, '', '2024-06-22 15:58:39'),
(9, '¿Qué usamos para diluir los colores de las acuarelas?', 1, 'Facil', '2024-06-22 15:58:39'),
(10, '¿Cuántos dedos tiene por lo general una caricatura?', 1, 'Facil', '2024-06-22 15:58:39'),
(11, '¿Quién es el autor de la frase \"Es tan corto el amor, y es tan largo el olvido\"?', 1, 'Facil', '2024-06-22 15:58:39'),
(12, '¿Quién era la diosa de la sabiduría en la mitología griega?', 1, 'Dificil', '2024-06-22 15:58:39'),
(13, '13. ¿Cuál es el siglo más importante para el arte barroco en España?', 1, 'Facil', '2024-06-22 15:58:39'),
(14, '¿Cuál de estos cuentos fue escrito por Julio Cortázar?', 1, 'Facil', '2024-06-22 15:58:39'),
(15, 'Completa el dicho: \"Tira la piedra...\".', 1, 'Facil', '2024-06-22 15:58:39'),
(16, '¿Quién escribió la obra \"Trabajo asalariado y capital\"?', 1, 'Facil', '2024-06-22 15:58:39'),
(17, '¿Cómo despertó el príncipe a la Bella Durmiente?', 1, 'Facil', '2024-06-22 15:58:39'),
(18, '¿Qué planeta es conocido como el planeta rojo?', 2, 'Facil', '2024-06-22 15:58:39'),
(19, '¿Cuál es el elemento químico con el símbolo O?', 2, 'Facil', '2024-06-22 15:58:39'),
(20, '¿Quién desarrolló la teoría de la relatividad?', 2, 'Facil', '2024-06-22 15:58:39'),
(21, '¿Cuál es la molécula portadora de la información genética?', 2, 'Facil', '2024-06-22 15:58:39'),
(22, '¿Qué gas es el más abundante en la atmósfera terrestre?', 2, 'Facil', '2024-06-22 15:58:39'),
(23, '¿Qué fuerza nos mantiene en la superficie de la Tierra?', 2, 'Dificil', '2024-06-22 15:58:39'),
(24, '¿Qué tipo de célula carece de núcleo?', 2, 'Facil', '2024-06-22 15:58:39'),
(25, '¿Cuál es la sustancia más dura conocida por el hombre?', 2, 'Facil', '2024-06-22 15:58:39'),
(26, '¿Qué órgano del cuerpo humano produce insulina?', 2, 'Facil', '2024-06-22 15:58:39'),
(27, '¿Qué partícula subatómica tiene una carga negativa?', 2, 'Facil', '2024-06-22 15:58:39'),
(28, '¿Qué científico es conocido por su trabajo en la gravedad y las leyes del movimiento?', 2, 'Facil', '2024-06-22 15:58:39'),
(29, '¿Cuál es la principal fuente de energía para la Tierra?', 2, 'Facil', '2024-06-22 15:58:39'),
(30, '¿Qué órgano es responsable de bombear sangre por todo el cuerpo?', 2, 'Dificil', '2024-06-22 15:58:39'),
(31, '¿Qué unidad se utiliza para medir la intensidad de la corriente eléctrica?', 2, 'Facil', '2024-06-22 15:58:39'),
(32, '¿Qué planeta es conocido por tener un sistema de anillos prominente?', 2, 'Facil', '2024-06-22 15:58:39'),
(33, '¿Qué es H2O comúnmente conocido?', 2, 'Facil', '2024-06-22 15:58:39'),
(34, '¿Qué fenómeno explica por qué los objetos flotan en el agua?', 2, 'Facil', '2024-06-22 15:58:39'),
(35, '¿Qué parte de la célula contiene el material genético?', 2, 'Facil', '2024-06-22 15:58:39'),
(36, '¿Qué tipo de reacción química libera energía?', 2, 'Facil', '2024-06-22 15:58:39'),
(37, '¿Cuál es el planeta más grande del sistema solar?', 2, 'Facil', '2024-06-22 15:58:39'),
(38, '¿Qué jugador de baloncesto es conocido como \"The King\"?', 3, 'Facil', '2024-06-22 15:58:39'),
(39, '¿Cuál es el deporte nacional de Japón?', 3, 'Facil', '2024-06-22 15:58:39'),
(40, '¿En qué deporte se destaca la atleta Serena Williams?', 3, 'Facil', '2024-06-22 15:58:39'),
(41, '¿Cuánto dura un partido de fútbol?', 3, 'Facil', '2024-06-22 15:58:39'),
(42, '¿Cuándo se celebró el primer mundial de fútbol?', 3, 'Facil', '2024-06-22 15:58:39'),
(43, '¿Qué selección de fútbol ha ganado más Mundiales?', 3, 'Dificil', '2024-06-22 15:58:39'),
(44, 'Si juegas a la NFL, ¿qué deporte practicas?', 3, 'Facil', '2024-06-22 15:58:39'),
(45, '¿Cuál es el deporte más popular en India?', 3, 'Facil', '2024-06-22 15:58:39'),
(46, '¿Cuál es el máximo título de tenis en Estados Unidos?', 3, 'Facil', '2024-06-22 15:58:39'),
(47, '¿Cuál es el máximo torneo de baloncesto a nivel mundial?', 3, 'Facil', '2024-06-22 15:58:39'),
(48, '¿Cuál es la distancia oficial de una maratón?', 3, '', '2024-06-22 15:58:39'),
(49, '¿Cuál es el nombre del festival de música más grande de Argentina?', 4, 'Facil', '2024-06-22 15:58:39'),
(50, '¿Cuál es la banda de rock más exitosa de todos los tiempos?', 4, 'Facil', '2024-06-22 15:58:39'),
(51, '¿Quién es el autor de la famosa novela \"Cien años de soledad\"?', 4, 'Dificil', '2024-06-22 15:58:39'),
(52, '¿Cuál es la serie de televisión más vista de todos los tiempos?', 4, 'Facil', '2024-06-22 15:58:39'),
(53, '¿Quién interpretó el papel de Harry Potter en las películas basadas en los libros de J.K.Rowling?', 4, '', '2024-06-22 15:58:39'),
(54, '¿Cuál es la película más taquillera de todos los tiempos?', 4, '', '2024-06-22 15:58:39'),
(55, '¿Quién es el actor principal en la película \"El Padrino\"?', 4, 'Dificil', '2024-06-22 15:58:39'),
(56, '¿Quién es el vocalista de la banda británica Queen?', 4, 'Facil', '2024-06-22 15:58:39'),
(57, '¿Qué álbum de Michael Jackson es el más vendido de todos los tiempos?', 4, 'Facil', '2024-06-22 15:58:39'),
(58, '¿Qué banda fue conocida como los \"Cuatro Fantásticos\" del Liverpool?', 4, 'Facil', '2024-06-22 15:58:39'),
(59, '¿Cuál es el nombre completo de la cantante pop conocida como \"Beyoncé\"?', 4, 'Facil', '2024-06-22 15:58:39'),
(60, '¿Qué serie de Netflix trata sobre un grupo de niños que desaparecen misteriosamente en un pequeño pueblo?', 4, 'Facil', '2024-06-22 15:58:39'),
(61, '¿Cuál es el río más largo del mundo?', 5, 'Facil', '2024-06-22 15:58:39'),
(62, '¿Cuál es la capital de Australia?', 5, 'Facil', '2024-06-22 15:58:39'),
(63, '¿En qué continente se encuentra el país de Mongolia?', 5, 'Facil', '2024-06-22 15:58:39'),
(64, '¿Cuál es el país más grande del mundo por área terrestre?', 5, 'Facil', '2024-06-22 15:58:39'),
(65, '¿Cuál es el país más pequeño del mundo en términos de área terrestre?', 5, 'Facil', '2024-06-22 15:58:39'),
(66, '¿Qué montaña es la más alta del mundo?', 5, '', '2024-06-22 15:58:39'),
(67, '¿En qué océano se encuentra la isla de Madagascar?', 5, 'Facil', '2024-06-22 15:58:39'),
(68, '¿Cuál es el país más poblado del mundo?', 5, 'Facil', '2024-06-22 15:58:39'),
(69, '¿Qué país africano es conocido como la \"cuna de la humanidad\" por sus importantes hallazgos arqueológicos?', 5, 'Dificil', '2024-06-22 15:58:39'),
(70, '¿Cuál es el país con la mayor cantidad de islas en el mundo?', 5, 'Facil', '2024-06-22 15:58:39'),
(71, '¿Cuál es el país con la mayor extensión de costa en el mundo?', 5, 'Facil', '2024-06-22 15:58:39'),
(72, '¿Cuál es el nombre del satélite argentino que fue lanzado al espacio en 1948?', 5, 'Dificil', '2024-06-22 15:58:39'),
(73, '¿En qué año cayó el Imperio Romano de Occidente?', 6, 'Facil', '2024-06-22 15:58:39'),
(74, '¿Qué civilización antigua construyó las pirámides de Giza?', 6, 'Facil', '2024-06-22 15:58:39'),
(75, '¿Qué tratado puso fin a la Primera Guerra Mundial?', 6, 'Facil', '2024-06-22 15:58:39'),
(76, '¿Quién fue el primer presidente de los Estados Unidos?', 6, 'Facil', '2024-06-22 15:58:39'),
(77, '¿En qué año Cristóbal Colón llegó a América?', 6, 'Dificil', '2024-06-22 15:58:39'),
(78, '¿Cuál fue la civilización precolombina que construyó Machu Picchu?', 6, 'Facil', '2024-06-22 15:58:39'),
(79, '¿En qué año comenzó la Segunda Guerra Mundial?', 6, 'Facil', '2024-06-22 15:58:39'),
(80, '¿Qué imperio controló gran parte del norte de África y partes de Europa durante la Edad Media?', 6, 'Facil', '2024-06-22 15:58:39'),
(81, '¿Quién fue el líder del movimiento de independencia de la India?', 6, 'Facil', '2024-06-22 15:58:39'),
(82, '¿Quién fue el primer hombre en caminar sobre la Luna?', 6, 'Dificil', '2024-06-22 15:58:39'),
(83, '¿Qué muro separó a Berlín en dos durante la Guerra Fría?', 6, 'Facil', '2024-06-22 15:58:39'),
(84, '¿Quién fue el líder del movimiento por los derechos civiles en Estados Unidos en la década de 1960?', 6, 'Facil', '2024-06-22 15:58:39'),
(85, '¿Qué acontecimiento histórico se conmemora el 2 de abril en Argentina?', 6, 'Facil', '2024-06-22 15:58:39'),
(86, '¿Quién fue el líder militar y político argentino conocido como el “Padre de la patria”?', 6, 'Facil', '2024-06-22 15:58:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_reportadas`
--

CREATE TABLE `preguntas_reportadas` (
  `id` int(11) NOT NULL,
  `pregunta_reportada` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas_reportadas`
--

INSERT INTO `preguntas_reportadas` (`id`, `pregunta_reportada`) VALUES
(1, 85);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_sugeridas`
--

CREATE TABLE `preguntas_sugeridas` (
  `id` bigint(20) NOT NULL,
  `pregunta` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas_sugeridas`
--

INSERT INTO `preguntas_sugeridas` (`id`, `pregunta`, `fecha_creacion`) VALUES
(1, '¿En qué año nació Colón?', '2024-06-20 21:14:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes`
--

CREATE TABLE `redes` (
  `usuario_id` bigint(20) NOT NULL,
  `pagina_web` varchar(200) DEFAULT NULL,
  `github` varchar(200) DEFAULT NULL,
  `twitter` varchar(200) DEFAULT NULL,
  `facebook` varchar(200) DEFAULT NULL,
  `instagram` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` bigint(20) NOT NULL,
  `pregunta_id` bigint(20) DEFAULT NULL,
  `respuesta` varchar(255) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `pregunta_id`, `respuesta`, `es_correcta`) VALUES
(5, 2, 'Donatello', 0),
(6, 2, 'Gian Lorenzo Bernini', 0),
(7, 2, 'Michelangelo', 1),
(8, 2, 'Auguste Rodin', 0),
(9, 3, 'Vincent van Gogh', 1),
(10, 3, 'Rembrandt', 0),
(11, 3, 'Jan Vermeer', 0),
(12, 3, 'Hieronymus Bosch', 0),
(13, 4, 'Roy Lichtenstein', 0),
(14, 4, 'Andy Warhol', 1),
(15, 4, 'Jean-Michel Basquiat', 0),
(16, 4, 'Jasper Johns', 0),
(17, 5, 'Royal Albert Hall', 0),
(18, 5, 'Sydney Opera House', 1),
(19, 5, 'Teatro alla Scala', 0),
(20, 5, 'Lincoln Center', 0),
(21, 6, '1917', 0),
(22, 6, 'Joker', 0),
(23, 6, 'Parasite', 1),
(24, 6, 'Once Upon a Time in Hollywood', 0),
(25, 7, 'Giovanni Boccaccio', 0),
(26, 7, 'Francesco Petrarca', 0),
(27, 7, 'Dante Alighieri', 1),
(28, 7, 'Torquato Tasso', 0),
(29, 8, 'El planeta del geógrafo', 0),
(30, 8, 'El planeta del farolero', 0),
(31, 8, 'El planeta del rey', 0),
(32, 8, 'El planeta Tierra', 1),
(33, 9, 'Aceite', 0),
(34, 9, 'Alcohol', 0),
(35, 9, 'Agua', 1),
(36, 9, 'Vinagre', 0),
(37, 10, 'Tres', 0),
(38, 10, 'Cuatro', 1),
(39, 10, 'Cinco', 0),
(40, 10, 'Seis', 0),
(41, 11, 'Jorge Luis Borges', 0),
(42, 11, 'Pablo Neruda', 1),
(43, 11, 'Gabriel García Márquez', 0),
(44, 11, 'Mario Benedetti', 0),
(45, 12, 'Hera', 0),
(46, 12, 'Afrodita', 0),
(47, 12, 'Atenea', 1),
(48, 12, 'Artemisa', 0),
(49, 13, 'XVI', 0),
(50, 13, 'XVII', 1),
(51, 13, 'XVIII', 0),
(52, 13, 'XIX', 0),
(53, 14, 'La Casa de Asterión', 0),
(54, 14, 'La Casa Verde', 0),
(55, 14, 'Casa Tomada', 1),
(56, 14, 'Casa de Muñecas', 0),
(57, 15, 'Y esconde la piedra', 0),
(58, 15, 'Y esconde el tesoro', 0),
(59, 15, 'Y esconde la mano', 1),
(60, 15, 'Y esconde el rastro', 0),
(61, 16, 'Friedrich Engels', 0),
(62, 16, 'Adam Smith', 0),
(63, 16, 'Karl Marx', 1),
(64, 16, 'John Maynard Keynes', 0),
(65, 17, 'Tocándola', 0),
(66, 17, 'Gritándole', 0),
(67, 17, 'Besándola', 1),
(68, 17, 'Sacudiéndola', 0),
(69, 18, 'Júpiter', 0),
(70, 18, 'Saturno', 0),
(71, 18, 'Marte', 1),
(72, 18, 'Venus', 0),
(73, 19, 'Oro', 0),
(74, 19, 'Oxígeno', 1),
(75, 19, 'Osmio', 0),
(76, 19, 'Oxalato', 0),
(77, 20, 'Isaac Newton', 0),
(78, 20, 'Nikola Tesla', 0),
(79, 20, 'Albert Einstein', 1),
(80, 20, 'Galileo Galilei', 0),
(81, 21, 'ARN', 0),
(82, 21, 'Proteína', 0),
(83, 21, 'ADN', 1),
(84, 21, 'Lípido', 0),
(85, 22, 'Oxígeno', 0),
(86, 22, 'Dióxido de carbono', 0),
(87, 22, 'Nitrógeno', 1),
(88, 22, 'Hidrógeno', 0),
(89, 23, 'Magnetismo', 0),
(90, 23, 'Gravedad', 1),
(91, 23, 'Inercia', 0),
(92, 23, 'Fuerza centrífuga', 0),
(93, 24, 'Célula animal', 0),
(94, 24, 'Célula vegetal', 0),
(95, 24, 'Célula procariota', 1),
(96, 24, 'Célula eucariota', 0),
(97, 25, 'Hierro', 0),
(98, 25, 'Diamante', 1),
(99, 25, 'Carbón', 0),
(100, 25, 'Grafito', 0),
(101, 26, 'Hígado', 0),
(102, 26, 'Páncreas', 1),
(103, 26, 'Riñón', 0),
(104, 26, 'Corazón', 0),
(105, 27, 'Protón', 0),
(106, 27, 'Neutrón', 0),
(107, 27, 'Electrón', 1),
(108, 27, 'Quark', 0),
(109, 28, 'Galileo Galilei', 0),
(110, 28, 'Isaac Newton', 1),
(111, 28, 'Johannes Kepler', 0),
(112, 28, 'Albert Einstein', 0),
(113, 29, 'Viento', 0),
(114, 29, 'Agua', 0),
(115, 29, 'Sol', 1),
(116, 29, 'Biomasa', 0),
(117, 30, 'Cerebro', 0),
(118, 30, 'Hígado', 0),
(119, 30, 'Corazón', 1),
(120, 30, 'Pulmones', 0),
(121, 31, 'Voltio', 0),
(122, 31, 'Vatio', 0),
(123, 31, 'Ohmio', 0),
(124, 31, 'Amperio', 1),
(125, 32, 'Júpiter', 0),
(126, 32, 'Saturno', 1),
(127, 32, 'Urano', 0),
(128, 32, 'Neptuno', 0),
(129, 33, 'Sal', 0),
(130, 33, 'Agua', 1),
(131, 33, 'Dióxido de carbono', 0),
(132, 33, 'Ácido sulfúrico', 0),
(133, 34, 'Gravedad', 0),
(134, 34, 'Magnetismo', 0),
(135, 34, 'Principio de Arquímedes', 1),
(136, 34, 'Inercia', 0),
(137, 35, 'Membrana celular', 0),
(138, 35, 'Citoplasma', 0),
(139, 35, 'Núcleo', 1),
(140, 35, 'Ribosoma', 0),
(141, 36, 'Endotérmica', 0),
(142, 36, 'Exotérmica', 1),
(143, 36, 'Isotérmica', 0),
(144, 36, 'Adiabática', 0),
(145, 37, 'Tierra', 0),
(146, 37, 'Saturno', 0),
(147, 37, 'Neptuno', 0),
(148, 37, 'Júpiter', 1),
(149, 38, 'Kobe Bryant', 0),
(150, 38, 'LeBron James', 1),
(151, 38, 'Michael Jordan', 0),
(152, 38, 'Shaquille O Neal', 0),
(153, 39, 'Sumo', 1),
(154, 39, 'Judo', 0),
(155, 39, 'JudKarateo', 0),
(156, 39, 'Taekwondo', 0),
(157, 40, 'Tenis', 1),
(158, 40, 'Golf', 0),
(159, 40, 'Atletismo', 0),
(160, 40, 'Natación', 0),
(161, 41, '60 minutos', 0),
(162, 41, '80 minutos', 0),
(163, 41, '6900 minutos', 1),
(164, 41, '120 minutos', 0),
(165, 42, 'El 13 de julio de 1930 en Uruguay.', 1),
(166, 42, 'El 7 de septiembre de 1928 en Argentina.', 0),
(167, 42, 'El 15 de mayo de 1934 en Italia.', 0),
(168, 42, 'El 2 de diciembre de 1926 en Francia.', 0),
(169, 43, 'Alemania', 0),
(170, 43, 'Argentina', 0),
(171, 43, 'Brasil', 1),
(172, 43, 'Italia', 0),
(173, 44, 'Béisbol', 0),
(174, 44, 'Baloncesto', 0),
(175, 44, 'Fútbol americano.', 1),
(176, 44, 'Golf', 0),
(177, 45, 'Cricket', 1),
(178, 45, 'Fútbol', 0),
(179, 45, 'Hockey sobre hierba', 0),
(180, 45, 'Bádminton', 0),
(181, 46, 'Abierto de Australia', 0),
(182, 46, 'Abierto de Francia', 0),
(183, 46, 'US Open', 1),
(184, 46, 'Wimbledon', 0),
(185, 47, 'Eurobasket', 0),
(186, 47, 'NBA Finals', 0),
(187, 47, 'Juegos Olímpicos', 0),
(188, 47, 'Copa del Mundo de Baloncesto', 1),
(189, 48, '26 kilómetros', 0),
(190, 48, '42 kilómetros', 1),
(191, 48, '50 kilómetros', 0),
(192, 48, '100 kilómetros', 0),
(193, 49, 'Lollapalooza', 0),
(194, 49, 'Rock in Rio', 0),
(195, 49, 'Cosquín Rock', 1),
(196, 49, 'Coachella', 0),
(197, 50, 'The Beatles', 1),
(198, 50, 'Queen', 0),
(199, 50, 'Led Zeppelin', 0),
(200, 50, 'The Rolling Stones', 0),
(201, 51, 'Pablo Neruda', 0),
(202, 51, 'Gabriel García Márquez', 1),
(203, 51, 'Jorge Luis Borges', 0),
(204, 51, 'Isabel Allende', 0),
(205, 52, 'Game of Thrones', 0),
(206, 52, 'Friends', 0),
(207, 52, 'Los Simpson', 0),
(208, 52, 'Breaking Bad', 1),
(209, 53, 'Daniel Radcliffe', 1),
(210, 53, 'Rupert Grint', 0),
(211, 53, 'Emma Watson', 0),
(212, 53, 'Tom Felton', 0),
(213, 54, 'Avatar', 0),
(214, 54, 'Vengadores: Endgame', 1),
(215, 54, 'Titanic', 0),
(216, 54, 'Star Wars: El Despertar de la Fuerza', 0),
(217, 55, 'Al Pacino', 0),
(218, 55, 'Robert De Niro', 0),
(219, 55, 'Marlon Brando', 1),
(220, 55, 'James Caan', 0),
(221, 56, 'Mick Jagger', 0),
(222, 56, 'Roger Taylor', 0),
(223, 56, 'Freddie Mercury', 1),
(224, 56, 'John Lennon', 0),
(225, 57, 'Thriller', 1),
(226, 57, 'Bad', 0),
(227, 57, 'Off the Wall', 0),
(228, 57, 'Dangerous', 0),
(229, 58, 'The Rolling Stones', 0),
(230, 58, 'The Beach Boys', 0),
(231, 58, 'The Beatles', 1),
(232, 58, 'Led Zeppelin', 0),
(233, 59, 'Beyoncé Carter', 0),
(234, 59, 'Beyoncé Knowles-Carter', 0),
(235, 59, 'Beyoncé Johnson', 0),
(236, 59, 'Beyoncé Smith', 1),
(237, 60, 'Stranger Things', 1),
(238, 60, 'Dark', 0),
(239, 60, 'The Crown', 0),
(240, 60, 'Breaking Bad', 0),
(241, 61, 'Nilo', 0),
(242, 61, 'Amazonas', 1),
(243, 61, 'Yangtsé', 0),
(244, 61, 'Misisipi', 0),
(245, 62, 'Sídney', 0),
(246, 62, 'Melbourne', 0),
(247, 62, 'Canberra', 1),
(248, 62, 'Brisbane', 0),
(249, 63, 'Asia', 1),
(250, 63, 'Europa', 0),
(251, 63, 'África', 0),
(252, 63, 'Oceanía', 0),
(253, 64, 'Estados Unidos', 0),
(254, 64, 'China', 0),
(255, 64, 'Rusia', 1),
(256, 64, 'Canadá', 0),
(257, 65, 'Mónaco', 0),
(258, 65, 'Nauru', 0),
(259, 65, 'San Marino', 0),
(260, 65, 'El Vaticano', 1),
(261, 66, 'Monte Everest', 1),
(262, 66, 'Mont Blanc', 0),
(263, 66, 'K2', 0),
(264, 66, 'Kilimanjaro', 0),
(265, 67, 'Océano Atlántico', 0),
(266, 67, 'Océano Pacífico', 0),
(267, 67, 'Océano Índico', 1),
(268, 67, 'Mar Mediterr´áneo', 0),
(269, 68, 'Estados Unidos', 0),
(270, 68, 'India', 0),
(271, 68, 'China', 1),
(272, 68, 'Indonesia', 0),
(273, 69, 'Sudáfrica', 0),
(274, 69, 'Egipto', 0),
(275, 69, 'Kenia', 0),
(276, 69, 'Tanzania', 1),
(277, 70, 'Indonesia', 1),
(278, 70, 'Filipinas', 0),
(279, 70, 'Maldivas', 0),
(280, 70, 'Japón', 0),
(281, 71, 'Estados Unidos', 0),
(282, 71, 'Australia', 0),
(283, 71, 'Canadá', 1),
(284, 71, 'Rusia', 0),
(285, 72, 'Nahuel I', 0),
(286, 72, 'Belgrano I', 0),
(287, 72, 'Ñacurutú I', 1),
(288, 72, 'Pehuén I', 0),
(289, 73, '410 d.C.', 0),
(290, 73, '476 d.C.', 1),
(291, 73, '500 d.C.', 0),
(292, 73, '1453 d.C.', 0),
(293, 74, 'Los sumerios', 0),
(294, 74, 'Los griegos', 0),
(295, 74, 'Los egipcios', 1),
(296, 74, 'Los romanos', 0),
(297, 75, 'Tratado de Tordesillas', 0),
(298, 75, 'Tratado de Utrecht', 0),
(299, 75, 'Tratado de Versalles', 1),
(300, 75, 'Tratado de París', 0),
(301, 76, 'John Adams', 0),
(302, 76, 'Thomas Jefferson', 0),
(303, 76, 'George Washington', 1),
(304, 76, 'Abraham Lincoln', 0),
(305, 77, '1492', 1),
(306, 77, '1500', 0),
(307, 77, '1498', 0),
(308, 77, '1512', 0),
(309, 78, 'Los aztecas', 0),
(310, 78, 'Los mayas', 0),
(311, 78, 'Los incas', 1),
(312, 78, 'Los olmecas', 0),
(313, 79, '1935', 0),
(314, 79, '1937', 0),
(315, 79, '1939', 1),
(316, 79, '1941', 0),
(317, 80, 'El Imperio Bizantino', 0),
(318, 80, 'El Imperio Otomano', 1),
(319, 80, 'El Imperio Carolingio', 0),
(320, 80, 'El Imperio Mongol', 0),
(321, 81, 'Jawaharlal Nehru', 0),
(322, 81, 'Subhas Chandra Bose', 0),
(323, 81, 'Mahatma Gandhi', 1),
(324, 81, 'Sardar Patel', 0),
(325, 82, 'Buzz Aldrin', 0),
(326, 82, 'Yuri Gagarin', 0),
(327, 82, 'Alan Shepard', 0),
(328, 82, 'Neil Armstrong', 1),
(329, 83, 'Muro de los Lamentos', 0),
(330, 83, 'Muro de Berlín', 1),
(331, 83, 'Muro de la Democracia', 0),
(332, 83, 'Muro de Varsovia', 0),
(333, 84, 'Malcolm X', 0),
(334, 84, 'Martin Luther King Jr.', 1),
(335, 84, 'Rosa Parks', 0),
(336, 84, 'Frederick Douglass', 0),
(337, 85, 'Día de la Independencia', 0),
(338, 85, 'Día del Trabajador', 0),
(339, 85, 'Día del Veterano y de los Caídos en la Guerra de Malvinas', 1),
(340, 85, 'Día de la Revolución de Mayo', 0),
(341, 86, 'Juan Manuel de Rosas', 0),
(342, 86, 'Domingo Faustino Sarmiento', 0),
(343, 86, 'José de San Martín', 1),
(344, 86, 'Manuel Belgrano', 0),
(370, 1, 'Leonardo Da Vinci', 1),
(371, 1, 'Vincent Van Gogh', 0),
(372, 1, 'Pablo Picasso', 0),
(373, 1, 'Michelangelo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `nombreCompleto` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fechaDeNacimiento` date NOT NULL,
  `genero` enum('Masculino','Femenino','Otro') NOT NULL,
  `pais` varchar(30) NOT NULL,
  `ciudad` varchar(30) NOT NULL,
  `nombreDeUsuario` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fotoDePerfil` longblob NOT NULL,
  `token` varchar(200) DEFAULT NULL,
  `estado` enum('activo, desactivado') DEFAULT NULL,
  `rol` enum('administrador','usuario','editor') NOT NULL DEFAULT 'usuario',
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombreCompleto`, `email`, `fechaDeNacimiento`, `genero`, `pais`, `ciudad`, `nombreDeUsuario`, `password`, `fotoDePerfil`, `token`, `estado`, `rol`, `fecha_creacion`) VALUES
(3, 'Bianca Leites', 'leitesbianca32@gmail.com', '2004-10-28', 'Femenino', 'Argentina', 'Buenos Aires', 'leitesbianca', 'e36bbc9dcfa58232f055aa1436f53ae8', 0x707275656261, '666c799e0628e', NULL, 'editor', '2024-06-22 16:06:32'),
(4, 'Bianca', 'bianleites56@gmail.com', '2005-10-28', 'Femenino', 'Argentina', 'Buenos Aires', 'leitesbianca56', '7bfb07f0560d6eebdcf40b389b100640', 0x707275656261, '666c7ac60161a', NULL, 'usuario', '2024-06-22 16:06:32'),
(5, 'Eugenio Adrina Miere Arrua', 'eugenio.adrian@hotmail.com', '1998-01-04', 'Masculino', 'Argentina', 'Caseros', 'Emiere', '304294d67f9c0088568b560b9537703f', 0x707275656261, '666ccd867539f', NULL, 'administrador', '2024-06-22 16:06:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `partidas_preguntas`
--
ALTER TABLE `partidas_preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partida_id` (`partida_id`),
  ADD KEY `pregunta_id` (`pregunta_id`),
  ADD KEY `respuesta_id` (`respuesta_id`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `preguntas_reportadas`
--
ALTER TABLE `preguntas_reportadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_reportada` (`pregunta_reportada`);

--
-- Indices de la tabla `preguntas_sugeridas`
--
ALTER TABLE `preguntas_sugeridas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `redes`
--
ALTER TABLE `redes`
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `partidas_preguntas`
--
ALTER TABLE `partidas_preguntas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `preguntas_reportadas`
--
ALTER TABLE `preguntas_reportadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `preguntas_sugeridas`
--
ALTER TABLE `preguntas_sugeridas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=374;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `partidas_preguntas`
--
ALTER TABLE `partidas_preguntas`
  ADD CONSTRAINT `partidas_preguntas_ibfk_1` FOREIGN KEY (`partida_id`) REFERENCES `partidas` (`id`),
  ADD CONSTRAINT `partidas_preguntas_ibfk_2` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`),
  ADD CONSTRAINT `partidas_preguntas_ibfk_3` FOREIGN KEY (`respuesta_id`) REFERENCES `respuestas` (`id`);

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);

--
-- Filtros para la tabla `preguntas_reportadas`
--
ALTER TABLE `preguntas_reportadas`
  ADD CONSTRAINT `preguntas_reportadas_ibfk_1` FOREIGN KEY (`pregunta_reportada`) REFERENCES `preguntas` (`id`);

--
-- Filtros para la tabla `redes`
--
ALTER TABLE `redes`
  ADD CONSTRAINT `redes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
