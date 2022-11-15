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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `brand` (`id`, `code`, `name`, `image`, `description`, `deletable`, `editable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'LX',	'Lexi',	NULL,	'Tesssssssssst.......',	0,	0,	'2021-01-24 06:01:28',	'2022-07-07 17:06:42',	NULL),
(3,	'CM',	'Camlin',	NULL,	'jt',	NULL,	NULL,	'2021-01-24 06:01:54',	'2022-07-07 17:00:15',	NULL),
(129,	'ytyty',	'ytyt',	NULL,	'tyty',	NULL,	NULL,	'2022-09-10 12:03:38',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(31,	NULL,	NULL,	NULL,	'Empty',	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-18 15:52:27',	NULL,	NULL),
(73,	NULL,	'cccv',	NULL,	'Baby',	'',	'cvcv',	NULL,	NULL,	NULL,	'2022-08-18 13:25:17',	NULL,	NULL),
(78,	26,	'hjhj',	NULL,	'jhhjhjhj',	'hjhj',	'jhj',	NULL,	NULL,	NULL,	'2022-08-31 18:52:16',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `customer` (`id`, `code`, `group`, `name`, `place`, `email`, `phone`, `address`, `pin_code`, `city`, `description`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'CUST0041',	1,	'Walk-in Customer',	'yuytuyuyt',	NULL,	NULL,	NULL,	NULL,	NULL,	'oipi',	NULL,	NULL,	'ACTIVE',	'2022-06-30 16:11:34',	'2022-08-09 11:57:45',	'2022-07-09 13:54:01'),
(42,	'CUST0042',	3,	'yuyuyu',	'yuyuyu',	NULL,	NULL,	'898',	NULL,	NULL,	'88890',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:26:31',	'2022-07-06 17:05:31',	'2022-07-06 17:05:31'),
(44,	'CUST0044',	2,	'aaa',	'tytyt',	'dfdf@fg.ghgh',	'565656',	'jhkuhoi',	'65656',	'6565',	'uiiouioiuo',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:38:41',	'2022-07-06 17:04:48',	'2022-07-06 17:04:48'),
(45,	'CUST0045',	2,	'tyutu6767',	'6767',	NULL,	NULL,	'jkjk',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:51:58',	'2022-07-01 14:26:53',	'2022-07-01 14:26:53'),
(48,	'CUST0048',	4,	'Cussssss 1',	'aaa',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	'ACTIVE',	'2022-07-01 04:52:16',	'2022-08-09 11:57:54',	NULL),
(50,	'CUST0050',	2,	'rtdtg',	'ggfg',	NULL,	NULL,	NULL,	NULL,	NULL,	'klklkluy',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:52:27',	'2022-07-06 17:12:57',	NULL),
(51,	'CUST0051',	1,	'kjjhkjk',	'uiuii',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 05:38:54',	'2022-07-09 13:53:54',	'2022-07-09 13:53:54'),
(52,	'CUST0052',	1,	'tyutyu',	'yutyutyu',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'ACTIVE',	'2022-07-01 06:50:43',	'2022-07-01 14:26:40',	NULL),
(53,	'CUST0053',	2,	'jmhjhgj',	'hjhgjghjhgj',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-06 17:13:05',	NULL,	NULL),
(54,	'CUST0054',	1,	'fggfggf',	'dgdfg',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-08-01 15:32:04',	NULL,	NULL),
(55,	'CUST0055',	1,	'fgfg',	'trtr',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-08-01 15:33:52',	NULL,	NULL),
(56,	'CUST0056',	1,	'fdgdfg',	'gfgg',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-08-09 17:38:10',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `label_size` (`id`, `code`, `name`, `p_width`, `p_height`, `labels`, `l_width`, `l_height`, `rows`, `columns`, `row_gutter`, `column_gutter`, `margin_t`, `margin_r`, `margin_b`, `margin_l`, `deleted_at`) VALUES
(1,	'A456',	'A4 56 Label Per Page',	210.00,	297.00,	56.00,	48.00,	20.00,	14.00,	4.00,	1.00,	2.00,	2.00,	6.00,	2.00,	6.00,	NULL),
(2,	'A484',	'A4 84 Label Per Page',	210.00,	297.00,	84.00,	46.00,	11.00,	21.00,	4.00,	1.50,	5.00,	18.00,	5.50,	18.00,	5.50,	NULL);

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `module` (`id`, `name`, `description`, `added_at`, `updated_at`) VALUES
(1,	'product',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(2,	'category',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(3,	'brand',	'This module is for product brands, here you can set permission for add, edit, update and delete the brands.',	'2022-07-06 11:59:05',	NULL),
(4,	'tax',	'This module can add create unique tax name based on tax rate and calculation type.',	'2022-07-06 11:59:05',	'2022-07-12 16:41:18'),
(5,	'unit',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(6,	'supplier',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(7,	'customer',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(8,	'user',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(9,	'warehouse',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(10,	'role',	'Role is to restrict or allow actions based on user level.',	'2022-07-06 11:59:05',	'2022-07-12 13:31:17'),
(11,	'pos',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(12,	'type',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(13,	'symbology',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(14,	'label',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(15,	'stock_adjustment',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(16,	'customer_group',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(17,	'common',	NULL,	'2022-07-06 11:59:05',	'2022-08-24 05:43:27'),
(18,	'purchase',	NULL,	'2022-08-24 05:42:37',	'2022-08-24 05:43:27'),
(19,	'purchase_return',	NULL,	'2022-10-03 05:52:05',	NULL);

DROP TABLE IF EXISTS `module_permission`;
CREATE TABLE `module_permission` (
  `module` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `checked` tinyint(1) DEFAULT NULL COMMENT 'default checked or not',
  `read_only` tinyint(1) DEFAULT NULL COMMENT 'ui read only',
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
(11,	6,	1,	NULL,	'POS pos sale list'),
(15,	1,	1,	NULL,	'STOCK ADJ.'),
(15,	3,	NULL,	NULL,	'STOCK ADJ.'),
(15,	4,	NULL,	NULL,	'STOCK ADJ.'),
(15,	6,	NULL,	NULL,	'STOCK ADJ.'),
(18,	1,	NULL,	NULL,	'PURCHASE'),
(18,	3,	NULL,	NULL,	'PURCHASE'),
(18,	4,	NULL,	NULL,	'PURCHASE'),
(18,	6,	NULL,	NULL,	'PURCHASE'),
(18,	7,	NULL,	NULL,	'PURCHASE'),
(18,	9,	NULL,	NULL,	'PURCHASE'),
(18,	10,	NULL,	NULL,	'PURCHASE'),
(18,	11,	NULL,	NULL,	'PURCHASE'),
(19,	1,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	3,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	4,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	6,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	7,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	9,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	10,	NULL,	NULL,	'PURCHASE RETURN'),
(19,	11,	NULL,	NULL,	'PURCHASE RETURN');

DROP TABLE IF EXISTS `payment_mode`;
CREATE TABLE `payment_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `payment_mode` (`id`, `name`, `description`) VALUES
(1,	'Cash',	NULL),
(2,	'Debit Card',	NULL),
(3,	'Credit Card',	NULL),
(4,	'UPI',	NULL),
(5,	'Gift Card',	NULL),
(6,	'Check',	NULL);

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `permission` (`id`, `name`, `usage`, `added_at`, `updated_at`) VALUES
(1,	'create',	'Create',	'2021-05-07 16:33:13',	'2022-07-12 12:23:58'),
(2,	'read',	'Read',	'2021-05-07 16:33:28',	'2022-07-12 12:24:26'),
(3,	'update',	'Update',	'2021-05-07 16:33:34',	'2022-07-12 12:24:14'),
(4,	'delete',	'Delete',	'2021-05-07 16:33:39',	'2022-07-12 12:24:21'),
(5,	'dropdown',	'Dropdown Item',	'2021-08-02 18:46:06',	'2022-07-12 12:24:47'),
(6,	'datatable',	'Data Table',	'2021-08-07 19:31:59',	'2022-07-12 12:25:08'),
(7,	'details',	'Details View',	'2022-07-06 17:31:43',	'2022-07-12 12:25:28'),
(8,	'search_product',	'Search',	'2022-07-07 07:55:03',	'2022-07-12 12:25:44'),
(9,	'payment',	'Add Payment',	'2022-09-10 07:19:13',	'2022-09-23 14:34:00'),
(10,	'payment_details',	'Show Payments',	'2022-09-16 18:44:04',	NULL),
(11,	'update_payment',	'Update Payment',	'2022-09-23 14:32:03',	NULL);

DROP TABLE IF EXISTS `pos_sale`;
CREATE TABLE `pos_sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(11) NOT NULL,
  `return_id` int(11) DEFAULT NULL,
  `warehouse` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `cart_discount` decimal(15,4) DEFAULT NULL,
  `shipping_charge` decimal(15,4) DEFAULT NULL,
  `packing_charge` decimal(15,4) DEFAULT NULL,
  `round_off` decimal(6,4) DEFAULT NULL,
  `payment_note` varchar(255) DEFAULT NULL,
  `sale_note` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `customer` (`customer`),
  KEY `warehouse` (`warehouse`),
  KEY `return` (`return_id`),
  KEY `status` (`status`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `pos_sale_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `pos_sale_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `pos_sale_ibfk_3` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`),
  CONSTRAINT `pos_sale_ibfk_4` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `pos_sale_ibfk_5` FOREIGN KEY (`return_id`) REFERENCES `pos_sale` (`id`),
  CONSTRAINT `pos_sale_ibfk_6` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  CONSTRAINT `pos_sale_ibfk_7` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pos_sale` (`id`, `status`, `return_id`, `warehouse`, `customer`, `cart_discount`, `shipping_charge`, `packing_charge`, `round_off`, `payment_note`, `sale_note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1,	20,	NULL,	20,	1,	0.0000,	0.0000,	0.0000,	-0.0900,	NULL,	NULL,	1,	'2022-11-15 23:25:32',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `pos_sale_payment`;
