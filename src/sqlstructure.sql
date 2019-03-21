-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 21 2019 г., 16:11
-- Версия сервера: 5.7.23-log
-- Версия PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Структура таблицы `balance`
--

CREATE TABLE `balance` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Record Id',
  `currency_id` int(11) UNSIGNED NOT NULL COMMENT 'Currency id',
  `amount` bigint(20) DEFAULT '0',
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation date',
  `date_update` timestamp NULL DEFAULT NULL COMMENT 'Record update date',
  `is_deleted` tinyint(1) DEFAULT '0',
  `ready` tinyint(3) DEFAULT '0' COMMENT 'Эта колонка указывает, наличный счет или нет, 1 - наличный, 0 - безналичный'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Balance';

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE `currency` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Record Id',
  `country_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Country id',
  `name_ru` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Currency name in russian',
  `name_en` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Currency name in english',
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Currency code',
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation date',
  `date_update` timestamp NULL DEFAULT NULL COMMENT 'Record update date',
  `precision` int(11) NOT NULL DEFAULT '100' COMMENT 'Precision for convert to price'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Currencies';

-- --------------------------------------------------------

--
-- Структура таблицы `finance_operation`
--

CREATE TABLE `finance_operation` (
  `id` int(10) UNSIGNED NOT NULL,
  `operation_type_id` int(11) UNSIGNED NOT NULL,
  `currency_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `finance_operation_type`
--

CREATE TABLE `finance_operation_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `finance_transaction`
--

CREATE TABLE `finance_transaction` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Record Id',
  `balance_id` int(11) UNSIGNED NOT NULL COMMENT 'User id',
  `balance_to` int(11) UNSIGNED DEFAULT NULL,
  `balance_from` int(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Operation type: 0 - draw, 1 - topup, 2 - currency exchange',
  `amount_before` bigint(20) NOT NULL,
  `amount_after` bigint(20) NOT NULL,
  `currency_id_before` int(11) UNSIGNED NOT NULL COMMENT 'Balance currency (before)',
  `currency_id_after` int(11) UNSIGNED NOT NULL COMMENT 'Balance currency after',
  `comment` text COLLATE utf8_unicode_ci,
  `date_create` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Record creation date',
  `operation_id` int(11) UNSIGNED NOT NULL COMMENT 'Operation identity',
  `sum` bigint(20) DEFAULT NULL COMMENT 'Transaction sum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Balance operations';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balance_currency_id_fkey` (`currency_id`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currency_code_unique` (`code`),
  ADD KEY `currency_country_id_fkey` (`country_id`);

--
-- Индексы таблицы `finance_operation`
--
ALTER TABLE `finance_operation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ix-finance_operation-operation_type` (`operation_type_id`),
  ADD KEY `ix-finance_operation-currency_id` (`currency_id`);

--
-- Индексы таблицы `finance_operation_type`
--
ALTER TABLE `finance_operation_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Индексы таблицы `finance_transaction`
--
ALTER TABLE `finance_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balance_operation_balance_id_fkey` (`balance_id`),
  ADD KEY `balance_operation_currency_id__before_fkey` (`currency_id_before`),
  ADD KEY `balance_operation_currency_id__after_fkey` (`currency_id_after`),
  ADD KEY `ix-balance_operation-from` (`balance_from`),
  ADD KEY `ix-balance_operation-to` (`balance_to`),
  ADD KEY `ix-finance_transaction-operation` (`operation_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Record Id';

--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Record Id';

--
-- AUTO_INCREMENT для таблицы `finance_operation`
--
ALTER TABLE `finance_operation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `finance_operation_type`
--
ALTER TABLE `finance_operation_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `finance_transaction`
--
ALTER TABLE `finance_transaction`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Record Id';

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `balance`
--
ALTER TABLE `balance`
  ADD CONSTRAINT `balance_currency_id_fkey` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `currency`
--
ALTER TABLE `currency`
  ADD CONSTRAINT `currency_country_id_fkey` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `finance_operation`
--
ALTER TABLE `finance_operation`
  ADD CONSTRAINT `fk-finance_operation-currency` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-finance_operation-operation_type` FOREIGN KEY (`operation_type_id`) REFERENCES `finance_operation_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `finance_transaction`
--
ALTER TABLE `finance_transaction`
  ADD CONSTRAINT `balance_operation_balance_id_fkey` FOREIGN KEY (`balance_id`) REFERENCES `balance` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `balance_operation_currency_id__after_fkey` FOREIGN KEY (`currency_id_after`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `balance_operation_currency_id__before_fkey` FOREIGN KEY (`currency_id_before`) REFERENCES `currency` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-balance_operation-balance_from` FOREIGN KEY (`balance_from`) REFERENCES `balance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-balance_operation-balance_to` FOREIGN KEY (`balance_to`) REFERENCES `balance` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk-finance_transaction-operation` FOREIGN KEY (`operation_id`) REFERENCES `finance_operation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
