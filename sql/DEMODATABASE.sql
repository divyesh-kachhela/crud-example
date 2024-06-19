-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 18, 2024 at 09:06 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DEMODATABASE`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Category_Name` varchar(100) DEFAULT NULL,
  `Category_Status` varchar(10) DEFAULT NULL CHECK (`Category_Status` in ('active','inactive')),
  `Category_Image` varchar(250) DEFAULT NULL,
  `Created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `Ordering`, `Category_Name`, `Category_Status`, `Category_Image`, `Created_at`, `Updated_at`) VALUES
(18, 11, 'electronics & Gadgets', 'active', 'images/category_images/Free Vector _ Circuit board isometric concept.jpeg', '2024-05-29 08:40:19', '2024-06-17 11:08:35'),
(19, 2, 'sports', 'active', 'images/category_images/Sports.jpeg', '2024-05-29 08:53:27', '2024-06-17 11:09:12'),
(20, 3, 'home appliances', 'active', 'images/category_images/homeAppliances.jpeg', '2024-05-29 08:55:58', '2024-06-17 11:09:32'),
(21, 4, 'fitness & yoga', 'active', 'images/category_images/Consumer Hobby Working Out.jpeg', '2024-05-29 09:06:27', '2024-06-17 11:09:44'),
(22, 5, 'automotive parts and accessories', 'active', 'images/category_images/Car service illustration_ Auto.jpeg', '2024-05-29 09:12:41', '2024-06-17 11:09:53'),
(23, 6, 'clothing and apparel', 'active', 'images/category_images/clothing-and-apparel.jpeg', '2024-05-29 09:19:52', '2024-06-17 11:10:01'),
(24, 7, 'gardening and outdoor living', 'active', 'images/category_images/gardening-outdoor-living.jpeg', '2024-05-29 09:28:11', '2024-06-17 11:10:09'),
(25, 8, 'pet supplies', 'active', 'images/category_images/Premium Vector _ Food for pet_ dog bowl and package.jpeg', '2024-05-29 09:33:44', '2024-06-17 11:10:15'),
(26, 8, 'art and craft supplies', 'inactive', 'images/category_images/Brushes with Paint and Bucket Stock Vector - Illustration of background, container_ 5488037.jpeg', '2024-05-29 09:36:32', '2024-06-17 11:10:21'),
(27, 9, 'home decor', 'active', 'images/category_images/Premium Vector _ Home interior background for video conferencing.jpeg', '2024-05-29 09:40:10', '2024-06-17 11:10:27'),
(28, 10, 'school and office stationery', 'inactive', 'images/category_images/Premium Photo _ Colorful school supplies.jpeg', '2024-05-29 09:52:09', '2024-06-17 11:10:32'),
(29, 11, 'toys & games', 'active', 'images/category_images/Sweet dreams, King Luke - childrens book.jpeg', '2024-05-29 10:49:30', '2024-06-17 11:10:38'),
(30, 12, 'tools and utility', 'inactive', 'images/category_images/System Preferences MacOS icon.jpeg', '2024-05-29 10:55:22', '2024-06-17 11:11:23'),
(31, 14, 'furniture', 'active', 'images/category_images/Download Carpenter, repairman with saw and tools_ professionals teamwork.jpg', '2024-05-30 08:13:36', '2024-06-17 11:11:58');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `ordering`, `product_name`, `product_code`, `price`, `sale_price`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(24, 1, 'LED TV  (43 Inches)', 'prod-LED -7167', '31488.00', '35800.00', 7, 'active', '2024-05-29 11:51:44', '2024-06-12 13:12:00'),
(25, 2, 'mobile (nord CE3)', 'prod-MOBI-5825', '18999.00', '21999.00', 18, 'active', '2024-05-29 12:05:28', '2024-06-10 11:09:49'),
(26, 3, 'Mini Monster Trucks', 'prod-MINI-3592', '899.00', '1350.00', 22, 'active', '2024-05-29 12:08:44', '2024-05-29 12:08:44'),
(27, 4, 'Tshirt (round nack)', 'prod-TSHI-3359', '999.00', '1499.00', 32, 'active', '2024-05-29 12:17:02', '2024-05-29 12:17:02'),
(29, 6, 'headphone (wireless )', 'prod-HEAD-8776', '1699.00', '1999.00', 65, 'active', '2024-05-29 12:28:25', '2024-05-29 12:28:25'),
(30, 7, 'power bank (20000mAh)', 'prod-POWE-2903', '2700.00', '3250.00', 17, 'inactive', '2024-05-29 12:32:29', '2024-05-29 12:32:29'),
(31, 10, 'LED smart light ( Philips)', 'prod-LED -5552', '7144.00', '9500.00', 14, 'active', '2024-05-29 12:37:17', '2024-05-29 12:37:17'),
(32, 12, 'Biometric Fingerprint Time Attendance Clock', 'prod-BIOM-3235', '3999.00', '5999.00', 11, 'inactive', '2024-05-29 12:42:19', '2024-05-29 12:42:19'),
(33, 22, 'printer (canon)', 'prod-PRIN-7636', '5499.00', '7599.00', 15, 'inactive', '2024-05-29 13:03:56', '2024-05-29 13:03:56'),
(34, 89, 'stapler', 'prod-STAP-5232', '1549.00', '1750.00', 33, 'active', '2024-05-29 13:07:03', '2024-05-29 13:07:03'),
(35, 19, 'multi-color Ink', 'prod-MULT-6281', '376.00', '450.00', 42, 'active', '2024-05-29 13:12:14', '2024-05-29 13:12:14'),
(36, 99, 'smart watch', 'prod-SMAR-8784', '1650.00', '2000.00', 73, 'active', '2024-05-29 13:16:54', '2024-05-29 13:16:54'),
(37, 55, 'cricket-kid', 'prod-CRIC-7121', '2399.00', '2699.00', 18, 'inactive', '2024-05-29 13:20:50', '2024-05-29 13:20:50'),
(38, 45, 'camera', 'prod-CAME-7668', '152320.00', '170000.00', 3, 'active', '2024-05-30 05:28:45', '2024-05-30 05:28:45'),
(39, 14, 'air conditioner (daikin)', 'prod-AIR -2236', '36000.00', '39000.00', 5, 'active', '2024-05-30 05:33:19', '2024-05-30 05:33:19'),
(40, 52, 'desk light', 'prod-DESK-3129', '899.00', '999.00', 45, 'inactive', '2024-05-30 05:37:48', '2024-05-30 05:37:48'),
(41, 25, 'microwave (Samsung)', 'prod-MICR-3390', '11590.00', '13200.00', 32, 'active', '2024-05-30 06:00:55', '2024-05-30 06:00:55'),
(42, 4, 'tennis racket', 'prod-TENN-3085', '570.00', '710.00', 120, 'active', '2024-05-30 06:04:01', '2024-05-30 06:04:01'),
(43, 165, 'refrigerator', 'prod-REFR-9052', '25999.00', '27800.00', 54, 'active', '2024-05-30 06:07:26', '2024-05-30 06:07:26'),
(44, 51, 'origami paper', 'prod-ORIG-9548', '70.00', '100.00', 320, 'active', '2024-05-30 06:11:19', '2024-05-30 06:11:19'),
(45, 645, 'yoga mat', 'prod-YOGA-7699', '189.00', '249.00', 94, 'inactive', '2024-05-30 06:13:44', '2024-05-30 06:13:44'),
(46, 41, 'engine oil (1ltr)', 'prod-ENGI-4718', '448.00', '550.00', 458, 'active', '2024-05-30 06:16:26', '2024-05-30 06:16:26'),
(47, 15, 'sneaker', 'prod-SNEA-2984', '3685.00', '4000.00', 154, 'active', '2024-05-30 06:19:32', '2024-06-04 13:42:19'),
(52, 9, 'laptop', 'PROD-7258', '39999.00', '45500.00', 7, 'inactive', '2024-06-06 12:11:12', '2024-06-12 13:20:13'),
(59, 5, 'table', 'PROD-4639', '1230.00', '1500.00', 27, 'active', '2024-06-14 11:13:41', '2024-06-17 13:03:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`product_id`, `category_id`) VALUES
(24, 18),
(24, 20),
(25, 18),
(26, 29),
(27, 23),
(29, 18),
(30, 18),
(31, 18),
(31, 20),
(31, 27),
(32, 18),
(32, 28),
(33, 18),
(33, 28),
(34, 28),
(35, 28),
(36, 18),
(36, 19),
(36, 21),
(37, 19),
(38, 18),
(39, 18),
(39, 20),
(40, 18),
(40, 27),
(40, 28),
(41, 18),
(41, 20),
(42, 19),
(42, 29),
(43, 18),
(43, 20),
(44, 26),
(44, 28),
(45, 21),
(46, 22),
(47, 23),
(52, 18),
(59, 27),
(59, 31);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` longtext DEFAULT NULL,
  `is_main_image` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `is_main_image`) VALUES
