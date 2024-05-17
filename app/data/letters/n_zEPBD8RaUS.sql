-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 09:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tz_clients`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `ClientID` int(11) NOT NULL,
  `ClientName` varchar(200) NOT NULL,
  `TelephoneNo` varchar(15) NOT NULL,
  `MobileNo` varchar(15) NOT NULL,
  `Fax` varchar(15) DEFAULT NULL,
  `ContactPersonName` varchar(200) NOT NULL,
  `ContactPersonMobileNo` varchar(15) NOT NULL,
  `ContactPersonDesignation` varchar(100) DEFAULT NULL,
  `StateID` tinyint(4) NOT NULL,
  `DistrictID` smallint(6) NOT NULL,
  `CityName` varchar(100) NOT NULL,
  `PinCode` varchar(10) NOT NULL,
  `Landmark` text NOT NULL,
  `Logo` varchar(100) DEFAULT NULL,
  `MaxUsers` varchar(10) DEFAULT NULL,
  `CreatedDateTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL,
  `isActive` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ClientID`, `ClientName`, `TelephoneNo`, `MobileNo`, `Fax`, `ContactPersonName`, `ContactPersonMobileNo`, `ContactPersonDesignation`, `StateID`, `DistrictID`, `CityName`, `PinCode`, `Landmark`, `Logo`, `MaxUsers`, `CreatedDateTime`, `CreatedBy`, `isActive`) VALUES
(17, 'riahtam', '1231231231', '1231231231', 'YHURFRBFVEURVU', 'test user', '1234561243', '2', 17, 3, 'Shillong', '908789', 'near sbi bank', '', '34', '2023-08-11 07:40:44', 1, b'0'),
(18, 'Ban', '76890', '543', 'fgdfh', '4323', '54543', '-1', 17, 3, 'Shillong', '908789', 'near sbi bank', '', '2', '2023-08-11 07:45:43', 1, b'1'),
(21, 'test', '1231231231', '1231231231', 'YHURFRBFVEURVU', 'test user', '1234561243', '2', 17, 3, 'Shillong', '908789', 'near sbi bank', 'C:\\fakepath\\Screenshot 2023-03-03 at 4.02.37 PM.png', '200', '2023-08-11 08:49:30', 1, b'1'),
(24, 'testxzv', '1231231231', '1231231231', 'YHURFRBFVEURVU', 'test user', '1234561243', '1', 17, 3, 'SHIL;LONG', '908789', 'near sbi bank', 'C:\\fakepath\\Screenshot 2023-03-03 at 4.02.37 PM.png', '200', '2023-08-11 09:03:08', 1, b'1'),
(25, 'test123', '1231231231', '1231231231', 'YHURFRBFVEURVU', 'test user', '1234561243', '2', 17, 3, 'Shillong', '908789', 'near sbi bank', 'C:\\fakepath\\Photos Library.photoslibrary.zip', '200', '2023-08-11 09:04:08', 1, b'1'),
(26, 'SAC', '0987', '89008', '890988', '8900', '788', '3', 17, 3, 'Bhoi', '9808', 'AIR', 'C:\\fakepath\\images.jpeg', '7889', '2023-08-11 09:05:47', 1, b'1'),
(40, 'Pak', '1234', '76890', '346', 'Pak123', 'pak 76890', '1', 17, 3, 'Shillong', '5435', 'Polo', 'C:\\fakepath\\Photos Library.photoslibrary.zip', '1', '2023-08-16 06:52:11', 1, b'1'),
(42, 'ITPL', '76580', '7888', 'ITPL90', 'ITPL908', '9008', '3', 17, 1, 'Shillong', '793002', '1', 'C:\\fakepath\\images.jpeg', '1', '2023-08-16 09:24:08', 1, b'1'),
(43, 'dag', 'qerq', '54352', '325', 'wertr', '53245', '1', 17, 1, 'et', '3423', '343', 'C:\\fakepath\\images.jpeg', '2', '2023-08-16 09:53:25', 1, b'1'),
(44, 'were', '3443', '343', '3423', 'er', 'ewrw', '2', 17, 1, 'ewrwe', '2', '2', 'C:\\fakepath\\KG.jpg', '1', '2023-08-16 10:28:17', 1, b'1'),
(45, 'ITPL09', '123456789', '9087654321', '908', 'ITPL', '987654321', '1', 0, 0, 'Shillong', '793002', 'POLO', 'C65c4c8a71c714.png', '20', '2023-08-23 08:51:23', 1, b'1'),
(46, 'Ban123', '54345', '654463', '634', 'Band', '897645', '3', 17, 4, 'Mawkyrwat', '793114', 'Dt', '', '67', '2023-08-24 06:41:58', 1, b'1'),
(47, 'ddd', '788787', '773241', '32324', 'ndfs', '7897897', '1', 17, 1, 'fdgs', '98989', 'dgsdf', '', '65', '2023-08-26 07:52:28', 1, b'1'),
(48, 'fdsgs', '523423', '2345', '24352', '4354', '23454', '2', 17, 3, 'vs', '53235', 'ewgew', '', '34', '2023-08-26 07:54:50', 1, b'1'),
(49, 'awrt', '345 ', '5345', '34534', 'erte', '34564', '1', 17, 1, 'rt', '3456', 'ert', '', '45', '2023-08-31 09:41:35', 1, b'1'),
(50, 'Dev', '9366535583', '9366535583', '', 'Dev', '9366535583', 'Teacher', 1, 1, 'Shillong', '793001', 'Polo Shillong', NULL, '450', '2024-04-01 11:34:43', 1, b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ClientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
