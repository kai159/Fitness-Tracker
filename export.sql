-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: fitnesstracker
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `eset`
--

DROP TABLE IF EXISTS `eset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rep` int(11) NOT NULL,
  `weight` decimal(6,3) NOT NULL,
  `fk_exercise` int(11) NOT NULL,
  `fk_training` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_exercise` (`fk_exercise`),
  KEY `fk_training` (`fk_training`),
  CONSTRAINT `eset_ibfk_1` FOREIGN KEY (`fk_exercise`) REFERENCES `exercise` (`id`),
  CONSTRAINT `eset_ibfk_2` FOREIGN KEY (`fk_training`) REFERENCES `training` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eset`
--

LOCK TABLES `eset` WRITE;
/*!40000 ALTER TABLE `eset` DISABLE KEYS */;
/*!40000 ALTER TABLE `eset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercise`
--

DROP TABLE IF EXISTS `exercise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exercise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `fk_user` int(11) NOT NULL,
  `picture` mediumblob DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user` (`fk_user`),
  CONSTRAINT `exercise_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise`
--

LOCK TABLES `exercise` WRITE;
/*!40000 ALTER TABLE `exercise` DISABLE KEYS */;
/*!40000 ALTER TABLE `exercise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` mediumblob DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_exercise`
--

DROP TABLE IF EXISTS `training_exercise`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training_exercise` (
  `fk_exercise` int(11) NOT NULL,
  `fk_training` int(11) NOT NULL,
  KEY `fk_exercise` (`fk_exercise`),
  KEY `fk_training` (`fk_training`),
  CONSTRAINT `training_exercise_ibfk_1` FOREIGN KEY (`fk_exercise`) REFERENCES `exercise` (`id`),
  CONSTRAINT `training_exercise_ibfk_2` FOREIGN KEY (`fk_training`) REFERENCES `training` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_exercise`
--

LOCK TABLES `training_exercise` WRITE;
/*!40000 ALTER TABLE `training_exercise` DISABLE KEYS */;
/*!40000 ALTER TABLE `training_exercise` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `passwordhash` char(64) NOT NULL,
  `time` datetime NOT NULL,
  `active_training` int(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (11,'admin','$2y$10$ET1kiT3tFkzKo35SqDSjAOIbKRPqP85MBbjknrl0JiCYGPrbWLHH6','2022-07-09 11:55:33',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_training`
--

DROP TABLE IF EXISTS `user_training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_training` (
  `fk_user` int(11) NOT NULL,
  `fk_training` int(11) NOT NULL,
  `time` datetime DEFAULT NULL,
  KEY `fk_user` (`fk_user`),
  KEY `fk_training` (`fk_training`),
  CONSTRAINT `user_training_ibfk_1` FOREIGN KEY (`fk_user`) REFERENCES `user` (`id`),
  CONSTRAINT `user_training_ibfk_2` FOREIGN KEY (`fk_training`) REFERENCES `training` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_training`
--

LOCK TABLES `user_training` WRITE;
/*!40000 ALTER TABLE `user_training` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_training` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-09 12:09:48
