-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES
(85,	'3',	0,	'2017-09-26 17:59:45'),
(86,	'5',	0,	'2017-09-26 17:59:48'),
(87,	'2',	0,	'2017-09-26 17:59:50'),
(88,	'1',	0,	'2017-09-26 17:59:51'),
(89,	'eutiu',	0,	'2017-09-26 18:12:20'),
(90,	'3wetry',	0,	'2017-09-26 18:13:39');

-- 2017-09-26 18:14:03
