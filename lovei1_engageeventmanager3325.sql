-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 03, 2025 at 09:50 PM
-- Server version: 5.7.44
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lovei1_engageeventmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `Name` varchar(40) NOT NULL,
  `Organization` varchar(30) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `TimeStart` datetime NOT NULL,
  `TimeEnd` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `OrgID` int(11) NOT NULL,
  `OrgName` varchar(30) NOT NULL,
  `OrgDescription` varchar(250) NOT NULL,
  `OrgEmail` varchar(30) NOT NULL,
  `OrgPassword` varchar(42) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rsvps`
--

CREATE TABLE `rsvps` (
  `UID` int(11) NOT NULL,
  `EventName` varchar(40) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `UID` int(11) NOT NULL,
  `EventName` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `Email` varchar(42) NOT NULL,
  `Password` varchar(42) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `FirstName`, `LastName`, `Email`, `Password`) VALUES
(8, 'Ian', 'Love', 'ianklove88@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
(9, 'MArk', 'Jacobs', 'markj@gmail.com', '2aa60a8ff7fcd473d321e0146afd9e26df395147'),
(10, '', '', '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709'),
(11, 'cristian', 'arcentales', 'arcentalesc1@montclair.edu', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(12, 'Hacker', 'Jeff', 'HackerJ1@hacking.evil', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684'),
(13, 'Hacker', 'Jeff', 'HackerJ2@hacking.evil', 'd7cd56f2a2a3f47830760edfb89946eb7b9e2cd1'),
(14, 'Hacker', 'Jeff', 'HackerJ3@hacking.evil', '993376e3dcc84a0c11306eb2610b823af756216b'),
(15, 'Hacker', 'Jeff', 'HackerJ4@hacking.evil', '368f976940775c710aec525fe1e349f8a1fb9a39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`OrgID`);

--
-- Indexes for table `rsvps`
--
ALTER TABLE `rsvps`
  ADD PRIMARY KEY (`UID`,`EventName`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`UID`,`EventName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `UID` (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `OrgID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
