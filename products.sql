-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 07, 2025 at 09:50 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `category`, `image`, `created_at`) VALUES
(1, 'Dog Leash', 'Durable and comfortable leash for daily dog walks.', 14.99, 'Dog', 'images/dog leash.png', '2025-12-02 18:58:10'),
(2, 'Dog Toys', 'Fun chew toys to keep your dog entertained.', 12.49, 'Dog', 'images/dog toys.png', '2025-12-02 18:58:10'),
(3, 'Cat Toys', 'Interactive toys to keep your cat active and playful.', 9.99, 'Cat', 'images/cat toys.png', '2025-12-02 18:58:10'),
(4, 'Dog Food', 'Nutritious dry food for adult dogs.', 24.99, 'Dog', 'images/dog food.png', '2025-12-02 18:58:10'),
(5, 'Cat Food', 'Balanced dry food for healthy cats.', 22.99, 'Cat', 'images/cat food.png', '2025-12-02 18:58:10'),
(6, 'Litter Box', 'Easy-clean litter box for indoor cats.', 29.99, 'Cat', 'images/litterbox.png', '2025-12-02 18:58:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
