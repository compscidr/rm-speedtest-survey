-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 04, 2018 at 05:29 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `testrun`
--

CREATE TABLE `testrun` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `uplink` float NOT NULL,
  `downlink` float NOT NULL,
  `rtt` float NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testrun`
--

INSERT INTO `testrun` (`id`, `userid`, `uplink`, `downlink`, `rtt`, `role`) VALUES
(1, 2, 16817700, 138431000, 30, 1),
(2, 2, 24688400, 142304000, 131, 1),
(3, 3, 23849300, 57484200, 53, 2),
(4, 2, 0, 55790000, 0, 1),
(5, 2, 6410780, 18136700, 38, 3),
(6, 2, 11754200, 77300700, 42, 1),
(7, 2, 6429010, 12540100, 92, 1),
(8, 2, 5849210, 82219800, 40, 1),
(9, 2, 19632800, 83742400, 35, 2),
(10, 2, 13543700, 51290300, 42, 2),
(11, 2, 16714100, 50029300, 38, 1),
(12, 2, 0, 0, 0, 1),
(13, 2, 11384300, 10967100, 89, 1),
(14, 4, 0, 0, 0, 1),
(15, 2, 7104000, 78797300, 43, 1),
(16, 2, 7104000, 64755500, 43, 2),
(17, 2, 16828100, 138904000, 30, 1),
(18, 5, 8740220, 6915690, 145, 1),
(19, 6, 4297660, 2093180, 197, 1),
(20, 6, 4611760, 2209610, 187, 1),
(21, 7, 11891500, 13023600, 633, 1),
(22, 8, 13928400, 17359300, 152, 3),
(23, 9, 5944470, 68632100, 138, 3),
(24, 10, 13671100, 22209500, 40, 1),
(25, 11, 22005300, 39648100, 52, 2),
(26, 12, 8474510, 62278200, 242, 2),
(27, 13, 16835100, 77521600, 29, 2),
(28, 14, 5090220, 17385200, 19, 2),
(29, 14, 4890220, 30327000, 113, 2),
(30, 15, 2453440, 28391200, 146, 2),
(31, 16, 13118100, 122587000, 31, 1),
(32, 16, 12916200, 110745000, 31, 3),
(33, 17, 2449820, 4561630, 366, 1),
(34, 18, 1801470, 3214250, 355, 1),
(35, 19, 5369240, 5564890, 477, 2),
(36, 20, 1777160, 3200220, 484, 1),
(37, 21, 1377310, 3102040, 849, 2),
(38, 22, 7648720, 8262040, 574, 1),
(39, 23, 21887000, 40617600, 83, 2),
(40, 24, 55448000, 30080400, 33, 1),
(41, 25, 0, 1836220, 0, 1),
(42, 25, 0, 0, 0, 1),
(43, 25, 0, 0, 0, 2),
(44, 2, 14940800, 129821000, 34, 1),
(45, 2, 19916200, 83228700, 34, 2),
(46, 2, 22245900, 86685500, 346, 1),
(47, 26, 3559300, 19552600, 685, 3),
(48, 27, 27771300, 34446700, 8, 2),
(49, 28, 4493630, 4271720, 306, 3),
(50, 29, 2327110, 2560880, 2955, 3),
(51, 2, 22635600, 98306300, 32, 1),
(52, 2, 19647000, 95313400, 31, 3),
(53, 2, 20903400, 87430300, 30, 1),
(54, 2, 20258200, 22648200, 35, 3),
(55, 2, 20441400, 35889600, 36, 3),
(56, 2, 12530400, 46196200, 28, 1),
(57, 2, 19670800, 97249300, 41, 1),
(58, 2, 13029900, 54483000, 108, 1),
(59, 2, 19491800, 93239000, 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip`, `longitude`, `latitude`) VALUES
(2, '184.71.161.242', -123.092, 49.262),
(3, '199.7.159.117', -122.992, 49.2038),
(4, '50.67.4.228', -122.994, 49.2478),
(5, '67.71.28.28', -80.5093, 43.4363),
(6, '173.32.167.13', -80.4467, 43.4646),
(7, '66.130.199.46', -73.5683, 45.5115),
(8, '50.98.150.180', -122.938, 49.1886),
(9, '184.151.114.133', -73.5788, 45.5486),
(10, '24.86.130.155', -123.092, 49.262),
(11, '199.7.159.78', -122.992, 49.2038),
(12, '184.151.231.111', -122.624, 49.1285),
(13, '50.98.155.217', -122.765, 49.274),
(14, '104.243.107.161', -123.04, 49.26),
(15, '96.48.110.252', -122.65, 49.1),
(16, '70.69.24.15', -122.616, 49.2196),
(17, '27.147.190.234', 90.375, 23.7),
(18, '103.102.218.210', 90.375, 23.7),
(19, '202.5.50.123', 89.2137, 23.1697),
(20, '103.80.70.155', 90.375, 23.7),
(21, '42.110.154.251', 88.3103, 22.5892),
(22, '27.147.190.149', 90.375, 23.7),
(23, '108.172.51.15', -122.579, 49.1661),
(24, '154.5.49.113', -123.041, 49.2397),
(25, '103.230.104.14', 90.375, 23.7),
(26, '119.30.32.186', 90.4112, 23.729),
(27, '207.244.143.126', -122.765, 49.274),
(28, '27.147.190.139', 90.375, 23.7),
(29, '43.245.120.94', 90.4112, 23.729);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `testrun`
--
ALTER TABLE `testrun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `testrun`
--
ALTER TABLE `testrun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
