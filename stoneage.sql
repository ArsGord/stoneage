-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 09 2020 г., 21:28
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `stoneage`
--

-- --------------------------------------------------------

--
-- Структура таблицы `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `field` text NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `maps`
--

INSERT INTO `maps` (`id`, `name`, `field`, `width`, `height`) VALUES
(1, 'первая карта', '1,0,1,1,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 6, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `tiles`
--

CREATE TABLE `tiles` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tiles`
--

INSERT INTO `tiles` (`id`, `type`, `name`, `x`, `y`) VALUES
(1, 1, 'grass', 1, 1),
(2, 0, 'water', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `token` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `password`, `token`) VALUES
(1, 'Вася', 'vasya', '4a2d247d0c05a4f798b0b03839d94cf0', '27b9b2adcbb60220d8b4eea85d56ebcd'),
(2, 'Петя', 'petya', 'd7ba312b012b3374ef53eb2e3f9830a5', '51042d46b38281419aa777356eb5af8a'),
(3, 'МарияИванна', 'masha', '68626ed9a3adbaf5bfd9148d42edd26b', 'b834f47eea96a26d61ba894a2a3e5964');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `maps`
--
ALTER TABLE `maps`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tiles`
--
ALTER TABLE `tiles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tiles`
--
ALTER TABLE `tiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
