-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 22 2026 г., 18:57
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `library`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id_author` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id_author`, `last_name`, `first_name`, `middle_name`) VALUES
(1, 'Пушкин', 'Александр', 'Сергеевич'),
(3, 'Достоевский', 'Фёдор', 'Михайлович'),
(4, 'Толстой', 'Лев', 'Николаевич'),
(5, 'Булгаков', 'Михаил', 'Афанасьевич'),
(6, 'Гоголь', 'Николай', 'Васильевич');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `id_author` int(11) NOT NULL,
  `id_status_book` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `publication_year` int(4) NOT NULL,
  `price` int(10) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `is_new` tinyint(1) NOT NULL,
  `cover` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `books_loans`
--

CREATE TABLE `books_loans` (
  `id_loan` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `card_number` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `return_date` date NOT NULL,
  `actual_return_date` date DEFAULT NULL,
  `id_status_loan` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `readers`
--

CREATE TABLE `readers` (
  `card_number` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id_role`, `role`) VALUES
(1, 'admin'),
(2, 'librarian');

-- --------------------------------------------------------

--
-- Структура таблицы `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `id_role` int(11) DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `staff`
--

INSERT INTO `staff` (`id_staff`, `login`, `password`, `first_name`, `last_name`, `middle_name`, `address`, `phone_number`, `id_role`) VALUES
(6, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Админ', 'Админов', NULL, 'Админcий', 'админ', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `statuses_books`
--

CREATE TABLE `statuses_books` (
  `id_status_book` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `statuses_books`
--

INSERT INTO `statuses_books` (`id_status_book`, `status`) VALUES
(1, 'в наличии'),
(2, 'выдана');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses_loans`
--

CREATE TABLE `statuses_loans` (
  `id_status_loan` int(11) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `statuses_loans`
--

INSERT INTO `statuses_loans` (`id_status_loan`, `status`) VALUES
(1, 'активна'),
(2, 'возвращена'),
(3, 'просрочена');

-- --------------------------------------------------------

--
-- Структура таблицы `tokens`
--

CREATE TABLE `tokens` (
  `id_token` int(11) NOT NULL,
  `id_staff` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id_author`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `id_author` (`id_author`),
  ADD KEY `id_status_book` (`id_status_book`);

--
-- Индексы таблицы `books_loans`
--
ALTER TABLE `books_loans`
  ADD PRIMARY KEY (`id_loan`),
  ADD KEY `id_book` (`id_book`),
  ADD KEY `card_number` (`card_number`),
  ADD KEY `id_status_loan` (`id_status_loan`);

--
-- Индексы таблицы `readers`
--
ALTER TABLE `readers`
  ADD PRIMARY KEY (`card_number`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Индексы таблицы `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `id_role` (`id_role`);

--
-- Индексы таблицы `statuses_books`
--
ALTER TABLE `statuses_books`
  ADD PRIMARY KEY (`id_status_book`);

--
-- Индексы таблицы `statuses_loans`
--
ALTER TABLE `statuses_loans`
  ADD PRIMARY KEY (`id_status_loan`);

--
-- Индексы таблицы `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id_token`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `id_staff` (`id_staff`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id_author` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `books_loans`
--
ALTER TABLE `books_loans`
  MODIFY `id_loan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `readers`
--
ALTER TABLE `readers`
  MODIFY `card_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `statuses_books`
--
ALTER TABLE `statuses_books`
  MODIFY `id_status_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `statuses_loans`
--
ALTER TABLE `statuses_loans`
  MODIFY `id_status_loan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`id_author`) REFERENCES `authors` (`id_author`),
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`id_status_book`) REFERENCES `statuses_books` (`id_status_book`);

--
-- Ограничения внешнего ключа таблицы `books_loans`
--
ALTER TABLE `books_loans`
  ADD CONSTRAINT `books_loans_ibfk_1` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`),
  ADD CONSTRAINT `books_loans_ibfk_2` FOREIGN KEY (`card_number`) REFERENCES `readers` (`card_number`),
  ADD CONSTRAINT `books_loans_ibfk_3` FOREIGN KEY (`id_status_loan`) REFERENCES `statuses_loans` (`id_status_loan`);

--
-- Ограничения внешнего ключа таблицы `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);

--
-- Ограничения внешнего ключа таблицы `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_ibfk_1` FOREIGN KEY (`id_staff`) REFERENCES `staff` (`id_staff`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
