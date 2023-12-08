-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 07:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skidalley_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `userrole` tinyint(4) NOT NULL,
  `avatar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `username`, `password`, `userrole`, `avatar`) VALUES
(23, 'Ian Salgado', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', 1, ''),
(30, 'Full Name', 'staff1', '4d7d719ac0cf3d78ea8a94701913fe47', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_products_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `notification_type` varchar(20) NOT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gcash_receipts_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brand_list`
--

CREATE TABLE `brand_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `image_path` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_list`
--

INSERT INTO `brand_list` (`id`, `name`, `image_path`, `delete_flag`, `status`) VALUES
(31, 'ian', 'path_to_image', 0, 1),
(32, 'salgado', 'path_to_image', 0, 1),
(33, 'edgar', 'path_to_image', 0, 1),
(34, 'ferrari', 'path_to_image', 0, 1),
(35, 'sad', 'path_to_image', 0, 1),
(36, 'Fixie', 'path_to_image', 0, 1),
(37, 'Japs Bike', 'path_to_image', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart_list`
--

CREATE TABLE `cart_list` (
  `id` int(10) NOT NULL,
  `client_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `product_colors_sizes_id` int(30) NOT NULL,
  `color` varchar(250) NOT NULL,
  `size` varchar(250) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `category` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`, `status`, `delete_flag`) VALUES
(19, 'Wheels', '', 1, 0),
(20, 'Chair', '', 1, 0),
(21, 'Accessories', '', 1, 0),
(23, 'Body', '', 1, 0),
(27, 'Breaks', '', 1, 0),
(29, 'Handles', '', 1, 0),
(30, 'Bike Set', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category_brands`
--

CREATE TABLE `category_brands` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_brands`
--

INSERT INTO `category_brands` (`id`, `category_id`, `brand_id`) VALUES
(10, 30, 31),
(11, 29, 34),
(18, 19, 35),
(19, 27, 36),
(20, 27, 37),
(22, 23, 36),
(23, 21, 34),
(24, 20, 31),
(25, 20, 32),
(26, 20, 33);

-- --------------------------------------------------------

--
-- Table structure for table `client_list`
--

CREATE TABLE `client_list` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_list`
--

INSERT INTO `client_list` (`id`, `username`, `fullname`, `contact`, `address`, `email`, `password`, `status`, `delete_flag`) VALUES
(31, 'iansalgado15', 'Ian Salgado', '09161661368', 'Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(32, 'username', 'Ian Salgado', '09161661367', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'iansalgado567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `content_management_aboutus`
--

CREATE TABLE `content_management_aboutus` (
  `id` int(10) NOT NULL,
  `aboutus` text NOT NULL,
  `font` text NOT NULL,
  `text_size` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_management_aboutus`
--

INSERT INTO `content_management_aboutus` (`id`, `aboutus`, `font`, `text_size`) VALUES
(19, '<p style=\"text-align: center;\"><span style=\"font-family: Impact;\">﻿</span><span style=\"background-color: rgb(247, 247, 247);\"><br></span></p><p style=\"text-align: center;\"><span style=\"font-family: Impact; background-color: rgb(247, 247, 247);\" times=\"\" new=\"\" roman\";\"=\"\" roman\";=\"\" background-color:=\"\" rgb(239,=\"\" 239,=\"\" 239);\"=\"\">Welcome to Skid Alley Bike Shop, your premier destination for all things related to biking. With a wide selection of bikes, accessories, and expert advice, we\'re here to make your biking experience exceptional. Whether you\'re a casual rider, a passionate cyclist, or just looking for a new adventure, our knowledgeable team is ready to assist you in finding the perfect bike and gear. Explore our collection and start your biking journey today!</span></p>', 'Arial', 20);

-- --------------------------------------------------------

--
-- Table structure for table `content_management_carousel`
--

CREATE TABLE `content_management_carousel` (
  `id` int(10) NOT NULL,
  `images` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_management_carousel`
--

INSERT INTO `content_management_carousel` (`id`, `images`) VALUES
(8, 'category-650750ff284f2.png'),
(9, 'Carousel-8977.png'),
(10, 'Carousel-8150.png'),
(11, 'Carousel-4296.png');

-- --------------------------------------------------------

--
-- Table structure for table `content_management_contactus`
--

CREATE TABLE `content_management_contactus` (
  `id` int(10) NOT NULL,
  `contactus` text NOT NULL,
  `font` text NOT NULL,
  `text_size` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_management_contactus`
--

INSERT INTO `content_management_contactus` (`id`, `contactus`, `font`, `text_size`) VALUES
(1, '<span style=\"font-family: \" times=\"\" new=\"\" roman\";\"=\"\">Feel free to reach out to us with any questions or concerns. We\'re here to help!\r\n\r\nOur Address:\r\n- 123 Main Street\r\n- Cityville, State 12345\r\n- Country\r\n\r\nPhone Number:\r\n- Main Office: (555) 123-4567\r\n- Customer Support: (555) 987-6543\r\n\r\nEmail:\r\n- General Inquiries: info@example.com\r\n- Support: support@example.com\r\n\r\nYou can also visit our website at www.example.com for more information and online support.</span>', 'Comic Sans MS', 25);

-- --------------------------------------------------------

--
-- Table structure for table `content_management_logo`
--

CREATE TABLE `content_management_logo` (
  `id` int(11) NOT NULL,
  `logo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content_management_logo`
--

INSERT INTO `content_management_logo` (`id`, `logo`) VALUES
(12, 'logo-651d0aecaba59.png');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `product_id`, `brand_id`, `category_id`, `discount_percentage`, `start_time`, `end_time`, `created_at`, `updated_at`) VALUES
(44, 57, NULL, NULL, 23.00, '2023-12-03 01:30:00', '2023-12-07 01:30:00', '2023-12-03 01:30:16', '2023-12-03 01:30:16');

-- --------------------------------------------------------

--
-- Table structure for table `gcash_infos`
--

CREATE TABLE `gcash_infos` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gcash_infos`
--

INSERT INTO `gcash_infos` (`id`, `name`, `number`) VALUES
(19, 'Skid Alley', '12345689123');

-- --------------------------------------------------------

--
-- Table structure for table `gcash_receipts`
--

CREATE TABLE `gcash_receipts` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `approved` tinyint(10) NOT NULL,
  `upload_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `message` text NOT NULL,
  `notification_type` varchar(20) NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `promo_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `notification_type`, `timestamp`, `status`, `is_read`, `promo_id`) VALUES
(8, 29, 'Your order has been placed successfully. Your order reference code is: ORD_20231022172428_29', 'order', '2023-10-22 17:24:28', 'new', 0, 0),
(112, 11, 'Your Order Is Packed and ready for delivery.', 'Packed', '2023-11-17 19:01:49', 'new', 0, 0),
(113, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231120102015_11', 'Order', '2023-11-20 10:20:15', 'new', 0, 0),
(114, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231120102337_11', 'Order', '2023-11-20 10:23:37', 'new', 0, 0),
(115, 11, 'Your Order Is Packed and ready for delivery.', 'Packed', '2023-11-20 10:24:10', 'new', 0, 0),
(116, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231120102605_11', 'Order', '2023-11-20 10:26:05', 'new', 0, 0),
(214, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231203172838_31', 'Order', '2023-12-03 17:28:38', 'new', 1, 0),
(215, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231203173512_31', 'Order', '2023-12-03 17:35:12', 'new', 1, 0),
(216, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231203232516_31', 'Order', '2023-12-03 23:25:16', 'new', 1, 0),
(217, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204005953_31', 'Order', '2023-12-04 00:59:53', 'new', 1, 0),
(218, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204010021_31', 'Order', '2023-12-04 01:00:21', 'new', 1, 0),
(219, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204010045_31', 'Order', '2023-12-04 01:00:45', 'new', 1, 0),
(220, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204010123_31', 'Order', '2023-12-04 01:01:23', 'new', 1, 0),
(221, 31, 'Gcash receipt approved successfully.', 'Gcash Approval', '2023-12-04 01:04:44', 'new', 1, 0),
(222, 31, 'Gcash receipt approved successfully.', 'Gcash Approval', '2023-12-04 01:04:47', 'new', 1, 0),
(223, 31, 'Gcash receipt approved successfully.', 'Gcash Approval', '2023-12-04 01:04:49', 'new', 1, 0),
(224, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204010513_31', 'Order', '2023-12-04 01:05:13', 'new', 1, 0),
(225, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204010753_31', 'Order', '2023-12-04 01:07:53', 'new', 1, 0),
(226, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204011145_31', 'Order', '2023-12-04 01:11:45', 'new', 1, 0),
(227, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204011235_31', 'Order', '2023-12-04 01:12:35', 'new', 1, 0),
(228, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204011303_31', 'Order', '2023-12-04 01:13:03', 'new', 1, 0),
(229, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204011936_31', 'Order', '2023-12-04 01:19:36', 'new', 1, 0),
(232, 31, 'Congratulations! You\'ve earned a voucher. Code: FZRGHEKC', 'Voucher', '2023-12-04 01:23:41', 'new', 0, 0),
(233, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20231204012341_31', 'Order', '2023-12-04 01:23:41', 'new', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(10) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `gcash_receipts_id` int(11) DEFAULT NULL,
  `total_amount` float NOT NULL DEFAULT 0,
  `delivery_address` text NOT NULL,
  `payment_method` varchar(250) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1 = packed, 2 = for delivery, 3 = on the way, 4 = delivered, 5=cancelled',
  `order_receive` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_colors_sizes`
--

CREATE TABLE `product_colors_sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colors_sizes`
--

INSERT INTO `product_colors_sizes` (`id`, `product_id`, `color`, `size`) VALUES
(199, 57, 'pink', 'small'),
(200, 57, 'pink', 'medium'),
(201, 57, 'pink', 'large'),
(202, 57, 'red', 'small'),
(203, 57, 'red', 'medium'),
(204, 57, 'red', 'large');

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `id` int(10) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `models` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `brand_id`, `category_id`, `name`, `models`, `description`, `price`, `status`, `image_path`, `delete_flag`) VALUES
(57, 31, 20, 'aaa', '', 'asdasddddddddd', 123123, 1, 'Bike-Name-5077.png', 0),
(58, 32, 20, 'Lezzgoo', '', 'asdasdas', 123123, 1, 'Bike-Name-2541.png', 0),
(59, 36, 23, 'what', '', '213123', 213123, 1, 'Bike-Name3068.png', 0),
(60, 35, 19, 'vvvvvvvvvvvvvvvvvvvvvvvvvvv', '', 'asdasdasdas', 123123, 1, 'Bike-Name5431.png', 0),
(61, 34, 29, 'bike na pink', '', 'kulay pink', 232323, 1, 'Bike-Name4869.png', 0),
(62, 31, 30, 'Japs Bike', '', 'a1asdasd', 2333, 1, 'Bike-Name9134.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(10) NOT NULL,
  `service` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `service`, `description`, `status`, `delete_flag`) VALUES
(3, 'Vulcanize', 'Tapal Gulong may butas', 1, 0),
(8, 'Fixxxx', 'Loren Ipsum', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_request`
--

CREATE TABLE `service_request` (
  `id` int(10) NOT NULL,
  `client_id` int(30) NOT NULL,
  `service_type` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_list`
--

CREATE TABLE `stock_list` (
  `id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `product_colors_sizes_id` int(10) NOT NULL,
  `quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_list`
--

INSERT INTO `stock_list` (`id`, `product_id`, `product_colors_sizes_id`, `quantity`) VALUES
(3, 39, 189, 218),
(4, 39, 186, 160),
(5, 39, 187, 230),
(8, 39, 188, 300),
(9, 39, 193, 140),
(11, 57, 0, 2799),
(12, 57, 199, 716),
(13, 57, 200, 553),
(14, 57, 201, 834),
(15, 57, 202, 598),
(16, 57, 203, 849);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_list`
--

CREATE TABLE `supplier_list` (
  `id` int(10) NOT NULL,
  `supplier_name` varchar(250) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contact` int(20) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier_list`
--

INSERT INTO `supplier_list` (`id`, `supplier_name`, `address`, `contact`, `email`) VALUES
(4, 'ABC Company', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 12312312, 'google@gmail.com'),
(7, 'asdas', 'aasdas', 12312, 'jendeukie567@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucher_id` int(11) NOT NULL,
  `code` varchar(20) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `is_redeemed` tinyint(1) DEFAULT 0,
  `redeemed_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gcash_receipt_id` (`gcash_receipts_id`);

--
-- Indexes for table `brand_list`
--
ALTER TABLE `brand_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_list`
--
ALTER TABLE `cart_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_colors_sizes_id` (`product_colors_sizes_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_brands`
--
ALTER TABLE `category_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `client_list`
--
ALTER TABLE `client_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management_aboutus`
--
ALTER TABLE `content_management_aboutus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management_carousel`
--
ALTER TABLE `content_management_carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management_contactus`
--
ALTER TABLE `content_management_contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content_management_logo`
--
ALTER TABLE `content_management_logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gcash_infos`
--
ALTER TABLE `gcash_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gcash_receipts`
--
ALTER TABLE `gcash_receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `fk_order_list_order_products` (`order_id`);

--
-- Indexes for table `product_colors_sizes`
--
ALTER TABLE `product_colors_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_request`
--
ALTER TABLE `service_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `stock_list`
--
ALTER TABLE `stock_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_colors_sizes_id` (`product_colors_sizes_id`);

--
-- Indexes for table `supplier_list`
--
ALTER TABLE `supplier_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `brand_list`
--
ALTER TABLE `brand_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `category_brands`
--
ALTER TABLE `category_brands`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `client_list`
--
ALTER TABLE `client_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `content_management_aboutus`
--
ALTER TABLE `content_management_aboutus`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `content_management_carousel`
--
ALTER TABLE `content_management_carousel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `content_management_contactus`
--
ALTER TABLE `content_management_contactus`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `content_management_logo`
--
ALTER TABLE `content_management_logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `gcash_infos`
--
ALTER TABLE `gcash_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `gcash_receipts`
--
ALTER TABLE `gcash_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `product_colors_sizes`
--
ALTER TABLE `product_colors_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `service_request`
--
ALTER TABLE `service_request`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_list`
--
ALTER TABLE `stock_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_ibfk_1` FOREIGN KEY (`gcash_receipts_id`) REFERENCES `gcash_receipts` (`id`);

--
-- Constraints for table `category_brands`
--
ALTER TABLE `category_brands`
  ADD CONSTRAINT `category_brands_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_brands_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brand_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`);

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `fk_order_list_order_products` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`),
  ADD CONSTRAINT `order_products_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`);

--
-- Constraints for table `product_colors_sizes`
--
ALTER TABLE `product_colors_sizes`
  ADD CONSTRAINT `product_colors_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_list` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_list` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `client_list` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
