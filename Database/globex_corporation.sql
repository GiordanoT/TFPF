-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 10, 2021 alle 16:14
-- Versione del server: 10.4.19-MariaDB
-- Versione PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `globex_corporation`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `immagine` varchar(255) NOT NULL,
  `sconto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `immagine`, `sconto`) VALUES
(6, 'Calcio', 'image\\categoria\\calcio.jpg', 0),
(7, 'Tennis', 'image\\categoria\\Tennis.jpg', 0),
(8, 'Basket', 'image\\categoria\\basket.jpg', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria_preferita`
--

CREATE TABLE `categoria_preferita` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `id` int(11) NOT NULL,
  `testo` text NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `data_evento`
--

CREATE TABLE `data_evento` (
  `id` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `data` date NOT NULL,
  `ora_inizio` time NOT NULL,
  `ora_fine` time NOT NULL,
  `costo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `data_evento`
--

INSERT INTO `data_evento` (`id`, `id_evento`, `data`, `ora_inizio`, `ora_fine`, `costo`) VALUES
(363, 209, '2021-09-26', '20:45:00', '23:15:00', 45),
(364, 210, '2021-10-03', '15:30:00', '18:00:00', 50),
(365, 211, '2021-10-09', '19:00:00', '21:00:00', 65),
(366, 212, '2021-10-17', '12:30:00', '15:00:00', 70),
(367, 213, '2021-08-01', '16:00:00', '21:00:00', 25),
(368, 214, '2021-06-30', '18:00:00', '23:00:00', 55),
(369, 215, '2021-08-12', '19:00:00', '21:30:00', 120),
(370, 216, '2021-11-06', '17:00:00', '21:00:00', 250),
(371, 217, '2021-08-31', '15:10:00', '17:10:00', 15),
(372, 218, '2023-06-23', '20:45:00', '23:00:00', 220),
(373, 219, '2022-02-05', '19:00:00', '22:00:00', 100),
(374, 219, '2022-02-07', '20:00:00', '22:00:00', 100),
(375, 219, '2022-02-09', '22:00:00', '23:00:00', 100),
(376, 219, '2022-02-11', '20:00:00', '21:00:00', 100),
(377, 219, '2022-02-13', '19:00:00', '21:00:00', 100),
(378, 219, '2022-02-15', '20:00:00', '21:00:00', 100),
(379, 219, '2022-02-17', '19:00:00', '22:00:00', 100),
(380, 220, '2022-01-01', '15:00:00', '20:00:00', 40),
(381, 221, '2021-06-30', '20:10:00', '22:30:00', 40);

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `tipologia` tinyint(1) NOT NULL,
  `posti` int(11) NOT NULL,
  `admin_evento` int(11) NOT NULL,
  `costo` float NOT NULL DEFAULT 0,
  `immagine` varchar(255) NOT NULL,
  `citta` varchar(255) NOT NULL,
  `concluso` tinyint(1) NOT NULL DEFAULT 0,
  `approvato` tinyint(1) NOT NULL DEFAULT 2,
  `sconto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id`, `nome`, `descrizione`, `id_categoria`, `tipologia`, `posti`, `admin_evento`, `costo`, `immagine`, `citta`, `concluso`, `approvato`, `sconto`) VALUES
(209, 'Atalanta - Juve', '1° Giornata di Serie A.', 6, 1, 25000, 22, 45, 'image/evento/atalanta_juve_calcio.jpg', 'Bergamo', 0, 1, 0),
(210, 'Atalanta -Napoli', '2° Giornata di Serie A.', 6, 1, 25000, 22, 50, 'image/evento/atalanta_napoli_calcio.jpg', 'Bergamo', 0, 1, 0),
(211, 'Fiorentina-Atalanta', '3° Giornata di Serie A.', 6, 1, 45000, 22, 65, 'image/evento/fiorentina_atalanta_calcio.jpg', 'Firenze', 0, 1, 0),
(212, 'Aalanta-Roma', '4° Giornata di Serie A.', 6, 1, 25000, 22, 70, 'image/evento/atalanta_roma_calcio.jpg', 'Bergamo', 0, 1, 0),
(213, 'Aukland-Djokovic', 'Evento Amichevole.', 7, 1, 15000, 20, 25, 'image/evento/aukland_djokovic_tennis.jpg', 'Roma', 0, 1, 0),
(214, 'Aukland-Federer', 'Partita del Roland Garros, open di Francia.', 7, 1, 20000, 20, 55, 'image/evento/aukland_federer_tennis.jpg', 'Parigi', 0, 1, 0),
(215, 'Federer-Fognini', 'Partita valida per il torneo di Wimbledon.', 7, 1, 32000, 20, 120, 'image/evento/federer_fognini_tennis.jpg', 'Wimbledon', 0, 1, 0),
(216, 'Djokovic-Nadal', 'Finale del US OPEN.', 7, 1, 28000, 20, 250, 'image/evento/djokovic_nadal_tennis.jpg', 'New York', 0, 1, 0),
(217, 'Fognini-Djokovic', 'Partita Amichevole', 7, 1, 10000, 20, 15, 'image/evento/fognini_djokovic_tennis.jpg', 'Roma', 0, 1, 0),
(218, 'Barcellona-PSG', 'Finale di Champions League 2022/2023.', 6, 1, 85000, 22, 220, 'image/evento/barca_psg_calcio.jpg', 'Milano', 0, 1, 0),
(219, 'Chicago Bulls - San Antonio Spurs', '1° turno dei playoff di NBA.', 8, 1, 40000, 19, 650, 'image/evento/bulls_spurs_basket.jpg', 'Chicago-San Antonio', 0, 1, 0),
(220, 'Virtus Bologna-Lakers', 'Partita di Beneficenza', 8, 1, 20000, 19, 40, 'image/evento/bologna_lakers_basket.jpg', 'Bologna', 0, 1, 0),
(221, 'Olimpia Milano-Virtus Bologna', 'Finale Scudetto Serie A basket.', 8, 1, 20000, 19, 40, 'image/evento/milano_bologna_basket.jpg', 'Milano', 0, 1, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipazione`
--

CREATE TABLE `partecipazione` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `id_data` int(11) NOT NULL,
  `intestatario` varchar(255) NOT NULL,
  `codice` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `preferito`
--

CREATE TABLE `preferito` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_data` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` tinyint(1) NOT NULL DEFAULT 0,
  `immagine` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`id`, `nome`, `cognome`, `email`, `password`, `ruolo`, `immagine`) VALUES
