-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 15 Cze 2018, 22:50
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sklep`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hobby`
--

CREATE TABLE IF NOT EXISTS `hobby` (
  `id_hobby` int(11) NOT NULL AUTO_INCREMENT,
  `id_osoby` int(11) NOT NULL,
  `hobby` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_hobby`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=82 ;

--
-- Zrzut danych tabeli `hobby`
--

INSERT INTO `hobby` (`id_hobby`, `id_osoby`, `hobby`) VALUES
(74, 1, 'Film'),
(75, 7, 'Film'),
(76, 7, 'Książka'),
(77, 8, 'Film'),
(78, 9, 'Film'),
(79, 10, 'Film'),
(80, 11, 'Film'),
(81, 12, 'Film');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `towar`
--

CREATE TABLE IF NOT EXISTS `towar` (
  `id_towar` int(11) NOT NULL AUTO_INCREMENT,
  `zdjecie` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `cena_zl` int(11) NOT NULL,
  `cena_gr` int(11) NOT NULL,
  `opis` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id_towar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `towar`
--

INSERT INTO `towar` (`id_towar`, `zdjecie`, `cena_zl`, `cena_gr`, `opis`) VALUES
(1, 'picture/pompa_hamulcowa.jpg', 100, 30, 'Pompa hamulcowa SAFIM'),
(2, 'picture/akumulator.jpg', 200, 10, 'Akumulator SAIP 0,75L'),
(3, 'picture/akumulator.jpg', 201, 14, 'Akumulator SAIP 0,35L'),
(4, 'picture/zasilacz.jpg', 1015, 50, 'Zasilacz hydrauliczny 24VDC'),
(5, 'picture/pompa.jpg', 211, 14, 'Pompa hydrauliczna 14cm3'),
(6, 'picture/zawor.jpg', 100, 10, 'Zawór hydrauliczny 6/2 12VDC');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `education` text COLLATE utf8_polish_ci NOT NULL,
  `street` text COLLATE utf8_polish_ci NOT NULL,
  `number` text COLLATE utf8_polish_ci NOT NULL,
  `kod` text COLLATE utf8_polish_ci NOT NULL,
  `city` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `password`, `email`, `education`, `street`, `number`, `kod`, `city`) VALUES
(1, 'Jacek', 'Kowalski1szww', 'login1', '$2y$10$BoXkDGDnFu7h9OPd6uVRNeAI.5WvBA7hOR6Gpu4Ez9fuFNpKggLo2', 'jan@wp.pl', 'średnie', 'Wilcza', '12', '03-256', 'Warszawa'),
(7, 'Paweł', 'Gaweł', 'loczko', 'qwefrdcre', 'qwery@wp.pl', 'podstawowe', 'zwola', '13', '03-456', 'Warszawa'),
(8, 'admin', 'admin', 'admin', '$2y$10$pdfksikw8AZY8mkY80yOR.XTiigwpXIsZRAsTDKcxMCby.A/GrtoS', 'admin@admin.pl', 'podstawowe', 'admin', 'admin', '00-000', 'admin'),
(9, 'jlkj', 'kljkljk', 'jhkjhkj', '$2y$10$xMHAunhgnWXLnfQfbKgTYeA7yGi5EH2RXa5/BnIOIf1MH/ev5vxLO', 'jbkjb@wp.pl', 'podstawowe', 'jkhkjhjkh', 'jkhkj', '02-100', 'jkhkjkh'),
(10, 'Paweł', 'Kulczyk', 'kulczyk1981', '$2y$10$hCSCzCjJBqslibUR.c0bv.JhfekbK8cKNhw8Ui18HrheMcjeQjBdm', 'kulczyk@kulczyk.pl', 'podstawowe', 'Wolna', '13', '23-100', 'Poznań'),
(11, 'Kamil', 'Godlewski', 'kamil1985', '$2y$10$LIVbPpkALtwszlfKJK.8AePwGWpU1vKUG0AiNp0yjB//LjIs6D9Pq', 'kamil@kamil.pl', 'podstawowe', 'krucza', '13', '03-256', 'Warszawa'),
(12, 'Karol', 'Lubecki', 'lubas', '$2y$10$0yAT6i5uzRqg6GGnQLhMKOMsnfUPPyZq60hoUZQ8oP0JUegG1ekpS', 'lubas@wp.pl', 'podstawowe', 'Mała', '13/124', '12-400', 'Łódź');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
