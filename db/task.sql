-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 13 2020 г., 20:27
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `id_status` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task`
--

INSERT INTO `task` (`id`, `user_name`, `email`, `text`, `id_status`, `comment`) VALUES
(1, 'Тестwqwqwqw', 'kharin.92wqwq@mail.ruwqwqw', 'ededewdewdwedwed', 2, 'отредактировано администратором'),
(2, 'sdcdc', 'csdcsdcsd@dsd.ru', 'csdcsdcsdcsdc', 1, NULL),
(3, 'sdcdc', 'csdcsdcsd@dsd.ru', 'csdcsdcsdcsdc', 1, NULL),
(4, 'aA', 'kharin.92@mail.ru', 'SSSSSSSSSSSS ыывыв', 1, 'отредактировано администратором'),
(8, 'user', 'kharin.92@mail.ru', 'ddsfdsfsdf', 1, NULL),
(9, 'user', 'kharin.92@mail.ru', '&lt;script&gt;console.log(&quot;fff&quot;)&lt;/script&gt;', 1, NULL),
(10, 'user', 'kharin.92@mail.ru', 'ukiyuk', 1, NULL),
(11, 'Тест', 'kharin.92@mail.ru', 'ededewdewdwedwed добавил', 1, NULL),
(12, 'Тест', 'kharin.92@mail.ru', 'ededewdewdwedwed', 1, NULL),
(13, 'Тест', 'kharin.92@mail.ru', 'ededewdewdwedwed', 1, NULL),
(14, 'Тест', 'kharin.92@mail.ru', 'ededewdewdwedwed', 1, NULL),
(15, 'Тест', 'kharin.92@mail.ru', 'ededewdewdwedwed', 1, NULL),
(16, 'Тестwqwqwqw', 'kharin.92@mail.ru', 'ededewdewdwedwed', 1, 'отредактировано администратором'),
(17, 'Тестwqwqwqw', 'kharin.92wqwq@mail.ruwqwqw', 'ededewdewdwedwed', 1, NULL),
(18, 'test', 'test@mail.ru', ' &lt;script&gt;alert(‘test’);&lt;/script&gt;', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `task_status`
--

CREATE TABLE `task_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `task_status`
--

INSERT INTO `task_status` (`id`, `name`, `label`) VALUES
(1, 'created', 'Добавлена'),
(2, 'open', 'Выполнено');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `password` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_task_task_status` (`id_status`);

--
-- Индексы таблицы `task_status`
--
ALTER TABLE `task_status`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `task_status`
--
ALTER TABLE `task_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_task_task_status` FOREIGN KEY (`id_status`) REFERENCES `task_status` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
