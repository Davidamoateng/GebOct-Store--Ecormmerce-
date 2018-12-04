-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2018 at 12:52 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `geboct store database`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand`) VALUES
(1, 'Asus'),
(3, 'Lenovo'),
(5, 'HP'),
(7, 'Dell'),
(9, 'MacBook');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Accessories', 0),
(2, 'Computing', 0),
(3, 'Electronics', 0),
(4, 'Mobile Phones', 0),
(5, 'Desktop Computers', 2),
(6, 'Laptop Computers', 2),
(7, 'Printers & Scanners', 2),
(8, 'Monitors & Projectors', 2),
(11, 'Chargers &amp; Adaptors', 1),
(12, 'Sound Systems', 3),
(13, 'Cameras & Videos', 3),
(14, 'Apliances', 3),
(15, 'Lightening', 3),
(16, 'Mouse & Keyboards', 2),
(18, 'Smartphones', 4),
(19, 'Tablets', 4),
(20, 'Smartwatches', 4),
(21, 'Phone Accessories', 4),
(23, 'Computer Accessories', 2),
(24, 'Gadgets', 3),
(34, 'Clothing', 0),
(35, 'T-Shirts', 34),
(36, 'Dresses', 34),
(42, 'Cabes & Connectors', 1),
(43, 'Storage Devices', 1),
(44, 'Bluetooth & Wireless', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `our_price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `models` text NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `our_price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `models`, `deleted`) VALUES
(1, 'Asus Laptop', '559.99', '759.99', 1, '6', '/GebOct Store/images/Asus Laptop.png', 'This laptop is Superb! It has quality graphics and clear sounds. Hurry come get yours before it gets finished.', 1, 'Aspire 2920:8,Envy G27:9,Elite Book:10', 0),
(2, 'Canon Camera', '159.99', '259.99', 1, '13', '/GebOct Store/images/Canon Camera.png', 'This camera makes you see clear pixels. Hurry come and buy it cos we are broke', 1, 'T3 series:27,Phantom A4:19,Pro E10:15', 0),
(3, 'LCD Monitor', '399.99', '599.90', 1, '8', '/GebOct Store/images/Flat Screen.png', 'This monitor has a wide screen and it also display quality pictures for clear visibility. Hurry and come for yours before it gets finished.', 1, 'M1:5,S3:6,Z2:10', 0),
(4, 'iPhone X', '169.99', '199.99', 1, '18', '/GebOct Store/images/SmartPhone.png', 'This a powerful smartphone in town with a low price so come get yours now.', 1, 'i7:30,i8:24,X:19', 0),
(5, 'Video Camera', '289.99', '389.99', 1, '13', '/GebOct Store/images/Canon Video Camera.png', 'This video camera makes you experience quality hd videos. It is a hot cake come buy at a cool price.', 1, 'pixel i90:7,clearfix e8:9,cognito c5:10', 0),
(6, 'HP Laptop', '749.99', '859.99', 1, '6', '/GebOct Store/images/HP 1.png', 'This is one of the latest released hp laptop in town. Come and buy yours quickly before it gets finished.', 1, 'Envy Pro:5,Elitebook:8,G27 Series:4', 0),
(7, 'BT Speaker', '129.99', '189.99', 1, '44', '/GebOct Store/images/Red Bluetooth Speaker.png', 'Experience good music with this bluetooth speaker, it can be connected to your laptop and phones wireless.', 1, 'Red:24,Black:19,Purple:15', 0),
(8, 'Memory Card', '59.99', '89.99', 1, '43', '/GebOct Store/images/Sandisk Memory Card.png', 'If you don\'t have enough memory in your phone, hurry come get this memory card at a very low price', 1, '4Gb:30,8Gb:28,16Gb:21,32Gb:16', 0),
(9, 'Flat Screen T.V', '789.99', '849.99', 1, '24', '/GebOct Store/images/LCD Screen.png', 'Entertain your family and friends with this lcd flat screen television, it is going at a cool price', 1, '12inch:24,21inch:11,32inch:16', 0),
(10, 'Lenovo Laptop', '779.99', '899.99', 1, '6', '/GebOct Store/images/Lenovo 2.png', 'A smart laptop from lenovo going at a cool price, hurry come and get your now.', 1, 'Notebook-1:16,Liveware-8:19,Nexus-E8:21', 0),
(11, 'Pendrive', '79.99', '99.99', 1, '43', '/GebOct Store/images/Transcend Pendrive.png', 'You can share files with friends and families with this pendrive, come get it at acool price.', 0, '2Gb:30,4Gb:26,8Gb:21,16Gb:19,32Gb:16', 0),
(12, 'CCTV Camera', '259.99', '349.99', 1, '13', '/GebOct Store/images/CCTV-Camera.png', 'This cctv camera provides you and your family with absolute security, come and buy it installation is free.', 1, 'Indoor:17,Outdoor:16,Office:18', 0),
(13, 'Music Box', '39.99', '49.99', 1, '44', '/GebOct Store/images/BT Speaker.png', 'Listen to clear sounds with this music box a low price.', 1, 'Red:34,Black:29,Purple:25', 0),
(14, 'USB Cable', '19.99', '29.99', 1, '42', '/GebOct Store/images/USB Cord.png', 'Transfer files from pc to another with this high speed usb cables, it is going at a low price.', 1, 'V3:42,iPhone:34,Android:35,Blackberry:15', 0),
(15, 'Toshiba Laptop', '989.99', '1099.99', 1, '6', '/GebOct Store/images/Toshiba 1.png', 'This toshiba has a high speed processor,large ram size and a wide screen, come get at a cheap price.', 1, 'Smartbook:13,Notebook-3:19', 0),
(16, 'Flashdrive', '69.99', '79.99', 1, '43', '/GebOct Store/images/Sandisk USB.png', 'A huge storage capacity flashdrive going at a cool price, come buy yours quick.', 1, '2Gb:32,4Gb:24,8Gb:22,16Gb:18,32Gb:13', 0),
(17, 'HP Mouse', '4.99', '5.99', 1, '16', '/GebOct Store/images/hp-mouse.png', '', 1, '', 0),
(18, 'Samsung Tablet', '179.99', '219.99', 1, '19', '/GebOct Store/images/Tablet.png', '', 1, '', 0),
(19, 'Card Reader', '2.99', '4.99', 1, '43', '/GebOct Store/images/Card Reader.png', '', 1, '', 0),
(20, 'OTG Cable', '3.99', '5.99', 1, '42', '/GebOct Store/images/OTG Cable.png', '', 1, '', 0),
(25, 'test', '666.99', '777.99', 1, '36', '', 'Try\r\ntry\r\ntry', 0, 'alien:23', 0),
(26, 'Jewelry', '234.99', '444.99', 1, '37', '', 'test\r\ntest\r\ntest', 0, 'Gold:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(175) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Wright Octopos', 'wrightoctopos@geboct.com', '$2y$10$pyuPt5ZCWMV71wCMWzHrq.B5EW4B3zkJ95ArM.EsdzeMUQbVWQc5S', '2018-09-27 21:26:07', '2018-09-27 00:00:00', 'admin,editor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
