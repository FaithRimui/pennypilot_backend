-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 09:55 PM
-- Server version: 11.4.7-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `financetracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `log_id` int(11) NOT NULL,
  `admin_username` varchar(100) DEFAULT NULL,
  `action` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`log_id`, `admin_username`, `action`, `timestamp`) VALUES
(1, 'admin', 'Viewed report 1', '2025-06-16 18:13:03'),
(2, 'admin', 'Viewed report 2', '2025-06-16 18:13:03'),
(3, 'admin', 'Viewed report 3', '2025-06-16 18:13:03'),
(4, 'admin', 'Viewed report 4', '2025-06-16 18:13:03'),
(5, 'admin', 'Viewed report 5', '2025-06-16 18:13:03'),
(6, 'admin', 'Viewed report 6', '2025-06-16 18:13:03'),
(7, 'admin', 'Viewed report 7', '2025-06-16 18:13:03'),
(8, 'admin', 'Viewed report 8', '2025-06-16 18:13:03'),
(9, 'admin', 'Viewed report 9', '2025-06-16 18:13:03'),
(10, 'admin', 'Viewed report 10', '2025-06-16 18:13:03'),
(11, 'admin', 'Viewed report 11', '2025-06-16 18:13:03'),
(12, 'admin', 'Viewed report 12', '2025-06-16 18:13:03'),
(13, 'admin', 'Viewed report 13', '2025-06-16 18:13:03'),
(14, 'admin', 'Viewed report 14', '2025-06-16 18:13:03'),
(15, 'admin', 'Viewed report 15', '2025-06-16 18:13:03'),
(16, 'admin', 'Viewed report 16', '2025-06-16 18:13:03'),
(17, 'admin', 'Viewed report 17', '2025-06-16 18:13:03'),
(18, 'admin', 'Viewed report 18', '2025-06-16 18:13:03'),
(19, 'admin', 'Viewed report 19', '2025-06-16 18:13:03'),
(20, 'admin', 'Viewed report 20', '2025-06-16 18:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `budget_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `budget_amount` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`budget_id`, `user_id`, `budget_amount`, `created_at`) VALUES
(1, 2, 20254.43, '2025-06-16 18:13:01'),
(2, 6, 38920.45, '2025-06-16 18:13:01'),
(3, 7, 42418.10, '2025-06-16 18:13:01'),
(4, 16, 42040.70, '2025-06-16 18:13:01'),
(5, 2, 26130.66, '2025-06-16 18:13:01'),
(6, 16, 31951.24, '2025-06-16 18:13:01'),
(7, 17, 11484.20, '2025-06-16 18:13:01'),
(8, 20, 22448.69, '2025-06-16 18:13:01'),
(9, 20, 12277.16, '2025-06-16 18:13:01'),
(10, 14, 32032.86, '2025-06-16 18:13:01'),
(11, 13, 19743.36, '2025-06-16 18:13:01'),
(12, 17, 26670.19, '2025-06-16 18:13:01'),
(13, 15, 23286.07, '2025-06-16 18:13:01'),
(14, 17, 10600.74, '2025-06-16 18:13:01'),
(15, 2, 22405.75, '2025-06-16 18:13:01'),
(16, 1, 28242.01, '2025-06-16 18:13:01'),
(17, 3, 15113.32, '2025-06-16 18:13:02'),
(18, 17, 23126.70, '2025-06-16 18:13:02'),
(19, 19, 11947.11, '2025-06-16 18:13:02'),
(20, 5, 48281.99, '2025-06-16 18:13:02'),
(21, 22, 30000.00, '2025-06-16 18:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expense_type` enum('fixed','miscellaneous') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `user_id`, `amount`, `category`, `date`, `description`, `expense_type`) VALUES
(1, 1, 1769.78, 'Utilities', '2025-06-09', 'Test expense 1', 'fixed'),
(2, 6, 2643.25, 'Utilities', '2025-06-10', 'Test expense 2', 'fixed'),
(3, 11, 2638.29, 'Utilities', '2025-05-30', 'Test expense 3', 'fixed'),
(4, 9, 660.53, 'Utilities', '2025-06-02', 'Test expense 4', 'fixed'),
(5, 19, 2859.19, 'Utilities', '2025-06-11', 'Test expense 5', 'fixed'),
(6, 14, 500.40, 'Utilities', '2025-06-02', 'Test expense 6', 'fixed'),
(7, 19, 1066.50, 'Utilities', '2025-05-19', 'Test expense 7', 'fixed'),
(8, 5, 1950.49, 'Utilities', '2025-06-05', 'Test expense 8', 'fixed'),
(9, 6, 2869.79, 'Utilities', '2025-05-18', 'Test expense 9', 'fixed'),
(10, 1, 859.37, 'Utilities', '2025-06-15', 'Test expense 10', 'fixed'),
(11, 15, 2711.09, 'Utilities', '2025-06-09', 'Test expense 11', 'fixed'),
(12, 19, 1670.83, 'Utilities', '2025-05-22', 'Test expense 12', 'fixed'),
(13, 2, 2270.21, 'Utilities', '2025-05-26', 'Test expense 13', 'fixed'),
(14, 9, 2759.04, 'Utilities', '2025-06-04', 'Test expense 14', 'fixed'),
(15, 20, 1302.51, 'Utilities', '2025-05-30', 'Test expense 15', 'fixed'),
(16, 4, 651.48, 'Utilities', '2025-05-22', 'Test expense 16', 'fixed'),
(17, 12, 2829.47, 'Utilities', '2025-06-11', 'Test expense 17', 'fixed'),
(18, 6, 1855.81, 'Utilities', '2025-05-18', 'Test expense 18', 'fixed'),
(19, 5, 1990.63, 'Utilities', '2025-05-27', 'Test expense 19', 'fixed'),
(20, 2, 634.70, 'Utilities', '2025-05-28', 'Test expense 20', 'fixed');

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL,
  `date_received` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `amount`, `source`, `date_received`) VALUES
