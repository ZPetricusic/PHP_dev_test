-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2021 at 02:16 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movies`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `api_key` char(40) NOT NULL,
  `requests` int(11) NOT NULL DEFAULT 0,
  `last_request_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`api_key`, `requests`, `last_request_time`) VALUES
('4985ba90ece24c965c2d3c4b64ebff49f301a2bc', 963, '2021-07-10 12:15:45'),
('ed559244775a1bc15bc99cf0f79b733b37c80ce0', 2, '2021-07-10 12:16:19');

--
-- Triggers `api`
--
DELIMITER $$
CREATE TRIGGER `API_CALL_DELAY` BEFORE UPDATE ON `api` FOR EACH ROW BEGIN
IF NEW.last_request_time + 2 < CURRENT_TIMESTAMP
THEN UPDATE api SET last_request_time = last_request_time;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `refcode` varchar(15) NOT NULL,
  `title` varchar(100) NOT NULL,
  `category` varchar(30) NOT NULL,
  `img_src` varchar(200) NOT NULL,
  `creation_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `refcode`, `title`, `category`, `img_src`, `creation_year`) VALUES
(1, '12097', 'How I almost met your mother', 'Comedy', 'https://m.media-amazon.com/images/M/MV5BNjg1MDQ5MjQ2N15BMl5BanBnXkFtZTYwNjI5NjA3._V1_.jpg', 2005),
(2, '7520', 'The Platform', 'Thriller', 'http://karike.ba/wp-content/uploads/2020/11/The-Platform-izvor-www.imdb_.com_.jpg', 2019);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`api_key`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
