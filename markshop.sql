-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2021 at 08:56 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `markshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(9, 'Gino'),
(10, 'Lele'),
(11, 'Nestle'),
(12, 'Tasty Tom'),
(13, 'Kasapreko'),
(14, 'Nike'),
(15, 'Topman'),
(16, 'Kith'),
(17, 'Lenovo'),
(18, 'hp'),
(19, 'Dell'),
(20, 'Apple'),
(21, 'samsung'),
(22, 'nokia'),
(23, 'nunu'),
(24, 'new look'),
(25, 'M&amp;S');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(1, '[{\"id\":\"5\",\"size\":\"39\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"42\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"42\",\"quantity\":2}]', '2021-02-15 19:27:43', 0, 0),
(2, '[{\"id\":\"3\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-15 19:31:50', 0, 0),
(3, '[{\"id\":\"2\",\"size\":\"42\",\"quantity\":\"1\"},{\"id\":\"14\",\"size\":\"N/A\",\"quantity\":\"1\"}]', '2021-02-16 01:17:05', 1, 0),
(4, '[{\"id\":\"3\",\"size\":\"43\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"42\",\"quantity\":\"1\"},{\"id\":\"1\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-16 01:22:53', 1, 0),
(5, '[{\"id\":\"1\",\"size\":\"42\",\"quantity\":2}]', '2021-02-16 01:32:17', 1, 0),
(6, '[{\"id\":\"5\",\"size\":\"39\",\"quantity\":\"1\"}]', '2021-02-16 01:41:07', 1, 0),
(7, '[{\"id\":\"5\",\"size\":\"39\",\"quantity\":\"1\"}]', '2021-02-16 01:48:46', 1, 0),
(8, '[{\"id\":\"1\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-16 01:59:01', 1, 0),
(9, '[{\"id\":\"1\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-16 02:01:32', 1, 0),
(10, '[{\"id\":\"1\",\"size\":\"43\",\"quantity\":\"1\"}]', '2021-02-16 02:05:55', 1, 0),
(11, '[{\"id\":\"1\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-16 02:15:41', 1, 0),
(12, '[{\"id\":\"1\",\"size\":\"42\",\"quantity\":\"1\"}]', '2021-02-16 02:18:37', 1, 0),
(13, '[{\"id\":\"3\",\"size\":\"42\",\"quantity\":\"1\"},{\"id\":\"14\",\"size\":\"N/A\",\"quantity\":\"1\"},{\"id\":\"2\",\"size\":\"42\",\"quantity\":3},{\"id\":\"1\",\"size\":\"42\",\"quantity\":2}]', '2021-02-17 20:51:45', 1, 0),
(14, '[{\"id\":\"2\",\"size\":\"42\",\"quantity\":\"5\"}]', '2021-02-17 20:54:43', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(28, 'Food Items', 0),
(29, 'Women Fashion', 0),
(30, 'Men Fashion', 0),
(31, 'Boys Fashion', 0),
(32, 'Girls Fashion', 0),
(33, 'Tomato Pastes', 28),
(34, 'Rice', 28),
(35, 'Spices', 28),
(36, 'Milk', 28),
(37, 'Kicks', 30),
(38, 'suit', 30),
(39, 't-shirt', 30),
(40, 'long sleeve', 30),
(41, 'sweater', 30),
(42, 'bags', 29),
(43, 'skirt', 32),
(44, 'kicks', 31),
(45, 't-shirt', 31),
(46, 'suit', 31),
(47, 'shoes', 29),
(48, 'trousers', 29),
(49, 'shoes', 32),
(50, 'tops', 32),
(51, 'Electronics', 0),
(52, 'laptops', 51),
(53, 'phones', 51);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(144) COLLATE utf8_unicode_ci NOT NULL,
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `full_name`, `email`, `profile_image`, `bio`, `password`, `join_date`, `last_login`) VALUES
(1, 'Isaac Kojo Yankson', 'isaacyankson24@yahoo.com', '', '', '$2y$10$RUVvF26NRML1Cft1.YHWWewnP4k1/ybbH0hXJA72sHsHeEgTTSR36', '2018-11-08 17:51:37', '2020-08-20 14:50:01'),
(3, 'Isaac Yankson', 'yankson.kojo@yahoo.com', '', '', '$2y$10$L4WAs3t8U5p.SLtqVHu4oOanOko7knSXBE2pY.o0UeioUgyvLnez6', '2018-11-10 20:23:48', '2021-01-14 09:31:18'),
(4, 'Kojo Lyon', 'isaacyankson@yahoo.com', '/online-mall/images/profile_images/51212bbf60c8832805f6d717b324acd7.png', '', '$2y$10$lQlpxVUt36d7PCJSPoFu8OoNklDZTzBfrEw5.LDdIxRuVkeirAYQ2', '2020-07-01 17:32:35', '2021-01-18 20:52:04'),
(5, 'Joe Asare', 'asarejoe@gmail.com', '', '', '$2y$10$ho0OwvZ4GNVamKOwyzlkOe/SxaZeCBwaf/8tFSCopYKBjATnnbYwW', '2020-12-20 16:53:11', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(1, 4, 'Nike Air Max', '99.99', '120.00', 14, '37', '/online-mall/images/products/0e187d8a68f8605bfd5771366598ca38.jpg', 'Very affordable Nike Air', 1, '42:91:5,43:49:6,44:25:2,45:20:2', 0),
(2, 4, 'Air Jordan 4', '119.99', '200.00', 14, '37', '/online-mall/images/products/66f7ec193e102497fafa831ad3dfe98e.jpg', 'affordable jordan kick', 1, '42:90:2,43:50:2,44:50:2', 0),
(3, 4, 'Pink Topman Suit', '499.99', '540.00', 15, '38', '/online-mall/images/products/b23a4f2de86ca67c56a06b6c49e16755.jpg', 'Neat Topman at affordable price', 1, '42:19:2,43:49:2', 0),
(4, 4, 'Kith shirt', '99.99', '120.00', 16, '40', '/online-mall/images/products/e93f798e81a2a01083e5e25d54736937.jpg', 'Neat long sleeve for you', 0, '42:30:2,43:20:2', 0),
(5, 4, 'Kith Men&#039;s t-shirt', '49.99', '60.00', 16, '39', '/online-mall/images/products/843cc559c3a958a9f4b0ddbc70251f10.jpg', 'Neat t-shirt for you at an affordable price', 1, '39:48:2,40:60:2', 0),
(6, 4, 'Topman long sleeve', '200.00', '249.99', 15, '40', '/online-mall/images/products/092d2b526af23eec1786271900174710.jpg', 'Neat dress', 0, '39:50:3', 0),
(7, 4, 'Kith Men&#039;s Sweater', '49.99', '60.00', 16, '41', '/online-mall/images/products/5839bc0e4c9fe63771c6abf99e8680ea.jpg', 'very affordable sweater', 0, 'small:50:2,medium:60:2,large:60:2,extra large:80:2', 0),
(8, 4, 'Lenovo G50', '2000.00', '2500.00', 17, '52', '/online-mall/images/products/f00e092c4cce502fb9b761c2adaf1bfd.jpg,/online-mall/images/products/fc527dcefaf6035a603ea7e2f9b1e52e.jpg,/online-mall/images/products/2845619e7e71d4b06313a306ca7fbf3a.jpg', 'Very neat laptop', 0, '15.1&quot;:20:2', 0),
(9, 4, 'lele rice (5kg)', '30.00', '35.00', 10, '34', '/online-mall/images/products/3c0c45604daaab915cd4428efe60fae1.png,/online-mall/images/products/f9d904d90fed070cc7f52172c063ef50.jpeg', 'tasty rice', 0, '5kg:200:', 0),
(10, 4, 'Kith Boy&#039;s t-shirt', '49.99', '60.00', 16, '45', '/online-mall/images/products/aa682c91167f157bafe3feb45145b12c.jpg', 'very neat t-shirt', 0, 'small:30:2,medium:20:2', 0),
(11, 4, 'ideal Milk', '3.00', '4.00', 11, '36', '/online-mall/images/products/083c4298ad2b2cbdea4c8bf7ae87330f.jpg,/online-mall/images/products/8406e6bd60f88f677796473cae4fc0ea.jpg,/online-mall/images/products/19930e31c8e5d363af713e18f966ca4d.jpg', 'neat evaporated milk', 0, 'small:200:2', 0),
(12, 4, 'nunu milk', '2.50', '3.00', 23, '36', '/online-mall/images/products/451d48be8a30a1c8f9161e2c365211f9.jpg,/online-mall/images/products/4424aeb8fd90f55a45c1017ac34ac0ea.jpg,/online-mall/images/products/06de1298edf79cb20fb6de44cc004c52.png', 'Tasty evaporated milk', 0, 'small:1000:2', 0),
(13, 4, 'Gino tomato paste', '4.50', '5.00', 9, '33', '/online-mall/images/products/c70c6cd0efae2e740cdfa4e7517f2a22.png', 'tasty tomato paste', 0, 'small:100:2', 0),
(14, 4, 'iphone 12', '9000.00', '10000.00', 20, '53', '/online-mall/images/products/809cf68c3e608c267ec6b2c4ddc31975.png,/online-mall/images/products/d22075d3fe79b283ce4ec4390fc18222.png,/online-mall/images/products/141c6f53aecae6f1eb0458a8d71c29cb.png', '', 1, 'N/A:198:2', 0),
(15, 4, 'Macbook Pro', '5000.00', '7000.00', 20, '52', '/online-mall/images/products/ec71363e61cfde351810904fe17ba05e.png,/online-mall/images/products/12988b15e7a3b22f12eb73e61d93c8ae.jpg,/online-mall/images/products/27e5292e9f1b5d39164b709b6448f2b0.jpg', 'brand new macbooks', 0, '15.1&#039;&#039;:100:2', 0),
(16, 4, 'Macbook Air', '6000.00', '9000.00', 20, '52', '/online-mall/images/products/db8bcc29a3ddc21be52da6c7b1675213.png,/online-mall/images/products/7cc532133d5655e26e39d58c488138ec.png,/online-mall/images/products/dca196e7c14c00c100f7d18394900191.png', 'very neat', 0, '15&#039;&#039;:100:2', 0),
(17, 4, 'iphone 11', '7999.99', '8500.00', 20, '53', '/online-mall/images/products/96799c1879e1e98b7b0d4364481f86b6.png,/online-mall/images/products/9007dd546068edd94b5dd3c8e246ca21.jpg,/online-mall/images/products/e88f817f3beed97927871ac385f2dbad.png', 'best iphone 11 phones', 1, 'N/A:100:2', 0),
(18, 4, 'Samsung Galaxy s10', '2999.99', '3200.00', 21, '53', '/online-mall/images/products/8553455370dcaf3c529f26ca00d4ac1f.jpg,/online-mall/images/products/3c726623d894938ab775ada339ead647.jpg,/online-mall/images/products/c2911073b4a13a7a377ddcbe5f753e0a.jpg', 'samsung galaxy ', 1, 'N/A:100:2', 0),
(19, 4, 'M&amp;S shiny shoe', '49.99', '60.00', 25, '47', '/online-mall/images/products/2415f3a90e0715d1237a56b3cfcf1ff2.jpg', 'very affordable', 1, '39:100:2,40:100:2', 0),
(20, 4, 'M&amp;S blue shoe', '49.99', '60.00', 25, '47', '/online-mall/images/products/9e8221a5937f97f125c52a76b2b89a73.jpg', 'lovely', 1, '39:100:2,40:100:2', 0),
(21, 4, 'new look black', '59.99', '70.00', 24, '47', '/online-mall/images/products/377116b8cc62748c115bd0563f9cba8d.jpg', 'lovely', 0, '39:100:2,40:100:2', 0),
(22, 4, 'ripped jeans', '66.00', '70.00', 25, '48', '/online-mall/images/products/36cea2bbfbf3dbda7fe374ce3ca8bfd3.jpg', 'very neat', 1, '39:100:2', 0),
(23, 4, 'Skinny Jeans', '49.99', '60.00', 25, '48', '/online-mall/images/products/a53e618e3df82fca9b4bcc071991dae5.png', 'affordable', 0, '40:100:2', 0),
(24, 4, 'M&amp;S bag', '99.99', '120.00', 25, '42', '/online-mall/images/products/b56db419060374f97238c5c940a25640.jpg', 'nice bag', 1, '40:100:2', 0),
(25, 4, 'tasty tom jollof mix', '1.00', '1.20', 12, '35', '/online-mall/images/products/b9c91e3967feec2087ff376c0c2255ab.jpg,/online-mall/images/products/693b0e89077889c68a89b4b5e7998446.jpg', 'very tasty', 1, '1kg:200:2', 0),
(26, 4, 'tasty tom 2.2kg', '4.00', '4.20', 12, '33', '/online-mall/images/products/1bd50dfca1a4f7f80c12de7ad64bd98f.jpg', 'tasty', 0, '2.2kg:100:2', 0),
(27, 4, 'Puma', '123.00', '150.00', 15, '37', '/online-mall/images/products/eb4e4141ca3608edb3b9c59d77a71e08.png', 'A cool kick for your perusal', 0, '42:200:150,43:500:400', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reset_passwords`
--

