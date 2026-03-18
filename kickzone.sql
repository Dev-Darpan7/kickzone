-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 08:05 PM
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
-- Database: `kickzone`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@test.com', '$2y$10$MNxADfT1C2dEYbWFMDaJt.H.qyhuwRW0X10bgfqvhgmeKI4.DVyhC', '2026-01-20 12:35:04'),
(2, '', 'admin@example.com', '$2y$10$HASH_HERE', '2026-01-20 12:49:04');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user`, `product_id`, `quantity`) VALUES
(10, '', 4, 1),
(11, '', 5, 1),
(74, 'tester', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(100) NOT NULL,
  `payment_method` varchar(20) NOT NULL DEFAULT 'COD',
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `order_number` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `status`, `created_at`, `user`, `payment_method`, `payment_status`, `phone`, `address`, `city`, `pincode`, `order_number`, `transaction_id`) VALUES
(1, 0, 8997.00, 'pending', '2026-01-20 13:37:34', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 0, 5998.00, 'Pending', '2026-01-20 13:37:46', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, 8999.00, 'pending', '2026-01-24 06:52:22', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 0, 2999.00, 'Completed', '2026-01-24 06:52:29', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 0, 2999.00, 'pending', '2026-01-24 06:55:57', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 0, 50394.00, 'pending', '2026-02-12 14:00:09', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 0, 118993.00, 'pending', '2026-02-12 14:01:13', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 0, 19998.00, 'pending', '2026-02-13 18:13:29', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 0, 2999.00, 'pending', '2026-02-13 18:15:46', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(10, 0, 20997.00, 'pending', '2026-02-13 18:32:32', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 0, 22997.00, 'pending', '2026-02-13 18:42:26', 'DARPAN', 'COD', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(12, 0, 16999.00, 'pending', '2026-02-14 07:36:19', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 0, 16999.00, 'pending', '2026-02-14 07:37:11', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(14, 0, 16999.00, 'pending', '2026-02-16 13:44:36', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(15, 0, 2999.00, 'pending', '2026-02-16 13:52:43', 'DARPAN', 'ONLINE', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(16, 0, 6000.00, 'pending', '2026-02-16 13:57:23', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(17, 0, 16999.00, 'pending', '2026-02-16 13:59:30', 'DARPAN', 'ONLINE', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 0, 2999.00, 'pending', '2026-02-16 14:03:46', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 0, 16999.00, 'pending', '2026-02-16 14:03:58', 'DARPAN', 'ONLINE', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(20, 0, 16999.00, 'pending', '2026-02-16 14:09:53', 'DARPAN', 'ONLINE', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 0, 2999.00, 'pending', '2026-02-16 14:10:48', 'DARPAN', 'ONLINE', 'pending', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 0, 2999.00, 'Completed', '2026-02-19 11:35:49', 'DARPAN', 'COD', 'success', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 0, 2999.00, 'pending', '2026-02-24 10:50:26', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(24, 0, 8999.00, 'pending', '2026-02-24 10:50:56', 'DARPAN', 'COD', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(25, 0, 8999.00, 'pending', '2026-02-24 10:51:20', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(26, 0, 5998.00, 'pending', '2026-02-24 11:11:58', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(27, 0, 1000.00, 'pending', '2026-02-24 11:25:58', 'test', 'COD', 'pending', '9999999999', 'Mumbai', NULL, NULL, NULL, NULL),
(28, 1, 12899.00, 'pending', '2026-02-24 11:32:22', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(29, 1, 8999.00, 'pending', '2026-02-24 11:32:36', 'DARPAN', 'COD', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(30, 1, 2999.00, 'pending', '2026-02-24 13:26:31', 'DARPAN', 'COD', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(31, 1, 2999.00, 'Completed', '2026-02-24 13:35:18', 'DARPAN', 'COD', 'cod', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(32, 1, 16999.00, 'Completed', '2026-02-24 13:39:51', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(33, 1, 15498.00, 'pending', '2026-02-24 15:28:24', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(34, 1, 13999.00, 'pending', '2026-02-24 16:11:30', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(35, 1, 16999.00, 'pending', '2026-02-24 16:25:33', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'D-13,002,KAUSHAL CO-OPRAATIVE SOCIETY', 'Ambernath', '421501', NULL, NULL),
(36, 1, 16999.00, 'pending', '2026-02-24 17:03:23', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(37, 1, 2999.00, 'Completed', '2026-02-25 02:52:40', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(38, 1, 2599.00, 'pending', '2026-02-25 03:16:40', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(39, 1, 16999.00, 'pending', '2026-02-25 03:21:15', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(40, 2, 2999.00, 'pending', '2026-02-25 03:28:12', 'qweqw', 'ONLINE', 'pending', '09307121646', 'Ambernath', 'Ambernath', '421501', NULL, NULL),
(41, 1, 16999.00, 'pending', '2026-03-01 08:54:08', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(42, 1, 16999.00, 'pending', '2026-03-01 08:54:29', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(43, 1, 16999.00, 'pending', '2026-03-01 08:57:15', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(44, 1, 16999.00, 'pending', '2026-03-01 09:06:27', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A403726692C'),
(45, 1, 6000.00, 'pending', '2026-03-01 09:15:43', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A403D59D62C'),
(46, 1, 2999.00, 'pending', '2026-03-01 09:25:19', 'DARPAN', 'ONLINE', 'success', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A4060F840E5'),
(47, 1, 8999.00, 'pending', '2026-03-01 09:47:05', 'DARPAN', 'COD', 'cod', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(48, 1, 13999.00, 'confirmed', '2026-03-01 09:47:27', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A40B45BE12C'),
(49, 1, 16999.00, 'pending', '2026-03-01 09:54:02', 'DARPAN', 'COD', 'cod', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(50, 1, 16999.00, 'confirmed', '2026-03-01 09:54:42', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A40CF26239B'),
(51, 1, 2999.00, 'confirmed', '2026-03-01 10:03:16', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, 'KZ69A40EEE03B2C'),
(52, 1, 19998.00, 'pending', '2026-03-01 12:26:18', 'DARPAN', 'COD', 'cod', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(53, 1, 16999.00, 'Completed', '2026-03-01 12:27:02', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(54, 1, 19998.00, 'Completed', '2026-03-01 13:13:27', 'DARPAN', 'COD', 'cod', '09307121646', 'd-13 002 loknagri midc road', 'Ambernath', '421501', NULL, NULL),
(55, 1, 2999.00, 'pending', '2026-03-01 14:28:48', 'DARPAN', 'ONLINE', 'pending', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, NULL),
(56, 1, 6000.00, 'confirmed', '2026-03-05 03:20:34', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69A8F691680CE'),
(57, 1, 16999.00, 'pending', '2026-03-05 03:21:18', 'DARPAN', 'COD', 'cod', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, NULL),
(58, 1, 3998.00, 'confirmed', '2026-03-14 14:54:04', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69B576A729872'),
(59, 1, 1999.00, 'confirmed', '2026-03-14 14:55:09', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69B5783D43902'),
(60, 3, 8999.00, 'confirmed', '2026-03-14 15:00:16', 'tester', 'ONLINE', 'paid', '1234567890', '123 Test Street', 'Test City', '123456', NULL, 'KZ69B57820EB9D6'),
(61, 1, 2999.00, 'confirmed', '2026-03-14 15:08:49', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69B57A3128393'),
(62, 1, 7999.00, 'pending', '2026-03-14 15:12:34', 'DARPAN', 'COD', 'cod', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, NULL),
(63, 1, 2999.00, 'pending', '2026-03-14 15:17:06', 'DARPAN', 'COD', 'cod', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, NULL),
(64, 1, 2999.00, 'confirmed', '2026-03-14 15:18:20', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69B57C5F28CA6'),
(65, 1, 1999.00, 'confirmed', '2026-03-18 19:01:31', 'DARPAN', 'ONLINE', 'paid', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501', NULL, 'KZ69BAF6A465C1C');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 4, 3, 2999.00),
(2, 2, 4, 2, 2999.00),
(3, 3, 3, 1, 8999.00),
(4, 4, 4, 1, 2999.00),
(5, 5, 4, 1, 2999.00),
(6, 6, 4, 2, 2999.00),
(7, 6, 5, 1, 16999.00),
(8, 6, 7, 1, 10799.00),
(9, 6, 8, 1, 2599.00),
(10, 6, 12, 1, 13999.00),
(11, 7, 5, 7, 16999.00),
(12, 8, 4, 1, 2999.00),
(13, 8, 5, 1, 16999.00),
(14, 9, 4, 1, 2999.00),
(15, 10, 3, 1, 8999.00),
(16, 10, 4, 2, 2999.00),
(17, 10, 6, 1, 6000.00),
(18, 11, 4, 2, 2999.00),
(19, 11, 5, 1, 16999.00),
(20, 12, 5, 1, 16999.00),
(21, 13, 5, 1, 16999.00),
(22, 14, 5, 1, 16999.00),
(23, 15, 4, 1, 2999.00),
(24, 16, 6, 1, 6000.00),
(25, 17, 5, 1, 16999.00),
(26, 18, 4, 1, 2999.00),
(27, 19, 5, 1, 16999.00),
(28, 20, 5, 1, 16999.00),
(29, 21, 4, 1, 2999.00),
(30, 22, 4, 1, 2999.00),
(31, 23, 4, 1, 2999.00),
(32, 24, 10, 1, 8999.00),
(33, 25, 3, 1, 8999.00),
(34, 26, 4, 2, 2999.00),
(35, 28, 13, 1, 12899.00),
(36, 29, 3, 1, 8999.00),
(37, 30, 4, 1, 2999.00),
(38, 31, 4, 1, 2999.00),
(39, 32, 5, 1, 16999.00),
(40, 33, 8, 1, 2599.00),
(41, 33, 13, 1, 12899.00),
(42, 34, 12, 1, 13999.00),
(43, 35, 5, 1, 16999.00),
(44, 36, 5, 1, 16999.00),
(45, 37, 4, 1, 2999.00),
(46, 38, 8, 1, 2599.00),
(47, 39, 5, 1, 16999.00),
(48, 40, 4, 1, 2999.00),
(49, 41, 5, 1, 16999.00),
(50, 42, 5, 1, 16999.00),
(51, 43, 5, 1, 16999.00),
(52, 44, 5, 1, 16999.00),
(53, 45, 6, 1, 6000.00),
(54, 46, 4, 1, 2999.00),
(55, 47, 3, 1, 8999.00),
(56, 48, 12, 1, 13999.00),
(57, 49, 5, 1, 16999.00),
(58, 50, 5, 1, 16999.00),
(59, 51, 4, 1, 2999.00),
(60, 52, 4, 1, 2999.00),
(61, 52, 5, 1, 16999.00),
(62, 53, 5, 1, 16999.00),
(63, 54, 4, 1, 2999.00),
(64, 54, 5, 1, 16999.00),
(65, 55, 4, 1, 2999.00),
(66, 56, 6, 1, 6000.00),
(67, 57, 5, 1, 16999.00),
(68, 58, 5, 2, 1999.00),
(69, 59, 5, 1, 1999.00),
(70, 60, 3, 1, 8999.00),
(71, 61, 4, 1, 2999.00),
(72, 62, 6, 1, 6000.00),
(73, 62, 14, 1, 1999.00),
(74, 63, 4, 1, 2999.00),
(75, 64, 4, 1, 2999.00),
(76, 65, 5, 1, 1999.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `created_at`) VALUES
(3, 'Adidias-Ultraboost', 8999.00, 'images/adidas-ultraboost-22.jpg', '2026-01-20 13:14:02'),
(4, 'Nike Gato', 2999.00, 'images/nike.jpg', '2026-01-20 13:14:40'),
(5, 'MagMax NITRO™', 1999.00, 'images/mag-max.jpg', '2026-01-20 13:15:29'),
(6, 'SpeedCat', 6000.00, 'images/speed-cat.jpg', '2026-01-20 13:17:31'),
(7, 'jordan', 1799.00, 'images/jordan.jpg', '2026-01-20 13:19:00'),
(8, 'Badminton', 2599.00, 'images/badminton.jpg', '2026-01-20 13:22:32'),
(9, 'Basketball pro', 5999.00, 'images/basketball.jpg', '2026-01-20 13:23:23'),
(10, 'Classic Leather', 8999.00, 'images/classicleather.jpg', '2026-01-20 13:24:12'),
(11, 'Air Max', 4999.00, 'images/airmax.jpg', '2026-01-20 13:24:48'),
(12, 'Puma x Rose', 3999.00, 'images/puma-x-rose.jpg', '2026-01-20 13:25:40'),
(13, 'Scuderia', 2899.00, 'images/scuderia.jpg', '2026-01-20 13:26:21'),
(14, 'Army Puma', 1999.00, 'images/puma-army.jpg', '2026-01-20 13:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `phone`, `address`, `city`, `pincode`) VALUES
(1, 'DARPAN', 'dhawandarpan@gmail.com', '$2y$10$7.QGGeKOLV9ketIf4a6VA.xUjFzAP.YA8LYWfmfoiE6PvfUuLi9Bm', '2026-01-20 13:29:23', '09307121646', 'D-13,002 KAUSHAL CO-OPERATIVE SOCIETY', 'Ambernath', '421501'),
(2, 'qweqw', 'gunjanjadhav@gmail.com', '$2y$10$wWppD/tFYrIrjtuNOqZR2ebynE3RlB4WxDbMGFkqd08hubSAHxpUG', '2026-02-25 03:22:43', NULL, NULL, NULL, NULL),
(3, 'tester', 'tester123@test.com', '$2y$10$fBRycJI.CHCemzjae6d.feiOzXwxEXSSFmvX6CdP1vfOgE6yKVAZC', '2026-03-14 14:58:42', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
