-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 08, 2024 at 11:15 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_client` (IN `nom` VARCHAR(255), IN `prenom` VARCHAR(255), IN `tel` INT, IN `login_email` VARCHAR(60), IN `login_password` VARCHAR(60))   BEGIN
    DECLARE message INT;

    IF NOT EXISTS (SELECT 1 FROM `client` WHERE login_email = login_email AND `login_password` = login_password) THEN
        SET message = 1;
    ELSE
        SET message = 0;
    END IF;

    SELECT message AS message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserttocart` (IN `id_client` INT, IN `id_product` INT, IN `quantity` INT, IN `total` INT)   BEGIN
    INSERT INTO `cart` ( id_client, id_product, quantity, total, date)
    VALUES ( id_client, id_product, quantity, total, CURRENT_TIMESTAMP);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `inserttocommandelist` (IN `id_client` INT, IN `id_product` INT, IN `quantity` INT, IN `total` INT)   BEGIN
    INSERT INTO `commandelist` ( id_client, id_product, quantity, total, date)
    VALUES ( id_client, id_product, quantity, total, CURRENT_TIMESTAMP);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insrt_client` (IN `nom` VARCHAR(255), IN `prenom` VARCHAR(255), IN `tel` INT, IN `login_emailc` VARCHAR(60), IN `login_password` VARCHAR(60))   BEGIN
    DECLARE message INT;

    IF NOT EXISTS (SELECT 1 FROM `client` WHERE login_email = login_emailc) THEN
        INSERT INTO `client` (nom, prenom, tel, login_email, login_password)
        VALUES (nom, prenom, tel, login_emailc, login_password);
        SET message = 1;
    ELSE
        SET message = 0;
    END IF;

    SELECT message AS message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insrt_login` (IN `emailc` VARCHAR(70), IN `passwordc` VARCHAR(70), IN `typec` VARCHAR(70))   BEGIN
DECLARE message INT;

IF NOT EXISTS (SELECT 1 FROM `login` WHERE email = emailc) THEN
INSERT INTO `login` (email,`password`,user_type)
    VALUES (emailc,passwordc,typec);
    SET message=1 ;
