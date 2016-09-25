-- MySQL dump 10.13  Distrib 5.6.22, for Win32 (x86)
--
-- Host: localhost    Database: users
-- ------------------------------------------------------
-- Server version	5.6.22-log

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
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `parent` varchar(45) NOT NULL,
  `child` varchar(45) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES (1,'3','4'),(3,'1','2'),(5,'2','3');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `privs`
--

DROP TABLE IF EXISTS `privs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privs` (
  `priv_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `controller_name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`priv_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privs`
--

LOCK TABLES `privs` WRITE;
/*!40000 ALTER TABLE `privs` DISABLE KEYS */;
INSERT INTO `privs` VALUES (1,'CAN_REDACT_ROLES','roles','може керувати ролями'),(2,'CAN_REDACT_USERS','add_user','може додавати, переглядати список, видаляти і редагувати користувачів'),(3,'CAN_CHANGE_USER_STATUS','user_status','може переглядати список користувачів, змінювати статус користувача'),(4,'USER_PRIV','main_list','може тільки переглядати користувачів і сторінку власного профілю'),(5,'CAN_REDACT_PRIVS','privs','може керувати привілегіями');
/*!40000 ALTER TABLE `privs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privs2roles`
--

DROP TABLE IF EXISTS `privs2roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `privs2roles` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `priv_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`pr_id`),
  KEY `priv_id` (`priv_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `privs2roles_ibfk_1` FOREIGN KEY (`priv_id`) REFERENCES `privs` (`priv_id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `privs2roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privs2roles`
--

LOCK TABLES `privs2roles` WRITE;
/*!40000 ALTER TABLE `privs2roles` DISABLE KEYS */;
INSERT INTO `privs2roles` VALUES (1,1,1),(2,5,1),(3,2,2),(4,3,3),(5,4,4);
/*!40000 ALTER TABLE `privs2roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `role_id` int(5) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'root','може керувати ролями та привілегіями'),(2,'admin','може додавати, переглядати список, видаляти і редагувати користувачів'),(3,'moderator','може переглядати список користувачів, змінювати статус користувача'),(4,'user','може тільки переглядати користувачів і сторінку власного профілю');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sid` varchar(10) NOT NULL,
  `time_start` datetime NOT NULL,
  `time_last` datetime NOT NULL,
  PRIMARY KEY (`id_session`),
  UNIQUE KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=821 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `password` varchar(32) NOT NULL,
  `role_id` int(5) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_avatar` varchar(255) DEFAULT NULL,
  `user_status` int(11) NOT NULL,
  `user_date_register` datetime DEFAULT NULL,
  `user_last_active` datetime NOT NULL,
  `user_time_update` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'f9eb2327784f3c18d1e84ea47a267280',1,'test','test@test.ru','57dea1348f2aa27fbc251c3999466d360ecdd0b06e33e.png',1,'2015-05-20 16:00:00','2018-06-20 16:00:00','2016-09-18 17:15:23'),(2,'0ed610b5d2394763730ec36053749047',2,'two','two@two.ua','57de47e900593d5d85d5073d42ee0fe481bbbf8a1423c.jpg',1,'2014-02-20 15:00:00','2016-05-20 16:00:00','2016-09-18 10:53:15'),(3,'0e600c26672a3316f30be63181da7446',3,'three','three@three.ua','57de48110e9642934d974e2f112248abbd8a450a26d54.jpg',1,'2025-02-20 13:00:00','2025-08-20 15:00:00','2016-09-18 10:53:55'),(4,'e97412a5a29d228e81ab6ae8656cfb78',4,'for','for@for.ua','57de9cd9b96c87253991c822f2707ce0b4754012f92ac.jpg',1,'2015-03-20 14:00:00','0000-00-00 00:00:00','2016-09-18 16:55:45'),(28,'1369bc0e8974f0bb2702a76bed62e19a',4,'efwef','test2@tesgggrg2.a','57de49b6c687b2246d1dbfd516ad8443e61144c6dfc02.jpg',1,'2016-09-17 18:29:08','0000-00-00 00:00:00','2016-09-18 11:00:56');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `delete images` BEFORE DELETE ON `users` FOR EACH ROW DELETE FROM images WHERE user_id = OLD.user_id */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-18 17:18:02
