-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2020 at 04:21 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bimco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `code_table`
--

CREATE TABLE `code_table` (
  `id` int(11) NOT NULL,
  `element_code` varchar(10) NOT NULL,
  `serial_no` varchar(15) NOT NULL,
  `serial_date` date DEFAULT NULL,
  `comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `code_table`
--

INSERT INTO `code_table` (`id`, `element_code`, `serial_no`, `serial_date`, `comment`) VALUES
(1, '01', '2', NULL, 'user'),
(2, '02', '3', NULL, 'Contacts'),
(3, '03', '2', NULL, 'User Role'),
(4, '04', '5', NULL, 'Raw Product category'),
(5, '05', '3', NULL, 'Finished Product category'),
(6, '06', '2', NULL, 'Raw Product'),
(7, '07', '2', NULL, 'Finish Product'),
(8, '08', '9', NULL, 'Stock Code'),
(9, '09', '2', NULL, 'Formula Code'),
(10, '10', '2', NULL, 'Mixing Code'),
(11, '11', '2', NULL, 'Raw Lifting');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `contact_code` varchar(30) NOT NULL,
  `display_contact_id` varchar(30) NOT NULL,
  `contact_name` varchar(200) NOT NULL,
  `mobile_no` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `contact_code`, `display_contact_id`, `contact_name`, `mobile_no`, `email`, `address`, `opening_balance`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '9901', 'Safiq Uddin', '01626026705', 'rahima@gmail.com', NULL, NULL, 1, '1', '2020-02-02 20:41:24', '1', '2020-02-02 20:41:24'),
(2, '2', '9902', 'Hasan Alam', '01626026708', NULL, NULL, NULL, 1, '1', '2020-02-02 20:41:32', '1', '2020-02-07 22:33:29'),
(3, '3', '9903', 'Safiq Uddin', '01626026705', 'rahima@gmail.com', '35, Terokhadia, Cantonment Road, Rajshahi, Bangladesh\r\nCantonment', '11.00', 1, '1', '2020-02-06 22:49:23', '1', '2020-02-07 22:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_table`
--

CREATE TABLE `dictionary_table` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `title_code` varchar(50) NOT NULL,
  `title_type` varchar(30) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `extra_raw_lifting_details`
--

CREATE TABLE `extra_raw_lifting_details` (
  `id` int(11) NOT NULL,
  `lifting_code` varchar(30) NOT NULL,
  `reference_no` varchar(30) NOT NULL,
  `raw_product` varchar(30) NOT NULL,
  `raw_rate` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extra_raw_lifting_details`
--

INSERT INTO `extra_raw_lifting_details` (`id`, `lifting_code`, `reference_no`, `raw_product`, `raw_rate`, `quantity`, `amount`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', 'bm5e36e23905382', '1', 101.83673469388, 1, 101.83673469388, 1, '1', '2020-02-02 20:52:40', '1', '2020-02-02 20:53:23'),
(2, '2', 'bm5e36e24220410', '2', 52.368421052632, 2, 104.73684210526, 1, '1', '2020-02-02 20:52:49', '1', '2020-02-02 20:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `extra_raw_lifting_summary`
--

CREATE TABLE `extra_raw_lifting_summary` (
  `id` int(11) NOT NULL,
  `lifting_code` varchar(30) NOT NULL,
  `stock_code` varchar(30) NOT NULL,
  `lifting_date` date NOT NULL,
  `total_cost` double NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `extra_raw_lifting_summary`
--

INSERT INTO `extra_raw_lifting_summary` (`id`, `lifting_code`, `stock_code`, `lifting_date`, `total_cost`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '7', '2020-02-03', 101.83673469388, 1, '1', '2020-02-02 20:52:40', '1', '2020-02-02 20:53:23'),
(2, '2', '8', '2020-02-06', 104.73684210526, 1, '1', '2020-02-02 20:52:49', '1', '2020-02-02 20:53:31');

-- --------------------------------------------------------

--
-- Table structure for table `finish_category`
--

CREATE TABLE `finish_category` (
  `id` int(11) NOT NULL,
  `category_code` varchar(30) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `finish_category`
--

INSERT INTO `finish_category` (`id`, `category_code`, `category_name`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', 'Finished Category 1', 1, '1', '2020-02-02 20:46:02', '1', '2020-02-02 20:46:02'),
(2, '2', 'Finished Category 2', 1, '1', '2020-02-02 20:46:04', '1', '2020-02-02 20:46:04'),
(3, '3', 'Finished Category 3', 1, '1', '2020-02-02 20:46:58', '1', '2020-02-02 20:46:58');

-- --------------------------------------------------------

--
-- Table structure for table `finish_product`
--

CREATE TABLE `finish_product` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `product_code` varchar(30) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `pack_size` varchar(200) DEFAULT NULL,
  `unit_name` varchar(200) DEFAULT NULL,
  `trade_price` decimal(20,2) DEFAULT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `finish_product`
--

INSERT INTO `finish_product` (`id`, `category`, `product_code`, `product_name`, `pack_size`, `unit_name`, `trade_price`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '1', 'Finish Good 1', '100 Gram', 'Piece', '200.00', 1, '1', '2020-02-02 20:49:52', '1', '2020-02-02 20:49:52'),
(2, '1', '2', 'Finish Good 2', '500GM', 'Piece', '250.00', 1, '1', '2020-02-02 20:50:08', '1', '2020-02-02 20:50:08');

-- --------------------------------------------------------

--
-- Table structure for table `formula_details`
--

CREATE TABLE `formula_details` (
  `id` int(11) NOT NULL,
  `formula_code` varchar(30) NOT NULL,
  `reference_no` varchar(30) NOT NULL,
  `raw_product` varchar(30) NOT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formula_details`
--

INSERT INTO `formula_details` (`id`, `formula_code`, `reference_no`, `raw_product`, `quantity`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', 'bm5e36e1b45ca11', '1', 2, 1, '1', '2020-02-02 20:50:28', '1', '2020-02-02 20:50:53'),
(2, '2', 'bm5e36e1c5f419c', '2', 3, 2, '1', '2020-02-02 20:50:45', '1', '2020-02-02 20:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `formula_summary`
--

CREATE TABLE `formula_summary` (
  `id` int(11) NOT NULL,
  `formula_code` varchar(30) NOT NULL,
  `finish_product` varchar(30) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `multi_formula_active` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formula_summary`
--

INSERT INTO `formula_summary` (`id`, `formula_code`, `finish_product`, `is_active`, `multi_formula_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '1', 1, 1, '1', '2020-02-02 20:50:28', '1', '2020-02-02 20:50:53'),
(2, '2', '2', 2, 0, '1', '2020-02-02 20:50:45', '1', '2020-02-02 20:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `mixing_details`
--

CREATE TABLE `mixing_details` (
  `id` int(11) NOT NULL,
  `mixing_code` varchar(30) NOT NULL,
  `reference_no` varchar(30) NOT NULL,
  `raw_product` varchar(30) NOT NULL,
  `raw_rate` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `raw_type` varchar(20) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mixing_details`
--

INSERT INTO `mixing_details` (`id`, `mixing_code`, `reference_no`, `raw_product`, `raw_rate`, `quantity`, `amount`, `raw_type`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', 'bm5e36e1ecdfa3b', '1', 101.83673469388, 2, 203.67346938776, 'finish_good', 1, '1', '2020-02-02 20:51:24', '1', '2020-02-02 20:52:14'),
(2, '2', 'bm5e36e2138d8e4', '1', 101.83673469388, 2, 203.67346938776, 'finish_good', 1, '1', '2020-02-02 20:52:03', '1', '2020-02-02 20:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `mixing_summary`
--

CREATE TABLE `mixing_summary` (
  `id` int(11) NOT NULL,
  `mixing_code` varchar(30) NOT NULL,
  `stock_code` varchar(30) NOT NULL,
  `finish_product` varchar(30) NOT NULL,
  `mixing_date` date NOT NULL,
  `pack_size` varchar(200) NOT NULL,
  `finish_good_quantity` double NOT NULL,
  `batch_no` varchar(100) NOT NULL,
  `manufacture_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `mixing_for_year` varchar(5) NOT NULL,
  `formulation_cost` double NOT NULL,
  `extra_cost` double NOT NULL,
  `total_cost` double NOT NULL,
  `purchase_cost_per_unit` double NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mixing_summary`
--

INSERT INTO `mixing_summary` (`id`, `mixing_code`, `stock_code`, `finish_product`, `mixing_date`, `pack_size`, `finish_good_quantity`, `batch_no`, `manufacture_date`, `expiry_date`, `mixing_for_year`, `formulation_cost`, `extra_cost`, `total_cost`, `purchase_cost_per_unit`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '5', '1', '2020-02-03', '100 Gram', 2, '123', '2020-02-04', '2021-02-04', '1', 407.34693877552, 0, 407.34693877552, 203.67346938776, 1, '1', '2020-02-02 20:51:24', '1', '2020-02-02 20:52:14'),
(2, '2', '6', '1', '2020-02-05', '100 Gram', 3, '1233', '2020-02-05', '2021-02-05', '1', 611.02040816328, 0, 611.02040816328, 203.67346938776, 1, '1', '2020-02-02 20:52:03', '1', '2020-02-02 20:52:23');

-- --------------------------------------------------------

--
-- Table structure for table `raw_category`
--

CREATE TABLE `raw_category` (
  `id` int(11) NOT NULL,
  `category_code` varchar(30) NOT NULL,
  `display_category_id` varchar(30) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_category`
--

INSERT INTO `raw_category` (`id`, `category_code`, `display_category_id`, `category_name`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '8804', 'Raw Category 1', 1, '1', '2020-02-02 20:41:41', '1', '2020-02-08 11:47:07'),
(2, '2', '8802', 'Raw Category 2', 1, '1', '2020-02-02 20:41:44', '1', '2020-02-02 20:41:44'),
(3, '3', '8803', 'Raw Category 3', 1, '1', '2020-02-06 23:08:31', '1', '2020-02-06 23:08:31'),
(4, '4', '8805', 'Raw Category 5', 1, '1', '2020-02-08 11:47:27', '1', '2020-02-08 11:47:27'),
(5, '5', '8806', 'Raw Category 7', 1, '1', '2020-02-08 11:48:39', '1', '2020-02-08 11:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `raw_product`
--

CREATE TABLE `raw_product` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `product_code` varchar(30) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `avg_purchase_rate` double NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raw_product`
--

INSERT INTO `raw_product` (`id`, `category`, `product_code`, `product_name`, `avg_purchase_rate`, `is_active`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '1', 'Raw Product 1', 101.83673469388, 1, '1', '2020-02-02 20:43:54', '1', '2020-02-02 20:45:47'),
(2, '1', '2', 'Raw Product 2', 52.368421052632, 1, '1', '2020-02-02 20:44:01', '1', '2020-02-02 20:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `stock_details`
--

CREATE TABLE `stock_details` (
  `id` int(11) NOT NULL,
  `stock_code` varchar(30) NOT NULL,
  `reference_no` varchar(30) NOT NULL,
  `product` varchar(30) NOT NULL,
  `vendor` varchar(30) DEFAULT NULL,
  `particulars` varchar(300) DEFAULT NULL,
  `rate` double NOT NULL DEFAULT 0,
  `stock_in_quantity` double NOT NULL DEFAULT 0,
  `stock_out_quantity` double NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `stock_type` varchar(20) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `is_raw_return` int(11) NOT NULL DEFAULT 0,
  `stock_variant_type` varchar(30) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_details`
--

INSERT INTO `stock_details` (`id`, `stock_code`, `reference_no`, `product`, `vendor`, `particulars`, `rate`, `stock_in_quantity`, `stock_out_quantity`, `amount`, `stock_type`, `is_active`, `is_raw_return`, `stock_variant_type`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', 'bm5e36e04ca629d', '1', '1', NULL, 100, 100, 0, 10000, 'stock_in', 1, 0, 'add_raw_in', '1', '2020-02-02 20:44:28', '1', '2020-02-02 20:45:01'),
(2, '2', 'bm5e36e06485d91', '2', '2', NULL, 50, 20, 0, 1000, 'stock_in', 1, 0, 'add_raw_in', '1', '2020-02-02 20:44:52', '1', '2020-02-02 20:45:07'),
(3, '3', 'bm5e36e087d2fdd', '1', '1', NULL, 10, 0, 2, 20, 'stock_out', 1, 1, 'raw_return_out', '1', '2020-02-02 20:45:27', '1', '2020-02-02 20:45:47'),
(4, '4', 'bm5e36e0940ac9a', '2', '2', NULL, 5, 0, 1, 5, 'stock_out', 1, 1, 'raw_return_out', '1', '2020-02-02 20:45:39', '1', '2020-02-02 20:45:53'),
(5, '5', 'bm5e36e1ecdfb2e', '1', NULL, NULL, 101.83673469388, 0, 2, 203.67346938776, 'stock_out', 1, 0, 'mixing_out', '1', '2020-02-02 20:51:24', '1', '2020-02-02 20:52:14'),
(6, '6', 'bm5e36e2138dbfa', '1', NULL, NULL, 101.83673469388, 0, 2, 203.67346938776, 'stock_out', 1, 0, 'mixing_out', '1', '2020-02-02 20:52:03', '1', '2020-02-02 20:52:23'),
(7, '7', 'bm5e36e239054e3', '1', NULL, NULL, 101.83673469388, 0, 1, 101.83673469388, 'stock_out', 1, 0, 'extra_raw_out', '1', '2020-02-02 20:52:40', '1', '2020-02-02 20:53:23'),
(8, '8', 'bm5e36e242205cb', '2', NULL, NULL, 52.368421052632, 0, 2, 104.73684210526, 'stock_out', 1, 0, 'extra_raw_out', '1', '2020-02-02 20:52:49', '1', '2020-02-02 20:53:31'),
(9, '9', 'bm5e36e2a305130', '2', '1', NULL, 122, 20, 0, 2440, 'stock_in', 4, 0, 'add_raw_in', '1', '2020-02-02 20:54:26', '1', '2020-02-08 00:51:57');

-- --------------------------------------------------------

--
-- Table structure for table `stock_summary`
--

CREATE TABLE `stock_summary` (
  `id` int(11) NOT NULL,
  `stock_code` varchar(30) NOT NULL,
  `stock_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `stock_type` varchar(20) NOT NULL,
  `total_amount` double NOT NULL DEFAULT 0,
  `is_active` int(11) NOT NULL DEFAULT 2,
  `is_raw_return` int(11) NOT NULL DEFAULT 0,
  `stock_variant_type` varchar(30) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock_summary`
--

INSERT INTO `stock_summary` (`id`, `stock_code`, `stock_date`, `description`, `stock_type`, `total_amount`, `is_active`, `is_raw_return`, `stock_variant_type`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`) VALUES
(1, '1', '2020-02-03', NULL, 'stock_in', 10000, 1, 0, 'add_raw_in', '1', '2020-02-02 20:44:28', '1', '2020-02-02 20:45:01'),
(2, '2', '2020-02-03', NULL, 'stock_in', 1000, 1, 0, 'add_raw_in', '1', '2020-02-02 20:44:52', '1', '2020-02-02 20:45:07'),
(3, '3', '2020-02-03', NULL, 'stock_out', 20, 1, 1, 'raw_return_out', '1', '2020-02-02 20:45:27', '1', '2020-02-02 20:45:47'),
(4, '4', '2020-02-03', NULL, 'stock_out', 5, 1, 1, 'raw_return_out', '1', '2020-02-02 20:45:39', '1', '2020-02-02 20:45:53'),
(5, '5', '2020-02-03', NULL, 'stock_out', 407.34693877552, 1, 0, 'mixing_out', '1', '2020-02-02 20:51:24', '1', '2020-02-02 20:52:14'),
(6, '6', '2020-02-05', NULL, 'stock_out', 611.02040816328, 1, 0, 'mixing_out', '1', '2020-02-02 20:52:03', '1', '2020-02-02 20:52:23'),
(7, '7', '2020-02-03', NULL, 'stock_out', 101.83673469388, 1, 0, 'extra_raw_out', '1', '2020-02-02 20:52:40', '1', '2020-02-02 20:53:23'),
(8, '8', '2020-02-06', NULL, 'stock_out', 104.73684210526, 1, 0, 'extra_raw_out', '1', '2020-02-02 20:52:49', '1', '2020-02-02 20:53:31'),
(9, '9', '2020-02-05', NULL, 'stock_in', 2440, 4, 0, 'add_raw_in', '1', '2020-02-02 20:54:26', '1', '2020-02-08 00:51:57');

-- --------------------------------------------------------

--
-- Stand-in structure for view `stock_view`
-- (See below for the actual view)
--
CREATE TABLE `stock_view` (
`product` varchar(30)
,`total_stock_in_quantity` double
,`total_stock_out_quantity` double
,`current_stock_quantity` double
);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `profile_image` varchar(50) DEFAULT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `full_name`, `email`, `mobile_no`, `address`, `profile_image`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`, `is_active`) VALUES
(1, '1', 'Rifat Sakib', 'rifatsakib230@gmail.com', '01945882352', 'Dhaka', 'img.jpg', '1', '2019-04-22 02:00:00', '1', '2020-01-08 22:29:35', 1),
(3, '2', 'Rahim Uddin', 'rifatsakib230@gmail.com', '01626026705', NULL, NULL, '1', '2020-02-02 20:40:21', '1', '2020-02-02 20:40:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `password_reset_code` varchar(6) DEFAULT NULL,
  `user_role` varchar(30) NOT NULL DEFAULT '0',
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `user_id`, `username`, `password`, `password_reset_code`, `user_role`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`, `is_active`) VALUES
(1, '1', '01945882352', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '1', '1', '2019-04-22 02:00:00', '1', '2020-01-08 23:29:22', 1),
(3, '2', '01626026705', '81dc9bdb52d04dc20036dbd8313ed055', NULL, '1', '1', '2020-02-02 20:40:21', '1', '2020-02-02 20:40:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role_code` varchar(30) NOT NULL,
  `role_title` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `permitted_page_code` text DEFAULT NULL,
  `permitted_action_code` text DEFAULT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_dt_tm` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_dt_tm` datetime NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role_code`, `role_title`, `permitted_page_code`, `permitted_action_code`, `created_by`, `created_dt_tm`, `updated_by`, `updated_dt_tm`, `is_active`) VALUES
(1, '1', 'Admin', '01,09,02,03,05,07,12,04,06,08,10,11,13,16', '01,03,04,22,23,24,06,07,08,09,10,11,25,12,13,14,15,16,17,18,19,20,21,26', '1', '2019-04-22 01:00:00', '1', '2020-01-06 23:22:14', 1),
(2, '2', 'Checker', '07', '03', '1', '2020-02-02 20:40:59', '1', '2020-02-02 20:40:59', 1);

-- --------------------------------------------------------

--
-- Structure for view `stock_view`
--
DROP TABLE IF EXISTS `stock_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `stock_view`  AS  select `stock_details`.`product` AS `product`,sum(`stock_details`.`stock_in_quantity`) AS `total_stock_in_quantity`,sum(`stock_details`.`stock_out_quantity`) AS `total_stock_out_quantity`,sum(`stock_details`.`stock_in_quantity`) - sum(`stock_details`.`stock_out_quantity`) AS `current_stock_quantity` from `stock_details` where `stock_details`.`is_active` = '1' group by `stock_details`.`product` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `code_table`
--
ALTER TABLE `code_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `element_code` (`element_code`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_code` (`contact_code`);

--
-- Indexes for table `dictionary_table`
--
ALTER TABLE `dictionary_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_code` (`title_code`);

--
-- Indexes for table `extra_raw_lifting_details`
--
ALTER TABLE `extra_raw_lifting_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_raw_lifting_summary`
--
ALTER TABLE `extra_raw_lifting_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish_category`
--
ALTER TABLE `finish_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `finish_product`
--
ALTER TABLE `finish_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `formula_details`
--
ALTER TABLE `formula_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `formula_summary`
--
ALTER TABLE `formula_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mixing_details`
--
ALTER TABLE `mixing_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mixing_summary`
--
ALTER TABLE `mixing_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_category`
--
ALTER TABLE `raw_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raw_product`
--
ALTER TABLE `raw_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_code` (`product_code`);

--
-- Indexes for table `stock_details`
--
ALTER TABLE `stock_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_summary`
--
ALTER TABLE `stock_summary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_no` (`mobile_no`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `code_table`
--
ALTER TABLE `code_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dictionary_table`
--
ALTER TABLE `dictionary_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extra_raw_lifting_details`
--
ALTER TABLE `extra_raw_lifting_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `extra_raw_lifting_summary`
--
ALTER TABLE `extra_raw_lifting_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `finish_category`
--
ALTER TABLE `finish_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `finish_product`
--
ALTER TABLE `finish_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `formula_details`
--
ALTER TABLE `formula_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `formula_summary`
--
ALTER TABLE `formula_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mixing_details`
--
ALTER TABLE `mixing_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mixing_summary`
--
ALTER TABLE `mixing_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `raw_category`
--
ALTER TABLE `raw_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `raw_product`
--
ALTER TABLE `raw_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_details`
--
ALTER TABLE `stock_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_summary`
--
ALTER TABLE `stock_summary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
