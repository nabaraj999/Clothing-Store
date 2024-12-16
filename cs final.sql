-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Dec 16, 2024 at 01:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'nabaraj', 'nabarajacharya999@gmail.com', 'BCA', 'hello', '2024-11-29 02:02:18'),
(2, 'nabaraj', 'nabarajacharya999@gmail.com', 'BCA', 'hello', '2024-11-29 02:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Rejected') DEFAULT 'Pending',
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `product_name`, `phone`, `email`, `district`, `address`, `total_amount`, `order_date`, `status`, `quantity`) VALUES
(1, 'user', 'Lightweight Jacket', '9816721688', 'nabarajacharya999@gmail.com', 'Kathmandu', 'kathamndu kamaladi', 280.00, '2024-12-13 19:24:05', 'Accepted', 0),
(2, 'user', 'Lightweight Jacket', '9816721688', 'nabarajacharya999@gmail.com', 'Kathmandu', 'lalitpur chapagaun', 0.00, '0000-00-00 00:00:00', 'Accepted', 2),
(3, 'user', 'Lightweight Jacket', '9816721688', 'nabarajacharya999@gmail.com', 'Kathmandu', 'lalitpur chapagaun', 1.00, '0000-00-00 00:00:00', 'Accepted', 2147483647),
(4, 'user', 'Lightweight Jacket', '976678', 'nabarajacharya999@gmail.com', 'Lalitpur', 'lalitpur chapagaun', 180.00, '2024-12-13 23:29:53', 'Rejected', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `size` enum('XL','XXL','3XL','4XL','5XL') NOT NULL,
  `color` enum('Red','White','Black','Pink','Yellow','Blue','Baby Pink','Sky Blue','Green','Orange') NOT NULL,
  `gender` enum('Men','Women','Both') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount` int(11) DEFAULT 0,
  `front_photo` varchar(255) NOT NULL,
  `back_photo` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `stock`, `size`, `color`, `gender`, `price`, `discount`, `front_photo`, `back_photo`, `created_at`, `description`, `quantity`) VALUES
(2, 'Lightweight Jacket', 6, 'XXL', 'Black', 'Men', 50.00, 10, '../uploads/product-detail-01.jpg', '../uploads/product-detail-02.jpg', '2024-11-10 12:48:22', NULL, 0),
(3, 'Lightweight Jacket', 1, 'XL', 'Red', 'Men', 100.00, 10, '../uploads/my power powerbank.jpg', '../uploads/logo.png', '2024-11-22 06:49:24', NULL, 0),
(4, 'Lightweight Jacket', 0, 'XL', 'Red', 'Men', 50.00, 12, '../uploads/WhatsApp Image 2024-11-05 at 12.22.15_738f24c0.jpg', '../uploads/logo.png', '2024-11-22 08:38:34', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'user', 'nabarajacharya999@gmail.com', '$2y$10$aDGZKabP5AsRpvxFwFztyelEWlf66P8H3gfCTfqPyF44M1BkLk1ia', '2024-11-22 08:21:07', 'user'),
(2, 'admin', 'nepal999@gmail.com', '$2y$10$dmlM6Bk9rlLtQNfosauO.eq/1.iP72lkXzl9TLGm4obKLHrHsYNeW', '2024-11-22 08:38:01', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
