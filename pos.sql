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
  `description` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `image` (`image`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `brand` (`id`, `code`, `name`, `image`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'L',	'Lexi',	NULL,	'yggp=',	'2021-01-24 06:01:28',	'2021-04-21 17:49:35',	NULL),
(3,	'CM',	'Camlin',	NULL,	'gjfjsd sg fpt',	'2021-01-24 06:01:54',	'2021-05-08 17:54:24',	NULL),
(67,	'ew',	'rere',	NULL,	'wqq6',	'2021-04-23 18:17:49',	'2021-04-23 18:19:48',	NULL),
(69,	'ry',	'lexi6',	NULL,	'7u7',	'2021-04-23 20:11:19',	NULL,	NULL),
(70,	'df',	'df',	NULL,	'dfdf',	'2021-04-30 07:01:19',	NULL,	NULL),
(72,	'yuyu',	'ty',	NULL,	'ytu',	'2021-05-08 18:00:04',	NULL,	NULL),
(73,	'fgdfg',	'gfg',	NULL,	'dgddd',	'2021-05-11 20:48:27',	NULL,	NULL),
(74,	'werwer',	'wer',	NULL,	'werwr',	'2021-05-11 20:52:34',	NULL,	NULL),
(75,	'try',	'rty',	NULL,	'rtyrty',	'2021-05-11 20:52:49',	NULL,	NULL),
(76,	'ytr',	'ryrty',	NULL,	'rtyrtyy',	'2021-05-11 20:53:39',	NULL,	NULL),
(77,	'7567',	'756',	NULL,	'676',	'2021-05-11 22:17:08',	NULL,	NULL),
(78,	'567',	'567',	NULL,	'657567',	'2021-05-17 19:12:50',	NULL,	NULL),
(81,	'ty',	'ytuty',	NULL,	't76878',	'2021-08-19 19:54:10',	NULL,	NULL),
(82,	'9879',	'8',	NULL,	'789',	'2021-08-19 19:54:19',	NULL,	NULL),
(83,	'uyy',	'ooipo',	NULL,	NULL,	'2022-04-05 10:50:58',	NULL,	NULL),
(84,	'cc',	'Apple',	NULL,	NULL,	'2022-04-05 10:51:12',	NULL,	NULL),
(85,	'n,m',	'nm,n,m',	NULL,	NULL,	'2022-04-05 12:24:24',	NULL,	NULL),
(86,	'ff',	'yhgfhgf',	NULL,	NULL,	'2022-04-06 13:38:00',	NULL,	NULL),
(87,	'3d',	'dgdfg',	NULL,	NULL,	'2022-04-11 07:18:03',	NULL,	NULL),
(88,	'dfs',	'fdf',	NULL,	NULL,	'2022-04-11 07:20:05',	NULL,	NULL),
(89,	'gr4',	'hgjghj',	NULL,	NULL,	'2022-04-11 07:22:34',	NULL,	NULL),
(90,	'56',	'uiouio',	NULL,	NULL,	'2022-04-11 07:22:57',	NULL,	NULL),
(91,	'3f',	'trtert',	NULL,	NULL,	'2022-04-11 07:41:22',	NULL,	NULL),
(92,	'45d',	'rttrt',	NULL,	NULL,	'2022-04-11 07:41:30',	NULL,	NULL),
(93,	's2',	'dsfsdf',	NULL,	NULL,	'2022-04-11 07:42:30',	NULL,	NULL),
(94,	'34',	'sdfdfs',	NULL,	NULL,	'2022-04-12 10:24:58',	NULL,	NULL),
(95,	'es3',	'dgfg',	NULL,	NULL,	'2022-04-12 10:25:35',	NULL,	NULL),
(96,	'sdsd',	'sss',	NULL,	NULL,	'2022-04-12 10:27:15',	NULL,	NULL),
(97,	'fsdfsf',	'sssw',	NULL,	NULL,	'2022-04-12 10:30:26',	NULL,	NULL),
(98,	'fgfg',	'vbvbvb',	NULL,	'fgfg',	'2022-04-12 11:57:25',	NULL,	NULL),
(99,	'ytyytyr',	'tytyt',	NULL,	NULL,	'2022-04-12 11:57:32',	NULL,	NULL),
(100,	'5656',	'yyy',	NULL,	NULL,	'2022-04-14 08:33:54',	NULL,	NULL),
(101,	'tyty',	'ghjghjghj',	NULL,	NULL,	'2022-04-15 10:54:52',	NULL,	NULL),
(102,	'hfghfgh',	'fghgf',	NULL,	NULL,	'2022-04-15 10:55:08',	NULL,	NULL),
(103,	'fhhgh',	'ghfghf',	NULL,	NULL,	'2022-04-15 10:57:34',	NULL,	NULL),
(104,	'gdfg',	'ggg',	NULL,	NULL,	'2022-04-15 10:59:04',	NULL,	NULL),
(105,	'bnvbnvbn',	'vnvbnvbn',	NULL,	NULL,	'2022-04-15 11:09:17',	NULL,	NULL),
(106,	'uyuj',	'jhkhkjhkhjkjhk',	NULL,	NULL,	'2022-04-15 11:13:00',	NULL,	NULL),
(107,	'fgf',	'ggfgfg',	NULL,	NULL,	'2022-04-15 11:43:26',	NULL,	NULL);

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
  `group` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `place` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
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

INSERT INTO `customer` (`id`, `group`, `name`, `place`, `email`, `phone`, `address`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	3,	'Walk-In Customer',	'USA',	'example@ex.com',	'+91-123',	'Kerala',	0,	0,	'ACTIVE',	'2021-04-29 06:39:48',	'2021-08-18 19:22:02',	NULL),
(18,	2,	'rty',	'ryrty',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2021-05-07 18:55:51',	'2021-08-18 19:08:18',	NULL),
(19,	3,	'retrrtrt',	'ert',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2021-05-07 19:02:54',	'2021-05-07 19:52:40',	NULL),
(26,	2,	'ewrwer',	'werer',	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2021-05-07 19:52:35',	NULL,	NULL);

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `module` (`id`, `name`) VALUES
(3,	'brand'),
(2,	'category'),
(7,	'customer'),
(14,	'label'),
(11,	'pos'),
(1,	'product'),
(10,	'role'),
(15,	'stock_adjustment'),
(6,	'supplier'),
(13,	'symbology'),
(4,	'tax'),
(12,	'type'),
(5,	'unit'),
(8,	'user'),
(9,	'warehouse');

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
(1,	'POST',	'2021-05-07 16:33:13',	'2021-07-31 18:40:05'),
(2,	'GET',	'2021-05-07 16:33:28',	'2021-07-31 18:40:10'),
(3,	'PUT',	'2021-05-07 16:33:34',	'2021-07-31 18:40:31'),
(4,	'DELETE',	'2021-05-07 16:33:39',	'2021-07-31 18:40:36'),
(5,	'LIST',	'2021-08-02 18:46:06',	'2021-08-02 21:51:22'),
(6,	'TEST',	'2021-08-07 19:31:59',	NULL);

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
  `profit_margin` decimal(10,4) DEFAULT 0.0000,
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
  `custom_tax` tinyint(1) DEFAULT NULL,
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
  CONSTRAINT `product-symbology` FOREIGN KEY (`symbology`) REFERENCES `symbology` (`id`),
  CONSTRAINT `product-tax_rate` FOREIGN KEY (`tax_rate`) REFERENCES `tax_rate` (`id`),
  CONSTRAINT `product-unit` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`),
  CONSTRAINT `product-unit_bulk1` FOREIGN KEY (`p_unit`) REFERENCES `unit_bulk` (`id`),
  CONSTRAINT `product-unit_bulk2` FOREIGN KEY (`s_unit`) REFERENCES `unit_bulk` (`id`),
  CONSTRAINT `price_check` CHECK (`price` <= `mrp`),
  CONSTRAINT `pos_max_sale_qty_check` CHECK (`pos_max_sale_qty` >= `pos_min_sale_qty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product` (`id`, `type`, `code`, `symbology`, `name`, `slug`, `thumbnail`, `weight`, `category`, `sub_category`, `brand`, `unit`, `p_unit`, `s_unit`, `is_auto_cost`, `cost`, `mrp`, `profit_margin`, `price`, `auto_discount`, `mfg_date`, `exp_date`, `tax_method`, `tax_rate`, `quantity`, `alert`, `alert_quantity`, `pos_sale`, `custom_discount`, `custom_tax`, `pos_min_sale_qty`, `pos_max_sale_qty`, `pos_sale_note`, `pos_custom_discount`, `pos_custom_tax`, `pos_data_field_1`, `pos_data_field_2`, `pos_data_field_3`, `pos_data_field_4`, `pos_data_field_5`, `pos_data_field_6`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'37519985',	1,	'King Book',	'king-book',	'https://www.escoffier.edu/wp-content/uploads/reading-is-a-great-way-to-continue-your-growth-as-a-chef_1028_40137340_1_14130186_500.jpg',	NULL,	1,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	35.0000,	0.0000,	30.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:30',	'2021-04-03 23:59:43',	NULL),
(2,	1,	'62305684',	1,	'Long Book',	'long-book',	'https://3ner1e34iilsjdn1qohanunu-wpengine.netdna-ssl.com/wp-content/uploads/2014/11/82175.jpg',	NULL,	1,	1,	3,	1,	NULL,	NULL,	'1',	NULL,	50.0000,	0.0000,	45.0000,	1.0000,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:14:54',	'2021-04-04 00:00:25',	NULL),
(3,	1,	'25171014',	1,	'Pen 0.7mm',	'pen-0-7mm',	'https://www.proimprint.com/image/cache/data/KEYCHAINS-OPENERS/Promotional-Keychains-Openers/Custom-Logo-Imprinted-Plastic-Keychains/Customized-Roslin-Stylus-Pens-500x500.jpg',	NULL,	1,	4,	1,	1,	NULL,	NULL,	'1',	NULL,	NULL,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-28',	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:15:37',	'2021-04-04 00:02:04',	NULL),
(4,	1,	'80493457',	1,	'Stylish',	'stylish',	'https://5.imimg.com/data5/GK/JK/MY-45473441/stylish-pen-500x500.jpg',	NULL,	1,	4,	NULL,	1,	NULL,	NULL,	'1',	NULL,	5.0000,	0.0000,	5.0000,	NULL,	NULL,	'2021-01-06',	'E',	NULL,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:17:04',	NULL,	NULL),
(5,	1,	'38644788',	1,	'Couple Photo Frame',	'couple-photo-frame',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7iyBDZf-tfvjCrGwONFuvg3Wj33FJ8xrsBg&usqp=CAU',	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	NULL,	300.0000,	0.0000,	200.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:18:37',	NULL,	NULL),
(6,	1,	'94426911',	1,	'Wall Clock',	'wall-clock',	'https://images-na.ssl-images-amazon.com/images/I/51VjOomhxoL._SY355_.jpg',	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'0',	300.0000,	NULL,	0.0000,	570.0000,	NULL,	NULL,	NULL,	'E',	2,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:19:09',	NULL,	NULL),
(10,	1,	'39741136',	1,	'Keyboard Mouse Combo',	'keyboard-mouse-combo',	'https://images-na.ssl-images-amazon.com/images/I/619gY3%2BheVL._SL1000_.jpg',	NULL,	4,	NULL,	1,	1,	NULL,	NULL,	'1',	NULL,	4500.0000,	0.0000,	1000.0000,	250.0000,	NULL,	NULL,	'I',	2,	0.0000,	'1',	3,	NULL,	NULL,	NULL,	0.0000,	0.0000,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-01-24 20:23:19',	NULL,	NULL),
(149,	1,	'56904366',	1,	'fhfgh',	'fghetrty',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:05',	NULL,	NULL),
(150,	1,	'65640426',	1,	'gdgserer',	'dfghfhdh',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-19 02:22:22',	NULL,	NULL),
(151,	1,	'78154768',	1,	'tyur',	'urutyutyuytu',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-24 02:14:50',	NULL,	NULL),
(152,	1,	'86112495',	1,	'ertert',	'rreyryryy',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2021-10-25 00:30:23',	NULL,	NULL),
(161,	1,	'63886634',	1,	'78768',	'6787688',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-11 16:55:30',	NULL,	NULL),
(165,	1,	'27144759',	1,	'dffsfsf',	'dffsfsf',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	3.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	0,	NULL,	NULL,	NULL,	NULL,	0,	0,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-12 17:31:44',	NULL,	NULL),
(173,	1,	'48386886',	1,	'dfgdfgdfgdfg',	'tert',	NULL,	NULL,	1,	NULL,	1,	1,	NULL,	NULL,	'1',	50.0000,	NULL,	50.0000,	75.0000,	0.0000,	NULL,	NULL,	'E',	1,	0.0000,	'1',	3,	0,	NULL,	NULL,	NULL,	NULL,	0,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:06',	NULL,	NULL),
(174,	1,	'33267747',	1,	'etertet',	'etertet',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	33.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	0,	'Serial No.',	'Serial No.',	NULL,	NULL,	NULL,	NULL,	'2022-04-14 17:00:29',	NULL,	NULL),
(176,	1,	'23556049',	1,	'Dell Monotor',	'dell-monotor',	NULL,	NULL,	4,	43,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	35000.0000,	NULL,	NULL,	NULL,	'I',	1,	0.0000,	'1',	10,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-18 13:03:23',	NULL,	NULL),
(177,	1,	'47204470',	1,	'uiuiiui',	'uiuiiui',	NULL,	NULL,	1,	NULL,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	44.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'0',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-23 16:32:25',	NULL,	NULL),
(178,	1,	'80896616',	1,	'test',	'test',	NULL,	NULL,	1,	4,	NULL,	1,	NULL,	NULL,	'1',	NULL,	NULL,	50.0000,	50.0000,	NULL,	NULL,	NULL,	'I',	NULL,	0.0000,	'1',	5,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	0,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-04-26 13:00:43',	NULL,	NULL),
(180,	1,	'54805482',	1,	'Name 1',	'name-1',	NULL,	NULL,	1,	1,	1,	1,	NULL,	NULL,	'1',	NULL,	500.0000,	50.0000,	50.0000,	5.0000,	NULL,	NULL,	'I',	1,	0.0000,	'1',	20,	1,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	'Serial No.',	'Color',	'3',	'4',	'5',	'6',	'2022-04-26 16:14:34',	NULL,	NULL);

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

INSERT INTO `product_stock` (`id`, `product`, `warehouse`, `quantity`, `added_at`, `updated_at`) VALUES
(16,	149,	20,	10.0000,	'2021-10-18 20:52:05',	NULL),
(17,	150,	22,	25.0000,	'2021-10-18 20:52:22',	NULL),
(18,	149,	22,	35.0000,	'2021-10-18 20:52:05',	NULL),
(21,	150,	20,	147.0000,	'2021-10-18 20:52:22',	NULL),
(22,	151,	20,	-55.0000,	'2021-10-23 20:44:50',	NULL),
(23,	152,	20,	10.0000,	'2021-10-24 19:00:23',	NULL),
(24,	161,	20,	-50.0000,	'2022-04-11 11:25:30',	NULL),
(25,	173,	20,	4545.0000,	'2022-04-14 11:30:06',	NULL),
(26,	174,	20,	3.0000,	'2022-04-14 11:30:29',	NULL),
(27,	176,	20,	50.0000,	'2022-04-18 07:33:23',	NULL),
(28,	180,	20,	10.0000,	'2022-04-26 10:44:34',	NULL);

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
  `deletable` tinyint(1) NOT NULL DEFAULT 1,
  `limit` int(11) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='This is user groups';

INSERT INTO `role` (`id`, `name`, `description`, `editable`, `updatable_rights`, `deletable`, `limit`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Administrator',	'All permissions allowed.',	0,	0,	0,	1,	'2021-04-21 00:19:28',	'2021-08-18 01:33:12',	NULL),
(2,	'Seller',	'Sales permissions.',	1,	1,	1,	2,	'2021-04-21 00:21:17',	'2021-08-18 01:30:12',	NULL),
(3,	'Purchaser',	'Purchase permissions.',	1,	1,	1,	1,	'2021-04-21 00:21:35',	'2021-08-18 01:30:26',	NULL),
(19,	'test',	'test',	1,	1,	1,	3,	'2021-08-15 23:49:29',	'2021-08-18 01:30:49',	NULL);

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission` (
  `role_id` int(11) NOT NULL,
  `readonly` tinyint(1) DEFAULT NULL COMMENT 'no changes can be made from ui',
  `comment` varchar(100) DEFAULT NULL,
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `allow` tinyint(1) DEFAULT 0,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `role_id_module_id_permission_id` (`role_id`,`module_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`),
  CONSTRAINT `role_permission_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Rows with readonly flag are read only or manually added rows ';

INSERT INTO `role_permission` (`role_id`, `readonly`, `comment`, `module_id`, `permission_id`, `allow`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	NULL,	1,	1,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	1,	2,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	1,	3,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	1,	4,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	2,	1,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	2,	2,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	2,	3,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	2,	4,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	3,	1,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	3,	2,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	3,	3,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	3,	4,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	4,	1,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	4,	2,	1,	'2021-09-29 18:24:04',	NULL,	NULL),
(1,	NULL,	NULL,	4,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	4,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	5,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	5,	2,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	5,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	5,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	6,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	6,	2,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	6,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	6,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	7,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	7,	2,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	7,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	7,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	8,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	8,	2,	1,	'2021-09-29 18:24:05',	'2021-10-24 18:49:57',	NULL),
(1,	NULL,	NULL,	8,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	8,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	9,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	9,	2,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	9,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	9,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	10,	1,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	10,	2,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	10,	3,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	NULL,	NULL,	10,	4,	1,	'2021-09-29 18:24:05',	NULL,	NULL),
(1,	1,	'MANUAL (pos list product)',	11,	2,	1,	'2021-09-29 18:30:33',	NULL,	NULL),
(1,	1,	'MANUAL (list product types)',	12,	2,	1,	'2021-09-23 17:49:34',	'2021-10-18 19:55:23',	NULL),
(1,	1,	'MANUAL (list barcode symbs)',	13,	2,	1,	'2021-09-23 18:02:55',	'2021-09-29 17:50:05',	NULL),
(1,	1,	'MANUAL (print barcode or label)',	14,	2,	1,	'2021-10-01 18:16:31',	NULL,	NULL),
(1,	1,	'MANUAL (stock adj list new)',	15,	1,	1,	'2021-10-29 17:45:44',	NULL,	NULL),
(1,	1,	'MANUAL (stock adj list)',	15,	2,	1,	'2021-10-20 20:11:57',	'2021-10-24 18:51:37',	NULL),
(19,	NULL,	NULL,	4,	1,	1,	'2021-09-28 18:09:05',	NULL,	NULL);

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `status` (`id`, `name`) VALUES
(1,	'online'),
(2,	'offline'),
(3,	'active'),
(4,	'inactive'),
(5,	'pending'),
(6,	'paid'),
(7,	'unpaid'),
(8,	'ordered'),
(9,	'packed'),
(10,	'shipped'),
(11,	'returned'),
(12,	'partially paid'),
(13,	'expired');

DROP TABLE IF EXISTS `stock_adjustment`;
CREATE TABLE `stock_adjustment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
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

INSERT INTO `stock_adjustment` (`id`, `warehouse`, `added_by`, `date`, `reference_no`, `note`, `added_at`, `updated_at`, `deleted_at`) VALUES
(104,	20,	1,	'2021-10-30 20:52:14',	NULL,	NULL,	'2021-10-30 18:52:14',	NULL,	NULL),
(105,	20,	1,	'2022-04-11 13:25:30',	NULL,	NULL,	'2022-04-11 11:25:30',	NULL,	NULL),
(106,	20,	1,	'2022-04-14 13:30:06',	NULL,	NULL,	'2022-04-14 11:30:06',	NULL,	NULL),
(107,	20,	1,	'2022-04-14 13:30:29',	NULL,	NULL,	'2022-04-14 11:30:29',	NULL,	NULL),
(108,	20,	1,	'2022-04-18 09:33:23',	NULL,	NULL,	'2022-04-18 07:33:23',	NULL,	NULL),
(109,	20,	1,	'2022-04-26 12:44:34',	NULL,	NULL,	'2022-04-26 10:44:34',	NULL,	NULL);

DROP TABLE IF EXISTS `stock_adjustment_product`;
CREATE TABLE `stock_adjustment_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_adjustment` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `quantity` decimal(10,4) NOT NULL,
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
(105,	104,	6,	'wwqweqwe',	2.0000),
(106,	105,	161,	NULL,	-50.0000),
(107,	106,	173,	NULL,	4545.0000),
(108,	107,	174,	NULL,	3.0000),
(109,	108,	176,	NULL,	50.0000),
(110,	109,	180,	NULL,	10.0000);

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
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
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
(34,	'SUPP0034',	'rgrtre',	'tert',	NULL,	NULL,	NULL,	'54545',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2021-08-19 20:50:45',	'2021-09-30 19:16:05',	NULL),
(35,	'SUPP0035',	'werwr',	'ewrtewtrwet',	NULL,	NULL,	NULL,	'5335',	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'ACTIVE',	'2021-08-19 20:50:53',	'2021-09-30 19:16:05',	NULL),
(36,	'SUPP0036',	'sdtgdfgdfg',	'fgdfg',	NULL,	NULL,	NULL,	'56456456',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2021-09-29 20:56:36',	'2021-09-30 19:16:05',	NULL);

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
(81,	1,	554545,	'ghghgh',	'etttrt',	NULL,	'2022-04-15 11:45:34',	NULL,	NULL);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(70) NOT NULL,
  `last_name` varchar(70) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(320) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` enum('M','F','O','N') NOT NULL DEFAULT 'N',
  `place` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE','PENDING') NOT NULL DEFAULT 'PENDING',
  `deletable` tinyint(1) NOT NULL DEFAULT 1,
  `client_ip` varchar(22) DEFAULT NULL,
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `user` (`id`, `role`, `username`, `password`, `first_name`, `last_name`, `company_name`, `date_of_birth`, `email`, `phone`, `avatar`, `gender`, `place`, `address`, `status`, `deletable`, `client_ip`, `login_at`, `logout_at`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	1,	'admin',	'$2y$10$3l0yQjMc7F2mlA8yCu.1l.ccKM68f9gLICEUCnId1bdCcO5gZh.si',	'Admin',	'Last',	NULL,	'1992-10-30',	'admin@example.com',	'+91-0000000012',	NULL,	'N',	'Trivandrum',	'CyberLikes Pvt. Ltd.',	'ACTIVE',	0,	'::1',	'2022-04-26 06:56:09',	'2022-04-15 05:07:31',	'2021-04-20 19:22:52',	'2022-04-26 06:56:09',	NULL),
(13,	2,	'rythse',	'$2y$10$A2Avf.FbCFpsUttbnIO9uOO0HS3nzZZnASe9yhLmDyZSbeM8Bxg4y',	'retety',	'tyty',	NULL,	'1992-10-30',	'ere@dfg.ddf',	'57567567',	NULL,	'O',	NULL,	NULL,	'INACTIVE',	1,	NULL,	NULL,	NULL,	'2021-05-01 17:33:45',	NULL,	NULL),
(24,	1,	'rtretrt',	'$2y$10$6Ycp.jwd.QJUZ.mjxTuTd.nnXLQRnfOSaLSymS3LdQNQf580ZAkQe',	'ertert',	NULL,	NULL,	NULL,	'ryr@et.rtrt',	'465464564456',	NULL,	'O',	NULL,	NULL,	'INACTIVE',	1,	NULL,	NULL,	NULL,	'2021-05-01 20:24:41',	'2021-08-18 18:08:09',	NULL),
(26,	1,	'fff',	'$2y$10$s2laXQmwAt4K8431Y/nubue1Z8OL3mELtHevdcXIFECmRHX7OPXN6',	'asdasd',	NULL,	NULL,	NULL,	'sf@dgdg.fgfdg',	'5454545',	NULL,	'M',	NULL,	NULL,	'ACTIVE',	1,	NULL,	NULL,	NULL,	'2021-05-07 20:05:30',	'2021-07-29 20:53:27',	NULL),
(27,	1,	'tytyt',	'$2y$10$dMv5wEcpSOj92qOBYfhwLOQM9ZVqG6wf1Chkco2AP1ExTrHtz656y',	'eeryyrty',	NULL,	NULL,	NULL,	'tyrty@st.tt',	'6565656',	NULL,	'M',	NULL,	NULL,	'PENDING',	1,	NULL,	NULL,	NULL,	'2021-05-08 10:06:52',	NULL,	NULL);

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
  `name` varchar(100) NOT NULL,
  `code` varchar(20) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `latitude` decimal(8,6) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `warehouse` (`id`, `name`, `code`, `phone`, `email`, `address`, `longitude`, `latitude`, `description`, `added_at`, `updated_at`, `deleted_at`) VALUES
(20,	'CyberKids',	'CK',	'+91-9745451448',	'tewest@gmail.com',	'TVMgy',	NULL,	NULL,	NULL,	'2021-04-14 19:54:53',	'2021-07-28 18:33:02',	NULL),
(22,	'er',	'erwerer',	'454546',	'dfgg@hg.vd',	'jkjljl',	NULL,	NULL,	'ghgh',	'2021-04-22 17:58:52',	'2021-07-28 18:33:11',	NULL),
(23,	'erer',	'erwer',	'45',	'fddf@wdwd.cv',	'erwer',	NULL,	NULL,	'ererererrer',	'2021-04-22 18:00:23',	'2021-04-23 19:31:27',	NULL),
(25,	'tret',	'rtert',	'4545',	'fgfdg@er.t',	'ryty',	NULL,	NULL,	NULL,	'2021-04-23 19:31:52',	NULL,	NULL);

-- 2022-04-26 10:45:57
