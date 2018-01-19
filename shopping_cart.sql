-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 19, 2018 at 07:08 AM
-- Server version: 5.6.35
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `shopping_cart`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` varchar(45) NOT NULL,
  `product_sku` varchar(45) NOT NULL,
  `product_color` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `CREATED_AT` varchar(45) NOT NULL,
  `UPDATED_AT` varchar(45) NOT NULL,
  `shipped` varchar(45) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `invoice_number`, `product_sku`, `product_color`, `quantity`, `CREATED_AT`, `UPDATED_AT`, `shipped`) VALUES
(17, 1, '11', '2222', 'Pink', 1, '2017-11-10 17:23:15', '2017-11-10 17:23:15', 'No'),
(18, 4, '12', '2222', 'Pink', 1, '2017-11-12 17:23:15', '2017-11-12 17:23:15', 'No'),
(19, 3, '13', '2222', 'Pink', 1, '2017-11-15 17:53:10', '2017-11-15 17:53:10', 'No'),
(20, 3, '13', '1111', 'Red', 2, '2017-11-15 17:53:10', '2017-11-15 17:53:10', 'No'),
(21, 2, '14', '1111', 'Black', 4, '2017-11-15 17:54:16', '2017-11-15 17:54:16', 'No'),
(22, 2, '14', '2222', 'Pink', 3, '2017-11-15 17:54:16', '2017-11-15 17:54:16', 'No'),
(23, 2, '14', '2222', 'Pink', 3, '2017-11-15 17:54:16', '2017-11-15 17:54:16', 'No'),
(24, 2, '15', '2222', 'Pink', 1, '2017-11-17 17:01:41', '2017-11-17 17:01:41', 'No'),
(25, 2, '15', '1111', 'Red', 1, '2017-11-17 17:01:41', '2017-11-17 17:01:41', 'No'),
(26, 2, '16', '2222', 'Pink', 1, '2017-11-17 17:02:56', '2017-11-17 17:02:56', 'No'),
(27, 2, '16', '1111', 'Red', 1, '2017-11-17 17:02:56', '2017-11-17 17:02:56', 'No'),
(28, 2, '16', '1111', 'Red', 1, '2017-11-17 17:02:56', '2017-11-17 17:02:56', 'No'),
(29, 2, '17', '2222', 'Pink', 5, '2017-11-17 17:05:25', '2017-11-17 17:05:25', 'No'),
(30, 2, '17', '2222', 'Pink', 5, '2017-11-17 17:05:25', '2017-11-17 17:05:25', 'No'),
(31, 2, '18', '2222', 'Pink', 3, '2017-11-17 17:34:06', '2017-11-17 17:34:06', 'No'),
(32, 2, '18', '1111', 'Black', 2, '2017-11-17 17:34:06', '2017-11-17 17:34:06', 'No'),
(33, 2, '18', '1111', 'Red', 3, '2017-11-17 17:34:06', '2017-11-17 17:34:06', 'No'),
(34, 2, '18', '1111', 'Red', 3, '2017-11-17 17:34:06', '2017-11-17 17:34:06', 'No'),
(71, 21, '19', '2222', 'Pink', 1, '2017-11-22 14:12:32', '2017-11-22 14:12:32', 'No'),
(72, 21, '19', '2222', 'Pink', 1, '2017-11-22 14:12:32', '2017-11-22 14:12:32', 'No'),
(73, 51, '20', '2222', 'Pink', 1, '2017-11-22 14:15:35', '2017-11-22 14:15:35', 'No'),
(74, 51, '20', '2222', 'Pink', 1, '2017-11-22 14:15:35', '2017-11-22 14:15:35', 'No'),
(75, 52, '21', '1111', 'Black', 4, '2017-11-22 22:18:34', '2017-11-22 22:18:34', 'No'),
(76, 52, '21', '1111', 'Black', 4, '2017-11-22 22:18:34', '2017-11-22 22:18:34', 'No'),
(77, 53, '22', '1111', 'Black', 4, '2017-11-22 22:54:59', '2017-11-22 22:54:59', 'No'),
(78, 53, '22', '2222', 'Pink', 1, '2017-11-22 22:54:59', '2017-11-22 22:54:59', 'No'),
(79, 53, '22', '2222', 'Pink', 1, '2017-11-22 22:54:59', '2017-11-22 22:54:59', 'No'),
(80, 4, '23', '2222', 'Pink', 1, '2017-11-29 12:07:35', '2017-11-29 12:07:35', 'No'),
(81, 4, '23', '1111', 'Red', 2, '2017-11-29 12:07:35', '2017-11-29 12:07:35', 'No'),
(82, 4, '23', '1111', 'Red', 2, '2017-11-29 12:07:35', '2017-11-29 12:07:35', 'No'),
(83, 2, '', '1111', 'Black', 1, '2017-11-29 17:49:58', '2017-11-29 17:49:58', 'No'),
(84, 2, '', '2222', 'Pink', 3, '2017-11-29 17:49:58', '2017-11-29 17:49:58', 'No'),
(85, 2, '', '2222', 'Pink', 3, '2017-11-29 17:49:58', '2017-11-29 17:49:58', 'No'),
(86, 2, '24', '1111', 'Black', 1, '2017-11-29 17:53:18', '2017-11-29 17:53:18', 'No'),
(87, 2, '24', '2222', 'Pink', 3, '2017-11-29 17:53:18', '2017-11-29 17:53:18', 'No'),
(88, 2, '24', '2222', 'Pink', 3, '2017-11-29 17:53:18', '2017-11-29 17:53:18', 'No'),
(89, 2, '25', '1111', 'Black', 1, '2017-11-29 17:56:17', '2017-11-29 17:56:17', 'No'),
(90, 2, '25', '2222', 'Pink', 3, '2017-11-29 17:56:17', '2017-11-29 17:56:17', 'No'),
(91, 2, '25', '2222', 'Pink', 3, '2017-11-29 17:56:17', '2017-11-29 17:56:17', 'No'),
(92, 2, '26', '1111', 'Black', 1, '2017-11-29 18:01:40', '2017-11-29 18:01:40', 'No'),
(93, 2, '26', '2222', 'Pink', 3, '2017-11-29 18:01:40', '2017-11-29 18:01:40', 'No'),
(94, 2, '26', '2222', 'Pink', 3, '2017-11-29 18:01:40', '2017-11-29 18:01:40', 'No'),
(95, 2, '27', '2222', 'Pink', 1, '2017-11-29 21:38:00', '2017-11-29 21:38:00', 'No'),
(96, 2, '27', '2222', 'Pink', 1, '2017-11-29 21:38:00', '2017-11-29 21:38:00', 'No'),
(97, 53, '28', '4444', 'Blue', 2, '2017-11-30 00:10:15', '2017-11-30 00:10:15', 'No'),
(98, 53, '28', '4444', 'Blue', 2, '2017-11-30 00:10:15', '2017-11-30 00:10:15', 'No'),
(99, 53, '29', '2222', 'Pink', 1, '2017-11-30 00:11:30', '2017-11-30 00:11:30', 'No'),
(100, 53, '29', '2222', 'Pink', 1, '2017-11-30 00:11:30', '2017-11-30 00:11:30', 'No'),
(101, 53, '30', '4444', 'Blue', 2, '2017-11-30 00:16:46', '2017-11-30 00:16:46', 'No'),
(102, 4, '31', '2222', 'Pink', 1, '2017-11-30 14:42:31', '2017-11-30 14:42:31', 'No'),
(103, 4, '31', '3333', 'Default', 2, '2017-11-30 14:42:31', '2017-11-30 14:42:31', 'No'),
(104, 2, '32', '1112', 'Red', 1, '2017-11-30 14:43:56', '2017-11-30 14:43:56', 'No'),
(105, 2, '33', '2222', 'Pink', 1, '2017-11-30 14:44:58', '2017-11-30 14:44:58', 'No'),
(106, 2, '34', '2222', 'Pink', 1, '2017-11-30 14:45:55', '2017-11-30 14:45:55', 'No'),
(107, 2, '35', '2222', 'Pink', 1, '2017-11-30 14:46:37', '2017-11-30 14:46:37', 'No'),
(108, 2, '36', '2222', 'Pink', 1, '2017-11-30 14:48:17', '2017-11-30 14:48:17', 'No'),
(109, 2, '37', '2222', 'Pink', 1, '2017-11-30 14:48:44', '2017-11-30 14:48:44', 'No'),
(110, 2, '38', '2222', 'Pink', 1, '2017-11-30 14:48:47', '2017-11-30 14:48:47', 'No'),
(111, 2, '39', '2222', 'Pink', 1, '2017-11-30 14:48:50', '2017-11-30 14:48:50', 'No'),
(112, 2, '40', '2222', 'Pink', 1, '2017-11-30 14:50:05', '2017-11-30 14:50:05', 'No'),
(113, 2, '41', '2222', 'Pink', 1, '2017-11-30 14:50:10', '2017-11-30 14:50:10', 'No'),
(114, 2, '42', '2222', 'Pink', 1, '2017-11-30 14:50:24', '2017-11-30 14:50:24', 'No'),
(115, 2, '43', '2222', 'Pink', 1, '2017-11-30 14:50:43', '2017-11-30 14:50:43', 'No'),
(116, 2, '44', '2222', 'Pink', 1, '2017-11-30 14:53:08', '2017-11-30 14:53:08', 'No'),
(117, 2, '45', '2222', 'Pink', 1, '2017-11-30 14:54:16', '2017-11-30 14:54:16', 'No'),
(118, 2, '46', '2222', 'Pink', 1, '2017-11-30 14:54:57', '2017-11-30 14:54:57', 'No'),
(119, 2, '47', '2222', 'Pink', 1, '2017-11-30 14:55:34', '2017-11-30 14:55:34', 'No'),
(120, 2, '48', '2222', 'Pink', 1, '2017-11-30 14:56:05', '2017-11-30 14:56:05', 'No'),
(121, 53, '49', '4444', 'Blue', 1, '2017-11-30 15:00:39', '2017-11-30 15:00:39', 'No'),
(122, 1, '50', '4444', 'Blue', 1, '2017-11-30 15:02:37', '2017-11-30 15:02:37', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` text,
  `sku` int(5) NOT NULL,
  `description` text,
  `price` varchar(11) NOT NULL,
  `color` varchar(40) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `img_url` varchar(100) NOT NULL,
  `img_hover` varchar(100) NOT NULL,
  `CREATED_AT` date DEFAULT NULL,
  `UPDATED_AT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `sku`, `description`, `price`, `color`, `quantity`, `img_url`, `img_hover`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'L209', 1111, 'Product1 but in color black', '11.99', 'Black', 10, '/img/staff.jpg', '/img/jordan.jpg', '2017-10-17', '2017-10-17'),
(2, 'Unicorn', 2222, 'Description 2', '19.99', 'Pink', 47, '/img/jordan.jpg', '/img/kanye_west.jpg', '2017-10-17', '2017-11-30'),
(3, 'L209 Red', 1112, 'Product1 but in color red', '11.99', 'Red', 50, '/img/staff.jpg', '/img/jordan.jpg', '2017-10-17', '2017-10-17'),
(4, 'Fast Food', 3333, 'This is Product 3', '19.99', 'Default', 8, '/img/kanye_west.jpg', '/img/jordan.jpg', NULL, NULL),
(5, 'Ice Cream', 4444, 'This is Product 4', '9.99', 'Blue', 2, '', 'img_hover 5', NULL, '2017-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_paypal`
--