CREATE TABLE `reset_passwords` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(144) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reset_passwords`
--

INSERT INTO `reset_passwords` (`id`, `code`, `email`) VALUES
(1, '16007da52159b9', 'isaacyankson@yahoo.com'),
(2, '16007dabd71702', 'isaacyankson@yahoo.com'),
(3, '16007dcd9b2249', 'yankson.kojo@yahoo.com'),
(4, '16007dcf620399', 'yankson.kojo@yahoo.com'),
(5, '16007dd0eb3071', 'yankson.kojo@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `phone` int(15) NOT NULL,
  `city` varchar(175) NOT NULL,
  `state` varchar(175) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `country` varchar(175) NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `txn_type` varchar(255) NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(144) COLLATE utf8_unicode_ci NOT NULL,
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `permissions` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `profile_image`, `bio`, `password`, `join_date`, `last_login`, `permissions`) VALUES
(1, 'Isaac Kojo Yankson', 'isaacyankson24@gmail.com', '', '', '$2y$10$RUVvF26NRML1Cft1.YHWWewnP4k1/ybbH0hXJA72sHsHeEgTTSR36', '2018-11-08 17:51:37', '2020-08-20 14:50:01', 'admin,editor'),
(3, 'Isaac Yankson', 'yankson.kojo@yahoo.com', '', '', '$2y$10$/zFYHKH4KncEcrfkodHQJOvx9EsPcQQgc7iiLaWr9AwR79YaBexm6', '2018-11-10 20:23:48', '2021-01-14 01:34:31', 'editor'),
(4, 'Kojo Lyon', 'isaacyankson@gmail.com', '/online-mall/images/profile_images/01cc4a1eb876c1723a6de8cbeb467c7b.jpg', 'here we go love', '$2y$10$lQlpxVUt36d7PCJSPoFu8OoNklDZTzBfrEw5.LDdIxRuVkeirAYQ2', '2020-07-01 17:32:35', '2021-03-12 16:30:42', 'admin,editor');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image` varchar(144) COLLATE utf8_unicode_ci NOT NULL,
  `bio` text COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `shop_name` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `full_name`, `email`, `profile_image`, `bio`, `password`, `join_date`, `last_login`, `shop_name`, `verified`) VALUES
