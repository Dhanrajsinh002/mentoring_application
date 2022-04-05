-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2022 at 05:43 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentoring_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `group_id` int(3) NOT NULL,
  `discussion` varchar(5000) NOT NULL,
  `sender_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`group_id`, `discussion`, `sender_name`) VALUES
(1, 'asd', 'ASD'),
(2, 'Hello Pratham. This is ASD', 'ASD'),
(1, 'Hello Dhanrajsinh', 'ASD'),
(1, 'Hello Belvin', 'ASD'),
(4, 'Hello Kaushal', 'ASD'),
(4, 'QWERTYUIOP', 'ASD'),
(5, 'ASDFGHJKL', 'pratham'),
(5, 'Hello Pratham', 'ASD');

-- --------------------------------------------------------

--
-- Table structure for table `group_details`
--

CREATE TABLE `group_details` (
  `group_id` int(3) NOT NULL,
  `group_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`group_id`, `group_name`) VALUES
(4, 'group'),
(5, 'ertyghujiko');

-- --------------------------------------------------------

--
-- Table structure for table `group_member`
--

CREATE TABLE `group_member` (
  `group_id` int(3) NOT NULL,
  `mentor_id` int(3) NOT NULL,
  `mentee_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_id`, `mentor_id`, `mentee_id`) VALUES
(4, 1, 1),
(4, 1, 2),
(4, 1, 9),
(5, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `mentee_details`
--

CREATE TABLE `mentee_details` (
  `mentee_id` int(5) NOT NULL,
  `gr_no` int(6) NOT NULL,
  `enrollment_no` bigint(12) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(10) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(7) NOT NULL,
  `semester` int(1) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `department` varchar(10) NOT NULL,
  `email_id` varchar(60) NOT NULL,
  `password` varchar(15) NOT NULL,
  `in_group` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentee_details`
--

INSERT INTO `mentee_details` (`mentee_id`, `gr_no`, `enrollment_no`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `semester`, `stream`, `department`, `email_id`, `password`, `in_group`, `status`) VALUES
(1, 111609, 92110133001, 'dhanrajsinh', 'jyotindrasinh', 'parmar', 7433035109, '2002-08-19', 'male', 4, 'B.Tech', 'ICT', 'dhanrajsinh.parmar111609@marwadiuniversity.ac.in', 'Dhanrajsinh123', 1, 1),
(2, 111610, 92110133002, 'Devang', 'abc', 'qwe', 7539518426, '2022-03-01', 'female', 5, 'B.Tech', 'ICT', 'abs@gmail.com', 'asdZXC123', 1, 1),
(3, 111611, 92110133003, 'zxc', 'abc', 'qwe', 7539518421, '2022-03-01', 'male', 5, 'B.Tech', 'ICT', 'asd@gmail.com', 'asdZXC123', 0, 1),
(4, 111612, 92110133004, 'vbn', 'abc', 'qwe', 7539518422, '2022-03-01', 'male', 5, 'B.Tech', 'ICT', 'zxc@gmail.com', 'asdZXC123', 0, 1),
(5, 111613, 92110133005, 'bnm', 'abc', 'qwe', 7539518423, '2022-03-01', 'male', 5, 'B.Tech', 'ICT', 'bnm@gmail.com', 'asdZXC123', 0, 1),
(6, 111614, 92110133006, 'res', 'top', 'bottom', 9874563215, '2022-03-15', 'female', 3, 'Diploma', 'CE', 'top@gmail.com', 'TOPbot123', 0, 1),
(7, 111615, 92110133007, 'sel', 'top', 'bottom', 9874563216, '2002-12-10', 'female', 3, 'Diploma', 'IT', 'sel@gmail.com', 'SELres123', 0, 0),
(8, 0, 0, 'pratham', '', '', 7990974178, '2022-04-01', 'male', 0, '', '', 'pratham.buddhadev111596@marwadiuniversity.ac.in', 'Optimus@619', 1, 1),
(9, 0, 0, 'kaushal', '', '', 4567891230, '2022-04-08', 'male', 0, '', '', 'kaushal.faldu109119@marwadiuniversity.ac.in', 'Kaushal123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mentor_details`
--

CREATE TABLE `mentor_details` (
  `mentor_id` int(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(7) NOT NULL,
  `department` varchar(10) NOT NULL,
  `stream` varchar(10) NOT NULL,
  `qualification` varchar(20) NOT NULL,
  `email_id` varchar(60) NOT NULL,
  `password` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mentor_details`
--

INSERT INTO `mentor_details` (`mentor_id`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `department`, `stream`, `qualification`, `email_id`, `password`, `status`) VALUES
(1, 'ASD', '', '', 9824777575, '0000-00-00', '', '', '', '', 'asd@marwadieducation.edu.in', 'ASDqwe123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `parent_details`
--

CREATE TABLE `parent_details` (
  `parent_id` int(5) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `middle_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `mobile_no` bigint(10) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(7) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `email_id` varchar(60) NOT NULL,
  `password` varchar(15) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parent_details`
--

INSERT INTO `parent_details` (`parent_id`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `occupation`, `email_id`, `password`, `status`) VALUES
(1, '', '', '', 9624010494, '0000-00-00', '', '', '', '', 1),
(2, 'Devang', 'abc', 'qwe', 7539518426, '2022-03-01', 'male', 'Business Man', 'abs@gmail.com', 'Devang123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE `relation` (
  `mentee_id` int(3) NOT NULL,
  `mentor_id` int(3) NOT NULL,
  `parent_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE `temp` (
  `uname` varchar(20) NOT NULL,
  `uphone` int(10) NOT NULL,
  `umail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `to_do`
--

CREATE TABLE `to_do` (
  `mentor_id` int(3) NOT NULL,
  `mentee_id` int(3) NOT NULL,
  `task` varchar(500) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_details`
--
ALTER TABLE `group_details`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `mentee_details`
--
ALTER TABLE `mentee_details`
  ADD PRIMARY KEY (`mentee_id`);

--
-- Indexes for table `mentor_details`
--
ALTER TABLE `mentor_details`
  ADD PRIMARY KEY (`mentor_id`);

--
-- Indexes for table `parent_details`
--
ALTER TABLE `parent_details`
  ADD PRIMARY KEY (`parent_id`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`mentee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_details`
--
ALTER TABLE `group_details`
  MODIFY `group_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `mentee_details`
--
ALTER TABLE `mentee_details`
  MODIFY `mentee_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mentor_details`
--
ALTER TABLE `mentor_details`
  MODIFY `mentor_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `parent_details`
--
ALTER TABLE `parent_details`
  MODIFY `parent_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
  MODIFY `mentee_id` int(3) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
