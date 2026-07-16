-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2026 at 06:25 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nexora`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `addr_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `user_id`, `addr_name`, `f_name`, `l_name`, `phone`, `address1`, `address2`, `city`, `postcode`, `country`, `state`, `is_default`, `is_delete`, `created_at`, `updated_at`) VALUES
(8, '1', 'Home', 'Nayan', 'Sau', '6296750899', '131/1, Contai 2I  substreet', 'Marishda', 'Contai', '922889', 'IND', 'WB', 1, 0, '2026-06-17 10:01:41', '2026-07-08 11:46:30'),
(10, '1', 'Work', 'Darius', 'Harmon', '9153936725', 'Autem labore aute qu', 'Quidem quos sint est', 'Consequatur Labore', '522961', 'IND', 'PY', 0, 0, '2026-06-18 10:52:23', '2026-07-08 11:46:30'),
(11, '2', NULL, 'Jaime', 'Lynn', '9052084193', '999 Nobel Parkway', 'Sit ipsam dolores pl', 'Expedita esse tempo', '995216', 'IND', 'UP', 1, 0, '2026-06-19 06:54:11', '2026-06-19 06:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'mailnayan@webgrity.net', 'Admin@43', '2026-06-03 07:08:51', '2026-06-03 07:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `u_id` int NOT NULL,
  `prd_id` int NOT NULL,
  `prd_type` int NOT NULL,
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `u_id`, `prd_id`, `prd_type`, `sku`, `quantity`, `created_at`, `updated_at`) VALUES
(21, 1, 8, 1, 'NX-FZS-140', 1, '2026-07-07 11:59:05', '2026-07-07 11:59:05'),
(22, 1, 9, 2, 'NX-TSH-E37C', 1, '2026-07-07 11:59:22', '2026-07-07 11:59:22'),
(24, 1, 10, 1, 'NX-UYB-676', 1, '2026-07-10 07:14:12', '2026-07-10 07:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_products` int DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Inactive, 1: Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `description`, `order_number`, `image`, `total_products`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'Discover cutting-edge technology and premium gadgets', '0', '1780470667.jpg', 1, 1, '2026-06-03 01:41:10', '2026-06-11 08:42:54'),
(2, 'Fashion', 'fashion', 'Elevate your style with timeless pieces', '0', '1780470802.jpg', 2, 1, '2026-06-03 01:43:25', '2026-06-12 07:11:29'),
(3, 'Accessories', 'accessories', 'Complete your look with premium accessories', '0', '1780470832.jpg', 2, 0, '2026-06-03 01:43:53', '2026-06-11 08:44:51'),
(4, 'Home', 'home', 'Transform your space with elegant home decor', '0', '1780470855.jpg', 1, 1, '2026-06-03 01:44:17', '2026-06-08 07:32:13'),
(5, 'Sports', 'sports', 'Discover sports equipment, fitness gear, and accessories for training, recreation, and active lifestyles.', '0', '1781091300.jpg', 1, 1, '2026-06-10 11:35:02', '2026-07-07 05:04:43');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE IF NOT EXISTS `discount` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_from` date NOT NULL,
  `valid_till` date DEFAULT NULL,
  `type` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1: PERCENTAGE, 2: FIXED_AMOUNT',
  `amount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Inactive, 1: Active',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `name`, `valid_from`, `valid_till`, `type`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 'NEXORA10', '2026-06-05', '2026-07-28', '1', '10', 1, '2026-06-05 09:10:05', '2026-07-06 11:13:15'),
(3, 'MT15', '2026-07-01', NULL, '2', '15', 1, '2026-06-05 09:10:40', '2026-07-06 13:39:51'),
(4, 'EXP30', '2026-06-06', '2026-06-30', '1', '30', 1, '2026-07-06 13:22:36', '2026-07-06 13:22:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_17_045210_create_billing_address_table', 1),
(5, '2026_02_17_045233_create_cart_table', 1),
(6, '2026_02_17_045250_create_category_table', 1),
(7, '2026_02_17_045308_create_discount_table', 1),
(8, '2026_02_17_045323_create_order_product_table', 1),
(9, '2026_02_17_045411_create_order_table_table', 1),
(10, '2026_02_17_045433_create_products_table', 1),
(11, '2026_02_17_045459_create_sub_category_table', 1),
(12, '2026_02_17_045514_create_wishlist_table', 1),
(13, '2026_04_07_050345_create_personal_access_tokens_table', 1),
(14, '2026_05_30_000002_create_variants_table', 1),
(15, '2026_05_30_000003_create_variant_attributes_table', 1),
(16, '2026_06_03_070442_create_admin_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_address`
--

DROP TABLE IF EXISTS `order_address`;
CREATE TABLE IF NOT EXISTS `order_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_number` varchar(100) DEFAULT NULL,
  `type` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '1' COMMENT '1=>Shipping,\r\n2=>Billing,\r\n3=>Shipping and Billing',
  `f_name` varchar(191) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(6) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_address`
--

INSERT INTO `order_address` (`id`, `user_id`, `order_number`, `type`, `f_name`, `l_name`, `phone`, `address1`, `address2`, `city`, `postcode`, `country`, `state`, `created_at`, `updated_at`) VALUES
(9, 1, 'ORD-NX1878', '1', 'Nayan', 'Sau', '6296750899', '131/1, Contai 2I  substreet', 'Marishda', 'Contai', '922889', 'IND', 'WB', '2026-07-06 07:16:03', '2026-07-06 07:16:03'),
(10, 1, 'ORD-NX1379', '3', 'Nayan', 'Sau', '6296750899', '131/1, Contai 2I  substreet', 'Marishda', 'Contai', '922889', 'IND', 'WB', '2026-07-06 07:31:12', '2026-07-06 07:31:12'),
(11, 1, 'ORD-NX95410', '1', 'Darius', 'Harmon', '9153936725', 'Autem labore aute qu', 'Quidem quos sint est', 'Consequatur Labore', '522961', 'IND', 'PY', '2026-07-07 11:53:40', '2026-07-07 11:53:40'),
(12, 1, 'ORD-NX95410', '2', 'Nayan', 'Sau', '6296750899', '131/1, Contai 2I  substreet', 'Marishda', 'Contai', '922889', 'IND', 'WB', '2026-07-07 11:53:40', '2026-07-07 11:53:40'),
(13, 2, 'ORD-NX34811', '3', 'Jaime', 'Lynn', '9052084193', '999 Nobel Parkway', 'Sit ipsam dolores pl', 'Expedita esse tempo', '995216', 'IND', 'UP', '2026-07-08 12:39:33', '2026-07-08 12:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type` int NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_product`
--

INSERT INTO `order_product` (`id`, `order_id`, `product_id`, `product_type`, `sku`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(9, '7', '9', 2, 'NX-TSH-63H1', '1', '46.00', '2026-07-06 07:06:38', '2026-07-06 07:06:38'),
(10, '8', '9', 2, 'NX-TSH-63H1', '1', '46.00', '2026-07-06 07:16:03', '2026-07-06 07:16:03'),
(11, '9', '8', 1, 'NX-FZS-140', '1', '95.00', '2026-07-06 07:31:12', '2026-07-06 07:31:12'),
(12, '10', '9', 2, 'NX-TSH-E37C', '1', '49.00', '2026-07-07 11:53:40', '2026-07-07 11:53:40'),
(13, '10', '8', 1, 'NX-FZS-140', '1', '95.00', '2026-07-07 11:53:40', '2026-07-07 11:53:40'),
(14, '11', '10', 1, 'NX-UYB-676', '2', '199.00', '2026-07-08 12:39:33', '2026-07-08 12:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `order_table`
--

DROP TABLE IF EXISTS `order_table`;
CREATE TABLE IF NOT EXISTS `order_table` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_status` enum('0','1','2','3') COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '0: Cancelled, 1: Processing, 2: Shipped, 3: Delivered',
  `payment_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci DEFAULT '1' COMMENT '0: Pending, 1: Paid, 2: Refunded',
  `payment_mode` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `total_price` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eco_tax` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_table`
--

INSERT INTO `order_table` (`id`, `order_number`, `user_id`, `order_status`, `payment_status`, `payment_mode`, `billing_address_id`, `shipping_address_id`, `sub_total`, `total_price`, `eco_tax`, `discount`, `shipping`, `created_at`, `updated_at`) VALUES
(8, 'ORD-NX1878', '1', '3', '1', 'card', '9', '9', NULL, '59.67', '3.68', '0', '9.99', '2026-07-06 07:16:03', '2026-07-07 11:56:36'),
(10, 'ORD-NX95410', '1', '2', '1', 'card', '12', '11', 144.00, '140.52', '11.52', '15', '0', '2026-07-07 11:53:40', '2026-07-08 11:17:12'),
(11, 'ORD-NX34811', '2', '2', '1', 'card', '13', '13', 398.00, '390.04', '31.84', '39.8', '0', '2026-07-08 12:39:33', '2026-07-10 07:15:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(11, 'App\\Models\\User', 1, 'auth_token', 'cf89ed40abdbcecf1d1dce18356f9136335a99ac516d8a414f78b3544f1d7a8a', '[\"*\"]', '2026-07-16 00:46:41', NULL, '2026-06-22 13:13:43', '2026-07-16 00:46:41'),
(12, 'App\\Models\\User', 2, 'auth_token', 'b14e87334b0bb8fc6ac12d74e61fa8f2cc149c4177d71840345649e911d3cd44', '[\"*\"]', '2026-07-09 12:40:07', NULL, '2026-07-08 11:34:35', '2026-07-09 12:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1 => simple, 2 => variable',
  `sku` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_category_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `features` json DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `featured_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gallery_image` json DEFAULT NULL,
  `stock` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_feature` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => no, 1 => yes',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 => no, 1 => yes',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_sku_unique` (`sku`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `type`, `sku`, `category_id`, `sub_category_id`, `description`, `features`, `price`, `sale_price`, `featured_image`, `gallery_image`, `stock`, `is_feature`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Desk Lamp Pro', 'desk-lamp-pro', '1', 'NX-C6X-CD8', '4', '3', 'LED desk lamp with adjustable color temperature and brightness. Built-in wireless charging pad and USB port.', '[\"Adjustable Color Temp\", \"Wireless Charging\", \"USB Port\", \"Touch Control\"]', 199.00, 129.00, '1781270206.jpg', NULL, '0', 1, 0, '2026-06-03 09:02:33', '2026-06-24 04:51:52'),
(4, 'Black Wired Computer Keyboard', 'black-wired-computer-keyboard', '1', 'NX-BRM-277', '1', '5', 'A reliable and comfortable keyboard featuring a standard layout, responsive keys, dedicated number pad, and plug-and-play USB connectivity. Perfect for office work, home use, and everyday computing tasks.', '[\"Full-Size Layout\", \"Wired USB Connectivity\", \"Low-Profile Key Design\"]', 12.00, 7.00, '1781270160.jpg', NULL, '18', 0, 0, '2026-06-08 09:20:45', '2026-06-12 13:16:01'),
(5, 'Alexa Fleming', 'alexa-fleming', '1', 'NX-CY3-1C7', '1', '2', 'Praesentium elit ve', '[\"Dolore nesciunt ven\", \"nesciunt\"]', 806.00, 89.00, '1781161114.jpg', '[\"1781161119_6a2a5c9f15a79.jpg\", \"1781163328_6a2a654054c91.jpg\"]', '90', 1, 1, '2026-06-11 06:58:40', '2026-06-11 08:42:54'),
(6, 'Virginia Skinner', 'virginia-skinner', '1', 'NX-CAG-830', '2', '1', 'Qui ad nisi maiores', '[\"Et sapiente soluta\", \"sapiente\"]', 229.00, 104.00, '1781162346.jpg', '[\"1781162352_6a2a61700dd30.jpg\", \"1781162357_6a2a6175b7e43.jpg\"]', '5', 0, 1, '2026-06-11 07:19:18', '2026-06-11 08:41:01'),
(7, 'Kenneth Sweeney', 'kenneth-sweeney', '1', 'NX-AD3-812', '1', '2', 'Omnis sequi ut ullam', '[\"Ducimus\", \"incidunt q\"]', 134.00, 112.00, '1781270420.jpg', '[\"1781164170_6a2a688a6b59a.jpg\", \"1781164172_6a2a688c6014d.jpg\"]', '53', 1, 0, '2026-06-11 07:49:34', '2026-06-12 13:20:22'),
(8, 'Patience Pollard', 'patience-pollard', '1', 'NX-FZS-140', '3', '4', 'Reiciendis lorem qua', '[\"Voluptates\", \"porro id\"]', 139.00, 95.00, '1781270386.jpg', '[\"1781167486_6a2a757ea4e1f.jpg\", \"1781270388_6a2c07748c8ec.jpg\"]', '45', 1, 0, '2026-06-11 08:44:51', '2026-07-07 11:53:40'),
(9, 'Premium Cotton T-Shirt', 'premium-cotton-t-shirt', '2', NULL, '2', '1', '100% organic Pima cotton with a relaxed fit. Pre-shrunk and garment-dyed for lasting comfort and color.', '[\"100% Organic Cotton\", \"Pre-Shrunk\", \"Relaxed Fit\", \"Eco-Friendly\"]', 46.00, NULL, '1781248266_var_0.jpg', '[\"1781255980_6a2bcf2c4057b_6.jpg\"]', NULL, 1, 0, '2026-06-12 07:11:06', '2026-06-13 06:37:22'),
(10, 'TON Player Edition Cricket Bat (Short Handle)', 'ton-player-edition-cricket-bat-short-handle', '1', 'NX-UYB-676', '5', '6', 'Perferendis ipsum q', '[\"Premium Air Dried English Willow Grade 1+\", \"Embossed Chrome sticker with Superb Grip\", \"Wide Play area with Clean bat face\", \"Premium / Portable SS Bat cover\"]', 259.00, 199.00, '1783401204.png', NULL, '4', 1, 0, '2026-07-07 05:04:43', '2026-07-08 12:39:33');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0FglkVyMHJtnkOCiq7fietF7xSEB69I88pxrFSzh', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJlNWJUdVkyN1AzbzFzRFBBazQ4bnJPZUtycjRjc3VJaE5lYkc4Q2xXIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1784089288),
('64sAKr0HB33yndZBGv6wANOxjyQORM6YKxXPTG7u', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJaa1ZPWnZRZ3AzVFFjbncyY3NXRHllNHJDUXJ3RkEwR3pKZ2p1bmVWIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1783484423),
('9HpULeHnuPEDXq4MJyEgUSeWpauWLQmsl2vIbAuf', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJoQWw5bUFucEVzaHA0ekx1Um9zYXpkckFmUUtXYnZHMUVUV2pJNmdKIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvcHJvZHVjdCIsInJvdXRlIjoiYWRtaW4ucHJvZHVjdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImFsZXJ0IjpbXSwiYWRtaW5faWQiOjF9', 1783681181),
('ASBTOklapEdYTkXuMS61CzlGeQIvERD2WGDX7Q90', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJnbGdmVzVuSm5DYW5EdTc4NlplaTNIQWJvWHR3eU1PdEpPY0pVaDk4IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvcHJvZHVjdCIsInJvdXRlIjoiYWRtaW4ucHJvZHVjdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImFsZXJ0IjpbXSwiYWRtaW5faWQiOjF9', 1783575778),
('cEWtEo1Yy5dsYyCezWgIdAwiiJ73QzC8D2Hsj70l', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJyRHprZnBqNFNYVXVNcXN6RURVcWVuMmxMM1VCdkI4dzVHbHhKMGNtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvb3JkZXIiLCJyb3V0ZSI6ImFkbWluLm9yZGVyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiYWxlcnQiOltdLCJhZG1pbl9pZCI6MX0=', 1783753544),
('EPeavedFBKLNqQLnMxmglovzhCn5HHeChYxtXGuX', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJPUVlnTVRYM05KMm5vVGQ3bkFyWU50ajM2WmQ3a3FyVXlUVjkyYVNkIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvb3JkZXIiLCJyb3V0ZSI6ImFkbWluLm9yZGVyIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiYWxlcnQiOltdLCJhZG1pbl9pZCI6MX0=', 1783431365),
('I2pWaT1tePhv4laJL2j1CsOrMJzWic2xvWrjjWOF', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJqUW85ckVuSnp6ajJBaldXemhOUU1RdjBpOFFCMDMyYm1Kbnh6b3dzIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTkyLjE2OC4wLjEyMTo4MDAwXC9vcmRlciIsInJvdXRlIjoiYWRtaW4ub3JkZXIifSwiYWxlcnQiOltdLCJhZG1pbl9pZCI6MX0=', 1783514485),
('Jkdr5oX6Cjd9PaHIuNV5AuFraSBoQYLbE7ugN2en', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ3SWd0NkxXbGlUZVZRM0ZnWm4wVWFHdkxORkJ4NkNqR3lSN2RtTG9UIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMCIsInJvdXRlIjoiYWRtaW4ifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJhbGVydCI6W10sImFkbWluX2lkIjoxfQ==', 1783744997),
('mxMDjtMbHPEgXOQ27YjFspNA04gJDskZPXkV5zds', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJhVTg3aGNIakVDZ2ZmMFlYbWs1WU9LR2xweXhuSlg5S1Y2QnBBdlNRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvbG9naW4iLCJyb3V0ZSI6ImFkbWluLmxvZ2luIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=', 1783657292),
('uC0569W9BfusRjfXdcmHCo83z318XRxuiYGOoUNL', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ4cVRUZHdqaVh0T0VzejZKam9uOFZFRXc0bTdKQk03UFFaZ2RCdDNtIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTkyLjE2OC4wLjEyMTo4MDAwXC9vcmRlciIsInJvdXRlIjoiYWRtaW4ub3JkZXIifSwiYWxlcnQiOltdLCJhZG1pbl9pZCI6MX0=', 1783667728),
('WnI3D5kiqOY6D4Nt35uridFLvY4dupMp9btK79ck', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJEVExuOXROWlZqa2hrVWxVV21wZU5pMWpQMnhyVm1hRmJjNWQ1U2F4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTkyLjE2OC4wLjEyMTo4MDAwIiwicm91dGUiOiJhZG1pbiJ9LCJhbGVydCI6W10sImFkbWluX2lkIjoxfQ==', 1784101293),
('XPhPOcJAjiFEeQYw2jZnsem98GY9OGnq5IIXXPle', NULL, '192.168.0.121', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ3YWpsRWpjNWtZUDRYdDVRMzNzVUdtMmpDd2VjRENlM3djMDVvZUNGIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzE5Mi4xNjguMC4xMjE6ODAwMFwvc3ViY2F0ZWdvcnkiLCJyb3V0ZSI6ImFkbWluLnN1YmNhdGVnb3J5In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwiYWxlcnQiOltdLCJhZG1pbl9pZCI6MX0=', 1784182751);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `category_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Inactive, 1: Active',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Not Deleted, 1: Deleted',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `name`, `slug`, `order_number`, `category_id`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 'T Shirt', 't-shirt', '0', '2', 1, 0, '2026-06-03 01:57:12', '2026-06-05 11:57:28'),
(2, 'Smart Home Speaker', 'smart-home-speaker', '0', '1', 1, 0, '2026-06-03 01:58:24', '2026-06-05 11:57:39'),
(3, 'Desk Accessories', 'desk-accessories', '0', '4', 1, 0, '2026-06-03 07:36:17', '2026-06-05 11:57:46'),
(4, 'Watch', 'watch', '1', '3', 1, 0, '2026-06-04 04:54:31', '2026-06-05 11:57:58'),
(5, 'Keyboard', 'keyboard', '1', '1', 1, 0, '2026-06-08 08:45:12', '2026-06-08 08:45:12'),
(6, 'Cricket', 'cricket', '1', '5', 1, 0, '2026-07-07 05:03:01', '2026-07-07 05:03:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `profile_image`, `email`, `email_verified_at`, `phone`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nayan', 'Sau', NULL, 'webgrity43@gmail.com', NULL, '6296750899', '$2y$12$tHBSJEE/L.FDrcTykJKm5OwSHDRSsn6ftY0EWDRR6wjnqyFFCdEzG', 1, NULL, '2026-06-05 09:22:32', '2026-06-19 12:10:50'),
(2, 'Quinn', 'Berry', 'user_1783512957.png', 'luro@mailinator.com', NULL, '9895258266', '$2y$12$SR49MylKDRmlaYzkOeWr/ekGIqyK4BBMSLIBl9XrkVqtLgba8aKW2', 1, NULL, '2026-06-18 11:57:30', '2026-07-08 12:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

DROP TABLE IF EXISTS `variants`;
CREATE TABLE IF NOT EXISTS `variants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `sku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `is_sale` tinyint(1) NOT NULL DEFAULT '0',
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `attributes` json DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  `featured_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_image` json DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `variants_sku_unique` (`sku`),
  KEY `variants_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `product_id`, `sku`, `price`, `is_sale`, `sale_price`, `stock`, `attributes`, `images`, `featured_image`, `gallery_image`, `is_active`, `is_default`, `created_at`, `updated_at`) VALUES
(10, 9, 'NX-TSH-T2TR', 59.00, 1, 49.00, 12, '[{\"name\": \"Color\", \"value\": {\"code\": \"#ffffff\", \"name\": \"White\"}}, {\"name\": \"Size\", \"value\": \"S\"}]', '1781248266_var_0.jpg', '1781248266_var_0.jpg', NULL, 1, 1, '2026-06-12 07:11:09', '2026-06-13 06:37:22'),
(11, 9, 'NX-TSH-ZZBK', 49.00, 0, NULL, 9, '[{\"name\": \"Color\", \"value\": {\"code\": \"#ffffff\", \"name\": \"White\"}}, {\"name\": \"Size\", \"value\": \"M\"}]', '1781248269_var_1.jpg', '1781248269_var_1.jpg', NULL, 1, 0, '2026-06-12 07:11:11', '2026-06-13 06:37:22'),
(12, 9, 'NX-TSH-UX9C', 58.00, 0, NULL, 6, '[{\"name\": \"Color\", \"value\": {\"code\": \"#ffffff\", \"name\": \"White\"}}, {\"name\": \"Size\", \"value\": \"L\"}]', '1781248271_var_2.jpg', '1781248271_var_2.jpg', NULL, 1, 0, '2026-06-12 07:11:14', '2026-06-13 06:37:22'),
(13, 9, 'NX-TSH-E37C', 49.00, 0, NULL, 14, '[{\"name\": \"Color\", \"value\": {\"code\": \"#000000\", \"name\": \"Black\"}}, {\"name\": \"Size\", \"value\": \"M\"}]', '1781248274_var_3.jpg', '1781248274_var_3.jpg', NULL, 1, 0, '2026-06-12 07:11:19', '2026-07-07 11:53:40'),
(14, 9, 'NX-TSH-JP6N', 59.00, 1, 52.00, 15, '[{\"name\": \"Color\", \"value\": {\"code\": \"#000000\", \"name\": \"Black\"}}, {\"name\": \"Size\", \"value\": \"L\"}]', '1781248279_var_4.jpg', '1781248279_var_4.jpg', NULL, 1, 0, '2026-06-12 07:11:24', '2026-06-13 06:37:22'),
(15, 9, 'NX-TSH-U9GV', 58.00, 1, 47.00, 11, '[{\"name\": \"Color\", \"value\": {\"code\": \"#000000\", \"name\": \"Black\"}}, {\"name\": \"Size\", \"value\": \"XL\"}]', '1781248284_var_5.jpg', '1781248284_var_5.jpg', NULL, 0, 0, '2026-06-12 07:11:29', '2026-06-13 06:37:22'),
(16, 9, 'NX-TSH-63H1', 59.00, 1, 46.00, 7, '[{\"name\": \"Color\", \"value\": {\"code\": \"#1e3a5f\", \"name\": \"Navy\"}}, {\"name\": \"Size\", \"value\": \"M\"}]', '1781255954_var_6.jpg', '1781255954_var_6.jpg', '[\"1781255980_6a2bcf2c4057b_6.jpg\"]', 1, 0, '2026-06-12 09:19:18', '2026-07-06 07:16:03'),
(17, 9, 'NX-TSH-ZW5S', 58.00, 1, 49.00, 0, '[{\"name\": \"Color\", \"value\": {\"code\": \"#1e3a5f\", \"name\": \"Navy\"}}, {\"name\": \"Size\", \"value\": \"L\"}]', NULL, '1781256225_var_7.jpg', '[\"1781256229_6a2bd0253d51f_7.jpg\", \"1781256234_6a2bd02aba2fc_7.jpg\"]', 1, 0, '2026-06-12 09:23:57', '2026-06-13 06:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `variant_attributes`
--

DROP TABLE IF EXISTS `variant_attributes`;
CREATE TABLE IF NOT EXISTS `variant_attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `attribute_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribute_values` json NOT NULL,
  `display_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'radio',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variant_attributes_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant_attributes`
--

INSERT INTO `variant_attributes` (`id`, `product_id`, `attribute_name`, `attribute_values`, `display_type`, `created_at`, `updated_at`) VALUES
(4, 9, 'Color', '[{\"code\": \"#ffffff\", \"name\": \"White\"}, {\"code\": \"#000000\", \"name\": \"Black\"}, {\"code\": \"#1e3a5f\", \"name\": \"Navy\"}]', 'color_picker', '2026-06-12 07:11:06', '2026-06-12 07:33:16'),
(5, 9, 'Size', '[\"S\", \"M\", \"L\", \"XL\"]', 'radio', '2026-06-12 07:11:06', '2026-06-12 07:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `u_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prd_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `u_id`, `prd_id`, `prd_type`, `sku`, `created_at`, `updated_at`) VALUES
(246, '1', '9', '2', 'NX-TSH-63H1', '2026-07-10 08:39:27', '2026-07-10 08:39:27');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `variant_attributes`
--
ALTER TABLE `variant_attributes`
  ADD CONSTRAINT `variant_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
