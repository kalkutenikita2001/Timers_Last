-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 08:43 AM
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
-- Database: `mybadmintondb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` enum('present','absent') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `date`, `time`, `status`, `created_at`) VALUES
(18, 267, '2025-09-19', '10:11:32', 'present', '2025-09-19 08:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `batch_level` enum('beginner','intermediate','advanced') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `category` enum('corporate','individual','group') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `center_id`, `batch_name`, `batch_level`, `start_time`, `end_time`, `start_date`, `end_date`, `duration`, `category`, `created_at`, `updated_at`) VALUES
(19, 21, 'First batch of 6', 'beginner', '14:21:00', '20:20:00', '2025-09-03', '2025-09-18', 500, 'individual', '2025-09-02 08:50:36', NULL),
(20, 21, 'First batch of 6', 'beginner', '14:21:00', '20:20:00', '2025-09-24', '2025-09-25', 500, 'individual', '2025-09-02 08:51:00', NULL),
(21, 22, 'First batcrrrrrrrrrrrh of 944566666', 'intermediate', '14:33:00', '19:32:00', '2025-09-03', '2025-09-17', 5, 'group', '2025-09-02 09:02:39', '2025-09-03 08:48:44'),
(23, 25, 'First batch of new center', 'beginner', '11:08:00', '17:07:00', '2025-09-09', '2025-09-30', 3, 'corporate', '2025-09-08 05:38:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `center_details`
--

CREATE TABLE `center_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `center_number` varchar(10) DEFAULT NULL,
  `address` text NOT NULL,
  `rent_amount` decimal(10,2) NOT NULL,
  `rent_paid_date` date NOT NULL,
  `center_timing_from` time NOT NULL,
  `center_timing_to` time NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `center_details`
--

INSERT INTO `center_details` (`id`, `name`, `center_number`, `address`, `rent_amount`, `rent_paid_date`, `center_timing_from`, `center_timing_to`, `password`, `created_at`, `updated_at`) VALUES
(20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '654', 'cddd', 7000.00, '2025-09-17', '12:34:00', '17:33:00', '$2y$10$LZRZ/5dVZduheCRw3PP15.A8dlRKdEdxfncr40/NbOGXhINe88Wfa', '2025-09-02 07:03:19', NULL),
(21, 'Nashik Centerrrttttgtfft', 'demo@123.c', 'gfyft', 7890.00, '2025-09-25', '14:21:00', '20:19:00', '$2y$10$a68LnHQBeOgmBSiuloBHCuHmf6cGqzvHgRRALZMIldG9kdhPi7Wxy', '2025-09-02 08:50:04', NULL),
(22, 'Nashik Center', 'demo@123.c', 'dfdfnnxn', 55555.00, '2025-09-23', '18:32:00', '20:32:00', '$2y$10$DgSbpQJU7ZJteOoWiudPDuIjKYgHpzaJuo2yqdQgbV9TOuRwj9.De', '2025-09-02 09:02:15', NULL),
(23, 'Updated Nashik Center34454yy567', '9995', 'Updated Address', 8000.00, '2025-09-30', '10:00:00', '18:00:00', '$2y$10$sCNYnrY0iRhdqXPUfQkwEuo5J.tfOB9H2F9RXvxQaXAGNHE80D5ee', '2025-09-02 09:45:43', '2025-09-02 15:47:58'),
(25, 'Newest Center', 'CEN-8173', 'Power House Colony, Tathawade, Pune', 5000.00, '2025-09-08', '13:08:00', '16:12:00', '$2y$10$5qRo/78LlJvWpKgv8MqQQ.1iAkcyQbR5HzqLR2XdKYhcQFNMpfDmy', '2025-09-08 05:37:21', NULL),
(26, 'reji', '247958', 'sdgaydiwaejk', 9880.00, '2025-09-15', '10:33:00', '12:33:00', '$2y$10$APRC/P8Nr6tkCv1ifdFgSuEaoWjaRfV0Rqeu8TrEPS/l3ZJQP8IG6', '2025-09-15 05:04:02', NULL),
(27, 'reji', '247958', 'kjkj', 120.00, '2025-10-05', '10:41:00', '23:41:00', '$2y$10$.oogn9IrJM.2Se5d6jGw2.zWLyqpSHuD5oWvN0Pb2xSAQxLTQzfWu', '2025-09-15 05:11:34', NULL),
(28, 'center1', '892', 'goa', 900.00, '2025-01-24', '10:45:00', '11:45:00', '$2y$10$bAjE/4i6yFY.4qEyENPxuedSbYBtefu27HfQBNHnlqhyA5dlbpDf2', '2025-09-15 05:15:30', NULL),
(29, 'center1', '23237', 'dhsif', 400.00, '2025-09-15', '10:48:00', '11:50:00', '$2y$10$HhTTPC2UbBLQYbOObiWBquUR7P4KtkAQyYaXFsXI83/i8WRIcaCIi', '2025-09-15 05:18:52', NULL),
(30, 'Nashik Center', '654', 'cdddd', 0.00, '0000-00-00', '00:00:00', '00:00:00', '$2y$10$ON2Q9VN2YpY.UimW09h/zewhRytrI8oUfEdz2X3qTwx...', '2025-09-15 12:25:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `center_permissions`
--

CREATE TABLE `center_permissions` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `permission_key` varchar(100) NOT NULL,
  `enabled` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `center_permissions`
--

INSERT INTO `center_permissions` (`id`, `center_id`, `permission_key`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 20, 'center_mgmt', 0, '2025-09-19 12:11:51', '2025-09-19 12:11:51'),
(2, 20, 'admission', 1, '2025-09-19 12:11:51', '2025-09-20 04:48:59'),
(3, 20, 'students', 1, '2025-09-19 12:11:51', '2025-09-19 12:11:51'),
(4, 20, 'events', 1, '2025-09-19 12:11:51', '2025-09-19 12:11:51'),
(5, 20, 'finance', 0, '2025-09-19 12:11:51', '2025-09-19 12:11:51'),
(6, 20, 'profile', 0, '2025-09-19 12:11:51', '2025-09-19 12:11:51'),
(7, 21, 'center_mgmt', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(8, 21, 'admission', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(9, 21, 'students', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(10, 21, 'events', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(11, 21, 'finance', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(12, 21, 'profile', 0, '2025-09-19 12:22:18', '2025-09-19 12:22:18'),
(13, 20, 'leave', 1, '2025-09-19 12:55:29', '2025-09-19 12:55:29');

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `id` int(50) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`id`, `name`, `email`, `mobile`) VALUES
(1, 'The coordinator', 'SampleCoordinator@gmail.com', 9736536632),
(2, 'The coordinator', 'SampleCoordinator@gmail.com', 9736536632);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_participants` int(11) NOT NULL,
  `venue` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date`, `time`, `fee`, `max_participants`, `venue`, `created_at`) VALUES
(1, 'team', 'A knockout', '2025-09-04', '15:58:00', 100.00, 5, 'center1', '2025-09-04 10:28:28'),
(2, 'Annual Marathon Run', 'A 10 km marathon to promote fitness and healthy lifestyle among students and staff.', '2025-09-04', '17:17:00', 150.00, 300, 'center2', '2025-09-04 10:47:46'),
(3, 'Intercollege Football Tournament', 'A knockout-style football tournament between top colleges in the city.', '2025-09-29', '10:35:00', 100.00, 100, 'center1', '2025-09-04 11:05:43'),
(5, 'xyz', 'abc', '2025-09-15', '18:48:00', 100.00, 10, 'nashik', '2025-09-04 12:19:03'),
(6, 'marathon', '200 m marathon ', '2025-09-08', '15:08:00', 200.00, 100, 'pune', '2025-09-08 09:39:06'),
(7, 'hoi', 'team', '2025-09-08', '15:11:00', 100.00, 15, 'diu', '2025-09-08 09:41:18'),
(8, 'volleyball', 'dubai special event', '2025-09-09', '15:14:00', 100.00, 20, 'center2', '2025-09-08 09:45:01'),
(9, 'team', 'hello', '2025-09-16', '12:49:00', 200.00, 200, 'nashik', '2025-09-16 07:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `center_id` int(11) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` enum('centerwise','own') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `added_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `center_id`, `title`, `date`, `amount`, `category`, `description`, `type`, `status`, `added_by`, `created_at`) VALUES
(1, 20, 'tennis mat', '2025-09-04', 2000.00, 'mat', 'done', '', 'approved', 'superadmin', '2025-09-04 10:08:51'),
(2, 20, 'mat', '2025-09-08', 1000.00, 'ground', 'done', '', 'approved', 'superadmin', '2025-09-08 09:11:36'),
(3, 20, 'fghhhj', '2025-09-15', 2000.00, 'fgfghgh', 'cvbgbnnhjhjhj', '', 'approved', 'superadmin', '2025-09-15 13:05:14'),
(4, 20, 'tennis bat', '2025-09-16', 2000.00, 'bat', 'important for playing', '', 'approved', 'superadmin', '2025-09-16 12:00:08'),
(5, 20, 'tennis bat', '2025-09-16', 2000.00, 'bat', 'important for playing', '', 'approved', 'superadmin', '2025-09-16 12:00:48'),
(6, 20, 'bat', '2025-09-16', 2000.00, 'cricket', 'playing', '', 'pending', 'admin', '2025-09-16 12:01:36'),
(7, 20, 'bat', '2025-09-16', 2000.00, 'cricket', 'playing', '', 'pending', 'admin', '2025-09-16 12:01:43'),
(8, 20, 'mts', '2025-09-16', 1000.00, 'done', 'bye', 'centerwise', 'approved', 'admin', '2025-09-16 12:05:26'),
(9, 25, 'tennis ball', '2025-09-16', 2000.00, 'ground', 'mat', '', 'approved', 'superadmin', '2025-09-16 12:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `center_id` int(11) DEFAULT NULL,
  `facility_name` varchar(100) NOT NULL,
  `subtype_name` varchar(100) DEFAULT NULL,
  `rent_amount` decimal(10,2) DEFAULT 0.00,
  `rent_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `center_id`, `facility_name`, `subtype_name`, `rent_amount`, `rent_date`, `created_at`, `updated_at`) VALUES
(11, NULL, 'shoes', NULL, 0.00, NULL, '2025-09-02 05:21:56', NULL),
(12, NULL, 'shoes', 'Small', 200.00, '2025-09-02', '2025-09-02 02:00:14', NULL),
(13, NULL, 'shoes', 'Small', 200.00, '2025-09-02', '2025-09-02 02:00:57', NULL),
(14, NULL, 'shoes', 'Small', 200.00, '2025-09-02', '2025-09-02 02:06:37', NULL),
(15, 19, 'shoes', 'Small', 200.00, '2025-09-02', '2025-09-02 03:19:10', NULL),
(16, 19, 'shoes', 'Small', 200.00, '2025-09-02', '2025-09-02 03:32:09', NULL),
(17, 19, 'shoes', 'big', 500.00, '2025-09-02', '2025-09-02 03:32:09', NULL),
(18, 23, 'Shoe', 'sports 94777757854 number', 5075.00, '2025-09-02', '2025-09-03 06:11:12', '2025-09-03 11:41:12'),
(19, 25, 'Swimming Pool', 'Small', 500.00, '2025-09-08', '2025-09-08 02:36:07', NULL),
(20, 25, 'Swimming Pool', 'Medium', 800.00, '2025-09-08', '2025-09-08 02:36:07', NULL),
(21, 25, 'Swimming Pool', 'Large', 1200.00, '2025-09-08', '2025-09-08 02:36:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `facility_subtypes`
--

CREATE TABLE `facility_subtypes` (
  `id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `subtype` varchar(255) NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility_subtypes`
--

INSERT INTO `facility_subtypes` (`id`, `facility_id`, `subtype`, `rent`, `created_at`, `updated_at`) VALUES
(1, 8, 'sports 9 number', 500.00, '2025-09-01 10:22:36', '2025-09-01 10:22:36'),
(3, 11, 'Small', 200.00, '2025-09-02 05:21:56', '2025-09-02 05:21:56');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `leave_type` varchar(100) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `center_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `user_id`, `user_name`, `applicant_name`, `role`, `leave_type`, `from_date`, `to_date`, `reason`, `status`, `center_name`, `created_at`, `updated_at`) VALUES
(1, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'xyz', 'Student', 'Sick', '2025-09-16', '2025-09-17', 'sadml;', 'approved', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-16 12:29:42', '2025-09-17 05:17:45'),
(2, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'dg', 'Staff', 'Sick', '2025-09-17', '2025-09-18', 'sick', 'approved', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-16 12:30:48', '2025-09-17 05:17:43'),
(3, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'dncxke', 'Student', 'Tournament', '2025-09-17', '2025-09-18', 'Tournament of pool ball', 'pending', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-17 04:25:19', '2025-09-17 05:17:40'),
(4, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'dxwkjd', 'Student', 'Tournament', '2025-09-18', '2025-09-19', 'done', 'pending', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-17 04:27:55', '2025-09-17 05:17:36'),
(5, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'dcwh', 'Student', 'Sick', '2025-09-17', '2025-09-17', 'dckjwjlk', 'approved', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-17 04:32:22', '2025-09-20 05:00:11'),
(6, 20, 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'admin', 'Staff', 'Emergency', '2025-09-17', '2025-09-19', 'sick', 'pending', 'Nashik Centerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', '2025-09-17 05:18:18', '2025-09-17 05:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `event_id`, `event_name`, `name`, `email`, `phone`, `address`, `created_at`) VALUES
(1, 3, NULL, 'neha', 'neha@gmail.com', '8767564534', 'nashik', '2025-09-05 06:14:30'),
(2, 5, 'xyz', 'niu', 'eeve@gmail.com', '8767564510', 'nashik', '2025-09-05 06:26:37'),
(3, 3, 'Intercollege Football Tournament', 'sid', 'sid12@gmail.com', '8767564531', 'diu', '2025-09-05 08:14:10'),
(4, 1, 'team', 'nikita', 'nik@gmail.com', '9878677898', 'goa', '2025-09-05 08:25:59'),
(5, 3, 'Intercollege Football Tournament', 'diya', 'di@gmail.com', '7883202345', 'aadsgdjkjdfkk', '2025-09-05 08:38:37'),
(6, 3, 'Intercollege Football Tournament', 'giya', 'giya@gmail.com', '7867564567', 'donebyebye', '2025-09-08 07:12:16'),
(7, 5, 'xyz', 'yashashree maam', 'rd9826150@gmail.com', '8767567890', 'goasswjdiu', '2025-09-08 09:18:23'),
(8, 6, 'marathon', 'done', 'done@gmail.com', '8978678780', 'nashikroad daghkjew', '2025-09-16 10:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `contact_no` varchar(15) NOT NULL,
  `role` enum('admin','manager','coach','support') NOT NULL,
  `joining_date` date NOT NULL,
  `assigned_batch` int(11) DEFAULT NULL,
  `coach_level` enum('beginner','intermediate','advanced') DEFAULT NULL,
  `coach_category` enum('corporate','individual','group') DEFAULT NULL,
  `coach_duration` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `center_id`, `staff_name`, `contact_no`, `role`, `joining_date`, `assigned_batch`, `coach_level`, `coach_category`, `coach_duration`, `created_at`, `updated_at`) VALUES
(10, 21, 'Prajwal Ramdas Wakulkar', '9455543563', 'manager', '2025-09-18', NULL, NULL, NULL, NULL, '2025-09-02 08:51:09', NULL),
(11, 23, 'Finee455ance Astrologer', '9455543563', 'admin', '2025-09-03', NULL, NULL, NULL, NULL, '2025-09-02 09:02:50', '2025-09-03 06:35:05'),
(12, 23, 'Prajwal UpdRRated', '9876543210', 'admin', '2025-09-15', 20, 'intermediate', 'corporate', 10, '2025-09-02 09:46:16', '2025-09-03 06:32:26'),
(13, 25, 'Badminton Manager', '8654647673', 'admin', '2025-09-08', NULL, NULL, NULL, NULL, '2025-09-08 05:38:34', NULL),
(14, 25, 'Badminton Coach', '9876543234', 'coach', '2025-09-09', 23, 'beginner', 'corporate', 5, '2025-09-08 05:39:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `emergency_contact` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `center_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `course_duration` int(11) NOT NULL,
  `student_progress_category` varchar(100) DEFAULT NULL,
  `coach` varchar(255) DEFAULT NULL,
  `coordinator` varchar(255) DEFAULT NULL,
  `coordinator_phone` varchar(20) DEFAULT NULL,
  `batch_time` time DEFAULT NULL,
  `duration` float DEFAULT NULL,
  `course_fees` decimal(10,2) DEFAULT NULL,
  `additional_fees` decimal(10,2) DEFAULT NULL,
  `total_fees` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `remaining_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` enum('Active','Deactive') DEFAULT 'Deactive',
  `last_attendance` date DEFAULT NULL,
  `unique_token` varchar(255) NOT NULL,
  `attendace_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `contact`, `parent_name`, `emergency_contact`, `email`, `dob`, `address`, `center_id`, `batch_id`, `course_duration`, `student_progress_category`, `coach`, `coordinator`, `coordinator_phone`, `batch_time`, `duration`, `course_fees`, `additional_fees`, `total_fees`, `paid_amount`, `remaining_amount`, `payment_method`, `admission_date`, `joining_date`, `created_at`, `status`, `last_attendance`, `unique_token`, `attendace_link`) VALUES
(201, 'Rushikesh Thomare', '7507973423', 'Aaba Thomare', '8080685050', 'rushithomare9@gmail.com', '2025-08-26', 'DGP Nager 2 Swapnapurti Ro-house No 8', 20, 10, 0, 'Beginner', 'Rohan', 'Rahul', '8989898899', '14:21:00', 1, 10000.00, 1000.00, 11000.00, 1000.00, 10000.00, 'Online', '2025-08-26', '2025-09-10', '2025-08-26 10:52:43', 'Deactive', NULL, '', ''),
(202, 'XYZ', '9322665933', 'Aaba Thomare', '8080685099', 'rushithomare9@gmail.com', '2025-08-26', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, 0, 'Beginner', 'Rohan', 'Rahul', '9322665933', '15:47:00', 1, 10000.00, 500.00, 10500.00, 1000.00, 9500.00, 'Online', '2025-01-01', '2025-10-30', '2025-08-26 12:20:19', 'Deactive', NULL, '', ''),
(203, 'Sadashiv Mohite', '9322665933', 'Xyz Mohite', '9876543234', 'sadashiv@gmail.com', '2025-08-26', 'Hinjewadi', 15, 16, 0, 'Intermediate', 'Rohan', 'Rahul', '9322665933', '17:37:00', 1, 1000.00, 300.00, 1300.00, 100.00, 1200.00, 'Online', '2025-08-26', '2025-08-26', '2025-08-26 14:08:37', 'Active', NULL, '', ''),
(204, 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, 0, 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', 3, 10000.00, 300.00, 10300.00, 1000.00, 9300.00, 'Online', '2025-08-28', '2025-08-28', '2025-08-28 10:56:16', 'Active', NULL, '', ''),
(237, 'Prajwal Ramdas Wakulkar', '8888888888', 'RMW', '7777778885', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 8000.00, 1200.00, 9200.00, 4000.00, 5200.00, 'Cash', '2025-09-08', '2025-09-09', '2025-09-08 17:07:12', 'Active', NULL, '', ''),
(238, 'Prajwal Ramdas Wakulkar', '9423377499', 'RMW', '8888888888', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 3, 'Beginner', NULL, NULL, NULL, NULL, NULL, 8000.00, 1200.00, 9200.00, 6000.00, 3200.00, 'Cash', '2025-09-09', '2025-09-09', '2025-09-09 10:42:51', 'Deactive', NULL, '', ''),
(239, 'Prajwal Ramdas Wakulkar', '9865433563', 'RMW', '7655433344', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 17000.00, 800.00, 17800.00, 5000.00, 12800.00, 'Cash', '2025-09-09', '2025-09-16', '2025-09-09 11:15:33', 'Deactive', NULL, '', ''),
(240, 'Prajwal Ramdas Wakulkar', '9865433563', 'RMW', '7655433344', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 17000.00, 800.00, 17800.00, 5000.00, 12800.00, 'Cash', '2025-09-09', '2025-09-16', '2025-09-09 11:15:33', 'Deactive', NULL, '', ''),
(241, 'Prajwal Ramdas Wakulkar', '9865433563', 'RMW', '7655433344', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 17000.00, 800.00, 17800.00, 5000.00, 12800.00, 'Cash', '2025-09-09', '2025-09-16', '2025-09-09 11:16:27', 'Deactive', NULL, '', ''),
(242, 'Prajwal Ramdas Wakulkar', '9865433563', 'RMW', '7655433344', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 17000.00, 800.00, 17800.00, 5000.00, 12800.00, 'Cash', '2025-09-09', '2025-09-16', '2025-09-09 11:18:15', 'Deactive', NULL, '', ''),
(243, 'Rushikesh Thomare', '7507973423', 'Aaba Thomare', '8080685050', 'rushithomare9@gmail.com', '0000-00-00', 'DGP Nagar 2, Swapnapurti Row-house No 8', 9, 10, 3, 'Beginner', NULL, NULL, NULL, NULL, NULL, 10000.00, 3000.00, 11000.00, 1000.00, 8000.00, 'Online', '0000-00-00', '0000-00-00', '2025-09-09 11:43:13', 'Deactive', NULL, '', ''),
(244, 'Prajwal Ramdas Wakulkar', '8888886743', 'RMW', '9778675633', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 70000.00, 20800.00, 'Cash', '2025-09-09', '2025-09-09', '2025-09-09 12:00:12', 'Deactive', NULL, '', ''),
(245, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:08:37', 'Deactive', NULL, '', ''),
(246, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:11:31', 'Deactive', NULL, '', ''),
(247, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:12:03', 'Deactive', NULL, '', ''),
(248, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:12:20', 'Deactive', NULL, '', ''),
(249, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:13:09', 'Deactive', NULL, '', ''),
(250, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:13:25', 'Deactive', NULL, '', ''),
(251, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 800.00, 90800.00, 8000.00, 82800.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:13:38', 'Deactive', NULL, '', ''),
(252, 'Prajwal Ramdas Wakulkar', '8767887545', 'RMW', '9786445443', 'wakulkarprajwal987@gmail.com', '2025-09-02', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 90000.00, 500.00, 90500.00, 8000.00, 82500.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 12:14:24', 'Deactive', NULL, '', ''),
(253, 'Prajwal Ramdas Wakulkar', '9786554324', 'RMW', '8765433454', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 99999.00, 800.00, 100799.00, 7000.00, 93799.00, 'Cash', '2025-09-09', '2025-09-09', '2025-09-09 12:18:59', 'Deactive', NULL, '', ''),
(254, 'Prajwal Ramdas Wakulkar', '9876543234', 'RMW', '7654676543', 'wakulkarprajwal987@gmail.com', '2025-09-08', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 7000.00, 500.00, 7500.00, 500.00, 7000.00, 'Cash', '2025-09-09', '2025-09-10', '2025-09-09 12:24:25', 'Deactive', NULL, '', ''),
(255, 'Prajwal Ramdas Wakulkar', '9876543234', 'RMW', '7654676543', 'wakulkarprajwal987@gmail.com', '2025-09-08', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 7000.00, 500.00, 7500.00, 500.00, 7000.00, 'Cash', '2025-09-09', '2025-09-10', '2025-09-09 12:24:57', 'Deactive', NULL, '', ''),
(256, 'Prajwal Ramdas Wakulkar', '9876543234', 'RMW', '7654676543', 'wakulkarprajwal987@gmail.com', '2025-09-08', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 7000.00, 500.00, 7500.00, 500.00, 7000.00, 'Cash', '2025-09-09', '2025-09-10', '2025-09-09 12:25:13', 'Deactive', NULL, '', ''),
(257, 'Prajwal Ramdas Wakulkar', '9876543234', 'RMW', '7654676543', 'wakulkarprajwal987@gmail.com', '2025-09-08', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 7000.00, 1200.00, 8200.00, 500.00, 7700.00, 'Cash', '2025-09-09', '2025-09-10', '2025-09-09 12:28:32', 'Deactive', NULL, '', ''),
(258, 'Prajwal Ramdas Wakulkar', '8779771471', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 9000.00, 1200.00, 10200.00, 500.00, 9700.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 13:07:10', 'Deactive', NULL, '', ''),
(259, 'Prajwal Ramdas Wakulkar', '8779771471', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 9000.00, 1200.00, 10200.00, 500.00, 9700.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 13:07:14', 'Deactive', NULL, '', ''),
(260, 'Prajwal Ramdas Wakulkar', '8779771471', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 9000.00, 1200.00, 10200.00, 500.00, 9700.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 13:07:19', 'Deactive', NULL, '', ''),
(261, 'Prajwal Ramdas Wakulkar', '8779771471', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-09', 'Power House Colony\r\nward. no. 2', 20, 23, 2, 'Intermediate', NULL, NULL, NULL, NULL, NULL, 9000.00, 1200.00, 10200.00, 500.00, 9700.00, 'Cash', '2025-09-09', '2025-10-01', '2025-09-09 13:07:23', 'Deactive', NULL, '', ''),
(262, 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 21, 19, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 12000.00, 1200.00, 102700.00, 102700.00, 0.00, 'UPI', '2025-09-09', '2025-09-19', '2025-09-09 16:50:48', 'Deactive', NULL, '', ''),
(263, 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 22, 21, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 200.00, 0.00, 200.00, 200.00, 0.00, 'Cash', '2025-09-18', '2025-09-20', '2025-09-18 14:10:01', 'Deactive', NULL, '', ''),
(264, 'ketan patil', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-03', 'Sec14, Near Maharashtra school', 22, 21, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 1000.00, 1000.00, 0.00, 'Cash', '2025-09-18', '2025-09-20', '2025-09-18 14:22:35', 'Deactive', NULL, '', ''),
(265, 'ketan', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-04', 'Sec14, Near Maharashtra school', 21, 19, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 2000.00, 0.00, 2000.00, 2000.00, 0.00, 'Cash', '2025-09-18', '2025-09-19', '2025-09-18 14:29:23', 'Deactive', NULL, '', ''),
(266, 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 22, 21, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 2000.00, 0.00, 2000.00, 1000.00, 1000.00, 'Cash', '2025-09-19', '2025-09-21', '2025-09-19 07:51:55', 'Deactive', NULL, '', ''),
(267, 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-02', 'Sec14, Near Maharashtra school', 21, 19, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 1000.00, 1000.00, 0.00, 'Cash', '2025-09-19', '2025-09-21', '2025-09-19 08:06:08', 'Deactive', NULL, 'a25ad68abf37ed20dad3cd6ca022b6f8', 'http://localhost/timersacademy-1/Admission/mark/a25ad68abf37ed20dad3cd6ca022b6f8'),
(268, 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-02', 'Sec14, Near Maharashtra school', 21, 19, 1, 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 1000.00, 1000.00, 0.00, 'Cash', '2025-09-19', '2025-09-21', '2025-09-19 08:06:17', 'Deactive', NULL, '848bcb37d6c73c42fc0db7f25f3a6fd6', 'http://localhost/timersacademy-1/Admission/mark/848bcb37d6c73c42fc0db7f25f3a6fd6');

-- --------------------------------------------------------

--
-- Table structure for table `student_addmission_history`
--

CREATE TABLE `student_addmission_history` (
  `history_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `parent_name` varchar(255) DEFAULT NULL,
  `emergency_contact` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `course_duration` varchar(50) DEFAULT NULL,
  `student_progress_category` varchar(50) DEFAULT NULL,
  `coach` varchar(255) DEFAULT NULL,
  `coordinator` varchar(255) DEFAULT NULL,
  `coordinator_phone` varchar(50) DEFAULT NULL,
  `batch_time` varchar(50) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `course_fees` decimal(10,2) DEFAULT NULL,
  `additional_fees` decimal(10,2) DEFAULT NULL,
  `total_fees` decimal(10,2) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `remaining_amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `admission_date` date DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  `last_attendance` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_addmission_history`
--

INSERT INTO `student_addmission_history` (`history_id`, `student_id`, `purpose`, `name`, `contact`, `parent_name`, `emergency_contact`, `email`, `dob`, `address`, `center_id`, `batch_id`, `course_duration`, `student_progress_category`, `coach`, `coordinator`, `coordinator_phone`, `batch_time`, `duration`, `course_fees`, `additional_fees`, `total_fees`, `paid_amount`, `remaining_amount`, `payment_method`, `admission_date`, `joining_date`, `created_at`, `status`, `last_attendance`, `updated_at`) VALUES
(1, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 21, 20, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 1000.00, 1200.00, -200.00, 'Cash', '2025-09-17', '2025-09-01', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:21:59'),
(2, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 21, 20, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 800.00, 100.00, 700.00, 'Cash', '2025-09-17', '2025-09-20', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:27:47'),
(3, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 20, 20, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 2800.00, 100.00, 2700.00, 'Cash', '2025-09-17', '2025-09-20', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:30:01'),
(4, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 20, 20, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 100.00, 0.00, 2800.00, 100.00, 2700.00, 'Cash', '2025-09-17', '2025-09-19', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:31:43'),
(5, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 20, 20, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 12000.00, 0.00, 16700.00, 10000.00, 6700.00, 'Cash', '2025-09-17', '2025-09-20', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:54:34'),
(6, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 21, 19, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 7700.00, 10000.00, 6700.00, 'Cash', '2025-09-17', '2025-09-21', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:55:15'),
(7, 267, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2025-09-10', 'Sec14, Near Maharashtra school', 20, 25, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 9700.00, 10000.00, 6700.00, 'Cash', '2025-09-17', '2025-09-21', '2025-09-17 07:50:16', 'Deactive', NULL, '2025-09-18 02:56:05'),
(8, 266, 'renew', 'Saurav Shahaji Nalawde', '9082483426', 'shahaji nalawade', '9082483426', 'saurv1220@gmail.com', '2001-12-20', 'Sec14, Near Maharashtra school', 21, 19, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 0.00, 1000.00, 100.00, 900.00, 'Cash', '2025-09-17', '2025-09-01', '2025-09-17 06:53:06', 'Active', NULL, '2025-09-18 03:10:50'),
(9, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 90000.00, 1200.00, 91200.00, 500.00, 90700.00, 'Cash', '2025-09-09', '2025-08-16', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:15:41'),
(10, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 90700.00, 1200.00, 183400.00, 18300.00, 165100.00, 'Cash', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:39:17'),
(11, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 2000.00, 1200.00, 167400.00, 167400.00, 165100.00, 'UPI', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:41:32'),
(12, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1200.00, 1200.00, 166300.00, 166300.00, 165100.00, 'Cash', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:44:38'),
(13, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1200.00, 1200.00, 166300.00, 166300.00, 165100.00, 'Cash', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:45:00'),
(14, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1200.00, 1200.00, 166300.00, 166300.00, 165100.00, 'Cash', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:46:09'),
(15, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 100.00, 1200.00, 165200.00, 1000.00, 164200.00, 'UPI', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:48:33'),
(16, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 1000.00, 164200.00, 'UPI', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:50:50'),
(17, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 1000.00, 164200.00, 'Cash', '2025-09-09', '2025-09-20', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:51:46'),
(18, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 10000000.00, 0.00, 'Cash', '2025-09-09', '2025-09-21', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:54:51'),
(19, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 10000000.00, 0.00, 'Cash', '2025-09-09', '2025-09-21', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:55:21'),
(20, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 10000000.00, 0.00, 'Cash', '2025-09-09', '2025-09-21', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:57:25'),
(21, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 10000000.00, 0.00, 'Cash', '2025-09-09', '2025-09-21', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 03:59:23'),
(22, 262, 'renew', 'Prajwal Ramdas Wakulkar sir', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 1000.00, 1200.00, 165200.00, 10000000.00, 0.00, 'Cash', '2025-09-09', '2025-09-21', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 04:00:13'),
(23, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, '0', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 10000.00, 300.00, 10300.00, 1000.00, 9300.00, 'Online', '2025-08-28', '2025-08-28', '2025-08-28 05:26:16', 'Active', NULL, '2025-09-18 04:44:16'),
(24, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, '0', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 2000.00, 300.00, 11300.00, 10000.00, 1300.00, 'UPI', '2025-08-28', '2025-09-21', '2025-08-28 05:26:16', 'Active', NULL, '2025-09-18 04:45:24'),
(25, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, '0', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 1000.00, 300.00, 2300.00, 2000.00, 300.00, 'Cash', '2025-08-28', '2025-09-21', '2025-08-28 05:26:16', 'Active', NULL, '2025-09-18 04:47:50'),
(26, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, '0', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 12000.00, 300.00, 12300.00, 3000.00, 9300.00, 'UPI', '2025-08-28', '2025-09-19', '2025-08-28 05:26:16', 'Active', NULL, '2025-09-18 04:50:16'),
(27, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, '0', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 2000.00, 300.00, 11300.00, 11300.00, 0.00, 'UPI', '2025-08-28', '2025-09-20', '2025-08-28 05:26:16', 'Active', NULL, '2025-09-18 05:13:58'),
(28, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 20, 25, '1', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 1000.00, 2000.00, 3000.00, 1000.00, 2000.00, 'UPI', '2025-08-28', '2025-09-19', '2025-08-28 05:26:16', 'Deactive', NULL, '2025-09-18 05:17:34'),
(29, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 20, 25, '1', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 1000.00, 2000.00, 5000.00, 2000.00, 3000.00, 'Cash', '2025-08-28', '2025-09-20', '2025-08-28 05:26:16', 'Deactive', NULL, '2025-09-18 05:19:05'),
(30, 204, 'renew', 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 20, 25, '1', 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', '3', 10000.00, 2000.00, 13000.00, 13000.00, 0.00, 'UPI', '2025-08-28', '2025-09-30', '2025-08-28 05:26:16', 'Deactive', NULL, '2025-09-18 05:23:27'),
(31, 203, 'renew', 'Sadashiv Mohite', '9322665933', 'Xyz Mohite', '9876543234', 'sadashiv@gmail.com', '2025-08-26', 'Hinjewadi', 15, 16, '0', 'Intermediate', 'Rohan', 'Rahul', '9322665933', '17:37:00', '1', 1000.00, 300.00, 1300.00, 100.00, 1200.00, 'Online', '2025-08-26', '2025-08-26', '2025-08-26 08:38:37', 'Active', NULL, '2025-09-18 05:30:55'),
(32, 262, 'renew', 'Prajwal Ramdas Wakulkar', '6246278991', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', '2025-09-01', 'Power House Colony\r\nward. no. 2', 20, 23, '1', 'Beginner', NULL, NULL, NULL, NULL, NULL, 90000.00, 1200.00, 91200.00, 500.00, 90700.00, 'Cash', '2025-09-09', '2025-08-16', '2025-09-09 11:20:48', 'Deactive', NULL, '2025-09-18 08:36:06');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendencelink`
--

CREATE TABLE `student_attendencelink` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `parent_name` varchar(100) DEFAULT NULL,
  `emergency_contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `center` varchar(100) NOT NULL,
  `batch` varchar(100) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `coach` varchar(100) DEFAULT NULL,
  `coordinator` varchar(100) DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `total_fees` decimal(10,2) NOT NULL,
  `course_fees` bigint(100) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `remaining_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `plan_expiry` date NOT NULL,
  `unique_token` varchar(64) NOT NULL,
  `attendace_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_attendencelink`
--

INSERT INTO `student_attendencelink` (`id`, `name`, `contact`, `parent_name`, `emergency_contact`, `email`, `address`, `center`, `batch`, `category`, `coach`, `coordinator`, `duration`, `total_fees`, `course_fees`, `amount_paid`, `remaining_amount`, `payment_method`, `plan_expiry`, `unique_token`, `attendace_link`, `created_at`) VALUES
(1, 'John Doe', '76543456543', 'ttttt', '6443333333', '4445566554', 'ygfddfd', '23', '23', '444', '333', '33', '334', 4555.00, 0, 566.00, 3989.00, 'cash', '2025-10-08', '4e767f8bff965db306c5dd7d686ec594', 'http://localhost/timersacademy_new/Student_controller/mark/4e767f8bff965db306c5dd7d686ec594', '2025-09-08 10:56:40'),
(2, 'John Doe', '76543456543', 'ttttt', '6443333333', '4445566554', 'ygfddfd', '23', '23', '444', '333', '33', '334', 4555.00, 0, 566.00, 3989.00, 'cash', '2025-10-08', '1a6ac88bc16321729a3a2f8ba04b77de', 'http://localhost/timersacademy_new/Student_controller/mark/1a6ac88bc16321729a3a2f8ba04b77de', '2025-09-08 10:57:44'),
(3, 'Prajwal Ramdas Wakulkar', '9876543245', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Beginner', NULL, NULL, NULL, 7800.00, 0, 5000.00, 7800.00, 'Cash', '2025-10-08', 'f3a3876817ed46c428de949fd604ac77', 'http://localhost/timersacademy_new/Student_controller/mark/f3a3876817ed46c428de949fd604ac77', '2025-09-08 11:06:23'),
(4, 'Prajwal Ramdas Wakulkar', '9876543245', 'RMW', '8765432454', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Beginner', NULL, NULL, NULL, 8200.00, 0, 5000.00, 8200.00, 'Cash', '2025-10-08', '00fa2b476bbc0e84e489d45143d2ee09', 'http://localhost/timersacademy_new/Student_controller/mark/00fa2b476bbc0e84e489d45143d2ee09', '2025-09-08 11:15:13'),
(5, 'Prajwal Ramdas Wakulkar', '9423377499', 'RMW', '9423377499', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Beginner', NULL, NULL, NULL, 19800.00, 0, 5000.00, 19800.00, 'Online', '2025-10-08', 'c3d168f7ecf9f7d00e1af5d9d1d64e25', 'http://localhost/timersacademy_new/Student_controller/mark/c3d168f7ecf9f7d00e1af5d9d1d64e25', '2025-09-08 14:01:55'),
(6, 'Prajwal Ramdas Wakulkar', '9876545674', 'RMW', '7777766666', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 1200.00, 0, 600.00, 1200.00, 'Cash', '2025-10-08', '040917e639a216673460f179271dc393', 'http://localhost/timersacademy_new/Student_controller/mark/040917e639a216673460f179271dc393', '2025-09-08 14:10:14'),
(7, 'Prajwal Ramdas Wakulkar', '7777777777', 'RMW', '7777777778', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 10200.00, 0, 2000.00, 10200.00, 'Cash', '2025-10-08', '6a0803c2271e9a2d22ddc436dc357507', 'http://localhost/timersacademy_new/Student_controller/mark/6a0803c2271e9a2d22ddc436dc357507', '2025-09-08 14:28:26'),
(8, 'Prajwal Ramdas Wakulkar', '8888888887', 'RMW', '7777777866', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 9200.00, 0, 2000.00, 9200.00, 'Cash', '2025-10-08', '8d1ae79d495b5704ab441698e383c713', 'http://localhost/timersacademy_new/Student_controller/mark/8d1ae79d495b5704ab441698e383c713', '2025-09-08 14:32:06'),
(9, 'Prajwal Ramdas Wakulkar', '8888888887', 'RMW', '7777777866', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 8800.00, 0, 2000.00, 8800.00, 'Cash', '2025-10-08', '1f32408425fcea252a6af5a44dd7ce22', 'http://localhost/timersacademy_new/Student_controller/mark/1f32408425fcea252a6af5a44dd7ce22', '2025-09-08 14:41:11'),
(10, 'Prajwal Ramdas Wakulkar', '8888888887', 'RMW', '7777777866', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 8800.00, 0, 2000.00, 8800.00, 'Cash', '2025-10-08', '1130de883d6469dbb93f777b333c0ff5', 'http://localhost/timersacademy_new/Student_controller/mark/1130de883d6469dbb93f777b333c0ff5', '2025-09-08 14:42:26'),
(13, 'Prajwal Ramdas Wakulkar', '8778737738', 'RMW', '8733783727', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Advanced', NULL, NULL, NULL, 9800.00, 0, 5000.00, 9800.00, 'Cash', '2025-10-08', '2a836b319ad12b370ac20797df42ac7d', 'http://localhost/timersacademy_new/Student_controller/mark/2a836b319ad12b370ac20797df42ac7d', '2025-09-08 14:54:27'),
(14, 'Prajwal Ramdas Wakulkar', '8778737738', 'RMW', '8733783727', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Advanced', NULL, NULL, NULL, 9800.00, 0, 5000.00, 9800.00, 'Cash', '2025-10-08', '44ac473588ba13f9606bb1c6247939b3', 'http://localhost/timersacademy_new/Student_controller/mark/44ac473588ba13f9606bb1c6247939b3', '2025-09-08 14:56:50'),
(15, 'Prajwal Ramdas Wakulkar', '9876675444', 'RMW', '8888888888', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 10200.00, 0, 4000.00, 10200.00, 'Cash', '2025-10-08', '3ca84fd511dcd0e8f513ed5ae064aee9', 'http://localhost/timersacademy_new/Student_controller/mark/3ca84fd511dcd0e8f513ed5ae064aee9', '2025-09-08 14:58:16'),
(16, 'Prajwal Ramdas Wakulkar', '8888888888', 'RMW', '7777778885', 'wakulkarprajwal987@gmail.com', 'Power House Colony\r\nward. no. 2', '25', '23', 'Intermediate', NULL, NULL, NULL, 9200.00, 0, 4000.00, 9200.00, 'Cash', '2025-10-08', '96abdf1553200eddb75dcff150562b3e', 'http://localhost/timersacademy_new/Student_controller/mark/96abdf1553200eddb75dcff150562b3e', '2025-09-08 15:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_facilities`
--

CREATE TABLE `student_facilities` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `facility_name` varchar(100) NOT NULL,
  `details` text DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_facilities`
--

INSERT INTO `student_facilities` (`id`, `student_id`, `facility_name`, `details`, `amount`, `created_at`) VALUES
(25, 201, 'Locker', 'Small (₹500), Locker No: Not selected', 500.00, '2025-08-26 10:52:43'),
(26, 201, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-26 10:52:43'),
(27, 201, 'Shoe Rental', 'Standard (₹200) for 1 month(s)', 200.00, '2025-08-26 10:52:43'),
(28, 202, 'Locker', 'Small (₹500), Locker No: Not selected', 500.00, '2025-08-26 12:20:19'),
(29, 203, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-26 14:08:37'),
(30, 204, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-28 10:56:16'),
(31, 205, 'Locker', 'Small (₹500), Locker No: Not selected', 500.00, '2025-08-30 12:04:23'),
(32, 205, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-30 12:04:23'),
(33, 205, 'Shoe Rental', 'Standard (₹200) for 1 month(s)', 200.00, '2025-08-30 12:04:23'),
(34, 213, '', '', 0.00, '2025-09-08 09:13:15'),
(35, 214, '', '', 0.00, '2025-09-08 09:13:25'),
(36, 215, '', '', 0.00, '2025-09-08 10:37:40'),
(37, 216, '', '', 0.00, '2025-09-08 10:42:58'),
(38, 217, '', '', 0.00, '2025-09-08 10:43:46'),
(39, 218, '', '', 0.00, '2025-09-08 10:48:01'),
(40, 219, '', '', 0.00, '2025-09-08 10:57:25'),
(41, 220, '', '', 0.00, '2025-09-08 13:04:33'),
(42, 221, '', '', 0.00, '2025-09-08 13:05:32'),
(43, 222, '', '', 0.00, '2025-09-08 13:06:00'),
(44, 223, '', '', 0.00, '2025-09-08 13:06:23'),
(45, 224, '', '', 0.00, '2025-09-08 13:15:13'),
(46, 225, '', '', 0.00, '2025-09-08 16:01:55'),
(47, 226, '', '', 0.00, '2025-09-08 16:10:14'),
(48, 227, '', '', 0.00, '2025-09-08 16:22:52'),
(49, 228, '', '', 0.00, '2025-09-08 16:28:26'),
(50, 229, '', '', 0.00, '2025-09-08 16:32:06'),
(51, 230, '', '', 0.00, '2025-09-08 16:41:10'),
(52, 231, '', '', 0.00, '2025-09-08 16:42:25'),
(53, 232, '', '', 0.00, '2025-09-08 16:46:38'),
(54, 233, '', '', 0.00, '2025-09-08 16:51:38'),
(55, 234, '', '', 0.00, '2025-09-08 16:54:27'),
(56, 235, '', '', 0.00, '2025-09-08 16:56:50'),
(57, 236, '', '', 0.00, '2025-09-08 16:58:16'),
(58, 237, '', '', 0.00, '2025-09-08 17:07:12');

-- --------------------------------------------------------

--
-- Table structure for table `student_facilities_history`
--

CREATE TABLE `student_facilities_history` (
  `history_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `facility_name` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT 'N/A',
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `purpose` varchar(50) NOT NULL,
  `history_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_facilities_history`
--

INSERT INTO `student_facilities_history` (`history_id`, `student_id`, `facility_name`, `details`, `amount`, `created_at`, `purpose`, `history_created_at`) VALUES
(1, 267, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 02:27:47', 'renew', '2025-09-18 02:30:01'),
(2, 267, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 02:31:43', 'renew', '2025-09-18 02:54:34'),
(3, 267, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 02:55:15', 'renew', '2025-09-18 02:56:05'),
(4, 266, 'Locker', 'Small (₹500), Locker No: Not selected', 500.00, '2025-08-26 05:22:43', 'renew', '2025-09-18 03:10:51'),
(5, 262, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 03:15:41', 'renew', '2025-09-18 03:39:17'),
(6, 262, 'Shoe', '\r\n                N/A (₹300.00)\r\n              ', 300.00, '2025-09-18 03:39:17', 'renew', '2025-09-18 03:41:32'),
(7, 204, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-28 05:26:16', 'renew', '2025-09-18 04:44:16'),
(8, 204, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 05:13:58', 'renew', '2025-09-18 05:17:34'),
(9, 204, 'Locker', '\r\n                N/A (₹2000.00)\r\n              ', 2000.00, '2025-09-18 05:17:34', 'renew', '2025-09-18 05:19:05'),
(10, 203, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-26 08:38:37', 'renew', '2025-09-18 05:30:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','superadmin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'superadmin', '$2y$10$CQGQL1M7HMs2Q1HmONUAmuQtx4CtwEfYGg13jgb/4N7x7du5N398u', 'superadmin', '2025-09-15 14:02:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `center_details`
--
ALTER TABLE `center_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `center_permissions`
--
ALTER TABLE `center_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_permission` (`center_id`,`permission_key`);

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `facility_subtypes`
--
ALTER TABLE `facility_subtypes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_facility` (`facility_id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`),
  ADD KEY `assigned_batch` (`assigned_batch`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `student_addmission_history`
--
ALTER TABLE `student_addmission_history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `student_attendencelink`
--
ALTER TABLE `student_attendencelink`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_token` (`unique_token`);

--
-- Indexes for table `student_facilities`
--
ALTER TABLE `student_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_facilities_history`
--
ALTER TABLE `student_facilities_history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `center_details`
--
ALTER TABLE `center_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `center_permissions`
--
ALTER TABLE `center_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `coordinator`
--
ALTER TABLE `coordinator`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `facility_subtypes`
--
ALTER TABLE `facility_subtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT for table `student_addmission_history`
--
ALTER TABLE `student_addmission_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `student_attendencelink`
--
ALTER TABLE `student_attendencelink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `student_facilities`
--
ALTER TABLE `student_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `student_facilities_history`
--
ALTER TABLE `student_facilities_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `center_permissions`
--
ALTER TABLE `center_permissions`
  ADD CONSTRAINT `center_permissions_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `center_details` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
