-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 13 2024 г., 17:32
-- Версия сервера: 5.6.37
-- Версия PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `qrpet`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pet_info`
--

CREATE TABLE `pet_info` (
  `id` int(10) NOT NULL,
  `pet_id` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `pet_name` varchar(255) NOT NULL,
  `breed` varchar(255) NOT NULL,
  `age` int(10) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `more_info` text NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_num` varchar(255) NOT NULL,
  `reward` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `wp` varchar(255) NOT NULL,
  `fb` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pet_info`
--

INSERT INTO `pet_info` (`id`, `pet_id`, `pass`, `photo`, `pet_name`, `breed`, `age`, `msg`, `more_info`, `owner_name`, `owner_num`, `reward`, `address`, `email`, `wp`, `fb`, `instagram`) VALUES
(1, '123456', '123', '641b95fd106283.22688361.png', 'Charley', 'Booldog', 3, 'Please, help me to get home', 'Please let me know if you find it sdfgjhhkh', 'Anar', '+994502861065', '200', 'Surowieckiego 12c/6', 'anar.ismahilov@gmail.com', '502861035', 'sadsadsa', 'asdsada'),
(7, 'M3gATVk', 'i0hOv', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(8, 'RtdgFku', 'c9d6n', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(9, 'vY1ptWI', 'ohXaU', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(10, 'CmP3J1G', 'pjfb6', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(11, 'BUjHjlx', 'jFoOw', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(12, 'llwTtuN', 'JNzdZ', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(13, '2UdLpmM', 'CEhmF', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(14, 'XuXw4m0', 'ecIvr', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(15, '3UUcRLa', '8kEMj', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(16, 'HpHlFnp', 'ksoRQ', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(17, 'MKjjwPx', 'Sl3zD', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(18, '6o0j8kX', '8hP0N', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(19, 'SmfyMTh', '6lSbF', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(20, 'njzXgEw', 'cORE6', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(21, 'op1UPge', 'jtUoy', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(22, '1TC4u5A', 'qASCn', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(23, '2Db14ce', 'XoUgh', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(24, 'fCdzjEA', 'VQRkX', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(25, 'xAUJCGi', 'ROuYq', '', '', '', 0, '', '', '', '', '', '', '', '', '', ''),
(26, 'kQS2S6w', 'LI6Qe', '', '', '', 0, '', '', '', '', '', '', '', '', '', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pet_info`
--
ALTER TABLE `pet_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pet_info`
--
ALTER TABLE `pet_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
