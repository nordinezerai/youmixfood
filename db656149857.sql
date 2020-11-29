-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  db656149857.db.1and1.com
-- Généré le :  Mar 03 Janvier 2017 à 17:57
-- Version du serveur :  5.5.52-0+deb7u1-log
-- Version de PHP :  5.4.45-0+deb7u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `db656149857`
--

DELIMITER $$
--
-- Fonctions
--
CREATE DEFINER=`dbo656149857`@`%` FUNCTION `FIND_SET_EQUALS`(`s1` VARCHAR(200), `s2` VARCHAR(200)) RETURNS tinyint(1)
BEGIN
          DECLARE a INT Default 0 ;
            DECLARE isEquals TINYINT(1) Default 0 ;
          DECLARE str VARCHAR(255);
          IF s1 IS NOT NULL AND s2 IS NOT NULL THEN
             simple_loop: LOOP
                 SET a=a+1;
                 SET str= SPLIT_STR(s1,",",a);
                 IF str='' THEN
                    LEAVE simple_loop;
                 END IF;
                 #Do  check is in set
                 IF FIND_IN_SET(str, s2)=0 THEN
                    SET isEquals=0;
                     LEAVE simple_loop;
                 END IF;
                 SET isEquals=1;
            END LOOP simple_loop;
          END IF;
        RETURN isEquals;
    END$$

CREATE DEFINER=`dbo656149857`@`%` FUNCTION `SPLIT_STR`(
  x VARCHAR(255),
  delim VARCHAR(12),
  pos INT
) RETURNS varchar(255) CHARSET latin1
RETURN REPLACE(SUBSTRING(SUBSTRING_INDEX(x, delim, pos),
       LENGTH(SUBSTRING_INDEX(x, delim, pos -1)) + 1),
       delim, '')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

CREATE TABLE IF NOT EXISTS `action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `action`
--

INSERT INTO `action` (`id`, `name`) VALUES
(1, 'couper'),
(2, 'mettre'),
(3, 'verser');

-- --------------------------------------------------------

--
-- Structure de la table `appareil`
--

CREATE TABLE IF NOT EXISTS `appareil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `etape`
--

CREATE TABLE IF NOT EXISTS `etape` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_id` int(11) NOT NULL,
  `ingredient_id` int(11) DEFAULT NULL,
  `appareil_id` int(11) DEFAULT NULL,
  `ustensile_id` int(11) DEFAULT NULL,
  `action_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `power` int(11) DEFAULT NULL,
  `um_quantity` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `um_power` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `typeEtape` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_285F75DD44AC3583` (`operation_id`),
  KEY `IDX_285F75DD933FE08C` (`ingredient_id`),
  KEY `IDX_285F75DDBF6A0032` (`appareil_id`),
  KEY `IDX_285F75DDB78A4282` (`ustensile_id`),
  KEY `IDX_285F75DD9D32F035` (`action_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Contenu de la table `etape`
--

