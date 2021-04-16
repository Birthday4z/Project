-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2021 at 11:19 PM
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
  `Invoice_Date` varchar(10) DEFAULT NULL,
  `Room_ID` int(11) DEFAULT NULL,
  `Member_ID` int(11) DEFAULT NULL,
  `Invoice_Total` int(11) NOT NULL,
  `Invoice_Date_Create` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_item`
--

CREATE TABLE `invoice_item` (
  `Invoice_Item_ID` int(11) NOT NULL,
  `Invoice_ID` int(11) NOT NULL,
  `Item_Name` varchar(250) NOT NULL,
  `Item_Unit_Price` int(11) DEFAULT NULL,
  `Item_Unit_LastMonth` int(11) DEFAULT NULL,
  `Item_Unit_ThisMonth` int(11) DEFAULT NULL,
  `Item_Unit_Used` int(11) DEFAULT NULL,
  `Item_Amount` decimal(10,2) DEFAULT NULL
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
(1, 2, 101, '7-2020', '1-2600'),
(2, 3, 102, '11-2020', '1-2600'),
(3, 5, 104, '11-2020', '1-2600'),
(4, 4, 103, '11-2020', '1-2600');

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
(3, 'dreamza555', 'e10adc3949ba59abbe56e057f20f883e', 'นันนภัส', 'พุทธะทิพากร', '0812345678', 0),
(4, 'markzuck555', '6074c6aa3488f3c2dddff2a7ca821aab', 'จิรนันท์', 'สิทธิสมาน', '0851326342', 0),
(5, 'earthza007', '4a7d1ed414474e4033ac29ccb8653d9b', 'ธนภัทร', 'สีดา', '0926946926', 0);

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
(102, 3, 2),
(103, 4, 2),
(104, 0, 0),
(105, 5, 3),
(106, 5, 0),
(107, 0, 0),
(201, 0, 0),
(202, 0, 0),
(203, 0, 0);

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
(1, 'คำร้องทำความสะอาดห้องพัก'),
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

--
-- Dumping data for table `petition_transaction`
--

INSERT INTO `petition_transaction` (`Petition_Transaction_ID`, `Petition_ID`, `Room_ID`, `Member_ID`, `Date_Create`, `Date_Admit`, `Description`, `isFinished`) VALUES
(1, 1, 102, 3, '2020-11-14', '2020-11-15', 'มีขี้กองใหญ่ อยู่กลางห้อง', 0),
(2, 2, 102, 3, '2020-11-14', '2020-11-21', 'ชักโครก ระเบิด', 0),
(3, 1, 102, 3, '2020-11-14', '2020-11-19', '', 0),
(4, 1, 102, 3, '2020-11-14', '2020-11-17', 'ทำความสะอาดระเบียง', 0),
(5, 2, 102, 3, '2020-11-14', '2020-11-14', 'ทดสอบ', 0),
(6, 1, 102, 3, '2020-11-14', '2020-11-24', 'ทดสอบ', 0),
(7, 1, 102, 3, '2020-11-14', '2020-11-17', 'ห้องน้ำเปียก', 0),
(8, 1, 102, 3, '2020-11-15', '2020-11-22', 'ล้างตู้เย็น', 0),
(9, 2, 102, 3, '2020-11-15', '2020-11-21', 'ลูกบิดประตูเสีย', 0),
(10, 1, 102, 3, '2020-11-17', '2020-11-20', 'ทำความสะอาดห้องน้ำ', 0),
(11, 2, 102, 3, '2020-11-17', '2020-11-21', 'ลูกบิดประตูชำรุด', 0),
(12, 1, 103, 4, '2020-11-17', '2020-11-19', 'มีขี้หมาอยู่บนเตียง', 0),
(13, 2, 102, 3, '2020-11-19', '2020-11-21', 'ทดสอบ', 0),
(14, 1, 102, 3, '2020-11-19', '2020-11-21', 'ทดสอบ\r\n', 0),
(15, 1, 102, 3, '2020-11-19', '2020-11-21', 'ทดสอบ\r\n', 0),
(16, 1, 102, 3, '2020-11-23', '2020-11-25', '', 0),
(17, 2, 102, 3, '2020-11-23', '2020-11-25', 'ทดสอบ', 0),
(18, 1, 102, 3, '2020-11-24', '2020-11-24', '', 0),
(19, 1, 102, 3, '2020-11-24', '2020-11-24', '', 0),
(20, 1, 102, 3, '2020-11-24', '2020-11-25', '', 0),
(21, 1, 102, 3, '2020-11-24', '2020-11-30', 'ทดสอบ', 0),
(22, 2, 102, 3, '2020-11-24', '2020-11-29', 'ลูกบิดประตูชำรุด', 0),
(23, 1, 102, 3, '2020-11-25', '2020-11-27', 'ทดสอบ', 0),
(24, 1, 102, 3, '2020-11-27', '2020-11-29', 'sss', 0),
(25, 2, 102, 3, '2020-11-27', '2020-11-29', 'sss', 0),
(26, 2, 102, 3, '2020-11-27', '2020-11-28', 'sss', 0),
(27, 1, 102, 3, '2020-11-27', '2020-11-28', 'ssss', 0),
(28, 2, 102, 3, '2020-12-07', '2020-12-16', 'sss', 0),
(29, 1, 102, 3, '2020-12-08', '2020-12-17', 'ทดสอบ From Ngrok\r\n', 0);

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
-- Dumping data for table `room`
--

INSERT INTO `room` (`Room_ID`, `Floor`, `Specification`) VALUES
(101, 1, 'ห้องแอร์'),
(102, 1, 'ห้องแอร์'),
(103, 1, 'ห้องพัดลม'),
(104, 1, 'ห้องพัดลม'),
(105, 1, 'ห้องพัดลม'),
(106, 1, 'ห้องแอร์'),
(107, 1, 'ห้องแอร์'),
(201, 2, 'ห้องแอร์'),
(202, 2, 'ห้องแอร์'),
(203, 2, 'ห้องพัดลม');

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
  ADD PRIMARY KEY (`Member_ID`),
  ADD UNIQUE KEY `Username` (`Username`);

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
  MODIFY `Invoice_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_item`
--
ALTER TABLE `invoice_item`
  MODIFY `Invoice_Item_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lease`
--
ALTER TABLE `lease`
  MODIFY `Lease_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `Member_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `petition`
--
ALTER TABLE `petition`
  MODIFY `Petition_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `petition_transaction`
--
ALTER TABLE `petition_transaction`
  MODIFY `Petition_Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `Room_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
