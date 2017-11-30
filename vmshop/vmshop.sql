-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 30. lis 2017, 17:32
-- Verze serveru: 10.1.19-MariaDB
-- Verze PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `vmshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `content` text,
  `op` text NOT NULL,
  `cdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `addons`
--

INSERT INTO `addons` (`id`, `mid`, `content`, `op`, `cdate`) VALUES
(1, 9, 'Testovy dodatek', 'Mates', '2017-11-30');

-- --------------------------------------------------------

--
-- Struktura tabulky `computers`
--

CREATE TABLE `computers` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `tasks` text NOT NULL,
  `done` text NOT NULL,
  `who` text NOT NULL,
  `comments` text NOT NULL,
  `cdate` date NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `computers`
--

INSERT INTO `computers` (`id`, `name`, `tasks`, `done`, `who`, `comments`, `cdate`, `finished`, `hidden`) VALUES
(7, 'PC Lynx', 'hdd,ram,vyfoukat,odvirovat,zÃ¡lohovat D', '1,1,1,1,1', 'Mates', 'ZÃ¡lohovat data na D pÅ™es acronis', '2017-11-29', 1, 1),
(9, 'Dell PC', 'hdd,ram,odvirovat,softy', '1,1,1,0', 'Mates', 'Nemazat D!', '2017-11-30', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uid` text NOT NULL,
  `pwd` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `uid`, `pwd`) VALUES
(1, 'Mates', '$2y$10$Y7cOHK71OGXKh6kfQvtiQ.a.yi8/fTbI475Sx1hCQF.xCuL9FZHAe');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `computers`
--
ALTER TABLE `computers`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pro tabulku `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
