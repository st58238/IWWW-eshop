-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2020 at 01:38 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwww-eshop`
--
CREATE DATABASE IF NOT EXISTS `iwww-eshop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `iwww-eshop`;

-- --------------------------------------------------------

--
-- Table structure for table `objednavka`
--

CREATE TABLE `objednavka` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cas_objednani` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `objednavka`
--

INSERT INTO `objednavka` (`id`, `user_id`, `cas_objednani`) VALUES
(201115498, 1, '2020-11-15 22:36:13'),
(201118362, 1, '2020-11-18 12:31:12'),
(201118468, 2, '2020-11-18 12:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `polozka`
--

CREATE TABLE `polozka` (
  `id` int(11) NOT NULL,
  `objednavka_id` int(11) NOT NULL,
  `zbozi_id` int(11) NOT NULL,
  `pocet` int(11) NOT NULL,
  `cena_za_kus` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `polozka`
--

INSERT INTO `polozka` (`id`, `objednavka_id`, `zbozi_id`, `pocet`, `cena_za_kus`) VALUES
(1, 201115498, 5, 3, 109.99),
(2, 201115498, 2, 1, 39),
(3, 201115498, 7, 3, 64.99),
(4, 201118362, 1, 3, 29),
(5, 201118362, 5, 6, 109.99),
(6, 201118468, 2, 5, 39),
(7, 201118468, 4, 2, 19),
(8, 201118468, 5, 7, 109.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(63) NOT NULL,
  `password` char(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `role`) VALUES
(1, 'admin', '$2y$13$M1qGMSs88ECgpk9SdHLak.t0l/S9gk9L7pQd/QKe3GEB3eRVWR..e', 'admin@iwww.example.com', 100),
(2, 'test', '$2y$13$9shQWb7A80gfDQF98KASueYllQG4JY4QLWFLoqekCa3WjN4Qnd.Eq', 'test@example.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `zbozi`
--

CREATE TABLE `zbozi` (
  `id` int(11) NOT NULL,
  `name` varchar(63) NOT NULL,
  `img` varchar(63) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zbozi`
--

INSERT INTO `zbozi` (`id`, `name`, `img`, `price`) VALUES
(1, 'Banán', '&#127820', 29),
(2, 'Jablko', '&#127823', 39),
(3, 'Vodní meloun', '&#127817', 59),
(4, 'Brambora', '&#129364', 19),
(5, 'Kokosový ořech', '&#129381', 109.99),
(7, 'Mango', '&#129389', 64.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `objednavka`
--
ALTER TABLE `objednavka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `polozka`
--
ALTER TABLE `polozka`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objednavka_id` (`objednavka_id`),
  ADD KEY `zbozi_id` (`zbozi_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zbozi`
--
ALTER TABLE `zbozi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `objednavka`
--
ALTER TABLE `objednavka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201118469;

--
-- AUTO_INCREMENT for table `polozka`
--
ALTER TABLE `polozka`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zbozi`
--
ALTER TABLE `zbozi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `objednavka`
--
ALTER TABLE `objednavka`
  ADD CONSTRAINT `objednavka_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `polozka`
--
ALTER TABLE `polozka`
  ADD CONSTRAINT `polozka_ibfk_1` FOREIGN KEY (`objednavka_id`) REFERENCES `objednavka` (`id`),
  ADD CONSTRAINT `polozka_ibfk_2` FOREIGN KEY (`zbozi_id`) REFERENCES `zbozi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
