-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Cze 2019, 07:11
-- Wersja serwera: 10.1.30-MariaDB
-- Wersja PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `sklep`
--

DELIMITER $$
--
-- Procedury
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `dodaj_klienta` (IN `im` VARCHAR(45), IN `naz` VARCHAR(45), IN `tele` INT(9), IN `ema` VARCHAR(45), IN `kod` VARCHAR(6), IN `mia` VARCHAR(45), IN `woje` VARCHAR(45), IN `miej` VARCHAR(45), IN `uli` VARCHAR(45), IN `nrdom` INT, IN `nrmie` INT)  SELECT * FROM users$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admins`
--

CREATE TABLE `admins` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `admin_name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `admin_nazwisko` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `admin_login` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `admin_password` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `admins`
--

INSERT INTO `admins` (`id_admin`, `admin_name`, `admin_nazwisko`, `admin_login`, `admin_password`) VALUES
(1, 'Abdul', 'Nassar', 'abdul_nassar', '$2y$10$8ttK1uLevD3aGZlp7KLcmOpy2ZzzsstYfr9I/iEAw8rYXfxitF2b2'),
(2, 'Tomcio', 'Paluszek', 'tomcio_paluszek', '$2y$10$rzsp2L7HQodua5ZjxNbsk.WPZQVPnE8zXKrLh/y6dSh9w1mE5go8G'),
(3, 'Sebastian', 'Elegacik', 'seba_fabinho', '$2y$10$OWWxXM6d0NEMb63HXQy.LObQrvvaVSZ69/u1rD03sqCmQBVtmp25W');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `id_adres` int(10) UNSIGNED NOT NULL,
  `id_kod` int(10) UNSIGNED NOT NULL,
  `miejscowosc` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `ulica` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `numer_domu` int(11) NOT NULL,
  `numer_mieszkania` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `adresy`
--