CREATE TABLE `transactions_paypal` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `transaction_completed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `guest` varchar(45) NOT NULL DEFAULT 'NO',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `city` varchar(45) NOT NULL,
  `state` varchar(45) NOT NULL,
  `zip_code` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT 'Adgjadgj01',
  `user_level` int(11) NOT NULL DEFAULT '0',
  `CREATED_AT` varchar(45) DEFAULT NULL,
  `UPDATED_AT` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `guest`, `first_name`, `last_name`, `email_address`, `address1`, `address2`, `city`, `state`, `zip_code`, `password`, `user_level`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'NO', 'Eddie', 'Yang', 'eddie@yang.com', 'address1', NULL, 'University Place', 'WA', '98109', 'password', 0, NULL, NULL),
(2, 'NO', 'Paul', 'Kwon', 'paul@kwon.com', '14111 95th AVE', 'APT #2', 'Gig Harbor', 'Washington', '98335', 'password', 1, NULL, '2017-11-30'),
(3, 'NO', 'Jenniferr', 'Oh', 'jennifer@oh.com', '', NULL, 'University Place', '', '', 'password', 0, NULL, NULL),
(4, 'NO', 'David', 'Kwon', 'david@kwon.com', 'hi', NULL, '', '', '', 'password', 0, NULL, NULL),
(11, 'NO', 'Joe', 'Kwon', 'joe@kwon.com', '', NULL, '', '', '', 'password', 0, NULL, NULL),
(12, 'NO', 'Guest', 'Testing', 'guest@testing.com', '', NULL, '', '', '', 'blank', 0, '2017-11-17 16:15:02', '2017-11-17'),
(13, 'NO', 'First', 'Last', 'first@last.com', '', NULL, '', '', '', 'Adgjadgj01', 0, '2017-11-21 00:39:07', '2017-11-21'),
(51, 'yes', 'Joe', 'Kim', 'joe@kim.com', 'New York', '', 'Manhattan', 'NY', '12312', 'Adgjadgj01', 0, '2017-11-22 14:15:35', '2017-11-22'),
(52, 'yes', 'Thomas', 'Kim', 'thomas@kim.com', 'Addy', '', 'Pullman', 'WA', '123455', 'Adgjadgj01', 0, '2017-11-22 22:18:34', '2017-11-22'),
(53, 'NO', 'Samuel', 'Kwon', 'sam@kwon.com', 'Addy', '', 'University Place', 'WA', '123456', 'password', 0, '2017-11-22 22:54:59', '2017-11-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `order_id_2` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;