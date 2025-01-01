-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 03:01 PM
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
-- Database: `projectevent`
--

-- --------------------------------------------------------

--
-- Table structure for table `admintable`
--

CREATE TABLE `admintable` (
  `AdminName` varchar(20) NOT NULL COMMENT 'Admin',
  `AdminPass` varchar(20) NOT NULL COMMENT 'Admin123'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admintable`
--

INSERT INTO `admintable` (`AdminName`, `AdminPass`) VALUES
('Admin', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `event_table`
--

CREATE TABLE `event_table` (
  `EventID` int(255) NOT NULL,
  `Name` varchar(300) NOT NULL,
  `Venue` varchar(300) NOT NULL,
  `Date` varchar(300) NOT NULL,
  `Action` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_table`
--

INSERT INTO `event_table` (`EventID`, `Name`, `Venue`, `Date`, `Action`) VALUES
(1, 'Sausage Party', 'Rumah Hadif', '2025-01-02', 'hell yeah'),
(2, 'Rembat Cable Uniten', 'UNITEN', '2025-01-02', 'hell yeah'),
(3, 'asdkjlahdl', 'aerberba', '2025-01-02', 'asdfvaef'),
(4, 'Majlis Gigit Hadif', 'YTJT', '2025-01-03', 'hell yeah');

-- --------------------------------------------------------

--
-- Table structure for table `participant_table`
--

CREATE TABLE `participant_table` (
  `Part_ID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `Event_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

CREATE TABLE `usertable` (
  `ID` int(255) NOT NULL,
  `Username` varchar(300) NOT NULL,
  `Password` varchar(300) NOT NULL,
  `Email` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`ID`, `Username`, `Password`, `Email`) VALUES
(2, 'Anas', '1234', 'thetoma12@gmail.com'),
(3, 'Abu', '1234', 'tombakawali@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_table`
--
ALTER TABLE `event_table`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `participant_table`
--
ALTER TABLE `participant_table`
  ADD PRIMARY KEY (`Part_ID`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_table`
--
ALTER TABLE `event_table`
  MODIFY `EventID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `participant_table`
--
ALTER TABLE `participant_table`
  MODIFY `Part_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
