-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2021 at 12:38 PM
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
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `ID` int(10) NOT NULL,
  `UserID` varchar(200) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `CommentText` varchar(1000) NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `later`
--

CREATE TABLE `later` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `love`
--

CREATE TABLE `love` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `love`
--

INSERT INTO `love` (`ID`, `PostID`, `UserID`) VALUES
(53, '25602021010019', '301021010019019011037');

-- --------------------------------------------------------

--
-- Table structure for table `pagefollowers`
--

CREATE TABLE `pagefollowers` (
  `ID` int(10) NOT NULL,
  `UserID` varchar(200) NOT NULL,
  `PageID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `ID` int(10) NOT NULL,
  `PageName` varchar(200) NOT NULL,
  `PageID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL,
  `PageType` varchar(200) NOT NULL,
  `PageDes` varchar(500) NOT NULL,
  `PageImage` varchar(1000) NOT NULL DEFAULT 'imgs/noimage.png',
  `Followers` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `IsPage` int(1) NOT NULL DEFAULT 0,
  `UserID` varchar(200) NOT NULL,
  `PostDate` date NOT NULL DEFAULT current_timestamp(),
  `PostTime` time NOT NULL DEFAULT current_timestamp(),
  `PostImage` varchar(500) NOT NULL DEFAULT 'imgs/noimage.png',
  `PostText` varchar(1000) NOT NULL,
  `LoveCount` int(10) NOT NULL DEFAULT 0,
  `CommentCount` int(10) NOT NULL DEFAULT 0,
  `ShareCount` int(10) NOT NULL DEFAULT 0,
  `PageID` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `PostID`, `IsPage`, `UserID`, `PostDate`, `PostTime`, `PostImage`, `PostText`, `LoveCount`, `CommentCount`, `ShareCount`, `PageID`) VALUES
(21, '25602021010019', 0, '301021010019019011037', '2021-10-19', '12:37:19', 'imgs/data/posts/Admin@admin.com-301021010019019011037.jpg', 'This Is The Everyone Dream If Its Not Your Dream As Us Read This Post', 1, 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `rmfromtl`
--

CREATE TABLE `rmfromtl` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE `share` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `UserStatus` varchar(10) NOT NULL DEFAULT 'offline',
  `TypeStatus` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserID`, `UserEmail`, `UserPassword`, `UserName`, `UserPhoto`, `BirthDay`, `BirthMon`, `BirthYear`, `UserFav`, `UserStatus`, `TypeStatus`) VALUES
(49, '301021010019019011037', 'Admin@admin.com', '123456', 'Admin Of The Page', 'imgs/data/users/Admin@admin.com-Admin Of The Page.jpg', 20, 20, 20, 'Sports Science beauty nature comedy technology foods cartoon culture music', 'online', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
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
-- Indexes for table `later`
--
ALTER TABLE `later`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `love`
--
ALTER TABLE `love`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pagefollowers`
--
ALTER TABLE `pagefollowers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `rmfromtl`
--
ALTER TABLE `rmfromtl`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
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
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `friendrequest`
--
ALTER TABLE `friendrequest`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `later`
--
ALTER TABLE `later`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `love`
--
ALTER TABLE `love`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pagefollowers`
--
ALTER TABLE `pagefollowers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `rmfromtl`
--
ALTER TABLE `rmfromtl`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
