-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-06-2021 a las 16:52:57
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/* Privilegios para `usuario_servitrade`@`%`*/

GRANT USAGE ON *.* TO `usuario_servitrade`@`%` IDENTIFIED BY PASSWORD '*EF7489257798033D63C2E19356D935D853D30665';
GRANT USAGE ON *.* TO 'usuario_servitrade'@'localhost' IDENTIFIED BY PASSWORD '*EF7489257798033D63C2E19356D935D853D30665';

GRANT ALL PRIVILEGES ON `servitrade`.* TO `usuario_servitrade`@`%` WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON `servitrade`.* TO 'usuario_servitrade'@'localhost' WITH GRANT OPTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `servitrade`
--
CREATE DATABASE IF NOT EXISTS `servitrade` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `servitrade`;

-- --------------------------------------------------------