-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 07, 2025 at 09:51 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pethavens_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `full_name` varchar(200) DEFAULT NULL,
  `address` text,
  `phone` varchar(50) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(50) DEFAULT 'Completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `payment_method`, `full_name`, `address`, `phone`, `order_date`, `status`) VALUES
(1, 12, 27.48, '', NULL, NULL, NULL, '2025-12-03 22:43:05', 'Completed'),
(2, 12, 29.99, '', NULL, NULL, NULL, '2025-12-03 22:48:44', 'Completed'),
(4, 12, 59.98, '', NULL, NULL, NULL, '2025-12-04 12:51:45', 'Completed'),
(5, 14, 27.48, '', NULL, NULL, NULL, '2025-12-04 13:40:19', 'Completed'),
(6, 14, 24.98, '', 'esther osho', '4901 Hamilton Ave Baltimore Md \r\nUnit B', '2403609774', '2025-12-04 13:48:47', 'Completed'),
(7, 12, 59.96, '', 'esther', '100 west way laurel md 20708', '222355667', '2025-12-04 14:23:21', 'Completed'),
(8, 12, 14.99, '', 'esther osho', '100 west way laurel md 20708', '2224576987', '2025-12-04 14:35:59', 'Completed'),
(12, 15, 49.96, 'Card ending in 0000', 'Seun O', '123 abc way rd laurel md 20707', '000-000-0000', '2025-12-05 06:45:50', 'Completed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
