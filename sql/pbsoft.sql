-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Čtvrtek 18. března 2010, 10:35
-- Verze MySQL: 5.1.41
-- Verze PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `pbsoft`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `chat_history`
--

DROP TABLE IF EXISTS `chat_history`;
CREATE TABLE IF NOT EXISTS `chat_history` (
  `sent` int(10) unsigned DEFAULT NULL,
  `room` int(10) unsigned DEFAULT NULL,
  `whisper` int(10) unsigned DEFAULT NULL,
  `author` int(10) unsigned DEFAULT NULL,
  `msg` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `chat_history`
--

INSERT INTO `chat_history` (`sent`, `room`, `whisper`, `author`, `msg`) VALUES
(1267377323, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267377476, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267377487, 1, 0, 1, 'prd mrd'),
(1267377494, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267438239, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(1267438267, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(1267438724, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267438740, 1, 0, 1, 'už sem tu.'),
(1267438800, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267441083, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267441112, 1, 0, 1, 'zavolejte konečně někdo !'),
(1267441421, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(1267441765, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267441781, 1, 0, 1, 'pondělí'),
(1267441804, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267442695, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267442708, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267442797, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267442812, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267447468, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267447482, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267447637, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267447657, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267448201, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267450671, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267450700, 1, 0, 1, 'tak to zkoušim.'),
(1267450720, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267450831, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267450859, 1, 0, 1, 'už to začíná smrdět.'),
(1267450886, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267450903, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267450924, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267450971, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451150, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451171, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267451410, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451428, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267451477, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451499, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267451571, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451580, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267451760, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451776, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267451865, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267451883, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267452168, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267452189, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267452360, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267452401, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267454763, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267454796, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267455174, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267455191, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267455240, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267455548, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267455576, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267455623, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(1267456732, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267456760, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267515149, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267515441, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(1267515522, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267515814, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(1267525806, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267525835, 1, 0, 1, 'tak uvidíme...'),
(1267525855, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267564247, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267564286, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267570568, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267570579, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(1267570707, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267570719, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(1267570753, 1, 0, 1, 'prd mrd'),
(1267570788, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.');

-- --------------------------------------------------------

--
-- Struktura tabulky `chat_rooms`
--

DROP TABLE IF EXISTS `chat_rooms`;
CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) COLLATE utf8_czech_ci NOT NULL,
  `created` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `users` int(10) unsigned NOT NULL,
  `visited` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=4 ;

--
-- Vypisuji data pro tabulku `chat_rooms`
--

INSERT INTO `chat_rooms` (`id`, `name`, `created`, `author`, `users`, `visited`) VALUES
(1, 'Globál', 1266142415, 1, 0, 1267570711),
(2, 'Brutál', 1266142458, 1, 0, 1267294554),
(3, 'Fekál', 1266142477, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `chat_work`
--

DROP TABLE IF EXISTS `chat_work`;
CREATE TABLE IF NOT EXISTS `chat_work` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sent` int(10) unsigned NOT NULL,
  `room` int(10) unsigned DEFAULT NULL,
  `whisper` int(10) unsigned DEFAULT NULL,
  `author` int(10) unsigned NOT NULL,
  `msg` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=320 ;

--
-- Vypisuji data pro tabulku `chat_work`
--

INSERT INTO `chat_work` (`id`, `sent`, `room`, `whisper`, `author`, `msg`) VALUES
(301, 1267455576, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(300, 1267455548, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(313, 1267564286, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(319, 1267570788, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(318, 1267570753, 1, 0, 1, 'prd mrd'),
(317, 1267570719, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(316, 1267570707, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(315, 1267570579, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(302, 1267455623, 1, 0, 0, 'Uživatel ''admin'' se odhlásil.'),
(303, 1267456732, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(304, 1267456760, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(305, 1267515149, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(306, 1267515441, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(307, 1267515522, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(308, 1267515814, 1, 0, 0, 'Uživatel ''admin'' byl vyhozen z důvodu nečinnosti.'),
(309, 1267525806, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(310, 1267525835, 1, 0, 1, 'tak uvidíme...'),
(311, 1267525855, 1, 0, 0, 'Uživatel ''admin'' odešel z místnosti.'),
(312, 1267564247, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.'),
(314, 1267570568, 1, 0, 0, 'Uživatel ''admin'' vešel do místnosti.');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `pass` varchar(32) COLLATE utf8_czech_ci NOT NULL,
  `fullname` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `mail` varchar(64) COLLATE utf8_czech_ci NOT NULL,
  `rights` int(10) unsigned NOT NULL,
  `gender` tinyint(3) unsigned NOT NULL,
  `color` int(10) unsigned NOT NULL,
  `room` int(10) unsigned NOT NULL,
  `activity` int(10) unsigned DEFAULT NULL,
  `pic` varchar(128) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=6 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `fullname`, `mail`, `rights`, `gender`, `color`, `room`, `activity`, `pic`) VALUES
(1, 'admin', 'c3792c84fb35aa24c795b9a3788ae488', 'Petr Blažíček', 'admin@pb-soft.cz', 255, 0, 0, 0, 0, 'cortinarius.gif'),
(2, 'brejle', '9e7e84b0d13f74f736c8e3f72e397531', 'Gustáv Husák', 'gusta@trash.cz', 1, 0, 7, 0, 0, 'husak.png'),
(3, 'veksl', '9e7e84b0d13f74f736c8e3f72e397531', 'Lubomír Štrougal', 'de-stroug@trash.cz', 2, 0, 10, 0, 0, 'strougal.png'),
(4, 'mary', '9e7e84b0d13f74f736c8e3f72e397531', 'Marie Kabrhelová', 'cssz@trash.cz', 1, 1, 6, 0, 0, 'kabrhel.png'),
(5, 'svetak', '9e7e84b0d13f74f736c8e3f72e397531', 'Bohuslav Chňoupek', 'bohus@trash.cz', 1, 0, 4, 0, 0, 'chnoupek.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
