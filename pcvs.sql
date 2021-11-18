-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2021 at 03:19 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pcvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `staffID` varchar(7) NOT NULL,
  `centreName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`username`, `password`, `email`, `fullName`, `staffID`, `centreName`) VALUES
('admin', 'admin123', 'a@gmail.com', 'Admin Tan', 'HA0001', 'KPJ Damansara'),
('austin', 'austin123', 'austin@covax.com', 'Austin', 'HA0002', 'Prince Court'),
('david', 'david123', 'david@gmail.com', 'David Lee', 'HA0007', 'JPJ Hospital'),
('yuna', 'yuna1234', 'yuna@gmail.com', 'Yuna Kim', 'HA0008', 'Ampang Hospital');

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batchNo` varchar(7) NOT NULL,
  `expiryDate` date NOT NULL,
  `quantityAvailable` int(11) NOT NULL,
  `quantityAdministered` int(11) NOT NULL,
  `vaccineID` varchar(7) NOT NULL,
  `centreName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batchNo`, `expiryDate`, `quantityAvailable`, `quantityAdministered`, `vaccineID`, `centreName`) VALUES
('B000001', '2021-11-10', 0, 7, 'V000001', 'JPJ Hospital'),
('B000002', '2021-12-03', 50, 0, 'V000002', 'JPJ Hospital'),
('B000003', '2021-11-27', 49, 1, 'V000001', 'Prince Court');

-- --------------------------------------------------------

--
-- Table structure for table `healthcarecentre`
--

CREATE TABLE `healthcarecentre` (
  `centreName` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `healthcarecentre`
--

INSERT INTO `healthcarecentre` (`centreName`, `address`) VALUES
('Ampang Hospital', '3, Jalan Mewah Utara, K.L'),
('JPJ Hospital', '10 Jalan 1, Taman Midah, K.L'),
('KPJ Damansara', 'Kuala Lumpur'),
('Prince Court', 'Kuala Lumpur');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `fullName` varchar(50) NOT NULL,
  `ICPassport` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`username`, `password`, `email`, `fullName`, `ICPassport`) VALUES
('janey', 'janey1234', 'covax@gmail.com', 'Jane', ''),
('patient', 'patient1', 'b@gmail.com', 'Patient Lim', '91110204123'),
('patientT', 'patient123', 'patient@123.com', 'Patient Testing', '123'),
('patricia', 'patricia123', 'pat@covax.com', 'Patricia', ''),
('zzh', 'a1111111', 'zzh@gmail.com', 'Zhang ZheHan', '511291161314'),
('zzs', 'b2222222', 'zzs@gmail.com', 'Zhou ZiShu', '55555478989');

-- --------------------------------------------------------

--
-- Table structure for table `vaccination`
--

CREATE TABLE `vaccination` (
  `vaccinationID` int(7) NOT NULL,
  `appointmentDate` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `remarks` varchar(30) NOT NULL,
  `batchNo` varchar(7) NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccination`
--

INSERT INTO `vaccination` (`vaccinationID`, `appointmentDate`, `status`, `remarks`, `batchNo`, `username`) VALUES
(5, '2021-11-30', 'pending', '', 'B000001', 'patient'),
(6, '2021-12-03', 'confirmed', '', 'B000001', 'patientT'),
(8, '2021-11-26', 'pending', '', 'B000003', 'patricia');

-- --------------------------------------------------------

--
-- Table structure for table `vaccine`
--

CREATE TABLE `vaccine` (
  `vaccineID` varchar(7) NOT NULL,
  `manufacturer` varchar(40) NOT NULL,
  `vaccineName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaccine`
--

INSERT INTO `vaccine` (`vaccineID`, `manufacturer`, `vaccineName`) VALUES
('V000001', 'Comirnaty', 'Pfizer'),
('V000002', 'AstraZeneca', 'AstraZeneca'),
('V000003', 'Sinovac Biotech Ltd', 'Sinovac');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`username`),
  ADD KEY `administrator_fk` (`centreName`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batchNo`),
  ADD KEY `batch_vaccineID_fk` (`vaccineID`),
  ADD KEY `batch_centreName_fk` (`centreName`);

--
-- Indexes for table `healthcarecentre`
--
ALTER TABLE `healthcarecentre`
  ADD PRIMARY KEY (`centreName`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD PRIMARY KEY (`vaccinationID`),
  ADD KEY `vaccination_fk1` (`batchNo`),
  ADD KEY `vaccination_fk2` (`username`);

--
-- Indexes for table `vaccine`
--
ALTER TABLE `vaccine`
  ADD PRIMARY KEY (`vaccineID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vaccination`
--
ALTER TABLE `vaccination`
  MODIFY `vaccinationID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
  ADD CONSTRAINT `administrator_fk` FOREIGN KEY (`centreName`) REFERENCES `healthcarecentre` (`centreName`);

--
-- Constraints for table `batch`
--
ALTER TABLE `batch`
  ADD CONSTRAINT `batch_centreName_fk` FOREIGN KEY (`centreName`) REFERENCES `healthcarecentre` (`centreName`),
  ADD CONSTRAINT `batch_vaccineID_fk` FOREIGN KEY (`vaccineID`) REFERENCES `vaccine` (`vaccineID`);

--
-- Constraints for table `vaccination`
--
ALTER TABLE `vaccination`
  ADD CONSTRAINT `vaccination_fk1` FOREIGN KEY (`batchNo`) REFERENCES `batch` (`batchNo`),
  ADD CONSTRAINT `vaccination_fk2` FOREIGN KEY (`username`) REFERENCES `patient` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
