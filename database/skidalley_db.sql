-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 04:55 PM
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

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `order_id`, `order_products_id`, `reason`, `notification_type`, `is_approved`, `is_read`, `timestamp`, `gcash_receipts_id`) VALUES
(553, 525, 66, NULL, 'order', 1, 0, '2024-01-16 08:00:29', NULL),
(554, 525, 0, NULL, 'Review Submitted', 4, 0, '2024-01-16 08:01:30', NULL),
(555, 526, 67, NULL, 'order', 1, 0, '2024-01-16 08:02:28', NULL),
(556, 526, 489, NULL, 'Receipt Uploaded', 3, 0, '2024-01-16 08:02:52', 62),
(557, 526, 0, NULL, 'Review Submitted', 4, 0, '2024-01-16 08:03:30', NULL),
(558, 527, 68, NULL, 'order', 1, 0, '2024-01-16 08:04:32', NULL),
(559, 528, 69, NULL, 'order', 1, 0, '2024-01-16 08:05:38', NULL),
(560, 529, 73, NULL, 'order', 1, 0, '2024-01-16 08:06:09', NULL),
(561, 530, 72, NULL, 'order', 1, 0, '2024-01-16 08:06:39', NULL),
(562, 531, 70, NULL, 'order', 1, 0, '2024-01-16 08:06:54', NULL),
(563, 532, 67, NULL, 'order', 1, 0, '2024-01-16 08:08:27', NULL);

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
(39, 'Celt 2024', 'path_to_image', 0, 1),
(40, 'Celt', 'path_to_image', 0, 1),
(42, 'VP', 'path_to_image', 0, 1),
(43, 'Arrow', 'path_to_image', 0, 1),
(44, 'Legend', 'path_to_image', 0, 1),
(45, 'Celt XJ', 'path_to_image', 0, 1),
(47, 'Garuda', 'path_to_image', 0, 1),
(48, 'Celt', 'path_to_image', 0, 1),
(49, 'Celt DS', 'path_to_image', 0, 1),
(50, 'Celt Chaser', 'path_to_image', 0, 1);

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

--
-- Dumping data for table `cart_list`
--

INSERT INTO `cart_list` (`id`, `client_id`, `product_id`, `product_colors_sizes_id`, `color`, `size`, `quantity`) VALUES
(378, 31, 67, 0, 'Black', '52', 1);

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
(88, 'Frame Set', '', 1, 0),
(89, 'Aero', '', 1, 0),
(91, 'Deep Rims', '', 1, 0),
(92, 'Rim Set', '', 1, 0),
(94, 'Bike Set', '', 1, 0),
(95, 'Aero', '', 1, 0);

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
(28, 89, 40),
(30, 91, 42),
(31, 92, 43),
(32, 92, 44),
(33, 92, 45),
(37, 95, 49),
(38, 94, 47),
(39, 88, 39),
(40, 88, 50);

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

--
-- Dumping data for table `gcash_receipts`
--

