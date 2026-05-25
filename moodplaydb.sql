-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2026 at 07:58 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moodplaydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`) VALUES
(1, 'Descarga la Ira'),
(2, 'Contra el Sistema'),
(3, 'Rabia Interna'),
(4, 'Furia Oscura'),
(5, 'Antihéroes');

-- --------------------------------------------------------

--
-- Table structure for table `peliculas`
--

CREATE TABLE `peliculas` (
  `id_pelicula` int NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url_video` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_estreno` date DEFAULT NULL,
  `id_categoria` int DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peliculas`
--

INSERT INTO `peliculas` (`id_pelicula`, `titulo`, `descripcion`, `imagen`, `url_video`, `fecha_estreno`, `id_categoria`, `precio`, `stock`) VALUES
(1, 'The Boys', 'Un grupo de vigilantes intenta detener a unos superhéroes corruptos que usan su fama y poder para manipular al mundo.', '1.png', '', '2019-07-26', 2, 30.00, 10),
(2, 'The Purge', 'En una sociedad donde todos los crímenes son legales durante una noche al año, varias personas luchan por sobrevivir a “La Purga”.', '2.png', '', '2013-06-07', 3, 22.00, 10),
(3, 'Gangs of London', 'Tras el asesinato del jefe criminal más poderoso de Londres, distintas bandas entran en guerra por el control de la ciudad.', '3.png', '', '2020-04-23', 4, 40.50, 10),
(4, 'Tokyo Vice', 'Un periodista estadounidense se adentra en el peligroso mundo de la yakuza mientras trabaja para un periódico japonés en Tokio.', '4.png', '', '2022-04-07', 1, 34.99, 5),
(5, 'El Hoyo 2', 'Secuela del thriller distópico español donde nuevos prisioneros intentan sobrevivir en una prisión vertical marcada por la desigualdad extrema.', '5.png', '', '2024-10-04', 5, 20.50, 0),
(6, 'Euphoria', 'Un grupo de adolescentes enfrenta problemas de drogas, identidad, relaciones y salud mental en un entorno intenso y oscuro.', '6.png', '', '2024-06-16', 3, 33.00, 20),
(7, 'Chernobyl', 'Miniserie basada en el desastre nuclear de Chernóbil de 1986 y en las consecuencias humanas, políticas y científicas del accidente.', '7.png', '', '2019-05-06', 3, 40.50, 10),
(8, 'Breaking Bad', 'Un profesor de química con cáncer comienza a fabricar metanfetamina para asegurar el futuro económico de su familia.', '8.png', '', '2008-01-20', 3, 50.50, 30),
(9, 'Prisioners', 'Tras la desaparición de dos niñas, un padre desesperado toma medidas extremas mientras la policía intenta resolver el caso. Thriller psicológico intenso dirigido por Denis Villeneuve.', '9.png', '', '2013-09-20', 2, 50.00, 9);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `rol` enum('ADMIN','USER') COLLATE utf8mb4_general_ci DEFAULT 'USER',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(5, 'Sara Jimenez', 'sara@test.com', '$2y$10$agycMg1J/6JK/EX89M0HWOiimqJnfyVTpIWwnq.Urr4FQsYocJavK', 'USER', '2026-05-18 09:47:27'),
(6, 'admin', 'admin@test.com', '$2y$10$moMVr.ThSW2HNUeq0j.p3eFXNLw2Vl.4oa0rJpRum3F2Rs9lVUobG', 'ADMIN', '2026-05-18 10:13:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indexes for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD PRIMARY KEY (`id_pelicula`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peliculas`
--
ALTER TABLE `peliculas`
  MODIFY `id_pelicula` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peliculas`
--
ALTER TABLE `peliculas`
  ADD CONSTRAINT `peliculas_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
