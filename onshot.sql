-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2021 at 08:22 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onshot`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `ID` int(10) NOT NULL,
  `SenderID` varchar(200) NOT NULL,
  `ReceiverID` varchar(200) NOT NULL,
  `Msg` varchar(1000) NOT NULL,
  `MsgDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friendrequest`
--

CREATE TABLE `friendrequest` (
  `ID` int(10) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `FriendID` varchar(200) NOT NULL,
  `RequestStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friendrequest`
--

INSERT INTO `friendrequest` (`ID`, `UserEmail`, `FriendID`, `RequestStatus`) VALUES
(8, 'Admin@admin.com', '14021010010010051018', 'Accepted'),
(9, 'friend2@gmail.com', '14021010010010051018', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `ID` int(10) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `FriendID` varchar(200) NOT NULL,
  `FriendFrom` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`ID`, `UserEmail`, `FriendID`, `FriendFrom`) VALUES
(18, 'friend1@gmail.com', '1000021010010010035018', '2021-10-13'),
(19, 'friend1@gmail.com', '401021010010010018058', '2021-10-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `UserID` varchar(200) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `UserPassword` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserPhoto` varchar(500) NOT NULL DEFAULT 'imgs/user.png',
  `BirthDay` int(2) NOT NULL,
  `BirthMon` int(2) NOT NULL,
  `BirthYear` int(4) NOT NULL,
  `UserFav` varchar(300) NOT NULL,
  `UserStatus` varchar(10) NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserID`, `UserEmail`, `UserPassword`, `UserName`, `UserPhoto`, `BirthDay`, `BirthMon`, `BirthYear`, `UserFav`, `UserStatus`) VALUES
(42, '401021010010010018058', 'Admin@admin.com', '123456', 'Emad Othman', 'imgs/user.png', 20, 20, 20, 'Sports culture music', 'offline'),
(45, '14021010010010051018', 'friend1@gmail.com', '123', 'Mohamed', 'imgs/user.png', 1, 1, 1, 'Sports comedy culture', 'online'),
(46, '1000021010010010035018', 'friend2@gmail.com', '123', 'Hassan Ahmed', 'imgs/user.png', 1, 1, 1, 'comedy culture', 'offline');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `friendrequest`
--
ALTER TABLE `friendrequest`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserEmail` (`UserEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `friendrequest`
--
ALTER TABLE `friendrequest`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
