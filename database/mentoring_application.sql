-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2022 at 07:02 PM
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

--
-- Dumping data for table `communnication`
--

INSERT INTO `communnication` (`mentor_id`, `mentee_id`, `comm`, `date`, `who`) VALUES
(1, 1, 'this is our first conversation.', '2022-05-05 14:12:45', 'mentor'),
(1, 1, 'Yes you are right.', '2022-05-05 14:12:59', 'mentee'),
(1, 12, 'hello pratham. how are you?', '2022-05-05 15:35:56', 'mentor'),
(1, 12, 'Im Fine.', '2022-05-05 15:51:05', 'mentee');

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`group_id`, `discussion`, `sender_name`, `date_time`) VALUES
(4, 'asd', 'ASD', '2022-04-09 14:35:05'),
(4, 'HELLO DEVANG', 'dhanrajsinh', '2022-04-11 09:45:58'),
(4, 'hello world', 'dhanrajsinh', '2022-04-11 10:22:00'),
(4, 'how are you?', 'dhanrajsinh', '2022-04-11 10:22:11'),
(4, 'HELLO PRATHAM`', 'user', '2022-04-11 11:20:56'),
(4, 'QWERTYUIOP', 'ASD', '2022-04-11 15:03:43'),
(4, 'hellooo bsdkkkkkkk', 'ASD', '2022-04-20 15:09:19'),
(11, 'This is our first conversation', 'ASD', '2022-05-05 08:56:36'),
(11, 'Yes you are right.', 'dhanrajsinh', '2022-05-05 17:49:13'),
(11, 'Helle There.', 'pratham', '2022-05-05 19:25:07'),
(11, 'Hello Pratham', 'ASD', '2022-05-05 19:25:38'),
(11, 'Im Fine.', 'Mentee dhanrajsinh', '2022-05-05 20:11:15');

--
-- Dumping data for table `group_details`
--

INSERT INTO `group_details` (`group_id`, `mentor_id`, `group_name`) VALUES
(11, 1, '4TK1'),
(12, 1, '2TK1');

--
-- Dumping data for table `group_member`
--

INSERT INTO `group_member` (`group_id`, `mentor_id`, `mentee_id`) VALUES
(11, 1, 1),
(11, 1, 12);

--
-- Dumping data for table `mentee_details`
--

INSERT INTO `mentee_details` (`mentee_id`, `gr_no`, `enrollment_no`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `semester`, `stream`, `department`, `email_id`, `password`, `in_group`, `status`) VALUES
(1, 111609, 92110133001, 'dhanrajsinh', 'jyotindrasinh', 'parmar', 7433035109, '2002-08-19', 'male', 4, 'B.Tech', 'ICT', 'dhanrajsinh.parmar111609@marwadiuniversity.ac.in', 'Dhanrajsinh123', 1, 1),
(12, 111596, 92110133003, 'pratham', 'bhaveshbhai', 'buddhadev', 7894561230, '2022-04-25', 'male', 4, 'B.Tech', 'ICT', 'prtham.buddhadev111596@marwadiuniversity.ac.in', 'Pratham@123', 1, 1);

--
-- Dumping data for table `mentor_details`
--

INSERT INTO `mentor_details` (`mentor_id`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `department`, `stream`, `qualification`, `email_id`, `password`, `status`) VALUES
(1, 'ASD', 'ZXC', 'QWE', 9824777575, '0000-00-00', 'male', 'ICT', 'BTECH', 'PHD', 'asd@marwadieducation.edu.in', 'ASDqwe123', 1);

--
-- Dumping data for table `parents_communnication`
--

INSERT INTO `parents_communnication` (`mentor_id`, `parent_id`, `comm`, `date`, `who`) VALUES
(1, 1, 'hello jyotindrasinh.', '2022-05-05 14:20:16', 'mentor'),
(1, 1, 'Im Fine.', '2022-05-05 18:47:53', 'parent');

--
-- Dumping data for table `parent_details`
--

INSERT INTO `parent_details` (`parent_id`, `first_name`, `middle_name`, `last_name`, `mobile_no`, `dob`, `gender`, `occupation`, `email_id`, `password`, `status`) VALUES
(1, 'jyotindrasinh', 'jaysinhji', 'parmar', 9624010494, '0000-00-00', 'male', 'businessman', 'jyt@gmail.com', 'Jyt@12345', 1),
(2, 'devang', 'abc', 'qwe', 7539518426, '2022-03-01', 'male', 'Business Man', 'abs@gmail.com', 'Devang123', 1);

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`mentee_id`, `mentor_id`, `parent_id`) VALUES
(1, 1, 1),
(12, 1, 2);

--
-- Dumping data for table `to_do`
--

INSERT INTO `to_do` (`mentor_id`, `mentee_id`, `task`, `file`, `date`, `who`) VALUES
(1, 1, 'cnanl,cnc', 'C:xampp	mpphp3508.tmp', '2022-05-05 14:17:19', 'mentor'),
(1, 1, 'cnanl,cnc', 'normalization tables.txt', '2022-05-05 14:17:43', 'mentor'),
(1, 1, 'compete it by today.', 'learn python.pdf', '2022-05-05 15:11:10', 'mentee');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
