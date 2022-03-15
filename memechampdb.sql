-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2022 at 07:34 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memechampdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pfp` varchar(255) DEFAULT NULL,
  `current_poggers` int(11) NOT NULL DEFAULT 10,
  `max_poggers` int(11) NOT NULL DEFAULT 10,
  `isBanned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `pfp`, `current_poggers`, `max_poggers`, `isBanned`, `created_at`) VALUES
(1, 'test', 'test@test.com', 'test', NULL, 10, 10, 0, '2022-03-15'),
(3, 'test1', 'test1@test.com', 'test', NULL, 10, 10, 0, '2022-03-15'),
(4, 'test2', 'test2@test.com', 'test', NULL, 10, 10, 0, '2022-03-15'),
(5, 'test3', 'test3@test.com', 'test', NULL, 10, 10, 0, '2022-03-15'),
(6, 'test4', 'test4@test.com', 'test', NULL, 10, 10, 0, '2022-03-15'),
(7, 'test5', 'test5@test.com', 'test', NULL, 10, 10, 0, '2022-03-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_uq` (`email`),
  ADD UNIQUE KEY `username_uq` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
