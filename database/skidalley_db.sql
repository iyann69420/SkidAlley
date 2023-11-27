-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 12:46 PM
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
(28, 'Ian Salgado', 'staff1', '4d7d719ac0cf3d78ea8a94701913fe47', 0, ''),
(29, 'staff2', 'staff2', '8bc01711b8163ec3f2aa0688d12cdf3b', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_products_id` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `is_approved` tinyint(4) NOT NULL DEFAULT 0,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_notifications`
--

INSERT INTO `admin_notifications` (`id`, `order_id`, `order_products_id`, `reason`, `is_approved`, `is_read`, `timestamp`) VALUES
(18, 140, 0, 'asdasd', 0, 1, '2023-11-09 11:14:41'),
(19, 141, 0, 'awaw', 0, 1, '2023-11-09 11:14:40'),
(20, 142, 0, '2323', 0, 1, '2023-11-09 11:14:38'),
(21, 143, 0, 'asdasdas', 0, 1, '2023-11-09 11:14:46'),
(22, 144, 0, '11', 0, 1, '2023-11-09 11:14:45'),
(23, 145, 0, 'tae', 0, 1, '2023-11-09 11:07:08'),
(24, 146, 0, '2323232', 0, 1, '2023-11-06 22:52:14'),
(25, 147, 0, 'asdasdasdas', 0, 1, '2023-11-06 22:51:55'),
(26, 148, 0, ':(', 0, 1, '2023-11-09 11:17:37'),
(27, 149, 0, 'asdasdas', 0, 1, '2023-11-09 11:28:36'),
(28, 150, 0, 'walang pera', 0, 1, '2023-11-09 11:28:35'),
(29, 151, 0, 'asdasdasdasdasdas', 0, 1, '2023-11-09 11:28:23'),
(30, 152, 0, 'aaaaaaaaaaaaaa', 0, 0, '2023-11-09 11:29:26');

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

--
-- Dumping data for table `cart_list`
--

INSERT INTO `cart_list` (`id`, `client_id`, `product_id`, `product_colors_sizes_id`, `color`, `size`, `quantity`) VALUES
(101, 8, 57, 0, 'pink', 'small', 2),
(110, 11, 57, 0, 'pink', 'medium', 30);

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
(30, 'Bike Set', '', 1, 0),
(87, 'wow', '', 1, 0);

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
(13, 87, 31),
(14, 87, 32),
(15, 87, 33),
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
(8, 'vak', 'VAL', '69', 'Blk 52  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'googlee@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(9, 'username', 'fullname', '123123', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'google@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(10, 'xd', 'XD', '12312312', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'google@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(11, 'iansalgado15', 'Ian Salgado', '0916462354', 'Trece', 'google@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(12, 'admin1', 'Ian Salgado', '1212312', 'etivac', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(13, 'ayygoo15', 'Ian Salgado', '091321231', 'Blk 20 Lot 5 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(14, 'admin69', 'Ian Salgado', '12312312', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'google@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(23, '', '', '', '', '', '', 1, 0),
(24, 'sanagumana', 'fullname', '12345', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(27, 'iansalgado11', 'Ian Salgado', '1234', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(28, 'ririxd', 'XD', '12121', 'etivac', 'salgadoerine@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(29, 'admin123', 'fullname', '12312', 'Blk 5  Lot 3 Pacific Towns 2 Brgy Conchu Trece Martires City Cavite Philippines', 'jendeukie567@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0),
(30, 'cathy', 'cathy', '123123', 'Trece', 'catherinesalgado23@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 1, 0);

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
(1, '<span style=\"font-family: &quot;Times New Roman&quot;;\">Feel free to reach out to us with any questions or concerns. We\'re here to help!\r\n\r\nOur Address:\r\n- 123 Main Street\r\n- Cityville, State 12345\r\n- Country\r\n\r\nPhone Number:\r\n- Main Office: (555) 123-4567\r\n- Customer Support: (555) 987-6543\r\n\r\nEmail:\r\n- General Inquiries: info@example.com\r\n- Support: support@example.com\r\n\r\nYou can also visit our website at www.example.com for more information and online support.</span>\r\n\r\n', 'Comic Sans MS', 25);

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
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
(51, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231109121338_11', 'Order', '2023-11-09 12:13:38', 'new', 0, 0),
(52, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231109121759_11', 'Order', '2023-11-09 12:17:59', 'new', 0, 0),
(53, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231109122330_11', 'Order', '2023-11-09 12:23:30', 'new', 0, 0),
(54, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231109122649_11', 'Order', '2023-11-09 12:26:49', 'new', 0, 0),
(55, 11, 'Your order has been placed successfully. Your order reference code is: ORD_20231109122848_11', 'Order', '2023-11-09 12:28:48', 'new', 0, 0),
(56, 11, 'Your order has been canceled successfully.', 'Cancellation', '2023-11-09 12:42:13', 'new', 0, 0);

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
  `total_amount` float NOT NULL DEFAULT 0,
  `delivery_address` text NOT NULL,
  `payment_method` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1 = packed, 2 = for delivery, 3 = on the way, 4 = delivered, 5=cancelled',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_list`
--

INSERT INTO `order_list` (`id`, `ref_code`, `client_id`, `total_amount`, `delivery_address`, `payment_method`, `status`, `date_created`, `date_updated`) VALUES
(148, 'ORD_20231109121338_11', 11, 615615, 'Trece', 'Pickup', 5, '2023-11-09 19:13:38', '2023-11-09 19:15:27'),
(149, 'ORD_20231109121759_11', 11, 1231230, 'Trece', 'Pickup', 5, '2023-11-09 19:17:59', '2023-11-09 19:18:41'),
(150, 'ORD_20231109122330_11', 11, 1231230, 'Trece', 'Pickup', 5, '2023-11-09 19:23:30', '2023-11-09 19:23:54'),
(151, 'ORD_20231109122649_11', 11, 1231230, 'Trece', 'Pickup', 5, '2023-11-09 19:26:49', '2023-11-09 19:30:42'),
(152, 'ORD_20231109122848_11', 11, 3693690, 'Trece', 'Pickup', 5, '2023-11-09 19:28:48', '2023-11-09 19:35:59');

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
(78, 148, 57, 5, 123123.00, 'pink', 'medium'),
(79, 149, 57, 10, 123123.00, 'pink', 'medium'),
(80, 150, 57, 10, 123123.00, 'pink', 'medium'),
(81, 151, 57, 10, 123123.00, 'pink', 'medium'),
(82, 152, 57, 30, 123123.00, 'pink', 'medium');

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
-- Table structure for table `request_meta`
--

CREATE TABLE `request_meta` (
  `request_id` int(10) NOT NULL,
  `meta_field` int(11) NOT NULL,
  `meta_value` int(11) NOT NULL
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
(11, 57, 0, 2794),
(12, 57, 199, 717),
(13, 57, 200, 950),
(14, 57, 201, 830),
(15, 57, 202, 610),
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
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(10) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
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
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `request_meta`
--
ALTER TABLE `request_meta`
  ADD KEY `request_id` (`request_id`);

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
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `brand_list`
--
ALTER TABLE `brand_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `cart_list`
--
ALTER TABLE `cart_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

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
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