INSERT INTO `adresy` (`id_adres`, `id_kod`, `miejscowosc`, `ulica`, `numer_domu`, `numer_mieszkania`) VALUES
(1, 1, 'WrocÅ‚aw', 'ZakopiaÅ„ska', 14, 5),
(2, 2, 'OleÅ›nica', 'Eustachego', 33, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `det_zam`
--

CREATE TABLE `det_zam` (
  `id_zam_pro` int(10) UNSIGNED NOT NULL,
  `id_zamowienia` int(10) UNSIGNED NOT NULL,
  `id_produkt` int(10) UNSIGNED NOT NULL,
  `liczba` int(10) UNSIGNED NOT NULL,
  `wartosc` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `det_zam`
--

INSERT INTO `det_zam` (`id_zam_pro`, `id_zamowienia`, `id_produkt`, `liczba`, `wartosc`) VALUES
(1, 1, 1, 2, 61.8),
(2, 1, 3, 3, 405),
(3, 2, 3, 1, 135),
(4, 2, 1, 2, 61.8),
(5, 3, 2, 5, 299.5),
(6, 3, 1, 1, 30.9),
(7, 4, 1, 3, 92.7),
(8, 5, 2, 41, 2455.9);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawa`
--

CREATE TABLE `dostawa` (
  `id_dostawa` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `dostawa`
--

INSERT INTO `dostawa` (`id_dostawa`, `nazwa`) VALUES
(1, 'DPD'),
(2, 'UPS'),
(3, 'Pocztex'),
(4, 'Poczta Polska');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kat` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id_kat`, `nazwa`) VALUES
(1, 'Akcelerometry'),
(2, 'Czujniki Alarmowe'),
(3, 'Czujniki CiÅ›nienia'),
(4, 'Czujniki DÅºwiÄ™ku'),
(5, 'Czujniki Gazu'),
(6, 'Czujniki Magnetyczne'),
(7, 'Czujniki Nacisku'),
(8, 'Czujniki OdlegÅ‚oÅ›ci'),
(9, 'Czujniki Ruchu');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `kategorie_widok`
-- (See below for the actual view)
--
CREATE TABLE `kategorie_widok` (
`kategoria` varchar(45)
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `klient_info`
-- (See below for the actual view)
--
CREATE TABLE `klient_info` (
`id` int(10) unsigned
,`imie` varchar(45)
,`nazwisko` varchar(45)
,`telefon` int(10) unsigned
,`email` varchar(45)
,`kod_poc` varchar(6)
,`miasto` varchar(45)
,`wojewodztwo` varchar(45)
,`miejscowosc` varchar(45)
,`ulica` varchar(45)
,`nr_domu` int(11)
,`nr_mieszkania` int(11)
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kod_pocztowy`
--

CREATE TABLE `kod_pocztowy` (
  `id_kod` int(10) UNSIGNED NOT NULL,
  `kod_po` varchar(6) COLLATE utf8_polish_ci NOT NULL,
  `miasto` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `wojewodztwo` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kod_pocztowy`
--

INSERT INTO `kod_pocztowy` (`id_kod`, `kod_po`, `miasto`, `wojewodztwo`) VALUES
(1, '50-300', 'WrocÅ‚aw', 'DolnoÅ›lÄ…skie'),
(2, '12-400', 'OleÅ›nica', 'DolnoÅ›lÄ…skie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `kto` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `nazwa` text COLLATE utf8_polish_ci NOT NULL,
  `ilosc` int(11) NOT NULL,
  `cena` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `koszyk`
--

INSERT INTO `koszyk` (`kto`, `id`, `nazwa`, `ilosc`, `cena`) VALUES
(1, 3, 'Czujnik tlenku wÄ™gla (czadu) i temperatury FireAngel CO-9D', 1, 135);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `log_admin`
-- (See below for the actual view)
--
CREATE TABLE `log_admin` (
`login` varchar(45)
,`haslo` varchar(100)
);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `log_klient`
-- (See below for the actual view)
--
CREATE TABLE `log_klient` (
`login` varchar(45)
,`haslo` varchar(100)
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `producenci`
--

CREATE TABLE `producenci` (
  `id_producent` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `producenci`
--

INSERT INTO `producenci` (`id_producent`, `nazwa`) VALUES
(5, ' '),
(2, 'Philips'),
(4, 'Pololu'),
(1, 'Sony'),
(3, 'STM32');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id_produkt` int(10) UNSIGNED NOT NULL,
  `id_kat` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `id_producent` int(10) UNSIGNED DEFAULT NULL,
  `cecha` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `cena` float NOT NULL,
  `obraz` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `stan_magazynowy` int(10) UNSIGNED NOT NULL,
  `opis` longtext COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id_produkt`, `id_kat`, `nazwa`, `id_producent`, `cecha`, `cena`, `obraz`, `stan_magazynowy`, `opis`) VALUES
(1, 1, 'LSM303D 3-osiowy akcelerometr + magnetometr IMU 6DoF I2C/SPI - moduÅ‚ Pololu', 4, 'Pob&oacute;r prÄ…du: 5 mA', 30.9, 'img/produkty/LSM303D.png', 100, 'Czujnik sÅ‚uÅ¼y do wyznaczania przyspieszenia oraz pola magnetycznego. Pomiar tych wielkoÅ›ci umoÅ¼liwiajÄ… 3-osiowy akcelerometr i magnetometr oraz niezbÄ™dne do poprawnego dziaÅ‚ania ukÅ‚adu elementy pasywne. Zintegrowany regulator pozwala zasilaÄ‡ moduÅ‚ dowolnym napiÄ™ciem z zakresu od 2,5 V do 5,5 V.'),
(2, 1, 'Waveshare IMU 10DoF - MPU9255 + BMP280 - 3-osiowy akcelerometr, Å¼yroskop i magnetometr oraz barometr', 1, 'NapiÄ™cie pracy: od 3,3 V do 5,5 V', 59.9, 'img/produkty/IMU10DoF.png', 200, 'Czujnik jest poÅ‚Ä…czeniem 3-osiowego cyfrowego Å¼yroskopu, akcelerometru i kompasu. Pozwala na pomiar przyspieszeÅ„, pola magnetycznego oraz prÄ™dkoÅ›ci kÄ…towej w konfigurowalnych zakresach. Dodatkowo wbudowany barometr pozwala mierzyÄ‡ ciÅ›nienie i dziÄ™ki temu wysokoÅ›Ä‡ nad poziomem morza. ModuÅ‚ komunikuje siÄ™ poprzez magistralÄ™ I2C, zasilany jest napiÄ™ciem 3,3 do 5,5 V.'),
(3, 2, 'Czujnik tlenku wÄ™gla (czadu) i temperatury FireAngel CO-9D', 5, 'Temperatura pracy: od -10 &deg;C do 40 &deg;C', 135, 'img/produkty/FireAngelCO-9D.png', 70, 'Czujnik wykrywajÄ…cy stÄ™Å¼enie tlenku wÄ™gla (czadu -  CO) w powietrzu, posiada wbudowany termometr. Zasilany jest trzema bateriami AA (w zestawie). Stosowany do ostrzegania przed tym, niebezpiecznym dla czÅ‚owieka gazem za pomocÄ… sygnaÅ‚u dÅºwiÄ™kowego. Czujnik posiada wyÅ›wietlacz LCD pokazujÄ…cy stÄ™Å¼enie CO za pomocÄ… wykresu graficznego. Posiada przycisk Test / Reset umoÅ¼liwiajÄ…cy sprawdzenie prawidÅ‚owoÅ›ci dziaÅ‚ania urzÄ…dzenia i wyÅ‚Ä…czenie sygnalizacji alarmowej oraz przycisk, kt&oacute;ry po naciÅ›niÄ™ciu wyÅ›wietli na ekranie najwyÅ¼szy wykryty poziom CO zapisany w pamiÄ™ci czujnika. Po 7 latach od aktywacji, czujnik poinformuje o koniecznoÅ›ci wymiany urzÄ…dzenia.');

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `towar`
-- (See below for the actual view)
--
CREATE TABLE `towar` (
`id` int(10) unsigned
,`kategoria` varchar(45)
,`nazwa` varchar(200)
,`producent` varchar(45)
,`cena` float
,`cecha` varchar(45)
,`obraz` varchar(45)
,`dostepnosc` int(10) unsigned
,`opis` longtext
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `user_imie` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `user_nazwisko` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `user_login` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `user_email` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `id_adres` int(10) UNSIGNED NOT NULL,
  `user_phone` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id_user`, `user_imie`, `user_nazwisko`, `user_login`, `user_password`, `user_email`, `id_adres`, `user_phone`) VALUES
(1, 'Abdul', 'Nassar', 'abdulek', '$2y$10$EA4Mf6B3xy1ZeZcPfYByWupoJBi/LI9/2gdBd..VtOfckvmPYEa.q', 'abdulek@wp.pl', 1, 666000999),
(2, 'BoÅ¼ydar', 'Ivanov', 'bozowporzo', '$2y$10$raJUVL9pSs6VOwFELV5BneQTdfA1msoNNFMGnBjy27ovcT2r8y8uG', 'borzojestwporzo@wp.pl', 2, 511600300);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id_zamowienia` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `kiedy` date NOT NULL,
  `id_dostawa` int(10) UNSIGNED NOT NULL,
  `kwota` float UNSIGNED NOT NULL,
  `status_zam` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id_zamowienia`, `id_user`, `kiedy`, `id_dostawa`, `kwota`, `status_zam`) VALUES
(1, 1, '2019-06-08', 2, 466.8, 2),
(2, 1, '2019-06-09', 1, 196.8, 2),
(3, 1, '2019-06-09', 1, 330.4, 5),
(4, 1, '2019-06-11', 3, 92.7, 3),
(5, 1, '2019-06-11', 4, 2455.9, 4);

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `zamowienie_widok`
-- (See below for the actual view)
--
CREATE TABLE `zamowienie_widok` (
`id_klienta` int(10) unsigned
,`id_zamowienia` int(10) unsigned
,`data_zamowienia` date
,`kurier` varchar(45)
,`wartosc` float unsigned
,`status_zamowienia` int(10) unsigned
);

-- --------------------------------------------------------

--
-- Struktura widoku `kategorie_widok`
--
DROP TABLE IF EXISTS `kategorie_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `kategorie_widok`  AS  select `kategorie`.`nazwa` AS `kategoria` from `kategorie` ;

-- --------------------------------------------------------

--
-- Struktura widoku `klient_info`
--
DROP TABLE IF EXISTS `klient_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `klient_info`  AS  select `u`.`id_user` AS `id`,`u`.`user_imie` AS `imie`,`u`.`user_nazwisko` AS `nazwisko`,`u`.`user_phone` AS `telefon`,`u`.`user_email` AS `email`,`k`.`kod_po` AS `kod_poc`,`k`.`miasto` AS `miasto`,`k`.`wojewodztwo` AS `wojewodztwo`,`a`.`miejscowosc` AS `miejscowosc`,`a`.`ulica` AS `ulica`,`a`.`numer_domu` AS `nr_domu`,`a`.`numer_mieszkania` AS `nr_mieszkania` from ((`users` `u` join `adresy` `a` on((`u`.`id_adres` = `a`.`id_adres`))) join `kod_pocztowy` `k` on((`a`.`id_kod` = `k`.`id_kod`))) ;

-- --------------------------------------------------------

--
-- Struktura widoku `log_admin`
--
DROP TABLE IF EXISTS `log_admin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_admin`  AS  select `admins`.`admin_login` AS `login`,`admins`.`admin_password` AS `haslo` from `admins` ;

-- --------------------------------------------------------

--
-- Struktura widoku `log_klient`
--
DROP TABLE IF EXISTS `log_klient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `log_klient`  AS  select `users`.`user_login` AS `login`,`users`.`user_password` AS `haslo` from `users` ;

-- --------------------------------------------------------

--
-- Struktura widoku `towar`
--
DROP TABLE IF EXISTS `towar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `towar`  AS  select `p`.`id_produkt` AS `id`,`k`.`nazwa` AS `kategoria`,`p`.`nazwa` AS `nazwa`,`l`.`nazwa` AS `producent`,`p`.`cena` AS `cena`,`p`.`cecha` AS `cecha`,`p`.`obraz` AS `obraz`,`p`.`stan_magazynowy` AS `dostepnosc`,`p`.`opis` AS `opis` from ((`produkty` `p` join `kategorie` `k` on((`p`.`id_kat` = `k`.`id_kat`))) join `producenci` `l` on((`p`.`id_producent` = `l`.`id_producent`))) ;

-- --------------------------------------------------------

--
-- Struktura widoku `zamowienie_widok`
--
DROP TABLE IF EXISTS `zamowienie_widok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `zamowienie_widok`  AS  select `u`.`id_user` AS `id_klienta`,`z`.`id_zamowienia` AS `id_zamowienia`,`z`.`kiedy` AS `data_zamowienia`,`k`.`nazwa` AS `kurier`,`z`.`kwota` AS `wartosc`,`z`.`status_zam` AS `status_zamowienia` from ((`zamowienia` `z` join `users` `u` on((`z`.`id_user` = `u`.`id_user`))) join `dostawa` `k` on((`z`.`id_dostawa` = `k`.`id_dostawa`))) ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `login` (`admin_login`);

--
-- Indexes for table `adresy`
--
ALTER TABLE `adresy`
  ADD PRIMARY KEY (`id_adres`),
  ADD KEY `kod` (`id_kod`);

--
-- Indexes for table `det_zam`
--
ALTER TABLE `det_zam`
  ADD PRIMARY KEY (`id_zam_pro`),
  ADD KEY `nr_zamow` (`id_zamowienia`),
  ADD KEY `nr_prod` (`id_produkt`);

--
-- Indexes for table `dostawa`
--
ALTER TABLE `dostawa`
  ADD PRIMARY KEY (`id_dostawa`);

--
-- Indexes for table `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kat`),
  ADD KEY `nazwa` (`nazwa`);

--
-- Indexes for table `kod_pocztowy`
--
ALTER TABLE `kod_pocztowy`
  ADD PRIMARY KEY (`id_kod`);

--
-- Indexes for table `koszyk`
--
ALTER TABLE `koszyk`
  ADD KEY `kto` (`kto`);

--
-- Indexes for table `producenci`
--
ALTER TABLE `producenci`
  ADD PRIMARY KEY (`id_producent`),
  ADD KEY `nazwa` (`nazwa`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id_produkt`),
  ADD KEY `kategoria` (`id_kat`),
  ADD KEY `producent` (`id_producent`),
  ADD KEY `cecha` (`cecha`),
  ADD KEY `cena` (`cena`),
  ADD KEY `dostepnosc` (`stan_magazynowy`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `adres` (`id_adres`),
  ADD KEY `imienazwisko` (`user_imie`,`user_nazwisko`),
  ADD KEY `login` (`user_login`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id_zamowienia`),
  ADD KEY `klient` (`id_user`),
  ADD KEY `data_zam` (`kiedy`),
  ADD KEY `status` (`status_zam`),
  ADD KEY `kurier` (`id_dostawa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `adresy`
--
ALTER TABLE `adresy`
  MODIFY `id_adres` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `det_zam`
--
ALTER TABLE `det_zam`
  MODIFY `id_zam_pro` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `dostawa`
--
ALTER TABLE `dostawa`
  MODIFY `id_dostawa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `kod_pocztowy`
--
ALTER TABLE `kod_pocztowy`
  MODIFY `id_kod` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `producenci`
--
ALTER TABLE `producenci`
  MODIFY `id_producent` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id_produkt` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id_zamowienia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD CONSTRAINT `kod` FOREIGN KEY (`id_kod`) REFERENCES `kod_pocztowy` (`id_kod`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `det_zam`
--
ALTER TABLE `det_zam`
  ADD CONSTRAINT `nr_prod` FOREIGN KEY (`id_produkt`) REFERENCES `produkty` (`id_produkt`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nr_zamow` FOREIGN KEY (`id_zamowienia`) REFERENCES `zamowienia` (`id_zamowienia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `kategoria` FOREIGN KEY (`id_kat`) REFERENCES `kategorie` (`id_kat`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `producent` FOREIGN KEY (`id_producent`) REFERENCES `producenci` (`id_producent`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `adres` FOREIGN KEY (`id_adres`) REFERENCES `adresy` (`id_adres`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ograniczenia dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `klient` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `kurier` FOREIGN KEY (`id_dostawa`) REFERENCES `dostawa` (`id_dostawa`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