(18, 'Admin', 'Admin', 'admin@admin', '$2y$10$QLQs0h/MA8JQdcl6Kr3YlOgvPcsI9C/rbThQWm9Y9eAxXI9D9EgCm', 1, ''),
(19, 'Davide', 'Palombaro', 'bauhoittannepou-4831@yopmail.com', '$2y$10$Zol2FCBf2op1PhGCkK8ibuh14LXisi25dS3oXdjSYY0aEfPUCh6aC', 0, ''),
(20, 'Gianluca ', 'Di Marzio', 'mezequezare-9955@yopmail.com', '$2y$10$eFApMPc.lJ8AaJ4ItfNaaO2KkEs1XAF3qQusZHeRtFOpei5/a6Me.', 0, ''),
(21, 'Giordano', 'Tinella', 'prittedicralu-3257@yopmail.com', '$2y$10$BiziwSo20nCehglSetusXeiMScUWTXjrGZb6Q3XcLN5aQ/tI8sfLm', 0, ''),
(22, 'Federico', 'Cantoro', 'troffittefoffa-2716@yopmail.com', '$2y$10$04p1t0k8LNvEBOApsq1al.7rSf8prup5M7/hkeniQf8PIBo6JBBEO', 0, '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `categoria_preferita`
--
ALTER TABLE `categoria_preferita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evento` (`id_evento`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `data_evento`
--
ALTER TABLE `data_evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_evento` (`id_evento`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `admin_evento` (`admin_evento`);

--
-- Indici per le tabelle `partecipazione`
--
ALTER TABLE `partecipazione`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_data` (`id_data`);

--
-- Indici per le tabelle `preferito`
--
ALTER TABLE `preferito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_data` (`id_data`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT per la tabella `categoria_preferita`
--
ALTER TABLE `categoria_preferita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT per la tabella `data_evento`
--
ALTER TABLE `data_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=382;

--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT per la tabella `partecipazione`
--
ALTER TABLE `partecipazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT per la tabella `preferito`
--
ALTER TABLE `preferito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT per la tabella `utente`
--
ALTER TABLE `utente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `categoria_preferita`
--
ALTER TABLE `categoria_preferita`
  ADD CONSTRAINT `categoria_preferita_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categoria_preferita_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `data_evento`
--
ALTER TABLE `data_evento`
  ADD CONSTRAINT `data_evento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_ibfk_2` FOREIGN KEY (`admin_evento`) REFERENCES `utente` (`id`);

--
-- Limiti per la tabella `partecipazione`
--
ALTER TABLE `partecipazione`
  ADD CONSTRAINT `partecipazione_ibfk_1` FOREIGN KEY (`id_data`) REFERENCES `data_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partecipazione_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `preferito`
--
ALTER TABLE `preferito`
  ADD CONSTRAINT `preferito_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `utente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `preferito_ibfk_3` FOREIGN KEY (`id_data`) REFERENCES `data_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
