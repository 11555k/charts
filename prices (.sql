-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2025 at 11:15 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `charts`
--

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `id` int(11) NOT NULL,
  `asset` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `asset`, `price`, `updated_at`) VALUES
(1, 'gold', 200.00, '2025-04-23 20:52:30'),
(2, 'gold', 50.00, '2025-04-23 20:52:32'),
(3, 'gold', 500.00, '2025-04-23 20:53:00'),
(4, 'gold', 500.00, '2025-04-23 20:54:39'),
(5, 'gold', 50.00, '2025-04-23 20:54:43'),
(6, 'gold', 100.00, '2025-04-23 21:01:16'),
(7, 'gold', 500.00, '2025-04-23 21:01:38'),
(8, 'silver', 500.00, '2025-04-23 21:01:50'),
(9, 'gold', 200.00, '2025-04-23 21:01:55'),
(10, 'silver', 200.00, '2025-04-23 21:02:11'),
(11, 'egp', 500.00, '2025-04-23 21:02:21'),
(12, 'gold', 300.00, '2025-04-23 21:02:27'),
(13, 'egp', 300.00, '2025-04-23 21:02:42'),
(14, 'gold', 200.00, '2025-04-23 21:10:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
