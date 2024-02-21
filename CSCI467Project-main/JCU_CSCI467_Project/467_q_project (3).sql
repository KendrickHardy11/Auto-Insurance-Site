-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2023 at 01:48 AM
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
-- Database: `467_q_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `associate`
--

CREATE TABLE `associate` (
  `AID` int(11) NOT NULL,
  `ANAME` char(16) NOT NULL,
  `UNAME` char(16) NOT NULL,
  `PASS` char(32) NOT NULL,
  `COMM` float(10,2) DEFAULT 0.00,
  `ADDR` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `associate`
--

INSERT INTO `associate` (`AID`, `ANAME`, `UNAME`, `PASS`, `COMM`, `ADDR`) VALUES
(3, 'Blane', 'B', 'student', 50.00, '1234 easy ST'),
(4, 'Kendrick', 'K', 'student', 50.00, '627 Huskie Dr'),
(5, 'Joe', 'J', 'student', 50.00, '111 NIU blvd'),
(6, 'Jacob', 'JA', 'student', 50.00, '467 Ege ave'),
(1, 'Admin', 'Admin', 'Admin', 0.00, 'Admin'),
(2, 'HQ', 'HQ', 'HQ', 0.00, 'HQ');

-- --------------------------------------------------------

--
-- Table structure for table `parts`
--

CREATE TABLE `parts` (
  `Parts_ID` int(6) NOT NULL,
  `Price_USD` double NOT NULL,
  `Description` varchar(200) NOT NULL,
  `Stock_Count` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts`
--

INSERT INTO `parts` (`Parts_ID`, `Price_USD`, `Description`, `Stock_Count`) VALUES
(1, 150000, 'Super Computer', 200),
(2, 2.75, 'Wiring (1ft)', 255),
(3, 15000.23, 'Testing Device ', 100),
(4, 70500.89, 'Generator ', 50),
(5, 2052.36, 'Giga Processor ', 150);

-- --------------------------------------------------------

--
-- Table structure for table `parts_lists`
--

CREATE TABLE `parts_lists` (
  `Parts_List_ID` int(11) NOT NULL,
  `Part_ID` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `Total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parts_lists`
--

INSERT INTO `parts_lists` (`Parts_List_ID`, `Part_ID`, `Qty`, `Total`) VALUES
(1, 2, 200000, 550000),
(1, 4, 5, 70500.89),
(2, 1, 1, 150000),
(2, 2, 50, 237.5),
(2, 5, 3, 6157.08),
(3, 5, 10, 20523.6),
(4, 1, 1, 150000),
(5, 2, 1000, 2750),
(6, 1, 1, 150000),
(6, 3, 10, 1500023);

-- --------------------------------------------------------

--
-- Table structure for table `quote_db`
--

CREATE TABLE `quote_db` (
  `Repair_Order_Num` int(11) NOT NULL,
  `Cust_ID` int(11) NOT NULL,
  `AID` int(11) NOT NULL,
  `Price` double NOT NULL,
  `EST_Hours` int(11) NOT NULL,
  `Hour_Rate` double NOT NULL,
  `Parts_List_ID` int(11) DEFAULT NULL,
  `Service_Description` varchar(200) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Status` enum('draft','finalized','sanctioned','ordered') NOT NULL DEFAULT 'draft',
  `Date` date NOT NULL DEFAULT current_timestamp(),
  `Notes` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quote_db`
--

INSERT INTO `quote_db` (`Repair_Order_Num`, `Cust_ID`, `AID`, `Price`, `EST_Hours`, `Hour_Rate`, `Parts_List_ID`, `Service_Description`, `Email`, `Status`, `Date`, `Notes`) VALUES
(1, 1, 1, 904504.45, 10, 200, 1, 'Server Generator Repair', '467testemail@gmail.com', 'draft', '2023-04-28', NULL),
(2, 2, 2, 184694.58, 142, 200, 2, 'Ege Magic Machine Repair', 'ege@niu.edu', 'draft', '2023-04-28', 'VIP, send the foremen and good techs. '),
(3, 3, 3, 29523.6, 45, 200, 3, 'AI Computer Hardware Upgrading', 'user@lucent.com', 'draft', '2023-04-28', 'doesn\'t like responding '),
(4, 4, 4, 156600, 33, 200, 4, 'Light Fixture Control Unit Install ', 'info@insight-tech.com', 'sanctioned', '2023-04-28', NULL),
(5, 5, 1, 400, 2, 200, NULL, 'Inspection ', 'user@rational.com', 'draft', '2023-04-28', NULL),
(6, 6, 2, 22400, 112, 200, 5, 'Fiber optic control module maintenance ', 'human102@bell.com', 'finalized', '2023-04-28', 'Definitely not human'),
(7, 7, 3, 400, 2, 200, NULL, 'Inspection ', 'JohnMyers@GE.org', 'draft', '2023-04-28', NULL),
(8, 8, 4, 408802.3, 544, 200, 6, 'Jet engine testing computer install.', 'bot@nbc.COMCAST.com', 'ordered', '2023-04-28', 'Not sure why comcast needs jet engine testing equipment. '),
(9, 9, 1, 800, 4, 200, NULL, 'Extended inspection ', 'SusanP@RP.org', 'draft', '2023-04-28', NULL),
(10, 10, 2, 400, 2, 200, NULL, 'Inspection ', 'yesnomaybe@johndeere.com', 'draft', '2023-04-28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parts`
--
ALTER TABLE `parts`
  ADD PRIMARY KEY (`Parts_ID`);

--
-- Indexes for table `parts_lists`
--
ALTER TABLE `parts_lists`
  ADD PRIMARY KEY (`Parts_List_ID`,`Part_ID`),
  ADD KEY `Part_ID` (`Part_ID`);

--
-- Indexes for table `quote_db`
--
ALTER TABLE `quote_db`
  ADD PRIMARY KEY (`Repair_Order_Num`),
  ADD KEY `Parts_List_ID` (`Parts_List_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quote_db`
--
ALTER TABLE `quote_db`
  MODIFY `Repair_Order_Num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parts_lists`
--
ALTER TABLE `parts_lists`
  ADD CONSTRAINT `parts_lists_ibfk_1` FOREIGN KEY (`Part_ID`) REFERENCES `parts` (`Parts_ID`);

--
-- Constraints for table `quote_db`
--
ALTER TABLE `quote_db`
  ADD CONSTRAINT `quote_db_ibfk_1` FOREIGN KEY (`Parts_List_ID`) REFERENCES `parts_lists` (`Parts_List_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
