-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 08:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_flow`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_requests`
--

CREATE TABLE `bank_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `bags_needed` int(3) NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank_requests`
--

INSERT INTO `bank_requests` (`id`, `user_id`, `bank_id`, `blood_group`, `bags_needed`, `reason`, `status`, `request_date`) VALUES
(1, 1, 9, 'B-', 1, 'FEJDFEJF', 'pending', '2026-06-11 09:26:16'),
(2, 1, 9, 'O-', 1, 'immedately need blood ', 'pending', '2026-06-11 09:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(1, 'Why Donate Blood?', 'Donating blood saves lives. Every drop counts and can help someone in an emergency.', 'blog1.jpg', '2026-05-04 11:23:02'),
(2, 'Fitness and Blood Donation', 'You can donate blood even if you work out. Just make sure to stay hydrated and rest.', 'blog2.jpg', '2026-05-04 11:23:02'),
(3, 'Post-Donation Care', 'After donating blood, drink plenty of fluids and avoid heavy lifting for 24 hours.', 'blog3.jpg', '2026-05-04 11:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `blood_banks`
--

CREATE TABLE `blood_banks` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `stock_a_positive` int(5) DEFAULT 0,
  `stock_a_negative` int(5) DEFAULT 0,
  `stock_b_positive` int(5) DEFAULT 0,
  `stock_b_negative` int(5) DEFAULT 0,
  `stock_o_positive` int(5) DEFAULT 0,
  `stock_o_negative` int(5) DEFAULT 0,
  `stock_ab_positive` int(5) DEFAULT 0,
  `stock_ab_negative` int(5) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_banks`
--

INSERT INTO `blood_banks` (`id`, `bank_name`, `location`, `contact_no`, `stock_a_positive`, `stock_a_negative`, `stock_b_positive`, `stock_b_negative`, `stock_o_positive`, `stock_o_negative`, `stock_ab_positive`, `stock_ab_negative`, `created_at`) VALUES
(1, 'Dhaka B_bnak', 'sayednagar ', '34324243', 2, 2, 2, 2, 2, 2, 2, 2, '2026-05-18 08:25:55'),
(2, 'Dhaka B_bnak', 'sayednagar ', '34324243', 1, 2, 2, 2, 2, 0, 2, 3, '2026-05-18 08:48:17'),
(3, 'Dhaka B_bnak', 'sayednagar ', '34324243', 1, 2, 2, 2, 2, 0, 2, 3, '2026-05-18 08:48:55'),
(4, 'Dhaka B_bnak', 'sayednagar ', '34324243', 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-18 08:54:28'),
(5, 'Dhaka B_bnak', 'sayednagar ', '34324243', 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-18 09:08:51'),
(6, 'Dhaka B_bnak', 'sayednagar ', '34324243', 0, 0, 0, 0, 0, 0, 0, 0, '2026-05-18 11:20:13'),
(7, 'Dhaka B_bnak', ' Dhala near by uiu', '34324243', 4, 5, 3, 5, 5, 1, 4, 2, '2026-06-11 08:39:48'),
(8, 'Dhaka B_bnak', ' Dhala near by uiu', '34324243', 4, 5, 3, 5, 5, 1, 4, 2, '2026-06-11 08:40:20'),
(9, 'uiu blood bank', 'Madani evenue.', '01521703400', 3, 4, 4, 3, 4, 1, 5, 7, '2026-06-11 08:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recipient_name` varchar(100) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `location` varchar(255) NOT NULL,
  `hospital` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','accepted','verified','completed') DEFAULT 'pending',
  `is_thalassemia` int(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `donor_name` varchar(100) DEFAULT NULL,
  `donor_contact` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `recipient_name`, `blood_group`, `location`, `hospital`, `date`, `time`, `message`, `status`, `is_thalassemia`, `created_at`, `donor_name`, `donor_contact`) VALUES
(2, 1, 'Sanjana Kabir', 'O+', 'Chittagong', 'Apollo Hospital', '2026-05-12', '14:30:00', 'Need O+ blood urgently.', '', 0, '2026-05-04 11:23:24', 'siyam', 'mdsiyam1011@gmail.com'),
(3, 1, 'Rahat Khan', 'B+', 'Dhaka, Uttara', 'Evercare Hospital', '2026-05-15', '09:00:00', 'B+ blood needed for a patient.', '', 0, '2026-05-04 11:23:24', 'siyam', 'mdsiyam10115555@gmail.com'),
(5, 2, 'siyam mia Donor', 'O+', 'united', 'RMC', '2026-05-09', '22:03:00', 'freeee', '', 0, '2026-05-04 12:00:26', 'siyam', 'mdsiyam1011@gmail.com'),
(6, 1, 'siyam mia Donor', 'O-', 'united', 'RMC', '2026-05-09', '04:14:00', 'hi i am siyam', '', 0, '2026-05-04 16:09:24', 'siyam', 'mdsiyam10115555@gmail.com'),
(7, 3, 'siyam mia Donor', 'O-', 'united', 'RMC', '2026-05-09', '13:20:00', 'hi', '', 0, '2026-05-04 16:16:51', 'siyam', 'mdsiyam1011555500000@gmail.com'),
(8, 2, 'siyam mia Donor', 'A+', 'united medical', 'RMC', '2026-05-09', '14:22:00', 'fdsf', '', 0, '2026-05-04 16:18:04', 'siyam', 'mdsiyam10115555@gmail.com'),
(9, 3, 'siyam mia ', 'B+', 'united medical', 'RMC', '2026-05-09', '14:22:00', 'hi new fixed', '', 0, '2026-05-04 16:23:11', 'siyam', 'mdsiyam10115555@gmail.com'),
(10, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', '', 0, '2026-05-04 16:35:23', 'siyam', 'mdsiya0000@gmail.com'),
(11, 1, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'verified', 0, '2026-05-04 16:35:23', 'siyam', 'mdsiyam1011@gmail.com'),
(12, 1, 'Abdur Rahman', 'O+', 'Gulshan', 'United Hospital', '2026-05-15', '09:00:00', 'Urgent O+ blood.', '', 0, '2026-05-04 16:35:23', 'Siyam Ahmed', '01711223344'),
(13, 1, 'Fatima Khatun', 'AB+', 'Bashundhara', 'Apollo Hospital', '2026-05-18', '11:00:00', 'Needed for operation.', '', 0, '2026-05-04 16:35:23', 'Karim Ullah', 'karim@email.com'),
(14, 1, 'Sanjana', 'B+', 'Dhaka', 'LabAid', '2026-05-20', '16:00:00', 'Blood found and verified.', '', 0, '2026-05-04 16:35:23', 'Yusuf Siyam', '01888776655'),
(15, 1, 'MD. Rahim', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency surgery case.', 'verified', 0, '2026-05-04 16:42:06', 'siyam', 'mdsiyam1011@gmail.com'),
(16, 1, 'Sultana Razia', 'O-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Accident patient.', 'verified', 0, '2026-05-04 16:42:06', 'siyam', 'mdsiya0000@gmail.com'),
(17, 1, 'Kamal Ahmed', 'B+', 'Kalyanpur', 'Ibn Sina', '2026-05-15', '09:00:00', 'Urgent B+ required.', 'verified', 0, '2026-05-04 16:42:06', 'Yusuf Siyam', '01711223344'),
(18, 1, 'Jannatun Nesa', 'AB-', 'Bashundhara', 'Evercare', '2026-05-18', '11:00:00', 'Thalassemia treatment.', 'verified', 0, '2026-05-04 16:42:06', 'Sanjana', 'sanjana@email.com'),
(19, 1, 'Tarek Hasan', 'O+', 'Dhanmondi', 'LabAid', '2026-05-20', '16:00:00', 'Blood matched.', 'verified', 0, '2026-05-04 16:42:06', 'Md. Sakib', '01888776655'),
(20, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', 'verified', 0, '2026-05-04 17:21:11', 'siyam', 'mdsiyam1011@gmail.com'),
(21, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'verified', 0, '2026-05-04 17:21:11', 'siyam', 'mdsiyam1011@gmail.com'),
(22, 1, 'Abdur Rahman', 'O+', 'Gulshan', 'United Hospital', '2026-05-15', '09:00:00', 'Urgent O+ blood.', 'verified', 0, '2026-05-04 17:21:11', 'Siyam Ahmed', '01711223344'),
(23, 2, 'Fatima Khatun', 'AB+', 'Bashundhara', 'Apollo Hospital', '2026-05-18', '11:00:00', 'Needed for operation.', 'verified', 0, '2026-05-04 17:21:11', 'Karim Ullah', 'karim@email.com'),
(24, 2, 'Sanjana', 'B+', 'Dhaka', 'LabAid', '2026-05-20', '16:00:00', 'Blood found and verified.', 'verified', 0, '2026-05-04 17:21:11', 'Yusuf Siyam', '01888776655'),
(26, 1, 'Rakib Hossain', 'A+', 'Dhaka', 'Dhaka Medical', '2026-05-10', '10:00:00', 'Emergency needed for surgery.', 'verified', 0, '2026-05-04 17:25:37', 'siyam', 'mdsiyam1011@gmail.com'),
(27, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'verified', 0, '2026-05-04 17:25:37', 'siyam', 'mdsiyam1011@gmail.com'),
(29, 2, 'Sumaiya Akter', 'B-', 'Dhanmondi', 'Square Hospital', '2026-05-12', '14:30:00', 'Thalassemia patient.', 'approved', 0, '2026-05-04 17:25:44', NULL, NULL),
(30, 2, 'siyam mia ', 'A-', 'united medical', 'RMC', '2026-05-09', '00:55:00', 'ssdsd', 'verified', 0, '2026-05-09 18:53:27', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(31, 2, 'siyam mia Donor', 'B+', 'dsdsfd', 'sdssfdf', '2026-05-05', '02:53:00', 'sdsd', 'verified', 0, '2026-05-09 18:53:58', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(32, 1, 'Tanvir Rahman', 'A+', 'Dhaka', 'Dhaka Medical College', '2026-05-15', '11:00:00', 'Emergency heart surgery.', 'approved', 0, '2026-05-10 09:41:58', NULL, NULL),
(33, 3, 'Nila Akter', 'O-', 'Bashundhara', 'Evercare Hospital', '2026-05-18', '09:30:00', 'Rare blood group needed urgently.', 'verified', 0, '2026-05-10 09:41:58', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(34, 4, 'Sabbir Ahmed', 'B+', 'Dhanmondi', 'LabAid Hospital', '2026-05-12', '16:00:00', 'Accident case, multiple bags needed.', 'approved', 0, '2026-05-10 09:41:58', NULL, NULL),
(35, 1, 'Tanvir Rahman', 'A+', 'Dhaka', 'Dhaka Medical College', '2026-05-15', '11:00:00', 'Emergency heart surgery.', 'approved', 0, '2026-05-10 09:42:04', NULL, NULL),
(36, 3, 'Nila Akter', 'O-', 'Bashundhara', 'Evercare Hospital', '2026-05-18', '09:30:00', 'Rare blood group needed urgently.', 'accepted', 0, '2026-05-10 09:42:04', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(37, 4, 'Sabbir Ahmed', 'B+', 'Dhanmondi', 'LabAid Hospital', '2026-05-12', '16:00:00', 'Accident case, multiple bags needed.', 'accepted', 0, '2026-05-10 09:42:04', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(38, 1, 'Jashim Uddin', 'AB+', 'Old Dhaka', 'Sir Salimullah Medical', '2026-05-20', '10:00:00', 'Blood needed for operation.', 'accepted', 0, '2026-05-10 09:42:39', 'Hasan Ali', '01911998877'),
(39, 2, 'Mitu Sarkar', 'B-', 'Sher-e-Bangla Nagar', 'National Heart Institute', '2026-05-22', '14:00:00', 'Regular blood transfusion.', 'accepted', 0, '2026-05-10 09:42:39', 'Rahat Khan', '01555664433'),
(40, 1, 'Kamal Pasha', 'O+', 'Panthapath', 'Square Hospital', '2026-05-11', '15:00:00', 'Patient is in ICU.', 'verified', 0, '2026-05-10 09:42:39', 'Arif Ahmed', '01700112233'),
(41, 2, 'Shaila Islam', 'A-', 'Shahbagh', 'Bangabandhu Medical (BSMMU)', '2026-05-09', '08:00:00', 'Emergency C-section.', 'verified', 0, '2026-05-10 09:42:39', 'Yusuf Siyam', '01888776655'),
(42, 1, 'siyam mia Donor', 'AB+', 'dsdsfd', 'sdssfdf', '2026-05-05', '18:45:00', 'hi i am siyam ', 'approved', 0, '2026-05-10 09:45:57', NULL, NULL),
(43, 1, 'siyam mia Donor', 'O-', 'dsdsfd', 'uiu', '2026-05-05', '18:04:00', 'hi ', 'approved', 0, '2026-05-10 10:04:20', NULL, NULL),
(44, 1, 'siyam mia Donor', 'O-', 'India to Dhala ', 'India', '2026-05-05', '01:00:00', 'Is this request for a Thalassemia Patient?', 'verified', 1, '2026-05-18 06:48:14', 'siyam', 'mdsiyam10wewqeqweqw11@gmail.com'),
(45, 1, 'Md Rishad Khan', 'AB-', 'India to Dhala ', 'Manikgonj', '2026-05-05', '19:07:00', 'this request for a Thalassemia Patient?', 'verified', 1, '2026-05-18 07:01:41', 'sanjana ekter eva', 'eeeeeeeeeeeeee@gmail.com'),
(46, 3, 'Md Rishad Khan', 'A+', 'India to Dhala ', 'Manikgonj', '2026-05-05', '17:08:00', 'hi', 'approved', 1, '2026-05-18 07:08:43', NULL, NULL),
(47, 3, 'Md Rishad Khan', 'B+', 'India to Dhala ', 'Manikgonj', '2026-05-05', '18:13:00', 'tttttttttttttttttt', 'approved', 1, '2026-05-18 07:09:35', NULL, NULL),
(48, 1, 'siyam mia Donor', 'A-', 'India to Dhala ', 'Manikgonj', '2026-05-21', '13:10:00', 'th', 'approved', 1, '2026-05-18 07:10:11', NULL, NULL),
(49, 1, 'siyam mia Donor', 'A-', 'India to Dhala ', 'Manikgonj', '2026-05-21', '13:15:00', 'sjkchdj', 'pending', 1, '2026-05-18 07:13:28', NULL, NULL),
(50, 1, 'siyam mia Donor', 'A-', 'India to Dhala ', 'Manikgonj', '2026-05-21', '13:15:00', 'sjkchdj', 'approved', 1, '2026-05-18 08:07:28', NULL, NULL),
(51, 1, 'sazzad', 'O+', 'jossore', 'jossore hospital', '2026-06-18', '19:34:00', 'iam availabe ', 'approved', 1, '2026-06-11 08:30:22', NULL, NULL),
(52, 1, 'sazzad', 'O+', 'jossore', 'jossore hospital', '2026-06-18', '19:34:00', 'iam availabe ', 'pending', 1, '2026-06-11 08:31:49', NULL, NULL),
(53, 1, 'sazzad', 'O+', 'jossore', 'jossore hospital', '2026-06-18', '19:34:00', 'iam availabe ', 'approved', 1, '2026-06-11 08:33:41', NULL, NULL),
(54, 1, 'sazzad', 'O-', 'jossore', 'jossore hospital', '2026-06-18', '23:37:00', 'IS thelasimiya ==1', 'approved', 1, '2026-06-11 10:38:26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `thalassemia_alerts`
--

CREATE TABLE `thalassemia_alerts` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `status` enum('pending','accepted','ignored') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thalassemia_alerts`
--

INSERT INTO `thalassemia_alerts` (`id`, `request_id`, `donor_id`, `status`, `created_at`) VALUES
(1, 54, 5, 'accepted', '2026-06-11 10:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','donor','admin') DEFAULT 'user',
  `nid_number` varchar(20) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `last_donation_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `donor_type` varchar(50) NOT NULL DEFAULT 'regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `role`, `nid_number`, `blood_group`, `password`, `status`, `last_donation_date`, `created_at`, `donor_type`) VALUES
(1, 'Siyam', 'mdsiyam1011@gmail.com', 'user', '1000000000', 'AB+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:24:54', 'regular'),
(2, 'Yusuf Siyam', 'mdsiyam2021@gmail.com', 'donor', '1000000001', 'A+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:26:28', 'regular'),
(3, 'Md Yusuf Siyam', 'adminsiyam@gmail.com', 'admin', '1234567890', 'AB+', 'YSIYAM2003', 1, NULL, '2026-05-04 11:44:34', 'regular'),
(5, 'Y_T_Siyam', 'mdsiyam3031@gmail.com', 'donor', '1111111111', 'O-', 'YSIYAM2003', 1, NULL, '2026-06-11 10:00:41', 'fixed');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_requests`
--
ALTER TABLE `bank_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_banks`
--
ALTER TABLE `blood_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thalassemia_alerts`
--
ALTER TABLE `thalassemia_alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_request_id` (`request_id`),
  ADD KEY `idx_donor_id` (`donor_id`);

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
-- AUTO_INCREMENT for table `bank_requests`
--
ALTER TABLE `bank_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blood_banks`
--
ALTER TABLE `blood_banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `thalassemia_alerts`
--
ALTER TABLE `thalassemia_alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `thalassemia_alerts`
--
ALTER TABLE `thalassemia_alerts`
  ADD CONSTRAINT `fk_ta_donor` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ta_request` FOREIGN KEY (`request_id`) REFERENCES `requests` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
