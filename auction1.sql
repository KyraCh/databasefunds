-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2022 at 06:27 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auction`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction1`
--

CREATE TABLE `auction1` (
  `auctionId` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `title` varchar(40) NOT NULL,
  `details` varchar(600) NOT NULL,
  `category` varchar(60) NOT NULL,
  `startingPrice` float NOT NULL,
  `reservePrice` float NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auction1`
--

INSERT INTO `auction1` (`auctionId`, `email`, `title`, `details`, `category`, `startingPrice`, `reservePrice`, `endDate`) VALUES
(294941, 'alexia_ch@gmail.com', 'Lego dragon', 'Selling a lego dragon game, all parts are in the box, paper with instructions included.', 'Hobbies & Leisure', 11.5, 0, '2022-12-04 18:00:00'),
(559526, 'kihuh@gmail.com', 'Ipad', 'Authentic Apple Ipad 7th Ge, colour black, 128GB capacity.', 'Electronics', 355, 0, '2022-12-15 12:00:00'),
(939234, 'larcrt@outlook.com', '4 pack cups', 'Excellent condition, fit in every home!', 'Home & Garden', 9.12, 0, '2022-11-28 09:30:00'),
(1476527, 'janeslin@hotmail.com ', 'Jacket', 'Nike dark blue jacket, size S, almost never worn, very good condition.', 'Fashion', 29.99, 0, '2022-11-08 00:00:00'),
(2579521, 'larcrt@outlook.com', 'T-shirt', 'Diesel red T-shirt, size M, never worn because it\'s too big, tags still on. ', 'Fashion', 39.99, 0, '2022-12-11 11:30:16'),
(6544415, 'cakeandfade@hotmail.com', 'Mixer for Baking', 'Very good condition, the brand is bosch.', 'Home & Garden', 22.75, 0, '0000-00-00 00:00:00'),
(83478172, 'mariaclk@gmail.com ', 'Shoes', 'addidas shoes, poor condition but wearable, size UK 9.', 'Fashion', 13.98, 0, '2022-12-29 18:00:30'),
(266233888, 'kihuh@gmail.com', 'Chair', 'Gaming chair, lovely for small kids playing video games.', 'Home & Garden', 75.66, 0, '2022-12-09 19:15:00'),
(321473291, 'janeslin@hotmail.com', 'Calculator', 'Casio grey calculator, bought 3 years ago, used but looks like new, brand new battery changed few days ago.', 'Electronics', 10, 0, '2022-12-05 19:45:21'),
(324798321, 'alexia_ch@gmail.com', 'Vacuum machine', 'Bought it last week but didn\'t like the color. Blue and grey, package is open but never used. Brand is hoover.', 'Electronics', 220, 0, '2022-12-12 00:00:00'),
(328975921, 'owenkg@hotmail.com', 'Teddy Bear ', 'White teddy bear bought 2 years ago. Good condition.', 'Other', 22, 0, '2022-11-10 17:00:00'),
(347321947, 'georgedavies@gmail.com', 'Dress', 'Colour: Pink\r\nBrand: Versace\r\nSize: M\r\nSuitable for formal occasions.', 'Fashion', 47.99, 0, '2023-01-22 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction1`
--
ALTER TABLE `auction1`
  ADD PRIMARY KEY (`auctionId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
