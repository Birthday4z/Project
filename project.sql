-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2020 at 10:15 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `Announcement_ID` int(11) NOT NULL,
  `Date_Create` date NOT NULL,
  `Date_End` date NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `Invoice_ID` int(11) NOT NULL,
  `Invoice_Note` varchar(250) NOT NULL,
  `Invoice_Date` date DEFAULT NULL,
  `Invoice_Room` int(11) DEFAULT NULL,
  `Invoice_Receiver_Name` varchar(250) NOT NULL,
  `Invoice_Total` int(11) NOT NULL,
  `Invoice_Date_Create` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Invoice_ID`, `Invoice_Note`, `Invoice_Date`, `Invoice_Room`, `Invoice_Receiver_Name`, `Invoice_Total`, `Invoice_Date_Create`) VALUES
(1, '', '2020-12-01', 101, 'ทดสอบ', 0, '0000-00-00 00:00:00'),
(2, '', '2020-11-11', 102, '', 0, '0000-00-00 00:00:00'),
(3, 'test', '2020-11-11', 101, 'ทดสอบ', 1000, '2020-11-04 03:19:03');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `Invoice_Item_ID` int(11) NOT NULL,
  `Invoice_ID` int(11) NOT NULL,
  `Item_Name` varchar(250) NOT NULL,
  `Item_Quantity` int(11) NOT NULL,
  `Item_Price` decimal(10,2) NOT NULL,
  `Item_Net` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lease`
--

CREATE TABLE `lease` (
  `Lease_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL,
  `Month_Create` varchar(50) NOT NULL,
  `Month_End` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lease`
--

INSERT INTO `lease` (`Lease_ID`, `Member_ID`, `Room_ID`, `Month_Create`, `Month_End`) VALUES
(1, 2, 101, '7/2563', '1/2600');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `Member_ID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `F_Name` varchar(50) NOT NULL,
  `L_Name` varchar(50) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`Member_ID`, `Username`, `Password`, `F_Name`, `L_Name`, `Phone`, `isAdmin`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'วีรภัทร', 'ศรีประดิษฐ์', '0972315630', 1),
(2, 'test', 'e10adc3949ba59abbe56e057f20f883e', 'ชื่อผู้ใช้', 'นามสกุลผู้ใช้', '01234567890', 0),
(3, 'dreamza555', 'e10adc3949ba59abbe56e057f20f883e', 'นันนภัส', 'พุทธะทิพากร', '0812345678', 0);

-- --------------------------------------------------------

--
-- Table structure for table `member_active`
--

CREATE TABLE `member_active` (
  `Room_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Lease_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `member_active`
--

INSERT INTO `member_active` (`Room_ID`, `Member_ID`, `Lease_ID`) VALUES
(101, 2, 1),
(102, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `petition`
--

CREATE TABLE `petition` (
  `Petition_ID` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petition`
--

INSERT INTO `petition` (`Petition_ID`, `Description`) VALUES
(1, 'คำร้องทำความสะอาด'),
(2, 'คำร้องซ่อมแซมอุปกรณ์');

-- --------------------------------------------------------

--
-- Table structure for table `petition_transaction`
--

CREATE TABLE `petition_transaction` (
  `Petition_Transaction_ID` int(11) NOT NULL,
  `Petition_ID` int(11) NOT NULL,
  `Room_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `Date_Create` varchar(10) NOT NULL,
  `Date_Admit` varchar(10) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `isFinished` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `Room_ID` int(11) NOT NULL,
  `Floor` int(2) NOT NULL,
  `Specification` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`Announcement_ID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`Invoice_ID`);

--
-- Indexes for table `invoice_item`
--
ALTER TABLE `invoice_item`
  ADD PRIMARY KEY (`Invoice_Item_ID`);

--
-- Indexes for table `lease`
--
ALTER TABLE `lease`
  ADD PRIMARY KEY (`Lease_ID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`Member_ID`);

--
-- Indexes for table `member_active`
--
ALTER TABLE `member_active`
  ADD PRIMARY KEY (`Room_ID`);

--
-- Indexes for table `petition`
--
ALTER TABLE `petition`
  ADD PRIMARY KEY (`Petition_ID`);

--
-- Indexes for table `petition_transaction`
--
ALTER TABLE `petition_transaction`
  ADD PRIMARY KEY (`Petition_Transaction_ID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`Room_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `Announcement_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Invoice_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `Invoice_Item_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `Lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Member_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `petition`
--
ALTER TABLE `petition`
  MODIFY `Petition_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `petition_transaction`
--
ALTER TABLE `petition_transaction`
  MODIFY `Petition_Transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