(1, 16, 47293.69, 'Job', '2025-06-11'),
(2, 2, 64333.94, 'Job', '2025-06-07'),
(3, 7, 67982.08, 'Job', '2025-06-04'),
(4, 3, 55829.56, 'Job', '2025-06-14'),
(5, 5, 10940.43, 'Job', '2025-06-14'),
(6, 15, 77890.87, 'Job', '2025-06-07'),
(7, 13, 11585.57, 'Job', '2025-06-12'),
(8, 6, 78751.93, 'Job', '2025-06-03'),
(9, 2, 36712.78, 'Job', '2025-06-01'),
(10, 3, 47567.10, 'Job', '2025-06-04'),
(11, 2, 38232.68, 'Job', '2025-06-13'),
(12, 5, 63443.57, 'Job', '2025-06-15'),
(13, 15, 73370.30, 'Job', '2025-06-14'),
(14, 18, 29455.91, 'Job', '2025-06-03'),
(15, 1, 21604.63, 'Job', '2025-06-04'),
(16, 5, 28944.90, 'Job', '2025-06-15'),
(17, 1, 48249.02, 'Job', '2025-06-09'),
(18, 4, 41866.14, 'Job', '2025-06-14'),
(19, 18, 57181.55, 'Job', '2025-06-06'),
(20, 6, 22317.11, 'Job', '2025-06-14'),
(21, 22, 70000.00, 'Salary', '2025-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `otp_codes`
--

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `purpose` varchar(20) DEFAULT 'signup',
  `expires_at` datetime DEFAULT (current_timestamp() + interval 10 minute),
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savings_goals`
--

CREATE TABLE `savings_goals` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `goal_amount` decimal(10,2) DEFAULT NULL,
  `progress_amount` decimal(10,2) DEFAULT NULL,
  `goal_name` varchar(255) DEFAULT NULL,
  `target_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `savings_goals`
--

INSERT INTO `savings_goals` (`id`, `user_id`, `goal_amount`, `progress_amount`, `goal_name`, `target_date`, `created_at`) VALUES
(1, 8, 13466.00, 2707.00, 'Goal 1', '2025-08-06', '2025-06-16 18:13:02'),
(2, 2, 11049.00, 2992.00, 'Goal 2', '2025-09-22', '2025-06-16 18:13:02'),
(3, 3, 17980.00, 2843.00, 'Goal 3', '2025-07-01', '2025-06-16 18:13:02'),
(4, 2, 33297.00, 25270.00, 'Goal 4', '2025-07-08', '2025-06-16 18:13:02'),
(5, 13, 6387.00, 5590.00, 'Goal 5', '2025-08-11', '2025-06-16 18:13:02'),
(6, 7, 48183.00, 4428.00, 'Goal 6', '2025-07-04', '2025-06-16 18:13:02'),
(7, 20, 21475.00, 4792.00, 'Goal 7', '2025-09-08', '2025-06-16 18:13:02'),
(8, 13, 44568.00, 29518.00, 'Goal 8', '2025-09-26', '2025-06-16 18:13:02'),
(9, 19, 21634.00, 20417.00, 'Goal 9', '2025-07-11', '2025-06-16 18:13:02'),
(10, 4, 27149.00, 21381.00, 'Goal 10', '2025-07-03', '2025-06-16 18:13:02'),
(11, 9, 20529.00, 10376.00, 'Goal 11', '2025-07-08', '2025-06-16 18:13:02'),
(12, 18, 29905.00, 15125.00, 'Goal 12', '2025-08-22', '2025-06-16 18:13:02'),
(13, 6, 47531.00, 3311.00, 'Goal 13', '2025-08-09', '2025-06-16 18:13:02'),
(14, 4, 15174.00, 10428.00, 'Goal 14', '2025-07-10', '2025-06-16 18:13:02'),
(15, 11, 38883.00, 28088.00, 'Goal 15', '2025-08-13', '2025-06-16 18:13:03'),
(16, 8, 18058.00, 2076.00, 'Goal 16', '2025-07-09', '2025-06-16 18:13:03'),
(17, 1, 47909.00, 27032.00, 'Goal 17', '2025-07-05', '2025-06-16 18:13:03'),
(18, 16, 38768.00, 30680.00, 'Goal 18', '2025-06-26', '2025-06-16 18:13:03'),
(19, 17, 13108.00, 3602.00, 'Goal 19', '2025-07-24', '2025-06-16 18:13:03'),
(20, 16, 33637.00, 27346.00, 'Goal 20', '2025-10-10', '2025-06-16 18:13:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `profile_picture`, `income`, `phone`, `created_at`) VALUES
(1, 'Faith Johnson', 'faith1@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile1.jpg', 44945.00, '0797933452', '2025-06-16 18:13:00'),
(2, 'Faith Smith', 'faith2@test.org', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile2.jpg', 50347.00, '0711711920', '2025-06-16 18:13:00'),
(3, 'John Rimui', 'johnr3@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile3.jpg', 40432.00, '0763112516', '2025-06-16 18:13:00'),
(4, 'Faith Williams', 'faith4@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile4.jpg', 54085.00, '0754034702', '2025-06-16 18:13:00'),
(5, 'Lucy Johnson', 'lucyj5@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile5.jpg', 58425.00, '0793799789', '2025-06-16 18:13:00'),
(6, 'Alice Johnson', 'alice6@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile6.jpg', 84443.00, '0736851959', '2025-06-16 18:13:00'),
(7, 'Michael Smith', 'micha7@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile7.jpg', 55293.00, '0720912488', '2025-06-16 18:13:00'),
(8, 'Alice Williams', 'alice8@test.org', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile8.jpg', 60243.00, '0717197800', '2025-06-16 18:13:00'),
(9, 'Faith Rimui', 'faith9@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile9.jpg', 77409.00, '0798244227', '2025-06-16 18:13:00'),
(10, 'Faith Johnson', 'faith10@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile10.jpg', 30562.00, '0792901962', '2025-06-16 18:13:00'),
(11, 'Alice Williams', 'alice11@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile11.jpg', 54586.00, '0775467466', '2025-06-16 18:13:00'),
(12, 'Lucy Williams', 'lucyw12@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile12.jpg', 79022.00, '0734379926', '2025-06-16 18:13:00'),
(13, 'Michael Brown', 'micha13@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile13.jpg', 61355.00, '0726257443', '2025-06-16 18:13:00'),
(14, 'Jane Johnson', 'janej14@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile14.jpg', 72974.00, '0765009694', '2025-06-16 18:13:00'),
(15, 'Faith Brown', 'faith15@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile15.jpg', 90684.00, '0759487303', '2025-06-16 18:13:00'),
(16, 'Jane Rimui', 'janer16@test.org', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile16.jpg', 39119.00, '0758809381', '2025-06-16 18:13:00'),
(17, 'Bob Smith', 'bobsm17@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile17.jpg', 51259.00, '0719429925', '2025-06-16 18:13:00'),
(18, 'Bob Johnson', 'bobjo18@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile18.jpg', 68756.00, '0780591815', '2025-06-16 18:13:00'),
(19, 'Michael Brown', 'micha19@mail.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile19.jpg', 77940.00, '0792815680', '2025-06-16 18:13:00'),
(20, 'Lucy Rimui', 'lucyr20@example.com', '$2y$10$TESTHASHEDPASS000000000000000000000000000000000000000000000', 'profile20.jpg', 57362.00, '0726101136', '2025-06-16 18:13:00'),
(21, 'Amber Zoya', 'amberz@gmail.com', '$2y$10$2R9GIw.LMQK3MIVFmaW.n.cAHztOtZGxLVDH0PNxSaKMvglKLxD1K', NULL, NULL, '0745207081', '2025-06-16 18:14:12'),
(22, 'Amber Sifah', 'ambers@gmail.com', '$2y$10$DyEt4bDM2BrF8Q02fo2dmO1k8B.1KiSd8uLY9TVfs.EDgoLzfP4Mq', NULL, 70000.00, '0745267081', '2025-06-16 18:29:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`budget_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings_goals`
--
ALTER TABLE `savings_goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `otp_codes`
--
ALTER TABLE `otp_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings_goals`
--
ALTER TABLE `savings_goals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budget`
--
ALTER TABLE `budget`
  ADD CONSTRAINT `budget_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `otp_codes`
--
ALTER TABLE `otp_codes`
  ADD CONSTRAINT `otp_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_goals`
--
ALTER TABLE `savings_goals`
  ADD CONSTRAINT `savings_goals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
