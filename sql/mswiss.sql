-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2018 at 09:44 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.0.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mswiss`
--

-- --------------------------------------------------------

--
-- Table structure for table `john_cart`
--

CREATE TABLE `john_cart` (
  `cart_id` int(40) NOT NULL,
  `product_id` int(40) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_price` double NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_quantity` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(255) NOT NULL,
  `product_url` varchar(500) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `product_price` double NOT NULL,
  `product_image_1` varchar(255) NOT NULL,
  `product_image_2` varchar(255) NOT NULL,
  `product_image_3` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_url`, `product_name`, `product_description`, `product_price`, `product_image_1`, `product_image_2`, `product_image_3`) VALUES
(1, 'nike-vapormax', 'Nike VaporMax', 'With a flexible Flyknit upper placed directly on top of a radically reinvented Air cushioning system, the Nike Air VaporMax defies conventional style and provides an unbelievably light, bouncy and flexible feel.', 199.99, 'product_images/product1.png', 'product_images/product2.png', 'product_images/product3.png'),
(2, 'reebok-flexweave', 'Reebok Flexweave', 'Marry flexibility and durability with the Flexweave Run. With independent nodes that provide multi-directional support, your steps will be cushioned at every ground-foot contact point. You\'re free to move naturally, whether you\'re out on a run or killing it in the gym.', 100, 'product_images/product1.png', 'product_images/product2.png', 'product_images/product3.png'),
(3, 'puma-hybrid-rocket', 'Puma Hybrid Rocket', 'The Hybrid Rocket Runner Mens Running Shoes are designed to help propel you even faster on your daily run. This unique shoe features a state-of-the-art HYBRID midsole with two types of innovative foam: NRGY beads for instant cushion and comfort and IGNITE foam for the ultimate in energy return.', 135.81, 'product_images/product1.png', 'product_images/product2.png', 'product_images/product3.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(255) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_address`, `user_type`, `user_token`) VALUES
(1, 'John', 'john@gmail.com', '$2y$10$GL3JaPwzB5Cb1xkNJy.8Gui70jyE3WjpnRrH3TEPZKM9oTeu3zowm', 'Main Street 34, CA', 'user', '$2y$10$z.T0Nk/i0uCVZwXQtSBAb.saofVZ08lO3wgq2dUraE4kD0OLw5KVm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `john_cart`
--
ALTER TABLE `john_cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `john_cart`
--
ALTER TABLE `john_cart`
  MODIFY `cart_id` int(40) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
