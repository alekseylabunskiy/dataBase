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
  CONSTRAINT `privs2roles_ibfk_1` FOREIGN KEY (`priv_id`) REFERENCES `privs` (`priv_id`) ON UPDATE CASCADE,
  CONSTRAINT `privs2roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON UPDATE CASCADE
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
-- Table structure for table `roles`
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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'root','може керувати ролями та привілегіями'),(2,'admin','може додавати, переглядати список, видаляти і редагувати користувачів'),(3,'moderator','може переглядати список користувачів, змінювати статус користувача'),(4,'user','може тільки переглядати користувачів і сторінку власного профілю');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=741 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (740,1,'hvaQzSSyWo','2016-09-12 21:24:55','2016-09-12 21:25:07');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'f9eb2327784f3c18d1e84ea47a267280',1,'test','test@test.ru','avatar.png',1,'2015-05-20 16:00:00','2018-06-20 16:00:00','2016-09-09 10:41:24'),(2,'0ed610b5d2394763730ec36053749047',2,'two','two@two.ua','avatar.png',1,'2014-02-20 15:00:00','2016-05-20 16:00:00','2016-09-12 17:30:39'),(3,'0e600c26672a3316f30be63181da7446',3,'three','three@three.ua','avatar.png',1,'2025-02-20 13:00:00','2025-08-20 15:00:00','2016-09-05 13:30:38'),(4,'e97412a5a29d228e81ab6ae8656cfb78',4,'for','for@for.ua','avatar.png',1,'2015-03-20 14:00:00','0000-00-00 00:00:00','2016-09-09 11:27:38'),(16,'45a6161897278f5cfe3c5a1beb8cddab',4,'thhthrhrhrhrh','test@test.as','avatar.png',1,'2016-09-03 10:19:36','0000-00-00 00:00:00','2016-09-05 09:57:52'),(24,'4a975452061bc7982310e2f8e4d69bc8',4,'test','test@test.as','avatar.png',1,'2016-09-05 10:07:46','0000-00-00 00:00:00','2016-09-06 15:51:58'),(25,'0e79707b428b3892a22f9359cd00d778',4,'dhhrgrre','test2@tesgggrg2.as','avatar.png',1,'2016-09-06 15:52:18','0000-00-00 00:00:00','2016-09-06 17:06:41'),(26,'e97412a5a29d228e81ab6ae8656cfb78',3,'уааацац','test2@tesgggrg2.as','avatar.png',1,'2016-09-07 09:28:47','0000-00-00 00:00:00','2016-09-08 10:30:13'),(27,'34368867ee7a302e1996ab9e75a7611b',4,'gbgfb','test2@tesgggrg2.as','avatar.png',0,'2016-09-08 11:09:11','0000-00-00 00:00:00','2016-09-12 20:54:57');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-12 21:29:46
