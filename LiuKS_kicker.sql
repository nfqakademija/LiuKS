CREATE DATABASE  IF NOT EXISTS `liuks_kicker` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `liuks_kicker`;
-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: liuks_kicker
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `competitors`
--

DROP TABLE IF EXISTS `competitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `competitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tournament_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `round` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2DED50C633D1A3E7` (`tournament_id`),
  KEY `IDX_2DED50C6296CD8AE` (`team_id`),
  CONSTRAINT `FK_2DED50C6296CD8AE` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`),
  CONSTRAINT `FK_2DED50C633D1A3E7` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `competitors`
--

LOCK TABLES `competitors` WRITE;
/*!40000 ALTER TABLE `competitors` DISABLE KEYS */;
/*!40000 ALTER TABLE `competitors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user1` int(11) DEFAULT NULL,
  `user2` int(11) DEFAULT NULL,
  `user3` int(11) DEFAULT NULL,
  `user4` int(11) DEFAULT NULL,
  `team1` int(11) DEFAULT NULL,
  `team2` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `goals1` int(11) NOT NULL,
  `goals2` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FF232B318C518555` (`user1`),
  KEY `IDX_FF232B311558D4EF` (`user2`),
  KEY `IDX_FF232B31625FE479` (`user3`),
  KEY `IDX_FF232B31FC3B71DA` (`user4`),
  KEY `IDX_FF232B31E1002E4` (`team1`),
  KEY `IDX_FF232B319719535E` (`team2`),
  KEY `IDX_FF232B31ECFF285C` (`table_id`),
  KEY `IDX_FF232B3133D1A3E7` (`tournament_id`),
  CONSTRAINT `FK_FF232B311558D4EF` FOREIGN KEY (`user2`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_FF232B3133D1A3E7` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  CONSTRAINT `FK_FF232B31625FE479` FOREIGN KEY (`user3`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_FF232B318C518555` FOREIGN KEY (`user1`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_FF232B319719535E` FOREIGN KEY (`team2`) REFERENCES `teams` (`id`),
  CONSTRAINT `FK_FF232B31E1002E4` FOREIGN KEY (`team1`) REFERENCES `teams` (`id`),
  CONSTRAINT `FK_FF232B31ECFF285C` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
  CONSTRAINT `FK_FF232B31FC3B71DA` FOREIGN KEY (`user4`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'NFQ Kaunas');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user2` int(11) DEFAULT NULL,
  `user3` int(11) DEFAULT NULL,
  `user4` int(11) DEFAULT NULL,
  `user1` int(11) DEFAULT NULL,
  `tournament_id` int(11) DEFAULT NULL,
  `team1` int(11) DEFAULT NULL,
  `team2` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `approved1` tinyint(1) NOT NULL,
  `approved2` tinyint(1) NOT NULL,
  `approved3` tinyint(1) NOT NULL,
  `approved4` tinyint(1) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_62615BA1558D4EF` (`user2`),
  KEY `IDX_62615BA625FE479` (`user3`),
  KEY `IDX_62615BAFC3B71DA` (`user4`),
  KEY `IDX_62615BA8C518555` (`user1`),
  KEY `IDX_62615BA33D1A3E7` (`tournament_id`),
  KEY `IDX_62615BAE1002E4` (`team1`),
  KEY `IDX_62615BA9719535E` (`team2`),
  KEY `IDX_62615BAECFF285C` (`table_id`),
  CONSTRAINT `FK_62615BA1558D4EF` FOREIGN KEY (`user2`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_62615BA33D1A3E7` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`),
  CONSTRAINT `FK_62615BA625FE479` FOREIGN KEY (`user3`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_62615BA8C518555` FOREIGN KEY (`user1`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_62615BA9719535E` FOREIGN KEY (`team2`) REFERENCES `teams` (`id`),
  CONSTRAINT `FK_62615BAE1002E4` FOREIGN KEY (`team1`) REFERENCES `teams` (`id`),
  CONSTRAINT `FK_62615BAECFF285C` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`),
  CONSTRAINT `FK_62615BAFC3B71DA` FOREIGN KEY (`user4`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DA239A76ED395` (`user_id`),
  KEY `IDX_4DA239ECFF285C` (`table_id`),
  CONSTRAINT `FK_4DA239A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_4DA239ECFF285C` FOREIGN KEY (`table_id`) REFERENCES `tables` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `available_from` time NOT NULL,
  `available_to` time NOT NULL,
  `owner` int(11) NOT NULL,
  `api` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `private` tinyint(1) NOT NULL,
  `last_event_id` int(11) NOT NULL,
  `last_shake` int(11) NOT NULL,
  `free` tinyint(1) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84470221FE54D947` (`group_id`),
  KEY `IDX_84470221CF60E67C` (`owner`),
  CONSTRAINT `FK_84470221CF60E67C` FOREIGN KEY (`owner`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_84470221FE54D947` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,1,'Brastos g. 15, LT-47183','Kaunas','08:00:00','20:00:00',1,'http://wonderwall.ox.nfq.lt/kickertable/api/v1/events',1,0,0,1,0);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) DEFAULT NULL,
  `captain_id` int(11) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `games_won` int(11) NOT NULL,
  `games_played` int(11) NOT NULL,
  `total_goals` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `IDX_96C2225899E6F5DF` (`player_id`),
  KEY `IDX_96C222583346729B` (`captain_id`),
  CONSTRAINT `FK_96C222583346729B` FOREIGN KEY (`captain_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_96C2225899E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teams`
--

LOCK TABLES `teams` WRITE;
/*!40000 ALTER TABLE `teams` DISABLE KEYS */;
/*!40000 ALTER TABLE `teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournaments`
--

DROP TABLE IF EXISTS `tournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tournaments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organizer_id` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `IDX_E4BCFAC3876C4DDA` (`organizer_id`),
  CONSTRAINT `FK_E4BCFAC3876C4DDA` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournaments`
--

LOCK TABLES `tournaments` WRITE;
/*!40000 ALTER TABLE `tournaments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tournaments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facebookId` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `roles` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `games_played` int(11) NOT NULL,
  `games_won` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E17C91E8` (`facebookId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'802226453158747','ROLE_ADMIN, ROLE_USER','Laurynas','Baltrėnas','laruxo@gmail.com',NULL,'https://fbcdn-profile-a.akamaihd.net/hprofile-ak-xap1/v/t1.0-1/c44.44.552.552/s50x50/1098011_533977953316933_295705552_n.jpg?oh=30c411f7b160a7cf44909cfda1255c50&oe=559CE086&__gda__=1436559699_0e4d76acbe5e7361918f3e5933b8c8e4',0,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FF8AB7E0A76ED395` (`user_id`),
  KEY `IDX_FF8AB7E0FE54D947` (`group_id`),
  CONSTRAINT `FK_FF8AB7E0A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_FF8AB7E0FE54D947` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-18 14:23:14
