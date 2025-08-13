-- AdminNeo 4.17.2 MySQL 8.0.35 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` int unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reviews` (`id`, `movie_id`, `name`, `email`, `review`, `created_at`) VALUES
(16,	13,	'Ion Ionescu',	'ion@yahoo.com',	'Is amazing!',	'2025-07-04 09:23:11'),
(17,	13,	'Ion Ionescu',	'ionescu@yahoo.com',	'I like this!',	'2025-07-04 09:29:04');

-- 2025-07-04 09:35:49 UTC
