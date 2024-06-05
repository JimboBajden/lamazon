-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Cze 2024, 21:48
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `lamazon`
--
CREATE DATABASE IF NOT EXISTS `lamazon` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lamazon`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `img`
--

DROP TABLE IF EXISTS `img`;
CREATE TABLE `img` (
  `img_id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `img`
--

INSERT INTO `img` (`img_id`, `url`) VALUES
(2, 'dom_kategoria.jpg'),
(5, 'temp_img.jpg\r\n'),
(6, 'krzesło_drewniane.jpg'),
(7, 'dom_kategoria.jpg'),
(8, 'audi.jpg'),
(9, 'ogórd.jpg'),
(10, 'skakanka.jpg'),
(11, 'ziemia.jpg'),
(12, 'ziemniak.jpg'),
(13, 'kuchenka_gazowa.jpg'),
(14, 'toster.jpg'),
(15, 'koń.jpg'),
(16, 'kamien.jpg'),
(17, 'grabki.jpg'),
(18, 'drzewo.jpg'),
(19, 'kwiatek.jpg'),
(20, 'stółkuchenny.jpg'),
(21, 'sofa.jpg'),
(22, 'hobby.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

DROP TABLE IF EXISTS `kategoria`;
CREATE TABLE `kategoria` (
  `kategoria_id` int(11) NOT NULL,
  `nazwa` varchar(200) NOT NULL,
  `img_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `nazwa`, `img_id`) VALUES
(1, 'dom', 2),
(2, 'ogród', 9),
(3, 'hobby', 22);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

DROP TABLE IF EXISTS `konta`;
CREATE TABLE `konta` (
  `konto_id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `konta`
--

INSERT INTO `konta` (`konto_id`, `nazwa`, `email`, `haslo`, `admin`) VALUES
(1, 'greg', 'g@mail.com', '$2y$10$db1GGBnfmrZ5vionq3210uWdht80cmPqEsX79HFbeNgctFerP3HdK', 1),
(17, 'the bronze way', 'w@g', '$2y$10$nFyWA8r0TfS0Fd4DP4pY3u1vInK7iNgQ8dicNy//BMvao8IVdvhdG', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

DROP TABLE IF EXISTS `koszyk`;
CREATE TABLE `koszyk` (
  `ilosc` int(11) NOT NULL,
  `konto_id` int(11) NOT NULL,
  `produkt_id` int(11) NOT NULL,
  `main` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `koszyk`
--

INSERT INTO `koszyk` (`ilosc`, `konto_id`, `produkt_id`, `main`) VALUES
(5, 1, 2, 26),
(4, 1, 14, 27),
(2, 1, 10, 28),
(4, 1, 2, 29),
(2, 1, 10, 30);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

DROP TABLE IF EXISTS `produkt`;
CREATE TABLE `produkt` (
  `produkt_id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena` decimal(12,2) UNSIGNED NOT NULL,
  `cala_cena` decimal(15,2) UNSIGNED NOT NULL,
  `ilosc` int(11) UNSIGNED NOT NULL,
  `img_id` int(11) DEFAULT NULL,
  `promocja` decimal(5,0) UNSIGNED NOT NULL,
  `opis` text NOT NULL,
  `kategoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `nazwa`, `cena`, `cala_cena`, `ilosc`, `img_id`, `promocja`, `opis`, `kategoria_id`) VALUES
(2, 'sofa', '10.20', '9.18', 1998, 21, '10', 'spunk', 1),
(4, 'krzesło drewniane', '2137.00', '2137.00', 3, 6, '0', 'to jest krzesło zrobione z drewna', 1),
(5, 'stół kuchennny', '1000.00', '1000.00', 10, 20, '0', 'stól do kuchni', 1),
(6, 'kwiatek', '5.00', '5.00', 100, 19, '0', 'jest to 1 kiwatek który wygląda stosunkowo dobrze', 2),
(7, 'drzewo', '211.00', '211.00', 100, 18, '0', 'to jest drzewo ', 2),
(8, 'grabki', '2.00', '2.00', 5, 17, '0', 'grabią ', 2),
(9, 'kamień', '1.00', '1.00', 100, 16, '0', 'to jest kamien do rekreacji', 3),
(10, 'koń', '1820.00', '1820.00', 198, 15, '0', 'wielenda', 3),
(11, 'tomasz', '10.00', '10.00', 0, NULL, '0', 'zgodził sie na to', 3),
(12, 'toster', '100.00', '100.00', 96, 14, '0', 'tosty robi', 1),
(13, 'kuchenka gazowa', '260.00', '260.00', 10, 13, '0', 'sehr gut schweis', 1),
(14, 'ziemianki', '1.00', '1.00', 96, 12, '0', 'ciekawie wyglądające ziemniaki', 2),
(15, 'ziemia', '100.00', '100.00', 1000, 11, '0', 'jest to kg ziemi', 2),
(16, 'audi 80', '1000.00', '1000.00', 1, 8, '0', 'nie działa. ładnie wygląda. można naprawić', 3),
(17, 'skakanka', '12.50', '12.50', 100, 10, '0', 'możesz skakać', 3);

--
-- Wyzwalacze `produkt`
--
DROP TRIGGER IF EXISTS `cena i promocja`;
DELIMITER $$
CREATE TRIGGER `cena i promocja` BEFORE UPDATE ON `produkt` FOR EACH ROW BEGIN
IF (new.cena != old.cena) OR (new.promocja != old.promocja)THEN SET new.cala_cena = new.cena - ((new.promocja/100)*new.cena);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamuwienia`
--

DROP TABLE IF EXISTS `zamuwienia`;
CREATE TABLE `zamuwienia` (
  `zamuwienie_id` int(11) NOT NULL,
  `produkt_id` int(11) NOT NULL,
  `ilosc` int(10) UNSIGNED NOT NULL,
  `main` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamuwienia`
--

INSERT INTO `zamuwienia` (`zamuwienie_id`, `produkt_id`, `ilosc`, `main`) VALUES
(18, 2, 2, 15),
(18, 4, 2, 16),
(20, 12, 4, 17),
(23, 2, 2, 18),
(23, 14, 4, 19),
(23, 10, 2, 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamuwienie`
--

DROP TABLE IF EXISTS `zamuwienie`;
CREATE TABLE `zamuwienie` (
  `zamuwienie_id` int(11) NOT NULL,
  `konto_id` int(11) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `adres` varchar(100) NOT NULL,
  `metoda_platnosci` varchar(50) NOT NULL,
  `metoda_dostawy` varchar(50) NOT NULL,
  `status` enum('przygotowywany','wysłany','odebrane') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamuwienie`
--

INSERT INTO `zamuwienie` (`zamuwienie_id`, `konto_id`, `imie`, `adres`, `metoda_platnosci`, `metoda_dostawy`, `status`) VALUES
(18, 17, 'lebron', 'lebron way', 'karta', 'teleporter', 'przygotowywany'),
(20, 1, 'greg', 'miejsce 2', 'przelew', 'paczkomat', 'przygotowywany'),
(23, 1, 'gorge ', 'tak', 'przelew', 'teleporter', 'przygotowywany');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`img_id`);

--
-- Indeksy dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD PRIMARY KEY (`kategoria_id`),
  ADD KEY `img_id` (`img_id`);

--
-- Indeksy dla tabeli `konta`
--
ALTER TABLE `konta`
  ADD PRIMARY KEY (`konto_id`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD PRIMARY KEY (`main`),
  ADD KEY `konto_id` (`konto_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD PRIMARY KEY (`produkt_id`),
  ADD KEY `kategoria_id` (`kategoria_id`),
  ADD KEY `img_id` (`img_id`);

--
-- Indeksy dla tabeli `zamuwienia`
--
ALTER TABLE `zamuwienia`
  ADD PRIMARY KEY (`main`),
  ADD KEY `zaumienie_id` (`zamuwienie_id`,`produkt_id`),
  ADD KEY `produkt_id` (`produkt_id`);

--
-- Indeksy dla tabeli `zamuwienie`
--
ALTER TABLE `zamuwienie`
  ADD PRIMARY KEY (`zamuwienie_id`),
  ADD KEY `produkt_id` (`konto_id`),
  ADD KEY `konto_id` (`konto_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `img`
--
ALTER TABLE `img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `konto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `main` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `zamuwienia`
--
ALTER TABLE `zamuwienia`
  MODIFY `main` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `zamuwienie`
--
ALTER TABLE `zamuwienie`
  MODIFY `zamuwienie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD CONSTRAINT `kategoria_ibfk_1` FOREIGN KEY (`img_id`) REFERENCES `img` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `koszyk_ibfk_2` FOREIGN KEY (`konto_id`) REFERENCES `konta` (`konto_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `produkt`
--
ALTER TABLE `produkt`
  ADD CONSTRAINT `produkt_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoria` (`kategoria_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`img_id`) REFERENCES `img` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamuwienia`
--
ALTER TABLE `zamuwienia`
  ADD CONSTRAINT `zamuwienia_ibfk_1` FOREIGN KEY (`zamuwienie_id`) REFERENCES `zamuwienie` (`zamuwienie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamuwienia_ibfk_2` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamuwienie`
--
ALTER TABLE `zamuwienie`
  ADD CONSTRAINT `zamuwienie_ibfk_1` FOREIGN KEY (`konto_id`) REFERENCES `konta` (`konto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
