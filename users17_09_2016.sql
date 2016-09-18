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
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (71,'b9b60e1e415a4e47dcd50c62c5e73b6b678.jpg',1,'2016-09-17 16:21:12'),(72,'c78e20bf2c5d4c8e04390662fafbe96887.jpg',1,'2016-09-17 16:21:45'),(73,'8cda81fc7ad906927144235dda5fdf15957.jpg',1,'2016-09-17 16:23:03'),(74,'a4e7ff26c998b25fe938f8aa02e2ce52404.jpg',1,'2016-09-17 16:28:04'),(75,'ccfba8fc6fa79b86b569854ef4cdbacc219.jpg',1,'2016-09-17 16:30:21'),(76,'c78e20bf2c5d4c8e04390662fafbe968793.jpg',1,'2016-09-17 16:32:50'),(77,'c78e20bf2c5d4c8e04390662fafbe968105.jpg',1,'2016-09-17 16:33:57'),(78,'d6218d56181e0c1ba7c01513b92b8e49486.jpg',1,'2016-09-17 16:38:12'),(79,'c78e20bf2c5d4c8e04390662fafbe968456.jpg',1,'2016-09-17 16:41:28'),(80,'d6218d56181e0c1ba7c01513b92b8e49876.jpg',1,'2016-09-17 16:45:06'),(81,'ccfba8fc6fa79b86b569854ef4cdbacc5.jpg',1,'2016-09-17 16:45:49'),(82,'c78e20bf2c5d4c8e04390662fafbe968177.jpg',1,'2016-09-17 16:47:01'),(83,'b9b60e1e415a4e47dcd50c62c5e73b6b172.jpg',1,'2016-09-17 16:48:53'),(84,'d6218d56181e0c1ba7c01513b92b8e49950.jpg',1,'2016-09-17 16:49:34'),(85,'c78e20bf2c5d4c8e04390662fafbe968842.jpg',1,'2016-09-17 16:51:48'),(86,'ab2b3d0393dfbc2576b90f199ac02f71120.jpg',1,'2016-09-17 17:01:25'),(87,'74d0c9e842f5198df09f2aaa2965cee2357.jpg',1,'2016-09-17 17:02:02'),(88,'ff9efab1c5c99c13d0b367997046319981.jpg',1,'2016-09-17 17:02:26'),(89,'ab2b3d0393dfbc2576b90f199ac02f71579.jpg',1,'2016-09-17 17:03:41'),(90,'32aba00fef18491b459ac1c8ebe04ffb519.jpg',1,'2016-09-17 17:51:16'),(91,'32aba00fef18491b459ac1c8ebe04ffb943.jpg',1,'2016-09-17 17:51:23'),(92,'32aba00fef18491b459ac1c8ebe04ffb695.jpg',1,'2016-09-17 17:51:26'),(93,'a4e7ff26c998b25fe938f8aa02e2ce52976.jpg',1,'2016-09-17 17:54:26'),(94,'d6218d56181e0c1ba7c01513b92b8e4988.jpg',1,'2016-09-17 18:30:53'),(95,'d6218d56181e0c1ba7c01513b92b8e4948.jpg',1,'2016-09-17 18:32:21'),(96,'32aba00fef18491b459ac1c8ebe04ffb149.jpg',1,'2016-09-17 18:36:45'),(97,'b9b60e1e415a4e47dcd50c62c5e73b6b128.jpg',1,'2016-09-17 18:42:39'),(98,'b9b60e1e415a4e47dcd50c62c5e73b6b46.jpg',1,'2016-09-17 18:42:51'),(99,'a4e7ff26c998b25fe938f8aa02e2ce52521.jpg',1,'2016-09-17 18:44:27'),(100,'a4e7ff26c998b25fe938f8aa02e2ce52415.jpg',1,'2016-09-17 18:44:35'),(101,'ccfba8fc6fa79b86b569854ef4cdbacc280.jpg',1,'2016-09-17 18:46:20'),(102,'b9b60e1e415a4e47dcd50c62c5e73b6b589.jpg',1,'2016-09-17 18:46:52'),(103,'c78e20bf2c5d4c8e04390662fafbe968485.jpg',1,'2016-09-17 18:47:29'),(104,'c78e20bf2c5d4c8e04390662fafbe968618.jpg',1,'2016-09-17 18:47:45'),(105,'d6218d56181e0c1ba7c01513b92b8e49630.jpg',1,'2016-09-17 19:05:55'),(106,'51e0824336ba7584f2274b8019706095476.jpg',1,'2016-09-17 19:07:57'),(107,'ccfba8fc6fa79b86b569854ef4cdbacc496.jpg',1,'2016-09-17 19:08:50');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=789 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (787,1,'j1Ph8OFni0','2016-09-17 18:23:57','2016-09-17 19:09:32'),(788,1,'JqAd1UmNKr','2016-09-17 19:07:36','2016-09-17 19:08:57');
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'f9eb2327784f3c18d1e84ea47a267280',1,'test','test@test.ru','ccfba8fc6fa79b86b569854ef4cdbacc280.jpg',1,'2015-05-20 16:00:00','2018-06-20 16:00:00','2016-09-09 10:41:24'),(2,'0ed610b5d2394763730ec36053749047',2,'two','two@two.ua','b9b60e1e415a4e47dcd50c62c5e73b6b589.jpg',1,'2014-02-20 15:00:00','2016-05-20 16:00:00','2016-09-16 15:05:57'),(3,'0e600c26672a3316f30be63181da7446',3,'three','three@three.ua','c78e20bf2c5d4c8e04390662fafbe968485.jpg',1,'2025-02-20 13:00:00','2025-08-20 15:00:00','2016-09-05 13:30:38'),(4,'e97412a5a29d228e81ab6ae8656cfb78',4,'for','for@for.ua','d6218d56181e0c1ba7c01513b92b8e49630.jpg',1,'2015-03-20 14:00:00','0000-00-00 00:00:00','2016-09-17 15:52:03'),(28,'1369bc0e8974f0bb2702a76bed62e19a',4,'efwef','test2@tesgggrg2.as','ccfba8fc6fa79b86b569854ef4cdbacc496.jpg',1,'2016-09-17 18:29:08','0000-00-00 00:00:00','2016-09-17 18:44:51');
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

-- Dump completed on 2016-09-17 19:19:02
