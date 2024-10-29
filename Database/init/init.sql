


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `tennis`
--

-- --------------------------------------------------------

--
-- Структура таблицы `matches`
--

CREATE TABLE `matches`
(
    `ID`      int(12) NOT NULL,
    `Player1` int(11) NOT NULL,
    `Player2` int(11) NOT NULL,
    `Winner`  int(11) NOT NULL
)
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Дамп данных таблицы `matches`
--

INSERT INTO `matches` (`ID`, `Player1`, `Player2`, `Winner`)
VALUES (1, 1, 3, 1),
       (2, 3, 4, 4),
       (3, 1, 5, 1),
       (4, 1, 6, 1),
       (5, 10, 7, 7),
       (6, 5, 8, 5),
       (7, 7, 9, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `players`
--

CREATE TABLE `players`
(
    `ID`   int(11)     NOT NULL,
    `Name` varchar(50) NOT NULL
)
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Дамп данных таблицы `players`
--

INSERT INTO `players` (`ID`, `Name`)
VALUES (11, 'Алекс де Минор'),
       (4, 'Александр Зверев'),
       (8, 'Андрей Рублёв'),
       (10, 'Григор Димитров'),
       (6, 'Даниил Медведев'),
       (3, 'Карлос Алькарас'),
       (9, 'Каспер Рууд'),
       (5, 'Новак Джокович'),
       (7, 'Тейлор Фриц'),
       (1, 'Янник Синнер');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `matches`
--
ALTER TABLE `matches`
    ADD PRIMARY KEY (`ID`),
    ADD UNIQUE KEY `ID` (`ID`),
    ADD KEY `Winner` (`Winner`),
    ADD KEY `Player2` (`Player2`),
    ADD KEY `Player1` (`Player1`);

--
-- Индексы таблицы `players`
--
ALTER TABLE `players`
    ADD PRIMARY KEY (`ID`),
    ADD UNIQUE KEY `Name` (`Name`),
    ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `matches`
--
ALTER TABLE `matches`
    MODIFY `ID` int(12) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT для таблицы `players`
--
ALTER TABLE `players`
    MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `matches`
--
ALTER TABLE `matches`
    ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`Winner`) REFERENCES `players` (`ID`),
    ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`Player2`) REFERENCES `players` (`ID`),
    ADD CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`Player1`) REFERENCES `players` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
