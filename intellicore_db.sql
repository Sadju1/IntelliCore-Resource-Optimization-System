-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 01:05 PM
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
-- Database: `intellicore_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `details`, `created_at`) VALUES
(1, 4, 'New user registered', NULL, '2025-12-02 18:47:20'),
(2, 4, 'User logged in', NULL, '2025-12-02 18:47:34'),
(3, 4, 'User logged out', NULL, '2025-12-02 18:48:53'),
(4, 4, 'User logged in', NULL, '2025-12-02 19:04:22'),
(5, 4, 'Added resource: Dell Latitude 5420 Laptop', NULL, '2025-12-02 19:21:17'),
(6, 4, 'Added resource: TP-Link TL-SG1024 24-Port Switch', NULL, '2025-12-02 19:23:59'),
(7, 4, 'Added resource: Arduino Mega 2560 Board', NULL, '2025-12-02 19:25:21'),
(8, 4, 'Added resource: Canon iR2520 Office Printer', NULL, '2025-12-02 19:26:40'),
(9, 4, 'Started using resource ID: 4', NULL, '2025-12-02 19:28:08'),
(10, 4, 'Started using resource ID: 2', NULL, '2025-12-02 19:28:15'),
(11, 4, 'Stopped using resource ID: 4', NULL, '2025-12-02 19:28:36'),
(12, 4, 'Stopped using resource ID: 2', NULL, '2025-12-02 19:28:38'),
(13, 4, 'User logged out', NULL, '2025-12-02 19:29:08'),
(14, 4, 'User logged in', NULL, '2025-12-02 19:39:54'),
(15, 4, 'User logged out', NULL, '2025-12-02 19:40:46'),
(16, 4, 'User logged in', NULL, '2025-12-02 19:46:51'),
(17, 4, 'User logged out', NULL, '2025-12-02 19:54:04'),
(18, 4, 'User logged in', NULL, '2025-12-02 19:54:13'),
(19, 4, 'User logged in', NULL, '2025-12-09 13:02:32'),
(20, 4, 'User logged in', NULL, '2025-12-10 11:30:47'),
(21, 4, 'User logged in', NULL, '2025-12-10 14:23:51'),
(22, 4, 'User logged in', NULL, '2025-12-10 14:33:19'),
(23, 4, 'User logged in', NULL, '2025-12-10 14:39:37'),
(24, 4, 'User logged in', NULL, '2025-12-10 14:48:55'),
(25, 4, 'User logged in', NULL, '2025-12-10 15:43:35'),
(26, 4, 'User logged in', NULL, '2025-12-10 15:50:45'),
(27, 4, 'User logged out', NULL, '2025-12-10 15:53:58'),
(28, 4, 'User logged in', NULL, '2025-12-15 09:44:03'),
(29, 4, 'User logged out', NULL, '2025-12-15 09:45:03'),
(30, 4, 'User logged in', NULL, '2025-12-15 09:45:58'),
(31, 4, 'User logged in', NULL, '2025-12-15 09:56:24'),
(32, 4, 'User logged in', NULL, '2025-12-15 10:02:23'),
(33, 5, 'New user registered', NULL, '2025-12-15 14:14:50'),
(34, 5, 'User logged in', NULL, '2025-12-15 14:15:19'),
(35, 5, 'User logged in', NULL, '2025-12-15 14:16:11'),
(36, 4, 'User logged in', NULL, '2025-12-15 14:32:57'),
(37, 4, 'User logged in', NULL, '2025-12-15 14:43:30'),
(38, 4, 'User logged out', NULL, '2025-12-15 14:44:25'),
(39, 4, 'User logged in', NULL, '2025-12-15 14:44:31'),
(40, 4, 'User logged in', NULL, '2025-12-15 14:57:08'),
(41, 4, 'User logged in', NULL, '2025-12-15 15:05:57'),
(42, 4, 'User logged in', NULL, '2025-12-15 15:21:17');

-- --------------------------------------------------------

--
-- Table structure for table `optimization_logs`
--

CREATE TABLE `optimization_logs` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `severity` enum('low','medium','high') DEFAULT 'low',
  `score` decimal(6,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `optimization_logs`
--

INSERT INTO `optimization_logs` (`id`, `resource_id`, `message`, `severity`, `score`, `created_at`) VALUES
(1, 4, 'Normal usage.', 'low', 0.00, '2025-12-02 19:28:36'),
(2, 2, 'Normal usage.', 'low', 0.00, '2025-12-02 19:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `status` enum('available','in_use','maintenance','idle','retired') DEFAULT 'available',
  `purchase_date` date DEFAULT NULL,
  `cost` decimal(12,2) DEFAULT 0.00,
  `estimated_lifetime_months` int(11) DEFAULT 60,
  `last_maintenance` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `name`, `category`, `location`, `status`, `purchase_date`, `cost`, `estimated_lifetime_months`, `last_maintenance`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Dell Latitude 5420 Laptop', 'laptop', 'Room 301', 'available', '2023-01-10', 850.00, 60, NULL, 'Assigned to ICT Department for daily office operations', '2025-12-02 19:21:17', '2025-12-02 19:21:17'),
(2, 'TP-Link TL-SG1024 24-Port Switch', 'Networking', 'Server Rack 2', 'available', '2024-01-19', 119.97, 71, NULL, 'Core switch for campus LAN backbone.', '2025-12-02 19:23:59', '2025-12-02 19:28:38'),
(3, 'Arduino Mega 2560 Board', 'Lab Equipment', 'Room 302', 'available', '2000-03-12', 34.96, 42, NULL, 'Used in programming and robotics experiments.', '2025-12-02 19:25:21', '2025-12-02 19:25:21'),
(4, 'Canon iR2520 Office Printer', 'Printer', 'Admin Office', 'available', '2013-04-20', 600.00, 47, NULL, 'Shared printer for administrative staff.', '2025-12-02 19:26:40', '2025-12-02 19:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `resource_usage`
--

CREATE TABLE `resource_usage` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_seconds` bigint(20) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resource_usage`
--

INSERT INTO `resource_usage` (`id`, `resource_id`, `user_id`, `start_time`, `end_time`, `duration_seconds`, `purpose`, `created_at`) VALUES
(1, 4, 4, '2025-12-02 21:28:08', '2025-12-02 21:28:36', -3572, NULL, '2025-12-02 19:28:08'),
(2, 2, 4, '2025-12-02 21:28:15', '2025-12-02 21:28:38', -3577, NULL, '2025-12-02 19:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `username`, `email`, `password_hash`, `full_name`, `created_at`) VALUES
(4, 2, 'sadju', 'shemasergei69@gmail.com', '$2y$10$F9mSy/sFZ4tU7iyu0fQW0Oco9RxHMPDLzPd.8eqxKkmQ9WxhbIvM6', 'IRADUKUNDA SHEMA Jean Serge', '2025-12-02 18:47:20'),
(5, 2, 'nema', 'nema1@gmail.com', '$2y$10$qARaf/kNRqk79.Nx/l6fLeOCtbgXYn/0k0PvC8RFB20zXJIMvpaR.', 'sheja usanane', '2025-12-15 14:14:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `optimization_logs`
--
ALTER TABLE `optimization_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resource_usage`
--
ALTER TABLE `resource_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `optimization_logs`
--
ALTER TABLE `optimization_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `resource_usage`
--
ALTER TABLE `resource_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `optimization_logs`
--
ALTER TABLE `optimization_logs`
  ADD CONSTRAINT `optimization_logs_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`);

--
-- Constraints for table `resource_usage`
--
ALTER TABLE `resource_usage`
  ADD CONSTRAINT `resource_usage_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `resource_usage_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
