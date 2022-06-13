-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 13, 2022 at 07:05 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `bid` int(11) NOT NULL,
  `brand_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`bid`, `brand_name`, `status`) VALUES
(1, 'Samsung', '1'),
(2, 'Hp', '1'),
(4, 'Huawei', '1'),
(10, 'Adobe', '1'),
(11, 'MicroSoft Coperation', '1'),
(12, 'Apple', '1');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cid` int(11) NOT NULL,
  `parent_cat` int(11) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cid`, `parent_cat`, `category_name`, `status`) VALUES
(1, 0, 'Electronics', '1'),
(2, 0, 'Software', '1'),
(3, 0, 'Gadgets', '1'),
(5, 1, 'Mobiles', '1'),
(6, 2, 'Antivirus', '1'),
(7, 2, 'Editing Software', '1'),
(9, 2, 'games', '1'),
(10, 1, 'phones', '1'),
(11, 1, 'televison', '1'),
(12, 3, 'iphone 13', '1'),
(14, 3, 'apple watch', '1'),
(16, 1, 'decoder', '1'),
(21, 1, 'hanset', '1');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_no` int(11) NOT NULL,
  `customer_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `order_date` date NOT NULL,
  `sub_total` double NOT NULL,
  `gst` double NOT NULL,
  `discount` double NOT NULL,
  `net_total` double NOT NULL,
  `paid` double NOT NULL,
  `due` double NOT NULL,
  `payment_type` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_no`, `customer_name`, `order_date`, `sub_total`, `gst`, `discount`, `net_total`, `paid`, `due`, `payment_type`) VALUES
(40, 'bright', '2022-02-22', 250000, 45000, 50000, 245000, 245000, 0, 'Cash'),
(41, 'Doe', '2022-02-22', 140000, 25200, 10000, 155200, 245000, 155200, 'Cash'),
(42, 'Doe', '2022-02-22', 140000, 25200, 10000, 155200, 245000, -89800, 'Cash'),
(43, 'john', '2022-02-22', 250000, 45000, 0, 295000, 0, 295000, 'Cash'),
(48, 'bright', '2022-02-22', 250000, 45000, 0, 295000, 29500, 265500, 'Cash'),
(50, 'john', '2022-02-22', 70000, 12600, 3000, 79600, 79600, 0, 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_no`, `product_name`, `price`, `qty`) VALUES
(13, 40, 'iphone 12', 250000, 1),
(14, 41, 'Samsung Galaxy S8', 70000, 2),
(15, 42, 'Samsung Galaxy S8', 70000, 2),
(16, 43, 'iphone 12', 250000, 1),
(21, 48, 'iphone 12', 250000, 1),
(23, 50, 'Samsung Galaxy S8', 70000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `product_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` double NOT NULL,
  `product_stock` int(11) NOT NULL,
  `added_date` date NOT NULL,
  `p_status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `cid`, `bid`, `product_name`, `product_price`, `product_stock`, `added_date`, `p_status`) VALUES
(1, 5, 1, 'Samsung Galaxy S8', 70000, 1000, '2022-02-21', '1'),
(3, 3, 12, 'iphone 12', 250000, 6, '2022-02-21', '1'),
(4, 3, 12, 'iphone 13pro max', 350000, 5, '2022-02-21', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` enum('Admin','Other') COLLATE utf8_unicode_ci NOT NULL,
  `register_date` date NOT NULL,
  `last_login` datetime NOT NULL,
  `notes` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) VALUES
(1, 'chinaza', 'naza@gmail.com', '$2y$08$i2Y8Q2TGPLeQy8o/pIOLHuTWunBy6wLaNln7p5PEIAGGbHEnMi5MW', 'Admin', '2022-02-12', '2022-02-13 08:02:20', ''),
(2, 'raf', 'raf@gmail.com', '$2y$08$q6RuZ/2Y58tOCsat3Pyy7.OZxpwgZeoHooyCuWsjzjyAiv1zXFDte', 'Admin', '2022-02-12', '2022-02-13 04:02:28', ''),
(3, 'chinaza', 'ada@gmail.com', '$2y$08$2N8b1P22Aumga1adIgeGJOyvprsvbSZ/dKmmaUnbDBeGFR23KNcyu', 'Admin', '2022-02-13', '2022-02-13 10:02:47', ''),
(4, 'john', 'johndoe@gmail.com', '$2y$08$5QyN2YKKmS0tZ2CvTMHaWu0qLJ28h3stZG/S12NRUb65uQDA1qIaS', 'Admin', '2022-02-14', '2022-02-14 00:00:00', ''),
(5, 'chichi', 'chi@gmail.com', '$2y$08$Z8SQFI0QAN8F/JgDm8eVPOIi8zSHfIdIR7dGNUgBNnkfdRLYrNfAG', 'Admin', '2022-02-14', '2022-02-14 00:00:00', ''),
(6, 'james', 'ja@gmail.com', '$2y$08$JpF4yJa81PB6ftwpFlKeCOt2WWV7N/MLUPhaXHF5ki7U.0Rpqi.pC', 'Admin', '2022-02-14', '2022-02-14 00:00:00', ''),
(7, 'joe', 'jo@gmail.com', '$2y$08$y.8.XWrWNvgXYyd9T5aXu.YWH1qUg6lYr18xHzx.0lA7anWAcTD3W', 'Admin', '2022-02-14', '2022-02-22 12:02:40', ''),
(8, 'dummy', 'dummy@gmail.com', '$2y$08$xYRAFcHeowp8ozcoNXrUTu9TzXOzXcwuavmVtiH.bgfHpW4rZ6QnW', 'Admin', '2022-03-23', '2022-03-23 04:03:00', ''),
(9, 'user', 'user@gmail.com', '$2y$08$Lb/QYQkquqUrtpLuC.zeUeMFQuYFFINC/2NCA0zk0V/6lpac9DkIq', '', '2022-04-19', '2022-04-19 03:04:48', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`bid`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_no`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_no` (`invoice_no`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `product_name` (`product_name`),
  ADD KEY `cid` (`cid`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`invoice_no`) REFERENCES `invoice` (`invoice_no`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `categories` (`cid`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`bid`) REFERENCES `brands` (`bid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
