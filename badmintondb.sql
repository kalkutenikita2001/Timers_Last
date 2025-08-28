-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 28, 2025 at 11:01 AM
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
-- Database: `badmintondb`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `timing` time NOT NULL,
  `start_date` date NOT NULL,
  `category` enum('Beginner','Intermediate','Advanced') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id`, `center_id`, `timing`, `start_date`, `category`, `created_at`) VALUES
(10, 9, '14:19:00', '2025-08-26', 'Beginner', '2025-08-26 05:20:12'),
(16, 15, '16:10:00', '2025-08-26', 'Beginner', '2025-08-26 07:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `centers`
--

CREATE TABLE `centers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `timing` time NOT NULL,
  `rent` decimal(10,2) NOT NULL,
  `rent_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `centers`
--

INSERT INTO `centers` (`id`, `name`, `timing`, `rent`, `rent_date`, `created_at`) VALUES
(9, 'Center-A', '14:19:00', 100.00, '2025-08-26', '2025-08-26 05:20:12'),
(15, 'ABC', '16:10:00', 123.00, '2025-08-26', '2025-08-26 07:10:41');

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
  `fee` decimal(10,2) NOT NULL,
  `max_participants` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `description`, `date`, `time`, `fee`, `max_participants`, `created_at`) VALUES
(3, 'ABC', 'sds', '2025-08-26', '15:56:00', 1234.00, 1234, '2025-08-26 10:26:57');

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
  `type` enum('centerwise','own') NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `type` enum('Locker','Shoe','Racket') NOT NULL,
  `locker_no` varchar(50) DEFAULT NULL,
  `rent` decimal(10,2) NOT NULL,
  `rent_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `center_id`, `type`, `locker_no`, `rent`, `rent_date`, `created_at`) VALUES
(10, 9, 'Locker', '1', 100.00, '2025-08-26', '2025-08-26 05:20:12'),
(16, 15, 'Shoe', '2', 100.00, '2025-08-26', '2025-08-26 07:10:41');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `center_id` int(11) NOT NULL,
  `category` enum('coach','co-ordinator') NOT NULL,
  `name` varchar(255) NOT NULL,
  `timing` time NOT NULL,
  `join_date` date NOT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `contact` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `center_id`, `category`, `name`, `timing`, `join_date`, `batch_id`, `contact`, `address`, `created_at`) VALUES
(9, 9, 'coach', 'Ganesh', '14:19:00', '2025-09-02', 10, '9876543212', 'Nashik', '2025-08-26 05:20:12'),
(10, 15, 'coach', 'Virapan', '16:10:00', '2025-08-26', 16, '9876545678', 'pune', '2025-08-26 07:10:41');

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
  `category` varchar(100) DEFAULT NULL,
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
  `status` enum('Active','Deactive') DEFAULT 'Active',
  `last_attendance` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `contact`, `parent_name`, `emergency_contact`, `email`, `dob`, `address`, `center_id`, `batch_id`, `category`, `coach`, `coordinator`, `coordinator_phone`, `batch_time`, `duration`, `course_fees`, `additional_fees`, `total_fees`, `paid_amount`, `remaining_amount`, `payment_method`, `admission_date`, `joining_date`, `created_at`, `status`, `last_attendance`) VALUES
(201, 'Rushikesh Thomare', '7507973423', 'Aaba Thomare', '8080685050', 'rushithomare9@gmail.com', '2025-08-26', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, 'Beginner', 'Rohan', 'Rahul', '8989898899', '14:21:00', 1, 10000.00, 1000.00, 11000.00, 1000.00, 10000.00, 'Online', '2025-08-26', '2025-08-26', '2025-08-26 10:52:43', 'Active', NULL),
(202, 'XYZ', '9322665933', 'Aaba Thomare', '8080685099', 'rushithomare9@gmail.com', '2025-08-26', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, 'Beginner', 'Rohan', 'Rahul', '9322665933', '15:47:00', 1, 10000.00, 500.00, 10500.00, 1000.00, 9500.00, 'Online', '2025-01-01', '2025-01-01', '2025-08-26 12:20:19', 'Deactive', NULL),
(203, 'Sadashiv Mohite', '9322665933', 'Xyz Mohite', '9876543234', 'sadashiv@gmail.com', '2025-08-26', 'Hinjewadi', 15, 16, 'Intermediate', 'Rohan', 'Rahul', '9322665933', '17:37:00', 1, 1000.00, 300.00, 1300.00, 100.00, 1200.00, 'Online', '2025-08-26', '2025-08-26', '2025-08-26 14:08:37', 'Active', NULL),
(204, 'Rushikesh Thomare', '9876543234', 'Aaba Thomare', '9876543234', 'rushithomare9@gmail.com', '2025-08-28', 'DGP Nager 2 Swapnapurti Ro-house No 8', 9, 10, 'Beginner', 'Rohan', 'Rahul', '9876543234', '14:25:00', 3, 10000.00, 300.00, 10300.00, 1000.00, 9300.00, 'Online', '2025-08-28', '2025-08-28', '2025-08-28 10:56:16', 'Active', NULL);

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
(30, 204, 'Racket Rental', 'Standard (₹300) for 1 month(s)', 300.00, '2025-08-28 10:56:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`);

--
-- Indexes for table `centers`
--
ALTER TABLE `centers`
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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `center_id` (`center_id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `student_facilities`
--
ALTER TABLE `student_facilities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `centers`
--
ALTER TABLE `centers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `student_facilities`
--
ALTER TABLE `student_facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `facilities`
--
ALTER TABLE `facilities`
  ADD CONSTRAINT `facilities_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`center_id`) REFERENCES `centers` (`id`),
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`);

--
-- Constraints for table `student_facilities`
--
ALTER TABLE `student_facilities`
  ADD CONSTRAINT `student_facilities_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
