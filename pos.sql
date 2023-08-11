-- Adminer 4.8.1 MySQL 10.4.27-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `barcode_symbologies`;
CREATE TABLE `barcode_symbologies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `barcode_symbology`;
CREATE TABLE `barcode_symbology` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`) USING HASH
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `brand` (`id`, `code`, `name`, `image`, `description`, `deletable`, `editable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'LX',	'Lexi',	NULL,	'Tesssssssssst.......',	0,	0,	'2021-01-24 06:01:28',	'2022-07-07 17:06:42',	NULL),
(3,	'CM',	'Camlin',	NULL,	'jt',	NULL,	NULL,	'2021-01-24 06:01:54',	'2022-07-07 17:00:15',	NULL),
(129,	'ytyty',	'ytyt',	NULL,	'tyty',	NULL,	NULL,	'2022-09-10 12:03:38',	NULL,	NULL);

DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `brands` (`id`, `code`, `name`, `logo`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(302,	'BR-3889',	'Pollich, Feeney and Bins',	NULL,	'Quos nisi velit consequatur.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(303,	'BR-1737',	'Nolan LLC',	NULL,	'Rerum nisi quis delectus.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(304,	'BR-6808',	'Casper PLC',	NULL,	'Quia hic veritatis ex officia nostrum laboriosam.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(305,	'BR-8351',	'Streich, Considine and Ondricka',	NULL,	'Est ad temporibus voluptatem dolorem et ut expedita officiis.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(306,	'BR-7008',	'Kessler, Bednar and Ward',	NULL,	'Labore dolores ea et facilis debitis non enim debitis.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(307,	'BR-4440',	'Gutkowski-Smith',	NULL,	'Nesciunt dolore ex veniam.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(308,	'BR-3516',	'Funk LLC',	NULL,	'Ut non qui rerum aut nobis deserunt qui.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(309,	'BR-5510',	'Kuhic Ltd',	NULL,	'Nisi repellat nobis voluptate ratione doloremque quibusdam.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(310,	'BR-3617',	'Pollich, Ortiz and Cormier',	NULL,	'Aut sed dolorem nobis aut.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(311,	'BR-8455',	'Schmitt Group',	NULL,	'Voluptatem et dolores est rerum.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(312,	'BR-1681',	'Pfannerstill-Cassin',	NULL,	'Odio assumenda quas ut voluptates.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(313,	'BR-4318',	'Bernier, Jacobson and Sipes',	NULL,	'Qui eius sit fuga sit exercitationem.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(314,	'BR-1419',	'Marquardt PLC',	NULL,	'Ad occaecati sint accusamus nesciunt.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(315,	'BR-3213',	'Bauch-Cronin',	NULL,	'Cupiditate facere dolores exercitationem et similique.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(316,	'BR-9502',	'Dickinson, Flatley and Lemke',	NULL,	'Vitae officiis velit vero aut labore nesciunt.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(317,	'BR-8741',	'Connelly-Kuhic',	NULL,	'Culpa provident voluptas est itaque qui ea.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(318,	'BR-7937',	'Hammes-Hamill',	NULL,	'Rem autem quis impedit beatae iure excepturi ut.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(319,	'BR-8997',	'Schamberger LLC',	NULL,	'Et incidunt natus est aut.',	'2023-01-29 12:26:40',	'2023-01-29 12:26:40',	NULL),
(320,	'BR-6409',	'Murphy Inc',	NULL,	'Error neque molestiae ab sed ut minima tempora.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(321,	'BR-3471',	'Cummings, Wuckert and Sanford',	NULL,	'Omnis earum ullam rerum perspiciatis modi.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(322,	'BR-5308',	'Erdman Group',	NULL,	'Cumque facere maxime repellat eveniet.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(323,	'BR-5879',	'Gutkowski, Champlin and Towne',	NULL,	'Ad inventore aut sit mollitia.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(324,	'BR-3856',	'Satterfield-Stanton',	NULL,	'Maxime ut voluptates veritatis repudiandae cum.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(325,	'BR-2799',	'Cartwright, Satterfield and Bauch',	NULL,	'Qui quia dignissimos voluptas qui possimus rerum fugiat.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(326,	'BR-245',	'Thompson Inc',	NULL,	'Harum et est qui sit iusto.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(327,	'BR-5589',	'O\'Connell LLC',	NULL,	'Sequi et autem repellat aut harum sint dolorem expedita.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(328,	'BR-4360',	'Gorczany, Doyle and Strosin',	NULL,	'Et quo molestiae accusantium asperiores vel.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(329,	'BR-7320',	'Lakin, Miller and Kuvalis',	NULL,	'Illum recusandae et quasi illum tenetur est.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(330,	'BR-7017',	'Mraz, Ziemann and Raynor',	NULL,	'Dolorem delectus vitae odit velit.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(331,	'BR-4230',	'Bashirian-Wehner',	NULL,	'Qui sint facilis et voluptatem autem hic sint libero.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(332,	'BR-390',	'Beatty, Fisher and Wisoky',	NULL,	'Omnis sunt consequatur aperiam quae repellat voluptates.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(333,	'BR-3906',	'Hackett Group',	NULL,	'Consequatur aut explicabo enim repellat repellat iste corrupti.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(334,	'BR-2185',	'Hyatt-Greenholt',	NULL,	'Dicta commodi amet ad accusamus.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(335,	'BR-2156',	'Shanahan LLC',	NULL,	'Velit non magni iste pariatur et est quia.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(336,	'BR-5704',	'Walker, Hahn and Prohaska',	NULL,	'Odit ipsa iure quia dignissimos blanditiis.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(337,	'BR-8229',	'Lockman Ltd',	NULL,	'Perspiciatis harum consequatur temporibus pariatur architecto voluptas eum.',	'2023-01-29 12:26:41',	'2023-01-29 12:26:41',	NULL),
(338,	'BR-3205',	'Hettinger-Kuphal',	NULL,	'Consequatur voluptatem dicta rerum totam quos.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(339,	'BR-7970',	'Lebsack, Skiles and Altenwerth',	NULL,	'Sed facilis minus sint quae impedit error in.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(340,	'BR-5034',	'Cummings PLC',	NULL,	'Qui et ipsam voluptatem fugit quas.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(341,	'BR-2578',	'Krajcik-Howe',	NULL,	'Saepe doloribus nisi saepe deleniti error aperiam accusantium incidunt.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(342,	'BR-2425',	'Stoltenberg Group',	NULL,	'Est aut id qui inventore.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(343,	'BR-4279',	'Toy and Sons',	NULL,	'Vel laboriosam ut doloribus.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(344,	'BR-9848',	'Boyer-Schneider',	NULL,	'Iste excepturi velit odit et doloremque nihil et.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(345,	'BR-7540',	'Wolf-Ruecker',	NULL,	'Asperiores minus voluptate consequuntur nesciunt et et nihil.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(346,	'BR-971',	'Lowe-Ryan',	NULL,	'Quisquam qui maiores placeat vel distinctio.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(347,	'BR-2293',	'Hudson and Sons',	NULL,	'Asperiores impedit qui consequatur delectus sapiente.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(348,	'BR-658',	'Watsica Inc',	NULL,	'Et exercitationem rerum voluptatem et sed laborum accusamus.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(349,	'BR-7208',	'McKenzie Inc',	NULL,	'Sed sit corporis architecto illum.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(350,	'BR-2777',	'Cole Ltd',	NULL,	'Ut exercitationem velit voluptate debitis consequatur aspernatur.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(351,	'BR-4240',	'Reilly-Wiza',	NULL,	'Possimus corporis perferendis distinctio dolores qui ut et eius.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(352,	'BR-5047',	'Wisozk, Osinski and King',	NULL,	'Fugiat est nam natus voluptatum consequatur consequatur natus.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(353,	'BR-7740',	'Price and Sons',	NULL,	'Est facilis molestias quia ut.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(354,	'BR-7724',	'Kovacek, Parker and Zemlak',	NULL,	'Dolores itaque possimus quo dolor animi.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(355,	'BR-8884',	'Stracke Group',	NULL,	'Adipisci corporis eius in.',	'2023-01-29 12:26:42',	'2023-01-29 12:26:42',	NULL),
(356,	'BR-9662',	'Jacobs, Graham and Prosacco',	NULL,	'Ipsam molestias consequuntur facere enim totam a.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(357,	'BR-7860',	'Thompson-Schumm',	NULL,	'Debitis eius magni fugit esse nisi qui ea.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(358,	'BR-3445',	'Schmitt, Schmitt and Morissette',	NULL,	'Alias aut ut voluptatem illum nobis labore.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(359,	'BR-6558',	'Barton, O\'Keefe and Turcotte',	NULL,	'Voluptatem tempora non omnis tenetur aut.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(360,	'BR-1832',	'Armstrong Ltd',	NULL,	'Quod deserunt eos et qui.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(361,	'BR-7246',	'Wunsch and Sons',	NULL,	'Omnis sit reprehenderit ut facere.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(362,	'BR-6129',	'Vandervort Ltd',	NULL,	'Voluptatum vero veniam libero.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(363,	'BR-5631',	'Ziemann PLC',	NULL,	'Asperiores porro similique aut et aut.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(364,	'BR-2498',	'Walker-Schuppe',	NULL,	'Rerum labore iusto iusto quisquam dicta voluptatum suscipit expedita.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(365,	'BR-1909',	'Ritchie Group',	NULL,	'Voluptas rerum repellat illo quos.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(366,	'BR-6550',	'Pollich Ltd',	NULL,	'Ut praesentium dignissimos accusantium illo sed aspernatur blanditiis.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(367,	'BR-563',	'Bogan Ltd',	NULL,	'Eaque aut quos est inventore doloribus qui odit.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(368,	'BR-9217',	'Conroy-Lindgren',	NULL,	'Quaerat consequatur eum nulla voluptatibus fuga est.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(369,	'BR-3632',	'Smitham, Bradtke and Stoltenberg',	NULL,	'Mollitia voluptas voluptas consequuntur et temporibus consequatur.',	'2023-01-29 12:26:43',	'2023-01-29 12:26:43',	NULL),
(370,	'BR-4513',	'Klocko-Tromp',	NULL,	'Eveniet nisi eveniet non aut.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(371,	'BR-6331',	'Goyette Inc',	NULL,	'Velit facilis aut ut maiores recusandae.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(372,	'BR-888',	'Baumbach, Kerluke and Kautzer',	NULL,	'Facere iure cupiditate aspernatur consequatur voluptatibus impedit beatae.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(373,	'BR-1139',	'Cruickshank-Champlin',	NULL,	'Corrupti enim et et delectus velit sit earum.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(374,	'BR-6547',	'Greenholt, Conn and Johns',	NULL,	'Neque et beatae officiis enim.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(375,	'BR-854',	'Leffler, Renner and Barrows',	NULL,	'Facere rerum explicabo incidunt voluptatem vel tenetur.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(376,	'BR-268',	'Rutherford Ltd',	NULL,	'Natus porro perferendis minus ex.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(377,	'BR-6721',	'Towne, Johnston and Harvey',	NULL,	'Eos quidem quae omnis.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(378,	'BR-4220',	'Schmitt, Corwin and Parker',	NULL,	'Tempore adipisci repellat aut suscipit ea iste.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(379,	'BR-3623',	'Murphy-Cruickshank',	NULL,	'Repudiandae sed deserunt numquam eveniet maiores dolorum dolorum et.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(380,	'BR-8180',	'Kshlerin-Daugherty',	NULL,	'Totam voluptatem quia laborum a.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(381,	'BR-483',	'Konopelski-Kemmer',	NULL,	'Sint quod qui dolorum voluptatem unde occaecati.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(382,	'BR-990',	'Kertzmann, Larkin and White',	NULL,	'Voluptate voluptatum asperiores tenetur qui.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(383,	'BR-5395',	'Hickle-Fritsch',	NULL,	'Vel blanditiis delectus unde qui quo perferendis voluptatum.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(384,	'BR-513',	'Wilderman and Sons',	NULL,	'Consequuntur aut corporis voluptatum doloremque.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(385,	'BR-1110',	'Walsh, McGlynn and Reichert',	NULL,	'Quia exercitationem distinctio impedit aut.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(386,	'BR-9399',	'Cremin and Sons',	NULL,	'Eos qui soluta reprehenderit qui magni voluptates.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(387,	'BR-8630',	'Ondricka-Morissette',	NULL,	'Voluptatem quos iste aliquam explicabo amet.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(388,	'BR-3004',	'Mosciski LLC',	NULL,	'Dolorem nisi voluptatibus qui deleniti.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(389,	'BR-2985',	'Ernser, Smith and Walsh',	NULL,	'Aut omnis repellat voluptatum vel possimus.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(390,	'BR-8001',	'Hermann and Sons',	NULL,	'Rerum et sed non magnam ut qui inventore.',	'2023-01-29 12:26:44',	'2023-01-29 12:26:44',	NULL),
(391,	'BR-2447',	'Brown, Bergstrom and Kuhic',	NULL,	'Qui aspernatur debitis consequatur delectus earum quae nesciunt.',	'2023-01-29 12:26:45',	'2023-01-29 13:41:10',	'2023-01-29 13:41:10'),
(392,	'BR-1163',	'Jacobi, Hintz and Kemmer',	NULL,	'Ducimus magnam similique soluta earum ea.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(393,	'BR-1805',	'Langosh, Harvey and King',	NULL,	'Sit ipsa iure commodi architecto.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(394,	'BR-1799',	'Padberg-Monahan',	NULL,	'Praesentium voluptatem veritatis animi eaque nesciunt pariatur.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(395,	'BR-6345',	'Sipes, Fisher and Pacocha',	NULL,	'Doloremque quo eos enim quos.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(396,	'BR-2008',	'Schneider PLC',	NULL,	'Eum quasi optio perspiciatis.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(397,	'BR-6502',	'Goodwin-Pacocha',	NULL,	'Pariatur rerum aut non earum et totam.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(398,	'BR-6180',	'Frami-Yundt',	NULL,	'Sed eos officia tenetur in reiciendis vel.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(399,	'BR-5171',	'Gorczany-O\'Keefe',	NULL,	'Eaque dolorum atque animi porro quisquam sed.',	'2023-01-29 12:26:45',	'2023-01-29 14:08:08',	'2023-01-29 14:08:08'),
(400,	'BR-400',	'Willms-Kris',	NULL,	'Voluptas enim eum accusamus dolorem vero aut.',	'2023-01-29 12:26:45',	'2023-01-29 12:26:45',	NULL),
(401,	'BR-7232',	'dfdsfdsfdfdsf',	NULL,	'Voluptas quae et maiores accusantiumddd',	'2023-01-29 12:26:45',	'2023-01-29 13:42:10',	'2023-01-29 13:42:10'),
(402,	'BR-00402',	'gfhfgh',	NULL,	'gfhfghfghgfh',	'2023-01-29 12:45:25',	'2023-01-29 13:41:23',	'2023-01-29 13:41:23'),
(403,	'BR-00403',	'dfdfdsf',	NULL,	'fghfghfghdsfdsfsdfsdf',	'2023-01-29 12:46:00',	'2023-01-29 13:41:03',	'2023-01-29 13:41:03'),
(404,	'BR-00404',	'Apple',	NULL,	'ApplessssssssssssFGHGFH',	'2023-01-29 12:59:16',	'2023-01-29 13:40:51',	'2023-01-29 13:40:51'),
(405,	'BR-00405',	'RTYTRY',	NULL,	'TRYRTYTY',	'2023-01-29 13:40:43',	'2023-01-29 13:40:56',	'2023-01-29 13:40:56'),
(406,	'BR-00406',	'fgfgfg',	NULL,	'fgdfg',	'2023-07-08 18:28:16',	'2023-07-08 18:28:16',	NULL);

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `allow_sub` tinyint(1) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `deletable` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_code_unique` (`code`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  UNIQUE KEY `slug` (`parent`,`name`),
  UNIQUE KEY `categories_image_unique` (`image`),
  CONSTRAINT `categories_parent_foreign` FOREIGN KEY (`parent`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `countries` (`id`, `code`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'IN',	'India',	'2023-01-29 01:12:24',	'2023-01-29 01:12:24',	NULL),
(2,	'UAE',	'United Arab Emirates',	'2023-01-29 01:12:24',	'2023-01-29 01:12:24',	NULL);

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `rate` decimal(16,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `currencies_code_unique` (`code`),
  UNIQUE KEY `currencies_name_unique` (`name`),
  UNIQUE KEY `currencies_symbol_unique` (`symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `parent` bigint(20) unsigned DEFAULT NULL,
  `customer_group` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_code_unique` (`code`),
  UNIQUE KEY `customers_email_unique` (`email`),
  UNIQUE KEY `customers_phone_unique` (`phone`),
  KEY `customers_parent_foreign` (`parent`),
  KEY `customers_customer_group_foreign` (`customer_group`),
  KEY `customers_status_foreign` (`status`),
  CONSTRAINT `customers_customer_group_foreign` FOREIGN KEY (`customer_group`) REFERENCES `customer_groups` (`id`),
  CONSTRAINT `customers_parent_foreign` FOREIGN KEY (`parent`) REFERENCES `customers` (`id`),
  CONSTRAINT `customers_status_foreign` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `customer_group` (`id`, `name`, `percentage`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'General',	0.0000,	'2021-04-02 06:33:09',	NULL,	NULL),
(2,	'Reseller',	50.0000,	'2021-04-02 06:33:22',	NULL,	NULL),
(3,	'Distributor',	65.0000,	'2021-04-02 06:34:04',	NULL,	NULL),
(4,	'Friends',	10.0000,	'2021-04-02 16:50:30',	'2021-04-02 16:50:34',	NULL);

DROP TABLE IF EXISTS `customer_groups`;
CREATE TABLE `customer_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `percentage` decimal(16,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_groups_name_unique` (`name`),
  UNIQUE KEY `customer_groups_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `gender`;
CREATE TABLE `gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `code` varchar(2) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `gender` (`id`, `name`, `code`, `description`) VALUES
(1,	'Male',	'M',	NULL),
(2,	'Female',	'F',	NULL),
(3,	'Not specify',	'NS',	NULL);

DROP TABLE IF EXISTS `genders`;
CREATE TABLE `genders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `genders_name_unique` (`name`),
  UNIQUE KEY `genders_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `hsn_sacs`;
CREATE TABLE `hsn_sacs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `tax_rate` decimal(16,4) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hsn_sacs_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `label_size` (`id`, `code`, `name`, `p_width`, `p_height`, `labels`, `l_width`, `l_height`, `rows`, `columns`, `row_gutter`, `column_gutter`, `margin_t`, `margin_r`, `margin_b`, `margin_l`, `deleted_at`) VALUES
(1,	'A456',	'A4 56 Label Per Page',	210.00,	297.00,	56.00,	48.00,	20.00,	14.00,	4.00,	1.00,	2.00,	2.00,	6.00,	2.00,	6.00,	NULL),
(2,	'A484',	'A4 84 Label Per Page',	210.00,	297.00,	84.00,	46.00,	11.00,	21.00,	4.00,	1.50,	5.00,	18.00,	5.50,	18.00,	5.50,	NULL);

DROP TABLE IF EXISTS `label_sizes`;
CREATE TABLE `label_sizes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `p_width` decimal(6,2) NOT NULL,
  `p_height` decimal(6,2) NOT NULL,
  `labels` int(11) NOT NULL,
  `l_width` decimal(6,2) NOT NULL,
  `l_height` decimal(6,2) NOT NULL,
  `rows` decimal(6,2) NOT NULL,
  `columns` decimal(6,2) NOT NULL,
  `row_gutter` decimal(6,2) NOT NULL,
  `column_gutter` decimal(6,2) NOT NULL,
  `margin_t` decimal(6,2) NOT NULL,
  `margin_r` decimal(6,2) NOT NULL,
  `margin_b` decimal(6,2) NOT NULL,
  `margin_l` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `label_sizes_code_unique` (`code`),
  UNIQUE KEY `label_sizes_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9,	'130_create_statuses_table',	1),
(10,	'148_create_roles_table',	1),
(11,	'150_create_countries_table',	1),
(12,	'160_create_genders_table',	1),
(13,	'180_create_users_table',	1),
(14,	'200_create_password_resets_table',	1),
(15,	'2019_12_14_000001_create_personal_access_tokens_table',	1),
(16,	'220_create_failed_jobs_table',	1),
(17,	'260_create_barcode_symbologies_table',	1),
(18,	'280_create_brands_table',	1),
(19,	'300_create_categories_table',	1),
(20,	'320_create_currencies_table',	1),
(21,	'340_create_customer_groups_table',	1),
(22,	'360_create_customers_table',	1),
(23,	'380_create_hsn_sacs_table',	1),
(24,	'400_create_label_sizes_table',	1),
(25,	'420_create_modules_table',	1),
(26,	'440_create_permissions_table',	1),
(27,	'460_create_module_permissions_table',	1),
(28,	'480_create_payment_modes_table',	1),
(29,	'500_create_product_types_table',	1),
(30,	'520_create_role_permissions_table',	1),
(31,	'540_create_suppliers_table',	1),
(32,	'560_create_units_table',	1),
(34,	'580_create_warehouses_table',	2);

DROP TABLE IF EXISTS `module`;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `modules` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'product',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(2,	'category',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(3,	'brand',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(4,	'tax',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(5,	'unit',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(6,	'supplier',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(7,	'customer',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(8,	'user',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(9,	'warehouse',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(10,	'role',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(11,	'pos',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(12,	'type',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(13,	'symbology',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(14,	'label',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(15,	'stock_adjustment',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(16,	'customer_group',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(17,	'common',	NULL,	'2023-01-29 01:05:22',	'2023-01-29 01:05:22',	NULL),
(18,	'purchase',	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(19,	'purchase_return',	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Available Permissions for each modules';

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

DROP TABLE IF EXISTS `module_permissions`;
CREATE TABLE `module_permissions` (
  `module` bigint(20) unsigned NOT NULL,
  `permission` bigint(20) unsigned NOT NULL,
  `checked` tinyint(1) DEFAULT NULL COMMENT 'default checked or not',
  `read_only` tinyint(1) DEFAULT NULL COMMENT 'ui read only',
  `comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `module_permissions_module_permission_unique` (`module`,`permission`),
  KEY `module_permissions_permission_foreign` (`permission`),
  CONSTRAINT `module_permissions_module_foreign` FOREIGN KEY (`module`) REFERENCES `modules` (`id`),
  CONSTRAINT `module_permissions_permission_foreign` FOREIGN KEY (`permission`) REFERENCES `permissions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Available Permissions for each modules';


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `payment_mode`;
CREATE TABLE `payment_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `payment_mode` (`id`, `name`, `description`) VALUES
(1,	'Cash',	NULL),
(2,	'Debit Card',	NULL),
(3,	'Credit Card',	NULL),
(4,	'UPI',	NULL),
(5,	'Gift Card',	NULL),
(6,	'Check',	NULL);

DROP TABLE IF EXISTS `payment_modes`;
CREATE TABLE `payment_modes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_modes_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `usage` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product_type` (`id`, `code`, `name`, `description`, `deleted_at`) VALUES
(1,	'SP',	'Standard Product',	'Standard Product hereeeeeee',	NULL),
(2,	'CP',	'Combo Product',	'Combo Product here......',	NULL),
(3,	'DP',	'Digital',	'Digital hereeeee',	NULL),
(4,	'SV',	'Service',	'Service hereeee',	NULL);

DROP TABLE IF EXISTS `product_types`;
CREATE TABLE `product_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_types_code_unique` (`code`),
  UNIQUE KEY `product_types_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `purchase` (`id`, `reference_id`, `warehouse`, `date`, `time`, `status`, `supplier`, `discount`, `purchase_tax`, `shipping_charge`, `shipping_tax`, `packing_charge`, `packing_tax`, `round_off`, `payment_note`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(35,	'REF-PUR-00035',	20,	'2022-11-19',	'00:41:26',	22,	88,	0.0000,	NULL,	0.0000,	NULL,	0.0000,	NULL,	0.1422,	'ryeryeryrw',	'sf',	1,	'2022-11-22 19:11:37',	1,	'2022-11-22 19:14:44',	NULL,	NULL);

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
  KEY `transaction_id` (`transaction_id`),
  KEY `reference_no` (`reference_no`),
  CONSTRAINT `purchase_payment_ibfk_1` FOREIGN KEY (`purchase`) REFERENCES `purchase` (`id`),
  CONSTRAINT `purchase_payment_ibfk_2` FOREIGN KEY (`payment_mode`) REFERENCES `payment_mode` (`id`),
  CONSTRAINT `purchase_payment_ibfk_3` FOREIGN KEY (`deleted_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_payment_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_payment_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`),
  CONSTRAINT `amount_check` CHECK (`amount` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `purchase_payment` (`id`, `purchase`, `payment_mode`, `amount`, `date_time`, `transaction_id`, `reference_no`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(56,	35,	1,	290.0000,	'2022-11-23 00:44:00',	NULL,	NULL,	NULL,	1,	'2022-11-22 19:14:32',	1,	'2022-11-22 19:14:51',	NULL,	NULL),
(57,	35,	1,	3.0000,	'2022-11-23 00:53:00',	NULL,	NULL,	NULL,	1,	'2022-11-22 19:23:29',	NULL,	NULL,	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `purchase_product` (`id`, `purchase`, `product`, `batch_no`, `quantity`, `unit`, `unit_cost`, `unit_discount`, `tax_id`, `net_unit_cost`, `product_total_without_tax`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(134,	35,	5,	NULL,	2.0000,	1,	12.0000,	0.0000,	2,	12.0000,	24.0000,	1,	'2022-11-22 19:11:37',	1,	'2022-11-22 19:11:44',	NULL,	NULL),
(135,	35,	10,	NULL,	1.0000,	6,	12.0000,	0.0000,	2,	12.0000,	12.0000,	1,	'2022-11-22 19:11:37',	NULL,	NULL,	NULL,	NULL),
(136,	35,	6,	NULL,	1.0000,	1,	250.7500,	0.0000,	2,	250.7500,	250.7500,	1,	'2022-11-22 19:11:37',	NULL,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS `rack`;
CREATE TABLE `rack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warehouse_rack_name` (`warehouse`,`name`),
  KEY `warehouse` (`warehouse`),
  CONSTRAINT `rack_ibfk_1` FOREIGN KEY (`warehouse`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `return_purchase` (`id`, `reference_id`, `purchase`, `date`, `time`, `status`, `discount`, `return_tax`, `shipping_charge`, `shipping_tax`, `packing_charge`, `packing_tax`, `round_off`, `payment_note`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(40,	'REF-RET-PUR-00040',	35,	'2022-11-24',	'01:19:55',	5,	0.0000,	NULL,	2.0000,	NULL,	0.0000,	NULL,	-0.1422,	'sasff',	NULL,	1,	'2022-11-23 19:50:02',	1,	'2022-11-23 20:46:49',	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `return_purchase_payment` (`id`, `return_purchase`, `payment_mode`, `amount`, `date_time`, `transaction_id`, `reference_no`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(17,	40,	1,	10.0000,	'2022-11-24 02:08:00',	NULL,	NULL,	NULL,	1,	'2022-11-23 20:38:18',	NULL,	'2022-11-23 20:39:42',	1,	'2022-11-23 20:39:42'),
(18,	40,	1,	295.0000,	'2022-11-24 02:09:00',	NULL,	NULL,	NULL,	1,	'2022-11-23 20:39:59',	NULL,	'2022-11-23 20:40:16',	1,	'2022-11-23 20:40:16'),
(19,	40,	1,	295.0000,	'2022-11-24 02:10:00',	NULL,	NULL,	NULL,	1,	'2022-11-23 20:40:33',	NULL,	'2022-11-23 20:40:45',	1,	'2022-11-23 20:40:45'),
(20,	40,	1,	100.0000,	'2022-11-24 02:16:00',	NULL,	NULL,	NULL,	1,	'2022-11-23 20:46:18',	NULL,	'2022-11-23 20:46:49',	1,	'2022-11-23 20:46:49'),
(21,	40,	3,	295.0000,	'2022-11-24 02:16:00',	NULL,	NULL,	NULL,	1,	'2022-11-23 20:46:49',	NULL,	NULL,	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `return_purchase_product` (`id`, `return_purchase`, `purchase_product`, `quantity`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(101,	40,	134,	2.0000,	1,	'2022-11-23 19:50:02',	1,	'2022-11-23 20:22:49',	NULL,	NULL),
(102,	40,	135,	1.0000,	1,	'2022-11-23 19:50:02',	NULL,	NULL,	NULL,	NULL),
(103,	40,	136,	1.0000,	1,	'2022-11-23 19:50:02',	NULL,	NULL,	NULL,	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This is user groups';

INSERT INTO `role` (`id`, `name`, `description`, `limit`, `editable`, `deletable`, `updatable_rights`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Administrator',	'All permissions allowed.',	1,	0,	0,	0,	'2021-04-21 00:19:28',	'2022-07-06 12:10:28',	NULL),
(2,	'Seller',	'Sales permissions.',	2,	NULL,	NULL,	1,	'2021-04-21 00:21:17',	'2022-07-14 23:13:37',	NULL),
(3,	'Purchaser',	'Purchase permissions.',	1,	NULL,	NULL,	1,	'2021-04-21 00:21:35',	'2022-07-14 23:13:37',	NULL);

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `limit` int(11) NOT NULL,
  `is_locked` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Every user role has thier own rights.';

INSERT INTO `roles` (`id`, `name`, `description`, `limit`, `is_locked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'Super Admin',	'Super admin can do anything, can even delete this world !',	1,	1,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(2,	'Admin',	'All rights or actions allowed !',	2,	1,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(3,	'Seller',	'Rights for selling products !',	3,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(4,	'Purchaser',	'Rights or purchase products !',	4,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Rows with readonly flag are read only or manually added rows ';

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

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` bigint(20) unsigned NOT NULL,
  `module_id` bigint(20) unsigned NOT NULL,
  `permission_id` bigint(20) unsigned NOT NULL,
  `readonly` tinyint(1) DEFAULT NULL COMMENT 'read only or manually added rows, no changes can be made from ui',
  `allow` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 - Allow, 0 - Deny',
  `disabled` tinyint(1) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `slug` (`role_id`,`module_id`,`permission_id`),
  KEY `role_permissions_module_id_foreign` (`module_id`),
  KEY `role_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `role_permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `role_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  CONSTRAINT `role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Module based role permissions';


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `css_color` varchar(255) DEFAULT NULL,
  `online_status` tinyint(1) DEFAULT NULL,
  `payment_status` tinyint(1) DEFAULT NULL,
  `order_status` tinyint(1) DEFAULT NULL,
  `role_status` tinyint(1) DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT NULL,
  `warehouse_status` tinyint(1) DEFAULT NULL,
  `pos_sale_status` tinyint(1) DEFAULT NULL,
  `purchase_status` tinyint(1) DEFAULT NULL,
  `purchase_return_status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statuses_name_unique` (`name`),
  KEY `statuses_online_status_index` (`online_status`),
  KEY `statuses_payment_status_index` (`payment_status`),
  KEY `statuses_order_status_index` (`order_status`),
  KEY `statuses_role_status_index` (`role_status`),
  KEY `statuses_user_status_index` (`user_status`),
  KEY `statuses_warehouse_status_index` (`warehouse_status`),
  KEY `statuses_pos_sale_status_index` (`pos_sale_status`),
  KEY `statuses_purchase_status_index` (`purchase_status`),
  KEY `statuses_purchase_return_status_index` (`purchase_return_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `statuses` (`id`, `name`, `css_class`, `css_color`, `online_status`, `payment_status`, `order_status`, `role_status`, `user_status`, `warehouse_status`, `pos_sale_status`, `purchase_status`, `purchase_return_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	'online',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(2,	'offline',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(3,	'active',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(4,	'inactive',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(5,	'pending',	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	NULL,	NULL,	1,	1,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(6,	'paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(7,	'unpaid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(8,	'ordered',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(9,	'packed',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(10,	'shipped',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(11,	'returned',	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	1,	NULL,	1,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(12,	'partially paid',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(13,	'expired',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(14,	'away',	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(15,	'blocked',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(16,	'open',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(17,	'closed',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(18,	'permanently closed',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(19,	'temperorily closed',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(20,	'completed',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(21,	'due',	NULL,	NULL,	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL),
(22,	'recieved ✓',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	NULL,	'2023-01-29 01:05:23',	'2023-01-29 01:05:23',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `supplier` (`id`, `code`, `name`, `place`, `address`, `pin_code`, `city`, `phone`, `email`, `gst_no`, `tax_no`, `description`, `editable`, `deletable`, `status`, `added_at`, `updated_at`, `deleted_at`) VALUES
(88,	'SUPP0088',	'Supp 1',	'rwrr5',	NULL,	NULL,	NULL,	'53535355',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:30:51',	'2022-08-27 18:53:28',	NULL),
(89,	'SUPP0089',	'Tensile',	'Kudappanamoodu',	'Bzd\nasdasd\nTdsd',	695505,	'Trivandrum',	'6664564564',	'ddfdfd@fgh.gbg',	'DDADA14166416+A',	'565656',	'fggfdgfdgdfg',	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:31:29',	'2022-10-22 10:08:32',	NULL),
(91,	'SUPP0091',	'Heloooo',	'tyrytry',	NULL,	NULL,	NULL,	'564335466',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-06-29 14:34:00',	'2022-08-27 18:53:39',	'2022-07-09 13:44:50'),
(108,	'SUPP0108',	'dfsdfd',	'fdfdfd',	NULL,	NULL,	NULL,	'454545',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'ACTIVE',	'2022-08-29 17:51:55',	NULL,	NULL);

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `status` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_code_unique` (`code`),
  UNIQUE KEY `suppliers_phone_unique` (`phone`),
  UNIQUE KEY `suppliers_email_unique` (`email`),
  KEY `suppliers_status_foreign` (`status`),
  KEY `suppliers_name_index` (`name`),
  KEY `suppliers_place_index` (`place`),
  CONSTRAINT `suppliers_status_foreign` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Supplier contact details';


DROP TABLE IF EXISTS `symbology`;
CREATE TABLE `symbology` (
  `id` int(11) NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `base` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `step` decimal(8,2) DEFAULT NULL COMMENT 'for sub units only',
  `allow_decimal` tinyint(1) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `units_code_unique` (`code`),
  UNIQUE KEY `units_name_unique` (`name`),
  UNIQUE KEY `units_base_step_unique` (`base`,`step`),
  CONSTRAINT `units_base_foreign` FOREIGN KEY (`base`) REFERENCES `units` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Measurement units';

INSERT INTO `units` (`id`, `base`, `code`, `name`, `step`, `allow_decimal`, `description`, `locked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1,	NULL,	'PC',	'Piece',	0.00,	NULL,	'fghf',	NULL,	NULL,	'2023-01-29 15:11:26',	NULL),
(3,	1,	'5PC',	'5 Piece',	5.50,	NULL,	'sfdsfdfyui',	NULL,	NULL,	'2023-01-29 15:11:33',	NULL),
(11,	NULL,	'eee',	'eee',	0.00,	1,	'nbbbbbbbbb',	NULL,	'2023-07-08 18:29:35',	'2023-07-08 18:30:02',	NULL),
(12,	NULL,	'tytyty',	'ytyty',	NULL,	NULL,	'tyty',	NULL,	'2023-07-08 18:31:05',	'2023-07-08 18:31:05',	NULL),
(13,	NULL,	'trt',	'rtr',	NULL,	1,	'rtrtrt',	NULL,	'2023-07-08 18:31:13',	'2023-07-08 18:31:13',	NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `code`, `role`, `username`, `password`, `first_name`, `last_name`, `company_name`, `date_of_birth`, `email`, `phone`, `avatar`, `gender`, `country`, `city`, `place`, `pin_code`, `address`, `description`, `status`, `deletable`, `editable`, `client_ip`, `login_at`, `logout_at`, `added_at`, `updated_at`, `deleted_at`) VALUES
(1,	'C1',	1,	'admin',	'$2y$10$6XeS4Sx0lGQzUWsqoSqaDOsaoM2wSVQAmDQg4viwBD4b5WAFw4SBu',	'Samnad',	'S',	'Cna',	'1992-10-30',	'admin@example.com',	'+91-0000000012',	NULL,	1,	'India',	'TVM',	'Trivandrum',	'695505',	'CyberLikes Pvt. Ltd.',	'something',	3,	0,	0,	'::1',	'2022-11-23 19:06:35',	'2022-10-27 17:42:33',	'2021-04-20 19:22:52',	'2022-11-23 19:06:35',	NULL),
(30,	'C2',	1,	'neo',	'$2y$10$KcBcIiTPhlaPmKDiuQmz/OzryKE4ZPgWf/ddgyCvmkXSHevNGeqL6',	'Neo',	'Andrew',	'And & Co.',	'2022-07-06',	'and@eff.c',	'5641511',	NULL,	1,	'Indo',	'Jarka',	'Imania',	'6950505',	'Feans Palace\r\nNew York',	'Something special',	15,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:20:23',	'2022-07-12 12:18:23',	NULL),
(31,	'C3',	1,	'markz',	'$2y$10$MwP6iXVdi0VrykbSVOq0EeL7L5x2YOnyrOUZZMIsPPLUjRgO2jLv.',	'Mark',	'Zuck',	'Meta',	'2022-07-20',	'mark@fb.com',	'61515141466',	NULL,	3,	'USA',	'Los Angels',	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-02 15:26:49',	'2022-07-12 12:18:17',	NULL),
(32,	'C4',	3,	'errerer',	'$2y$10$w/w8b2bLPzlFFw9mb3.abuYyyRhoQfGh24YPRwYhdWVNX5lbQV5Ja',	'ytyty',	'tytyty',	NULL,	'2022-07-14',	'gfgfg@f.ghgh',	'4454545445',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-03 10:38:07',	'2022-07-04 13:43:00',	'2022-07-04 13:43:00'),
(33,	'USER0033',	1,	'sfdfdsf',	'$2y$10$m3SCyOOEBf9x7zHoJD5nkuajcLI0MqPypDIsXo0zVE6pKwZ9ebP3u',	'dfdfsdf',	NULL,	NULL,	'2022-07-26',	'safdf@fdsfgdfg.ghgfh',	'7475454545',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	5,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 12:57:40',	'2022-07-06 16:37:47',	'2022-07-06 16:37:47'),
(34,	'USER0034',	1,	'sdfsdfsdf',	'$2y$10$X5g0UY6y6ciaAxYoHj//CeuwoWdwZ5S2v8qgVUAOyB.dirVZI1uyC',	'sdfdf',	'dfdfdsf',	NULL,	'2022-07-05',	'trt@ghjhg.fghfh',	'444544545',	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	3,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-04 13:09:49',	'2022-07-06 16:37:07',	'2022-07-06 16:37:07'),
(35,	'USER0035',	3,	'hjhgjhg',	'$2y$10$vUGaJ4qQGg7yHt1hbP9eZOIFzL5SHX.ynu.w.EUwiiZIlUFJMbSoi',	'gikghjg',	'jghjghjhgj',	NULL,	'2022-07-05',	'fdf@g.ghgh',	'7574544454',	NULL,	2,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	NULL,	NULL,	NULL,	'2022-07-06 16:38:36',	NULL,	NULL),
(36,	'USER0036',	3,	'dfdf',	'$2y$10$728Kvxh9olwHyXoUQ4Lq.e7aALAXdOO/s4zy3SNwi3464CYTWYfFS',	'dfdf',	'dfdfd',	NULL,	'2022-07-05',	'dfd@fsg.gdfgg',	'546464645645',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'::1',	'2022-07-07 07:50:50',	NULL,	'2022-07-06 16:45:10',	'2022-07-07 07:50:50',	'2022-07-06 16:45:25'),
(37,	'USER0037',	3,	'dfdfdf',	'$2y$10$.eYvj6.BMLYuGUDvlwSLnO4ZzR8OO8.SpB7Z/mR45zZUWIo/GJbMG',	'yuytuytu',	'ytuytu',	NULL,	'2022-07-12',	'ds@rtg.jghjg',	'5646456456',	NULL,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	NULL,	NULL,	'::1',	'2022-07-09 13:27:36',	NULL,	'2022-07-07 13:22:05',	'2022-07-09 13:55:29',	'2022-07-09 13:55:29');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender_id` bigint(20) unsigned NOT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `city` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `pin_code` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status_id` bigint(20) unsigned NOT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `login_ip` varchar(255) NOT NULL,
  `login_at` datetime DEFAULT NULL,
  `logout_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_gender_id_foreign` (`gender_id`),
  KEY `users_country_id_foreign` (`country_id`),
  KEY `users_status_id_foreign` (`status_id`),
  CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `users_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`),
  CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `users_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `variant`;
CREATE TABLE `variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `variants`;
CREATE TABLE `variants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variant` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `variant` (`variant`),
  CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`variant`) REFERENCES `variant` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `warehouse` (`id`, `code`, `name`, `place`, `date_of_open`, `country`, `city`, `pin_code`, `phone`, `email`, `address`, `longitude`, `latitude`, `description`, `status`, `status_reason`, `editable`, `deletable`, `added_at`, `updated_at`, `deleted_at`) VALUES
(20,	'WARE0020',	'Ware House AAA',	'dsds',	'2020-02-12',	'India',	'TVM',	'695505',	'+91-9745451448',	'tewest@gmail.com',	'TVM',	NULL,	NULL,	'lklkl',	16,	'Flood',	NULL,	NULL,	'2021-04-14 19:54:53',	'2022-08-27 06:30:31',	NULL),
(27,	'WARE0027',	'Ware House BBB',	'KMD',	'2022-07-01',	'Innnn',	'Ciiiii',	NULL,	'9745451448',	'sdsds@g.ghh',	'Addddddd',	NULL,	NULL,	'Desssssssssss',	16,	'Some',	NULL,	NULL,	'2022-07-05 12:01:17',	'2022-09-12 06:08:24',	NULL),
(33,	'WARE0033',	' bvbv',	'nbnvbnvbn',	'2022-09-08',	NULL,	NULL,	NULL,	'45454545',	'bnvbn@qqwqw.ghg',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-09-11 07:52:55',	'2022-11-01 11:50:03',	'2022-11-01 11:50:03'),
(34,	'WARE0034',	'Closed Ware house',	'ddfgdfdf',	'2022-11-29',	NULL,	NULL,	NULL,	'54545435',	'fdf@fff.tyytry',	NULL,	NULL,	NULL,	NULL,	17,	NULL,	NULL,	NULL,	'2022-11-01 11:50:50',	NULL,	NULL);

DROP TABLE IF EXISTS `warehouses`;
CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `place` varchar(255) NOT NULL,
  `date_of_open` date DEFAULT NULL,
  `country_id` bigint(20) unsigned NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status_id` bigint(20) unsigned NOT NULL,
  `status_reason` varchar(255) NOT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `warehouses_code_unique` (`code`),
  UNIQUE KEY `warehouses_email_unique` (`email`),
  KEY `warehouses_country_id_foreign` (`country_id`),
  KEY `warehouses_status_id_foreign` (`status_id`),
  CONSTRAINT `warehouses_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  CONSTRAINT `warehouses_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `warehouses` (`id`, `code`, `name`, `place`, `date_of_open`, `country_id`, `city`, `pin_code`, `phone`, `email`, `email_verified_at`, `address`, `longitude`, `latitude`, `description`, `status_id`, `status_reason`, `locked`, `created_at`, `updated_at`, `deleted_at`) VALUES
(858,	'WH-4121',	'Monahan, Lang and Beatty',	'KqpVhlCnUuNrQsNeam5s',	'1994-05-07',	1,	NULL,	NULL,	'830.385.9478',	'AjlWz1pYlE@gmail.com',	NULL,	'17986 Glover Crescent\nNew Jaunitastad, SC 98974',	NULL,	NULL,	NULL,	18,	'7Zl0p',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(859,	'WH-9912',	'Kirlin, O\'Connell and Herzog',	'oCIZv1vdM7TypA1pkrt9',	'1976-07-31',	1,	NULL,	NULL,	'478-473-7697',	'YLPKYFMmQ7@gmail.com',	NULL,	'814 Sawayn Pine\nKrajcikburgh, NH 36820-2103',	NULL,	NULL,	NULL,	16,	'eWwR2',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(860,	'WH-4539',	'Bashirian-Kiehn',	'QxtzzhYDhJ78s8IaRjUD',	'1982-05-01',	1,	NULL,	NULL,	'973.452.9989',	'fKcxDews2M@gmail.com',	NULL,	'66927 Harvey Island\nAshleetown, ID 84510-5738',	NULL,	NULL,	NULL,	19,	'0m2xl',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(861,	'WH-3028',	'Greenholt Inc',	'MK4JVwafNy2h4IBoIa3X',	'2011-12-20',	1,	NULL,	NULL,	'+1.409.438.7759',	'4EQyLWQwEL@gmail.com',	NULL,	'19033 O\'Reilly Crossing\nNorth Heaven, MO 59199-5631',	NULL,	NULL,	NULL,	19,	'UVXjK',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(862,	'WH-5916',	'Schumm Ltd',	'1Z6Kgdr1Q8BBsds4s3Ct',	'1978-05-11',	1,	NULL,	NULL,	'+1 (541) 697-2327',	'2vECGHGQFh@gmail.com',	NULL,	'5022 Maeve Oval Apt. 596\nWest Malika, OK 89449-6322',	NULL,	NULL,	NULL,	18,	'tB8UJ',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(863,	'WH-4887',	'Schowalter, Rosenbaum and Morar',	'uruDPYPibe2nbAd5mXmw',	'1988-06-27',	1,	NULL,	NULL,	'+1.517.549.0130',	'mXhqc947Xe@gmail.com',	NULL,	'60461 Arianna Trace Apt. 280\nSouth Gertrude, ME 93035-2087',	NULL,	NULL,	NULL,	19,	'K0uyI',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(864,	'WH-1662',	'Johnston Ltd',	'tcwy1xPCArRVE2fO4W9v',	'2022-08-24',	1,	NULL,	NULL,	'1-848-454-1966',	'GLgsEmakTo@gmail.com',	NULL,	'7613 Carter Ville\nPort Audiefort, ND 84341-0346',	NULL,	NULL,	NULL,	19,	'LxpHq',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(865,	'WH-953',	'Mann-Kovacek',	'ISiSyYZo7cRUaF42CFDz',	'1985-05-13',	1,	NULL,	NULL,	'+1 (681) 600-5794',	'BoqVRcbyGq@gmail.com',	NULL,	'486 Blanca Court\nStrackeburgh, MS 56904',	NULL,	NULL,	NULL,	19,	'eYV3u',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(866,	'WH-2299',	'Marvin-Spencer',	'MIjBkIX512brfNhrqESD',	'1984-05-22',	1,	NULL,	NULL,	'678.504.0782',	'KBS5QTW9TX@gmail.com',	NULL,	'83237 O\'Kon Lock Apt. 201\nBoganport, VA 30128-1805',	NULL,	NULL,	NULL,	19,	'LPMRr',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(867,	'WH-2292',	'Blick, Murphy and Jacobs',	'e2E2qVB68S9BOf4VWM38',	'2005-01-17',	1,	NULL,	NULL,	'(515) 216-3106',	'pYO2POqM9J@gmail.com',	NULL,	'729 Powlowski Roads\nJefferytown, OH 66171',	NULL,	NULL,	NULL,	17,	'aJmVr',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(868,	'WH-8691',	'Monahan PLC',	'mwy1WVLWHxB57Gb4OOpW',	'1979-10-04',	1,	NULL,	NULL,	'+1.305.750.5399',	'kyFSYI72s1@gmail.com',	NULL,	'428 Emiliano Pines\nNorth Gordon, TN 62606',	NULL,	NULL,	NULL,	19,	'0p3am',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(869,	'WH-252',	'Lynch, Ward and Smith',	'pWttIu33ErPnHkgt0vbo',	'2003-10-16',	1,	NULL,	NULL,	'520-439-0649',	'Vj2Sj0b88G@gmail.com',	NULL,	'6683 Green Branch\nCobytown, LA 27529',	NULL,	NULL,	NULL,	17,	'x9zXa',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(870,	'WH-4594',	'Windler Inc',	'6RrzyRtSg5XATFgtOJR0',	'1974-11-28',	1,	NULL,	NULL,	'509-434-5882',	'X9GklPJlRJ@gmail.com',	NULL,	'48654 Shea Squares Suite 496\nSouth Ladariusberg, KY 69332-9592',	NULL,	NULL,	NULL,	19,	'A5F6Y',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(871,	'WH-1666',	'Corwin PLC',	'y14RICQZYrW8Ex5EjSin',	'2021-04-09',	1,	NULL,	NULL,	'838.597.8791',	'cxjjQsfXKb@gmail.com',	NULL,	'557 Deckow Route\nNorth Ashtynbury, UT 45847-7349',	NULL,	NULL,	NULL,	16,	'blq7e',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(872,	'WH-2788',	'Johns, Adams and Murphy',	'YE8kGHT7neSAIQ35OF8Z',	'2013-02-22',	1,	NULL,	NULL,	'845.718.6935',	'dM0YnCK5l6@gmail.com',	NULL,	'46935 Hirthe Prairie\nGrantfurt, OK 45473',	NULL,	NULL,	NULL,	19,	'CyQPj',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(873,	'WH-5345',	'Botsford-Brekke',	'A6PqXF2bAKZxP6PrXHiK',	'2016-06-18',	1,	NULL,	NULL,	'346.830.2875',	'DuQfeJjo10@gmail.com',	NULL,	'432 Larkin Estate Apt. 425\nBashirianchester, NJ 12899',	NULL,	NULL,	NULL,	18,	'EQppp',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(874,	'WH-66',	'Gleichner, Collins and Runolfsson',	'Q3YBhIeaHmm6oYgMdZFy',	'2016-07-14',	1,	NULL,	NULL,	'315.346.1871',	'YVlj1721DW@gmail.com',	NULL,	'2048 Manuela Road Suite 018\nLefflerstad, WA 91996-8024',	NULL,	NULL,	NULL,	18,	'3Xsvs',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(875,	'WH-4936',	'Rippin-Rau',	'HPVuRXUGUD00rukGVMdm',	'1979-08-04',	1,	NULL,	NULL,	'269-895-2454',	'i5opSxG5bt@gmail.com',	NULL,	'404 Rippin Underpass Apt. 061\nKeanushire, SC 61789-4693',	NULL,	NULL,	NULL,	16,	'MRYSh',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(876,	'WH-2682',	'Considine, Simonis and Howell',	'aoKLciykdWbtAzLl8SJj',	'1974-09-30',	1,	NULL,	NULL,	'1-445-697-3108',	'vsP94ZMu4a@gmail.com',	NULL,	'879 Unique Keys Suite 576\nLake Raquelmouth, AR 25808',	NULL,	NULL,	NULL,	18,	'L8iTI',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(877,	'WH-6851',	'Cartwright, Greenfelder and Considine',	'eBRKJy63zLz982S1stjf',	'2009-06-12',	1,	NULL,	NULL,	'+1-858-515-7731',	'3NeC68qRoN@gmail.com',	NULL,	'420 Ben Fort Suite 567\nCarrollburgh, WA 25645',	NULL,	NULL,	NULL,	18,	'Ax1b6',	NULL,	'2023-01-29 10:01:24',	'2023-01-29 10:01:24',	NULL),
(878,	'WH-8989',	'Olson-Mitchell',	'iYe1ET1cL5rT4haAB11M',	'1989-12-10',	1,	NULL,	NULL,	'+17032358508',	'IactEvgYfj@gmail.com',	NULL,	'20074 Lakin Ways\nSatterfieldberg, ND 56606-2207',	NULL,	NULL,	NULL,	18,	'VEVDE',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(879,	'WH-1130',	'Bailey-Rath',	'dyfpmqvx9yMc0rRrBcKU',	'1986-05-06',	1,	NULL,	NULL,	'+1.862.970.6060',	'tWqyKxFDfm@gmail.com',	NULL,	'1732 Henry Circle\nSouth Ginoton, WA 84290-6852',	NULL,	NULL,	NULL,	16,	'xQbhy',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(880,	'WH-8259',	'Hermann, Gibson and Oberbrunner',	'IGbQ9Eet3M1wdLICvzbb',	'1993-05-11',	1,	NULL,	NULL,	'(347) 655-8038',	'Ye6mqjPU2m@gmail.com',	NULL,	'29405 Liliana Spurs Apt. 811\nPollichville, GA 44031',	NULL,	NULL,	NULL,	16,	'quTlK',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(881,	'WH-788',	'Johnson, Kilback and Heathcote',	'iXhwjpNALc1gi9Cg6ynh',	'1990-12-13',	1,	NULL,	NULL,	'+1-313-654-3808',	'aD70Sh4HWx@gmail.com',	NULL,	'8939 Hill Mews\nChristianamouth, OR 28183-4196',	NULL,	NULL,	NULL,	18,	'ciEG5',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(882,	'WH-9922',	'Dietrich LLC',	'LMCVO8fmI1qpoApHx6yE',	'2022-12-30',	1,	NULL,	NULL,	'786-227-2137',	'JcrJs6KrqT@gmail.com',	NULL,	'530 Walsh Motorway\nRobbmouth, NE 26220',	NULL,	NULL,	NULL,	17,	'yB1X4',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(883,	'WH-1755',	'Swift-Haag',	'h1P6JJecXWnuHww1pQMH',	'1981-05-05',	1,	NULL,	NULL,	'1-682-552-8893',	'qxFuKq8E0g@gmail.com',	NULL,	'408 Stark Road Suite 073\nSmithamfurt, AL 22273',	NULL,	NULL,	NULL,	16,	'WKdwj',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(884,	'WH-5457',	'Greenfelder and Sons',	'G7K2n5MUc3GXuQ82BFq7',	'1996-05-14',	1,	NULL,	NULL,	'908-828-1197',	'Vh1FeQIWfQ@gmail.com',	NULL,	'485 Sabrina Spring Suite 959\nNew Sabrynatown, MN 72142',	NULL,	NULL,	NULL,	17,	'SXEbQ',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(885,	'WH-8252',	'Huels-Kerluke',	'krUdLcfwZcbgOUrmLCr9',	'1973-04-11',	1,	NULL,	NULL,	'+1-534-860-3000',	'hcBeX2m53p@gmail.com',	NULL,	'743 Shields Passage\nLake Eliane, MO 61784-6925',	NULL,	NULL,	NULL,	18,	'prrov',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(886,	'WH-4533',	'Ferry Ltd',	'TJiAYQv4aI0jLQByhv2q',	'2017-11-11',	1,	NULL,	NULL,	'(530) 903-8346',	'bXnajnWhJP@gmail.com',	NULL,	'44636 Gerlach Mews Suite 944\nHuelfort, NJ 92691',	NULL,	NULL,	NULL,	19,	'vVnlW',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(887,	'WH-9599',	'Osinski and Sons',	'migcUkRT6M8aUuTnsCCV',	'1972-07-25',	1,	NULL,	NULL,	'+1-520-885-5690',	'fpflNmGIMA@gmail.com',	NULL,	'161 Gislason Garden\nWest Princessburgh, WY 66229',	NULL,	NULL,	NULL,	19,	'TXDTx',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(888,	'WH-5182',	'McDermott Group',	'7iYmlTX3RWbdWrnTqbut',	'1992-06-26',	1,	NULL,	NULL,	'434.545.4771',	'K0xDbFTcn4@gmail.com',	NULL,	'35502 Zachary Knoll Suite 015\nEast Joesphfort, NY 45291',	NULL,	NULL,	NULL,	16,	'U4PIp',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(889,	'WH-4689',	'Waters, Purdy and Bartoletti',	'CEi9ThiqNEHulmOPHuEW',	'2020-02-27',	1,	NULL,	NULL,	'+17196512959',	'XKfg0eoa2J@gmail.com',	NULL,	'88496 Orpha Trafficway Suite 847\nRennerchester, NC 71850-5986',	NULL,	NULL,	NULL,	17,	'INuJY',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(890,	'WH-5415',	'Kovacek, Hammes and Turner',	'ZCdOga4p8zpeFLRs5ULJ',	'2016-05-10',	1,	NULL,	NULL,	'+1-434-804-9911',	'rdKOEEygN8@gmail.com',	NULL,	'48247 Queen Vista Suite 423\nWest Biankastad, OR 90897-4565',	NULL,	NULL,	NULL,	16,	'6p7tG',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(891,	'WH-2725',	'Moore Inc',	'Y8sTDC7cLJi7GpUUaOTs',	'1993-12-30',	1,	NULL,	NULL,	'480-790-7134',	'pfXP6BMoOJ@gmail.com',	NULL,	'327 Schroeder Shore\nWatsonton, HI 48050',	NULL,	NULL,	NULL,	19,	'QkxKi',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(892,	'WH-4981',	'Gusikowski Group',	'778LxrIq4poFU2cP6OLy',	'2010-12-20',	1,	NULL,	NULL,	'+1 (623) 841-0384',	'ubb3nJdfO9@gmail.com',	NULL,	'243 Sanford Tunnel Suite 429\nNorth Sadiemouth, TN 22158',	NULL,	NULL,	NULL,	18,	'CPsyE',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(893,	'WH-3259',	'Quigley Inc',	'aqgO84zX6GpKtjOrWoT0',	'2002-03-04',	1,	NULL,	NULL,	'1-315-428-4754',	'31AMO5K5kK@gmail.com',	NULL,	'63838 Schroeder Landing\nEmmittborough, WI 77618-3675',	NULL,	NULL,	NULL,	19,	'd3W6u',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(894,	'WH-5286',	'Stamm-Treutel',	'ZrgqAy1SXTyoTuY6AgoK',	'1988-04-13',	1,	NULL,	NULL,	'+1-580-554-8858',	'wimMFDjsXu@gmail.com',	NULL,	'2602 Osinski Flat Suite 501\nSouth Garnett, ID 89481',	NULL,	NULL,	NULL,	19,	'LOj9a',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(895,	'WH-3850',	'Lang, Lang and Heller',	'88IOERW0Nh5MzyQpf35S',	'1990-06-14',	1,	NULL,	NULL,	'320.999.3813',	'tfaK77VLtZ@gmail.com',	NULL,	'8386 Katheryn Grove\nQuitzonhaven, RI 84669',	NULL,	NULL,	NULL,	18,	'bqve6',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(896,	'WH-7855',	'Veum, Yundt and Wisozk',	'AYvC4K850bcpwU3ncGYd',	'1983-08-13',	1,	NULL,	NULL,	'1-930-623-5027',	'iQ23jj9wNy@gmail.com',	NULL,	'582 Kuhn Pike\nPort Diannaburgh, FL 83245-3986',	NULL,	NULL,	NULL,	19,	'nQp8k',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(897,	'WH-6535',	'Okuneva Ltd',	'pKEz9nUel17obAdIq4rj',	'1981-11-26',	1,	NULL,	NULL,	'1-650-525-0225',	'1MZGnJmbZA@gmail.com',	NULL,	'48753 Morissette Divide Apt. 404\nNorth Wayne, NH 85538',	NULL,	NULL,	NULL,	16,	'gvhv2',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(898,	'WH-8928',	'Morissette, Casper and Cole',	'ftzZTEuBLUJ4Y5xDq5OE',	'2007-09-25',	1,	NULL,	NULL,	'+1-872-626-9580',	'F6UKzgcn6u@gmail.com',	NULL,	'1379 Rosenbaum Ways Apt. 661\nRomagueraport, TX 53015',	NULL,	NULL,	NULL,	17,	'ueoMw',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(899,	'WH-126',	'Jenkins-Powlowski',	'86tnWkR0ZXuAk7bWMe92',	'1985-01-04',	1,	NULL,	NULL,	'+1-207-285-4589',	'bcMnKpGBTZ@gmail.com',	NULL,	'4680 Gottlieb Inlet Apt. 261\nLake Pierce, OH 78533',	NULL,	NULL,	NULL,	17,	'AraYh',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(900,	'WH-5053',	'Reichert-Pfannerstill',	'vxZfaMPrSxtZrwyhOqtO',	'1970-04-12',	1,	NULL,	NULL,	'+1-530-274-9046',	'SgfzxcamFW@gmail.com',	NULL,	'8402 Treutel Ways Apt. 292\nBrannonmouth, OH 61541',	NULL,	NULL,	NULL,	18,	'r3AcK',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(901,	'WH-9571',	'Huel PLC',	'JByWGXXu9lku0bTeiJxG',	'2010-02-03',	1,	NULL,	NULL,	'534.221.4147',	'0H0U4VjUsc@gmail.com',	NULL,	'6046 Alayna Isle\nLindmouth, PA 96826',	NULL,	NULL,	NULL,	19,	'fDTZB',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(902,	'WH-5583',	'Boyer, Krajcik and Schinner',	'f0KMin5PQiGhcDlND2jM',	'1995-03-02',	1,	NULL,	NULL,	'+1-786-496-7390',	'QL1LsMXztc@gmail.com',	NULL,	'4031 Jast Radial Apt. 477\nEllieville, SC 28424',	NULL,	NULL,	NULL,	19,	'weYWA',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(903,	'WH-3284',	'Kutch-Ullrich',	'1WsNR5PsLLFz2Ee4o680',	'1990-08-26',	1,	NULL,	NULL,	'(801) 876-2885',	'6ZRX3Cdkjw@gmail.com',	NULL,	'123 Flo Crossing Apt. 454\nDrewborough, FL 12981-5115',	NULL,	NULL,	NULL,	18,	'foK0c',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(904,	'WH-7195',	'Turcotte PLC',	'u2Ynt9lDJs9x7n5T2tQ8',	'1973-01-12',	1,	NULL,	NULL,	'+1-689-338-8508',	'ZxhKseuQ3y@gmail.com',	NULL,	'9607 Schultz Motorway\nWest Norbertomouth, WV 65756',	NULL,	NULL,	NULL,	18,	'c34IC',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(905,	'WH-9351',	'Koepp-Abbott',	'evWpXXNm514ZG43PkcHu',	'1983-05-07',	1,	NULL,	NULL,	'(870) 615-5431',	'cAgYHYCu26@gmail.com',	NULL,	'112 Harber Hills\nNew Jailyn, GA 42168',	NULL,	NULL,	NULL,	18,	'nvRaB',	NULL,	'2023-01-29 10:01:25',	'2023-01-29 10:01:25',	NULL),
(906,	'WH-6734',	'Boyer-Schowalter',	'VWkOaqivcgXZx73OafyL',	'1997-08-13',	1,	NULL,	NULL,	'+17542698098',	'5LAnUdG7qq@gmail.com',	NULL,	'93353 Doyle Groves Suite 771\nWatersville, TN 96010-6424',	NULL,	NULL,	NULL,	16,	'Cg74I',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(907,	'WH-665',	'Torphy PLC',	'uic1X0i4oNshVt66HuwL',	'2017-02-15',	1,	NULL,	NULL,	'1-864-987-6028',	'W9hgnaWG0n@gmail.com',	NULL,	'3721 Frami Cove\nElmomouth, MT 01545-6111',	NULL,	NULL,	NULL,	19,	'bVZaa',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(908,	'WH-4977',	'Kling-Ryan',	'5q91yDvyz2l3z48x1xT6',	'2017-05-16',	1,	NULL,	NULL,	'757.748.8591',	'VvZ3JljJPH@gmail.com',	NULL,	'205 Runolfsdottir Point Suite 234\nScarlettmouth, OK 98064',	NULL,	NULL,	NULL,	16,	'rqVVm',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(909,	'WH-9899',	'Dickinson Group',	'olwkpT1MTQBSYB7TRnqC',	'2012-04-13',	1,	NULL,	NULL,	'325.395.8517',	'T6Kkayr14k@gmail.com',	NULL,	'242 Judge Plaza\nReingerside, DC 41605-6109',	NULL,	NULL,	NULL,	16,	'0i7z2',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(910,	'WH-8832',	'Wisozk-Hickle',	'S5OmpCfJQDx2gR2ujmnE',	'2001-10-28',	1,	NULL,	NULL,	'(270) 351-5298',	'qCgHWPskNw@gmail.com',	NULL,	'2709 Missouri Loop\nSouth Lorenview, MD 41044-9615',	NULL,	NULL,	NULL,	17,	'dHi3X',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(911,	'WH-3575',	'Wiza, Streich and King',	'EVMH0rxFlzwaRnXXcaLz',	'1988-01-16',	1,	NULL,	NULL,	'1-678-733-2942',	'WXcztmm1Di@gmail.com',	NULL,	'75218 Deckow Well\nEast Rethastad, MD 78125-9997',	NULL,	NULL,	NULL,	16,	'mEidx',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(912,	'WH-9337',	'Gerlach-Kerluke',	'WkIf5IuV8KsTwwo2uhAs',	'1989-12-17',	1,	NULL,	NULL,	'(240) 597-7505',	'MVosInWKEm@gmail.com',	NULL,	'927 Daniel Pass Suite 219\nLake Margaritashire, CA 66982',	NULL,	NULL,	NULL,	19,	'YtVFr',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(913,	'WH-6874',	'Hermann, Price and Schaefer',	'K1CUmqhXoXMw6FHHn7Bv',	'2008-11-22',	1,	NULL,	NULL,	'239-337-4505',	'FJGc3rVQk0@gmail.com',	NULL,	'631 Wilhelmine Mission\nLake Lomabury, OK 05148-6349',	NULL,	NULL,	NULL,	17,	'XxKTd',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(914,	'WH-5409',	'Flatley, O\'Connell and Moen',	'Ky4dB61SyBgZzKVDHip9',	'1998-09-13',	1,	NULL,	NULL,	'520-767-2799',	'1IhxVHJYWu@gmail.com',	NULL,	'89990 Branson Islands Suite 098\nPaytonport, OR 17319-8581',	NULL,	NULL,	NULL,	18,	'chAUI',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(915,	'WH-1002',	'Purdy, Wuckert and Simonis',	'CYnHh2xVcub51opzyc2L',	'2008-08-24',	1,	NULL,	NULL,	'(772) 247-5026',	'VqCAQqZV3s@gmail.com',	NULL,	'2329 Krista Gateway Apt. 245\nLake Magdalen, SC 55547-3879',	NULL,	NULL,	NULL,	19,	'ENZsF',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(916,	'WH-3475',	'Dooley PLC',	'qTzy78dRG9BOIEWzNBDP',	'1990-03-16',	1,	NULL,	NULL,	'(262) 688-8806',	'8OU2efT3l3@gmail.com',	NULL,	'66886 Robin Hill\nNorth Macyhaven, MD 58124',	NULL,	NULL,	NULL,	17,	'adC2Y',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(917,	'WH-2395',	'Graham and Sons',	'GoHSgWmg5bTMv8bhRLvc',	'1993-10-15',	1,	NULL,	NULL,	'+1-781-951-5124',	'N1EmUvTyeS@gmail.com',	NULL,	'99163 Dare Fields\nFlatleyhaven, AL 48328',	NULL,	NULL,	NULL,	18,	'p0sVy',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(918,	'WH-5566',	'Willms-Smith',	'21IA1ATNH4bGscXy27VC',	'2007-11-05',	1,	NULL,	NULL,	'352.471.5189',	'LoqmwJ3Kbm@gmail.com',	NULL,	'525 Cathrine Burg\nEast Cedrick, AZ 12686-5610',	NULL,	NULL,	NULL,	16,	'9AQ39',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(919,	'WH-2438',	'Langosh-Brown',	'0C3E1syW9xU5KarVkZAP',	'1984-01-28',	1,	NULL,	NULL,	'239-689-1709',	'j0waO6z4FL@gmail.com',	NULL,	'798 Rohan Mountains\nSouth Coty, CT 66246-9776',	NULL,	NULL,	NULL,	17,	'uU9GP',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(920,	'WH-8075',	'Becker, Boyer and Hagenes',	'vuVXWBjnDe0Nx1Y0Radn',	'1986-12-03',	1,	NULL,	NULL,	'385.458.1196',	'o5KqJGuxOu@gmail.com',	NULL,	'15234 Jovan Ridge\nStromanside, AK 71022-7805',	NULL,	NULL,	NULL,	19,	'0TRb0',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(921,	'WH-6885',	'Mosciski Ltd',	'4NvQEHrAl6CYc3bg01yJ',	'1994-01-30',	1,	NULL,	NULL,	'770-293-2006',	'qXYqKTBxRo@gmail.com',	NULL,	'312 Mraz Fort\nSchambergerberg, WV 31987',	NULL,	NULL,	NULL,	19,	'ARCbb',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(922,	'WH-825',	'Mitchell-Bashirian',	'ZMQYFOoAHJOxBb9ZsNvN',	'2001-07-07',	1,	NULL,	NULL,	'+1-361-493-5738',	'KZt7JWBok9@gmail.com',	NULL,	'7210 Breitenberg Curve\nLake Lindastad, NY 89521-6152',	NULL,	NULL,	NULL,	17,	'yeDYR',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(923,	'WH-3512',	'O\'Hara, Gulgowski and Bartoletti',	'5fGI1ejy4vqYfu6Y6Iqz',	'1984-10-20',	1,	NULL,	NULL,	'(458) 672-5372',	'ArUeJ1EwCG@gmail.com',	NULL,	'91781 Marks Mills\nLake Elyssa, MT 02845-7514',	NULL,	NULL,	NULL,	17,	'C2Llb',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(924,	'WH-5292',	'Medhurst, Gutkowski and Ziemann',	'NE39HfXei7J5XYn7GRZy',	'2022-12-18',	1,	NULL,	NULL,	'347.932.0811',	'isxDyxV2Jh@gmail.com',	NULL,	'754 Nolan Place\nBatzton, FL 18364-5438',	NULL,	NULL,	NULL,	19,	'zR2cR',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(925,	'WH-7494',	'Bosco, Stanton and Franecki',	'UJi5FnkI0SLgDWO8bpml',	'1993-04-12',	1,	NULL,	NULL,	'(281) 726-4611',	'1ioggfIACi@gmail.com',	NULL,	'406 Korey Rest\nSouth Theodoramouth, IN 96450',	NULL,	NULL,	NULL,	16,	'ySzi4',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(926,	'WH-7827',	'Cruickshank-Huels',	't6rZDPRi7Z1HK8ciZp6v',	'1980-12-04',	1,	NULL,	NULL,	'1-662-549-1929',	'8PgAqqsAfh@gmail.com',	NULL,	'43512 Omari Prairie Apt. 683\nMarafurt, AZ 16560-2940',	NULL,	NULL,	NULL,	18,	'6FKv5',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(927,	'WH-8428',	'Ortiz, Koelpin and Nitzsche',	'gBZswtqe9RkHWMQ8yQH8',	'2017-03-20',	1,	NULL,	NULL,	'+1.551.845.5420',	'umHLnowqI8@gmail.com',	NULL,	'8848 Margaret Forks Suite 007\nJakubowskiport, AL 13392-6384',	NULL,	NULL,	NULL,	19,	'yv1bf',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(928,	'WH-5289',	'Sauer PLC',	'0vQxO3bcwowfcJujC5Wq',	'1986-09-13',	1,	NULL,	NULL,	'+1.681.757.9178',	'9junEZ5ElX@gmail.com',	NULL,	'50647 Sanford Spurs\nNorth Jordon, HI 38540-6842',	NULL,	NULL,	NULL,	17,	'0iRGN',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(929,	'WH-7200',	'Donnelly-Thompson',	'axj60KjnAkNzzP1DLH9S',	'1996-12-26',	1,	NULL,	NULL,	'760-551-0669',	'yv7fApGCCk@gmail.com',	NULL,	'9452 Daniel Shoal\nEast Warrentown, MI 50218-7187',	NULL,	NULL,	NULL,	18,	'Wzfk0',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(930,	'WH-3574',	'Pollich-Okuneva',	'COE4cIYryPt6MANfc6at',	'1999-08-15',	1,	NULL,	NULL,	'838.984.9286',	'pU4utG2kSp@gmail.com',	NULL,	'760 Iliana Islands\nPort Dustytown, IN 88176-4309',	NULL,	NULL,	NULL,	18,	'oQdBB',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(931,	'WH-2433',	'Becker-Sawayn',	'S6AkwX2NuMFzHY1VVWFQ',	'1990-07-23',	1,	NULL,	NULL,	'442-269-0591',	'ofDlUwRbzo@gmail.com',	NULL,	'4768 Justina Underpass\nBlockton, AL 96668-3951',	NULL,	NULL,	NULL,	19,	'kOEkE',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(932,	'WH-6293',	'Abshire, Rosenbaum and Stroman',	'dtrLuUaZ06Kx89T9Yhgr',	'1980-03-17',	1,	NULL,	NULL,	'+1 (463) 978-9073',	'2VL1Xb4Ph8@gmail.com',	NULL,	'70480 Matt Club\nWest Nikita, OK 60692',	NULL,	NULL,	NULL,	18,	'VfwPo',	NULL,	'2023-01-29 10:01:26',	'2023-01-29 10:01:26',	NULL),
(933,	'WH-4415',	'Gottlieb-McDermott',	'twh31gzSBIhcJFRMzAtY',	'2005-01-08',	1,	NULL,	NULL,	'+1-509-910-5534',	'2L9re7rTb3@gmail.com',	NULL,	'81261 Gregg Station Suite 030\nDaughertymouth, IL 59293-9744',	NULL,	NULL,	NULL,	16,	'RdEz5',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(934,	'WH-8163',	'Balistreri, Goldner and Towne',	'DPYsaZYXN2dffafuXdbM',	'2000-03-16',	1,	NULL,	NULL,	'(248) 423-6976',	'fJO00fdMBL@gmail.com',	NULL,	'71816 Sallie Knolls\nTrevionport, NJ 42666',	NULL,	NULL,	NULL,	18,	'HR93G',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(935,	'WH-4118',	'Lubowitz-Turner',	'ZEGNXKxpR47O43f9QHJG',	'1996-08-20',	1,	NULL,	NULL,	'1-347-356-6722',	'cJbsgcvQ48@gmail.com',	NULL,	'421 Henri Summit\nShanahanport, ID 66939-1082',	NULL,	NULL,	NULL,	17,	'NyDX8',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(936,	'WH-5153',	'Bosco-Moore',	'WWo5G0CHj090zUloqOlw',	'1971-10-05',	1,	NULL,	NULL,	'+1-440-891-4772',	'WzwZheSQzV@gmail.com',	NULL,	'9700 Desiree Greens\nMicaelamouth, AK 49903-7090',	NULL,	NULL,	NULL,	18,	'd7CNf',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(937,	'WH-1922',	'Gutkowski, Stroman and Will',	'aSihEzmRaH4ryWRm2Dpj',	'1984-02-08',	1,	NULL,	NULL,	'+17176214527',	'fBEtFXbQTo@gmail.com',	NULL,	'3927 Kayla Squares Apt. 832\nWest Ronaldoport, PA 70159-9802',	NULL,	NULL,	NULL,	18,	'bifWa',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(938,	'WH-5662',	'Lang-Glover',	'mpyUuj27s8N9EWoulOQ4',	'2010-05-12',	1,	NULL,	NULL,	'737.842.5094',	'L3loE39Lur@gmail.com',	NULL,	'1698 Lockman Place\nGraceshire, DC 70464',	NULL,	NULL,	NULL,	18,	'a73YM',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(939,	'WH-9756',	'Kautzer-Collier',	'wSAx7zJiV0nyjfxvAt2j',	'1992-10-07',	1,	NULL,	NULL,	'1-910-886-2915',	'dXdTatI60O@gmail.com',	NULL,	'517 Gislason Inlet\nNorth Jaren, KY 29037',	NULL,	NULL,	NULL,	17,	'fblxI',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(940,	'WH-4818',	'Cartwright, Breitenberg and Hand',	'ULTDyXr9bPRSI0C7LjRk',	'1990-12-28',	1,	NULL,	NULL,	'+1-516-492-6786',	'5dc0DOBcny@gmail.com',	NULL,	'5049 Hortense Mills Suite 587\nWest Heloiseville, CA 28117',	NULL,	NULL,	NULL,	19,	'ASPed',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(941,	'WH-193',	'Ritchie PLC',	'tr6E7PS3QyHNvmjLY6MG',	'2020-05-06',	1,	NULL,	NULL,	'+1-234-489-2766',	'KCDZQRHRaB@gmail.com',	NULL,	'8320 Emil Ford Apt. 319\nFraneckihaven, ND 27902-8258',	NULL,	NULL,	NULL,	16,	'Rj8c0',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(942,	'WH-5239',	'Grant, Hintz and O\'Reilly',	'bPxExmrp6dSjkvudivSu',	'2013-05-16',	1,	NULL,	NULL,	'(585) 791-3513',	'NVjGvrqfuZ@gmail.com',	NULL,	'59764 Dorthy Corner Suite 309\nSouth Darrick, UT 26444',	NULL,	NULL,	'rtrtret',	17,	'EsiOY',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:56:47',	NULL),
(943,	'WH-6077',	'Jast-Wuckert',	'HLfhGwHriuis76718Pix',	'1973-07-02',	1,	NULL,	NULL,	'703-839-5022',	'5V9Bau1Bad@gmail.com',	NULL,	'164 Eden Viaduct\nTreutelbury, LA 79220',	NULL,	NULL,	NULL,	19,	'cA0hD',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(944,	'WH-3231',	'Nitzsche-Crona',	'MFzpzrvc0JocyfBso64c',	'2003-10-16',	1,	NULL,	NULL,	'1-262-982-7666',	'yIRFqvUEhK@gmail.com',	NULL,	'4080 Eloise Light Apt. 305\nNew Earleneport, RI 91492',	NULL,	NULL,	NULL,	17,	'Bh23a',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(945,	'WH-2757',	'Runolfsdottir, Jaskolski and Prohaska',	'aYAqxLXuqF0rQ12BRMZx',	'1988-06-22',	1,	NULL,	NULL,	'405-526-5150',	'843E9pHGNW@gmail.com',	NULL,	'325 Collier Row Suite 810\nWest Lynn, MD 43777-5519',	NULL,	NULL,	NULL,	18,	'Vbm1C',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(946,	'WH-5028',	'Skiles, Quitzon and Deckow',	'7DAlIg970qJfTmD0pakC',	'1993-08-27',	1,	NULL,	NULL,	'863-575-7488',	'pK8mwFJvct@gmail.com',	NULL,	'3641 Dagmar Rapids\nNikolausport, MT 19977',	NULL,	NULL,	NULL,	18,	'r0IgD',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(947,	'WH-4395',	'Hegmann-Swift',	'A76hEtWcTpTQvvyYSrZe',	'1984-05-31',	1,	NULL,	NULL,	'+1-339-672-0828',	'pETK7XqBey@gmail.com',	NULL,	'944 Lowe Estate Apt. 338\nWestleystad, KY 78098',	NULL,	NULL,	NULL,	18,	'ErJ9R',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(948,	'WH-5626',	'Durgan-Luettgen',	'XZWxFFl0Ar2r9LJcKnqM',	'1989-07-30',	1,	NULL,	NULL,	'+12314044889',	'fSnEdqv9kp@gmail.com',	NULL,	'688 Caterina Shore\nSouth Ramonaton, KY 61880',	NULL,	NULL,	NULL,	18,	'BV0eG',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(949,	'WH-6169',	'Towne Group',	'UOpzTd8qWkdALMMDpjA5',	'1972-02-08',	1,	NULL,	NULL,	'1-651-541-7205',	'nwNjG8yBQR@gmail.com',	NULL,	'70519 Tito Orchard\nDanielmouth, AL 05686',	NULL,	NULL,	NULL,	16,	'C7fAx',	NULL,	'2023-01-29 10:01:27',	'2023-01-29 10:01:27',	NULL),
(950,	'WH-3164',	'McCullough Ltd',	'vq585xMVZHT8JECdTruv',	'2017-07-31',	1,	NULL,	NULL,	'1-541-787-8679',	'uoopGnoweF@gmail.com',	NULL,	'287 Koby Landing Apt. 911\nMcDermottville, IA 52593',	NULL,	NULL,	NULL,	17,	'zXf1I',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:01:28',	NULL),
(951,	'WH-5622',	'Cole-Cummerata',	'cirOcwuzdSahkxxuUMtP',	'1989-01-04',	1,	NULL,	NULL,	'(270) 383-4742',	'r8RpEQgY89@gmail.com',	NULL,	'9002 Christ River\nTheronstad, NH 25096',	NULL,	NULL,	NULL,	18,	'nZAqr',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:01:28',	NULL),
(952,	'WH-1081',	'Borer LLC',	'xKbc2MzvmazZJms8ZeiO',	'1977-11-28',	1,	NULL,	NULL,	'1-430-632-0594',	'uWrsoAzUy7@gmail.com',	NULL,	'13276 Antonina Heights\nKihnville, FL 55891-9298',	NULL,	NULL,	NULL,	18,	'zCNPQ',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:01:28',	NULL),
(953,	'WH-6522',	'Cummings Group',	'HohbOvY3M1lIS6fEkdyg',	'1980-12-27',	2,	NULL,	NULL,	'380-922-6830',	'CQJhwwHxzt@gmail.com',	NULL,	'3697 Walsh Knoll\nBahringermouth, MT 74726-2595',	NULL,	NULL,	NULL,	19,	'gu40R',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:03:00',	NULL),
(954,	'WH-7479',	'Runolfsdottir-Cartwright',	'I8wfFbGhpjmn9lbjs59k',	'2010-08-22',	1,	NULL,	NULL,	'+1-364-967-0924',	'gCVnqOAoIq@gmail.com',	NULL,	'54360 Hickle Fords\nEast Jewelberg, SC 28293',	NULL,	NULL,	NULL,	18,	'AaLKn',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:02:47',	'2023-01-29 10:02:47'),
(955,	'WH-3713',	'McGlynn, Ebert and Schmidt',	'dl8at0S3pjIQVp0mPAic',	'1976-11-23',	1,	NULL,	NULL,	'+1-651-429-3817',	'GrOZMMmDbo@gmail.com',	NULL,	'460 Feest Fall Suite 795\nLake Palma, RI 04055-5436',	NULL,	NULL,	NULL,	17,	'amYWx',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:02:39',	'2023-01-29 10:02:39'),
(956,	'WH-8791',	'Nitzsche, Legros and Wilderman',	'BToOnAOtulBi1DVZLxqw',	'2013-09-10',	1,	NULL,	NULL,	'+1 (979) 977-7677',	'G6DTAOZY6L@gmail.com',	NULL,	'2397 Corwin Corner Apt. 049\nLabadieville, NJ 18266-5463',	NULL,	NULL,	NULL,	18,	'xkEMv',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:02:29',	'2023-01-29 10:02:29'),
(957,	'WH-905',	'Gottlieb LLC',	'e3Tzu3lv3TxxRq2usHSE',	'2018-03-25',	1,	NULL,	NULL,	'+1-269-665-8784',	'OjjBzlm9tX@gmail.com',	NULL,	'9352 Spinka Walk Apt. 806\nMillershire, MA 53798-8188',	NULL,	NULL,	NULL,	16,	'UKRlH',	NULL,	'2023-01-29 10:01:28',	'2023-01-29 10:02:24',	'2023-01-29 10:02:24'),
(958,	'WH-00958',	'erwerwer',	'werwerwe',	'2023-01-20',	1,	NULL,	NULL,	'34324234234324',	'r8RpEQgY89s@gmail.com',	NULL,	'yutyutyu',	NULL,	NULL,	NULL,	18,	'werewr',	NULL,	'2023-01-29 10:04:15',	'2023-01-29 10:55:55',	'2023-01-29 10:55:55'),
(959,	'WH-00959',	'fsdf',	'sdfsdfsdfdsf',	'2023-01-14',	2,	'dfsdsf',	'dfdsfdsf',	'545454545',	'pK8mrtrtwFJvct@gmail.com',	NULL,	'dfdsfdrhhj',	NULL,	NULL,	'fdsfdfdsfsdf',	16,	'sdfsdfdsdsdfgdfgfdg',	NULL,	'2023-01-29 10:50:23',	'2023-01-29 10:55:24',	NULL),
(960,	'WH-00960',	'fghfgh',	'hgfhgfh',	'2023-01-07',	1,	NULL,	NULL,	'4543544656',	'fghfgh@sdfgs.sfsdfdsf',	NULL,	NULL,	NULL,	NULL,	NULL,	19,	'dfdfdsfg',	NULL,	'2023-01-29 10:57:58',	'2023-01-29 11:07:10',	NULL),
(962,	'WH-00962',	'iouiouio',	'ioiuoo',	'2023-07-06',	1,	'jhkjhk',	'45646546456',	'45454545',	'ertre@rfet.fgfg',	NULL,	'gdgh',	NULL,	NULL,	'dfhdfhh',	16,	'yuiyuiuyi',	NULL,	'2023-07-08 18:16:35',	'2023-07-08 18:17:16',	'2023-07-08 18:17:16');

-- 2023-08-11 16:54:34
