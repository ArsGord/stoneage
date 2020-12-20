-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 20 2020 г., 13:10
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
-- Структура таблицы `gamer`
--

CREATE TABLE `gamer` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(16) NOT NULL,
  `direction` varchar(10) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `satiety` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `gamer`
--

INSERT INTO `gamer` (`id`, `user_id`, `status`, `direction`, `x`, `y`, `hp`, `satiety`) VALUES
(1, 1, 'offline', 'left', 3, 3, 100, 56),
(2, 2, 'offline', 'down', 4, 2, 90, 91),
(3, 3, 'offline', 'down', 2, 1, 100, 100),
(4, 4, 'offline', 'down', 1, 2, 100, 100),
(5, 5, 'offline', 'down', 5, 0, 100, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `hp` int(11) NOT NULL,
  `calories` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `damage` int(11) DEFAULT NULL,
  `gamer_id` int(11) DEFAULT NULL,
  `inventory` varchar(12) NOT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `type_id`, `name`, `hp`, `calories`, `armor`, `damage`, `gamer_id`, `inventory`, `x`, `y`) VALUES
(1, 9, 'wood', 100, NULL, NULL, NULL, NULL, 'map', 1, 2),
(28, 1, 'axe', 100, NULL, NULL, 15, 1, 'right_hand', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `item_type`
--

CREATE TABLE `item_type` (
  `id` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  `name` varchar(16) NOT NULL,
  `default_hp` int(11) NOT NULL,
  `calories` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `damage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `item_type`
--

INSERT INTO `item_type` (`id`, `type`, `name`, `default_hp`, `calories`, `armor`, `damage`) VALUES
(1, 'weapon', 'axe', 100, NULL, NULL, 15),
(2, 'weapon', 'bow', 100, NULL, NULL, 15),
(3, 'weapon', 'spear', 100, NULL, NULL, 20),
(4, 'weapon', 'shield', 100, NULL, 5, 5),
(5, 'building', 'hut', 250, NULL, 5, NULL),
(6, 'building', 'wall', 150, NULL, 5, NULL),
(7, 'animal', 'human', 100, 100, NULL, 5),
(8, 'animal', 'cow', 40, 10, NULL, NULL),
(9, 'resource', 'wood', 100, NULL, NULL, NULL),
(10, 'resource', 'stone', 100, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `maps`
--

CREATE TABLE `maps` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `field` text NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `maps`
--

INSERT INTO `maps` (`id`, `name`, `hash`, `field`, `width`, `height`) VALUES
(1, 'первая карта', '36cea70e56df3987c66e1eafcbac2df1', '1,0,1,1,1,1,1,0,0,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1', 6, 5);

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
(1, 1, 'grass', 0, 0),
(2, 0, 'water', 1, 0),
(3, 0, 'water', 2, 0),
(4, 1, 'grass', 3, 0),
(5, 1, 'grass', 4, 0),
(6, 1, 'grass', 5, 0),
(7, 1, 'sand', 0, 1),
(8, 0, 'water', 1, 1),
(9, 0, 'water', 2, 1),
(10, 1, 'sand', 3, 1),
(11, 1, 'sand', 4, 1),
(12, 1, 'sand', 5, 1),
(13, 1, 'snow', 0, 2),
(14, 1, 'snow', 1, 2),
(15, 1, 'snow', 2, 2),
(16, 1, 'snow', 3, 2),
(17, 1, 'snow', 4, 2),
(18, 1, 'snow', 5, 2),
(19, 1, 'dirt', 0, 3),
(20, 1, 'dirt', 1, 3),
(21, 1, 'dirt', 2, 3),
(22, 1, 'dirt', 3, 3),
(23, 1, 'dirt', 4, 3),
(24, 1, 'dirt', 5, 3),
(25, 1, 'grass', 0, 4),
(26, 1, 'grass', 1, 4),
(27, 1, 'grass', 2, 4),
(28, 0, 'water', 3, 4),
(29, 0, 'water', 4, 4),
(30, 1, 'grass', 5, 4);

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
(1, 'Вася', 'vasya', '4a2d247d0c05a4f798b0b03839d94cf0', ''),
(2, 'Петя', 'petya', 'd7ba312b012b3374ef53eb2e3f9830a5', ''),
(3, 'МарияИванна', 'masha', '68626ed9a3adbaf5bfd9148d42edd26b', 'b834f47eea96a26d61ba894a2a3e5964'),
(4, 'Виталик228', 'Vitalek', 'be102ee3f322c437670ae29934756240', ''),
(5, 'Дима', 'dima', '70c9dc2d09299d9d21583266acc7681c', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `gamer`
--
ALTER TABLE `gamer`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `item_type`
--
ALTER TABLE `item_type`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT для таблицы `gamer`
--
ALTER TABLE `gamer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT для таблицы `item_type`
--
ALTER TABLE `item_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `maps`
--
ALTER TABLE `maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tiles`
--
ALTER TABLE `tiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