(85, 24, 'images/product_images/71G3w6wIhZL._SL1500_.jpg', 1),
(86, 24, 'images/product_images/81PecbAxnCL._SL1500_.jpg', 0),
(87, 24, 'images/product_images/71ScK+--VEL._SL1500_.jpg', 0),
(88, 24, 'images/product_images/61iMjFPPkEL._SL1500_.jpg', 0),
(89, 25, 'images/product_images/61abLrCfF7L._SL1500_.jpg', 1),
(90, 25, 'images/product_images/61WJTQBCXqL._SL1500_.jpg', 0),
(91, 25, 'images/product_images/614mpYrPSEL._SL1080_.jpg', 0),
(92, 26, 'images/product_images/51LOCndm-SL.jpg', 1),
(93, 26, 'images/product_images/71sjOStMJIS._SL1000_.jpg', 0),
(94, 26, 'images/product_images/81IMehLxk-L._SL1500_.jpg', 0),
(95, 27, 'images/product_images/61ThK8RnMjL._SL1500_.jpg', 1),
(96, 27, 'images/product_images/41rc7sSLVqL.jpg', 0),
(97, 27, 'images/product_images/518VjFvrKEL._SL1500_.jpg', 0),
(100, 29, 'images/product_images/51iII3p-q-L._SL1200_.jpg', 1),
(101, 29, 'images/product_images/81dIuBdOuVL._SL1200_.jpg', 0),
(102, 29, 'images/product_images/71rxtM6yGOL._SL1200_.jpg', 0),
(103, 29, 'images/product_images/81GhF2dUCxL._SL1200_.jpg', 0),
(104, 30, 'images/product_images/51aKmWrYIbL._SL1200_.jpg', 1),
(105, 30, 'images/product_images/61Ogan9Qw9L._SL1200_.jpg', 0),
(106, 30, 'images/product_images/61OejD7flaL._SL1200_.jpg', 0),
(107, 31, 'images/product_images/61NM9hIawiL._SL1500_.jpg', 1),
(108, 31, 'images/product_images/61MHveihAUL._SL1500_.jpg', 0),
(109, 31, 'images/product_images/71cL7KCwJ-L._SL1500_.jpg', 0),
(110, 32, 'images/product_images/51sDKf2RBvL._SL1000_.jpg', 1),
(112, 32, 'images/product_images/81q78xDo1AL._SL1500_.jpg', 0),
(113, 33, 'images/product_images/71Tl763J68L._SL1500_.jpg', 1),
(114, 33, 'images/product_images/715gKYpFd3L._SL1500_.jpg', 0),
(115, 33, 'images/product_images/61q0zM5u+bL._SL1500_.jpg', 0),
(116, 34, 'images/product_images/61xyIEFxqiL._SL1500_.jpg', 0),
(117, 34, 'images/product_images/81N0bBNjHfL._SL1500_.jpg', 1),
(118, 34, 'images/product_images/71MG0Rq311L._SL1500_.jpg', 0),
(119, 35, 'images/product_images/71ie-02LbBL._SX679_.jpg', 1),
(121, 36, 'images/product_images/61Q0R5cdxWL._SL1500_.jpg', 1),
(122, 36, 'images/product_images/61rMxD0VLXL._SL1500_.jpg', 0),
(123, 36, 'images/product_images/71IryXoTThL._SL1500_.jpg', 0),
(124, 37, 'images/product_images/71wGwi34tSL._SL1500_.jpg', 1),
(125, 37, 'images/product_images/81sbWbLRlCL._SL1500_.jpg', 0),
(126, 37, 'images/product_images/71N7oJlpbJL._SL1500_.jpg', 0),
(127, 38, 'images/product_images/71j3bPnm+UL._SL1500_.jpg', 1),
(128, 38, 'images/product_images/81vQst9IHDL._SL1500_.jpg', 0),
(129, 38, 'images/product_images/71NzRRxpqZL._SL1500_.jpg', 0),
(130, 39, 'images/product_images/61HuUBy7XIL._SL1500_.jpg', 1),
(131, 39, 'images/product_images/81Q+TsaQhZL._SL1500_.jpg', 0),
(132, 39, 'images/product_images/719cSy5X2gL._SL1500_.jpg', 0),
(133, 40, 'images/product_images/71mI4aUUQYL._SL1500_.jpg', 1),
(134, 40, 'images/product_images/71uRNHBNW1L._SL1500_.jpg', 0),
(135, 41, 'images/product_images/71MCCZu4TLL._SL1500_.jpg', 1),
(136, 41, 'images/product_images/81O7DJ-W+iL._SL1500_.jpg', 0),
(137, 41, 'images/product_images/71A6tFu30TL._SL1500_.jpg', 0),
(138, 42, 'images/product_images/61-yTYFKYgS._SL1500_.jpg', 1),
(139, 42, 'images/product_images/71IVZhk6f5S._SL1500_.jpg', 0),
(140, 43, 'images/product_images/61+pdg8CfmL._SL1500_.jpg', 1),
(142, 43, 'images/product_images/61WzTinUjgL._SL1500_.jpg', 0),
(143, 44, 'images/product_images/611ZoTGwzqL._SX679_.jpg', 1),
(144, 44, 'images/product_images/61Od5uvlZOL._SX679_.jpg', 0),
(145, 45, 'images/product_images/71Y5C+puYhL._SL1500_.jpg', 0),
(146, 45, 'images/product_images/71sLpmnLzkL._SL1500_.jpg', 1),
(147, 46, 'images/product_images/71jr7yBbOVL._SL1500_.jpg', 1),
(148, 46, 'images/product_images/71PFkm2gElL._SL1500_.jpg', 0),
(149, 47, 'images/product_images/71chIep9O6L._SL1500_.jpg', 1),
(150, 47, 'images/product_images/61-0TqGig-L._SL1500_.jpg', 0),
(151, 47, 'images/product_images/s.jpg', 0),
(163, 52, 'images/product_images/71oQh8WFlyL._SL1500_.jpg', 1),
(164, 52, 'images/product_images/81POqFUJHhL._SL1500_.jpg', 0),
(165, 52, 'images/product_images/81x4iV5bK0L._SL1500_.jpg', 0),
(166, 52, 'images/product_images/61kOtBfQECL._SL1000_.jpg', 0),
(181, 59, 'images/product_images/81om16UTE4L._SL1500_.jpg', 0),
(182, 59, 'images/product_images/81VxEpVZguL._SL1500_.jpg', 1),
(183, 59, 'images/product_images/81Youyf7ZkL._SL1500_.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'e6e061838856bf47e1de730719fb2609', '2024-04-10 06:03:44', '2024-05-30 06:39:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `Category_Name` (`Category_Name`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