INSERT INTO `etape` (`id`, `operation_id`, `ingredient_id`, `appareil_id`, `ustensile_id`, `action_id`, `quantity`, `power`, `um_quantity`, `um_power`, `time`, `typeEtape`) VALUES
(1, 1, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Ustensile'),
(2, 1, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'Action'),
(3, 1, 1, NULL, NULL, NULL, 2000, NULL, 'g', NULL, NULL, 'Ingredient'),
(4, 1, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 0, 'Action'),
(5, 1, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'Ustensile'),
(6, 2, 2, NULL, NULL, NULL, 400, NULL, 'mL', NULL, NULL, 'Ingredient'),
(7, 2, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, 0, 'Action'),
(8, 2, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, 'Ustensile');

-- --------------------------------------------------------

--
-- Structure de la table `gif`
--

CREATE TABLE IF NOT EXISTS `gif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `name`) VALUES
(1, 'blanc de poulet'),
(2, 'babeurre');

-- --------------------------------------------------------

--
-- Structure de la table `operation`
--

CREATE TABLE IF NOT EXISTS `operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gif_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1981A66DB75C3F80` (`gif_id`),
  KEY `IDX_1981A66D59D8A214` (`recipe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `operation`
--

INSERT INTO `operation` (`id`, `gif_id`, `recipe_id`, `description`) VALUES
(1, NULL, 1, 'couper le blanc de poulet en rondelle'),
(2, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`id`, `url`, `alt`) VALUES
(1, 'jpeg', 'pilonspouletcroustillant.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE IF NOT EXISTS `recipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `difficult` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `list_ingredient` longtext COLLATE utf8_unicode_ci NOT NULL,
  `views_number` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `person_number` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_DA88B137EE45BDBF` (`picture_id`),
  UNIQUE KEY `UNIQ_DA88B13729C1004E` (`video_id`),
  KEY `IDX_DA88B137A76ED395` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `recipe`
--

INSERT INTO `recipe` (`id`, `picture_id`, `video_id`, `user_id`, `name`, `type`, `difficult`, `time`, `list_ingredient`, `views_number`, `date`, `person_number`, `description`) VALUES
(1, 1, 1, 2, 'Poulet frit', 'Plat principal', 'Moyenne', 45, 'blanc de poulet,babeurre', 0, '2016-11-29 20:07:30', 4, 'Le poulet façon kfc :)');

-- --------------------------------------------------------

--
-- Structure de la table `search_criteria`
--

CREATE TABLE IF NOT EXISTS `search_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_access_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `google_id`, `google_access_token`) VALUES
(1, '112813970601979367317', '112813970601979367317', 'nordine.zerai@gmail.com', 'nordine.zerai@gmail.com', 1, 'pqturuqvaas4gcs8o0w88wcsosk0gsc', '112813970601979367317', '2017-01-03 05:48:57', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '112813970601979367317', 'ya29.CjDIA4VrncbM9biJo71UdoenBU8pZmEWiehfIEDGPX5bCPzstYXrd8RxCaN_2miTVtg'),
(2, '108573824146506940502', '108573824146506940502', 'samira.zerai@gmail.com', 'samira.zerai@gmail.com', 1, 'llitein3krkkkcgs4kwksowkscc8sks', '108573824146506940502', '2016-11-29 19:27:27', 0, 0, NULL, NULL, NULL, 'a:0:{}', 0, NULL, '108573824146506940502', 'ya29.Ci-lA0vATzFaaorDMz1ZYzbUAVD7jGzlnIEokZRmJ2xWHvYFdckVYHT_YQ-E2pHPGg');

-- --------------------------------------------------------

--
-- Structure de la table `ustensile`
--

CREATE TABLE IF NOT EXISTS `ustensile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `ustensile`
--

INSERT INTO `ustensile` (`id`, `name`) VALUES
(1, 'couteau'),
(2, 'saladier');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Contenu de la table `video`
--

INSERT INTO `video` (`id`, `url`) VALUES
(1, 'https://www.youtube.com/embed/f_RwyVgKNBk');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `etape`
--
ALTER TABLE `etape`
  ADD CONSTRAINT `FK_285F75DD9D32F035` FOREIGN KEY (`action_id`) REFERENCES `action` (`id`),
  ADD CONSTRAINT `FK_285F75DD44AC3583` FOREIGN KEY (`operation_id`) REFERENCES `operation` (`id`),
  ADD CONSTRAINT `FK_285F75DD933FE08C` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`),
  ADD CONSTRAINT `FK_285F75DDB78A4282` FOREIGN KEY (`ustensile_id`) REFERENCES `ustensile` (`id`),
  ADD CONSTRAINT `FK_285F75DDBF6A0032` FOREIGN KEY (`appareil_id`) REFERENCES `appareil` (`id`);

--
-- Contraintes pour la table `operation`
--
ALTER TABLE `operation`
  ADD CONSTRAINT `FK_1981A66D59D8A214` FOREIGN KEY (`recipe_id`) REFERENCES `recipe` (`id`),
  ADD CONSTRAINT `FK_1981A66DB75C3F80` FOREIGN KEY (`gif_id`) REFERENCES `gif` (`id`);

--
-- Contraintes pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `FK_DA88B137A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_DA88B13729C1004E` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`),
  ADD CONSTRAINT `FK_DA88B137EE45BDBF` FOREIGN KEY (`picture_id`) REFERENCES `picture` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
