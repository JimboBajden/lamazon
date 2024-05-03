-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 03 Maj 2024, 20:35
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
(1, 'krzesło_drewniane.jpg'),
(2, 'dom_kategoria.jpg');

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
  `haslo` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `konta`
--

INSERT INTO `konta` (`konto_id`, `nazwa`, `email`, `haslo`, `admin`) VALUES
(1, 'greg', 'g@mail.com', '123', 0),
(10, 'jhon', '', '', 0),
(11, '', '', '', 0),
(12, 'lebron', 'lebnron@mail.com', '123', 0),
(13, 'joe', 'mai@g.co', 'biden', 0),
(14, 'test', 'a@m.c', '123', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `ilosc` int(11) NOT NULL,
  `konto_id` int(11) NOT NULL,
  `produkt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `koszyk`
--

INSERT INTO `koszyk` (`ilosc`, `konto_id`, `produkt_id`) VALUES
(5, 10, 1),
(2, 10, 2),
(2, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkt`
--

CREATE TABLE `produkt` (
  `produkt_id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `cena` decimal(12,2) NOT NULL,
  `cala_cena` decimal(15,2) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `img_id` int(11) DEFAULT NULL,
  `promocja` decimal(5,0) DEFAULT NULL,
  `opis` text NOT NULL,
  `kategoria_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `produkt`
--

INSERT INTO `produkt` (`produkt_id`, `nazwa`, `cena`, `cala_cena`, `ilosc`, `img_id`, `promocja`, `opis`, `kategoria_id`) VALUES
(1, 'krzesło drewniane ', '2137.00', '1816.00', 12, 1, '15', 'krzesło które jest zrobione z drewna', 1),
(2, 'testowy produkt', '14.25', '14.25', 15, NULL, '0', 'produkt do testó', 1);

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
  `ilosc` int(11) NOT NULL,
  `konto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamuwienia`
--

INSERT INTO `zamuwienia` (`zamuwienie_id`, `produkt_id`, `ilosc`, `konto_id`) VALUES
(1, 1, 5, 1),
(1, 2, 2, 1);

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
  ADD KEY `produkt_id` (`produkt_id`,`konto_id`),
  ADD KEY `konto_id` (`konto_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `img`
--
ALTER TABLE `img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT dla tabeli `produkt`
--
ALTER TABLE `produkt`
  MODIFY `produkt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `kategoria`
--
ALTER TABLE `kategoria`
  ADD CONSTRAINT `kategoria_ibfk_1` FOREIGN KEY (`img_id`) REFERENCES `img` (`img_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `produkt_ibfk_2` FOREIGN KEY (`img_id`) REFERENCES `img` (`img_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `zamuwienia`
--
ALTER TABLE `zamuwienia`
  ADD CONSTRAINT `zamuwienia_ibfk_1` FOREIGN KEY (`produkt_id`) REFERENCES `produkt` (`produkt_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamuwienia_ibfk_2` FOREIGN KEY (`konto_id`) REFERENCES `konta` (`konto_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
