-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 03 Cze 2024, 21:26
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

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `img`
--

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
(7, 'dom_kategoria.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategoria`
--

CREATE TABLE `kategoria` (
  `kategoria_id` int(11) NOT NULL,
  `nazwa` varchar(200) NOT NULL,
  `img_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategoria`
--

INSERT INTO `kategoria` (`kategoria_id`, `nazwa`, `img_id`) VALUES
(1, 'dom', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `konta`
--

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
(1, 'greg', 'g@mail.com', '123', 1),
(10, 'jhon', '', '', 0),
(11, '', '', '', 0),
(12, 'lebron', 'lebron@mail.com', '123', 0),
(13, 'joe', 'mai@g.co', 'biden', 0),
(14, 'test', 'a@m.c', '123', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

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
(2, 10, 2, 2),
(1, 1, 2, 7),
(4, 12, 2, 8),
(2, 12, 4, 9),
(2, 1, 4, 10),
(1, 1, 2, 11),
(1, 1, 4, 12),
(3, 1, 2, 13),
(1, 1, 2, 14),
(1, 1, 4, 15),
(10, 1, 2, 16);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

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
(2, 'testowy produkt', '10.20', '9.18', 2135, NULL, '10', 'spunk', 1),
(4, 'krzesło drewniane', '2137.00', '2137.00', 5, 6, '0', 'to jest krzesło zrobione z drewna', 1);

--
-- Wyzwalacze `produkt`
--
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
(9, 2, 3, 5),
(9, 4, 2, 6),
(11, 2, 1, 7),
(11, 4, 1, 8),
(13, 2, 3, 9),
(14, 2, 3, 10),
(14, 4, 1, 11),
(15, 2, 10, 12),
(16, 2, 2, 13),
(16, 4, 1, 14);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamuwienie`
--

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
(9, 1, 'imie', 'miejsce', 'przelew', 'paczkomat', 'przygotowywany'),
(11, 1, 'lebron', 'the fifth', 'karta', 'teleporter', 'przygotowywany'),
(13, 1, 'qwe', 'swe', 'przelew', 'paczkomat', 'przygotowywany'),
(14, 1, 'gregory', 'lebron', 'przelew', 'kurier', 'przygotowywany'),
(15, 1, 'lebron', 'jhames', 'przelew', 'paczkomat', 'przygotowywany'),
(16, 12, 'lebronJames', 'lebron way', 'karta', 'kurier', 'przygotowywany');

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
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  MODIFY `kategoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `konta`
--
ALTER TABLE `konta`
  MODIFY `konto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  MODIFY `main` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `zamuwienia`
--
ALTER TABLE `zamuwienia`
  MODIFY `main` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `zamuwienie`
--
ALTER TABLE `zamuwienie`
  MODIFY `zamuwienie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
