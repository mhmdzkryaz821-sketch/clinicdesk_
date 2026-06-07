-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2026 at 06:53 PM
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
-- Database: `clinicdesk_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appt_date` date NOT NULL,
  `appt_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','canceled') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `patient_id`, `doctor_id`, `appt_date`, `appt_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(4, 15, 103, '2026-06-09', '09:00:00', 'canceled', 'ثث', '2026-06-07 09:50:58', '2026-06-07 14:47:08'),
(5, 15, 103, '2026-06-08', '13:00:00', 'confirmed', 'مم', '2026-06-07 09:51:11', '2026-06-07 11:04:47'),
(6, 15, 103, '2026-06-09', '09:00:00', 'canceled', 'ثث', '2026-06-07 09:51:29', '2026-06-07 11:06:47'),
(7, 15, 103, '2026-06-09', '09:00:00', 'canceled', 'ثث', '2026-06-07 09:52:43', '2026-06-07 11:06:47'),
(8, 15, 103, '2026-06-09', '09:00:00', 'canceled', 'ثث', '2026-06-07 09:53:23', '2026-06-07 11:06:48'),
(9, 15, 104, '2026-06-24', '09:00:00', 'confirmed', 'Thanks for every thing', '2026-06-07 11:09:25', '2026-06-07 11:09:44'),
(10, 105, 104, '2026-06-08', '09:00:00', 'confirmed', 'vv', '2026-06-07 11:21:50', '2026-06-07 11:22:33'),
(11, 105, 103, '2026-06-13', '09:00:00', 'confirmed', 'يي', '2026-06-07 11:48:01', '2026-06-07 14:38:09'),
(15, 111, 112, '2026-06-13', '09:00:00', '', 'eq', '2026-06-07 16:40:19', '2026-06-07 16:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT 0.00,
  `bio` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `user_id`, `specialty`, `specialization_id`, `room_number`, `consultation_fee`, `bio`, `phone_number`, `address`) VALUES
(9, 103, NULL, 3, NULL, 33.00, '1', NULL, NULL),
(10, 104, NULL, 3, NULL, 2.00, '3', NULL, NULL),
(13, 109, NULL, 1, NULL, 55.00, 'Dentisit', NULL, NULL),
(14, 112, NULL, 5, NULL, 2.00, '2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `appointment_id`, `file_path`, `uploaded_at`) VALUES
(1, 5, 'presc_5_1780843393.pdf', '2026-06-07 14:43:13'),
(2, 5, 'presc_5_1780843398.pdf', '2026-06-07 14:43:18'),
(3, 5, 'presc_5_1780843405.pdf', '2026-06-07 14:43:25'),
(4, 5, 'presc_5_1780843468.pdf', '2026-06-07 14:44:28'),
(5, 5, 'presc_5_1780843474.pdf', '2026-06-07 14:44:34'),
(6, 5, 'presc_5_1780843617.pdf', '2026-06-07 14:46:57'),
(7, 5, 'presc_5_1780843631.pdf', '2026-06-07 14:47:11'),
(8, 5, 'presc_5_1780843699.pdf', '2026-06-07 14:48:19'),
(9, 5, 'presc_5_1780843838.pdf', '2026-06-07 14:50:38'),
(10, 5, 'presc_5_1780844144.pdf', '2026-06-07 14:55:44'),
(11, 11, 'presc_11_1780844387.csv', '2026-06-07 14:59:47'),
(12, 5, 'presc_5_1780844558.pdf', '2026-06-07 15:02:38'),
(13, 5, 'presc_5_1780844649.pdf', '2026-06-07 15:04:09'),
(14, 5, 'presc_5_1780845294.csv', '2026-06-07 15:14:54'),
(15, 5, 'presc_5_1780845822.csv', '2026-06-07 15:23:42'),
(16, 5, 'presc_5_1780846139.csv', '2026-06-07 15:28:59'),
(17, 5, 'presc_5_1780846252.csv', '2026-06-07 15:30:52'),
(18, 5, 'presc_5_1780846932.pdf', '2026-06-07 15:42:12'),
(20, 15, 'presc_15_1780850440.jpg', '2026-06-07 16:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `created_at`) VALUES
(1, 'General Medicine', '2026-06-06 14:36:43'),
(2, 'Pediatrics', '2026-06-06 14:36:43'),
(3, 'Cardiology', '2026-06-06 14:36:43'),
(4, 'Dermatology', '2026-06-06 14:36:43'),
(5, 'Orthopedics', '2026-06-06 14:36:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','doctor','patient') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'admin@clinic.com', '$2y$10$ez.rLTmMMQ1f8dB82WcczuZn8hsBtIus1PfbtJsx4gLRgelp98.Ki', 'admin', 'active', '2026-06-06 14:32:05', '2026-06-06 15:03:40'),
(15, 'Mohamed Patient', 'patient@clinic.com', '$2y$10$ez.rLTmMMQ1f8dB82WcczuZn8hsBtIus1PfbtJsx4gLRgelp98.Ki', 'patient', 'active', '2026-06-06 18:09:58', '2026-06-06 18:09:58'),
(103, 'aseel1', 'aseel1@clinic.local', '$2y$10$xrlubvURr/cgzXFa7rZsu.4JOo8p0PagczWhk4hFLOGhnq61M86yO', 'doctor', 'active', '2026-06-07 10:13:15', '2026-06-07 10:13:15'),
(104, 'Jamal', 'Jamal@clinic.local', '$2y$10$WMA2vLLAzyRrouWuAaUh6eHn/Pn.w/elwDxlaeuuAsUn0M2wVaiU.', 'doctor', 'active', '2026-06-07 10:57:58', '2026-06-07 10:57:58'),
(105, 'Kamal', 'Kamal@clinic.local', '$2y$10$b/Qz721Xre//zlrhd3S3h.dI2XH/ClJyXnKNNkx3vrXmB/wDTD5UK', 'patient', 'active', '2026-06-07 11:21:11', '2026-06-07 11:21:11'),
(108, 'Firas', 'Firas@clinic.local', '$2y$10$pvwTrGeA2vxxNINIpNd/3O0Jwp2DG6dpfLyEhf9fAWjXmCyZpn0ci', 'patient', 'active', '2026-06-07 12:19:08', '2026-06-07 12:19:08'),
(109, 'Yousef', 'Yousef@clinic.local', '$2y$10$SLYBJdWf.UNGdGTdDghMeuRpwcUlAvTwrkQB4sdHxGnbusmrgsBHi', 'doctor', 'active', '2026-06-07 12:23:43', '2026-06-07 12:23:43'),
(111, 'Elias', 'Elias@clinic.local', '$2y$10$lkVywITWUikr5FIESc/2neT9XaVvgQDjbAJH8VMchfQ4BmVxFubBq', 'patient', 'active', '2026-06-07 16:38:42', '2026-06-07 16:38:42'),
(112, 'Sami', 'Sami@clinic.local', '$2y$10$fZIiBpLfOdqcmSixIwQbOO4k.B1iWEyy.MTSyMdS3.M6pfwoYuu5u', 'doctor', 'active', '2026-06-07 16:39:20', '2026-06-07 16:39:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_doctor_specialization` (`specialization_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doctor_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
