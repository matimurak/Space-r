-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Lut 2023, 10:46
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `spacer`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `events`
--

INSERT INTO `events` (`id`, `name`, `event_type_id`, `date`, `time`, `description`) VALUES
(11, 'Koniunkcja Wenus z Jowiszem', 6, '2023-03-01', '00:00:00', 'zbliżenie dwóch jasnych obiektów. Zbliżenie dwóch jasnych obiektów. Warto je obserwować przez lornetkę lub teleskop.'),
(12, 'rodziny autora aplikacji', 1, '1999-11-25', '00:00:00', 'Dzień dobry.'),
(13, 'Pełnia', 4, '2023-03-07', '00:00:00', ''),
(14, 'Ostatnia kwadra', 4, '2023-03-15', '00:00:00', ''),
(15, 'Astronomiczna wiosna', 1, '2023-03-20', '21:25:00', ''),
(17, 'Koniunkcja Księżyc - Uran', 6, '2023-03-24', '23:52:00', 'Koniunkcja Księżyca i Urana w odległości - 1°26.'),
(19, 'Koniunkcja Księżyc - Wenus', 6, '2023-03-24', '10:31:00', 'Koniunkcja Księżyca i Wenus w odległości - 0°06`.'),
(20, 'Kometa C/2022 E3', 7, '2023-02-01', '00:00:00', 'Kometa C/2022 E3 (ZTF) znajdzie się najbliżej Ziemi.'),
(21, 'Koniunkcja Wenus - Neptun', 6, '2023-02-15', '00:00:00', 'Koniunkcja Wenus - Neptun w odległości - 0°01`.'),
(22, 'Koniunkcja Księżyc - Merkury', 6, '2023-02-18', '00:00:00', 'Koniunkcja Księżyc - Merkury w odległości - 3°27`.'),
(25, 'Koniunkcja Księżyc - Saturn', 6, '2023-02-20', '02:00:00', 'Koniunkcja Księżyc - Saturn w odległości - 3°25`.'),
(26, 'Nów', 4, '2023-02-20', '07:05:00', ''),
(27, 'Koniunkcja Księżyc - Wenus', 6, '2023-02-22', '09:26:00', 'Koniunkcja Księżyc - Wenus w odległości - 1°51`.'),
(28, 'Koniunkcja Księżyc - Jowisz', 6, '2023-02-22', '22:48:00', 'Koniunkcja Księżyc - Jowisz w odległości - 1°03`.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `event_types`
--

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL,
  `type` varchar(40) NOT NULL DEFAULT 'other'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `event_types`
--

INSERT INTO `event_types` (`id`, `type`) VALUES
(1, 'Inne'),
(7, 'Kometa'),
(6, 'Koniunkcja'),
(4, 'Wydarzenie Księżyca'),
(2, 'Wydarzenie społeczności'),
(3, 'Wydarzenie Słońca'),
(5, 'Zaćmienie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(10000) NOT NULL,
  `submittedby` int(11) NOT NULL,
  `submittedon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `moderator` tinyint(1) NOT NULL DEFAULT 0,
  `fname` varchar(40) DEFAULT NULL,
  `lname` varchar(40) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `createdon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `hashed_password`, `admin`, `moderator`, `fname`, `lname`, `email`, `createdon`) VALUES
(4, 'mati99wp', '$2y$10$F1LNQZ.VmQs2/9PrQkddZuAVR9Z4CwgNqcUmZH0LLayOiFRrc3Uee', 0, 0, 'Mateusz', 'Murak', NULL, '2022-12-13 13:46:11'),
(6, 'c', '$2y$10$kmt69xafbsOpHr4B8d5jJueFRVpNucNbxBWS5fm1OkE2i9vgvqPjC', 1, 1, 'mattt', 'b', NULL, '2022-12-16 12:29:07'),
(7, 'andre2000', '$2y$10$Mb9Y/c4vc2xDNlMuzqwQ.uwmhZB4yD21qbMITm8N.JCZsJQUWQ7qy', 0, 0, 'Andrzej', 'Baczyński', NULL, '2023-02-09 20:18:34');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indeksy dla tabeli `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Test` (`submittedby`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`);

--
-- Ograniczenia dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `Test` FOREIGN KEY (`submittedby`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
