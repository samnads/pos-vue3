-- Adminer 4.8.0 MySQL 5.5.5-10.4.14-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `place` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_no` (`phone`),
  UNIQUE KEY `email` (`email`),
  KEY `group` (`group`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`group`) REFERENCES `customer_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `customer` (`id`, `group`, `name`, `place`, `email`, `phone`, `address`, `added_at`, `updated_at`) VALUES
(1,	1,	'Walk-In Customer',	'India',	NULL,	NULL,	NULL,	'2021-04-29 06:38:59',	NULL),
(2,	2,	'Felix',	'Africa',	NULL,	'65656',	'Add dfdfdfdfdf',	'2021-04-29 06:39:25',	NULL),
(3,	3,	'Peter',	'Malaysia',	'dsd@fd.ghh',	'454545',	'Weaff gg',	'2021-04-29 06:39:48',	NULL),
(4,	1,	'Geo Telip',	'Peavcalk',	'sdsd@efd.yyy',	NULL,	NULL,	'2021-04-29 06:40:13',	NULL),
(5,	3,	'gfhfghgf',	'tytryrtyty',	NULL,	NULL,	NULL,	'2021-04-29 06:47:42',	NULL),
(6,	3,	'tytyty',	'tytyty',	NULL,	NULL,	NULL,	'2021-04-29 06:47:46',	NULL),
(7,	2,	'tryrty',	'rtytytytu',	NULL,	NULL,	'yuyu',	'2021-04-29 06:47:54',	NULL),
(8,	3,	'tyutyu',	'utyutytty',	NULL,	NULL,	NULL,	'2021-04-29 06:48:01',	NULL);

-- 2021-04-29 06:48:12
