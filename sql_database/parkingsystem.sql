-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 06:04 AM
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
-- Database: `parkingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedbackid` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedbackid`, `username`, `phonenumber`, `feedback`, `userid`) VALUES
(18, 'Tarun', '9946679763', 'Wow', 44),
(19, 'Sneha', '0987654321', 'nice experience', 45),
(20, 'Shoby', '1234567890', 'Nice Experience', 46),
(21, 'Shafi', '6987541237', 'Awesome service provider', 47);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentid` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `slotnum` int(11) DEFAULT NULL,
  `extraprice` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentid`, `price`, `slotnum`, `extraprice`) VALUES
(68, 20, 1, 0),
(69, 10, 3, 0),
(70, 30, 4, 0),
(71, 40, 5, 14),
(72, 140, 6, 0),
(73, 60, 7, 0),
(74, 30, 8, 0),
(75, 60, 10, 20),
(76, 15, 11, 15),
(77, 30, 9, 0),
(78, 30, 13, 0),
(79, 30, 17, 0);

-- --------------------------------------------------------

--
-- Table structure for table `slot`
--

CREATE TABLE `slot` (
  `slotnum` int(11) NOT NULL,
  `vehicletypeslot` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `ticketid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slot`
--

INSERT INTO `slot` (`slotnum`, `vehicletypeslot`, `status`, `ticketid`) VALUES
(1, 1, 1, 73),
(3, 3, 1, 74),
(4, 4, 1, 75),
(5, 1, 1, 76),
(6, 2, 1, 77),
(7, 3, 1, 78),
(8, 4, 1, 79),
(9, 1, 1, 82),
(10, 2, 1, 80),
(11, 3, 1, 81),
(12, 4, 0, NULL),
(13, 1, 1, 83),
(14, 2, 0, NULL),
(15, 3, 0, NULL),
(16, 4, 0, NULL),
(17, 1, 1, 84),
(18, 2, 0, NULL),
(19, 3, 0, NULL),
(20, 4, 0, NULL),
(21, 1, 0, NULL),
(22, 1, 0, NULL),
(23, 1, 0, NULL),
(24, 1, 0, NULL),
(25, 1, 0, NULL),
(26, 1, 0, NULL),
(27, 1, 0, NULL),
(28, 1, 0, NULL),
(29, 1, 0, NULL),
(30, 1, 0, NULL),
(31, 1, 0, NULL),
(32, 1, 0, NULL),
(33, 2, 0, NULL),
(34, 2, 0, NULL),
(35, 3, 0, NULL),
(36, 3, 0, NULL),
(37, 3, 0, NULL),
(38, 3, 0, NULL),
(39, 3, 0, NULL),
(40, 3, 0, NULL),
(41, 4, 0, NULL),
(42, 4, 0, NULL),
(43, 1, 0, NULL),
(44, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketid` int(11) NOT NULL,
  `timein` time NOT NULL,
  `timeout` time NOT NULL,
  `dateofbooking` varchar(255) NOT NULL,
  `vehicletype` int(11) NOT NULL,
  `numberplate` varchar(255) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `extratime` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketid`, `timein`, `timeout`, `dateofbooking`, `vehicletype`, `numberplate`, `userid`, `extratime`) VALUES
(72, '15:33:00', '15:35:00', '2023-11-20', 2, 'KL 07 CM 9992', 44, 0),
(73, '15:59:00', '17:59:00', '20-11-2023', 1, 'MH 01 AB 1234', 44, 0),
(74, '17:01:00', '19:01:00', '21-11-2023', 3, 'KA 12 CD 5678', 44, 0),
(75, '17:02:00', '20:02:00', '20-11-2023', 4, 'DL 34 EF 9012', 44, 0),
(76, '16:04:00', '20:04:01', '22-11-2023', 1, 'TN 45 GH 3456', 45, 2),
(77, '16:06:00', '23:06:00', '23-11-2023', 2, 'UP 78 IJ 7890', 45, 0),
(78, '07:08:00', '19:08:00', '22-11-2023', 3, 'RJ 67 KL 2345', 45, 0),
(79, '16:08:00', '19:09:00', '22-11-2023', 4, 'AP 89 MN 4567', 45, 0),
(80, '16:16:00', '19:16:01', '22-11-2023', 2, 'WB 56 QR 1234', 46, 2),
(81, '17:17:00', '23:17:00', '24-11-2023', 3, 'GJ 23 OP 8901', 46, 3),
(82, '18:03:00', '21:03:00', '22-11-2023', 1, 'TS 78 ST 5678', 46, 0),
(83, '18:08:00', '21:08:00', '20-11-2023', 1, 'TS 78 ST 4898', 46, 0),
(84, '09:31:00', '12:31:00', '23-12-2023', 1, 'KL 05 CM 5689', 47, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` varchar(10) NOT NULL,
  `isadmin` int(11) NOT NULL DEFAULT 0,
  `banstatus` int(11) NOT NULL DEFAULT 0,
  `feedbackgiven` varchar(255) DEFAULT '''0'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `phonenumber`, `isadmin`, `banstatus`, `feedbackgiven`) VALUES
(43, 'Admin', 'Admin@123', '9072160041', 1, 0, '0'),
(44, 'Tarun', 'Tarun@123', '9946679763', 0, 0, '0'),
(45, 'Sneha', 'Sneha@123', '0987654321', 0, 0, '0'),
(46, 'Shoby', 'Shoby@123', '1234567890', 0, 0, '0'),
(47, 'Shafi', 'Shafi@123', '6987541237', 0, 0, '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedbackid`),
  ADD KEY `username` (`username`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentid`),
  ADD KEY `slotnum` (`slotnum`);

--
-- Indexes for table `slot`
--
ALTER TABLE `slot`
  ADD PRIMARY KEY (`slotnum`),
  ADD KEY `ticketid` (`ticketid`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketid`),
  ADD UNIQUE KEY `numberplate` (`numberplate`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phonenumber` (`phonenumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `slot`
--
ALTER TABLE `slot`
  MODIFY `slotnum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`),
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`slotnum`) REFERENCES `slot` (`slotnum`);

--
-- Constraints for table `slot`
--
ALTER TABLE `slot`
  ADD CONSTRAINT `slot_ibfk_1` FOREIGN KEY (`ticketid`) REFERENCES `tickets` (`ticketid`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
