-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 26, 2022 at 06:08 AM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ogaras_magic_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `type_id` int(255) NOT NULL,
  `rarity_id` int(11) NOT NULL,
  `product_price` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `product_rarity` (`rarity_id`),
  KEY `product_type` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `type_id`, `rarity_id`, `product_price`) VALUES
(1, 'Greatclub of Frost Giants', 1, 3, 4000),
(2, 'Breastplate of Joan of Arc', 2, 6, 24400),
(3, 'Sling of David', 1, 3, 16000),
(4, 'Splint of Metal Flesh', 2, 5, 24200),
(5, 'Defender Rapier', 1, 6, 24100),
(6, 'Rapier of Life-Stealing', 1, 3, 1030),
(7, 'Ring of Water Elemental Command', 3, 6, 25000),
(8, 'Robe of Useful Items', 5, 2, 8000),
(9, 'Scroll of Enhance Ability', 4, 2, 240),
(10, 'Scroll of Investiture of Flame', 4, 3, 2560),
(11, 'Scroll of Sickening Radiance', 4, 3, 640),
(12, 'Splint Armor of Resistance (Acid)', 2, 3, 6200),
(13, 'Sword of Answering', 1, 6, 36000),
(14, 'Something Wicked', 1, 1, 1000),
(15, 'Fireball Scroll', 4, 2, 650),
(16, 'Mladjo\'s Bow', 1, 6, 45000),
(17, 'Something Wicked', 5, 3, 26563);

-- --------------------------------------------------------

--
-- Table structure for table `rarities`
--

DROP TABLE IF EXISTS `rarities`;
CREATE TABLE IF NOT EXISTS `rarities` (
  `rarity_id` int(11) NOT NULL AUTO_INCREMENT,
  `rarity_name` varchar(255) NOT NULL,
  PRIMARY KEY (`rarity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rarities`
--

INSERT INTO `rarities` (`rarity_id`, `rarity_name`) VALUES
(1, 'Common'),
(2, 'Uncommon'),
(3, 'Rare'),
(4, 'Very Rare'),
(5, 'Mythical'),
(6, 'Legendary');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `type_name`) VALUES
(1, 'Weapon'),
(2, 'Armor'),
(3, 'Ring'),
(4, 'Scroll'),
(5, 'Wonder');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_rarity` FOREIGN KEY (`rarity_id`) REFERENCES `rarities` (`rarity_id`),
  ADD CONSTRAINT `product_type` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