INSERT INTO `gcash_receipts` (`id`, `file_name`, `file_path`, `approved`, `upload_timestamp`) VALUES
(61, 'BSIT4.!B_logo1.png', 'images/gcash_receipts/BSIT4.!B_logo1.png', 1, '2024-01-16 07:04:29'),
(62, 'texture.jpg', 'images/gcash_receipts/texture.jpg', 1, '2024-01-16 08:02:52');

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
(725, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160029_31', 'Order', '2024-01-16 16:00:29', 'new', 0, 0),
(726, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:00:42', 'new', 0, 0),
(727, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:01:05', 'new', 0, 0),
(728, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160228_31', 'Order', '2024-01-16 16:02:28', 'new', 0, 0),
(729, 31, 'Gcash receipt approved successfully.', 'Gcash Approval', '2024-01-16 16:02:59', 'new', 0, 0),
(730, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:03:06', 'new', 0, 0),
(731, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:03:15', 'new', 0, 0),
(732, 31, 'Congratulations! You\'ve earned a voucher. Code: 2Q62YDZC', 'Voucher', '2024-01-16 16:04:32', 'new', 0, 0),
(733, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160432_31', 'Order', '2024-01-16 16:04:32', 'new', 0, 0),
(734, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:04:44', 'new', 0, 0),
(735, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160538_31', 'Order', '2024-01-16 16:05:38', 'new', 0, 0),
(736, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160609_31', 'Order', '2024-01-16 16:06:09', 'new', 0, 0),
(737, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160639_31', 'Order', '2024-01-16 16:06:39', 'new', 0, 0),
(738, 31, 'Congratulations! You\'ve earned a voucher. Code: 7O4LGIN0', 'Voucher', '2024-01-16 16:06:54', 'new', 0, 0),
(739, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160654_31', 'Order', '2024-01-16 16:06:54', 'new', 0, 0),
(740, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:07:11', 'new', 0, 0),
(741, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:07:15', 'new', 0, 0),
(742, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:07:20', 'new', 0, 0),
(743, 31, 'Your Order Has Been Delivered Successfully.', 'Delivered', '2024-01-16 16:07:24', 'new', 0, 0),
(744, 31, 'Your order has been placed successfully. Your order reference code is: ORD_20240116160827_31', 'Order', '2024-01-16 16:08:27', 'new', 0, 0);

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

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `ref_code`, `client_id`, `gcash_receipts_id`, `total_amount`, `delivery_address`, `payment_method`, `message`, `status`, `order_receive`, `date_created`, `date_updated`) VALUES
(525, 'ORD_20240116160029_31', 31, NULL, 5300, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Cash on Delivery', '', 4, 1, '2024-01-16 16:00:29', '2024-01-16 16:01:05'),
(526, 'ORD_20240116160228_31', 31, 62, 8000, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Gcash', '', 4, 1, '2024-01-16 16:02:28', '2024-01-16 16:03:15'),
(527, 'ORD_20240116160432_31', 31, NULL, 10000, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Pickup', '', 4, 0, '2024-01-16 16:04:32', '2024-01-16 16:04:44'),
(528, 'ORD_20240116160538_31', 31, NULL, 2600, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Cash on Delivery', '', 4, 0, '2024-01-16 16:05:38', '2024-01-16 16:07:11'),
(529, 'ORD_20240116160609_31', 31, NULL, 20000, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Pickup', '', 4, 0, '2024-01-16 16:06:09', '2024-01-16 16:07:15'),
(530, 'ORD_20240116160639_31', 31, NULL, 12300, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Cash on Delivery', '', 4, 0, '2024-01-16 16:06:39', '2024-01-16 16:07:20'),
(531, 'ORD_20240116160654_31', 31, NULL, 5300, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Cash on Delivery', '', 4, 0, '2024-01-16 16:06:54', '2024-01-16 16:07:24'),
(532, 'ORD_20240116160827_31', 31, NULL, 12900, '\"Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines\"', 'Cash on Delivery', '', 0, 0, '2024-01-16 16:08:27', NULL);

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

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `product_id`, `quantity`, `price_per_unit`, `color`, `size`) VALUES
(488, 525, 66, 1, 5000.00, 'Gray', '50'),
(489, 526, 67, 1, 8000.00, 'Black', '52'),
(490, 527, 68, 1, 10000.00, 'Black', '52'),
(491, 528, 69, 1, 2500.00, 'Black', ' 90mm'),
(492, 529, 73, 1, 20000.00, 'Red', 'small'),
(493, 530, 72, 1, 6000.00, 'Silver', '26 inch'),
(494, 530, 72, 1, 6000.00, 'Black', '26 inch'),
(495, 531, 70, 1, 5000.00, 'Black', '26 inch'),
(496, 532, 71, 1, 5000.00, 'Black', '26 inch'),
(497, 532, 67, 1, 8000.00, 'Black', '52');

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
(205, 66, 'Black', '50'),
(206, 66, 'Black', ' 53'),
(207, 66, 'Black', ' 56 '),
(208, 66, 'Gray', '50'),
(209, 66, 'Gray', ' 53'),
(210, 66, 'Blue', '50'),
(211, 66, 'Blue', ' 53'),
(212, 66, 'Pink', '50'),
(213, 67, 'Black', '52'),
(214, 67, 'Gray', '52'),
(215, 68, 'Green', '52'),
(216, 68, 'Black', '52'),
(217, 68, 'Silver', '52'),
(220, 69, 'Black', '70mm'),
(221, 69, 'Black', ' 90mm'),
(222, 73, 'Red', 'small'),
(223, 73, 'Red', 'medium'),
(224, 73, 'Red', 'large'),
(225, 70, 'Black', '26 inch'),
(226, 71, 'Black', '26 inch'),
(228, 72, 'Silver', '26 inch'),
(229, 72, 'Black', '26 inch');

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
  `description` varchar(10000) NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `image_path` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`id`, `brand_id`, `category_id`, `name`, `models`, `description`, `price`, `status`, `image_path`, `delete_flag`) VALUES
(66, 39, 88, 'Celt 2024 Frame Set', '', 'The Celt 2024 Frame boasts a robust steel construction, ensuring a sturdy foundation for your cycling adventures. The frame is meticulously designed to provide optimal support and stability, delivering a reliable platform for riders of all levels. Its steel composition not only enhances durability but also provides a smooth and comfortable ride, absorbing road vibrations for an enjoyable cycling experience.\r\n\r\n', 5000, 1, 'Bike-Name5966.jpg', 0),
(67, 40, 89, 'Celt DS Aero', '', 'Celt DS Aero – a cutting-edge alloy frame set designed for optimal aerodynamics.\r\n\r\nCrafted with precision, the alloy frame ensures a lightweight yet sturdy foundation.\r\n\r\nPaired with an aerodynamically optimized fork, enhancing speed and control for an exhilarating ride.\r\n\r\nThe included headset guarantees smooth steering, adding to the overall precision and responsiveness.\r\n\r\nCompleting the package is a reliable seatclamp, providing secure adjustment for a comfortable and customized cycling experience.', 8000, 1, 'Bike-Name9996.jpg', 0),
(68, 50, 88, 'Celt Chaser ', '', 'Celt Chaser – a dynamic alloy frame set engineered for the ultimate cycling experience.\r\n\r\nThe lightweight alloy frame offers agility and durability, providing a solid foundation for your journeys.\r\n\r\nPaired with a performance-driven fork, the Celt Chaser ensures responsive handling and precise control on any terrain.\r\n\r\nEquipped with a reliable headset, this bike guarantees smooth and efficient steering, enhancing overall ride quality.\r\n\r\nThe inclusion of a secure seatclamp completes the Celt Chaser, allowing for personalized adjustments and ensuring comfort throughout your cycling adventures.', 10000, 1, 'Bike-Name8175.jpg', 0),
(69, 42, 91, 'VP Deep Rims', '', 'VP Deep Rims precision-engineered for speed and stability, available in two versatile sizes to suit your cycling needs.\r\n\r\nThe 70mm rims offer an ideal balance between aerodynamics and maneuverability, providing a smooth and controlled ride.\r\n\r\nFor those craving maximum performance, the 90mm rims deliver unparalleled aerodynamic advantages, pushing the limits of speed and efficiency.\r\n\r\nWith one pair of each size, the VP Deep Rims offer a dynamic duo for cyclists seeking the perfect combination of style and performance. Elevate your ride with these meticulously designed rims, where form meets function seamlessly.', 2500, 1, 'Bike-Name3650.jpg', 0),
(70, 43, 92, 'Arrow Rim Set ', '', 'Arrow Rim Set  a precision-crafted cycling essential designed for speed enthusiasts.\r\n\r\nFeaturing 20/24 holes, this rim set strikes a balance between lightweight agility and structural integrity, ensuring a responsive ride.\r\n\r\nPaired with fixed/fixed hubs, the Arrow Rim Set guarantees a reliable and versatile performance, ideal for both urban commuting and track racing.', 5000, 1, 'Bike-Name-5773.jpg', 0),
(71, 44, 92, 'Legend Rimset ', '', 'Featuring 20/24 holes, this rimset strikes a balance between strength and weight, offering a responsive and agile performance.\r\n\r\nEquipped with fixed/fixed hubs, the Legend Rimset ensures versatility and reliability for both urban commuting and track cycling enthusiasts.\r\n\r\nIncluded in this set are meticulously crafted rims, hubs, and a 17-tooth cog, providing a seamless integration of components for a high-performance ', 5000, 1, 'Bike-Name6950.jpg', 0),
(72, 45, 92, 'Celt XJ Rim Set', '', 'Celt XJ Rim Set a high-performance cycling essential designed for precision rides.\r\n\r\nFeaturing Celt rims with 32 sealed bearing hubs, this set offers durability and a smooth, low-maintenance experience.\r\n\r\nComplete with a 17-tooth cog, the Celt XJ Rim Set ensures a responsive and customizable cycling adventure. Elevate your ride with this meticulously engineered combination, where reliability and style converge seamlessly.', 6000, 1, 'Bike-Name7072.jpg', 0),
(73, 47, 94, 'Garuda Bike Set', '', 'Garuda Bike Set  a meticulously crafted ensemble for avid riders. Its lightweight, sturdy frame ensures agility and durability on diverse terrains, complemented by high-performance wheels and a responsive drivetrain for speed and control. The ergonomic saddle and handlebars add comfort to long rides. Elevate your cycling journey with the Garuda Bike Set where style and functionality meet seamlessly on the road.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 20000, 1, 'Bike-Name5065.jpg', 0);

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
  `approved` tinyint(10) NOT NULL,
  `reply` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `client_id`, `image_path`, `stars`, `review_text`, `approved`, `reply`, `timestamp`, `product_id`) VALUES
(53, 525, 31, 'Review-1199.webp', 5, 'ang ganda ng product!!', 1, 'thank you buy again!', '2024-01-16 08:01:30', 0),
(54, 526, 31, 'Review-970.jpg', 5, 'ang ganda!!', 1, 'thank you buy again!', '2024-01-16 08:03:30', 0);

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
(17, 66, 205, 50),
(18, 66, 206, 47),
(19, 66, 207, 50),
(20, 66, 208, 46),
(21, 66, 209, 96),
(22, 66, 210, 100),
(23, 66, 211, 50),
(24, 66, 212, 50),
(25, 67, 213, 46),
(26, 67, 214, 49),
(27, 68, 215, 49),
(28, 68, 216, 48),
(29, 68, 217, 50),
(30, 69, 220, 49),
(31, 69, 221, 49),
(32, 70, 225, 49),
(33, 71, 226, 49),
(34, 72, 228, 48),
(35, 72, 229, 49),
(36, 73, 222, 49);

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
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucher_id`, `code`, `client_id`, `amount`, `expiration_date`, `is_redeemed`, `redeemed_date`, `created_at`) VALUES
(53, '2Q62YDZC', 31, 200.00, '2024-01-23', 1, '2024-01-16', '2024-01-16 08:04:32'),
(54, '7O4LGIN0', 31, 400.00, '2024-01-23', 1, '2024-01-16', '2024-01-16 08:06:54');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=564;

--
-- AUTO_INCREMENT for table `brand_list`
--
ALTER TABLE `brand_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=379;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `category_brands`
--
ALTER TABLE `category_brands`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `gcash_infos`
--
ALTER TABLE `gcash_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `gcash_receipts`
--
ALTER TABLE `gcash_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=745;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=498;

--
-- AUTO_INCREMENT for table `product_colors_sizes`
--
ALTER TABLE `product_colors_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `product_list`
--
ALTER TABLE `product_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `supplier_list`
--
ALTER TABLE `supplier_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
