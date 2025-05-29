-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 27, 2025 at 04:14 PM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `j2k5e6r5_pmtvs`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `display_index` int NOT NULL,
  `position_id` int NOT NULL,
  `position_category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `display_index`, `position_id`, `position_category_id`, `name`, `position`, `address`, `image`) VALUES
(2, 98, 0, 0, 'श्री भैया लाल चौधरी', 'प्रदेश सचिव पिछड़ा वर्ग मध्य प्रदेश', 'निवास अंजनिया कला तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748019542_b067c814797ca952c791.jpg'),
(3, 97, 0, 0, 'श्री विनोद गुर्जर', 'प्रदेश उपाध्यक्ष पिछड़ा वर्ग मध्य प्रदेश', '-', '1748092697_a7f4a15f26e8be8788c6.jpg'),
(4, 96, 0, 0, 'श्री रमेश गुर्जर', 'प्रदेश अध्यक्ष पिछड़ा वर्ग मध्य प्रदेश', 'निवास अंजनिया कला तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748092810_ba11ed753f504172af64.jpg'),
(5, 95, 0, 0, 'श्री जितेंद्र', 'जिला उपाध्यक्ष खंडवा मध्य प्रदेश', 'निवास ग्राम मुंडाई तहसील पुनासा जिला खंडवा मध्य प्रदेश\n', '1748093167_5e6001c0c5e6a795db1b.jpg'),
(6, 94, 0, 0, 'श्री नानकराम मोरे', 'जिला अध्यक्ष खंडवा मध्य प्रदेश', 'निवासी रिछपाल तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748093249_b1eff0652fdd351972bb.jpg'),
(7, 93, 0, 0, 'सत्यनारायण वर्मा', 'संभाग अध्यक्ष उज्जैन मध्य प्रदेश', 'निवास बागान खेड़ा तहसील बागली जिला देवास', '1748093324_8f149f56f210dcfe0489.jpg'),
(8, 92, 0, 3, 'श्री मनोज चौहान', 'संभाग अध्यक्ष होशंगाबाद मध्य प्रदेश', 'निवास ग्राम टेमला तहसील डोलिया जिला होशंगाबाद', '1748101079_8cffe8920c4ff37c5385.jpg'),
(9, 91, 0, 2, 'श्री महेश बडोले', 'संभाग सचिव इंदौर मध्य प्रदेश', 'निवास बालापुरा तहसील खंडवा जिला खंडवा मध्य प्रदेश', '1748101123_00c3ec7e3970730b0783.jpg'),
(10, 90, 0, 2, 'श्री सुरेश डावर', 'संभाग उपाध्यक्ष इंदौर मध्य प्रदेश', 'निवास पीपल झोपा तहसील भगवानपुरा जिला खरगोन मध्य प्रदेश', '1748101435_b9ebb1cb153ab9636d26.jpg'),
(11, 89, 0, 2, 'श्री मदिप बारसे', 'संभाग अध्यक्ष इंदौर संभाग मध्य प्रदेश', 'निवास शिव धाम कॉलोनी इंदौर जिला इंदौर मध्य प्रदेश', '1748101526_3d43f994f56c3685b5b9.jpg'),
(12, 88, 0, 1, '‌श्री बलिराम दंगोड़े', 'कार्यकारिणी सदस्य', 'निवास ग्राम मुंडाई तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748101864_df1f3c2541427012f383.jpg'),
(13, 87, 0, 1, 'श्री नरसिंह मोरे', 'कार्यकारिणी सदस्य', 'निवास बलखड़ तहसील बड़वाह जिला खरगोन मध्य प्रदेश', '1748101923_b58d5cea14b6eaa506e7.jpg'),
(14, 86, 0, 1, 'श्री जगन मोरे', 'कार्यकारिणी सदस्य', 'निवास बलखड़ तहसील बड़वाह जिला खरगोन मध्य प्रदेश', '1748102066_aa40640172c5168ee952.jpg'),
(15, 85, 0, 1, 'श्रीमती राजेश्वरी गुजराती', 'कार्यकारिणी सदस्य', 'निवास खंडवा जिला खंडवा मध्य प्रदेश', '1748102126_77c5adab9bec27f97c1f.jpg'),
(16, 84, 0, 1, 'श्रीमती माधुरी चौहान', 'उप सचिव', 'निवास एखंड तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748102267_0216f0f48090116b8143.jpg'),
(17, 83, 0, 1, 'श्री विष्णु करोले', 'संयुक्त सचिव', 'खंडवा', '1748102330_a0a7b7392d80550ce17b.jpg'),
(18, 82, 0, 1, 'श्री बलवंत सिंह राजपूत', 'सहसचिव', 'निवास सिरलाय तहसील भीकनगांव जिला खरगोन मध्य प्रदेश', '1748102755_1496f70d00c7f0df24b9.jpg'),
(19, 81, 0, 1, 'श्री कुंवर सिंह बडोले', 'आयोजक', 'निवास ग्राम बलियापुर तहसील खंडवा जिला खंडवा मध्य प्रदेश', '1748102783_27b567fda8b426b93144.jpg'),
(20, 80, 0, 1, '‌श्री भवरसिंह मेहता', 'संयोजक', 'निवास मदनी खुर्द तहसील भगवानपुर जिला खरगोन मध्य प्रदेश', '1748102836_943a6c87ec584a8deb13.jpg'),
(21, 79, 0, 1, 'श्रीमती माया बाईं', 'माहासचिव', 'निवास सनावद तहसील सनावद जिला खरगोन मध्य प्रदेश', '1748102864_7107446659617b408041.jpg'),
(22, 78, 0, 1, 'श्री रायसिंह देवड़ा', 'महामंत्री', 'निवासी चांदेल तहसील पुनासा जिला खंडवा मध्य प्रदेश', '1748102894_6511cf61cbb0b7205cc9.jpg'),
(23, 77, 0, 1, 'श्रीमती सीमा चौहान', 'उपकोषाध्यक्ष', 'निवास नई बस्ती 15 नंबर वार्ड ओंकारेश्वर तहसील पुनासा जिला खंडवा', '1748102933_4834a59e1af5c851b8c6.jpg'),
(24, 76, 0, 1, 'श्रीमती सुधाबाई', 'कोषाध्यक्ष', 'निवास सिधखैड़ा तहसील खरगोन जिला खरगोन मध्य प्रदेश', '1748102962_927ff9cf3cc180305174.jpg'),
(25, 75, 0, 1, 'श्री केवल राम बारसे', 'वरिष्ठ उपाध्यक्ष', 'निवास ग्राम सिराली तहसील भिकनगाव जिला खरगोन मध्य प्रदेश', '1748103003_f1fbdf05d91f78933ac9.jpg'),
(26, 74, 0, 1, 'श्री शांतिलाल खौड़ै', 'उपाध्यक्ष', 'निवास भगवानपुर तहसील भगवानपुरा जिला मध्य प्रदेश', '1748103044_83a40d513b914384a168.jpg'),
(27, 73, 0, 1, 'श्रीमती अनीता गौड़', 'सचिव', 'निवास मोरगढ़ी कालोनी सनावद जिला खरगोन', '1748103084_e5b0bfe2a2175d67d42a.jpg'),
(28, 72, 0, 1, 'श्री सुरेंद्र कुमार भुसारिया', 'अध्यक्ष', 'निवास 15 नंबर वार्ड अटल बिहारी वाजपेई नगर परिषद पुनासा', '1748103156_002c67609191229f0ee9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `display_index` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `display_index`, `title`, `description`) VALUES
(1, 1, 'उपाध्यक्ष', '');

-- --------------------------------------------------------

--
-- Table structure for table `position_category`
--

DROP TABLE IF EXISTS `position_category`;
CREATE TABLE IF NOT EXISTS `position_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `display_index` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `position_category`
--

INSERT INTO `position_category` (`id`, `display_index`, `title`, `description`) VALUES
(1, 0, 'राष्ट्रीय पदाधिकारी ', ''),
(2, 2, 'इंदौर संभाग पदाधिकारी ', ''),
(3, 3, 'होशंगाबाद संभाग पदाधिकारी ', ''),
(4, 5, 'खंडवा जिला पदाधिकारी ', ''),
(5, 1, 'मध्य प्रदेश, प्रदेश पदाधिकारी पिछड़ा वर्ग ', ''),
(6, 4, 'उज्जैन संभाग पदाधिकारी ', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
