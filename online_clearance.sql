-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2018 at 05:54 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_clearance`
--

-- --------------------------------------------------------

--
-- Table structure for table `bursary`
--

CREATE TABLE `bursary` (
  `user_id` int(11) NOT NULL,
  `accept_fees` tinyint(1) NOT NULL,
  `sch_fees_yr1` tinyint(1) NOT NULL,
  `sch_fees_yr2` tinyint(1) NOT NULL,
  `sch_fees_yr3` tinyint(1) NOT NULL,
  `sch_fees_yr4` tinyint(1) NOT NULL,
  `sch_fees_yr5` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bursary`
--

INSERT INTO `bursary` (`user_id`, `accept_fees`, `sch_fees_yr1`, `sch_fees_yr2`, `sch_fees_yr3`, `sch_fees_yr4`, `sch_fees_yr5`) VALUES
(2, 1, 1, 1, 1, 1, 1),
(1, 0, 0, 0, 0, 0, 0),
(0, 0, 0, 0, 0, 0, 0),
(3, 0, 0, 0, 0, 0, 0),
(10, 0, 0, 0, 0, 0, 0),
(11, 0, 0, 0, 0, 0, 0),
(12, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `user_id` int(11) NOT NULL,
  `yr1_complete` tinyint(1) NOT NULL,
  `yr2_complete` tinyint(1) NOT NULL,
  `yr3_complete` tinyint(1) NOT NULL,
  `yr4_complete` tinyint(1) NOT NULL,
  `yr5_complete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`user_id`, `yr1_complete`, `yr2_complete`, `yr3_complete`, `yr4_complete`, `yr5_complete`) VALUES
(2, 1, 1, 1, 1, 1),
(1, 1, 1, 1, 1, 1),
(0, 0, 0, 0, 0, 0),
(3, 1, 1, 1, 1, 1),
(10, 0, 0, 0, 0, 0),
(11, 0, 0, 0, 0, 0),
(12, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hostel`
--

CREATE TABLE `hostel` (
  `user_id` int(11) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `stolen` tinyint(1) NOT NULL,
  `broken` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hostel`
--

INSERT INTO `hostel` (`user_id`, `paid`, `stolen`, `broken`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 1),
(3, 1, 0, 1),
(0, 0, 0, 0),
(10, 0, 0, 0),
(11, 0, 0, 0),
(12, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicals`
--

CREATE TABLE `medicals` (
  `user_id` int(11) NOT NULL,
  `xray` tinyint(1) NOT NULL,
  `blood_test` tinyint(1) NOT NULL,
  `faecal` tinyint(1) NOT NULL,
  `urinalysis` tinyint(1) NOT NULL,
  `certificate` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicals`
--

INSERT INTO `medicals` (`user_id`, `xray`, `blood_test`, `faecal`, `urinalysis`, `certificate`) VALUES
(2, 1, 1, 1, 1, 1),
(1, 0, 0, 0, 0, 0),
(0, 0, 0, 0, 0, 0),
(3, 0, 0, 0, 0, 0),
(10, 0, 0, 0, 0, 0),
(11, 0, 0, 0, 0, 0),
(12, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `security`
--

CREATE TABLE `security` (
  `user_id` int(11) NOT NULL,
  `pending_case` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `security`
--

INSERT INTO `security` (`user_id`, `pending_case`) VALUES
(2, 1),
(1, 1),
(0, 0),
(3, 0),
(10, 0),
(11, 0),
(12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_affairs`
--

CREATE TABLE `student_affairs` (
  `user_id` int(11) NOT NULL,
  `security` tinyint(1) NOT NULL,
  `medicals` tinyint(1) NOT NULL,
  `hostel` tinyint(1) NOT NULL,
  `bursary` tinyint(1) NOT NULL,
  `department` tinyint(1) NOT NULL,
  `student_affairs` tinyint(1) NOT NULL,
  `completion_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_affairs`
--

INSERT INTO `student_affairs` (`user_id`, `security`, `medicals`, `hostel`, `bursary`, `department`, `student_affairs`, `completion_date`) VALUES
(24, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(4, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00'),
(2, 1, 1, 1, 1, 1, 1, '2018-07-23 16:22:22'),
(3, 0, 0, 0, 0, 1, 0, '0000-00-00 00:00:00'),
(12, 1, 1, 0, 0, 0, 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `college` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `reg_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `user_type`, `name`, `email`, `phone`, `college`, `department`, `reg_no`) VALUES
(1, 'nadispendragon', '0f06cce7c9b7dfc2671e7fb5822a2fab', 'bursary', 'Nnamdi Patrick Nwafor', 'patnadis2program@gmail.com', '07061305805', 'CEET', 'CIE', 'MOUAU/30106'),
(2, 'lordkelly', '0f06cce7c9b7dfc2671e7fb5822a2fab', 'student', 'Onumah Kalu Samuel', 'lordkellysam@gmail.com', '08133792006', 'CEET', 'CIE', 'MOUAU/13/28905'),
(3, 'eblaborjohn', '0f06cce7c9b7dfc2671e7fb5822a2fab', 'student', 'John Eblabor', 'tlsvjdblov@gmail.com', '0906696509', 'CEET', 'CIE', 'MOUAU/13/26509'),
(4, 'bursary', 'c4434f0227c40008e3266f7ab911ff1e', 'bursary', 'Bursary Admin', '', '', '', '', ''),
(5, 'department', '459d9fca17e3a950deae755d13578292', 'department', 'Department Admin', '', '', '', '', ''),
(6, 'hostel', '9e12394c8d54ac26c45e9a98922c2e11', 'hostel', 'Hostel Admin', '', '', '', '', ''),
(7, 'medicals', '5c52637f1201f7d9e4741047ecdaeda6', 'medicals', 'Medicals Admin', '', '', '', '', ''),
(8, 'security', 'e91e6348157868de9dd8b25c81aebfb9', 'security', 'Security Admin', '', '', '', '', ''),
(9, 'studentaffairs', '0f06cce7c9b7dfc2671e7fb5822a2fab', 'student affairs', 'Student Affairs Admin', '', '', '', '', ''),
(12, 'ebenezer', '466f669d33e6b9a05942e1c5324c7834', 'student', 'Ebenezer O. Ebenezer', 'ebendrums@gmail.com', '08098798765', 'CAERSE', 'ABM', 'MOUAU/13/56435');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
