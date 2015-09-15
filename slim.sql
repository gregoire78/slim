-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `slim`;
CREATE DATABASE `slim` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `slim`;

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `groups`;
INSERT INTO `groups` (`id`, `name`) VALUES
(1,	'simple utilisateur'),
(2,	'administrateur'),
(3,	'modérateur');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `streetAddress` varchar(250) DEFAULT NULL,
  `city` varchar(250) DEFAULT NULL,
  `postalcode` varchar(250) DEFAULT NULL,
  `phonenumber` varchar(10) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `date_register` datetime DEFAULT NULL,
  `id_group` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_group` (`id_group`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

TRUNCATE `users`;
INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `streetAddress`, `city`, `postalcode`, `phonenumber`, `ip`, `date_register`, `id_group`) VALUES
(1,	'Grégoire',	'Joncour',	'greg.autre@gmail.com',	'27 rue des fontaines',	'MAREIL SUR MAULDRE',	'78124',	'0134758420',	'192.168.59.104',	'2015-09-08 18:52:08',	2),
(2,	'Anne',	'Joncour',	'example@mail.com',	'1 avenue de la chardonniere',	'MAREIL SUR MAULDRE',	'78124',	'0134758420',	'192.168.59.104',	'2015-09-13 13:41:58',	1),
(3,	'Georges',	'Thierry',	'examole@email.com',	'20 rue Jean Baptiste Pigalle',	'PARIS',	'75009',	'0140230872',	'192.168.59.104',	'2015-09-08 21:21:45',	1),
(4,	'Alain',	'Joncour',	'example@email.com',	'9 place St Martin',	'BEYNES',	'78650',	'0130640406',	'192.168.59.104',	'2015-09-08 21:21:59',	1),
(5,	'Jacques',	'Joncour',	'example@email.com',	'Kerbrat',	'SAINT THEGONNEC',	'29410',	'0298780620',	'192.168.59.104',	'2015-09-08 22:39:56',	1),
(6,	'Michel',	'Drucker',	'michel.drucker@gmail.com',	'144 rue de l\'université',	'PARIS',	'75007',	'0134758420',	'192.168.59.104',	'2015-09-13 01:51:48',	3),
(7,	'Pauline',	'Dupont',	'exempla@email.com',	'44 rue Godefroy Cavaignac',	'PARIS',	'75011',	'0140099223',	'192.168.59.104',	'2015-09-13 02:50:12',	1),
(8,	'Nicolas',	'Sarkozy',	'exempla@email.com',	'52 boulevard Malesherbes',	'PARIS',	'78008',	'0143877307',	'192.168.0.1',	'2015-09-13 02:53:44',	2),
(10,	'Pierre',	'Lancelot',	'exempla@email.com',	'18 route de laubrière',	'BALLOTS',	'53350',	'0243065256',	'192.168.0.1',	'2015-09-13 02:58:00',	1),
(11,	'François',	'Hollande',	'exempla@email.com',	'55 Rue du Faubourg Saint-Honoré',	'PARIS',	'75008',	'0142928100',	'192.168.0.1',	'2015-09-13 19:07:58',	2),
(12,	'Frédéric',	'Plancqueel',	'exempla@email.com',	'10 allée du château',	'MAULE',	'78580',	'0130907410',	'192.168.0.1',	'2015-09-14 23:05:38',	1),
(13,	'Laurent',	'Richard',	'exempla@email.com',	'1 rue orléans',	'MAULE',	'78580',	'0130909064',	'192.168.0.1',	'2015-09-14 23:32:23',	2),
(14,	'Pierre',	'Picard',	'exempla@email.com',	'11 allée du dessus des prés',	'MAREIL SUR MAULDRE',	'78124',	'0684662756',	'192.168.0.1',	'2015-09-14 23:58:27',	1),
(15,	'truc',	'muche',	'exempla@email.com',	'27 rue des fontaines',	'MAREIL SUR MAULDRE',	'78124',	'0134758420',	'192.168.0.1',	'2015-09-15 00:15:16',	2),
(17,	'test',	'test',	'ghyff@email.com',	'test',	'TEST',	'78124',	'0000000000',	'192.168.0.1',	'2015-09-16 00:14:07',	1);

-- 2015-09-15 23:39:04
