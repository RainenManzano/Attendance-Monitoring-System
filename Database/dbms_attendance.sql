-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2020 at 06:13 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbms_attendance`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `Id` bigint(20) NOT NULL,
  `Class_Id` bigint(20) NOT NULL,
  `Student_Id` bigint(20) NOT NULL,
  `Datein` date NOT NULL,
  `Timein` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Id`, `Class_Id`, `Student_Id`, `Datein`, `Timein`) VALUES
(4, 6, 5, '2019-02-11', '21:34:01'),
(7, 6, 4, '2019-02-04', '21:08:31'),
(8, 6, 5, '2019-02-06', '08:27:21'),
(9, 6, 5, '2019-02-18', '22:30:28'),
(10, 6, 4, '2019-02-13', '05:10:17'),
(12, 6, 6, '2019-02-06', '05:55:56'),
(13, 6, 4, '2019-02-18', '21:29:07'),
(14, 6, 6, '2019-02-25', '20:30:49'),
(15, 12, 6, '2019-03-19', '09:09:33'),
(16, 13, 120, '2019-03-27', '11:04:19'),
(17, 13, 109, '2019-03-27', '11:06:10'),
(18, 13, 8, '2019-03-27', '11:09:16');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `Id` bigint(20) NOT NULL,
  `Subject_Code` varchar(30) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `Subject_Description` text NOT NULL,
  `Units` char(1) NOT NULL,
  `Section_Id` bigint(20) DEFAULT '0',
  `User_Id` bigint(20) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`Id`, `Subject_Code`, `Subject`, `Subject_Description`, `Units`, `Section_Id`, `User_Id`, `Status`) VALUES
(6, 'NASC_2033', 'College Physics', 'This is a subject description', '3', 1, 3, '1'),
(12, 'INTE 1234', 'Introduction', 'Intro', '3', 1, 3, '1'),
(13, 'COMP 3033', 'Software Engineering', 'Soft. Eng Description', '5', 8, 7, '1');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `Schedule_Id` bigint(20) NOT NULL,
  `Day` varchar(30) NOT NULL,
  `Beginning_Time` time NOT NULL,
  `End_Time` time NOT NULL,
  `Class_Id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`Schedule_Id`, `Day`, `Beginning_Time`, `End_Time`, `Class_Id`) VALUES
(1, 'monday', '21:30:00', '23:00:00', 6),
(8, 'wednesday', '08:00:00', '12:00:00', 6),
(16, 'monday', '09:00:00', '00:00:00', 12),
(17, 'wednesday', '09:00:00', '12:00:00', 13);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `Section_Id` bigint(20) NOT NULL,
  `Section_Name` varchar(100) NOT NULL,
  `Section_Desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`Section_Id`, `Section_Name`, `Section_Desc`) VALUES
(1, 'BS-IT Bridge', 'Ladderize section led by Maam Nayre'),
(4, 'BS CS 3-1', 'Bachelor of Science in Computer Science'),
(8, 'INTE 1234', 'Intro');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Id` bigint(20) NOT NULL,
  `Student_No` varchar(30) NOT NULL,
  `Firstname` varchar(50) NOT NULL,
  `Middlename` varchar(50) NOT NULL,
  `Lastname` varchar(50) NOT NULL,
  `Image_Path` varchar(100) DEFAULT NULL,
  `Section_Id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Id`, `Student_No`, `Firstname`, `Middlename`, `Lastname`, `Image_Path`, `Section_Id`) VALUES
(4, '2018-15757-MN-0', 'Rainen Scheenler', 'Delica', 'Manzano', '4.jpg', 1),
(5, '2015-00381-TG-0', 'Justine', 'Borja', 'Hernandez', '5.jpg', 1),
(6, '2018-15729-MN-1', 'Princess Nicole', 'Domingo', 'Nacianceno', '6.jpg', 1),
(8, '2015-12312-MN-1', 'John Cedric', '', 'Zamora', '8.jpg', 1),
(109, '2015-00380-TG-0', 'Charlie', 'Pagunsan', 'Sigasig', '109.JPG', 1),
(120, '2018-1234-MN-0', 'Abigail', 'Vargas', 'Datu', '120.jpeg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` bigint(20) NOT NULL,
  `Firstname` varchar(100) DEFAULT NULL,
  `Middlename` varchar(100) DEFAULT NULL,
  `Lastname` varchar(100) DEFAULT NULL,
  `Birthdate` date NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Pw` varchar(100) NOT NULL,
  `Level` char(1) NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `Firstname`, `Middlename`, `Lastname`, `Birthdate`, `Username`, `Pw`, `Level`, `Status`) VALUES
(1, 'Admin', '', '', '0000-00-00', 'admin', 'admin', '1', 'Active'),
(3, 'Princess Nicole', 'Domingo', 'Nacianceno', '1995-12-31', 'cess', 'cess', '0', 'Active'),
(5, 'Naruto', 'Namikaze', 'Uzumaki', '2004-01-01', 'naruto', 'uzumaki', '1', 'Active'),
(6, 'Kevin Paul', 'lama', 'Drid', '1998-01-23', 'lama', 'drid', '0', 'Active'),
(7, 'Florante', 'V', 'Andres', '1998-11-11', 'florante', 'florante', '0', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_studentid` (`Student_Id`),
  ADD KEY `fk_attendance_classid` (`Class_Id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_section` (`Section_Id`),
  ADD KEY `fk_user` (`User_Id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`Schedule_Id`),
  ADD KEY `fk_schedule` (`Class_Id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`Section_Id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `fk_section_id` (`Section_Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `Schedule_Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `Section_Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_classid` FOREIGN KEY (`Class_Id`) REFERENCES `class` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_studentid` FOREIGN KEY (`Student_Id`) REFERENCES `student` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `fk_section` FOREIGN KEY (`Section_Id`) REFERENCES `section` (`Section_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `fk_schedule` FOREIGN KEY (`Class_Id`) REFERENCES `class` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_section_id` FOREIGN KEY (`Section_Id`) REFERENCES `section` (`Section_Id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
