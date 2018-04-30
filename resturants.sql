-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2013 at 07:52 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resturants`
--

-- --------------------------------------------------------

--
-- Table structure for table `advert`
--

CREATE TABLE IF NOT EXISTS `advert` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=75 ;

--
-- Dumping data for table `advert`
--

INSERT INTO `advert` (`id`, `url`, `name`, `desc`) VALUES
(72, 'http://localhost:8090/resturant/uploads/ScratchCardWeb4.gif', 'FFF', 'FFFFFF'),
(74, 'http://localhost:8090/resturant/uploads/gcat.jpg', 'asdfasdf', 'asdfasdfasdf');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `feedback` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `feedback`, `date`) VALUES
(1, 'fgsdfg', 'dsdf', '2013-08-06 10:06:41'),
(2, 'fgsdfg', 'dsdf', '2013-08-06 10:06:42'),
(3, 'fgsdfg', 'dsdf', '2013-08-06 10:06:48'),
(4, 'fgsdfg', 'dsdf', '2013-08-06 10:06:48'),
(5, 'asdfasdfasdf', 'asdfasdf', '2013-08-06 21:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE IF NOT EXISTS `food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `desc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL,
  `rest_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `food_group`
--

CREATE TABLE IF NOT EXISTS `food_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `rest_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `food_group`
--

INSERT INTO `food_group` (`id`, `name`, `rest_id`) VALUES
(1, 'MAIN DISH', 2),
(2, 'SALADS', 2),
(3, 'SIDE DISHES', 0),
(4, 'DESSERTS', 0),
(5, 'TODAY SPECIAL', 0),
(6, 'SANDWICHES', 0),
(7, 'DRINKS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `img`
--

CREATE TABLE IF NOT EXISTS `img` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `img`
--

INSERT INTO `img` (`id`, `name`) VALUES
(9, 'http://localhost:8090/resturant/uploads/gcat.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `food` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tid` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rating_food`
--

CREATE TABLE IF NOT EXISTS `rating_food` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `food_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rate` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `feedback` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rest`
--

CREATE TABLE IF NOT EXISTS `rest` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `food_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `delivery` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_cost` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rating` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `rating_count` int(11) NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rest`
--

INSERT INTO `rest` (`id`, `name`, `address`, `phone`, `food_type`, `delivery`, `delivery_cost`, `rating`, `rating_count`, `url`) VALUES
(1, 'Resturant Name', 'Khartoum 15 street', '090909093', 'Any Type', 'yes', 'free', '0', 0, 'http://www.cruzine.com/wp-content/uploads/2010/09/898-restaurant-logos.jpg'),
(2, 'Resturant Name 2', 'Khartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 streetKhartoum 15 stre', '09090909555', 'Any Type', 'no', 'free', '0', 0, 'http://www.cruzine.com/wp-content/uploads/2010/09/898-restaurant-logos.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `password`, `date`) VALUES
(6, 'ok', 'ok@ok.com', '12312312366', 'ok', '2013-07-14 00:26:41'),
(8, 'Hassan Gareeb', 'sudane@gmail.com', '249', 'ok', '2013-07-13 14:45:06'),
(9, 'a', 'a@a.com', 'a', 'a', '2013-07-18 11:41:00'),
(10, 'sd', 'as@as.com', '234d', '123', '2013-07-22 23:29:20'),
(11, 'test test', 'test@test.com', '123123', 'okok', '2013-07-26 15:22:32'),
(12, 'test', 'test2@test.com', '090909', 'ok', '2013-08-06 21:53:24'),
(13, 'tt', 'tt@tt.com', '909090909090', 'ok', '2013-08-12 00:37:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
