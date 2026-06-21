-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: gallery
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.22.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nick` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `photo_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C7E9E4C8C` (`photo_id`),
  CONSTRAINT `FK_9474526C7E9E4C8C` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (6,'test@example.com','test@example.com','kocham Bajm!!','2026-06-18 22:24:54',8),(7,'admin@example.com','admin@example.com','let\'s cook','2026-06-19 13:40:43',19);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20260617235235','2026-06-18 01:52:54',1028),('DoctrineMigrations\\Version20260618004720','2026-06-18 02:47:46',5505),('DoctrineMigrations\\Version20260618005943','2026-06-18 02:59:59',1574),('DoctrineMigrations\\Version20260618012703',NULL,NULL),('DoctrineMigrations\\Version20260618015025','2026-06-18 15:47:54',4285),('DoctrineMigrations\\Version20260618134517',NULL,NULL),('DoctrineMigrations\\Version20260618145448','2026-06-18 16:55:01',7920),('DoctrineMigrations\\Version20260619104444','2026-06-19 12:44:59',1799),('DoctrineMigrations\\Version20260619105444','2026-06-19 12:54:46',1044),('DoctrineMigrations\\Version20260619112255','2026-06-19 13:22:56',2582);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (4,'ludzie'),(5,'Zwierzęta'),(6,'Owoce'),(8,'Inne');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_id` int DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14B784184E7AF8F` (`gallery_id`),
  CONSTRAINT `FK_14B784184E7AF8F` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` VALUES (4,'gesler','photo_6a34348cd57b25.60386085.jpg',4,NULL,'2026-06-19 00:00:00'),(5,'kiwi','photo_6a343b4b3ee9b0.07939559.jpg',6,NULL,'2026-06-19 00:00:00'),(6,'kot','photo_6a343b61dd57c8.54188338.jpg',5,NULL,'2026-06-19 00:00:00'),(7,'figa','photo_6a343b764d2ee9.32276723.jpg',6,NULL,'2026-06-19 00:00:00'),(8,'beata','photo_6a343b88271b65.47064903.jpg',4,NULL,'2026-06-19 00:00:00'),(9,'ania','photo_6a343b9e89e315.69963452.jpg',4,NULL,'2026-06-19 00:00:00'),(10,'pies','photo_6a343bb4c01b42.91839914.jpg',5,NULL,'2026-06-19 00:00:00'),(11,'lwy','photo_6a343bce963a80.63988203.jpg',5,NULL,'2026-06-19 00:00:00'),(12,'banan','photo_6a3456bf845ed5.64703567.jpg',6,NULL,'2026-06-19 00:00:00'),(14,'lis','photo_6a3459b7005d04.71674726.jpg',5,'to jest dzikie zwierze','2026-06-19 00:00:00'),(15,'mango','photo_6a351e4945a7b3.69263663.jpg',6,'jest to zdjęcie owocu !','2026-06-19 00:00:00'),(16,'sowa','photo_6a352356a15944.15174711.jpg',5,'sowa mieszka w lesie','2026-06-19 00:00:00'),(17,'ptak','photo_6a3526d4d0a4f4.40675232.jpg',5,'ptak na wodą','2026-06-19 13:24:04'),(19,'robert','photo_6a352a00634af6.73910175.jpg',4,'krytyk kulinarny fiu fiu fiu','2026-06-19 13:37:36');
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_tag`
--

DROP TABLE IF EXISTS `photo_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo_tag` (
  `photo_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`photo_id`,`tag_id`),
  KEY `IDX_8C2D8E577E9E4C8C` (`photo_id`),
  KEY `IDX_8C2D8E57BAD26311` (`tag_id`),
  CONSTRAINT `FK_8C2D8E577E9E4C8C` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_8C2D8E57BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_tag`
--

LOCK TABLES `photo_tag` WRITE;
/*!40000 ALTER TABLE `photo_tag` DISABLE KEYS */;
INSERT INTO `photo_tag` VALUES (4,3),(5,2),(6,4),(7,2),(8,3),(9,3),(10,4),(11,4),(12,2),(14,4),(15,2),(16,4),(17,4),(19,5);
/*!40000 ALTER TABLE `photo_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (2,'martwa natura'),(3,'kobiety'),(4,'natura'),(5,'faceci');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@example.com','[\"ROLE_ADMIN\"]','$2y$13$e/e6S7Aiiq47UzsSibd3Ru5lXl8fkmbASYB3WV7fWe/mcb0pnDVQO'),(2,'user1@example.com','[]','$2y$13$oeXSI753pm8IsJaAopQOjuD/kKROo3.om5Y1CA4WHSwWqhcbAWCbu'),(3,'test@example.com','[]','$2y$13$yWunBChknaog.1plI3IqCeK89zG/4tKXkgHawPs0U.l/cLK6K0iky');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-21 15:27:31
