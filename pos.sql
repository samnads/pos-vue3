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
(81,	'ty',	'ytuty',	NULL,	't76878',	NULL,	NULL,	'2021-08-19 19:54:10',	NULL,	NULL);

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `image` (`image`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `category` (`id`, `code`, `name`, `slug`, `image`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'SI',	'School Items',	'school-items',	NULL,	'uidgdgfd',	'2021-01-24 05:49:06',	NULL,	NULL),
(2,	'OI',	'Office Items',	'office-items',	NULL,	'gfhfgh hghh',	'2021-01-24 05:49:25',	NULL,	NULL),
(4,	'E',	'Electronics',	'electronics',	NULL,	'df df fd f',	'2021-01-24 14:49:36',	NULL,	NULL),
(5,	'BI',	'Baby Items',	'baby-items',	NULL,	'hdf  gtt',	'2021-01-24 14:51:37',	NULL,	NULL),
(52,	'GI',	'Gift Items',	'gift-items',	NULL,	NULL,	'2022-04-02 10:56:45',	NULL,	NULL),
(53,	'gh',	'hjhjhj',	'hjhjhj',	NULL,	'jhgjhjhj',	'2022-04-03 10:19:10',	NULL,	NULL),
(54,	'sa',	'dsss',	'dsss',	NULL,	NULL,	'2022-04-03 11:23:07',	NULL,	NULL),
(55,	'qw',	'ttwrer',	'ttwrer',	NULL,	NULL,	'2022-04-03 11:26:15',	NULL,	NULL),
(56,	'tt',	'tyytyyyty',	'tyytyyyty',	NULL,	NULL,	'2022-04-03 11:59:47',	NULL,	NULL),
(57,	'gf',	'bjmhj',	'bjmhj',	NULL,	NULL,	'2022-04-05 12:23:55',	NULL,	NULL),
(58,	'r3',	'dfgg',	'dfgg',	NULL,	NULL,	'2022-04-11 07:11:42',	NULL,	NULL),
(59,	'54',	'fdgfdg',	'fdgfdg',	NULL,	NULL,	'2022-04-11 07:14:55',	NULL,	NULL),
(60,	'a2',	'aaa',	'aaa',	NULL,	NULL,	'2022-04-11 07:15:09',	NULL,	NULL),
(61,	'78768',	'uiouio',	'uiouio',	NULL,	NULL,	'2022-04-12 11:21:17',	NULL,	NULL),
(62,	'fg',	'iuiuyiyui',	'iuiuyiyui',	NULL,	NULL,	'2022-04-15 11:50:04',	NULL,	NULL);

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
(41,	'CUST0041',	1,	'uyuytu',	'yuytuyuyt',	NULL,	NULL,	NULL,	NULL,	NULL,	'oipi',	NULL,	NULL,	'ACTIVE',	'2022-06-30 16:11:34',	'2022-07-06 17:06:23',	NULL),
(42,	'CUST0042',	3,	'yuyuyu',	'yuyuyu',	NULL,	NULL,	'898',	NULL,	NULL,	'88890',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:26:31',	'2022-07-06 17:05:31',	'2022-07-06 17:05:31'),
(44,	'CUST0044',	2,	'aaa',	'tytyt',	'dfdf@fg.ghgh',	'565656',	'jhkuhoi',	'65656',	'6565',	'uiiouioiuo',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:38:41',	'2022-07-06 17:04:48',	'2022-07-06 17:04:48'),
(45,	'CUST0045',	2,	'tyutu6767',	'6767',	NULL,	NULL,	'jkjk',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:51:58',	'2022-07-01 14:26:53',	'2022-07-01 14:26:53'),
(48,	'CUST0048',	4,	'aaaa',	'aaa',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	0,	'ACTIVE',	'2022-07-01 04:52:16',	'2022-07-01 14:26:40',	NULL),
(50,	'CUST0050',	2,	'rtdtg',	'ggfg',	NULL,	NULL,	NULL,	NULL,	NULL,	'klklkluy',	NULL,	NULL,	'ACTIVE',	'2022-07-01 04:52:27',	'2022-07-06 17:12:57',	NULL),
(51,	'CUST0051',	1,	'kjjhkjk',	'uiuii',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-01 05:38:54',	'2022-07-01 14:26:40',	NULL),
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
  `description` text NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `module` (`id`, `name`, `description`, `added_at`, `updated_at`) VALUES
(1,	'product',	'',	'2022-07-06 11:59:05',	NULL),
(2,	'category',	'',	'2022-07-06 11:59:05',	NULL),
(3,	'brand',	'This module is for product brands, here you can set permission for add, edit, update and delete the brands.',	'2022-07-06 11:59:05',	NULL),
(4,	'tax',	'',	'2022-07-06 11:59:05',	NULL),
(5,	'unit',	'',	'2022-07-06 11:59:05',	NULL),
(6,	'supplier',	'',	'2022-07-06 11:59:05',	NULL),
(7,	'customer',	'',	'2022-07-06 11:59:05',	NULL),
(8,	'user',	'',	'2022-07-06 11:59:05',	NULL),
(9,	'warehouse',	'',	'2022-07-06 11:59:05',	NULL),
(10,	'role',	'',	'2022-07-06 11:59:05',	NULL),
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
  `read_only` tinyint(1) DEFAULT NULL COMMENT 'manually added rows',
  `allow` tinyint(1) DEFAULT NULL,
  `comments` varchar(50) DEFAULT NULL,
  UNIQUE KEY `module_permission` (`module`,`permission`),
  KEY `permission` (`permission`),
  CONSTRAINT `module_permission_ibfk_1` FOREIGN KEY (`module`) REFERENCES `module` (`id`),
  CONSTRAINT `module_permission_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `permission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Available Permissions for each modules';

INSERT INTO `module_permission` (`module`, `permission`, `read_only`, `allow`, `comments`) VALUES
(10,	1,	1,	1,	'ROLE - post'),
(10,	2,	1,	1,	'ROLE - get'),
(10,	3,	1,	1,	'ROLE - put'),
(10,	4,	1,	1,	'ROLE - delete'),
(10,	6,	1,	1,	'ROLE - datatable');

DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `permission` (`id`, `name`, `added_at`, `updated_at`) VALUES
(1,	'create',	'2021-05-07 16:33:13',	'2022-07-06 16:41:06'),
(2,	'read',	'2021-05-07 16:33:28',	'2022-07-06 16:42:42'),
(3,	'update',	'2021-05-07 16:33:34',	'2022-07-06 16:41:27'),
(4,	'delete',	'2021-05-07 16:33:39',	'2022-07-06 15:07:33'),
(5,	'dropdown',	'2021-08-02 18:46:06',	'2022-07-06 17:10:05'),
(6,	'datatable',	'2021-08-07 19:31:59',	'2022-07-06 13:42:37'),
(7,	'details',	'2022-07-06 17:31:43',	NULL),
(8,	'search_product',	'2022-07-07 07:55:03',	'2022-07-07 13:15:47');

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
  `sub_category` int(11) DEFAULT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `slug` (`slug`),
  KEY `product-product_type` (`type`),
  KEY `product-symbology` (`symbology`),
  KEY `product-category` (`category`),
  KEY `product-sub_category` (`sub_category`),
  KEY `product-brand` (`brand`),
  KEY `product-unit` (`unit`),
  KEY `product-unit_bulk1` (`p_unit`),
  KEY `product-unit_bulk2` (`s_unit`),
  KEY `product-tax_rate` (`tax_rate`),
  CONSTRAINT `product-brand` FOREIGN KEY (`brand`) REFERENCES `brand` (`id`),
  CONSTRAINT `product-category` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `product-product_type` FOREIGN KEY (`type`) REFERENCES `product_type` (`id`),
  CONSTRAINT `product-sub_category` FOREIGN KEY (`sub_category`) REFERENCES `sub_category` (`id`),
  CONSTRAINT `product-tax_rate` FOREIGN KEY (`tax_rate`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `product-unit` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `product-unit_bulk1` FOREIGN KEY (`p_unit`) REFERENCES `unit_bulk` (`id`),
  CONSTRAINT `product-unit_bulk2` FOREIGN KEY (`s_unit`) REFERENCES `unit_bulk` (`id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`symbology`) REFERENCES `symbology` (`id`),
  CONSTRAINT `price_check` CHECK (`price` <= `mrp`),
  CONSTRAINT `pos_max_sale_qty_check` CHECK (`pos_max_sale_qty` >= `pos_min_sale_qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product` (`id`, `type`, `code`, `symbology`, `name`, `slug`, `thumbnail`, `weight`, `category`, `sub_category`, `brand`, `unit`, `p_unit`, `s_unit`, `is_auto_cost`, `cost`, `mrp`, `markup`, `price`, `auto_discount`, `mfg_date`, `exp_date`, `tax_method`, `tax_rate`, `quantity`, `alert`, `alert_quantity`, `pos_sale`, `custom_discount`, `pos_min_sale_qty`, `pos_max_sale_qty`, `pos_sale_note`, `pos_custom_discount`, `pos_custom_tax`, `pos_data_field_1`, `pos_data_field_2`, `pos_data_field_3`, `pos_data_field_4`, `pos_data_field_5`, `pos_data_field_6`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'37519985',	1,	'King Book',	'king-book',	'https://www.escoffier.edu/wp-content/uploads/reading-is-a-great-way-to-continue-your-growth-as-a-chef_1028_40137340_1_14130186_500.jpg',	NULL,	1,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	35.0000,	0.0000,	30.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:30',	'2021-04-03 23:59:43',	NULL),
(2,	1,	'62305684',	1,	'Long Book',	'long-book',	'https://3ner1e34iilsjdn1qohanunu-wpengine.netdna-ssl.com/wp-content/uploads/2014/11/82175.jpg',	NULL,	1,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	50.0000,	0.0000,	45.0000,	1.0000,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:54',	'2021-04-04 00:00:25',	NULL),
(3,	1,	'25171014',	1,	'Pen 0.7mm',	'pen-0-7mm',	'https://www.proimprint.com/image/cache/data/KEYCHAINS-OPENERS/Promotional-Keychains-Openers/Custom-Logo-Imprinted-Plastic-Keychains/Customized-Roslin-Stylus-Pens-500x500.jpg',	NULL,	1,	4,	1,	1,	NULL,	NULL,	'1',	NULL,	NULL,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-28',	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:15:37',	'2021-04-04 00:02:04',	NULL),
(4,	1,	'80493457',	1,	'Stylish',	'stylish',	'https://5.imimg.com/data5/GK/JK/MY-45473441/stylish-pen-500x500.jpg',	NULL,	1,	4,	NULL,	1,	NULL,	NULL,	'1',	NULL,	5.0000,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-06',	'E',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:17:04',	NULL,	NULL),
(5,	1,	'38644788',	1,	'Couple Photo Frame',	'couple-photo-frame',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7iyBDZf-tfvjCrGwONFuvg3Wj33FJ8xrsBg&usqp=CAU',	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	NULL,	300.0000,	0.0000,	200.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:18:37',	NULL,	NULL),
(6,	1,	'94426911',	1,	'Wall Clock',	'wall-clock',	'https://images-na.ssl-images-amazon.com/images/I/51VjOomhxoL._SY355_.jpg',	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'0',	300.0000,	NULL,	0.0000,	570.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:19:09',	NULL,	NULL),
(10,	1,	'39741136',	1,	'Keyboard Mouse Combo',	'keyboard-mouse-combo',	'https://images-na.ssl-images-amazon.com/images/I/619gY3%2BheVL._SL1000_.jpg',	NULL,	4,	NULL,	1,	1,	NULL,	NULL,	'1',	NULL,	4500.0000,	0.0000,	1000.0000,	250.0000,	NULL,	NULL,	'I',	2,	0.0000,	'1',	3,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:23:19',	NULL,	NULL),
(149,	1,	'56904366',	1,	'fhfgh',	'fghetrty',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:05',	NULL,	NULL),
(150,	1,	'65640426',	1,	'gdgserer',	'dfghfhdh',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:22',	NULL,	NULL),
(151,	1,	'78154768',	1,	'tyur',	'urutyutyuytu',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-24 02:14:50',	NULL,	NULL),
(152,	1,	'86112495',	1,	'ertert',	'rreyryryy',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-25 00:30:23',	NULL,	NULL),
(161,	1,	'63886634',	1,	'78768',	'6787688',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-11 16:55:30',	NULL,	NULL),
(165,	1,	'27144759',	1,	'dffsfsf',	'dffsfsf',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	3.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	0,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-12 17:31:44',	NULL,	NULL),
(173,	1,	'48386886',	1,	'AAA',	'aaa',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	NULL,	75.0000,	0.0000,	'2022-06-23',	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:06',	'2022-06-23 16:00:49',	NULL),
(174,	1,	'33267747',	1,	'etertet',	'etertet',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	NULL,	50.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	1,	1,	0,	'Serial No.',	'Serial No.',	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:29',	'2022-06-28 13:58:01',	NULL),
(176,	1,	'23556049',	1,	'Dell Monotor',	'dell-monotor',	NULL,	NULL,	4,	NULL,	NULL,	1,	NULL,	NULL,	'1',	400.0000,	NULL,	NULL,	400.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	10,	1,	NULL,	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-18 13:03:23',	'2022-06-28 13:58:12',	NULL),
(180,	1,	'54805482',	1,	'Name 1',	'name-1',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	10.0000,	500.0000,	NULL,	10.0000,	0.0000,	NULL,	NULL,	'I',	1,	0.0000,	'1',	20,	1,	NULL,	NULL,	NULL,	1,	1,	1,	'Serial No.',	'Color',	NULL,	NULL,	NULL,	'6',	'2022-04-26 16:14:34',	'2022-06-26 21:15:53',	NULL),
(186,	1,	'96213555',	2,	'have data field 1 - 2',	'have-data-field-1---2',	NULL,	NULL,	2,	NULL,	1,	39,	NULL,	NULL,	'1',	100.0000,	500.0000,	NULL,	150.0000,	10.0000,	'2022-05-30',	'2022-06-06',	'I',	NULL,	0.0000,	'1',	12,	1,	NULL,	NULL,	NULL,	1,	1,	1,	'IMEI No.',	'IMEI No.',	'IMEI No. 2 :',	'b',	'c',	'4454',	'2022-04-28 16:42:25',	'2022-06-28 17:45:04',	NULL),
(187,	1,	'24366313',	1,	'yuiyui',	'yuiyui',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	10.0000,	NULL,	NULL,	15.0000,	0.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	1,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-06-27 20:42:52',	'2022-06-28 18:20:03',	NULL),
(188,	1,	'98141630',	1,	'tytytytyty',	'tytytytyty',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	65.0000,	NULL,	50.0000,	97.5000,	5.0000,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	5,	1,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-05 17:37:03',	NULL,	NULL);

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
(1,	'S',	'Standard Product',	'Standard Product hereeeeeee',	NULL),
(2,	'C',	'Combo Product',	'Combo Product here......',	NULL),
(3,	'D',	'Digital',	'Digital hereeeee',	NULL),
(4,	'SV',	'Service',	'Service hereeee',	NULL);

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(150) DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT 1,
  `updatable_rights` tinyint(1) NOT NULL DEFAULT 1,
  `deletable` tinyint(1) DEFAULT NULL,
  `limit` int(11) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This is user groups';

INSERT INTO `role` (`id`, `name`, `description`, `editable`, `updatable_rights`, `deletable`, `limit`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Administrator',	'All permissions allowed.',	0,	0,	0,	1,	'2021-04-21 00:19:28',	'2022-07-06 12:10:28',	NULL),
(2,	'Seller',	'Sales permissions.',	1,	1,	NULL,	2,	'2021-04-21 00:21:17',	'2022-07-06 15:21:36',	NULL),
(3,	'Purchaser',	'Purchase permissions.',	1,	1,	NULL,	1,	'2021-04-21 00:21:35',	'2022-07-06 15:21:36',	NULL),
(19,	'test',	'test',	1,	1,	NULL,	3,	'2021-08-15 23:49:29',	'2022-07-06 15:21:36',	NULL),
(28,	'rerere',	'tgtrrtrt',	1,	1,	NULL,	1,	'2022-07-04 23:10:41',	'2022-07-06 15:21:36',	NULL),
(29,	'testt',	'sdsd',	1,	1,	0,	3,	'2022-07-06 11:57:03',	'2022-07-06 12:10:28',	NULL);

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `readonly` tinyint(1) DEFAULT NULL COMMENT 'no changes can be made from ui',
  `comment` varchar(100) DEFAULT NULL,
  `allow` tinyint(1) DEFAULT 0,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  UNIQUE KEY `role_id_module_id_permission_id` (`role_id`,`module_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  CONSTRAINT `role_permission_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Rows with readonly flag are read only or manually added rows ';

INSERT INTO `role_permission` (`role_id`, `module_id`, `permission_id`, `readonly`, `comment`, `allow`, `added_at`, `updated_at`) VALUES
(1,	1,	4,	1,	'PRODUCT - delete',	1,	'2022-07-06 17:36:43',	NULL),
(1,	1,	6,	1,	'PRODUCT - datatable',	1,	'2022-07-06 17:30:12',	NULL),
(1,	1,	7,	1,	'PRODUCT - details',	1,	'2022-07-06 17:34:16',	NULL),
(1,	3,	1,	1,	'BRAND - create',	1,	'2022-07-07 15:44:37',	NULL),
(1,	3,	3,	1,	'BRAND - update',	1,	'2022-07-07 15:50:35',	NULL),
(1,	3,	4,	1,	'BRAND - delete',	1,	'2022-07-07 16:49:43',	NULL),
(1,	3,	6,	1,	'BRAND - datatable',	1,	'2022-07-07 14:03:41',	NULL),
(1,	6,	1,	1,	'SUPPLIER - create',	1,	'2021-09-29 18:24:05',	'2022-07-06 16:55:02'),
(1,	6,	3,	1,	'SUPPLIER - update',	1,	'2021-09-29 18:24:05',	'2022-07-06 16:55:02'),
(1,	6,	4,	1,	'SUPPLIER - delete',	1,	'2021-09-29 18:24:05',	'2022-07-06 16:55:02'),
(1,	6,	6,	1,	'SUPPLIER - datatable',	1,	'2022-07-06 16:49:35',	'2022-07-06 16:55:02'),
(1,	7,	1,	1,	'CUSTOMER - create',	1,	'2021-09-29 18:24:05',	'2022-07-06 16:59:56'),
(1,	7,	3,	1,	'CUSTOMER - update',	1,	'2021-09-29 18:24:05',	'2022-07-06 17:00:08'),
(1,	7,	4,	1,	'CUSTOMER - delete',	1,	'2021-09-29 18:24:05',	'2022-07-06 17:00:27'),
(1,	7,	6,	1,	'CUSTOMER - datatable',	1,	'2022-07-06 16:58:16',	'2022-07-06 17:02:19'),
(1,	8,	1,	1,	'USER - create',	1,	'2021-09-29 18:24:05',	'2022-07-06 14:28:42'),
(1,	8,	3,	1,	'USER - update',	1,	'2021-09-29 18:24:05',	'2022-07-06 16:40:22'),
(1,	8,	4,	1,	'USER - delete',	1,	'2021-09-29 18:24:05',	'2022-07-06 14:28:42'),
(1,	8,	6,	1,	'USER - datatable',	1,	'2022-07-06 14:27:24',	'2022-07-06 16:46:30'),
(1,	9,	1,	1,	'WAREHOUSE - create',	1,	'2022-07-06 17:24:31',	NULL),
(1,	9,	3,	1,	'WAREHOUSE - update',	1,	'2022-07-06 17:22:04',	NULL),
(1,	9,	4,	1,	'WAREHOUSE - delete',	1,	'2022-07-06 17:24:56',	'2022-07-06 17:26:00'),
(1,	9,	5,	1,	'WAREHOUSE - dropdown',	1,	'2022-07-06 17:42:28',	NULL),
(1,	9,	6,	1,	'WAREHOUSE - datatable',	1,	'2022-07-06 17:21:27',	NULL),
(1,	10,	1,	1,	'ROLE - create',	1,	'2021-09-29 18:24:05',	'2022-07-06 17:01:27'),
(1,	10,	3,	1,	'ROLE - update',	1,	'2021-09-29 18:24:05',	'2022-07-06 17:01:35'),
(1,	10,	4,	1,	'ROLE - delete',	1,	'2021-09-29 18:24:05',	'2022-07-06 17:01:42'),
(1,	10,	6,	1,	'ROLE - datatable',	1,	'2022-07-06 14:17:43',	'2022-07-06 17:01:49'),
(1,	11,	2,	1,	'MANUAL (pos list product)',	1,	'2021-09-29 18:30:33',	NULL),
(1,	12,	2,	1,	'MANUAL (list product types)',	1,	'2021-09-23 17:49:34',	'2021-10-18 19:55:23'),
(1,	13,	2,	1,	'MANUAL (list barcode symbs)',	1,	'2021-09-23 18:02:55',	'2021-09-29 17:50:05'),
(1,	14,	2,	1,	'MANUAL (print barcode or label)',	1,	'2021-10-01 18:16:31',	NULL),
(1,	15,	1,	1,	'STOCK ADJ - create',	1,	'2021-10-29 17:45:44',	'2022-07-06 17:50:44'),
(1,	15,	3,	1,	'STOCK ADJ - edit',	1,	'2022-06-23 07:14:24',	'2022-07-06 17:49:45'),
(1,	15,	6,	1,	'STOCK ADJ - datatable',	1,	'2022-07-06 17:39:39',	NULL),
(1,	15,	7,	1,	'STOCK ADJ - details',	1,	'2022-07-06 17:41:16',	NULL),
(1,	15,	8,	1,	'STOCK ADJ - autocomplete product',	1,	'2022-07-07 08:03:27',	NULL),
(1,	16,	2,	1,	'MANUAL list customer groups (admin default)',	1,	'2022-06-30 12:33:11',	'2022-06-30 14:53:29'),
(1,	16,	5,	1,	'CUSTOMER GROUP - dropdown',	1,	'2022-07-06 17:12:27',	NULL),
(1,	17,	2,	1,	'MANUAL genders (admin default)',	1,	'2022-07-02 13:02:09',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(175,	27,	1,	'2022-07-07',	'18:46:37',	NULL,	NULL,	'2022-07-07 13:16:41',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `stock_adjustment_product` (`id`, `stock_adjustment`, `product`, `note`, `quantity`) VALUES
(103,	104,	5,	'eqq',	4.0000),
(104,	104,	10,	'eqwe',	3.0000),
(105,	104,	6,	'wwqweqwe',	1.0000),
(106,	105,	161,	NULL,	-50.0000),
(107,	106,	173,	NULL,	4545.0000),
(108,	107,	174,	NULL,	3.0000),
(109,	108,	176,	NULL,	50.0000),
(110,	109,	180,	NULL,	10.0000),
(111,	110,	5,	NULL,	1.0000),
(112,	111,	5,	NULL,	1.0000),
(113,	112,	5,	NULL,	1.0000),
(114,	113,	5,	NULL,	1.0000),
(115,	114,	5,	NULL,	1.0000),
(116,	115,	5,	NULL,	1.0000),
(117,	116,	5,	NULL,	1.0000),
(118,	117,	5,	NULL,	1.0000),
(119,	118,	5,	NULL,	1.0000),
(120,	119,	186,	NULL,	2.0000),
(121,	120,	186,	NULL,	2.0000),
(122,	121,	5,	NULL,	5.0000),
(123,	122,	5,	NULL,	5.0000),
(124,	123,	5,	'sss',	1.0000),
(125,	124,	5,	NULL,	1.0000),
(126,	125,	5,	'htyh',	1.0000),
(127,	126,	10,	'aa',	1.0000),
(128,	126,	186,	'bb',	1.0000),
(129,	126,	5,	NULL,	1.0000),
(130,	127,	6,	'wa',	2.0000),
(131,	127,	10,	'k',	1.0000),
(132,	127,	5,	'c',	1.0000),
(133,	128,	6,	'w',	1.0000),
(134,	128,	10,	NULL,	1.0000),
(135,	128,	5,	'c',	1.0000),
(136,	129,	6,	'w',	1.0000),
(137,	129,	10,	NULL,	1.0000),
(138,	129,	5,	'c',	1.0000),
(139,	130,	6,	'w',	1.0000),
(140,	130,	10,	NULL,	1.0000),
(141,	130,	5,	'c',	1.0000),
(142,	131,	6,	'w',	1.0000),
(143,	131,	10,	NULL,	1.0000),
(144,	131,	5,	'c',	1.0000),
(145,	132,	6,	'w',	1.0000),
(146,	132,	10,	NULL,	1.0000),
(147,	132,	5,	'c',	1.0000),
(148,	133,	10,	NULL,	-1.0000),
(149,	133,	186,	NULL,	1.0000),
(150,	133,	5,	NULL,	1.0000),
(151,	134,	151,	NULL,	-5.0000),
(152,	134,	152,	NULL,	-4.0000),
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
(310,	175,	10,	NULL,	1.0000);

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(30) NOT NULL,
  `slug` varchar(30) NOT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `image` (`image`) USING HASH,
  KEY `sub_category_category` (`category`),
  CONSTRAINT `sub_category_category` FOREIGN KEY (`category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `sub_category` (`id`, `category`, `code`, `name`, `slug`, `image`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'B',	'Books',	'books',	NULL,	'fg fsf f ffdd',	'2021-01-24 05:50:07',	'2021-05-11 15:54:41',	NULL),
(2,	1,	'PS',	'Pencils',	'pencils',	NULL,	'g gfgfg g',	'2021-01-24 05:50:20',	'2021-05-11 15:50:05',	NULL),
(3,	2,	'SP',	'Seal Pad',	'seal-pad',	NULL,	'cxgfgfgfg',	'2021-01-24 06:00:56',	NULL,	NULL),
(4,	1,	'P',	'Pens',	'pens',	NULL,	'ggh gh',	'2021-01-24 14:45:20',	NULL,	NULL),
(5,	5,	'FB',	'Feeding Bottle',	'feeding-bottle',	NULL,	'fg rtgt t',	'2021-01-24 14:51:54',	NULL,	NULL),
(35,	1,	'erer',	'feer',	'werwe',	NULL,	'erw',	'2021-05-11 20:21:05',	NULL,	NULL),
(36,	1,	'gdfg',	'fgf',	'dfgd',	NULL,	'ddd',	'2021-05-11 20:48:11',	NULL,	NULL),
(37,	1,	't',	'sdfsdf',	'etr',	NULL,	'retrt',	'2021-05-11 21:42:22',	NULL,	NULL),
(38,	1,	'ee',	'ertert',	'retret',	NULL,	'ertertert',	'2021-05-11 21:49:22',	NULL,	NULL),
(39,	1,	'rty',	'rty',	'rty35',	NULL,	'534545',	'2021-05-11 22:17:01',	NULL,	NULL),
(40,	1,	'ryrt',	'tyrr',	'yrty',	NULL,	'tyrty',	'2021-05-19 20:59:33',	NULL,	NULL),
(41,	1,	'er',	'tyt',	'ytryrty',	NULL,	'tryrtyrty',	'2021-05-30 18:14:07',	NULL,	NULL),
(42,	4,	'xcvx',	'Mobiles',	'xcv',	NULL,	NULL,	'2021-10-11 16:55:34',	'2022-03-23 14:32:56',	NULL),
(43,	4,	'we',	'Smart TVs',	'ewewe',	NULL,	NULL,	'2022-03-23 14:33:10',	NULL,	NULL),
(44,	1,	'fa',	'TTT',	'tttgg',	NULL,	'fgfgfg',	'2022-04-03 10:34:49',	NULL,	NULL),
(45,	1,	'sf',	'QQQ',	'qqq',	NULL,	'jhjhh',	'2022-04-03 10:35:37',	NULL,	NULL),
(46,	5,	'fd',	'ghgg',	'ghgg',	NULL,	'gg',	'2022-04-03 10:36:32',	NULL,	NULL),
(47,	5,	'yr',	'yuyuyu',	'yuyuyu',	NULL,	NULL,	'2022-04-03 10:36:56',	NULL,	NULL),
(48,	2,	'gt',	'jkjkj',	'jkjkj',	NULL,	'ii',	'2022-04-03 10:38:28',	NULL,	NULL),
(49,	1,	'rr',	'trtrtr',	'trtrtr',	NULL,	NULL,	'2022-04-03 11:23:27',	NULL,	NULL),
(50,	1,	'tt',	'uyu',	'uyu',	NULL,	NULL,	'2022-04-03 11:59:58',	NULL,	NULL),
(51,	1,	'trt',	'uityr',	'uityr',	NULL,	'e',	'2022-04-03 12:02:34',	NULL,	NULL),
(52,	1,	'ag',	'tyty',	'tyty',	NULL,	NULL,	'2022-04-03 12:27:08',	NULL,	NULL),
(53,	1,	'lk',	'yettwt',	'yettwt',	NULL,	NULL,	'2022-04-03 12:28:08',	NULL,	NULL),
(54,	1,	'ww',	'yuyuyuy',	'yuyuyuy',	NULL,	'ytyty',	'2022-04-03 12:28:34',	NULL,	NULL),
(55,	1,	'eq',	'tytyty',	'tytyty',	NULL,	NULL,	'2022-04-03 12:29:12',	NULL,	NULL),
(56,	1,	'hh',	'tytrytry',	'tytrytry',	NULL,	'tytyyt',	'2022-04-03 12:29:30',	NULL,	NULL),
(57,	1,	'55',	'hjhgjgj',	'hjhgjgj',	NULL,	'tyty',	'2022-04-03 12:29:57',	NULL,	NULL),
(58,	1,	'ra',	'uyuyu',	'uyuyu',	NULL,	NULL,	'2022-04-03 12:33:11',	NULL,	NULL),
(59,	1,	'ttr',	'iuiu',	'iuiu',	NULL,	NULL,	'2022-04-03 12:33:42',	NULL,	NULL),
(60,	1,	'hxj',	'ioiuoio',	'ioiuoio',	NULL,	'uyuy',	'2022-04-03 12:34:13',	NULL,	NULL),
(61,	1,	'ahg',	'uyut',	'uyut',	NULL,	'yty',	'2022-04-03 12:34:38',	NULL,	NULL),
(62,	1,	'rw',	'kjkhkj',	'kjkhkj',	NULL,	'rtrt',	'2022-04-03 12:36:52',	NULL,	NULL),
(63,	1,	'rrr',	'uyi',	'uyi',	NULL,	NULL,	'2022-04-03 12:38:29',	NULL,	NULL),
(64,	1,	'65',	'uyiuyiyu',	'uyiuyiyu',	NULL,	NULL,	'2022-04-08 11:23:29',	NULL,	NULL),
(65,	1,	'54',	'yuiyiy',	'yuiyiy',	NULL,	'ytry',	'2022-04-08 11:24:13',	NULL,	NULL),
(66,	1,	'66',	'uouo',	'uouo',	NULL,	NULL,	'2022-04-08 11:25:14',	NULL,	NULL),
(67,	1,	'65464',	'666',	'666',	NULL,	NULL,	'2022-04-11 07:11:24',	NULL,	NULL),
(68,	54,	'ete',	'trret',	'trret',	NULL,	NULL,	'2022-04-12 10:31:20',	NULL,	NULL),
(69,	1,	'86886',	'787878',	'787878',	NULL,	NULL,	'2022-04-12 11:21:25',	NULL,	NULL),
(70,	1,	'uyyui',	'uyiyuiyuiyuiyui',	'uyiyuiyuiyuiyui',	NULL,	NULL,	'2022-04-15 11:52:11',	NULL,	NULL);

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
(83,	'SUPP0083',	'fgdfg',	'fdgdg',	NULL,	NULL,	NULL,	'45546',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 12:25:23',	'2022-07-01 14:14:35',	NULL),
(86,	'SUPP0086',	'ytyty',	'rtty',	NULL,	NULL,	NULL,	'6545445',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:25:10',	'2022-07-01 14:14:35',	NULL),
(87,	'SUPP0087',	'rt5rt56546',	'565656544',	NULL,	NULL,	NULL,	'65654656',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:25:18',	'2022-07-01 14:14:35',	NULL),
(88,	'SUPP0088',	'tryt',	'rwrr5',	NULL,	NULL,	NULL,	'53535355',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:30:51',	'2022-07-01 14:14:35',	NULL),
(89,	'SUPP0089',	'eeeeeeeeee',	'rrrrrrrrrrr',	NULL,	NULL,	NULL,	'6664564564',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:31:29',	'2022-07-01 14:14:35',	NULL),
(90,	'SUPP0090',	'tyryrty',	'rty6575',	NULL,	NULL,	NULL,	'5764465656',	NULL,	NULL,	NULL,	'987',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:33:00',	'2022-07-01 14:14:35',	NULL),
(91,	'SUPP0091',	'ryrtyrty',	'tyrytry',	NULL,	NULL,	NULL,	'564335466',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:00',	'2022-07-01 14:14:35',	NULL),
(92,	'SUPP0092',	'utyu6',	'7576',	NULL,	NULL,	NULL,	'4368455447',	NULL,	NULL,	NULL,	'uiouo9',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:12',	'2022-07-01 14:19:54',	'2022-07-01 14:19:54'),
(93,	'SUPP0093',	'fggfg',	'gfdsser',	NULL,	NULL,	NULL,	'0000000000000',	NULL,	NULL,	NULL,	'o88',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:25',	'2022-07-01 14:19:30',	'2022-07-01 14:19:30'),
(94,	'SUPP0094',	'tyutyu',	'yuytuytu',	NULL,	NULL,	NULL,	'565655757',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:35:16',	'2022-07-01 14:18:00',	'2022-07-01 14:18:00'),
(95,	'SUPP0095',	'uytutyu',	'tutyutyutu',	NULL,	NULL,	NULL,	'123456',	NULL,	'\'\'\'',	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:35:31',	'2022-07-01 14:16:33',	'2022-07-01 14:16:33'),
(100,	'SUPP0100',	'`6r7yrtyty',	'ttyty',	NULL,	NULL,	NULL,	'56464656',	NULL,	NULL,	NULL,	'jtt',	NULL,	NULL,	'ACTIVE',	'2022-06-30 04:08:35',	'2022-07-01 14:15:48',	'2022-07-01 14:15:48'),
(102,	'SUPP0102',	'ghfhgfh g',	'tteerr',	'aaa',	123,	'tgft',	'77575547',	'ff@ds.fg',	'eee',	'jjj',	'dddydo',	0,	0,	'ACTIVE',	'2022-06-30 05:45:45',	'2022-07-01 14:14:35',	NULL),
(103,	'SUPP0103',	'aaa',	'bbb',	NULL,	NULL,	NULL,	'111111',	NULL,	NULL,	NULL,	'dfdt',	NULL,	NULL,	'ACTIVE',	'2022-06-30 05:55:00',	'2022-07-01 14:14:59',	'2022-07-01 14:14:59'),
(104,	'SUPP0104',	'aaa',	'bbb',	NULL,	NULL,	NULL,	'1111111',	NULL,	NULL,	NULL,	'aaaa',	NULL,	NULL,	'ACTIVE',	'2022-06-30 06:01:54',	'2022-07-06 16:56:31',	'2022-07-06 16:56:31'),
(105,	'SUPP0105',	'hjguj',	'gujyuyu',	NULL,	NULL,	NULL,	'56565656',	NULL,	NULL,	NULL,	'lll',	NULL,	NULL,	'ACTIVE',	'2022-06-30 06:40:53',	'2022-07-01 14:21:34',	NULL),
(106,	'SUPP0106',	'0909808',	'789789879',	NULL,	NULL,	NULL,	'654656565',	NULL,	NULL,	NULL,	'iouioiuoio',	NULL,	NULL,	'ACTIVE',	'2022-06-30 08:03:33',	'2022-07-01 14:22:02',	NULL),
(107,	'SUPP0107',	'yuyu',	'uytuytu',	NULL,	NULL,	'yhgfhgh',	'4645645646',	'ghgf@fgcfgg.hjkhgk',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-07-06 16:51:58',	NULL,	NULL);

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
  `type` enum('P','F') NOT NULL DEFAULT 'P',
  `description` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tax_rate` (`id`, `code`, `name`, `rate`, `type`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'GST10',	'GST',	10.0000,	'P',	NULL,	'2021-03-02 14:12:44',	'2021-04-12 13:49:32',	NULL),
(2,	'IGST2',	'IGST',	2.1300,	'P',	'sdsdsdd',	'2021-03-02 14:12:44',	'2021-05-08 17:06:45',	NULL),
(3,	'VAT',	'VAT',	10.5000,	'P',	NULL,	'2021-03-02 14:12:44',	NULL,	NULL),
(137,	'44',	'test',	6.0000,	'P',	NULL,	'2022-04-08 05:25:21',	NULL,	NULL),
(138,	'55',	'yiyu',	56.0000,	'P',	NULL,	'2022-04-08 05:57:07',	NULL,	NULL),
(139,	'de',	'45545',	3.0000,	'P',	NULL,	'2022-04-08 05:57:16',	NULL,	NULL),
(140,	'ee',	'ghfgh',	4.0000,	'P',	NULL,	'2022-04-08 06:01:20',	NULL,	NULL),
(141,	'e3',	'dgdfgd',	3.0000,	'P',	NULL,	'2022-04-08 10:36:29',	NULL,	NULL),
(183,	'4e',	'TTT',	3.0000,	'P',	NULL,	'2022-04-11 07:33:07',	NULL,	NULL),
(184,	'rwewr',	'333',	23.0000,	'P',	NULL,	'2022-04-11 07:33:32',	NULL,	NULL),
(185,	'te',	'fhfgh',	3.0000,	'P',	NULL,	'2022-04-11 12:13:10',	NULL,	NULL),
(186,	'22',	'w345325',	31.0000,	'P',	NULL,	'2022-04-12 06:37:36',	NULL,	NULL);

DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` varchar(30) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `unit` (`id`, `code`, `name`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'PC',	'Piece',	'md df d',	'2021-01-24 06:02:13',	NULL,	NULL),
(38,	'mtr',	'Meter',	'dsfsf',	'2021-04-18 19:00:13',	NULL,	NULL),
(39,	'rtert',	'et',	'tretrt',	'2021-04-18 19:09:37',	NULL,	NULL),
(40,	'sd',	'sdf',	'dfsdfsdf',	'2021-04-18 19:10:12',	NULL,	NULL),
(41,	'fg',	'dfgfg',	'fgfgfg',	'2021-04-18 19:10:40',	NULL,	NULL),
(42,	'fdgf',	'dfg',	'gfddfg',	'2021-04-18 19:11:26',	NULL,	NULL),
(92,	'dsfsd',	'sdfsdf9',	'sdfsdf',	'2021-05-11 22:14:33',	NULL,	NULL),
(163,	'uyiui',	'yuiuyi',	'dfdf',	'2022-04-15 11:44:48',	NULL,	NULL);

DROP TABLE IF EXISTS `unit_bulk`;
CREATE TABLE `unit_bulk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(15) NOT NULL,
  `description` varchar(30) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit` (`unit`) USING BTREE,
  CONSTRAINT `unit_bulk-unit` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `unit_bulk` (`id`, `unit`, `value`, `code`, `name`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(38,	1,	10,	'10b',	'Box of 10',	NULL,	'2021-04-18 15:16:00',	NULL,	NULL),
(39,	1,	5535,	'dsf',	'dsf',	'ert',	'2021-04-18 18:58:09',	NULL,	NULL),
(70,	1,	6,	'fgh',	'rrr',	NULL,	'2022-04-15 05:52:47',	NULL,	NULL),
(71,	1,	6,	'fc',	'ttt',	NULL,	'2022-04-15 05:55:13',	NULL,	NULL),
(72,	1,	34,	'aa',	'ggg',	NULL,	'2022-04-15 05:57:14',	NULL,	NULL),
(73,	1,	565,	'r5',	'tyty',	NULL,	'2022-04-15 05:58:17',	NULL,	NULL),
(74,	1,	4,	'qq',	'qqq',	NULL,	'2022-04-15 06:06:01',	NULL,	NULL),
(75,	1,	5,	'ss',	'sss',	NULL,	'2022-04-15 06:06:34',	NULL,	NULL),
(76,	1,	5,	'jjj',	'jjj',	NULL,	'2022-04-15 06:07:38',	NULL,	NULL),
(77,	1,	4,	'gfdfg',	'gdfg',	NULL,	'2022-04-15 06:10:56',	NULL,	NULL),
(78,	1,	4545,	'efg',	'kkk',	NULL,	'2022-04-15 06:19:22',	NULL,	NULL),
(79,	1,	5,	'ggg4',	'ddd',	NULL,	'2022-04-15 06:19:49',	NULL,	NULL),
(80,	1,	45,	'fhgf',	'yyy',	NULL,	'2022-04-15 11:40:55',	NULL,	NULL),
(81,	1,	554545,	'ghghgh',	'etttrt',	NULL,	'2022-04-15 11:45:34',	NULL,	NULL),
(82,	1,	2147483647,	'ffdgdfgdfg',	'dgfdgd',	NULL,	'2022-04-26 12:19:59',	NULL,	NULL),
(83,	1,	3,	'fgd',	'erewrer',	NULL,	'2022-04-26 12:21:13',	NULL,	NULL);

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
(1,	'C1',	1,	'admin',	'$2y$10$6XeS4Sx0lGQzUWsqoSqaDOsaoM2wSVQAmDQg4viwBD4b5WAFw4SBu',	'Samnad',	'S',	'Cna',	'1992-10-30',	'admin@example.com',	'+91-0000000012',	NULL,	1,	'India',	'TVM',	'Trivandrum',	'695505',	'CyberLikes Pvt. Ltd.',	'something',	3,	0,	0,	'::1',	'2022-07-07 12:59:47',	'2022-07-05 03:46:37',	'2021-04-20 19:22:52',	'2022-07-07 12:59:47',	NULL),
(30,	'C2',	3,	'neo',	'$2y$10$KcBcIiTPhlaPmKDiuQmz/OzryKE4ZPgWf/ddgyCvmkXSHevNGeqL6',	'Neo',	'Andrew',	'And & Co.',	'2022-07-06',	'and@eff.c',	'5641511',	NULL,	1,	'Indo',	'Jarka',	'Imania',	'6950505',	'Feans Palace\r\nNew York',	'Something special',	15,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:20:23',	'2022-07-07 13:21:24',	NULL),
(31,	'C3',	2,	'markz',	'$2y$10$MwP6iXVdi0VrykbSVOq0EeL7L5x2YOnyrOUZZMIsPPLUjRgO2jLv.',	'Mark',	'Zuck',	'Meta',	'2022-07-20',	'mark@fb.com',	'61515141466',	NULL,	3,	'USA',	'Los Angels',	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:26:49',	'2022-07-04 12:54:45',	NULL),
(32,	'C4',	3,	'errerer',	'$2y$10$w/w8b2bLPzlFFw9mb3.abuYyyRhoQfGh24YPRwYhdWVNX5lbQV5Ja',	'ytyty',	'tytyty',	NULL,	'2022-07-14',	'gfgfg@f.ghgh',	'4454545445',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-03 10:38:07',	'2022-07-04 13:43:00',	'2022-07-04 13:43:00'),
(33,	'USER0033',	1,	'sfdfdsf',	'$2y$10$m3SCyOOEBf9x7zHoJD5nkuajcLI0MqPypDIsXo0zVE6pKwZ9ebP3u',	'dfdfsdf',	NULL,	NULL,	'2022-07-26',	'safdf@fdsfgdfg.ghgfh',	'7475454545',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 12:57:40',	'2022-07-06 16:37:47',	'2022-07-06 16:37:47'),
(34,	'USER0034',	1,	'sdfsdfsdf',	'$2y$10$X5g0UY6y6ciaAxYoHj//CeuwoWdwZ5S2v8qgVUAOyB.dirVZI1uyC',	'sdfdf',	'dfdfdsf',	NULL,	'2022-07-05',	'trt@ghjhg.fghfh',	'444544545',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 13:09:49',	'2022-07-06 16:37:07',	'2022-07-06 16:37:07'),
(35,	'USER0035',	3,	'hjhgjhg',	'$2y$10$vUGaJ4qQGg7yHt1hbP9eZOIFzL5SHX.ynu.w.EUwiiZIlUFJMbSoi',	'gikghjg',	'jghjghjhgj',	NULL,	'2022-07-05',	'fdf@g.ghgh',	'7574544454',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-06 16:38:36',	NULL,	NULL),
(36,	'USER0036',	3,	'dfdf',	'$2y$10$728Kvxh9olwHyXoUQ4Lq.e7aALAXdOO/s4zy3SNwi3464CYTWYfFS',	'dfdf',	'dfdfd',	NULL,	'2022-07-05',	'dfd@fsg.gdfgg',	'546464645645',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'::1',	'2022-07-07 07:50:50',	NULL,	'2022-07-06 16:45:10',	'2022-07-07 07:50:50',	'2022-07-06 16:45:25'),
(37,	'USER0037',	3,	'dfdfdf',	'$2y$10$.eYvj6.BMLYuGUDvlwSLnO4ZzR8OO8.SpB7Z/mR45zZUWIo/GJbMG',	'yuytuytu',	'ytuytu',	NULL,	'2022-07-12',	'ds@rtg.jghjg',	'5646456456',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-07 13:22:05',	NULL,	NULL);

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
(20,	'WARE0020',	'CyberKids',	'dsds',	'2020-02-12',	'India',	'TVM',	'695505',	'+91-9745451448',	'tewest@gmail.com',	'TVM',	NULL,	NULL,	'Desc',	19,	'Flood',	NULL,	NULL,	'2021-04-14 19:54:53',	'2022-07-05 12:48:00',	NULL),
(27,	'WARE0027',	'Test',	'KMD',	'2022-07-01',	'Innnn',	'Ciiiii',	NULL,	'9745451448',	'sdsds@g.ghh',	'Addddddd',	NULL,	NULL,	'Desssssssssss',	19,	'Some',	NULL,	NULL,	'2022-07-05 12:01:17',	'2022-07-05 12:49:13',	NULL),
(28,	'WARE0028',	'cvccvcx',	'ggfdgfgfg',	'2022-07-01',	NULL,	NULL,	NULL,	'646665465',	'gfgg@f.ghgh',	NULL,	NULL,	NULL,	'opopj',	19,	'fgfgfg',	NULL,	NULL,	'2022-07-05 12:31:47',	'2022-07-06 17:26:38',	NULL),
(30,	'WARE0030',	'ouioiuo',	'uiouio',	'2022-07-02',	NULL,	NULL,	NULL,	'5565656',	'ff@g.yty',	NULL,	NULL,	NULL,	NULL,	18,	'iuoiuoi',	NULL,	NULL,	'2022-07-05 12:35:29',	'2022-07-06 17:24:59',	'2022-07-06 17:24:59'),
(31,	'WARE0031',	'jhjhgjgjhg',	'jhgjhgjhgj',	'2022-07-01',	NULL,	NULL,	NULL,	'56565656',	'fgf@dy.hjgj',	NULL,	NULL,	NULL,	NULL,	16,	'hjhj',	NULL,	NULL,	'2022-07-05 12:36:57',	NULL,	NULL),
(32,	'WARE0032',	'uiuiui',	'uiuiuiuiu',	'2022-07-06',	NULL,	NULL,	NULL,	'4545454',	'ui@gf.ghgh',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-07-06 17:24:34',	NULL,	NULL);

-- 2022-07-07 17:17:50
