-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 05:43 PM
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

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`ID`, `SenderID`, `ReceiverID`, `Msg`, `MsgDate`) VALUES
(28, '14021010010010051018', '1000021010010010035018', 'hi', '2021-10-14 08:27:50'),
(29, '14021010010010051018', '1000021010010010035018', 'emad', '2021-10-14 15:10:45');

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

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`ID`, `UserID`, `PostID`, `CommentText`) VALUES
(1, '401021010010010018058', '202101001501', 'I Love Kangarro'),
(2, '401021010010010018058', '202101001501', '*Kangaroo');

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
(37, '', '401021010010010018058'),
(39, '202101001501', '401021010010010018058');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `ID` int(10) NOT NULL,
  `PostID` varchar(200) NOT NULL,
  `UserID` varchar(200) NOT NULL,
  `PostDate` date NOT NULL DEFAULT current_timestamp(),
  `PostTime` time NOT NULL DEFAULT current_timestamp(),
  `PostImage` varchar(500) NOT NULL,
  `PostText` varchar(1000) NOT NULL,
  `LoveCount` int(10) NOT NULL DEFAULT 0,
  `CommentCount` int(10) NOT NULL DEFAULT 0,
  `ShareCount` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `PostID`, `UserID`, `PostDate`, `PostTime`, `PostImage`, `PostText`, `LoveCount`, `CommentCount`, `ShareCount`) VALUES
(1, '202101001500', '401021010010010018058', '2021-10-15', '05:25:16', 'imgs/data/posts/lion.jpg', 'The lion (Panthera leo) is a large cat of the genus Panthera native to Africa and India. It has a muscular, deep-chested body, short, rounded head, round ears, and a hairy tuft at the end of its tail. It is sexually dimorphic; adult male lions are larger than females and have a prominent mane. It is a social species, forming groups called prides. A lion\'s pride consists of a few adult males, related females, and cubs. Groups of female lions usually hunt together, preying mostly on large ungulates. The lion is an apex and keystone predator; although some lions scavenge when opportunities occur and have been known to hunt humans, the species typically does not.', 0, 0, 0),
(2, '202101001501', '401021010010010018058', '2021-10-15', '11:34:20', 'imgs/data/posts/kangaroo.jpg', 'The kangaroo is a marsupial from the family Macropodidae (macropods, meaning \"large foot\"). In common use the term is used to describe the largest species from this family, the red kangaroo, as well as the antilopine kangaroo, eastern grey kangaroo, and western grey kangaroo.[1] Kangaroos are indigenous to Australia and New Guinea. The Australian government estimates that 42.8 million kangaroos lived within the commercial harvest areas of Australia in 2019, down from 53.2 million in 2013.[2]\r\n\r\nAs with the terms \"wallaroo\" and \"wallaby\", \"kangaroo\" refers to a paraphyletic grouping of species. All three refer to members of the same taxonomic family, Macropodidae, and are distinguished according to size. The largest species in the family are called \"kangaroos\" and the smallest are generally called \"wallabies\". The term \"wallaroos\" refers to species of an intermediate size.[3] There are also the tree-kangaroos, another type of macropod, which inhabit the tropical rainforests of New Guine', 0, 0, 0);

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
  `UserStatus` varchar(10) NOT NULL DEFAULT 'offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `UserID`, `UserEmail`, `UserPassword`, `UserName`, `UserPhoto`, `BirthDay`, `BirthMon`, `BirthYear`, `UserFav`, `UserStatus`) VALUES
(42, '401021010010010018058', 'Admin@admin.com', '123456', 'Emad Othman', 'imgs/user.png', 20, 20, 20, 'Sports culture music', 'online'),
(45, '14021010010010051018', 'friend1@gmail.com', '123', 'Mohamed', 'imgs/user.png', 1, 1, 1, 'Sports comedy culture', 'offline'),
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
-- Indexes for table `posts`
--
ALTER TABLE `posts`
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
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `later`
--
ALTER TABLE `later`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `love`
--
ALTER TABLE `love`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `share`
--
ALTER TABLE `share`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
