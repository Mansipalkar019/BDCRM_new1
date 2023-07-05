-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2022 at 10:20 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdscrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `master_department`
--

CREATE TABLE `master_department` (
  `id` int(10) NOT NULL,
  `dept_name` varchar(50) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 1 COMMENT '1=active,0=Inactive, ',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_department`
--

INSERT INTO `master_department` (`id`, `dept_name`, `status`, `created_at`) VALUES
(1, 'Operations1', 1, '2022-09-26 12:20:43'),
(2, 'Operations2', 1, '2022-09-26 12:20:43'),
(3, 'Business Development', 1, '2022-09-26 12:21:15');

-- --------------------------------------------------------

--
-- Table structure for table `master_designation`
--

CREATE TABLE `master_designation` (
  `id` int(10) NOT NULL,
  `designation_name` varchar(50) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Inactive',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `master_project`
--

CREATE TABLE `master_project` (
  `id` int(10) NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Inactive',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `master_project`
--

INSERT INTO `master_project` (`id`, `project_name`, `status`, `created_at`) VALUES
(1, 'BTB-02-T', 0, '2022-09-26 12:46:08'),
(2, 'BTB-02-T', 0, '2022-09-26 12:46:08'),
(3, 'BTB-02-T', 0, '2022-09-26 12:46:33'),
(4, 'BTB-02-T', 0, '2022-09-26 12:46:33'),
(5, 'BTB-02-T', 0, '2022-09-26 12:46:33'),
(6, 'BTB-02-T', 0, '2022-09-26 12:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(111) NOT NULL,
  `password` varchar(1111) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0=Active, 1=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `designation`, `created_at`, `status`) VALUES
(1, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b	', 'Mohammed Sufian', 'Administrator', '', '2022-07-29 09:49:30', 0),
(2, 'manager', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Manager', 'User', '', '2022-07-29 09:53:34', 0),
(3, 'teamleader', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'TeamLeader', 'User', '', '2022-07-29 09:55:30', 0),
(4, 'bdresearcher', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'BDResearcher', 'User', '', '2022-07-29 09:57:24', 0),
(5, 'bdcaller', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'BDCaller', 'User', '', '2022-07-29 09:58:40', 0),
(6, 'opsresearcher', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'OPSResearcher', 'User', '', '2022-07-29 09:59:39', 0),
(7, 'opscaller', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'OPSCaller', 'User', '', '2022-07-29 10:01:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `master_department`
--
ALTER TABLE `master_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_designation`
--
ALTER TABLE `master_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_project`
--
ALTER TABLE `master_project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `master_department`
--
ALTER TABLE `master_department`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `master_designation`
--
ALTER TABLE `master_designation`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_project`
--
ALTER TABLE `master_project`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
