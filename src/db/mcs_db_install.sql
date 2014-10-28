/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- Create database
CREATE DATABASE IF NOT EXISTS mcs CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Use database
USE mcs;

--
-- Character encoding setting
--
SET NAMES utf8;

--
-- 'user' table structure
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(40) NOT NULL,
  `password` VARCHAR(40) NOT NULL,
  `firstname` VARCHAR(40) NOT NULL,
  `lastname` VARCHAR(40) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `access_token` VARCHAR(40) NULL,
  `last_login_dt` INT(11) NULL,
  `create_dt` INT(11) NOT NULL,
  `update_dt` INT(11) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_uk` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- 'article' table structure
--
CREATE TABLE IF NOT EXISTS `article` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `create_dt` INT(11) NOT NULL,
  `update_dt` INT(11) NOT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- 'x_user_article' table structure
--
CREATE TABLE IF NOT EXISTS `x_user_article` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `article_id` INT(11) NOT NULL,
  `owner_flg` TINYINT(1) NOT NULL,
  `comment` TEXT NULL,
  `create_dt` INT(11) NOT NULL,
  `update_dt` INT(11) NOT NULL,
  `status` TINYINT(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



--
-- Master tables
--


--
-- 'x_user_article' table constrain
--
ALTER TABLE `x_user_article`
  ADD CONSTRAINT `x_user_article_fk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `x_user_article_fk_2` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);