CREATE TABLE `pos_sale_payment` (
  `pos_sale` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  KEY `pos_sale` (`pos_sale`),
  KEY `payment_mode` (`payment_mode`),
  CONSTRAINT `pos_sale_payment_ibfk_1` FOREIGN KEY (`pos_sale`) REFERENCES `pos_sale` (`id`),
  CONSTRAINT `pos_sale_payment_ibfk_3` FOREIGN KEY (`payment_mode`) REFERENCES `payment_mode` (`id`),
  CONSTRAINT `amount_check` CHECK (`amount` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pos_sale_payment` (`pos_sale`, `payment_mode`, `amount`, `transaction_id`, `reference_no`, `note`) VALUES
(1,	2,	400.0000,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `pos_sale_product`;
CREATE TABLE `pos_sale_product` (
  `pos_sale` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity` decimal(15,4) NOT NULL,
  `unit_price` decimal(15,4) NOT NULL,
  `auto_discount` decimal(15,4) DEFAULT NULL,
  `discount` decimal(15,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `data_value_1` varchar(100) DEFAULT NULL,
  `data_value_2` varchar(100) DEFAULT NULL,
  `data_value_3` varchar(100) DEFAULT NULL,
  `data_value_4` varchar(100) DEFAULT NULL,
  `data_value_5` varchar(100) DEFAULT NULL,
  `data_value_6` varchar(100) DEFAULT NULL,
  UNIQUE KEY `pos_sale_product` (`pos_sale`,`product`),
  KEY `pos_sale` (`pos_sale`),
  KEY `product` (`product`),
  KEY `tax_rate` (`tax_id`),
  CONSTRAINT `pos_sale_product_ibfk_1` FOREIGN KEY (`pos_sale`) REFERENCES `pos_sale` (`id`),
  CONSTRAINT `pos_sale_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `pos_sale_product_ibfk_3` FOREIGN KEY (`tax_id`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `quantity_check` CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pos_sale_product` (`pos_sale`, `product`, `quantity`, `unit_price`, `auto_discount`, `discount`, `tax_id`, `data_value_1`, `data_value_2`, `data_value_3`, `data_value_4`, `data_value_5`, `data_value_6`) VALUES
(1,	5,	2.0000,	200.0000,	10.0000,	0.0000,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL);

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
  `mrp` decimal(15,4) DEFAULT NULL,
  `markup` decimal(10,4) DEFAULT 0.0000,
  `price` decimal(10,4) NOT NULL,
  `auto_discount` decimal(10,4) DEFAULT NULL,
  `mfg_date` date DEFAULT NULL,
  `exp_date` date DEFAULT NULL,
  `tax_method` enum('I','E') NOT NULL,
  `tax_rate` int(11) DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product` (`id`, `type`, `code`, `symbology`, `name`, `slug`, `thumbnail`, `weight`, `category`, `brand`, `unit`, `p_unit`, `s_unit`, `is_auto_cost`, `cost`, `mrp`, `markup`, `price`, `auto_discount`, `mfg_date`, `exp_date`, `tax_method`, `tax_rate`, `alert`, `alert_quantity`, `pos_sale`, `custom_discount`, `pos_min_sale_qty`, `pos_max_sale_qty`, `pos_sale_note`, `pos_custom_discount`, `pos_custom_tax`, `pos_data_field_1`, `pos_data_field_2`, `pos_data_field_3`, `pos_data_field_4`, `pos_data_field_5`, `pos_data_field_6`, `added_at`, `updated_at`, `editable`, `deletable`, `deleted_at`) VALUES
(1,	1,	'37519985',	1,	'King Book',	'king-book',	'https://www.escoffier.edu/wp-content/uploads/reading-is-a-great-way-to-continue-your-growth-as-a-chef_1028_40137340_1_14130186_500.jpg',	NULL,	1,	3,	1,	3,	NULL,	'1',	12.0000,	35.0000,	0.0000,	30.0000,	NULL,	NULL,	NULL,	'I',	NULL,	'1',	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:30',	'2022-08-29 14:55:57',	NULL,	NULL,	NULL),
(2,	1,	'62305684',	1,	'Long Book',	'long-book',	'https://3ner1e34iilsjdn1qohanunu-wpengine.netdna-ssl.com/wp-content/uploads/2014/11/82175.jpg',	NULL,	1,	3,	1,	NULL,	NULL,	'1',	12.0000,	50.0000,	0.0000,	45.0000,	1.0000,	NULL,	NULL,	'E',	2,	'1',	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:54',	'2022-08-27 21:23:09',	NULL,	NULL,	NULL),
(3,	1,	'25171014',	1,	'Pen 0.7mm',	'pen-0-7mm',	'https://www.proimprint.com/image/cache/data/KEYCHAINS-OPENERS/Promotional-Keychains-Openers/Custom-Logo-Imprinted-Plastic-Keychains/Customized-Roslin-Stylus-Pens-500x500.jpg',	NULL,	1,	1,	1,	NULL,	NULL,	'1',	12.0000,	NULL,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-28',	'E',	2,	'1',	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:15:37',	'2022-08-27 21:23:09',	NULL,	NULL,	NULL),
(4,	1,	'80493457',	1,	'Stylish',	'stylish',	'https://5.imimg.com/data5/GK/JK/MY-45473441/stylish-pen-500x500.jpg',	NULL,	1,	NULL,	1,	NULL,	NULL,	'1',	12.0000,	5.0000,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-06',	'E',	NULL,	'1',	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:17:04',	'2022-08-27 21:23:09',	NULL,	NULL,	NULL),
(5,	1,	'38644788',	1,	'Couple Photo Frame',	'couple-photo-frame',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7iyBDZf-tfvjCrGwONFuvg3Wj33FJ8xrsBg&usqp=CAU',	NULL,	1,	1,	1,	NULL,	NULL,	'1',	12.0000,	300.0000,	NULL,	200.0000,	10.0000,	NULL,	NULL,	'E',	2,	'1',	3,	0,	NULL,	2.0000,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:18:37',	'2022-10-03 11:17:16',	NULL,	NULL,	NULL),
(6,	1,	'94426911',	1,	'Wall Clock',	'wall-clock',	'https://images-na.ssl-images-amazon.com/images/I/51VjOomhxoL._SY355_.jpg',	NULL,	1,	1,	1,	NULL,	NULL,	'0',	250.7500,	NULL,	0.0000,	570.0000,	170.2500,	NULL,	NULL,	'E',	2,	'1',	3,	NULL,	NULL,	1.0000,	10.0000,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:19:09',	'2022-08-27 23:07:12',	NULL,	NULL,	NULL),
(10,	1,	'39741136',	1,	'Keyboard Mouse Combo',	'keyboard-mouse-combo',	'https://images-na.ssl-images-amazon.com/images/I/619gY3%2BheVL._SL1000_.jpg',	NULL,	1,	1,	6,	NULL,	NULL,	'1',	12.0000,	4500.0000,	0.0000,	1000.0000,	250.0000,	NULL,	NULL,	'I',	2,	'1',	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:23:19',	'2022-08-27 21:23:09',	NULL,	NULL,	NULL),
(215,	1,	'74587136',	1,	'RRRRRRRRRRR',	'rrrrrrrrrrr',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	445.0000,	NULL,	50.0000,	667.5000,	NULL,	NULL,	NULL,	'I',	NULL,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-08-19 12:18:28',	NULL,	NULL,	NULL,	NULL),
(217,	1,	'70491654',	1,	'UIII',	'uiii',	NULL,	NULL,	2,	NULL,	1,	NULL,	NULL,	'1',	4545.0000,	NULL,	50.0000,	6817.5000,	NULL,	NULL,	NULL,	'I',	NULL,	'1',	3,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-08-22 23:54:25',	NULL,	NULL,	NULL,	NULL),
(218,	1,	'20183462',	1,	'iuiui',	'iuiui',	NULL,	NULL,	2,	NULL,	1,	3,	NULL,	'1',	7878.0000,	NULL,	NULL,	11817.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-08-27 11:58:56',	'2022-09-01 00:24:52',	NULL,	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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


DROP TABLE IF EXISTS `product_rack`;
CREATE TABLE `product_rack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `warehouse` int(11) NOT NULL,
  `rack` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_warehouse_rack` (`product`,`warehouse`,`rack`),
  KEY `rack` (`rack`),
  KEY `product` (`product`),
  KEY `warehouse` (`warehouse`),
  CONSTRAINT `product_rack_ibfk_1` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `product_rack_ibfk_2` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `product_rack_ibfk_3` FOREIGN KEY (`rack`) REFERENCES `rack` (`id`)
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_stock` (`id`, `product`, `warehouse`, `quantity`, `added_at`, `updated_at`) VALUES
(45,	215,	20,	100.0000,	'2022-08-19 06:48:28',	NULL),
(46,	217,	27,	10.0000,	'2022-08-22 18:24:25',	NULL),
(47,	218,	20,	667.0000,	'2022-08-27 06:28:56',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_type` (`id`, `code`, `name`, `description`, `deleted_at`) VALUES
(1,	'SP',	'Standard Product',	'Standard Product hereeeeeee',	NULL),
(2,	'CP',	'Combo Product',	'Combo Product here......',	NULL),
(3,	'DP',	'Digital',	'Digital hereeeee',	NULL),
(4,	'SV',	'Service',	'Service hereeee',	NULL);

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE `purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_id` varchar(150) NOT NULL,
  `warehouse` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `discount` decimal(12,4) DEFAULT 0.0000,
  `purchase_tax` int(11) DEFAULT NULL,
  `shipping_charge` decimal(12,4) DEFAULT 0.0000,
  `shipping_tax` int(11) DEFAULT NULL,
  `packing_charge` decimal(12,4) DEFAULT 0.0000,
  `packing_tax` int(11) DEFAULT NULL,
  `round_off` decimal(12,4) DEFAULT 0.0000,
  `payment_note` varchar(150) DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_id` (`reference_id`),
  KEY `warehouse` (`warehouse`),
  KEY `supplier` (`supplier`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `status` (`status`),
  KEY `shipping_tax` (`shipping_tax`),
  KEY `packing_tax` (`packing_tax`),
  KEY `tax` (`purchase_tax`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`),
  CONSTRAINT `purchase_ibfk_10` FOREIGN KEY (`purchase_tax`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `purchase_ibfk_11` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`supplier`) REFERENCES `supplier` (`id`),
  CONSTRAINT `purchase_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_ibfk_5` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  CONSTRAINT `purchase_ibfk_8` FOREIGN KEY (`shipping_tax`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `purchase_ibfk_9` FOREIGN KEY (`packing_tax`) REFERENCES `tax_rate` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `purchase` (`id`, `reference_id`, `warehouse`, `date`, `time`, `status`, `supplier`, `discount`, `purchase_tax`, `shipping_charge`, `shipping_tax`, `packing_charge`, `packing_tax`, `round_off`, `payment_note`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(18,	'REF-PUR-00018',	20,	'2022-11-25',	'23:23:09',	22,	91,	0.0000,	NULL,	0.0000,	NULL,	0.0000,	NULL,	0.2200,	NULL,	NULL,	1,	'2022-11-15 17:53:17',	1,	'2022-11-15 17:53:52',	NULL,	NULL);

DROP TABLE IF EXISTS `purchase_payment`;
CREATE TABLE `purchase_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase` (`purchase`),
  KEY `payment_mode` (`payment_mode`),
  KEY `deleted_by` (`deleted_by`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `purchase_payment_ibfk_1` FOREIGN KEY (`purchase`) REFERENCES `purchase` (`id`),
  CONSTRAINT `purchase_payment_ibfk_2` FOREIGN KEY (`payment_mode`) REFERENCES `payment_mode` (`id`),
  CONSTRAINT `purchase_payment_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_payment_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_payment_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `amount_check` CHECK (`amount` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `purchase_product`;
CREATE TABLE `purchase_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `batch_no` varchar(100) DEFAULT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `unit` int(11) NOT NULL,
  `unit_cost` decimal(12,4) NOT NULL,
  `unit_discount` decimal(12,4) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `net_unit_cost` decimal(12,4) GENERATED ALWAYS AS (`unit_cost` - `unit_discount`) VIRTUAL,
  `product_total_without_tax` decimal(12,4) GENERATED ALWAYS AS (`net_unit_cost` * `quantity`) VIRTUAL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product` (`product`),
  KEY `unit` (`unit`),
  KEY `tax_id` (`tax_id`),
  KEY `purchase` (`purchase`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `purchase_product_ibfk_1` FOREIGN KEY (`purchase`) REFERENCES `purchase` (`id`),
  CONSTRAINT `purchase_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `purchase_product_ibfk_3` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `purchase_product_ibfk_4` FOREIGN KEY (`tax_id`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `purchase_product_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_product_ibfk_6` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_product_ibfk_7` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `quantity_check` CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `purchase_product` (`id`, `purchase`, `product`, `batch_no`, `quantity`, `unit`, `unit_cost`, `unit_discount`, `tax_id`, `net_unit_cost`, `product_total_without_tax`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(80,	18,	5,	NULL,	10.0000,	2,	60.0000,	0.0000,	2,	60.0000,	600.0000,	1,	'2022-11-15 17:53:17',	1,	'2022-11-15 17:53:52',	NULL,	NULL);

DROP TABLE IF EXISTS `rack`;
CREATE TABLE `rack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warehouse_rack_name` (`warehouse`,`name`),
  KEY `warehouse` (`warehouse`),
  CONSTRAINT `rack_ibfk_1` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `return_purchase`;
CREATE TABLE `return_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_id` varchar(150) NOT NULL,
  `purchase` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` int(11) NOT NULL,
  `discount` decimal(12,4) DEFAULT 0.0000,
  `return_tax` int(11) DEFAULT NULL,
  `shipping_charge` decimal(12,4) DEFAULT 0.0000,
  `shipping_tax` int(11) DEFAULT NULL,
  `packing_charge` decimal(12,4) DEFAULT 0.0000,
  `packing_tax` int(11) DEFAULT NULL,
  `round_off` decimal(12,4) DEFAULT 0.0000,
  `payment_note` varchar(150) DEFAULT NULL,
  `note` varchar(150) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference_id` (`reference_id`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `status` (`status`),
  KEY `return_id` (`purchase`),
  KEY `shipping_tax` (`shipping_tax`),
  KEY `packing_tax` (`packing_tax`),
  KEY `tax` (`return_tax`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `return_purchase_ibfk_1` FOREIGN KEY (`purchase`) REFERENCES `purchase` (`id`),
  CONSTRAINT `return_purchase_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_ibfk_4` FOREIGN KEY (`status`) REFERENCES `status` (`id`),
  CONSTRAINT `return_purchase_ibfk_5` FOREIGN KEY (`return_tax`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `return_purchase_ibfk_6` FOREIGN KEY (`shipping_tax`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `return_purchase_ibfk_7` FOREIGN KEY (`packing_tax`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `return_purchase_ibfk_8` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `return_purchase` (`id`, `reference_id`, `purchase`, `date`, `time`, `status`, `discount`, `return_tax`, `shipping_charge`, `shipping_tax`, `packing_charge`, `packing_tax`, `round_off`, `payment_note`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(33,	'REF-RET-PUR-00033',	18,	'2022-11-15',	'23:24:02',	5,	0.0000,	NULL,	0.0000,	NULL,	0.0000,	NULL,	-0.4440,	NULL,	NULL,	1,	'2022-11-15 17:54:07',	1,	'2022-11-15 18:08:27',	1,	'2022-11-15 18:08:27'),
(34,	'REF-RET-PUR-00034',	18,	'2022-11-15',	'23:39:18',	5,	0.0000,	NULL,	0.0000,	NULL,	0.0000,	NULL,	0.2780,	'www',	NULL,	1,	'2022-11-15 18:09:20',	NULL,	'2022-11-15 18:12:23',	NULL,	NULL);

DROP TABLE IF EXISTS `return_purchase_payment`;
CREATE TABLE `return_purchase_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_purchase` int(11) NOT NULL,
  `payment_mode` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase` (`return_purchase`),
  KEY `payment_mode` (`payment_mode`),
  KEY `created_by` (`created_by`),
  KEY `updated_by` (`updated_by`),
  KEY `deleted_by` (`deleted_by`),
  CONSTRAINT `return_purchase_payment_ibfk_1` FOREIGN KEY (`return_purchase`) REFERENCES `return_purchase` (`id`),
  CONSTRAINT `return_purchase_payment_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_payment_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_payment_ibfk_4` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `return_purchase_payment` (`id`, `return_purchase`, `payment_mode`, `amount`, `date_time`, `transaction_id`, `reference_no`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(3,	34,	1,	11.0000,	'2022-11-15 23:41:00',	NULL,	NULL,	NULL,	1,	'2022-11-15 18:11:27',	1,	'2022-11-15 18:13:05',	1,	'2022-11-15 18:13:05'),
(4,	34,	1,	20.0000,	'2022-11-15 23:41:00',	NULL,	NULL,	NULL,	1,	'2022-11-15 18:11:41',	NULL,	'2022-11-15 18:12:49',	1,	'2022-11-15 18:12:49'),
(5,	34,	3,	11.0000,	'2022-11-15 23:41:00',	NULL,	NULL,	'yuy fdf',	1,	'2022-11-15 18:11:41',	1,	'2022-11-15 18:16:10',	NULL,	NULL),
(6,	34,	5,	22.0000,	'2022-11-15 23:43:00',	NULL,	NULL,	'yu rrt',	1,	'2022-11-15 18:13:05',	1,	'2022-11-15 18:20:30',	NULL,	NULL),
(7,	34,	3,	28.0000,	'2022-11-15 23:51:00',	'h',	NULL,	NULL,	1,	'2022-11-15 18:21:35',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `return_purchase_product`;
CREATE TABLE `return_purchase_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_purchase` int(11) NOT NULL,
  `purchase_product` int(11) NOT NULL,
  `quantity` decimal(12,4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `return_purchase_purchase_product_deleted_at` (`return_purchase`,`purchase_product`,`deleted_at`),
  KEY `product` (`purchase_product`),
  KEY `deleted_by` (`deleted_by`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `return_purchase_product_ibfk_1` FOREIGN KEY (`return_purchase`) REFERENCES `return_purchase` (`id`),
  CONSTRAINT `return_purchase_product_ibfk_5` FOREIGN KEY (`purchase_product`) REFERENCES `purchase_product` (`id`),
  CONSTRAINT `return_purchase_product_ibfk_6` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_product_ibfk_7` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_purchase_product_ibfk_8` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `return_quantity_check` CHECK (`quantity` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `return_purchase_product` (`id`, `return_purchase`, `purchase_product`, `quantity`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(80,	33,	80,	2.0000,	1,	'2022-11-15 17:54:07',	1,	'2022-11-15 17:54:31',	NULL,	NULL),
(81,	34,	80,	1.0000,	1,	'2022-11-15 18:09:20',	NULL,	NULL,	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This is user groups';

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
(1,	11,	6,	1,	'POS - datatable (sale)',	1,	NULL),
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
(1,	18,	1,	1,	'PURCHASE - create',	1,	NULL),
(1,	18,	3,	1,	'PURCHASE - update',	1,	NULL),
(1,	18,	4,	1,	'PURCHASE - delete',	1,	NULL),
(1,	18,	6,	1,	'PURCHASE - datatable',	1,	NULL),
(1,	18,	7,	1,	'PURCHASE - details',	1,	NULL),
(1,	18,	9,	1,	'PURCHASE - payment',	1,	NULL),
(1,	18,	10,	1,	'PURCHASE - payment details',	1,	NULL),
(1,	18,	11,	1,	'PURCHASE - payment update',	1,	NULL),
(1,	19,	1,	1,	'PURCHASE RETURN - create',	1,	NULL),
(1,	19,	3,	1,	'PURCHASE RETURN - update',	1,	NULL),
(1,	19,	4,	1,	'PURCHASE RETURN - delete',	1,	NULL),
(1,	19,	6,	1,	'PURCHASE RETURN - datatable',	1,	NULL),
(1,	19,	7,	1,	'PURCHASE RETURN - details',	1,	NULL),
(1,	19,	9,	1,	'PURCHASE RETURN - payment add',	1,	NULL),
(1,	19,	10,	1,	'PURCHASE RETURN - payment details',	1,	NULL),
(1,	19,	11,	1,	'PURCHASE RETURN - update payment',	1,	NULL);

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
  `pos_sale_status` tinyint(1) DEFAULT NULL,
  `purchase_status` tinyint(1) DEFAULT NULL,
  `purchase_return_status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `purchase_status` (`purchase_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `status` (`id`, `name`, `css_class`, `css_color`, `online_status`, `payment_status`, `order_status`, `role_status`, `user_status`, `warehouse_status`, `pos_sale_status`, `purchase_status`, `purchase_return_status`) VALUES
(1,	'online',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(2,	'offline',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(3,	'active',	'bg-success',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(4,	'inactive',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL),
(5,	'pending',	'bg-warning text-dark',	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	1,	1),
(6,	'paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(7,	'unpaid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(8,	'ordered',	'bg-primary',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	1,	NULL),
(9,	'packed',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(10,	'shipped',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(11,	'returned',	'bg-success',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	1,	NULL,	1),
(12,	'partially paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(13,	'expired',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(14,	'away',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(15,	'blocked',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL),
(16,	'open',	'bg-success',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(17,	'closed',	'bg-warning text-dark',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(18,	'permanently closed',	'bg-danger',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(19,	'temperorily closed',	'bg-info text-dark',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL),
(20,	'completed',	'bg-success',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL),
(21,	'due',	'bg-danger',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL),
(22,	'recieved ✓',	'bg-success',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
  CONSTRAINT `stock_adjustment_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`),
  CONSTRAINT `quantity_check` CHECK (`quantity` <> 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `supplier` (`id`, `code`, `name`, `place`, `address`, `pin_code`, `city`, `phone`, `email`, `gst_no`, `tax_no`, `description`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(88,	'SUPP0088',	'Supp 1',	'rwrr5',	NULL,	NULL,	NULL,	'53535355',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:30:51',	'2022-08-27 18:53:28',	NULL),
(89,	'SUPP0089',	'Tensile',	'Kudappanamoodu',	'Bzd\nasdasd\nTdsd',	695505,	'Trivandrum',	'6664564564',	'ddfdfd@fgh.gbg',	'DDADA14166416+A',	'565656',	'fggfdgfdgdfg',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:31:29',	'2022-10-22 10:08:32',	NULL),
(91,	'SUPP0091',	'Heloooo',	'tyrytry',	NULL,	NULL,	NULL,	'564335466',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:00',	'2022-08-27 18:53:39',	'2022-07-09 13:44:50'),
(108,	'SUPP0108',	'dfsdfd',	'fdfdfd',	NULL,	NULL,	NULL,	'454545',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-08-29 17:51:55',	NULL,	NULL);

DROP TABLE IF EXISTS `symbology`;
CREATE TABLE `symbology` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 NOT NULL,
  `name` text CHARACTER SET utf8 NOT NULL,
  `desc` text CHARACTER SET utf8 DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `symbology` (`id`, `code`, `name`, `desc`, `deleted_at`) VALUES
(1,	'CODE128',	'CODE128 (auto and force mode)',	NULL,	NULL),
(2,	'CODE39',	'CODE39',	NULL,	NULL),
(3,	'EAN / UPC',	'EAN-13, EAN-8, EAN-5, EAN-2, UPC (A)',	NULL,	NULL),
(4,	'ITF-14',	'ITF-14',	NULL,	NULL),
(5,	'ITF',	'ITF',	NULL,	NULL),
(6,	'MSI',	'MSI',	NULL,	NULL),
(7,	'Pharmacode',	'Pharmacode',	NULL,	NULL);

DROP TABLE IF EXISTS `tax_group`;
CREATE TABLE `tax_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(15) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tax_rate` (`id`, `code`, `name`, `rate`, `type`, `description`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'GST10',	'GST',	10.0000,	'P',	NULL,	NULL,	NULL,	'2021-03-02 14:12:44',	'2022-07-12 07:53:30',	NULL),
(2,	'IGST2',	'IGST',	2.1300,	'P',	NULL,	NULL,	NULL,	'2021-03-02 14:12:44',	'2022-10-21 06:07:30',	NULL),
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
  UNIQUE KEY `base_step` (`base`,`step`),
  KEY `base` (`base`),
  CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`base`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `unit` (`id`, `base`, `code`, `name`, `step`, `allow_decimal`, `description`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'PC',	'Piece',	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:13:31',	'2022-07-22 17:32:14',	NULL),
(2,	1,	'5PC',	'5 Piece',	5,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:14:10',	'2022-07-22 17:32:14',	NULL),
(3,	1,	'10 PC',	'10 Piece',	10,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:15:25',	'2022-07-22 17:32:14',	NULL),
(5,	NULL,	'GM',	'Gram',	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:21:17',	'2022-07-22 17:32:14',	NULL),
(6,	NULL,	'KG',	'Kilo Gram',	NULL,	1,	NULL,	NULL,	NULL,	'2022-07-20 14:21:49',	'2022-07-22 17:32:14',	NULL),
(7,	6,	'5kkk',	'5 kg',	5,	1,	NULL,	NULL,	NULL,	'2022-07-20 15:13:35',	'2022-08-29 11:08:08',	NULL),
(8,	5,	'1/2 KG',	'Half KG',	500,	0,	NULL,	NULL,	NULL,	'2022-07-20 15:18:12',	'2022-08-29 11:08:27',	NULL),
(9,	NULL,	'MTR',	'Meter',	NULL,	0,	NULL,	NULL,	NULL,	'2022-07-20 15:23:18',	'2022-07-23 15:59:45',	NULL),
(88,	6,	'jk',	'14hjhgj',	14,	0,	NULL,	NULL,	NULL,	'2022-08-29 17:33:18',	'2022-09-11 07:25:23',	NULL),
(89,	6,	'1 Ton',	'Ton',	1000,	1,	NULL,	NULL,	NULL,	'2022-08-29 17:34:29',	NULL,	NULL),
(90,	1,	'fgfg',	'53 gfg',	53,	1,	NULL,	NULL,	NULL,	'2022-10-08 07:35:00',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id`, `code`, `role`, `username`, `password`, `first_name`, `last_name`, `company_name`, `date_of_birth`, `email`, `phone`, `avatar`, `gender`, `country`, `city`, `place`, `pin_code`, `address`, `description`, `status`, `deletable`, `editable`, `client_ip`, `login_at`, `logout_at`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'C1',	1,	'admin',	'$2y$10$6XeS4Sx0lGQzUWsqoSqaDOsaoM2wSVQAmDQg4viwBD4b5WAFw4SBu',	'Samnad',	'S',	'Cna',	'1992-10-30',	'admin@example.com',	'+91-0000000012',	NULL,	1,	'India',	'TVM',	'Trivandrum',	'695505',	'CyberLikes Pvt. Ltd.',	'something',	3,	0,	0,	'::1',	'2022-11-15 16:53:00',	'2022-10-27 17:42:33',	'2021-04-20 19:22:52',	'2022-11-15 16:53:00',	NULL),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `warehouse` (`id`, `code`, `name`, `place`, `date_of_open`, `country`, `city`, `pin_code`, `phone`, `email`, `address`, `longitude`, `latitude`, `description`, `status`, `status_reason`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(20,	'WARE0020',	'Ware House AAA',	'dsds',	'2020-02-12',	'India',	'TVM',	'695505',	'+91-9745451448',	'tewest@gmail.com',	'TVM',	NULL,	NULL,	'lklkl',	16,	'Flood',	NULL,	NULL,	'2021-04-14 19:54:53',	'2022-08-27 06:30:31',	NULL),
(27,	'WARE0027',	'Ware House BBB',	'KMD',	'2022-07-01',	'Innnn',	'Ciiiii',	NULL,	'9745451448',	'sdsds@g.ghh',	'Addddddd',	NULL,	NULL,	'Desssssssssss',	16,	'Some',	NULL,	NULL,	'2022-07-05 12:01:17',	'2022-09-12 06:08:24',	NULL),
(33,	'WARE0033',	' bvbv',	'nbnvbnvbn',	'2022-09-08',	NULL,	NULL,	NULL,	'45454545',	'bnvbn@qqwqw.ghg',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-09-11 07:52:55',	'2022-11-01 11:50:03',	'2022-11-01 11:50:03'),
(34,	'WARE0034',	'Closed Ware house',	'ddfgdfdf',	'2022-11-29',	NULL,	NULL,	NULL,	'54545435',	'fdf@fff.tyytry',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-11-01 11:50:50',	NULL,	NULL);

-- 2022-11-15 18:28:45
