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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_image` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `created_at`, `profile_image`) VALUES
(2, 'Emily', 'Johnson', 'emjay', 'emily@example.com', 'hashed_password_1', '2025-11-10 03:32:00', NULL),
(3, 'Michael', 'Brown', 'mikeb', 'michael@example.com', 'hashed_password_2', '2025-11-10 03:32:00', NULL),
(4, 'Sophia', 'Davis', 'sophiad', 'sophia@example.com', 'hashed_password_3', '2025-11-10 03:32:00', NULL),
(5, 'James', 'Wilson', 'jaywil', 'james@example.com', 'hashed_password_4', '2025-11-10 03:32:00', NULL),
(6, 'Olivia', 'Moore', 'livmoore', 'olivia@example.com', 'hashed_password_5', '2025-11-10 03:32:00', NULL),
(7, 'Daniel', 'Taylor', 'dantay', 'daniel@example.com', 'hashed_password_6', '2025-11-10 03:32:00', NULL),
(8, 'Ava', 'Anderson', 'avanda', 'ava@example.com', 'hashed_password_7', '2025-11-10 03:32:00', NULL),
(9, 'Ethan', 'Thomas', 'ethant', 'ethan@example.com', 'hashed_password_8', '2025-11-10 03:32:00', NULL),
(10, 'Isabella', 'Martin', 'isam', 'isabella@example.com', 'hashed_password_9', '2025-11-10 03:32:00', NULL),
(11, 'Noah', 'Garcia', 'noahg', 'noah@example.com', 'hashed_password_10', '2025-11-10 03:32:00', NULL),
(12, 'Brianna', 'taylor', 'briannasimon', 'bri@example.com', '$2y$10$rBdv4P6kKR8XegSWKam5HewNl/m6gsw7dZ/QeTpUbjswv1z10yWka', '2025-11-17 04:31:33', '1764918400_PETHAVENS-5.png'),
(13, NULL, NULL, 'ikechukwu19', 'ikechuk@example.com', '$2y$10$q1Xs6YSXzmeKxC1kNIXAqeRcNeS0PpdTJDRORIMWjcBujUXqSijNu', '2025-12-02 00:24:23', NULL),
(14, NULL, NULL, 'EstherOsh', 'esther@example.com', '$2y$10$yqZbKgsfEo5.8Eh37NJQw.LnIQ06Ky9Z4rjF8kDmWTGL34K1/2bhG', '2025-12-04 13:38:24', NULL),
(16, 'Ami', 'lash', 'amilash', 'ami@example.com', '$2y$10$lnB5vycbZEG3tw3KvXjqd.5Nf2XHxfYroDrd2jLW5FGcjnbK6L9ry', '2025-12-05 09:54:35', NULL),
(18, NULL, NULL, 'loladaniels', 'lola@example.com', '$2y$10$B.HSREluqJ7ur/Mw5V/Fmekzfbl.fdTtF9hZUu9z640cHuI3qGoPK', '2025-12-05 17:32:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