(1, 'Isaac Kojo Yankson', 'isaacyankson24@gmail.com', '', '', '$2y$10$RUVvF26NRML1Cft1.YHWWewnP4k1/ybbH0hXJA72sHsHeEgTTSR36', '2018-11-08 17:51:37', '2020-12-24 17:02:51', 'joko', 1),
(3, 'Isaac Yankson', 'yankson.kojo@yahoo.com', '', '', '$2y$10$RUVvF26NRML1Cft1.YHWWewnP4k1/ybbH0hXJA72sHsHeEgTTSR36', '2018-11-10 20:23:48', '2020-12-20 16:55:50', '', 0),
(4, 'Kojo Lyon', 'isaacyankson@yahoo.com', '/online-mall/images/profile_images/4ffe8a9ae4b615a7d6708cb4b7015d7e.png', 'hjk', '$2y$10$jn/bT8hLJJi2ACTY5tyRheD07shjUGrwQYYE5kqyhm2TNmMdZn/xS', '2020-07-01 17:32:35', '2021-01-19 23:18:01', 'Lyon\'s Shop', 1),
(5, 'Joe Asare', 'joeasare@gmail.com', '', '', '$2y$10$u7uUL15rz27hq6coc429puf8cXsO5S66w2HCbD6yR3nuEABoZlXqG', '2020-12-22 23:19:09', '0000-00-00 00:00:00', '', 0),
(6, 'Ezekiel Brown', 'kobenabrown@gmail.com', '', '', '$2y$10$kAPbscFV3f1YNxbU3sPdI.rmXFppVVW5weemcvKrxmZSog3tvfeji', '2020-12-22 23:33:25', '2020-12-25 16:07:33', 'Ransbet', 1),
(7, 'Bismark Tetteh', 'snrasibu22@gmail.com', '', '', '$2y$10$EHnTB8tb7r8V/ID2CArH0eNseukgFfl9qC2lcofb.Uz1F8lOPCZb6', '2020-12-26 19:27:42', '2020-12-26 20:29:18', 'Tetteh&#039;s store', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reset_passwords`
--
ALTER TABLE `reset_passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
