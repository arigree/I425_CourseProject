-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2026 at 10:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musiclibrary`
--
DROP DATABASE IF EXISTS `musiclibrary`;
CREATE DATABASE IF NOT EXISTS `musiclibrary` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `musiclibrary`;

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumID` int(11) NOT NULL,
  `albumTitle` varchar(30) NOT NULL,
  `releaseDate` date NOT NULL,
  `artistID` int(11) DEFAULT NULL,
  `labelID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`albumID`, `albumTitle`, `releaseDate`, `artistID`, `labelID`) VALUES
(1, '19890', '2014-10-27', 1, 9),
(2, 'Divide', '2017-03-03', 2, 10),
(3, 'After Hours', '2020-03-20', 3, 9),
(4, 'SOUR', '2021-05-21', 4, 11),
(5, 'Doo-Wops & Hooligans', '2010-10-04', 5, 10),
(8, 'test album', '2014-10-27', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `artistID` int(11) NOT NULL,
  `artistName` varchar(30) NOT NULL,
  `artistDescription` varchar(100) NOT NULL,
  `joinDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`artistID`, `artistName`, `artistDescription`, `joinDate`) VALUES
(1, 'Taylor Swift', 'American singer-songwriter', '2006-10-24'),
(2, 'Ed Sheeran', 'English singer-songwriter', '2011-09-09'),
(3, 'The Weeknd', 'Canadian singer and producer', '2011-03-21'),
(4, 'Olivia Rodrigo', 'American singer-songwriter', '2021-05-21'),
(5, 'Bruno Mars', 'American singer-songwriter', '2010-10-04'),
(6, 'New Artist', 'Test Description', '2002-12-20'),
(9, 'New Artist3', 'Test Description', '2002-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `artist-song`
--

CREATE TABLE `artist-song` (
  `creditID` int(11) NOT NULL,
  `songID` int(11) NOT NULL,
  `artistID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist-song`
--

INSERT INTO `artist-song` (`creditID`, `songID`, `artistID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genreID` int(11) NOT NULL,
  `genreName` varchar(30) NOT NULL,
  `genreDescription` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genreID`, `genreName`, `genreDescription`) VALUES
(1, 'Pop', 'Popular mainstream music'),
(2, 'Rock', 'Rock and alternative music'),
(3, 'Hip-Hop', 'Rap and hip-hop music'),
(4, 'R&B', 'Rhythm and blues music'),
(5, 'Country', 'Country music');

-- --------------------------------------------------------

--
-- Table structure for table `recordlabel`
--

CREATE TABLE `recordlabel` (
  `labelID` int(11) NOT NULL,
  `labelName` varchar(30) NOT NULL,
  `labelDescription` varchar(100) NOT NULL,
  `startDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recordlabel`
--

INSERT INTO `recordlabel` (`labelID`, `labelName`, `labelDescription`, `startDate`) VALUES
(9, 'Republic Records', 'Major American record label under Universal Music Group.', '1995-01-01'),
(10, 'Atlantic Records', 'American label known for pop, rock, and hip-hop artists.', '1947-10-01'),
(11, 'Geffen Records', 'Label under Universal Music Group focusing on rock and pop artists.', '1980-01-01'),
(12, 'Interscope Records', 'American record label under Universal Music Group.', '1990-01-01'),
(13, 'Columbia Records', 'Historic American label under Sony Music Entertainment.', '1887-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(4) NOT NULL,
  `role` varchar(25) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`) VALUES
(1, 'System administrator', 'System admin'),
(2, 'Creator', 'Can add, list, and search data'),
(3, 'User', 'Can list and search data');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `songID` int(11) NOT NULL,
  `songTitle` varchar(30) NOT NULL,
  `duration` time NOT NULL,
  `releaseDate` date NOT NULL,
  `plays` int(11) NOT NULL,
  `genreID` int(11) DEFAULT NULL,
  `albumID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`songID`, `songTitle`, `duration`, `releaseDate`, `plays`, `genreID`, `albumID`) VALUES
(1, 'Blank Space', '00:03:51', '2014-11-10', 1200001, 1, 1),
(2, 'Shape of You', '00:03:53', '2017-01-06', 2500000, 1, 2),
(3, 'Blinding Lights', '00:03:20', '2019-11-29', 3000000, 4, 3),
(4, 'drivers license', '00:04:02', '2021-01-08', 1800000, 1, 4),
(5, 'Just the Way You Are', '00:03:40', '2010-07-20', 1500000, 1, 5),
(6, 'Test song', '00:03:51', '2014-11-10', 1200000, 1, 3),
(7, 'Blank Space', '00:03:51', '2014-11-10', 1200001, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) DEFAULT 4,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'TestEmail@Email.com', 'TestUser', '$2y$10$GOcg/K966L8r.gMiOFD.3utcs9NKwdTBZLRsKwPDGXeqAL4Dx6vC2', 1, '2026-06-15 08:20:48', '2026-06-15 08:20:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumID`),
  ADD KEY `artistID` (`artistID`),
  ADD KEY `album_label_fk` (`labelID`);

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`artistID`);

--
-- Indexes for table `artist-song`
--
ALTER TABLE `artist-song`
  ADD PRIMARY KEY (`creditID`),
  ADD KEY `songID` (`songID`),
  ADD KEY `artistID` (`artistID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genreID`);

--
-- Indexes for table `recordlabel`
--
ALTER TABLE `recordlabel`
  ADD PRIMARY KEY (`labelID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`songID`),
  ADD KEY `song_genre_fk` (`genreID`),
  ADD KEY `song_albums_fk` (`albumID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_uindex` (`username`),
  ADD KEY `fk_role_id` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `artistID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `artist-song`
--
ALTER TABLE `artist-song`
  MODIFY `creditID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genreID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recordlabel`
--
ALTER TABLE `recordlabel`
  MODIFY `labelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `songID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`artistID`) REFERENCES `artist` (`artistID`),
  ADD CONSTRAINT `album_label_fk` FOREIGN KEY (`labelID`) REFERENCES `recordlabel` (`labelID`);

--
-- Constraints for table `artist-song`
--
ALTER TABLE `artist-song`
  ADD CONSTRAINT `artist-song_ibfk_1` FOREIGN KEY (`songID`) REFERENCES `song` (`songID`),
  ADD CONSTRAINT `artist-song_ibfk_2` FOREIGN KEY (`artistID`) REFERENCES `artist` (`artistID`);

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_albums_fk` FOREIGN KEY (`albumID`) REFERENCES `album` (`albumID`),
  ADD CONSTRAINT `song_genre_fk` FOREIGN KEY (`genreID`) REFERENCES `genre` (`genreID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
