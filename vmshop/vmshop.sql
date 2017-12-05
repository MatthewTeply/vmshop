-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Úte 05. pro 2017, 15:04
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
(4, 34, 'ÄŒekÃ¡m na softy', 'TestovÃ½ uÅ¾ivatel', '2017-12-01'),
(5, 34, 'MusÃ­ bÃ½t do hodiny hotovo', 'Mates', '2017-12-01'),
(6, 39, 'nenÃ­ 500 GB v bazaru', 'Mates', '2017-12-01'),
(9, 34, 'TestovÃ½ dodatek', 'TestovÃ½ uÅ¾ivatel', '2017-12-04');

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
(34, 'Hal 3000', 'ram,hdd,softy,odinstalovat avast', '1,1,1,1', 'TestovÃ½ uÅ¾ivatel', 'MusÃ­ bÃ½t hotovÃ½ dneska!', '2017-12-01', 1, 0),
(39, 'HP Probook 4730s', 'vadnÃ½ disk,vÃ½mÄ›na 500GB,softy', '1,1,1', 'Mates', 'instalace win 7 + update', '2017-12-01', 1, 0),
(63, 'Lenovo Thinkpad', 'ram,hdd', '1,1', 'Mates', '', '2017-12-04', 1, 0),
(79, 'Acer Aspire', 'hdd,ram,softy', '0,0,0', 'TestovÃ½ uÅ¾ivatel', '', '2017-12-04', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `uid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `item_id`, `uid`) VALUES
(10, 'a', 34, 'TestovÃ½ uÅ¾ivatel'),
(28, 'c', 63, 'Mates'),
(31, 'cf', 63, 'Mates'),
(79, 'c', 79, 'TestovÃ½ uÅ¾ivatel');

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
(1, 'Mates', '$2y$10$Y7cOHK71OGXKh6kfQvtiQ.a.yi8/fTbI475Sx1hCQF.xCuL9FZHAe'),
(3, 'TestovÃ½ uÅ¾ivatel', '$2y$10$8hfvLy.SZsh7t0DVeGtR6uFgAhCSi9LgJooDqEYfCJmI.VI7G8gbC');

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
-- Klíče pro tabulku `notifications`
--
ALTER TABLE `notifications`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pro tabulku `computers`
--
ALTER TABLE `computers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT pro tabulku `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
