-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for beadando
CREATE DATABASE IF NOT EXISTS `beadando` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `beadando`;

-- Dumping structure for table beadando.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(50) NOT NULL,
  `uzenet` varchar(255) NOT NULL,
  `ido` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table beadando.chat: ~5 rows (approximately)
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
INSERT INTO `chat` (`id`, `uid`, `uzenet`, `ido`) VALUES
	(46, 14, 'Welcome traveller!', '2020-05-13'),
	(47, 26, 'asdiuhawiudhaisd', '2020-05-13'),
	(48, 26, 'asoidjaoisd', '2020-05-13'),
	(49, 27, 'Én vagyok GROOT!', '2020-05-13');
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;

-- Dumping structure for table beadando.userdata
CREATE TABLE IF NOT EXISTS `userdata` (
  `uid` int(255) NOT NULL,
  `szulido` date DEFAULT '2020-01-01',
  `lakhely` varchar(255) NOT NULL,
  `nem` int(255) NOT NULL DEFAULT 0,
  `webhely` varchar(255) NOT NULL,
  `github` varchar(255) NOT NULL,
  `bemutatkozas` varchar(255) NOT NULL,
  `kep` varchar(255) NOT NULL,
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table beadando.userdata: ~5 rows (approximately)
/*!40000 ALTER TABLE `userdata` DISABLE KEYS */;
INSERT INTO `userdata` (`uid`, `szulido`, `lakhely`, `nem`, `webhely`, `github`, `bemutatkozas`, `kep`) VALUES
	(14, '1996-11-17', 'Egercsehi', 1, 'Én vagyok GROOOOOOT!', 'https://github.com/Fizzor96', 'Én vagyok GROOT!', '14groot9.jpg'),
	(25, '2020-05-12', 'Valahol', 0, 'EZaz', 'van, de minek', 'Bemutatkozószöveg! Asderrrr', ''),
	(26, '2020-01-12', 'AAAAAAAA', 1, 'BBBBBBBB', 'CCCCCCC', 'AAAAAAAAVVVVVVVVVBBBBBBB', '26groot10.jpg'),
	(27, '1111-11-11', 'Én vagyok GROOT!', 2, 'Én vagyok GROOT!', 'Én vagyok GROOT!', 'Én vagyok GROOOOOOOT!', '27groot9.jpg');
/*!40000 ALTER TABLE `userdata` ENABLE KEYS */;

-- Dumping structure for table beadando.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `permission` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table beadando.users: ~5 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `email`, `permission`) VALUES
	(14, 'dominik', '2891baceeef1652ee698294da0e71ba78a2a4064', 'szokedominik@gmail.com', 1),
	(25, 'asd123', '2891baceeef1652ee698294da0e71ba78a2a4064', 'a@a.com', 0),
	(26, 'norbi', 'e2b85f03d99033c17434a7897fba72affe5813f9', 'mail.norbert.szucs@gmail.com', 1),
	(27, 'groot', '2891baceeef1652ee698294da0e71ba78a2a4064', 'groot@groot.com', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