ELSE
SET message=0 ;
END IF ;
SELECT message AS message;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insrt_product` (IN `nom` VARCHAR(255), IN `prix` INT, IN `discount` INT, IN `category` VARCHAR(120), IN `dateCreation` DATETIME, IN `quantity` INT, IN `image_url` VARCHAR(120))   BEGIN
        INSERT INTO produit (nom, prix, discount, category, dateCreation, quantity, image_url) 
        VALUES (nom,prix,discount,category,dateCreation,quantity,image_url);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `test_login` (IN `emailc` VARCHAR(70), IN `passwordc` VARCHAR(70))   BEGIN
DECLARE message INT;

IF NOT EXISTS (SELECT 1 FROM `login` WHERE email = emailc AND `password` = passwordc) THEN
    SET message=0 ;
ELSE
SET message=1 ;
END IF ;
SELECT message AS message;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `tel` int NOT NULL,
  `login_email` varchar(60) DEFAULT NULL,
  `login_password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_email` (`login_email`),
  UNIQUE KEY `login_password` (`login_password`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `prenom`, `tel`, `login_email`, `login_password`) VALUES
(1, 'iliass', 'wakkar', 674007987, 'iliass.wakkar@um5r.ac.ma', 'iliass2001');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  `total` int NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`id_client`,`id_product`,`quantity`,`date`),
  KEY `id_client_cart` (`id_client`),
  KEY `id_product_cart` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `id_client`, `id_product`, `quantity`, `total`, `date`) VALUES
(31, 6, 2, 3, 120060, '2024-10-01 14:08:42'),
(32, 6, 15, 3, 150, '2024-10-29 23:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `nom`, `description`) VALUES
(1, 'Books', 'Literature and Fiction'),
(2, 'electronics', 'ssssssss');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(60) NOT NULL,
  `prenom` varchar(60) NOT NULL,
  `tel` int NOT NULL,
  `login_email` varchar(60) DEFAULT NULL,
  `login_password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_email` (`login_email`),
  UNIQUE KEY `login_password` (`login_password`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `nom`, `prenom`, `tel`, `login_email`, `login_password`) VALUES
(2, 'Iliass2', 'Wakkar', 2147483647, 'iliasswakkar2@gmail.com', '0000'),
(3, 'Iliass', 'Wakkar', 655240541, 'iliasswakkar22@gmail.com', '1111'),
(6, 'wakkar', 'iliass', 674007987, 'email@gmail.com', 'atelier');

-- --------------------------------------------------------

--
-- Table structure for table `commandelist`
--

CREATE TABLE IF NOT EXISTS `commandelist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_product` int NOT NULL,
  `quantity` int NOT NULL,
  `total` int NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`,`id_client`,`id_product`,`date`),
  KEY `id_client_list` (`id_client`),
  KEY `id_product_list` (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commandelist`
--

INSERT INTO `commandelist` (`id`, `id_client`, `id_product`, `quantity`, `total`, `date`) VALUES
(2, 2, 1, 5, 20000, '2024-05-02 16:31:30'),
(3, 2, 1, 3, 12000, '2024-05-02 22:00:41'),
(4, 3, 2, 5, 40000, '2024-05-02 15:44:05'),
(11, 2, 4, 4, 180000, '2024-05-16 00:45:33'),
(15, 2, 9, 3, 600, '2024-05-16 10:00:32'),
(17, 2, 14, 3, 1050, '2024-05-16 10:00:47'),
(18, 2, 4, 3, 135000, '2024-05-16 10:00:47'),
(20, 2, 9, 2, 400, '2024-05-16 10:09:33'),
(22, 2, 9, 3, 600, '2024-05-16 10:09:43'),
(23, 2, 9, 2, 400, '2024-05-16 10:09:43'),
(24, 2, 4, 2, 90000, '2024-05-16 10:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `email` varchar(80) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('Admin','Client') NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `password` (`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_type`) VALUES
('email@gmail.com', 'atelier', 'Client'),
('iliass.wakkar@um5r.ac.ma', 'iliass2001', 'Admin'),
('iliasswakkar2@gmail.com', '0000', 'Client'),
('iliasswakkar22@gmail.com', '1111', 'Client'),
('iliasswakkar29@gmail.com', '5555', 'Client');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `discount` decimal(5,2) DEFAULT '0.00',
  `category` varchar(60) COLLATE utf8mb4_general_ci NOT NULL,
  `dateCreation` date DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idc` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `prix`, `discount`, `category`, `dateCreation`, `quantity`, `image_url`) VALUES
(1, 'iphone', 4000.00, 10.00, 'electronics', '2024-04-01', 25, '../img/2.jpg'),
(2, 'prossesor', 40020.00, 20.00, 'electronics', '2024-04-01', 20, '../img/1.jpg'),
(4, 'sumsung tv', 45000.00, 10.00, 'electronics', '2024-04-28', 40, '../img/R.jpeg'),
(9, 'headphone', 200.00, 10.00, 'electronics', '2024-05-01', 50, '../img/8.webp'),
(14, 'Shoes', 350.00, 20.00, 'Books', '2024-05-16', 52, '../img/io.webp'),
(15, 'p1', 50.00, 10.00, 'electronics', '2024-10-29', 20, '../img/pexels-madebymath-90946.jpg'),
(16, 'prod3', 70.00, 10.00, 'Books', '2024-10-29', 10, '../img/ultra-realistic-orange-background-4k-hd-photo-product_1193781-21514.avif');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `login_email_admin` FOREIGN KEY (`login_email`) REFERENCES `login` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_password_admin` FOREIGN KEY (`login_password`) REFERENCES `login` (`password`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `id_client_cart` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_product_cart` FOREIGN KEY (`id_product`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `login_email_client` FOREIGN KEY (`login_email`) REFERENCES `login` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `login_password_client` FOREIGN KEY (`login_password`) REFERENCES `login` (`password`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commandelist`
--
ALTER TABLE `commandelist`
  ADD CONSTRAINT `id_client_list` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_product_list` FOREIGN KEY (`id_product`) REFERENCES `produit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `category` FOREIGN KEY (`category`) REFERENCES `category` (`nom`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
