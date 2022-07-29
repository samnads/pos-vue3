-- Adminer 4.8.1 MySQL 5.5.5-10.4.21-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `barcode_symbology`;
CREATE TABLE `barcode_symbology` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `desc` text CHARACTER SET utf8 DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `barcode_symbology` (`id`, `code`, `name`, `desc`, `deleted_at`) VALUES
(1,	'CODE128',	'CODE128 (auto and force mode)',	NULL,	NULL),
(2,	'CODE39',	'CODE39',	NULL,	NULL),
(3,	'EAN / UPC',	'EAN-13, EAN-8, EAN-5, EAN-2, UPC (A)',	NULL,	NULL),
(4,	'ITF-14',	'ITF-14',	NULL,	NULL),
(5,	'ITF',	'ITF',	NULL,	NULL),
(6,	'MSI',	'MSI',	NULL,	NULL),
(7,	'Pharmacode',	'Pharmacode',	NULL,	NULL);

DROP TABLE IF EXISTS `brand`;
CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4;

INSERT INTO `brand` (`id`, `code`, `name`, `image`, `description`, `deletable`, `editable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'LX',	'Lexi',	NULL,	'Tesssssssssst.......',	0,	0,	'2021-01-24 06:01:28',	'2022-07-07 17:06:42',	NULL),
(3,	'CM',	'Camlin',	NULL,	'jt',	NULL,	NULL,	'2021-01-24 06:01:54',	'2022-07-07 17:00:15',	NULL),
(67,	'ew',	'rere',	NULL,	'wqq6',	NULL,	NULL,	'2021-04-23 18:17:49',	'2021-04-23 18:19:48',	NULL),
(69,	'ry',	'lexi6',	NULL,	'7u7',	NULL,	NULL,	'2021-04-23 20:11:19',	NULL,	NULL),
(70,	'df',	'df',	NULL,	'dfdf',	NULL,	NULL,	'2021-04-30 07:01:19',	'2022-07-07 17:00:15',	NULL),
(72,	'yuyu',	'ty',	NULL,	'ytu',	NULL,	NULL,	'2021-05-08 18:00:04',	NULL,	NULL),
(73,	'fgdfg',	'gfg',	NULL,	'dgddd',	NULL,	NULL,	'2021-05-11 20:48:27',	NULL,	NULL),
(74,	'werwer',	'wer',	NULL,	'werwr',	NULL,	NULL,	'2021-05-11 20:52:34',	NULL,	NULL),
(75,	'try',	'rty',	NULL,	'rtyrty',	NULL,	NULL,	'2021-05-11 20:52:49',	NULL,	NULL),
(76,	'ytr',	'ryrty',	NULL,	'rtyrtyy',	NULL,	NULL,	'2021-05-11 20:53:39',	NULL,	NULL),
(77,	'7567',	'756',	NULL,	'676',	NULL,	NULL,	'2021-05-11 22:17:08',	NULL,	NULL),
(78,	'567',	'567',	NULL,	'657567',	NULL,	NULL,	'2021-05-17 19:12:50',	NULL,	NULL),
(81,	'ty',	'ytuty',	NULL,	't76878',	NULL,	NULL,	'2021-08-19 19:54:10',	NULL,	NULL),
(118,	'BRAN0118',	'oikpiopip',	NULL,	NULL,	NULL,	NULL,	'2022-07-09 14:43:31',	NULL,	NULL),
(119,	'dgfg',	'bfgfg',	NULL,	'gfgfgfg',	NULL,	NULL,	'2022-07-15 15:38:56',	NULL,	NULL),
(120,	'rrtergg',	'dfgdfgfg',	NULL,	'fgfgfg',	NULL,	NULL,	'2022-07-20 10:25:44',	NULL,	NULL),
(121,	'BRAN0121',	'asas',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:38:13',	NULL,	NULL),
(122,	'BRAN0122',	'sdsdsd',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:52:40',	NULL,	NULL),
(123,	'BRAN0123',	'fgfgfg',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:54:22',	NULL,	NULL),
(124,	'BRAN0124',	'EEE',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:56:03',	NULL,	NULL),
(125,	'BRAN0125',	'PPP',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:56:44',	NULL,	NULL),
(126,	'BRAN0126',	'kljkkljkl',	NULL,	NULL,	NULL,	NULL,	'2022-07-20 13:57:29',	NULL,	NULL),
(127,	'lkl',	'lklk',	NULL,	NULL,	NULL,	NULL,	'2022-07-23 16:26:15',	NULL,	NULL),
(128,	'545',	'uuu',	NULL,	NULL,	NULL,	NULL,	'2022-07-24 07:20:24',	NULL,	NULL);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `allow_sub` tinyint(1) DEFAULT NULL COMMENT 'use 0 for disallow',
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parent_name` (`parent`,`name`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `slug` (`slug`),
  CONSTRAINT `category_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

INSERT INTO `category` (`id`, `parent`, `code`, `image`, `name`, `description`, `slug`, `allow_sub`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'CAT003',	NULL,	'Miscellaneous',	'to898',	'fhfghfgh',	0,	NULL,	NULL,	'2022-07-17 16:19:16',	'2022-07-27 05:08:35',	NULL),
(2,	NULL,	'CATSI',	NULL,	'School Items',	'',	'ddd',	0,	NULL,	NULL,	'2022-07-17 16:20:15',	'2022-07-27 06:57:46',	NULL),
(3,	2,	'ffdfgdg',	NULL,	'Books',	NULL,	'fdgdfgdfg',	NULL,	NULL,	NULL,	'2022-07-17 16:20:29',	'2022-07-26 17:42:02',	NULL),
(4,	3,	NULL,	NULL,	'King',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:20:44',	'2022-07-17 16:21:30',	NULL),
(5,	3,	NULL,	NULL,	'Small',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:20:53',	'2022-07-17 16:21:27',	NULL),
(6,	3,	NULL,	NULL,	'Long',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:21:24',	NULL,	NULL),
(7,	NULL,	NULL,	NULL,	'Woman',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:21:51',	NULL,	NULL),
(8,	7,	NULL,	NULL,	'Beauty',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:22:02',	NULL,	NULL),
(9,	7,	NULL,	NULL,	'Earings',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:22:02',	NULL,	NULL),
(10,	7,	NULL,	NULL,	'Rings',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:22:22',	NULL,	NULL),
(11,	8,	NULL,	NULL,	'Makeup Kits',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:22:47',	NULL,	NULL),
(12,	NULL,	NULL,	NULL,	'Laptops',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:22:56',	NULL,	NULL),
(13,	NULL,	NULL,	NULL,	'PC',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:23:05',	NULL,	NULL),
(14,	NULL,	'MOB',	NULL,	'Mobiles',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:23:20',	'2022-07-26 15:15:52',	NULL),
(15,	14,	NULL,	NULL,	'Apple',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:23:37',	NULL,	NULL),
(16,	14,	'sfsdf',	NULL,	'One Plus',	'dfd88',	'oneplus5',	0,	NULL,	NULL,	'2022-07-17 16:23:55',	'2022-07-26 18:06:51',	NULL),
(17,	14,	NULL,	NULL,	'Nothing',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-17 16:24:03',	NULL,	NULL),
(18,	15,	NULL,	NULL,	'I Phone 11',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 04:57:00',	NULL,	NULL),
(19,	18,	NULL,	NULL,	'I Phone 11 - 16 GB',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 04:58:53',	NULL,	NULL),
(20,	18,	NULL,	NULL,	'I Phone 11 - 32 GB',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 04:59:00',	NULL,	NULL),
(21,	12,	NULL,	NULL,	'i5 Generation',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 05:00:51',	NULL,	NULL),
(22,	4,	NULL,	NULL,	'King Blue',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 05:11:52',	NULL,	NULL),
(23,	2,	NULL,	NULL,	'Charts',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 06:54:53',	NULL,	NULL),
(24,	23,	NULL,	NULL,	'Pink Chart',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 10:36:34',	NULL,	NULL),
(25,	19,	NULL,	NULL,	'I Phone 11 - 16 GB Blue',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 13:47:06',	NULL,	NULL),
(26,	19,	NULL,	NULL,	'I Phone 11 - 16 GB Red',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 13:47:06',	NULL,	NULL),
(27,	4,	NULL,	NULL,	'King Red',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 14:13:37',	NULL,	NULL),
(28,	4,	'tuy',	NULL,	'King Pink',	'',	'klj',	NULL,	NULL,	NULL,	'2022-07-18 05:11:52',	'2022-07-27 15:49:49',	NULL),
(29,	26,	NULL,	NULL,	'I Phone 11 - 16 GB Red V1',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 15:20:51',	NULL,	NULL),
(30,	29,	NULL,	NULL,	'I Phone 11 - 16 GB Red V1 - 1',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 15:20:51',	NULL,	NULL),
(31,	NULL,	NULL,	NULL,	'Empty',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 15:52:27',	NULL,	NULL);

DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(15) NOT NULL,
  `symbol` varchar(5) NOT NULL,
  `rate` decimal(10,0) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `symbol` (`symbol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `currency` (`id`, `code`, `name`, `symbol`, `rate`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'INR',	'Indian Rupee',	'₹',	1,	'2021-03-02 14:11:32',	NULL,	NULL),
(2,	'USD',	'Dollar',	'$',	63,	'2021-03-02 14:11:32',	NULL,	NULL);

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `group` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `place` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pin_code` varchar(12) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','PENDING') NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_no` (`phone`),
  UNIQUE KEY `email` (`email`),
  KEY `group` (`group`),
  CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`group`) REFERENCES `customer_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4;

INSERT INTO `customer` (`id`, `code`, `group`, `name`, `place`, `email`, `phone`, `address`, `pin_code`, `city`, `description`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(41,	'CUST0041',	1,	'uyuytu',	'yuytuyuyt',	NULL,	NULL,	NULL,	NULL,	NULL,	'oipi',	NULL,	NULL,	'ACTIVE',	'2022-06-30 16:11:34',	'2022-07-09 13:54:01',	'2022-07-09 13:54:01'),
(42,	'CUST0042',	3,	'yuyuyu',	'yuyuyu',	NULL,	NULL,	'898',	NULL,	NULL,	'88890',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:26:31',	'2022-07-06 17:05:31',	'2022-07-06 17:05:31'),
(44,	'CUST0044',	2,	'aaa',	'tytyt',	'dfdf@fg.ghgh',	'565656',	'jhkuhoi',	'65656',	'6565',	'uiiouioiuo',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:38:41',	'2022-07-06 17:04:48',	'2022-07-06 17:04:48'),
(45,	'CUST0045',	2,	'tyutu6767',	'6767',	NULL,	NULL,	'jkjk',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:51:58',	'2022-07-01 14:26:53',	'2022-07-01 14:26:53'),
(48,	'CUST0048',	4,	'aaaa',	'aaa',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	'ACTIVE',	'2022-07-01 04:52:16',	'2022-07-01 14:26:40',	NULL),
(50,	'CUST0050',	2,	'rtdtg',	'ggfg',	NULL,	NULL,	NULL,	NULL,	NULL,	'klklkluy',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:52:27',	'2022-07-06 17:12:57',	NULL),
(51,	'CUST0051',	1,	'kjjhkjk',	'uiuii',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 05:38:54',	'2022-07-09 13:53:54',	'2022-07-09 13:53:54'),
(52,	'CUST0052',	1,	'tyutyu',	'yutyutyu',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'ACTIVE',	'2022-07-01 06:50:43',	'2022-07-01 14:26:40',	NULL),
(53,	'CUST0053',	2,	'jmhjhgj',	'hjhgjghjhgj',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-06 17:13:05',	NULL,	NULL);

DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percentage` decimal(10,4) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `customer_group` (`id`, `name`, `percentage`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'General',	0.0000,	'2021-04-02 06:33:09',	NULL,	NULL),
(2,	'Reseller',	50.0000,	'2021-04-02 06:33:22',	NULL,	NULL),
(3,	'Distributor',	65.0000,	'2021-04-02 06:34:04',	NULL,	NULL),
(4,	'Friends',	10.0000,	'2021-04-02 16:50:30',	'2021-04-02 16:50:34',	NULL);

DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `code` varchar(2) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `gender` (`id`, `name`, `code`, `description`) VALUES
(1,	'Male',	'M',	NULL),
(2,	'Female',	'F',	NULL),
(3,	'Not specify',	'NS',	NULL);

DROP TABLE IF EXISTS `hsn_sac`;
CREATE TABLE `hsn_sac` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate` int(11) DEFAULT NULL,
  `tax_group` int(11) DEFAULT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_rate` (`tax_rate`),
  KEY `tax_group` (`tax_group`),
  CONSTRAINT `hsn_sac_ibfk_1` FOREIGN KEY (`tax_rate`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `hsn_sac_ibfk_2` FOREIGN KEY (`tax_group`) REFERENCES `tax_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17943 DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `label_size`;
CREATE TABLE `label_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `p_width` float(6,2) NOT NULL,
  `p_height` float(6,2) NOT NULL,
  `labels` float(6,2) NOT NULL,
  `l_width` float(6,2) NOT NULL,
  `l_height` float(6,2) NOT NULL,
  `rows` float(6,2) NOT NULL,
  `columns` float(6,2) NOT NULL,
  `row_gutter` float(6,2) NOT NULL,
  `column_gutter` float(6,2) NOT NULL,
  `margin_t` float(6,2) NOT NULL,
  `margin_r` float(6,2) NOT NULL,
  `margin_b` float(6,2) NOT NULL,
  `margin_l` float(6,2) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `label_size` (`id`, `code`, `name`, `p_width`, `p_height`, `labels`, `l_width`, `l_height`, `rows`, `columns`, `row_gutter`, `column_gutter`, `margin_t`, `margin_r`, `margin_b`, `margin_l`, `deleted_at`) VALUES
(1,	'A456',	'A4 56 Label Per Page',	210.00,	297.00,	56.00,	48.00,	20.00,	14.00,	4.00,	1.00,	2.00,	2.00,	6.00,	2.00,	6.00,	NULL),
(2,	'A484',	'A4 84 Label Per Page',	210.00,	297.00,	84.00,	46.00,	11.00,	21.00,	4.00,	1.50,	5.00,	18.00,	5.50,	18.00,	5.50,	NULL);

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

INSERT INTO `module` (`id`, `name`, `description`, `added_at`, `updated_at`) VALUES
(1,	'product',	'',	'2022-07-06 11:59:05',	NULL),
(2,	'category',	'',	'2022-07-06 11:59:05',	NULL),
(3,	'brand',	'This module is for product brands, here you can set permission for add, edit, update and delete the brands.',	'2022-07-06 11:59:05',	NULL),
(4,	'tax',	'This module can add create unique tax name based on tax rate and calculation type.',	'2022-07-06 11:59:05',	'2022-07-12 16:41:18'),
(5,	'unit',	'',	'2022-07-06 11:59:05',	NULL),
(6,	'supplier',	'',	'2022-07-06 11:59:05',	NULL),
(7,	'customer',	'',	'2022-07-06 11:59:05',	NULL),
(8,	'user',	'',	'2022-07-06 11:59:05',	NULL),
(9,	'warehouse',	'',	'2022-07-06 11:59:05',	NULL),
(10,	'role',	'Role is to restrict or allow actions based on user level.',	'2022-07-06 11:59:05',	'2022-07-12 13:31:17'),
(11,	'pos',	'',	'2022-07-06 11:59:05',	NULL),
(12,	'type',	'',	'2022-07-06 11:59:05',	NULL),
(13,	'symbology',	'',	'2022-07-06 11:59:05',	NULL),
(14,	'label',	'',	'2022-07-06 11:59:05',	NULL),
(15,	'stock_adjustment',	'',	'2022-07-06 11:59:05',	NULL),
(16,	'customer_group',	'',	'2022-07-06 11:59:05',	NULL),
(17,	'common',	'',	'2022-07-06 11:59:05',	NULL);

DROP TABLE IF EXISTS `module_permission`;
CREATE TABLE `module_permission` (
  `module` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `checked` tinyint(1) DEFAULT NULL COMMENT 'default checked or not',
  `read_only` tinyint(1) DEFAULT NULL,
  `comments` varchar(50) DEFAULT NULL,
  UNIQUE KEY `module_permission` (`module`,`permission`),
  KEY `permission` (`permission`),
  CONSTRAINT `module_permission_ibfk_1` FOREIGN KEY (`module`) REFERENCES `module` (`id`),
  CONSTRAINT `module_permission_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `permission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Available Permissions for each modules';

INSERT INTO `module_permission` (`module`, `permission`, `checked`, `read_only`, `comments`) VALUES
(1,	1,	NULL,	NULL,	'PRODUCT'),
(1,	3,	NULL,	NULL,	'PRODUCT'),
(1,	4,	NULL,	NULL,	'PRODUCT'),
(1,	6,	1,	NULL,	'PRODUCT'),
(1,	7,	NULL,	NULL,	'PRODUCT'),
(2,	1,	NULL,	NULL,	'CATEGORY'),
(2,	3,	NULL,	NULL,	'CATEGORY'),
(2,	4,	NULL,	NULL,	'CATEGORY'),
(2,	6,	NULL,	NULL,	'CATEGORY'),
(3,	1,	NULL,	NULL,	'BRAND'),
(3,	3,	NULL,	NULL,	'BRAND'),
(3,	4,	NULL,	NULL,	'BRAND'),
(3,	6,	NULL,	NULL,	'BRAND'),
(4,	1,	NULL,	NULL,	'TAX'),
(4,	3,	NULL,	NULL,	'TAX'),
(4,	4,	NULL,	NULL,	'TAX'),
(4,	6,	NULL,	NULL,	'TAX'),
(5,	1,	NULL,	NULL,	'UNIT'),
(5,	3,	NULL,	NULL,	'UNIT'),
(5,	4,	NULL,	NULL,	'UNIT'),
(5,	6,	NULL,	NULL,	'UNIT'),
(6,	1,	NULL,	NULL,	'SUPPLIER'),
(6,	3,	NULL,	NULL,	'SUPPLIER'),
(6,	4,	NULL,	NULL,	'SUPPLIER'),
(6,	6,	NULL,	NULL,	'SUPPLIER'),
(7,	1,	NULL,	NULL,	'CUSTOMER'),
(7,	3,	NULL,	NULL,	'CUSTOMER'),
(7,	4,	NULL,	NULL,	'CUSTOMER'),
(7,	6,	NULL,	NULL,	'CUSTOMER'),
(8,	1,	NULL,	NULL,	'USER'),
(8,	3,	NULL,	NULL,	'USER'),
(8,	4,	NULL,	NULL,	'USER'),
(8,	6,	NULL,	NULL,	'USER'),
(9,	1,	NULL,	NULL,	'WAREHOUSE'),
(9,	3,	NULL,	NULL,	'WAREHOUSE'),
(9,	4,	NULL,	NULL,	'WAREHOUSE'),
(9,	6,	NULL,	NULL,	'WAREHOUSE'),
(10,	1,	NULL,	NULL,	'ROLE'),
(10,	3,	NULL,	NULL,	'ROLE'),
(10,	4,	NULL,	NULL,	'ROLE'),
(10,	6,	NULL,	NULL,	'ROLE'),
(11,	1,	1,	NULL,	'POS'),
(15,	1,	1,	NULL,	'STOCK ADJ.'),
(15,	3,	NULL,	NULL,	'STOCK ADJ.'),
(15,	4,	NULL,	NULL,	'STOCK ADJ.'),
(15,	6,	NULL,	NULL,	'STOCK ADJ.');

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

INSERT INTO `permission` (`id`, `name`, `usage`, `added_at`, `updated_at`) VALUES
(1,	'create',	'Create',	'2021-05-07 16:33:13',	'2022-07-12 12:23:58'),
(2,	'read',	'Read',	'2021-05-07 16:33:28',	'2022-07-12 12:24:26'),
(3,	'update',	'Update',	'2021-05-07 16:33:34',	'2022-07-12 12:24:14'),
(4,	'delete',	'Delete',	'2021-05-07 16:33:39',	'2022-07-12 12:24:21'),
(5,	'dropdown',	'Dropdown Item',	'2021-08-02 18:46:06',	'2022-07-12 12:24:47'),
(6,	'datatable',	'Data Table',	'2021-08-07 19:31:59',	'2022-07-12 12:25:08'),
(7,	'details',	'Details View',	'2022-07-06 17:31:43',	'2022-07-12 12:25:28'),
(8,	'search_product',	'Search',	'2022-07-07 07:55:03',	'2022-07-12 12:25:44');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbology` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `weight` decimal(10,4) DEFAULT NULL,
  `category` int(11) NOT NULL,
  `brand` int(11) DEFAULT NULL,
  `unit` int(11) NOT NULL,
  `p_unit` int(11) DEFAULT NULL,
  `s_unit` int(11) DEFAULT NULL,
  `is_auto_cost` enum('1','0') NOT NULL DEFAULT '1',
  `cost` decimal(10,4) DEFAULT NULL,
  `mrp` decimal(10,4) DEFAULT NULL,
  `markup` decimal(10,4) DEFAULT 0.0000,
  `price` decimal(10,4) NOT NULL,
  `auto_discount` decimal(10,4) DEFAULT NULL,
  `mfg_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `tax_method` enum('I','E') NOT NULL,
  `tax_rate` int(11) DEFAULT NULL,
  `quantity` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `alert` enum('0','1') NOT NULL DEFAULT '0',
  `alert_quantity` int(11) DEFAULT NULL,
  `pos_sale` tinyint(1) DEFAULT NULL,
  `custom_discount` tinyint(1) DEFAULT NULL,
  `pos_min_sale_qty` decimal(10,4) DEFAULT NULL,
  `pos_max_sale_qty` decimal(10,4) DEFAULT NULL,
  `pos_sale_note` tinyint(1) DEFAULT NULL,
  `pos_custom_discount` tinyint(1) DEFAULT NULL,
  `pos_custom_tax` tinyint(1) DEFAULT NULL,
  `pos_data_field_1` varchar(30) DEFAULT NULL COMMENT 'for custom data field in pos',
  `pos_data_field_2` varchar(30) DEFAULT NULL,
  `pos_data_field_3` varchar(30) DEFAULT NULL,
  `pos_data_field_4` varchar(30) DEFAULT NULL,
  `pos_data_field_5` varchar(30) DEFAULT NULL,
  `pos_data_field_6` varchar(30) DEFAULT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `product-product_type` (`type`),
  KEY `product-symbology` (`symbology`),
  KEY `product-brand` (`brand`),
  KEY `product-unit` (`unit`),
  KEY `product-unit_bulk1` (`p_unit`),
  KEY `product-unit_bulk2` (`s_unit`),
  KEY `product-tax_rate` (`tax_rate`),
  KEY `category` (`category`),
  CONSTRAINT `product-brand` FOREIGN KEY (`brand`) REFERENCES `brand` (`id`),
  CONSTRAINT `product-product_type` FOREIGN KEY (`type`) REFERENCES `product_type` (`id`),
  CONSTRAINT `product-tax_rate` FOREIGN KEY (`tax_rate`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `product_ibfk_4` FOREIGN KEY (`symbology`) REFERENCES `barcode_symbology` (`id`),
  CONSTRAINT `product_ibfk_5` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `product_ibfk_6` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `product_ibfk_7` FOREIGN KEY (`p_unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `product_ibfk_8` FOREIGN KEY (`s_unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `price_check` CHECK (`price` <= `mrp`),
  CONSTRAINT `pos_max_sale_qty_check` CHECK (`pos_max_sale_qty` >= `pos_min_sale_qty`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4;

INSERT INTO `product` (`id`, `type`, `code`, `symbology`, `name`, `slug`, `thumbnail`, `weight`, `category`, `brand`, `unit`, `p_unit`, `s_unit`, `is_auto_cost`, `cost`, `mrp`, `markup`, `price`, `auto_discount`, `mfg_date`, `exp_date`, `tax_method`, `tax_rate`, `quantity`, `alert`, `alert_quantity`, `pos_sale`, `custom_discount`, `pos_min_sale_qty`, `pos_max_sale_qty`, `pos_sale_note`, `pos_custom_discount`, `pos_custom_tax`, `pos_data_field_1`, `pos_data_field_2`, `pos_data_field_3`, `pos_data_field_4`, `pos_data_field_5`, `pos_data_field_6`, `added_at`, `updated_at`, `editable`, `deletable`, `deleted_at`) VALUES
(1,	1,	'37519985',	1,	'King Book',	'king-book',	'https://www.escoffier.edu/wp-content/uploads/reading-is-a-great-way-to-continue-your-growth-as-a-chef_1028_40137340_1_14130186_500.jpg',	NULL,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	35.0000,	0.0000,	30.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:30',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(2,	1,	'62305684',	1,	'Long Book',	'long-book',	'https://3ner1e34iilsjdn1qohanunu-wpengine.netdna-ssl.com/wp-content/uploads/2014/11/82175.jpg',	NULL,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	50.0000,	0.0000,	45.0000,	1.0000,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:54',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(3,	1,	'25171014',	1,	'Pen 0.7mm',	'pen-0-7mm',	'https://www.proimprint.com/image/cache/data/KEYCHAINS-OPENERS/Promotional-Keychains-Openers/Custom-Logo-Imprinted-Plastic-Keychains/Customized-Roslin-Stylus-Pens-500x500.jpg',	NULL,	1,	1,	1,	NULL,	NULL,	'1',	NULL,	NULL,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-28',	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:15:37',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(4,	1,	'80493457',	1,	'Stylish',	'stylish',	'https://5.imimg.com/data5/GK/JK/MY-45473441/stylish-pen-500x500.jpg',	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	NULL,	5.0000,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-06',	'E',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:17:04',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(5,	1,	'38644788',	1,	'Couple Photo Frame',	'couple-photo-frame',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7iyBDZf-tfvjCrGwONFuvg3Wj33FJ8xrsBg&usqp=CAU',	NULL,	1,	1,	1,	NULL,	NULL,	'1',	NULL,	300.0000,	0.0000,	200.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:18:37',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(6,	1,	'94426911',	1,	'Wall Clock',	'wall-clock',	'https://images-na.ssl-images-amazon.com/images/I/51VjOomhxoL._SY355_.jpg',	NULL,	1,	1,	1,	NULL,	NULL,	'0',	300.0000,	NULL,	0.0000,	570.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:19:09',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(10,	1,	'39741136',	1,	'Keyboard Mouse Combo',	'keyboard-mouse-combo',	'https://images-na.ssl-images-amazon.com/images/I/619gY3%2BheVL._SL1000_.jpg',	NULL,	1,	1,	1,	NULL,	NULL,	'1',	NULL,	4500.0000,	0.0000,	1000.0000,	250.0000,	NULL,	NULL,	'I',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:23:19',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(149,	1,	'56904366',	1,	'fhfgh',	'fghetrty',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:05',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(150,	1,	'65640426',	1,	'gdgserer',	'dfghfhdh',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:22',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(151,	1,	'78154768',	1,	'tyur',	'urutyutyuytu',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-24 02:14:50',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(152,	1,	'86112495',	1,	'ertert',	'rreyryryy',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-25 00:30:23',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(161,	1,	'63886634',	1,	'78768',	'6787688',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-11 16:55:30',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(165,	1,	'27144759',	1,	'dffsfsf',	'dffsfsf',	NULL,	NULL,	16,	NULL,	1,	NULL,	NULL,	'1',	5.0000,	NULL,	NULL,	5.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-12 17:31:44',	'2022-07-25 10:33:39',	NULL,	NULL,	NULL),
(173,	1,	'48386886',	1,	'AAA',	'aaa',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	NULL,	75.0000,	0.0000,	'2022-06-23',	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:06',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(174,	1,	'33267747',	1,	'etertet',	'etertet',	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	NULL,	50.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	'Serial No.',	'Serial No.',	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:29',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(176,	1,	'23556049',	1,	'Dell Monotor',	'dell-monotor',	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	400.0000,	NULL,	NULL,	400.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	10,	1,	NULL,	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-18 13:03:23',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(180,	1,	'54805482',	1,	'Name 1',	'name-1',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	10.0000,	500.0000,	NULL,	10.0000,	0.0000,	NULL,	NULL,	'I',	1,	0.0000,	'1',	20,	1,	NULL,	NULL,	NULL,	1,	1,	1,	'Serial No.',	'Color',	NULL,	NULL,	NULL,	'6',	'2022-04-26 16:14:34',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(186,	1,	'96213555',	2,	'have data field 1 - 2',	'have-data-field-1---2',	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	'1',	100.0000,	500.0000,	NULL,	150.0000,	10.0000,	'2022-05-30',	'2022-06-06',	'I',	NULL,	0.0000,	'1',	12,	1,	NULL,	NULL,	NULL,	1,	1,	1,	'IMEI No.',	'IMEI No.',	'IMEI No. 2 :',	'b',	'c',	'4454',	'2022-04-28 16:42:25',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(187,	1,	'24366313',	1,	'yuiyui',	'yuiyui',	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	10.0000,	NULL,	NULL,	15.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	1,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-06-27 20:42:52',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(188,	1,	'98141630',	1,	'tytytytyty',	'tytytytyty',	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	65.0000,	NULL,	50.0000,	97.5000,	5.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	5,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-05 17:37:03',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(189,	1,	'39857931',	1,	'jklkjl',	'jklkjl',	NULL,	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	6767.0000,	NULL,	50.0000,	10150.5000,	66.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	45,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-16 19:49:34',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(190,	1,	'60706432',	1,	'yuyuuyu',	'yuyuuyu',	NULL,	NULL,	1,	3,	1,	NULL,	NULL,	'1',	434.0000,	NULL,	NULL,	651.0000,	34.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-16 20:08:52',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(191,	1,	'11544316',	1,	'ghfghfghgfh',	'ghfghfghgfh',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	34.0000,	NULL,	50.0000,	51.0000,	34.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	4,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 15:55:22',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(196,	1,	'52495533',	1,	'jhkjkhjkjh',	'jhkjkhjkjh',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	54545.0000,	NULL,	50.0000,	81817.5000,	454545.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:23:47',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(197,	1,	'26769461',	1,	'gfhfghfgh',	'gfhfghfgh',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	4466.0000,	NULL,	50.0000,	6699.0000,	46466.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	545,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:28:06',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(198,	1,	'95381111',	1,	'sdasd',	'sdasd',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	34343.0000,	NULL,	50.0000,	51514.5000,	343434.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	343434,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:29:34',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(199,	1,	'27765677',	1,	'dfdfdsf',	'dfdfdsf',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	544.0000,	NULL,	50.0000,	816.0000,	45.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	3434,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:32:21',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(200,	1,	'36337226',	1,	'fdf',	'fdf',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	45.0000,	NULL,	50.0000,	67.5000,	45.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	54545,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:36:47',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(201,	1,	'86615677',	1,	'dfdfdf',	'dfdfdf',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	53454.0000,	NULL,	50.0000,	80181.0000,	4.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:38:02',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(202,	1,	'28200048',	1,	'sdsdsd',	'sdsdsd',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	3.0000,	NULL,	50.0000,	4.5000,	4234.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:39:23',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(203,	1,	'94141452',	1,	'dfsdfsdf',	'dfsdfsdf',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	43.0000,	NULL,	50.0000,	64.5000,	3.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:40:52',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(204,	1,	'58088666',	1,	'rtrt',	'rtrt',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	453.0000,	NULL,	50.0000,	679.5000,	43.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:41:46',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(205,	1,	'16779764',	1,	'jyuytu',	'jyuytu',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	3.0000,	NULL,	50.0000,	4.5000,	34.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:43:04',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(206,	1,	'77746751',	1,	'54545',	'54545',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	3.0000,	NULL,	50.0000,	4.5000,	3.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 17:51:18',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(207,	1,	'27398738',	1,	'uiiuy',	'uiiuy',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	56.0000,	NULL,	50.0000,	84.0000,	5.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-20 18:25:01',	'2022-07-25 10:11:42',	NULL,	NULL,	NULL),
(211,	1,	'32427445',	1,	'3434',	'3434',	NULL,	NULL,	2,	NULL,	1,	3,	NULL,	'1',	543.0000,	NULL,	NULL,	814.5000,	5.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-25 10:10:28',	'2022-07-25 10:15:27',	NULL,	NULL,	NULL),
(212,	1,	'78734177',	1,	'fghfghfgh',	'fghfghfgh',	NULL,	NULL,	21,	NULL,	1,	NULL,	NULL,	'1',	5.0000,	NULL,	NULL,	7.5000,	3.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	5,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	'Color',	't',	'e',	'w',	'q',	'2022-07-25 10:23:17',	'2022-07-25 10:46:00',	NULL,	NULL,	NULL),
(213,	1,	'78031178',	1,	'gfhfgh',	'gfhfgh',	NULL,	NULL,	3,	NULL,	1,	NULL,	NULL,	'1',	10.0000,	100.0000,	10.0000,	11.0000,	5.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-27 20:12:10',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `product_gallery`;
CREATE TABLE `product_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image` (`image`),
  KEY `product_id` (`product`),
  CONSTRAINT `product_gallery_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_gallery` (`id`, `product`, `image`, `added_at`, `updated_at`, `deleted_at`) VALUES
(2,	1,	'fgfgdgfg',	'2021-04-06 05:59:32',	'2021-04-06 05:59:50',	NULL);

DROP TABLE IF EXISTS `product_pos`;
CREATE TABLE `product_pos` (
  `id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `data_field_1` varchar(100) NOT NULL,
  `data_field_2` varchar(100) NOT NULL,
  `data_field_3` varchar(100) NOT NULL,
  `data_field_4` varchar(100) NOT NULL,
  `data_field_5` varchar(100) NOT NULL,
  `data_field_6` varchar(100) NOT NULL,
  KEY `product` (`product`),
  CONSTRAINT `product_pos_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `product_stock`;
CREATE TABLE `product_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `warehouse` int(11) NOT NULL,
  `quantity` decimal(10,4) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_warehouse` (`product`,`warehouse`),
  KEY `warehouse` (`warehouse`),
  CONSTRAINT `product_stock_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `product_stock_ibfk_2` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_stock` (`id`, `product`, `warehouse`, `quantity`, `added_at`, `updated_at`) VALUES
(30,	190,	20,	33.0000,	'2022-07-16 14:38:52',	NULL),
(31,	196,	28,	54355.0000,	'2022-07-20 11:53:47',	NULL),
(32,	197,	28,	454545.0000,	'2022-07-20 11:58:06',	NULL),
(33,	198,	28,	3434.0000,	'2022-07-20 11:59:34',	NULL),
(34,	199,	20,	5.0000,	'2022-07-20 12:02:21',	NULL),
(35,	200,	20,	5345.0000,	'2022-07-20 12:06:47',	NULL),
(36,	201,	20,	3434.0000,	'2022-07-20 12:08:02',	NULL),
(37,	202,	20,	332.0000,	'2022-07-20 12:09:23',	NULL),
(38,	203,	28,	434.0000,	'2022-07-20 12:10:52',	NULL),
(39,	204,	20,	4.0000,	'2022-07-20 12:11:46',	NULL),
(40,	205,	20,	343.0000,	'2022-07-20 12:13:04',	NULL),
(41,	206,	28,	54.0000,	'2022-07-20 12:21:18',	NULL),
(42,	207,	20,	64.0000,	'2022-07-20 12:55:01',	NULL),
(43,	212,	20,	-50.0000,	'2022-07-25 04:53:17',	NULL),
(44,	213,	20,	2.0000,	'2022-07-27 14:42:10',	NULL);

DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_type` (`id`, `code`, `name`, `description`, `deleted_at`) VALUES
(1,	'S',	'Standard Product',	'Standard Product hereeeeeee',	NULL),
(2,	'C',	'Combo Product',	'Combo Product here......',	NULL),
(3,	'D',	'Digital',	'Digital hereeeee',	NULL),
(4,	'SV',	'Service',	'Service hereeee',	NULL);

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `limit` int(11) NOT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `updatable_rights` tinyint(1) NOT NULL DEFAULT 1,
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COMMENT='This is user groups';

INSERT INTO `role` (`id`, `name`, `description`, `limit`, `editable`, `deletable`, `updatable_rights`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Administrator',	'All permissions allowed.',	1,	0,	0,	0,	'2021-04-21 00:19:28',	'2022-07-06 12:10:28',	NULL),
(2,	'Seller',	'Sales permissions.',	2,	NULL,	NULL,	1,	'2021-04-21 00:21:17',	'2022-07-14 23:13:37',	NULL),
(3,	'Purchaser',	'Purchase permissions.',	1,	NULL,	NULL,	1,	'2021-04-21 00:21:35',	'2022-07-14 23:13:37',	NULL);

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `readonly` tinyint(1) DEFAULT NULL COMMENT 'no changes can be made from ui',
  `comment` varchar(100) DEFAULT NULL,
  `allow` tinyint(1) DEFAULT 0,
  `disabled` tinyint(1) DEFAULT NULL,
  UNIQUE KEY `role_id_module_id_permission_id` (`role_id`,`module_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  CONSTRAINT `role_permission_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Rows with readonly flag are read only or manually added rows ';

INSERT INTO `role_permission` (`role_id`, `module_id`, `permission_id`, `readonly`, `comment`, `allow`, `disabled`) VALUES
(1,	1,	1,	1,	'PRODUCT - create',	1,	NULL),
(1,	1,	3,	1,	'PRODUCT - update',	1,	NULL),
(1,	1,	4,	1,	'PRODUCT - delete',	1,	NULL),
(1,	1,	6,	1,	'PRODUCT - datatable',	1,	NULL),
(1,	1,	7,	1,	'PRODUCT - details',	1,	NULL),
(1,	2,	1,	1,	'CATEGORY - create',	1,	NULL),
(1,	2,	3,	1,	'CATEGORY - update',	1,	NULL),
(1,	2,	4,	1,	'CATEGORY - delete',	1,	NULL),
(1,	2,	6,	1,	'CATEGORY - datatable',	1,	NULL),
(1,	3,	1,	1,	'BRAND - create',	1,	NULL),
(1,	3,	3,	1,	'BRAND - update',	1,	NULL),
(1,	3,	4,	1,	'BRAND - delete',	1,	NULL),
(1,	3,	6,	1,	'BRAND - datatable',	1,	NULL),
(1,	4,	1,	1,	'TAX RATE - create',	1,	NULL),
(1,	4,	3,	1,	'TAX RATE - update',	1,	NULL),
(1,	4,	4,	1,	'TAX RATE - delete',	1,	NULL),
(1,	4,	6,	1,	'TAX RATE - datatable',	1,	NULL),
(1,	5,	1,	1,	'UNIT - create',	1,	NULL),
(1,	5,	3,	1,	'UNIT - update',	1,	NULL),
(1,	5,	4,	1,	'UNIT - delete',	1,	NULL),
(1,	5,	6,	1,	'UNIT - datatable',	1,	NULL),
(1,	6,	1,	1,	'SUPPLIER - create',	1,	NULL),
(1,	6,	3,	1,	'SUPPLIER - update',	1,	NULL),
(1,	6,	4,	1,	'SUPPLIER - delete',	1,	NULL),
(1,	6,	6,	1,	'SUPPLIER - datatable',	1,	NULL),
(1,	7,	1,	1,	'CUSTOMER - create',	1,	NULL),
(1,	7,	3,	1,	'CUSTOMER - update',	1,	NULL),
(1,	7,	4,	1,	'CUSTOMER - delete',	1,	NULL),
(1,	7,	6,	1,	'CUSTOMER - datatable',	1,	NULL),
(1,	8,	1,	1,	'USER - create',	1,	NULL),
(1,	8,	3,	1,	'USER - update',	1,	NULL),
(1,	8,	4,	1,	'USER - delete',	1,	NULL),
(1,	8,	6,	1,	'USER - datatable',	1,	NULL),
(1,	9,	1,	1,	'WAREHOUSE - create',	1,	NULL),
(1,	9,	3,	1,	'WAREHOUSE - update',	1,	NULL),
(1,	9,	4,	1,	'WAREHOUSE - delete',	1,	NULL),
(1,	9,	5,	1,	'WAREHOUSE - dropdown',	1,	NULL),
(1,	9,	6,	1,	'WAREHOUSE - datatable',	1,	NULL),
(1,	10,	1,	1,	'ROLE - create',	1,	NULL),
(1,	10,	3,	1,	'ROLE - update',	1,	NULL),
(1,	10,	4,	1,	'ROLE - delete',	1,	NULL),
(1,	10,	6,	1,	'ROLE - datatable',	1,	NULL),
(1,	11,	1,	1,	'POS - create',	1,	NULL),
(1,	11,	2,	1,	'MANUAL (pos list product)',	1,	NULL),
(1,	12,	2,	1,	'MANUAL (list product types)',	1,	NULL),
(1,	13,	2,	1,	'MANUAL (list barcode symbs)',	1,	NULL),
(1,	14,	2,	1,	'MANUAL (print barcode or label)',	1,	NULL),
(1,	15,	1,	1,	'STOCK ADJ - create',	1,	NULL),
(1,	15,	3,	1,	'STOCK ADJ - edit',	1,	NULL),
(1,	15,	4,	1,	'STOCK ADJ - delete',	1,	NULL),
(1,	15,	6,	1,	'STOCK ADJ - datatable',	1,	NULL),
(1,	15,	7,	1,	'STOCK ADJ - details',	1,	NULL),
(1,	15,	8,	1,	'STOCK ADJ - autocomplete product',	1,	NULL),
(1,	16,	2,	1,	'MANUAL list customer groups (admin default)',	1,	NULL),
(1,	16,	5,	1,	'CUSTOMER GROUP - dropdown',	1,	NULL),
(1,	17,	2,	1,	'MANUAL genders (admin default)',	1,	NULL),
(2,	6,	1,	NULL,	NULL,	1,	NULL),
(2,	6,	3,	NULL,	NULL,	1,	NULL),
(2,	6,	4,	NULL,	NULL,	1,	NULL),
(2,	6,	6,	NULL,	NULL,	1,	NULL),
(3,	1,	1,	NULL,	NULL,	1,	NULL),
(3,	1,	3,	NULL,	NULL,	1,	NULL),
(3,	1,	4,	NULL,	NULL,	1,	NULL),
(3,	1,	6,	NULL,	NULL,	1,	NULL),
(3,	1,	7,	NULL,	NULL,	1,	NULL),
(3,	3,	3,	NULL,	NULL,	1,	NULL);

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `css_class` varchar(20) DEFAULT NULL,
  `css_color` varchar(20) DEFAULT NULL,
  `online_status` tinyint(1) DEFAULT NULL,
  `payment_status` tinyint(1) DEFAULT NULL,
  `order_status` tinyint(1) DEFAULT NULL,
  `role_status` tinyint(1) DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT NULL,
  `warehouse_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

INSERT INTO `status` (`id`, `name`, `css_class`, `css_color`, `online_status`, `payment_status`, `order_status`, `role_status`, `user_status`, `warehouse_status`) VALUES
(1,	'online',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	'offline',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	'active',	'bg-success',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL),
(4,	'inactive',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL),
(5,	'pending',	'bg-warning text-dark',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL),
(6,	'paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(7,	'unpaid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(8,	'ordered',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(9,	'packed',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(10,	'shipped',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(11,	'returned',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(12,	'partially paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(13,	'expired',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(14,	'away',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL),
(15,	'blocked',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL),
(16,	'open',	'bg-success',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1),
(17,	'closed',	'bg-warning text-dark',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1),
(18,	'permanently closed',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1),
(19,	'temperorily closed',	'bg-info text-dark',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1);

DROP TABLE IF EXISTS `stock_adjustment`;
CREATE TABLE `stock_adjustment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_no` (`reference_no`),
  KEY `warehouse_id` (`warehouse`),
  KEY `added_by` (`added_by`),
  CONSTRAINT `stock_adjustment_ibfk_2` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `stock_adjustment_ibfk_3` FOREIGN KEY (`added_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4;

INSERT INTO `stock_adjustment` (`id`, `warehouse`, `added_by`, `date`, `time`, `reference_no`, `note`, `added_at`, `updated_at`, `deleted_at`) VALUES
(104,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2021-10-30 18:52:14',	'2022-06-24 10:44:46',	NULL),
(105,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-04-11 11:25:30',	NULL,	NULL),
(106,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-04-14 11:30:06',	NULL,	NULL),
(107,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-04-14 11:30:29',	NULL,	NULL),
(108,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-04-18 07:33:23',	NULL,	NULL),
(109,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-04-26 10:44:34',	NULL,	NULL),
(110,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:05:16',	NULL,	NULL),
(111,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:15:35',	NULL,	NULL),
(112,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:18:13',	NULL,	NULL),
(113,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:18:17',	NULL,	NULL),
(114,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:18:53',	NULL,	NULL),
(115,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:18:58',	NULL,	NULL),
(116,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:20:28',	NULL,	NULL),
(117,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	'gh',	'2022-06-20 11:20:38',	NULL,	NULL),
(118,	20,	1,	'2022-06-24',	'00:00:00',	'54',	'gh',	'2022-06-20 11:20:55',	NULL,	NULL),
(119,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:21:54',	NULL,	NULL),
(120,	20,	1,	'2022-06-24',	'00:00:00',	'5754',	'4545',	'2022-06-20 11:22:16',	NULL,	NULL),
(121,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:26:05',	NULL,	NULL),
(122,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:26:07',	NULL,	NULL),
(123,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:28:10',	NULL,	NULL),
(124,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:33:02',	NULL,	NULL),
(125,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:33:40',	NULL,	NULL),
(126,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:35:06',	NULL,	NULL),
(127,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:36:39',	NULL,	NULL),
(128,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:41:22',	NULL,	NULL),
(129,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:41:31',	NULL,	NULL),
(130,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:41:38',	NULL,	NULL),
(131,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:41:42',	NULL,	NULL),
(132,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:42:54',	NULL,	NULL),
(133,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-20 11:45:16',	NULL,	NULL),
(134,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-21 11:16:50',	NULL,	NULL),
(135,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-21 11:33:46',	NULL,	NULL),
(136,	20,	1,	'2022-06-24',	'00:00:00',	'564',	'With held',	'2022-06-21 11:34:50',	NULL,	NULL),
(137,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-21 16:26:43',	NULL,	NULL),
(138,	20,	1,	'2022-06-24',	'00:00:00',	'zdsf',	'fe2',	'2022-06-22 14:40:49',	NULL,	NULL),
(139,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-23 05:40:05',	NULL,	NULL),
(140,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-23 05:41:02',	NULL,	NULL),
(141,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-23 06:48:41',	NULL,	NULL),
(142,	20,	1,	'2022-06-24',	'00:00:00',	'lll',	NULL,	'2022-06-23 06:49:13',	'2022-06-24 05:52:22',	NULL),
(143,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-23 06:50:24',	'2022-06-24 05:51:35',	NULL),
(144,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-23 06:53:37',	'2022-06-24 05:51:24',	NULL),
(163,	20,	1,	'2022-06-24',	'00:00:00',	'gh',	NULL,	'2022-06-23 11:44:11',	'2022-06-24 06:01:36',	NULL),
(165,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-06-24 05:54:01',	'2022-06-24 06:32:18',	NULL),
(166,	27,	1,	'2022-06-24',	'19:05:06',	NULL,	NULL,	'2022-06-24 06:25:49',	'2022-07-05 12:29:07',	NULL),
(167,	20,	1,	'2022-06-24',	'12:40:07',	'ref',	'not',	'2022-06-24 07:07:33',	'2022-06-26 16:26:09',	NULL),
(168,	20,	1,	'2022-06-10',	'12:00:50',	NULL,	NULL,	'2022-06-24 07:08:00',	'2022-06-27 07:44:10',	NULL),
(169,	20,	1,	'2022-06-24',	'16:06:17',	'ref 231',	'Not 79',	'2022-06-24 10:36:39',	'2022-06-28 07:41:50',	NULL),
(170,	27,	1,	'2022-06-26',	'19:58:12',	NULL,	NULL,	'2022-06-26 14:28:15',	'2022-07-07 07:53:53',	NULL),
(171,	20,	1,	'2022-06-28',	'13:12:18',	'ee',	NULL,	'2022-06-28 07:42:21',	'2022-07-07 13:16:27',	NULL),
(172,	20,	1,	'2022-06-09',	'17:53:51',	NULL,	NULL,	'2022-06-28 12:23:54',	'2022-07-06 17:49:51',	NULL),
(173,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-05 12:07:03',	'2022-07-07 08:05:53',	NULL),
(174,	28,	1,	'2022-07-07',	'13:35:33',	NULL,	NULL,	'2022-07-07 08:05:42',	'2022-07-07 08:06:55',	NULL),
(175,	27,	1,	'2022-07-07',	'18:46:37',	NULL,	NULL,	'2022-07-07 13:16:41',	NULL,	NULL),
(176,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-16 14:38:52',	NULL,	NULL),
(181,	28,	1,	'2022-07-20',	'17:22:46',	NULL,	NULL,	'2022-07-20 11:52:52',	NULL,	NULL),
(182,	28,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 11:53:47',	NULL,	NULL),
(183,	28,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 11:58:06',	NULL,	NULL),
(184,	28,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 11:59:34',	NULL,	NULL),
(185,	20,	1,	'2022-06-24',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:02:21',	NULL,	NULL),
(186,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:06:47',	NULL,	NULL),
(187,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:08:02',	NULL,	NULL),
(188,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:09:23',	NULL,	NULL),
(189,	28,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:10:52',	NULL,	NULL),
(190,	20,	1,	'0000-00-00',	'00:00:00',	NULL,	NULL,	'2022-07-20 12:11:46',	NULL,	NULL),
(191,	20,	1,	'2022-07-20',	'17:43:00',	NULL,	NULL,	'2022-07-20 12:13:04',	'2022-07-20 12:14:11',	NULL),
(192,	20,	1,	'2022-07-20',	'02:50:55',	NULL,	NULL,	'2022-07-20 12:20:56',	NULL,	NULL),
(193,	28,	1,	'2022-07-20',	'17:51:18',	NULL,	NULL,	'2022-07-20 12:21:18',	NULL,	NULL),
(194,	20,	1,	'2022-07-20',	'18:24:03',	'gg',	'trtr',	'2022-07-20 12:54:15',	NULL,	NULL),
(195,	20,	1,	'2022-07-20',	'18:25:01',	NULL,	NULL,	'2022-07-20 12:55:01',	NULL,	NULL),
(196,	20,	1,	'2022-07-25',	'10:23:17',	NULL,	NULL,	'2022-07-25 04:53:17',	NULL,	NULL),
(197,	20,	1,	'2022-07-27',	'19:13:27',	NULL,	NULL,	'2022-07-27 13:43:29',	'2022-07-27 13:43:45',	NULL),
(198,	20,	1,	'2022-07-27',	'20:12:10',	NULL,	NULL,	'2022-07-27 14:42:10',	NULL,	NULL);

DROP TABLE IF EXISTS `stock_adjustment_product`;
CREATE TABLE `stock_adjustment_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_adjustment` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `quantity` decimal(12,4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stock_adjustment_product` (`stock_adjustment`,`product`),
  KEY `stock_adjustment_id` (`stock_adjustment`),
  KEY `product_id` (`product`),
  CONSTRAINT `stock_adjustment_product_ibfk_1` FOREIGN KEY (`stock_adjustment`) REFERENCES `stock_adjustment` (`id`),
  CONSTRAINT `stock_adjustment_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=utf8mb4;

INSERT INTO `stock_adjustment_product` (`id`, `stock_adjustment`, `product`, `note`, `quantity`) VALUES
(153,	134,	6,	NULL,	2.0000),
(154,	134,	180,	NULL,	-5.0000),
(155,	134,	10,	NULL,	2.0000),
(156,	134,	186,	NULL,	1.0000),
(157,	134,	5,	NULL,	1.0000),
(158,	135,	6,	NULL,	-2.0000),
(159,	136,	6,	NULL,	1.0000),
(160,	136,	10,	NULL,	-1.0000),
(161,	136,	186,	NULL,	1.0000),
(162,	137,	186,	NULL,	1.0000),
(163,	137,	5,	NULL,	1.0000),
(164,	138,	180,	NULL,	1.0000),
(259,	163,	6,	NULL,	1.0000),
(267,	163,	151,	NULL,	1.0000),
(268,	144,	180,	NULL,	1.0000),
(269,	144,	10,	NULL,	1.0000),
(270,	144,	186,	NULL,	1.0000),
(271,	144,	5,	NULL,	1.0000),
(273,	143,	180,	NULL,	1.0000),
(274,	143,	10,	NULL,	1.0000),
(275,	143,	186,	NULL,	1.0000),
(276,	143,	5,	NULL,	1.0000),
(277,	143,	173,	NULL,	1.0000),
(278,	142,	173,	NULL,	1.0000),
(279,	165,	180,	NULL,	2.0000),
(281,	165,	186,	NULL,	1.0000),
(283,	165,	173,	NULL,	3.0000),
(284,	166,	165,	NULL,	1.0000),
(285,	167,	180,	NULL,	1.0000),
(287,	167,	186,	NULL,	1.0000),
(288,	167,	5,	NULL,	1.0000),
(289,	167,	173,	NULL,	1.0000),
(291,	168,	5,	NULL,	1.0000),
(293,	169,	186,	NULL,	8.0000),
(294,	169,	5,	NULL,	5.0000),
(295,	169,	173,	NULL,	4.0000),
(296,	169,	6,	NULL,	3.0000),
(297,	170,	186,	NULL,	-1.0000),
(298,	170,	5,	NULL,	4.0000),
(299,	170,	173,	NULL,	2.0000),
(301,	171,	5,	'fdfdf',	5.0000),
(302,	172,	5,	NULL,	1.0000),
(303,	172,	180,	NULL,	4.0000),
(304,	172,	186,	NULL,	2.0000),
(305,	173,	188,	NULL,	555.0000),
(307,	173,	173,	NULL,	1.0000),
(309,	174,	10,	NULL,	1.0000),
(310,	175,	10,	NULL,	1.0000),
(311,	176,	190,	NULL,	33.0000),
(312,	181,	5,	NULL,	1.0000),
(313,	182,	196,	NULL,	54355.0000),
(314,	183,	197,	NULL,	454545.0000),
(315,	184,	198,	NULL,	3434.0000),
(316,	185,	199,	NULL,	5.0000),
(317,	186,	200,	NULL,	5345.0000),
(318,	187,	201,	NULL,	3434.0000),
(319,	188,	202,	NULL,	332.0000),
(320,	189,	203,	NULL,	434.0000),
(321,	190,	204,	NULL,	4.0000),
(322,	191,	205,	NULL,	343.0000),
(323,	192,	173,	NULL,	1.0000),
(324,	193,	206,	NULL,	54.0000),
(325,	194,	180,	NULL,	1.0000),
(326,	195,	207,	NULL,	64.0000),
(327,	196,	212,	NULL,	-50.0000),
(328,	197,	5,	'c',	1.0000),
(329,	197,	161,	'7',	1.0000),
(330,	197,	6,	'w',	-2.0000),
(331,	198,	213,	NULL,	2.0000);

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `place` varchar(150) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pin_code` int(11) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `gst_no` varchar(150) DEFAULT NULL,
  `tax_no` varchar(150) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL COMMENT 'set 0 for protect edit, otherwise use NULL',
  `deletable` tinyint(1) DEFAULT NULL COMMENT 'set 0 for protect delete, otherwise use NULL',
  `status` enum('ACTIVE','INACTIVE','PENDING') NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4;

INSERT INTO `supplier` (`id`, `code`, `name`, `place`, `address`, `pin_code`, `city`, `phone`, `email`, `gst_no`, `tax_no`, `description`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(83,	'SUPP0083',	'fgdfg',	'fdgdg',	NULL,	NULL,	NULL,	'45546',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 12:25:23',	'2022-07-01 14:14:35',	NULL),
(86,	'SUPP0086',	'ytyty',	'rtty',	NULL,	NULL,	NULL,	'6545445',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:25:10',	'2022-07-01 14:14:35',	NULL),
(87,	'SUPP0087',	'rt5rt56546',	'565656544',	NULL,	NULL,	NULL,	'65654656',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:25:18',	'2022-07-01 14:14:35',	NULL),
(88,	'SUPP0088',	'tryt',	'rwrr5',	NULL,	NULL,	NULL,	'53535355',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:30:51',	'2022-07-01 14:14:35',	NULL),
(89,	'SUPP0089',	'eeeeeeeeee',	'rrrrrrrrrrr',	NULL,	NULL,	NULL,	'6664564564',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:31:29',	'2022-07-01 14:14:35',	NULL),
(91,	'SUPP0091',	'ryrtyrty',	'tyrytry',	NULL,	NULL,	NULL,	'564335466',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:00',	'2022-07-09 13:44:50',	'2022-07-09 13:44:50'),
(92,	'SUPP0092',	'utyu6',	'7576',	NULL,	NULL,	NULL,	'4368455447',	NULL,	NULL,	NULL,	'uiouo9',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:12',	'2022-07-01 14:19:54',	'2022-07-01 14:19:54'),
(93,	'SUPP0093',	'fggfg',	'gfdsser',	NULL,	NULL,	NULL,	'0000000000000',	NULL,	NULL,	NULL,	'o88',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:25',	'2022-07-01 14:19:30',	'2022-07-01 14:19:30'),
(94,	'SUPP0094',	'tyutyu',	'yuytuytu',	NULL,	NULL,	NULL,	'565655757',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:35:16',	'2022-07-01 14:18:00',	'2022-07-01 14:18:00'),
(95,	'SUPP0095',	'uytutyu',	'tutyutyutu',	NULL,	NULL,	NULL,	'123456',	NULL,	'\'\'\'',	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:35:31',	'2022-07-01 14:16:33',	'2022-07-01 14:16:33'),
(100,	'SUPP0100',	'`6r7yrtyty',	'ttyty',	NULL,	NULL,	NULL,	'56464656',	NULL,	NULL,	NULL,	'jtt',	NULL,	NULL,	'ACTIVE',	'2022-06-30 04:08:35',	'2022-07-01 14:15:48',	'2022-07-01 14:15:48'),
(102,	'SUPP0102',	'ghfhgfh g',	'tteerr',	'aaa',	123,	'tgft',	'77575547',	'ff@ds.fg',	'eee',	'jjj',	'dddydo',	0,	0,	'ACTIVE',	'2022-06-30 05:45:45',	'2022-07-01 14:14:35',	NULL),
(103,	'SUPP0103',	'aaa',	'bbb',	NULL,	NULL,	NULL,	'111111',	NULL,	NULL,	NULL,	'dfdt',	NULL,	NULL,	'ACTIVE',	'2022-06-30 05:55:00',	'2022-07-01 14:14:59',	'2022-07-01 14:14:59'),
(104,	'SUPP0104',	'aaa',	'bbb',	NULL,	NULL,	NULL,	'1111111',	NULL,	NULL,	NULL,	'aaaa',	NULL,	NULL,	'ACTIVE',	'2022-06-30 06:01:54',	'2022-07-06 16:56:31',	'2022-07-06 16:56:31');

DROP TABLE IF EXISTS `tax_group`;
CREATE TABLE `tax_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(15) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tax_group` (`id`, `name`, `code`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Tax Group 1',	'TG1',	'2021-04-06 10:25:57',	'2021-04-06 10:26:59',	NULL);

DROP TABLE IF EXISTS `tax_group_rate`;
CREATE TABLE `tax_group_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_group` int(11) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tax_group` (`tax_group`),
  KEY `tax_rate` (`tax_rate`),
  CONSTRAINT `tax_group_rate_ibfk_1` FOREIGN KEY (`tax_group`) REFERENCES `tax_group` (`id`),
  CONSTRAINT `tax_group_rate_ibfk_2` FOREIGN KEY (`tax_rate`) REFERENCES `tax_rate` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tax_group_rate` (`id`, `tax_group`, `tax_rate`) VALUES
(1,	1,	1),
(2,	1,	2),
(3,	1,	3);

DROP TABLE IF EXISTS `tax_rate`;
CREATE TABLE `tax_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rate` decimal(12,4) NOT NULL,
  `type` enum('P','F') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;

INSERT INTO `tax_rate` (`id`, `code`, `name`, `rate`, `type`, `description`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'GST10',	'GST',	10.0000,	'P',	NULL,	NULL,	NULL,	'2021-03-02 14:12:44',	'2022-07-12 07:53:30',	NULL),
(2,	'IGST2',	'IGST',	2.1300,	'F',	NULL,	NULL,	NULL,	'2021-03-02 14:12:44',	'2022-07-12 09:38:57',	NULL),
(3,	'VAT',	'VAT',	10.5000,	'P',	NULL,	NULL,	NULL,	'2021-03-02 14:12:44',	'2022-07-12 09:38:49',	NULL),
(5,	'gfg',	'hjhj',	5646.0000,	'P',	NULL,	NULL,	NULL,	'2022-07-12 08:42:48',	'2022-07-14 14:01:24',	'2022-07-14 14:01:24'),
(29,	'ds2',	'fff',	2.0000,	'P',	NULL,	NULL,	NULL,	'2022-07-24 07:21:01',	NULL,	NULL);

DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base` int(11) DEFAULT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `step` int(10) DEFAULT NULL,
  `operator` varchar(2) DEFAULT NULL,
  `allow_decimal` tinyint(4) DEFAULT NULL COMMENT 'use NULL for allow',
  `description` text DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `base_step_operator` (`base`,`step`,`operator`),
  KEY `base` (`base`),
  CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`base`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4;

INSERT INTO `unit` (`id`, `base`, `code`, `name`, `step`, `operator`, `allow_decimal`, `description`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'PC',	'Piece',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:13:31',	'2022-07-22 17:32:14',	NULL),
(2,	1,	'5PC',	'5 Piece',	5,	'*',	1,	NULL,	NULL,	NULL,	'2022-07-20 14:14:10',	'2022-07-22 17:32:14',	NULL),
(3,	1,	'10 PC',	'10 Piece',	10,	'*',	1,	NULL,	NULL,	NULL,	'2022-07-20 14:15:25',	'2022-07-22 17:32:14',	NULL),
(5,	NULL,	'GM',	'Gram',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:21:17',	'2022-07-22 17:32:14',	NULL),
(6,	NULL,	'KG',	'Kilo Gram',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:21:49',	'2022-07-22 17:32:14',	NULL),
(7,	6,	'1/2 KG /',	'Half KG /',	2,	'/',	1,	NULL,	NULL,	NULL,	'2022-07-20 15:13:35',	'2022-07-22 17:32:14',	NULL),
(8,	5,	'1/2 KG *',	'Half KG *',	500,	'*',	0,	NULL,	NULL,	NULL,	'2022-07-20 15:18:12',	'2022-07-23 15:56:20',	NULL),
(9,	NULL,	'MTR',	'Meter',	NULL,	NULL,	0,	NULL,	NULL,	NULL,	'2022-07-20 15:23:18',	'2022-07-23 15:59:45',	NULL),
(84,	1,	'hghgh',	'ghgh',	54,	'*',	1,	NULL,	NULL,	NULL,	'2022-07-25 04:35:57',	NULL,	NULL),
(86,	1,	'uku',	'jkk,jik',	2,	'*',	1,	'6yuyuyu',	NULL,	NULL,	'2022-07-25 05:18:16',	NULL,	NULL),
(87,	6,	'tytyt',	'nvbn',	3,	'*',	1,	NULL,	NULL,	NULL,	'2022-07-25 08:46:03',	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `role` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `last_name` varchar(70) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(320) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `pin_code` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `deletable` tinyint(1) DEFAULT NULL COMMENT 'keep NULL for allow delete',
  `editable` tinyint(1) DEFAULT NULL COMMENT 'keep NULL for allow edit',
  `client_ip` varchar(22) DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `role_id` (`role`),
  KEY `gender` (`gender`),
  KEY `status` (`status`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`),
  CONSTRAINT `user_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `gender` (`id`),
  CONSTRAINT `user_ibfk_3` FOREIGN KEY (`status`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id`, `code`, `role`, `username`, `password`, `first_name`, `last_name`, `company_name`, `date_of_birth`, `email`, `phone`, `avatar`, `gender`, `country`, `city`, `place`, `pin_code`, `address`, `description`, `status`, `deletable`, `editable`, `client_ip`, `login_at`, `logout_at`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'C1',	1,	'admin',	'$2y$10$6XeS4Sx0lGQzUWsqoSqaDOsaoM2wSVQAmDQg4viwBD4b5WAFw4SBu',	'Samnad',	'S',	'Cna',	'1992-10-30',	'admin@example.com',	'+91-0000000012',	NULL,	1,	'India',	'TVM',	'Trivandrum',	'695505',	'CyberLikes Pvt. Ltd.',	'something',	3,	0,	0,	'::1',	'2022-07-29 09:28:14',	'2022-07-18 04:37:51',	'2021-04-20 19:22:52',	'2022-07-29 09:28:14',	NULL),
(30,	'C2',	1,	'neo',	'$2y$10$KcBcIiTPhlaPmKDiuQmz/OzryKE4ZPgWf/ddgyCvmkXSHevNGeqL6',	'Neo',	'Andrew',	'And & Co.',	'2022-07-06',	'and@eff.c',	'5641511',	NULL,	1,	'Indo',	'Jarka',	'Imania',	'6950505',	'Feans Palace\r\nNew York',	'Something special',	15,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:20:23',	'2022-07-12 12:18:23',	NULL),
(31,	'C3',	1,	'markz',	'$2y$10$MwP6iXVdi0VrykbSVOq0EeL7L5x2YOnyrOUZZMIsPPLUjRgO2jLv.',	'Mark',	'Zuck',	'Meta',	'2022-07-20',	'mark@fb.com',	'61515141466',	NULL,	3,	'USA',	'Los Angels',	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:26:49',	'2022-07-12 12:18:17',	NULL),
(32,	'C4',	3,	'errerer',	'$2y$10$w/w8b2bLPzlFFw9mb3.abuYyyRhoQfGh24YPRwYhdWVNX5lbQV5Ja',	'ytyty',	'tytyty',	NULL,	'2022-07-14',	'gfgfg@f.ghgh',	'4454545445',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-03 10:38:07',	'2022-07-04 13:43:00',	'2022-07-04 13:43:00'),
(33,	'USER0033',	1,	'sfdfdsf',	'$2y$10$m3SCyOOEBf9x7zHoJD5nkuajcLI0MqPypDIsXo0zVE6pKwZ9ebP3u',	'dfdfsdf',	NULL,	NULL,	'2022-07-26',	'safdf@fdsfgdfg.ghgfh',	'7475454545',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 12:57:40',	'2022-07-06 16:37:47',	'2022-07-06 16:37:47'),
(34,	'USER0034',	1,	'sdfsdfsdf',	'$2y$10$X5g0UY6y6ciaAxYoHj//CeuwoWdwZ5S2v8qgVUAOyB.dirVZI1uyC',	'sdfdf',	'dfdfdsf',	NULL,	'2022-07-05',	'trt@ghjhg.fghfh',	'444544545',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 13:09:49',	'2022-07-06 16:37:07',	'2022-07-06 16:37:07'),
(35,	'USER0035',	3,	'hjhgjhg',	'$2y$10$vUGaJ4qQGg7yHt1hbP9eZOIFzL5SHX.ynu.w.EUwiiZIlUFJMbSoi',	'gikghjg',	'jghjghjhgj',	NULL,	'2022-07-05',	'fdf@g.ghgh',	'7574544454',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-06 16:38:36',	NULL,	NULL),
(36,	'USER0036',	3,	'dfdf',	'$2y$10$728Kvxh9olwHyXoUQ4Lq.e7aALAXdOO/s4zy3SNwi3464CYTWYfFS',	'dfdf',	'dfdfd',	NULL,	'2022-07-05',	'dfd@fsg.gdfgg',	'546464645645',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'::1',	'2022-07-07 07:50:50',	NULL,	'2022-07-06 16:45:10',	'2022-07-07 07:50:50',	'2022-07-06 16:45:25'),
(37,	'USER0037',	3,	'dfdfdf',	'$2y$10$.eYvj6.BMLYuGUDvlwSLnO4ZzR8OO8.SpB7Z/mR45zZUWIo/GJbMG',	'yuytuytu',	'ytuytu',	NULL,	'2022-07-12',	'ds@rtg.jghjg',	'5646456456',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'::1',	'2022-07-09 13:27:36',	NULL,	'2022-07-07 13:22:05',	'2022-07-09 13:55:29',	'2022-07-09 13:55:29');

DROP TABLE IF EXISTS `variant`;
CREATE TABLE `variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `variants`;
CREATE TABLE `variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variant` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `variant` (`variant`),
  CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`variant`) REFERENCES `variant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `place` varchar(100) NOT NULL,
  `date_of_open` date NOT NULL,
  `country` varchar(30) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pin_code` varchar(10) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `latitude` decimal(8,6) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 17 COMMENT '17 for closed',
  `status_reason` varchar(100) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name_place` (`name`,`place`),
  KEY `status` (`status`),
  CONSTRAINT `warehouse_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

INSERT INTO `warehouse` (`id`, `code`, `name`, `place`, `date_of_open`, `country`, `city`, `pin_code`, `phone`, `email`, `address`, `longitude`, `latitude`, `description`, `status`, `status_reason`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(20,	'WARE0020',	'CyberKids',	'dsds',	'2020-02-12',	'India',	'TVM',	'695505',	'+91-9745451448',	'tewest@gmail.com',	'TVM',	NULL,	NULL,	'Desc',	16,	'Flood',	NULL,	NULL,	'2021-04-14 19:54:53',	'2022-07-27 14:52:14',	NULL),
(27,	'WARE0027',	'Test',	'KMD',	'2022-07-01',	'Innnn',	'Ciiiii',	NULL,	'9745451448',	'sdsds@g.ghh',	'Addddddd',	NULL,	NULL,	'Desssssssssss',	19,	'Some',	NULL,	NULL,	'2022-07-05 12:01:17',	'2022-07-05 12:49:13',	NULL),
(28,	'WARE0028',	'cvccvcx',	'ggfdgfgfg',	'2022-07-01',	NULL,	NULL,	NULL,	'646665465',	'gfgg@f.ghgh',	NULL,	NULL,	NULL,	'opopj',	19,	'fgfgfg',	NULL,	NULL,	'2022-07-05 12:31:47',	'2022-07-09 14:04:12',	'2022-07-09 14:04:12'),
(30,	'WARE0030',	'ouioiuo',	'uiouio',	'2022-07-02',	NULL,	NULL,	NULL,	'5565656',	'ff@g.yty',	NULL,	NULL,	NULL,	NULL,	18,	'iuoiuoi',	NULL,	NULL,	'2022-07-05 12:35:29',	'2022-07-06 17:24:59',	'2022-07-06 17:24:59'),
(31,	'WARE0031',	'jhjhgjgjhg',	'jhgjhgjhgj',	'2022-07-01',	NULL,	NULL,	NULL,	'56565656',	'fgf@dy.hjgj',	NULL,	NULL,	NULL,	NULL,	16,	'hjhj',	NULL,	NULL,	'2022-07-05 12:36:57',	NULL,	NULL),
(32,	'WARE0032',	'uiuiui',	'uiuiuiuiu',	'2022-07-06',	NULL,	NULL,	NULL,	'4545454',	'ui@gf.ghgh',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-07-06 17:24:34',	NULL,	NULL);

-- 2022-07-29 16:10:04
