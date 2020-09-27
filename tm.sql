-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 27 2020 г., 15:47
-- Версия сервера: 10.3.13-MariaDB
-- Версия PHP: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `fines2`
--

CREATE TABLE `fines2` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day_of_start` date NOT NULL,
  `is_finished` tinyint(1) NOT NULL DEFAULT 0,
  `cause` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2020_03_28_172034_create_fines_table', 1),
(4, '2020_04_16_174456_timetable_table', 2),
(5, '2020_03_28_171842_create_tasks_table', 3),
(6, '2020_03_28_172009_create_problems_table', 4),
(7, '2020_07_08_185603_add_status_column_to_tasks_table', 5),
(8, '2020_07_12_142559_update_tasks_table', 6),
(9, '2020_07_12_143111_update_problems_table', 6),
(11, '2020_09_08_165607_add_cause_field_to_timetables', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `problems`
--

CREATE TABLE `problems` (
  `problem_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL,
  `problem_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` tinyint(1) NOT NULL DEFAULT 0,
  `isPerfomed` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `timetable_id` int(11) NOT NULL,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark` double DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`task_id`, `timetable_id`, `task_name`, `details`, `time`, `mark`, `note`, `created_at`, `updated_at`, `status`) VALUES
(40, 47, 'task1', 'com1', '02:00', NULL, NULL, NULL, NULL, 2),
(41, 47, 'task2', 'com2', '01:00', NULL, NULL, NULL, NULL, 2),
(44, 49, 'task1', 'com1', '02:00', NULL, NULL, NULL, NULL, 2),
(45, 49, 'task2', 'com2', '01:00', NULL, NULL, NULL, NULL, 2),
(46, 50, 'task1', 'com1', '02:00', NULL, NULL, NULL, NULL, 2),
(47, 50, 'task2', 'com2', '01:00', NULL, NULL, NULL, NULL, 2),
(48, 50, 'non-task1', 'non-com1', '00:30', NULL, NULL, NULL, NULL, 1),
(49, 51, 'task1', 'com1', '02:00', 70, NULL, NULL, NULL, 2),
(50, 51, 'task2', 'com2', '01:30', 50, '50', NULL, NULL, 2),
(51, 51, 'task3', 'com3', '01:00', NULL, NULL, NULL, NULL, 2),
(52, 52, 'Задание 1', 'комен1', '02:00', NULL, NULL, NULL, NULL, 2),
(53, 52, 'Задание 2', 'комент2', '01:00', NULL, NULL, NULL, NULL, 2),
(55, 53, 'Задание 1', 'ком1', '02:00', NULL, NULL, NULL, NULL, 2),
(56, 53, 'Задание2', 'ком2', '01:00', NULL, NULL, NULL, NULL, 2),
(57, 54, 'task1', 'cpm1', '02:00', NULL, NULL, NULL, NULL, 2),
(58, 54, 'task2', 'com2', '01:00', NULL, NULL, NULL, NULL, 2),
(59, 54, 'non-task1', 'non-com1', '00:30', NULL, NULL, NULL, NULL, 1),
(60, 55, 'Работа', 'нет', '07:00', NULL, NULL, NULL, NULL, 2),
(61, 55, 'Оцифровка системы тайм-менеджмента', 'нет', '02:00', NULL, NULL, NULL, NULL, 2),
(62, 55, 'Bloomberg', 'нет', '00:30', NULL, NULL, NULL, NULL, 1),
(63, 55, 'Шахматы', 'нет', '00:30', NULL, NULL, NULL, NULL, 1),
(64, 56, 'Работа', '', '07:00', 78, '55', NULL, NULL, 2),
(65, 56, 'Оцифровка системы тайм-менеджмента', '', '02:00', NULL, NULL, NULL, NULL, 2),
(66, 57, 'Зарядка', 'гантели-25%,прогулка/дорожка-49%,велотренажер-25%', '01:30', 74, 'Комментарий 1', NULL, NULL, 2),
(67, 57, 'Оцифровка моей системы тайм-менеджмента', '', '02:00', 87, 'com2', NULL, NULL, 2),
(68, 58, 'Зарядка', 'гантели-25%,прогулка/дорожка-49%,велотренажер-25%', '01:30', 99, 'Вместо велотренажера-ЛФК', NULL, NULL, 2),
(69, 58, 'Оцифровка системы тайм-менеджмента', '', '02:00', 60, 'Работаю над возможностью добавления задания', NULL, NULL, 2),
(70, 58, 'Книга \"Деньги,банковский % и эконом циклы\"', '', '01:00', 70, 'стр 20', NULL, NULL, 2),
(71, 58, 'Bloomberg', '', '00:30', NULL, NULL, NULL, NULL, 1),
(72, 58, 'Шахматы', '', '00:30', NULL, NULL, NULL, NULL, 1),
(77, 60, 'Зарядка', '', '01:30', 74, 'Cегодня много прошел,когда подавал документы', NULL, NULL, 2),
(78, 60, 'Оцифровка системы тайм-менеджмента', 'Фикшу баги', '02:00', 68, 'Пофиксил баги редактирования и добавил окошко + задания', NULL, NULL, 2),
(79, 60, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(80, 60, 'Шахматы', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(81, 61, 'Зарядка', '', '01:30', 74, 'NULL', NULL, NULL, 2),
(82, 61, 'Оцифровка системы тайм-менеджмента', 'Реализую возможность добавить задание', '02:00', 58, 'Пока не получается', NULL, NULL, 2),
(83, 61, 'Книга \"Деньги,Банковский % и эконом циклы\"', 'стр 20', '01:00', 62, 'NULL', NULL, NULL, 2),
(84, 61, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(85, 61, 'Шахматы', '', '00:30', 84, 'NULL', NULL, NULL, 1),
(86, 62, 'Зарядка', 'ЛФК(25%)|Прогулка(49%)|ЛФК2(25%)', '01:30', 99, 'NULL', NULL, NULL, 2),
(87, 62, 'Оцифровка системы тайм-менеджмента', 'Продолжить работу над возможностью + задание', '02:00', NULL, 'NULL', NULL, NULL, 2),
(88, 62, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(89, 62, 'Шахматы', '', '00:30', 78, 'NULL', NULL, NULL, 1),
(90, 63, 'Зарядка', 'ЛФК-25%,Прогулка-49%,велотренажер-25%', '01:30', NULL, 'Сейчас 25%', NULL, NULL, 2),
(91, 63, 'Оцифровкка системы тпйм-менеджмента', '', '02:00', NULL, 'NULL', NULL, NULL, 2),
(92, 63, 'Финансовая теория', 'Учебник Мишкмна', '01:00', NULL, 'NULL', NULL, NULL, 2),
(93, 63, 'Bloomberg', '', '00:30', 80, 'NULL', NULL, NULL, 1),
(94, 63, 'Шахматы', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(95, 64, 'Зарядка', 'Гантели/ЛФК-25%,Прогулка/дорожка-49%,велотренажер-25%', '01:30', 74, 'NULL', NULL, NULL, 2),
(96, 64, 'Работа', '', '07:00', 68, 'NULL', NULL, NULL, 2),
(97, 64, 'Оцифровка моей системы тайм-менеджмента', 'Действовать согласно плану', '02:00', 63, 'NULL', NULL, NULL, 2),
(98, 64, 'Bloomberg/BBC', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(99, 64, 'Шахматы', '', '00:30', NULL, '73%..', NULL, NULL, 1),
(106, 66, 'Зарядка', '', '01:30', 74, 'ЛФК-25%,прогулка-49%,велотренажер-25%', NULL, NULL, 2),
(107, 66, 'Работа', '', '07:00', 68, 'NULL', NULL, NULL, 2),
(108, 66, 'Финансовая теория', '', '01:00', 70, 'стр 39', NULL, NULL, 2),
(109, 66, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(110, 66, 'Шахматы', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(111, 66, 'Оцифровка системы тайм-менеджмента', '', '02:00', 90, 'Добавил возможность добавлять задания', NULL, NULL, 2),
(112, 67, 'Зарядка', 'ЛФК-25%,прогулка-49%,велотренажер-25%', '01:30', 75, 'Прошел больше чем обычно => +1%', NULL, NULL, 2),
(113, 67, 'Работа', '', '07:00', 67, 'NULL', NULL, NULL, 2),
(114, 67, 'Оцифровка системы тайм-менеджмента', '', '02:00', NULL, 'NULL', NULL, NULL, 2),
(115, 67, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(116, 67, 'Шахматы', '', '00:30', 85, 'NULL', NULL, NULL, 1),
(120, 67, 'Разобраться с больничным', '', '00:00', NULL, NULL, NULL, NULL, 0),
(121, 68, 'Зарядка', '', '01:30', 74, 'NULL', NULL, NULL, 2),
(122, 68, 'Работа', '', '07:00', 62, 'NULL', NULL, NULL, 2),
(123, 68, 'Изучение baaGrid', '', '01:00', 59, 'NULL', NULL, NULL, 2),
(124, 68, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(125, 68, 'Шахматы', '', '00:30', 80, 'NULL', NULL, NULL, 1),
(126, 68, 'ntcn', '', '00:01', NULL, NULL, NULL, NULL, 0),
(127, 69, 'Зарядка', 'ЛФК-25%,Прогулка-49%,ЛФК2-25%', '01:30', 99, 'Прошел от Макаенка до дома без посиделок', NULL, NULL, 2),
(128, 69, 'Оцифровка системы тайм-менеджмента', '', '02:00', 80, 'Реализовал добавление и оценку задачи', NULL, NULL, 2),
(129, 69, 'Финансовая теория', '*стр 39', '01:00', 71, '*стр 50', NULL, NULL, 2),
(130, 69, 'BBC', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(131, 69, 'Шахматы', '', '00:30', 82, 'NULL', NULL, NULL, 1),
(132, 69, 'Добавить функционал добавления', '', '00:00', 99, 'Работает', NULL, NULL, 0),
(133, 69, 'Задача 2', '', '00:00', 99, 'NULL', NULL, NULL, 0),
(134, 70, 'Зарядка', 'ЛФК-25%,Прогулка-49%,велотренажер-25%', '01:30', 50, 'Пошел дождь и помешал прогулке', NULL, NULL, 2),
(135, 70, 'Работа', '', '07:00', 73, 'Практически закончил текущее задание', NULL, NULL, 2),
(136, 70, 'Оцифровка системы тайм-менеджмента', 'Реализация экстренного режима', '02:00', NULL, 'NULL', NULL, NULL, 2),
(137, 70, 'Bloomberg/BBC', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(138, 70, 'Шахматы', '', '00:30', 76, 'NULL', NULL, NULL, 1),
(139, 71, 'Зарядка', 'ЛФК-25%,Прогулка-49%,Велотренажер-25%', '01:30', 74, 'NULL', NULL, NULL, 2),
(140, 71, 'Работа', '', '07:00', 70, 'NULL', NULL, NULL, 2),
(141, 71, 'Оцифровка системы тайм-менеджмента', 'Реализация экстренного режима', '02:00', 82, 'NULL', NULL, NULL, 2),
(142, 71, 'Шахматы', '', '00:30', 81, 'NULL', NULL, NULL, 1),
(143, 71, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(144, 72, 'Зарядка', 'ЛФК-25%,Прогулка-49%,велотренажер-25%', '01:30', 74, 'NULL', NULL, NULL, 2),
(145, 72, 'Работа', 'Отправить на тестирование задачу по срелнедневным остаткам', '07:00', 75, 'NULL', NULL, NULL, 2),
(146, 72, 'Оцифровка системы тайм-менеджмента', '', '02:00', 69, 'NULL', NULL, NULL, 2),
(147, 72, 'Шахматы', '', '00:30', 77, 'NULL', NULL, NULL, 1),
(148, 72, 'Bloomberg', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(149, 73, 'Зарядка', 'ЛФК1-25%бДорожка/Прогулка-49%,велотренажер-25%', '01:30', NULL, '25%..', NULL, NULL, 2),
(150, 73, 'Оцифровка системы тайм-менеджмента', '', '02:00', NULL, 'Добавить фунционал просмотра истории', NULL, NULL, 2),
(151, 73, 'Финансовая теория', '*стр 50', '01:00', NULL, 'NULL', NULL, NULL, 2),
(152, 73, 'Bloomberg/BBC/Euronews', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(153, 73, 'Шахматы', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(154, 74, 'Зарядка', 'Гантели/ЛФК-25%,Прогулка-49%,велотренажер-25%', '01:30', 50, 'NULL', NULL, NULL, 2),
(155, 74, 'Оцифровка системы тайм-менеджмента', '', '02:00', NULL, '42%..', NULL, NULL, 2),
(156, 74, 'Финансовая теория', '*стр 106', '01:30', NULL, 'NULL', NULL, NULL, 2),
(157, 74, 'Euronews', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(158, 74, 'Шахматы', '', '00:30', NULL, 'NULL', NULL, NULL, 1),
(159, 74, 'Книга \"Анализ ценных бумаг\"', '', '01:00', NULL, '*стр 15', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `timetables`
--

CREATE TABLE `timetables` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `day_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `final_estimation` double(8,2) NOT NULL,
  `own_estimation` double(8,2) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `necessary` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `for_tommorow` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cause` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `timetables`
--

INSERT INTO `timetables` (`id`, `user_id`, `date`, `day_status`, `final_estimation`, `own_estimation`, `comment`, `necessary`, `for_tommorow`, `created_at`, `updated_at`, `cause`) VALUES
(47, 1, '2020-07-19', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-19 08:20:34', '2020-07-19 08:20:34', NULL),
(49, 1, '2020-07-20', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-20 13:04:20', '2020-07-20 13:04:20', NULL),
(50, 1, '2020-07-21', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-21 13:23:49', '2020-07-21 13:23:49', NULL),
(51, 1, '2020-07-22', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-22 14:08:14', '2020-07-22 14:08:14', NULL),
(52, 1, '2020-07-26', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-26 10:55:18', '2020-07-26 10:55:18', NULL),
(53, 1, '2020-07-27', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-27 13:53:46', '2020-07-27 13:53:46', NULL),
(54, 1, '2020-07-28', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-28 14:34:03', '2020-07-28 14:34:03', NULL),
(55, 1, '2020-07-29', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-29 14:35:11', '2020-07-29 14:35:11', NULL),
(56, 1, '2020-07-30', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-07-30 13:22:36', '2020-07-30 13:22:36', NULL),
(57, 1, '2020-08-02', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-02 08:07:42', '2020-08-02 08:07:42', NULL),
(58, 1, '2020-08-06', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-06 05:13:41', '2020-08-06 05:13:41', NULL),
(60, 1, '2020-08-07', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-07 12:37:02', '2020-08-07 12:37:02', NULL),
(61, 1, '2020-08-08', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-08 09:54:51', '2020-08-08 09:54:51', NULL),
(62, 1, '2020-08-10', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-10 11:50:38', '2020-08-10 11:50:38', NULL),
(63, 1, '2020-08-23', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-23 07:04:39', '2020-08-23 07:04:39', NULL),
(64, 1, '2020-08-24', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-24 13:44:06', '2020-08-24 13:44:06', NULL),
(66, 1, '2020-08-27', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-27 14:18:40', '2020-08-27 14:18:40', NULL),
(67, 1, '2020-08-28', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-08-28 13:30:20', '2020-08-28 13:30:20', NULL),
(68, 1, '2020-09-02', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-09-02 15:26:47', '2020-09-02 15:26:47', NULL),
(69, 1, '2020-09-05', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-09-05 10:15:42', '2020-09-05 10:15:42', NULL),
(70, 1, '2020-09-07', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-09-07 13:15:40', '2020-09-07 13:15:40', NULL),
(71, 1, '2020-09-08', 'Ред', -1.00, -1.00, 'Тестовая причина', NULL, NULL, '2020-09-08 13:50:34', '2020-09-08 13:50:34', NULL),
(72, 1, '2020-09-09', 'Ред', -1.00, -1.00, '', NULL, NULL, '2020-09-09 14:29:45', '2020-09-09 14:29:45', NULL),
(73, 1, '2020-09-13', 'Ред', -1.00, -1.00, 'Продолжаю работать над функцией экстренного режима', NULL, NULL, '2020-09-13 05:58:33', '2020-09-13 05:58:33', NULL),
(74, 1, '2020-09-27', 'Ред', -1.00, -1.00, NULL, NULL, NULL, '2020-09-27 07:00:37', '2020-09-27 07:00:37', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Vlad', 'vlad.markotin@gmail.com', '$2y$10$0oVKF8E.w059yi8iXC4NbesLXmlolMGPWYiUBAIyyi3FIjocLYza2', 0, '3tJbilWOINszvFEqZhZaUWfdBaubQLFkeWgq820lgyNMyA6FRqmE7G7TzWQx', '2020-04-19 06:36:34', '2020-04-19 06:36:34');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `fines2`
--
ALTER TABLE `fines2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fines2_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`problem_id`),
  ADD KEY `problems_timetable_id_foreign` (`timetable_id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `tasks_timetable_id_foreign` (`timetable_id`);

--
-- Индексы таблицы `timetables`
--
ALTER TABLE `timetables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`),
  ADD UNIQUE KEY `date_2` (`date`),
  ADD UNIQUE KEY `date_3` (`date`),
  ADD UNIQUE KEY `date_4` (`date`),
  ADD UNIQUE KEY `date_5` (`date`),
  ADD UNIQUE KEY `date_6` (`date`),
  ADD KEY `timetables_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `fines2`
--
ALTER TABLE `fines2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `problems`
--
ALTER TABLE `problems`
  MODIFY `problem_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT для таблицы `timetables`
--
ALTER TABLE `timetables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `fines2`
--
ALTER TABLE `fines2`
  ADD CONSTRAINT `fines2_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_timetable_id_foreign` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`);

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_timetable_id_foreign` FOREIGN KEY (`timetable_id`) REFERENCES `timetables` (`id`);

--
-- Ограничения внешнего ключа таблицы `timetables`
--
ALTER TABLE `timetables`
  ADD CONSTRAINT `timetables_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
